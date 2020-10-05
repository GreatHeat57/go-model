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

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        //\Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
		\App\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,

        
    ];
    
    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            //\App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            \App\Http\Middleware\TransformInput::class,
            \App\Http\Middleware\XSSProtection::class,
			\App\Http\Middleware\HttpsProtocol::class,
            \App\Http\Middleware\CookiesWarning::class,
            \App\Http\Middleware\HtAccessAuth::class
        ],
        
        'admin' => [
            // \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
	
			\Larapen\Admin\app\Http\Middleware\Admin::class,
            \App\Http\Middleware\XSSProtection::class,
			\App\Http\Middleware\HttpsProtocol::class,
            \App\Http\Middleware\HtAccessAuth::class
        ],
        
        'api' => [
            'throttle:150,1',
        ],

        // page speed middlewares
        'pagespeed' => [
            \RenatoMarinho\LaravelPageSpeed\Middleware\ElideAttributes::class,
            \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveComments::class,
            \RenatoMarinho\LaravelPageSpeed\Middleware\RemoveQuotes::class,
            \App\Http\Middleware\CollapseWhitespace::class,
            // \RenatoMarinho\LaravelPageSpeed\Middleware\InsertDNSPrefetch::class,
            //\RenatoMarinho\LaravelPageSpeed\Middleware\TrimUrls::class,
            // \RenatoMarinho\LaravelPageSpeed\Middleware\InlineCss::class,
        ],

        'local' => ['localize', 'localizationRedirect', 'localeSessionRedirect', 'htmlMinify'],
    ];
    
    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        'bannedUser' => \App\Http\Middleware\BannedUser::class,
        
        'localize' => \Larapen\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect' => \Larapen\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect' => \Larapen\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        
        'httpCache' => \App\Http\Middleware\HttpCache::class,
        'htmlMinify' => \App\Http\Middleware\HtmlMinify::class,
		'installChecker' => \App\Http\Middleware\InstallationChecker::class,
        'preventBackHistory' => \App\Http\Middleware\PreventBackHistory::class,
		'ajax' => \App\Http\Middleware\IsAjax::class,
		'demo' => \App\Http\Middleware\IsDemo::class,
        'adminRedirect' => \App\Http\Middleware\AdminRedirect::class,
        'htaccessauth' => \App\Http\Middleware\HtAccessAuth::class,
        'doNotCacheResponse' => \Spatie\ResponseCache\Middlewares\DoNotCacheResponse::class,
        'cacheResponse' => \App\Http\Middleware\CacheResponse::class,
        'optimizeImages' => \Spatie\LaravelImageOptimizer\Middlewares\OptimizeImages::class,
    ];
}
