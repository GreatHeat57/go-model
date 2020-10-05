<?php
/**
 * JobClass - Geolocalized Job Board Script
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.bedigit.com
 *
 * LICENSE
 * -------
 * This software is furnished under a license and may be used and copied
 * only in accordance with the terms of such license and with the inclusion
 * of the above copyright notice. If you Purchased from Codecanyon,
 * Please read the full License from here - http://codecanyon.net/licenses/standard
 */

namespace App\Http\Controllers\Traits;

use App\Models\Page;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use ChrisKonnertz\OpenGraph\OpenGraph;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use App\Helpers\Localization\Country as CountryLocalization;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use Jenssegers\Date\Date;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Str;

trait SettingsTrait
{
	public $cookieExpiration;
	public $cacheExpiration = 3600; // In seconds (e.g. 3600 for 1h)
	public $picturesLimit = 1;
	
	public $countries = null;
	
	public $paymentMethods;
	public $countPaymentMethods = 0;
	
	public $og;
	
	/**
	 * Set all the front-end settings
	 */
	public function applyFrontSettings()
	{
		// Cache Expiration Time
		$this->cacheExpiration = (int)config('settings.other.cache_expiration', $this->cacheExpiration);
		view()->share('cacheExpiration', $this->cacheExpiration);
		
		// Ads photos number
		$picturesLimit = (int)config('settings.single.pictures_limit');
		if ($picturesLimit >= 1 and $picturesLimit <= 20) {
			$this->picturesLimit = $picturesLimit;
		}
		if ($picturesLimit > 20) {
			$this->picturesLimit = 20;
		}
		view()->share('picturesLimit', $this->picturesLimit);
		
		
		// Default language for Bots
		$crawler = new CrawlerDetect();
		if ($crawler->isCrawler()) {
			// $lang = collect(config('country.lang'));
			$lang = collect(config('app.locale'));
			if ($lang->has('abbr')) {
				Config::set('lang.abbr', $lang->get('abbr'));
				Config::set('lang.locale', $lang->get('locale'));
			}
			App::setLocale(config('lang.abbr'));
		}
		
		// Set Date Locale
		if (!empty(config('lang.abbr'))) {
			Date::setLocale(config('lang.abbr'));
		}
		if (!empty(config('lang.locale'))) {
			setlocale(LC_ALL, config('lang.locale'));
		}
		
		// deadlink URL
		//fonts.googleapis.com
		//graph.facebook.com
		//apis.google.com
		//pagead2.googlesyndication.com
		//cdn.api.twitter.com
		//gstatic.com

		// DNS Prefetch meta tags
		$dnsPrefetch = [
			'//google.com',
			'//ajax.googleapis.com',
			'//www.google-analytics.com',
			'//oss.maxcdn.com',
			'https://cdn.go-models.com',
			'https://stats.go-models.com',
			'https://hi.go-models.com',
			'https://static.hotjar.com',
			'https://script.hotjar.com',
			'https://in.hotjar.com',
			'https://vc.hotjar.io',
			'https://vars.hotjar.com',
		];
		view()->share('dnsPrefetch', $dnsPrefetch);
		
		
		// SEO
		// $title = getMetaTag('title', 'home');
		// $description = getMetaTag('description', 'home');
		// $keywords = getMetaTag('keywords', 'home');

		$tags = getAllMetaTagsForPage('home');
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
		MetaTag::set('title', $title);
		MetaTag::set('description', strip_tags($description));
		MetaTag::set('keywords', $keywords);
		
		
		// Open Graph
		$this->og = new OpenGraph();
		$locale = !empty(config('lang.locale')) ? config('lang.locale') : 'en_US';
		try {
			$this->og->siteName(config('settings.app.name'))->locale($locale)->type('website')->url(url()->current());
		} catch (\Exception $e) {};
		view()->share('og', $this->og);
		
		
		// CSRF Control
		// CSRF - Some JavaScript frameworks, like Angular, do this automatically for you.
		// It is unlikely that you will need to use this value manually.
		setcookie('X-XSRF-TOKEN', csrf_token(), $this->cookieExpiration, '/', getDomain());
		
		
		// Skin selection
		if (Request::filled('skin')) {
			if (file_exists(public_path() . '/assets/css/skins/' . Request::input('skin') . '.css')) {
				config(['app.skin' => Request::input('skin')]);
			} else {
				// config(['app.skin' => config('settings.style.app_skin')]);
				config(['app.skin' => 'skin-default']);
			}
		} else {
			config(['app.skin' => config('settings.style.app_skin', 'skin-default')]);
		}
		
		// Reset session Post view counter
		if (! Str::contains(Route::currentRouteAction(), 'Post\DetailsController')) {
			if (session()->has('postIsVisited')) {
				session()->forget('postIsVisited');
			}
		}
		
		/* ** move below code to frontcontroller */
		// Pages Menu
		/*$pages = Cache::remember('pages.' . config('app.locale') . '.menu', $this->cacheExpiration, function () {
			$pages = Page::trans()->where('excluded_from_footer', '!=', 1)->where('active', '=', 1)->orderBy('lft', 'ASC')->get();
			return $pages;
		});
		view()->share('pages', $pages);*/
		
		// Get all installed plugins name
		view()->share('installedPlugins', array_keys(plugin_installed_list()));
		
		
		// Get all Countries
		// $countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
		$countries = Cache::remember('header_countries.' . config('app.locale'), $this->cacheExpiration, function () {
			$country = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));			
			return $country;
		});

		$cols = round($countries->count() / 4, 0, PHP_ROUND_HALF_EVEN);
		$cols = ($cols > 0) ? $cols : 1; // Fix array_chunk with 0
		view()->share('countryCols', $countries->chunk($cols)->all());
		

		//Get all Countries based on Contient
		// $contient = CountryLocalization::getContinent();
		$contient = Cache::remember('header_contient.' . config('app.locale'), $this->cacheExpiration, function () {
			$contient = CountryLocalization::getContinent();			
			return $contient;
		});
		foreach ($contient as $key => $cont) {
			$cols = round($cont->country->count() / 3.5, 0, PHP_ROUND_HALF_EVEN);
			$cols = ($cols > 0) ? $cols : 1;
			$contient[$key]->country = $cont->country->chunk($cols)->all();
		}
		view()->share('contient', $contient);

		 // echo "<pre>"; print_r($contient); echo "</pre>"; exit(); 

		// Get Payment Methods
		$this->paymentMethods = Cache::remember('paymentMethods.all', $this->cacheExpiration, function () {
			$paymentMethods = PaymentMethod::where(function ($query) {
				$query->whereRaw('FIND_IN_SET("' . config('country.icode') . '", LOWER(countries)) > 0')
					->orWhereNull('countries');
			})->orderBy('ordering')->get();
			
			return $paymentMethods;
		});
		
		$this->countPaymentMethods = $this->paymentMethods->count();
		view()->share('paymentMethods', $this->paymentMethods);
		view()->share('countPaymentMethods', $this->countPaymentMethods);
	}
	
	/**
	 * Check & Add the missing entries in the /.env file
	 */
	public function checkDotEnvEntries()
	{
		$isChanged = false;
		
		// Check the App Config Locale
		if (!DotenvEditor::keyExists('APP_LOCALE') || !DotenvEditor::keyExists('APP_FALLBACK_LOCALE')) {
			DotenvEditor::addEmpty();
			DotenvEditor::setKey('APP_LOCALE', config('appLang.abbr'));
			DotenvEditor::setKey('APP_FALLBACK_LOCALE', config('appLang.abbr'));
			$isChanged = true;
		}
		
		// Check Purchase Code
		if (!DotenvEditor::keyExists('PURCHASE_CODE')) {
			if (!empty(config('settings.app.purchase_code'))) {
				DotenvEditor::addEmpty();
				DotenvEditor::setKey('PURCHASE_CODE', config('settings.app.purchase_code'));
				$isChanged = true;
			}
		}
		
		if ($isChanged) {
			DotenvEditor::save();
		}
	}
}
