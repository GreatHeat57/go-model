<?php namespace Larapen\LaravelLocalization\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LaravelLocalizationRedirectFilter extends LaravelLocalizationMiddlewareBase
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// If the URL of the request is in exceptions.
		if ($this->shouldIgnore($request)) {
			return $next($request);
		}

		
		$currentLocale = app('laravellocalization')->getCurrentLocale();
		$defaultLocale = app('laravellocalization')->getDefaultLocale();
		$params = explode('/', $request->path());

		/*
		// set url language as default locale for googlesearchbots - start
		$segment = $request->segment(1);
		// check segment is set and is valid locale then set default locale
		if(isset($segment) && !app('laravellocalization')->checkLocaleInSupportedLocales($segment)){
			\App::setLocale($segment);
		}
		// set url language as default locale for googlesearchbots - end
		*/

		if (count($params) > 0) {
			$localeCode = $params[0];
			$locales = app('laravellocalization')->getSupportedLocales();
			$hideDefaultLocale = app('laravellocalization')->hideDefaultLocaleInURL();
			$redirection = false;
			
			if (!empty($locales[$localeCode])) {
				if ($localeCode === $defaultLocale && $hideDefaultLocale) {
					// Don't remove the language code from the sitemaps generation URL
					if (!ends_with($request->url(), '.xml')) {
						$redirection = app('laravellocalization')->getNonLocalizedURL();
					}
				}
			} else if ($currentLocale !== $defaultLocale || !$hideDefaultLocale) {
				// If the current url does not contain any locale
				// The system redirect the user to the very same url "localized"
				// we use the current locale to redirect him
				// $redirection = app('laravellocalization')->getLocalizedURL();
				$redirection = app('laravellocalization')->getLocalizedURL(session('locale'), $request->fullUrl());
			}

			
			if ($redirection && $redirection != url()->current()) {
				// Save any flashed data for redirect
				app('session')->reflash();
				
				return new RedirectResponse($redirection, 301, ['Vary' => 'Accept-Language']);
			}
		}
		
		return $next($request);
	}
}
