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

namespace App\Http\Controllers\Search;

use App\Helpers\Search;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Models\Post;

class CompanyController extends BaseController
{
	private $perPage = 10;
	public $isCompanySearch = true;
	public $company;
	
	public function __construct(Request $request)
	{
		parent::__construct($request);
		
		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
	}
	
	/**
	 * Listing of Companies
	 *
	 * @return $this
	 */
	public function index()
	{
		// Get Companies List
		$companies = Company::whereHas('posts', function($query) {
			$query->currentCountry();
		})->withCount(['posts' => function($query) {
			$query->currentCountry();
		}]);
		
		// Apply search filter
		if (RequestFacade::filled('q')) {
			$keywords = rawurldecode(RequestFacade::input('q'));
			$companies = $companies->where('name', 'LIKE', '%' . $keywords . '%')->whereOr('description', 'LIKE', '%' . $keywords . '%');
		}
		
		// Get Companies List with pagination
		$companies = $companies->orderByDesc('id')->paginate($this->perPage);
		
		// Meta Tags
		MetaTag::set('title', t('Companies List'));
		MetaTag::set('description', t('Companies List - :app_name', ['app_name' => config('settings.app.name')]));
		
		return view('search.company.index')->with('companies', $companies);
	}
	
	/**
	 * Show a Company profiles (with its Jobs ads)
	 *
	 * @param $countryCode
	 * @param null $companyId
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
    public function profile($countryCode, $companyId = null)
    {
		// Check multi-countries site parameters
		if (!config('larapen.core.multiCountriesWebsite')) {
			$companyId = $countryCode;
		}
		
		// Get Company
		$this->company = Company::findOrFail($companyId);
	
		// Get the Company's Jobs
		//$data = $this->jobs($this->company->id);
		$data = Post::myPostsByCompanyId($this->company->id, $this->perPage, null);

		// Share the Company's info with the view
		$company = $this->company;
	
		return view('search.company.profile')->with('data', $data)->with('company', $company)->with('paginator', $data);
    }
	
	/**
	 * Get the Company Jobs ads
	 *
	 * @param $companyId
	 * @return array
	 */
	private function jobs($companyId)
	{
		view()->share('isCompanySearch', $this->isCompanySearch);
		
		// Search
		$search = new Search();
		if (auth()->check() && auth()->user()->user_type_id == 3) {
			$data = $search->setCompany($companyId)->setRequestFilters()->setProfile(auth()->user())->fetch();
		} else {
			$data = $search->setCompany($companyId)->setRequestFilters()->fetch();
		}
		
		// Get Titles
		$bcTab = $this->getBreadcrumb();
		$htmlTitle = $this->getHtmlTitle();
		view()->share('bcTab', $bcTab);
		view()->share('htmlTitle', $htmlTitle);
		
		// Meta Tags
		$title = $this->getTitle();
		MetaTag::set('title', $title);
		MetaTag::set('description', $title);
		
		// Translation vars
		view()->share('uriPathCompanyId', $companyId);
		
		return $data;
	}
}
