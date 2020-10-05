<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
 */

/*
|--------------------------------------------------------------------------
| Migration
|--------------------------------------------------------------------------
|
| The update db routes
|
 */

Route::group(['middleware' => ['web', 'local'], 'namespace' => 'App\Http\Controllers'], function ($router) {
	
	$router->pattern('langcode', 'at|li|ch|de|gb');
	Route::get('{langcode}/login', 'PageRedirectController@loginPageRedirection');

	Route::get('{langcode?}/tour/partner-bewerbung', 'PageRedirectController@registerPageRedirection');
	Route::get('{langcode?}/tour/model-bewerbung', 'PageRedirectController@registerPageRedirection');
	Route::get('tour/apply-as-professional', 'PageRedirectController@registerPageRedirection');
	Route::get('tour/apply-now', 'PageRedirectController@registerPageRedirection');

	// redirect all model category routes to model category page
	/*Route::group(array(
		'where' => array('slug' => '^((?!become-a-baby-model|jetzt-babymodel-werden|become-a-child-model|kindermodel-werden|become-a-model|jetzt-model-werden|senior-models|50plus-model-werden|plus-size-model|plus-size-model-werden|become-a-fitness-model|fitnessmodel-werden).)*$')
		), function ($router) {
		Route::get('baby-models/{slug?}', 'PageRedirectController@findMatchCategory');
		Route::get('{langcode}/baby-models/{slug?}', 'PageRedirectController@findMatchCategory');

		Route::get('kindermodels/{slug?}', 'PageRedirectController@findMatchCategory');
		Route::get('{langcode}/kindermodels/{slug?}', 'PageRedirectController@findMatchCategory');

		// Route::get('child-models/{slug?}', 'PageRedirectController@findMatchCategory');
		// Route::get('{langcode}/child-models/{slug?}', 'PageRedirectController@findMatchCategory');

		Route::get('models/{slug?}', 'PageRedirectController@findMatchCategory');
		Route::get('{langcode}/models/{slug?}', 'PageRedirectController@findMatchCategory');

		Route::get('50plus/{slug?}', 'PageRedirectController@findMatchCategory');
		Route::get('{langcode}/50plus/{slug?}', 'PageRedirectController@findMatchCategory');

		Route::get('plus-size/{slug?}', 'PageRedirectController@findMatchCategory');
		Route::get('{langcode}/plus-size/{slug?}', 'PageRedirectController@findMatchCategory');

		Route::get('fitnessmodel/{slug?}', 'PageRedirectController@findMatchCategory');
		Route::get('{langcode}/fitnessmodel/{slug?}', 'PageRedirectController@findMatchCategory');
	});*/

	/*managed by htaccess redirection*/
	/*
	Route::get('{langcode?}/ueber-uns/kontakt', function(){
		return redirect(config('app.locale').'/'.trans('routes.contact'));
	});

	Route::get('ueber-uns/kontakt', function(){
		return redirect(config('app.locale').'/'.trans('routes.contact'));
	});

	Route::get('{langcode?}/about-us/contact', function(){
		return redirect(config('app.locale').'/'.trans('routes.contact'));
	});*/

	/* About us page redirections */
	// routes call on same url and create loop so comment these route
	// Route::get('{langcode}/ueber-uns', 'PageRedirectController@aboutUsPageRedirection');

	Route::get('ueber-uns/{slug}', 'PageRedirectController@aboutUsRedirection');
	Route::get('about-us/{slug}', 'PageRedirectController@aboutUsRedirection');
	Route::get('{langcode}/ueber-uns/{slug}', 'PageRedirectController@aboutUsRedirection');
	Route::get('{langcode}/about-us/{slug}', 'PageRedirectController@aboutUsRedirection');

	Route::get('{langcode?}/model-dashboard', 'PageRedirectController@modelDashboardRedirection');
	
	/* About us page redirections - End */

	// Route::get('tour', 'PageRedirectController@redirectPremium');
	// Route::get('{langcode?}/tour', 'PageRedirectController@redirectPremium');

	/*managed by htaccess redirection*/
	/*Route::get('blog', function(){
		return redirect(config('app.locale').'/'.trans('routes.magazine'));
	});

	Route::get('{langcode?}/blog', function(){
		return redirect(config('app.locale').'/'.trans('routes.magazine'));
	});*/

	Route::get('partner/{slug}', 'PageRedirectController@aboutUsRedirection');
	Route::get('{langcode?}/partner/{slug}', 'PageRedirectController@aboutUsRedirection');

	/*Route::get('partner-bereich', function(){
		return redirect(config('app.locale').'/'.trans('routes.partner-dashboard'));
	});

	Route::get('{langcode?}/partner-bereich', function(){
		return redirect(config('app.locale').'/'.trans('routes.partner-dashboard'));
	});*/

	Route::get('{langcode?}/jobliste-partner', 'PageRedirectController@jobPageRedirection');
	Route::get('{langcode?}/model-jobs', 'PageRedirectController@jobPageRedirection');


	// Route::get('{langcode?}/profis', 'PageRedirectController@partnerlistRedirection');
	Route::get('{langcode?}/liste-der-profis', 'PageRedirectController@partnerlistRedirection');
	Route::get('{langcode?}/profi-liste', 'PageRedirectController@partnerlistRedirection');

	// Route::get('list-of-partners', function(){
	// 	return redirect(trans('routes.partner-list'));
	// });

	// $router->pattern('homeredirect', 'upgrade-package|zur-kasse|einkaufswagen|model-subscribers|danke|transaktion|shop|suchergebnisse-seite|thank-you|thank-you-for-premium|premium-bankeinzahlung|premium|woo_oppcw|danke-fuer-premium|go-friend');
	// Route::get('{langcode?}/{homeredirect}', function(){
	// 	return redirect(config('app.locale').'/');
	// });

	
	// $router->pattern('thanksredirect','thank-you-for-premium|recission|thank-premium-bank|thank-premium-bank-2|woo_oppcw|thank-premium-bank-2');
	// Route::get('{thanksredirect}', function(){
	// 	return redirect(config('app.locale').'/');
	// });

	// Route::get('partner', function(){
	// 	return redirect(trans('routes.benefits'));
	// });


	// Route::get('{langcode?}/partner', 'PageRedirectController@benefitsRedirection');
	// Route::get('{langcode?}/auftraggeber', 'PageRedirectController@benefitsRedirection');


	// Route::get('model-portal', function(){
	// 	return redirect(trans('routes.models-category'));
	// });


	$router->pattern('modelcat', 'willkommen-bei-go-models|willkommen-bei-go-models-2');
	Route::get('{langcode?}/{modelcat}', 'PageRedirectController@modelCategoryRedirection');

	Route::get('sedcard-generator', 'PageRedirectController@sedcardRedirection');
	Route::get('{langcode?}/sedcard-generator', 'PageRedirectController@sedcardRedirection');

	Route::get('models-liste', 'PageRedirectController@modellistRedirection');
	Route::get('{langcode?}/models-liste', 'PageRedirectController@modellistRedirection');
	
	// $router->pattern('model_list', 'models-liste-2|models-list-2');
	// Route::get('{model_list}', function(){
	// 	return redirect(trans('routes.model-list'));
	// });

	
	// Route::get('joblist-partner', function(){
	// 	return redirect(trans('routes.search'));
	// });
	
	// Route::get('category/{slug}', 'PageRedirectController@blogCategoryRedirection');
	// Route::get('{langcode?}/category/{slug}', 'PageRedirectController@blogCategoryRedirectionV2');
	// Route::get('category/{slug}', function($slug){
	// 	return redirect(trans('routes.blogcategory').'/'.$slug);
	// }); 

	// tag go-models.com url to redirect  
	// Route::get('tag/{slug}', 'PageRedirectController@blogTagRedirection');
	// Route::get('{langcode}/tag/{slug}', 'PageRedirectController@blogTagRedirectionV2');
	// Route::get('tag/{slug}', function($slug){				
	// 	$p_attr = ['countryCode' => config('app.locale') , 'slug' =>  $slug];
	// 	return redirect(lurl(trans('routes.v-magazine-tag', $p_attr), $p_attr));
	// });	
	// tag go-models.com url to redirect 
	// Route::get('{langcode}/tag/{slug}', function($countryCode, $slug){		
	// 	$langcode = array('at','li','ch','de');		
	// 	if(in_array(strtolower($countryCode), $langcode)){
	// 		App::setLocale('de');
	// 	}else{
	// 		App::setLocale('en');
	// 	}		
	// 	$p_attr = ['countryCode' => config('app.locale') , 'slug' =>  $slug];
	// 	return redirect(lurl(trans('routes.v-magazine-tag', $p_attr), $p_attr));
	// });
});


Route::group(['middleware' => ['web', 'local'], 'namespace' => 'App\Http\Controllers'], function ($router) {
	Route::get('contract', 'Auth\ContractController@showProfileForm');
	Route::get('{countryCode}/contract', 'Auth\ContractController@showProfileForm');
	Route::get('contract/createPaymentIntent', 'Auth\ContractController@createPaymentIntent')->name('contract-create-payment-intent');
	Route::get('upgrade-contract', 'Auth\ContractController@getPremiumPackages');
});


// Route::get('/migratedb', function () {

// 	$migrate = \Artisan::call('migrate', array('--path' => '../app/database/migrations', '--force' => true));
// 	print_r($migrate);
// 	echo " Migration done";
// });

/*
|--------------------------------------------------------------------------
| Upgrading
|--------------------------------------------------------------------------
|
| The upgrading process routes
|
 */
// Route::group(['middleware' => ['web'], 'namespace' => 'App\Http\Controllers'], function () {
// 	Route::get('upgrade', 'UpgradeController@version');
// });

/*
|--------------------------------------------------------------------------
| Installation
|--------------------------------------------------------------------------
|
| The installation process routes
|
 */

// Route::group([
// 	'middleware' => ['web', 'installChecker'],
// 	'namespace' => 'App\Http\Controllers',
// ], function () {
// 	Route::get('install', 'InstallController@starting');
// 	Route::get('install/site_info', 'InstallController@siteInfo');
// 	Route::post('install/site_info', 'InstallController@siteInfo');
// 	Route::get('install/system_compatibility', 'InstallController@systemCompatibility');
// 	Route::get('install/database', 'InstallController@database');
// 	Route::post('install/database', 'InstallController@database');
// 	Route::get('install/database_import', 'InstallController@databaseImport');
// 	Route::get('install/cron_jobs', 'InstallController@cronJobs');
// 	Route::get('install/finish', 'InstallController@finish');
// });

/*
|--------------------------------------------------------------------------
| Back-end
|--------------------------------------------------------------------------
|
| The admin panel routes
|
 */
// 'installChecker',

Route::group([
	'middleware' => ['admin', 'bannedUser', 'preventBackHistory'],
	'prefix' => config('larapen.admin.route_prefix', 'admin'),
	'namespace' => 'App\Http\Controllers\Admin',
], function () {
	// CRUD
	CRUD::resource('advertising', 'AdvertisingController');
	CRUD::resource('blacklist', 'BlacklistController');
	CRUD::resource('category', 'CategoryController');
	CRUD::resource('category/{catId}/sub_category', 'SubCategoryController');
	CRUD::resource('city', 'CityController');
	CRUD::resource('company', 'CompanyController');
	CRUD::resource('country', 'CountryController');
	CRUD::resource('country/{countryCode}/city', 'CityController');
	CRUD::resource('country/{countryCode}/loc_admin1', 'SubAdmin1Controller');
	CRUD::resource('currency', 'CurrencyController');
	CRUD::resource('gender', 'GenderController');
	CRUD::resource('homepage_section', 'HomeSectionController');
	CRUD::resource('loc_admin1/{admin1Code}/city', 'CityController');
	CRUD::resource('loc_admin1/{admin1Code}/loc_admin2', 'SubAdmin2Controller');
	CRUD::resource('loc_admin2/{admin2Code}/city', 'CityController');
	CRUD::resource('meta_tag', 'MetaTagController');
	CRUD::resource('package', 'PackageController');
	CRUD::resource('branch', 'BranchController');
	CRUD::resource('model-categories', 'ModelCategoryController');
	CRUD::resource('page', 'PageController');
	CRUD::resource('payment', 'PaymentController');
	CRUD::resource('payment_method', 'PaymentMethodController');
	CRUD::resource('picture', 'PictureController');
	CRUD::resource('post', 'PostController');
	CRUD::resource('p_type', 'PostTypeController');
	CRUD::resource('report_type', 'ReportTypeController');
	CRUD::resource('salary_type', 'SalaryTypeController');
	CRUD::resource('time_zone', 'TimeZoneController');
	CRUD::resource('user', 'UserController');

	// Blogs

	CRUD::resource('blog-categories', 'BlogCategoryController');
	CRUD::resource('blog-entries', 'BlogEntryController');
	CRUD::resource('blog-tags', 'BlogTagController');

	// Others
	Route::get('account', 'UserController@account');
	Route::post('ajax/{table}/{field}', 'AjaxController@saveAjaxRequest');
	Route::get('clear_cache', 'CacheController@clear');
	Route::get('test_cron', 'TestCronController@run');

	// Maintenance Mode
	Route::post('maintenance/down', 'MaintenanceController@down');
	Route::get('maintenance/up', 'MaintenanceController@up');

	// Re-send Email or Phone verification message
	Route::get('verify/user/{id}/resend/email', 'UserController@reSendVerificationEmail');
	Route::get('verify/user/{id}/resend/sms', 'UserController@reSendVerificationSms');
	Route::get('verify/post/{id}/resend/email', 'PostController@reSendVerificationEmail');
	Route::get('verify/post/{id}/resend/sms', 'PostController@reSendVerificationSms');

	// Plugins
	Route::get('plugin', 'PluginController@index');
	Route::get('plugin/{plugin}/install', 'PluginController@install');
	Route::get('plugin/{plugin}/uninstall', 'PluginController@uninstall');
	Route::get('plugin/{plugin}/delete', 'PluginController@delete');

	//Route::get('/clear-response-cache', 'HomeSectionController@clearCache');
});

/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The not translated front-end routes
|
 */
// installChecker
Route::group([
	'middleware' => ['web'],
	'namespace' => 'App\Http\Controllers',
], function ($router) {
	// AJAX
	Route::group(['prefix' => 'ajax'], function ($router) {
		Route::get('countries/{countryCode}/admins/{adminType}', 'Ajax\LocationController@getAdmins');
		Route::get('countries/{countryCode}/admins/{adminType}/{adminCode}/cities', 'Ajax\LocationController@getCities');
		Route::get('countries/{countryCode}/cities/{id}', 'Ajax\LocationController@getSelectedCity');
		Route::post('countries/{countryCode}/cities/autocomplete', 'Ajax\LocationController@searchedCities');
		Route::post('countries/{countryCode}/admin1/cities', 'Ajax\LocationController@getAdmin1WithCities');
		Route::post('category/sub-categories', 'Ajax\CategoryController@getSubCategories');
		Route::post('save/post', 'Ajax\PostController@savePost');
		Route::post('save/search', 'Ajax\PostController@saveSearch');
		Route::post('post/phone', 'Ajax\PostController@getPhone');

		Route::get('citiesByCode/{countryCode}', 'Ajax\LocationController@getCodeCities');
		Route::get('citiesByCode/{countryCode}/{citybyname}', 'Ajax\LocationController@getCodeCities');

		Route::get('countries/{countryCode}/cities', 'Ajax\LocationController@getCityByCountry');

		// New units controller to get unitest based on country code and return json object
		Route::post('getAjaxUnites', 'Ajax\UnitsController@getAjaxUnits');

		// Image upload from simeditor
		Route::post('smiditor/uploadSimditorImg', 'PageController@pageImageUploads');

		// Route::post('contract/webhook', 'Ajax\ContractController@webhook');

	});

	// SEO
	Route::get('sitemaps.xml', 'SitemapsController@index');

	// Impersonate (As admin user, login as an another user)
	Route::group(['middleware' => 'auth'], function ($router) {
		Route::impersonate();
	});

});

//add webhook to prevent htaccess
Route::group([
	'namespace' => 'App\Http\Controllers',
], function ($router) {
	Route::post('ajax/contract/webhook', 'Ajax\ContractController@webhook');
});

/*
|--------------------------------------------------------------------------
| Front-end
|--------------------------------------------------------------------------
|
| The translated front-end routes
|
 */
Route::group([
	'prefix' => LaravelLocalization::setLocale(),
	'middleware' => ['local','web'],
	'namespace' => 'App\Http\Controllers',
], function ($router) {
	
	Route::get('sitemaps/generatexml', 'SitemapsController@generateXml');
	Route::get('sitemaps/xmlCron', 'SitemapsController@xmlCron');
	Route::get('maxmind/updatemaxminddb', 'HomeController@updatemaxminddb');
	

	//conaversation unread massge details send notification via email
	Route::get('messagesnotification', 'Account\ConversationsController@sendMessagesNotification');
	

	Route::group(['middleware' => ['web', 'adminRedirect']], function ($router) {
		// HOMEPAGE
		
		//flash messages render on ajax request
		Route::get('/ajax-flash-message', 'HomeController@ajaxFlashMessage')->name('ajaxFlashMessage');

		
		Route::group(['middleware' => ['pagespeed']], function ($router) {
			Route::get('/country', 'HomeController@home')->name('home'); //Route::get('/', 'HomeController@index');
			Route::get('{locale}/country', 'HomeController@home')->name('home');
			// get header country by ajax call
			// Route::get('/header-ajax-country', 'HomeController@getHeaderCountry')->name('header-ajax-country');
			Route::get('/header-ajax-country', 'PageRedirectController@getHeaderCountry')->name('header-ajax-country');
			// Route::get('/header-ajax-country-list', 'HomeController@getHeaderCountryListPopup')->name('header-ajax-country-list');
		});

		//only home page is minify using pagespeed middelware
		Route::group(['middleware' => ['httpCache:yes', 'cacheResponse:864000', 'pagespeed']], function ($router) {
			Route::get('/', 'HomeController@home')->name('home'); //Route::get('/', 'HomeController@index');
		});


		Route::group(['middleware' => ['httpCache:yes', 'cacheResponse:864000']], function ($router) {
			
			Route::get('/header-ajax-country-list', 'HomeController@getHeaderCountryListPopup')->name('header-ajax-country-list');
			// Route::get('/', 'HomeController@home')->name('home'); //Route::get('/', 'HomeController@index');
			Route::get('/homepg', 'HomeController@index'); //Route::get('/', 'HomeController@index');
			Route::get('/home-ajax-content', 'HomeController@home')->name('home-ajax-content');
			Route::get(LaravelLocalization::transRoute('routes.countries'), 'CountriesController@index');


			

			// testing route to show demo table for shoe and dress unit measurement in Germany, UK, US
			Route::post('/shoe-size-units', 'HomeController@getShoesSizeUnitTest');
			Route::post('/dress-size-units', 'HomeController@getDressSizeUnitTest');
			// testing route to show demo table for shoe and dress unit measurement in Germany, UK, US -End

			// Post's Details for guest
			Route::get(LaravelLocalization::transRoute('routes.share-post'), 'Post\DetailsController@sharePostDetail');

			// Profile Picture Croping
			Route::post('cropProfileImage', 'HomeController@cropProfileImage');
			// get term-conditions popup view in ajax call
			Route::post('get-term-ajax', 'PageController@getTermsAjax');

			//get user restricton popup
			Route::get('get-restriction-popup', 'HomeController@getRestrictPopup');
			Route::get('get-go-restriction-popup', 'HomeController@getGoRestrictPopup');
		});

		// AUTH
		Route::group(['middleware' => ['guest', 'preventBackHistory', 'adminRedirect']], function () {
			// Registration Routes...
			Route::get(LaravelLocalization::transRoute('routes.register'), 'Auth\RegisterController@showRegistrationForm');
			Route::post(LaravelLocalization::transRoute('routes.register'), 'Auth\RegisterController@register');
			Route::get(LaravelLocalization::transRoute('routes.registerData') . '/{slug}', 'Auth\RegisterController@registerDataForm');
			Route::post(LaravelLocalization::transRoute('routes.registerData') . '/{slug}', 'Auth\RegisterController@registerData');
			Route::get(LaravelLocalization::transRoute('routes.registerPhoto') . '/{slug}', 'Auth\RegisterController@registerPhotoForm');
			Route::post(LaravelLocalization::transRoute('routes.registerPhoto') . '/{slug}', 'Auth\RegisterController@registerPhoto');
			// Route::get('register/finish/{slug}', 'Auth\RegisterController@finish');

			Route::get(LaravelLocalization::transRoute('routes.registerFinish') . '/{slug}', 'Auth\RegisterController@finish');
			Route::post('updateProfileInfo', 'Auth\RegisterController@updateProfileInfo')->name('updateProfileInfo');
			Route::post('saveUserPhoneAvailable', 'Auth\RegisterController@saveUserPhoneAvailable')->name('saveUserPhoneAvailable');	

			//register popup form open
			Route::get(LaravelLocalization::transRoute('routes.register-from'), 'Auth\RegisterController@registerFrom');

			// Authentication Routes...
			Route::get(LaravelLocalization::transRoute('routes.login'), 'Auth\LoginController@showLoginForm');
			Route::post(LaravelLocalization::transRoute('routes.login'), 'Auth\LoginController@login');

			// Forgot Password Routes...
			// Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
			Route::get(LaravelLocalization::transRoute('routes.password-reset'), 'Auth\ForgotPasswordController@showLinkRequestForm');
			Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

			// Reset Password using Token
			Route::get('password/token', 'Auth\ForgotPasswordController@showTokenRequestForm');
			Route::post('password/token', 'Auth\ForgotPasswordController@sendResetToken');

			// Reset Password using Link (Core Routes...)
			Route::get(LaravelLocalization::transRoute('routes.t-password-reset'), 'Auth\ResetPasswordController@showResetForm');
			Route::post(LaravelLocalization::transRoute('routes.password-reset'), 'Auth\ResetPasswordController@reset');

			// Social Authentication
			Route::get('auth/facebook', 'Auth\SocialController@redirectToProvider');
			Route::get('auth/facebook/callback', 'Auth\SocialController@handleProviderCallback');
			Route::get('auth/google', 'Auth\SocialController@redirectToProvider');
			Route::get('auth/google/callback', 'Auth\SocialController@handleProviderCallback');
			Route::get('auth/twitter', 'Auth\SocialController@redirectToProvider');
			Route::get('auth/twitter/callback', 'Auth\SocialController@handleProviderCallback');

			Route::get(LaravelLocalization::transRoute('routes.socialRedirect') . '/{slug}', 'Auth\RegisterController@socialRedirect');	

			// Contract link
			// Route::get('contract', 'Auth\ContractController@showProfileForm');
			// Route::get('{country_code}/contract', 'Auth\ContractController@showProfileForm');
			Route::post('contract', 'Auth\ContractController@makeContract');
			Route::post('contract/profileUpdate', 'Auth\ContractController@profileUpdate');
			Route::get('contract/{tmpToken}/packages', 'Auth\ContractController@showPackagesForm');
			Route::post('contract/{tmpToken}/packages', 'Auth\ContractController@postPackages');
			Route::post('contract/{tmpToken}/packagesajax', 'Auth\ContractController@postPackagesAjax');
			Route::get('contract/{tmpToken}/payPackages', 'Auth\ContractController@payPackages');
			// Route::get('contract/{tmpToken}/finish', 'Auth\ContractController@finish');
			Route::get('contract/{tmpToken}/{postId}/finish', 'Auth\ContractController@finish');
			Route::post('contract/date_update', 'Auth\ContractController@updateConratctDate')->name('contract-date-update');
			Route::post('makeContractForFreeModel', 'Auth\ContractController@makeContractForFreeModel')->name('contract-for-free-model');

			// Payment Gateway Success & Cancel
			Route::get('contract/{tmpToken}/payment/success', 'Auth\ContractController@paymentConfirmation');
			Route::get('contract/{tmpToken}/payment/cancel', 'Auth\ContractController@paymentCancel');
			Route::get('contract/{tmpToken}/payment/check', 'Auth\ContractController@paymentCheck');

			Route::get('contract/{id}/payment/success', 'Auth\ContractController@paymentConfirmation');
			Route::get('contract/{id}/payment/cancel', 'Auth\ContractController@paymentCancel');

			Route::get('contract/update-profile-popup/{userId}', 'Auth\ContractController@updateProflePopup');
			// registration and contract page wise api call in crm.
			Route::post('funnelApiCallAjax', 'Auth\RegisterController@funnelApiCallAjax');

			//validate the coupon code
			
			Route::post('contract/{tmpToken}/packages/validatecoupon', 'Auth\ContractController@postValidateCoupon');
			Route::get('contract/packages/finish', 'Auth\ContractController@freeContractFinishPage');

			Route::get(LaravelLocalization::transRoute('routes.terms-conditions-model'), 'PageController@getTerms')->name('terms-conditions-model');
			Route::get(LaravelLocalization::transRoute('routes.terms-conditions-client'), 'PageController@getTerms')->name('terms-conditions-client');

			// clear cache
			// Route::get('/clear-response-cache', 'HomeController@clearCache');
		});
		
		
		// Email Address or Phone Number verification
		$router->pattern('field', 'email|phone');
		Route::get('verify/user/{id}/resend/email', 'Auth\RegisterController@reSendVerificationEmail');
		Route::get('verify/user/{id}/resend/sms', 'Auth\RegisterController@reSendVerificationSms');
		Route::get('verify/user/{field}/{token?}', 'Auth\RegisterController@verification');
		Route::post('verify/user/{field}/{token?}', 'Auth\RegisterController@verification');

		// User Logout
		Route::get(LaravelLocalization::transRoute('routes.logout'), 'Auth\LoginController@logout');

		// POSTS
		Route::group(['namespace' => 'Post'], function ($router) {
			$router->pattern('id', '[0-9]+');
			// $router->pattern('slug', '.*');
			$router->pattern('slug', '^(?=.*)((?!\/).)*$');

			Route::get(LaravelLocalization::transRoute('routes.post-create'), 'CreateController@getForm');
			Route::post(LaravelLocalization::transRoute('routes.post-create'), 'CreateController@postForm');
			// Route::post('posts/create', 'CreateController@postForm');
			Route::put('posts/create/{tmpToken}', 'CreateController@postForm');
			Route::get('posts/create/{tmpToken}/packages', 'PackageController@getForm');
			Route::post('posts/create/{tmpToken}/packages', 'PackageController@postForm');
			Route::get('posts/create/{tmpToken}/finish', 'CreateController@finish');
			Route::get('posts/package/info/{id}', 'PackageController@getShowPackageInfo');

			// Payment Gateway Success & Cancel
			Route::get('posts/create/{tmpToken}/payment/success', 'PackageController@paymentConfirmation');
			Route::get('posts/create/{tmpToken}/payment/cancel', 'PackageController@paymentCancel');

			// Email Address or Phone Number verification
			$router->pattern('field', 'email|phone');
			Route::get('verify/post/{id}/resend/email', 'CreateController@reSendVerificationEmail');
			Route::get('verify/post/{id}/resend/sms', 'CreateController@reSendVerificationSms');
			Route::get('verify/post/{field}/{token?}', 'CreateController@verification');
			Route::post('verify/post/{field}/{token?}', 'CreateController@verification');

			Route::group(['middleware' => 'auth'], function ($router) {
				$router->pattern('id', '[0-9]+');

				//Route::get('posts/{id}/edit', 'EditController@getForm');
				Route::get(LaravelLocalization::transRoute('routes.post-edit'), 'EditController@getForm');

				Route::put(LaravelLocalization::transRoute('routes.post-edit'), 'EditController@postForm');
				Route::get('posts/{id}/packages', 'PackageController@getForm');
				Route::post('posts/{id}/packages', 'PackageController@postForm');

				// Payment Gateway Success & Cancel
				Route::get('posts/{id}/payment/success', 'PackageController@paymentConfirmation');
				Route::get('posts/{id}/payment/cancel', 'PackageController@paymentCancel');

				// Contact Job's Author
				Route::post('posts/{id}/contact', 'DetailsController@sendMessage');

				// Send report abuse
				Route::get('posts/{id}/report', 'ReportController@showReportForm');
				Route::post('posts/{id}/report', 'ReportController@sendReport');

				// Post's Details
				Route::get(LaravelLocalization::transRoute('routes.post'), 'DetailsController@index');
			});

		});
		Route::post('send-by-email', 'Search\SearchController@sendByEmail');

		// ACCOUNT
		Route::group(['middleware' => ['auth', 'bannedUser', 'preventBackHistory', 'adminRedirect'], 'namespace' => 'Account'], function ($router) {
			$router->pattern('id', '[0-9]+');

			

			// Users
			Route::get(LaravelLocalization::transRoute('routes.model-dashboard'), 'EditController@dashboard');
			Route::get(LaravelLocalization::transRoute('routes.model-academy'), 'EditController@modelAcademy');
			Route::get(LaravelLocalization::transRoute('routes.my-data'), 'EditController@index')->name('my-data');

			// Route::get('account/close', 'CloseController@index');
			Route::group(['middleware' => 'impersonate.protect'], function () {
				Route::post('account/close', 'CloseController@submit');
			});

			// Profile
			Route::get(LaravelLocalization::transRoute('routes.profile-edit'), 'EditController@profile');
				
			Route::get('account/profile/resume_delete', 'EditController@resume_delete');

			Route::get('account/profile/show-logo/{type}', 'EditController@showProfileLogo')->name('show-logo');
			Route::get('account/profile/delete-logo', 'EditController@deleteProfileLogo')->name('delete-logo');
			Route::get('account/profile/delete-cover', 'EditController@deleteProfileCover')->name('delete-cover');
			Route::post('account/profile/update', 'EditController@updateProfile');
			Route::post('account/save/partner', 'EditController@addFavouritePartner');

			Route::get('account/user/{id}', 'EditController@userView');
			// Route::get('model-public-profile/{id}', 'EditController@userView')->name('model-public-profile');
			Route::get(LaravelLocalization::transRoute('routes.model-portfolio'), 'EditController@portfolio')->name('model-portfolio');
			Route::get('portfolio-popup/{id}', 'EditController@portfolioGallery')->name('img-zoom-popup');
			Route::get('model-sedcard/{id}', 'EditController@sedcard')->name('model-sedcard');
			Route::get('account/invtresp/{status}/{id}', 'ConversationsController@approve');

			Route::get(LaravelLocalization::transRoute('routes.system-settings'), 'EditController@loadSystemSettings')->name('system-settings');
			Route::post('system-settings/update', 'EditController@updateSystemSettings');
			Route::get(LaravelLocalization::transRoute('routes.work-settings'), 'EditController@loadWorkSettings');
			Route::post(LaravelLocalization::transRoute('routes.work-settings-edit'), 'EditController@updateWorkSettings');
			// Route::post('work-settings/update', 'EditController@updateWorkSettings');

			
			// for favorite or unfavorite
			Route::get('account/favorite/{id}', 'EditController@favorite');
			Route::post('account/invitation', 'ConversationsController@invitation');

			// profile-education
			Route::post('account/profile/education', 'EditController@postEducation');
			Route::get('account/profile/education/create', 'EditController@createEducation')->name('add-education-popup');
			Route::get('account/profile/education/{id}/edit', 'EditController@editEducation');
			Route::get('account/profile/education/{id}/delete', 'EditController@deleteEducation');

			// profile-experience
			Route::post('account/profile/experience', 'EditController@postExperience');
			Route::get('account/profile/experience/create', 'EditController@createExperience')->name('add-experience-popup');
			Route::get('account/profile/experience/{id}/edit', 'EditController@editExperience');
			Route::get('account/profile/experience/{id}/delete', 'EditController@deleteExperience');

			// profile-talent
			Route::post('account/profile/talent', 'EditController@postTalent');
			Route::get('account/profile/talent/create', 'EditController@createTalent');
			Route::get('account/profile/talent/{id}/edit', 'EditController@editTalent');
			Route::get('account/profile/talent/{id}/delete', 'EditController@deleteTalent');

			// profile-reference
			Route::post('account/profile/reference', 'EditController@postReference');
			Route::get('account/profile/reference/create', 'EditController@createReference')->name('add-reference-popup');
			Route::get('account/profile/reference/{id}/edit', 'EditController@editReference');
			Route::get('account/profile/reference/{id}/delete', 'EditController@deleteReference');

			// profile-language
			Route::post('account/profile/language', 'EditController@postLanguage');
			Route::get('account/profile/language/create', 'EditController@createLanguage')->name('add-language-popup');
			Route::get('account/profile/language/{id}/edit', 'EditController@editLanguage');
			Route::get('account/profile/language/{id}/delete', 'EditController@deleteLanguage');

			// Companies
			Route::get(LaravelLocalization::transRoute('routes.account-companies'), 'CompanyController@index');
			Route::get(LaravelLocalization::transRoute('routes.account-companies-create'), 'CompanyController@create');
			Route::post(LaravelLocalization::transRoute('routes.account-companies-create'), 'CompanyController@store');
			Route::post(LaravelLocalization::transRoute('routes.account-companies-search'), 'CompanyController@search');
			Route::get(LaravelLocalization::transRoute('routes.account-companies-search'), 'CompanyController@search');

			// Route::get('account/companies/create', 'CompanyController@create');

			// Route::post('account/companies', 'CompanyController@store');
			Route::get(LaravelLocalization::transRoute('routes.account-companies') .'/{id}', 'CompanyController@show');
			Route::get(LaravelLocalization::transRoute('routes.account-companies-edit'), 'CompanyController@edit');
			Route::put(LaravelLocalization::transRoute('routes.account-companies') .'/{id}', 'CompanyController@update');
			Route::get(LaravelLocalization::transRoute('routes.t-account-companies-delete'), 'CompanyController@destroy');
			Route::post(LaravelLocalization::transRoute('routes.account-companies-delete'), 'CompanyController@destroy');
			// Route::post('account/companies/search', 'CompanyController@search');

			// Resumes
			Route::get('account/resumes', 'ResumeController@index');
			Route::get('account/resumes/create', 'ResumeController@create');
			Route::post('account/resumes', 'ResumeController@store');
			Route::get('account/resumes/{id}', 'ResumeController@show');
			Route::get('account/resumes/{id}/edit', 'ResumeController@edit');
			Route::put('account/resumes/{id}', 'ResumeController@update');
			Route::get('account/resumes/{id}/delete', 'ResumeController@destroy');
			Route::post('account/resumes/delete', 'ResumeController@destroy');

			// Sedcard
			Route::get(LaravelLocalization::transRoute('routes.model-sedcard-edit'), 'SedcardNewController@index');
			Route::get('account/sedcards/create/{id}', 'SedcardNewController@create');
			Route::post('account/sedcard', 'SedcardNewController@store');
			
			Route::get('account/sedcards/{id}', 'SedcardNewController@show')->name('show-sedcard');

			Route::get('account/sedcards/sedcardnew/{id}/{user_id}', 'SedcardNewController@sedcardnew')->name('show-sedcardnew');

			// sedcard Picture Croping
			Route::post('cropSedcardImage', 'SedcardNewController@cropSedcardImage');

			

			Route::get('account/sedcards/{id}/edit', 'SedcardNewController@edit');
			Route::put('account/sedcards/{id}', 'SedcardNewController@update');
			Route::get('account/sedcards/{id}/delete', 'SedcardNewController@destroy');
			Route::post('account/sedcards/delete', 'SedcardNewController@destroy');
			Route::get('account/sedcards/genrate/{id}', 'SedcardNewController@genrate');
			Route::post('account/sedcards/cropimg/{id}', 'SedcardNewController@cropimg');
			Route::get('account/{id}/downloadsdcard/', 'SedcardNewController@downloadsdcard');

			// translation routes
			Route::get(LaravelLocalization::transRoute('routes.sedcard-generator'), 'SedcardNewController@genrate');

			// Model Book
			Route::get(LaravelLocalization::transRoute('routes.model-portfolio-edit'), 'ModelBookController@index');
			Route::get('account/model-book/{id}', 'ModelBookController@show')->name('show-modelbook');
			Route::get('account/model-book/gallery/{id}/{user_id}', 'ModelBookController@showGallery')->name('show-gallery');

			// ajax call show all model-book
			Route::get('show-all-modelbook', 'ModelBookController@getModelBookAjaxCall')->name('show-all-modelbook');

			// ajax call show all Albums
			Route::get('show-all-albums', 'AlbumController@getAlbumsAjaxCall')->name('show-all-albums');

			Route::get('account/model-book/create', 'ModelBookController@create');
			Route::post(LaravelLocalization::transRoute('routes.model-portfolio-edit'), 'ModelBookController@store');
			Route::get('account/model-book/{id}/edit', 'ModelBookController@edit');
			Route::get('account/model-book/genrate/{id}', 'ModelBookController@genrate');
			Route::post('account/model-book/cropimg/{id}', 'ModelBookController@cropimg');
			Route::post('account/model-book/{id}/update', 'ModelBookController@update');
			Route::get('account/model-book/{id}/delete', 'ModelBookController@destroy');
			Route::get('account/{id}/downloadmbook', 'ModelBookController@downloadsdcard');
			Route::post('account/model-book/delete', 'ModelBookController@destroy');

			// Route::get('/find-work', function () {
			// 	return view('model/find-work');
			// })->name('find-work');

			// Route::get('/my-favourite-jobs', function () {
			// 	return view('model/my-favourite-jobs');
			// })->name('my-favourite-jobs');

			// Route::get('/my-jobs', function () {
			// 	return view('model/my-jobs');
			// })->name('my-jobs');

			// Route::get('/notifications', function () {
			// 	return view('notifications');
			// })->name('notifications');

			// Route::get('/my-job-messages', function () {
			// 	return view('model/my-job-messages');
			// })->name('my-job-messages');

			// Route::get('/my-subscription', function () {
			// 	return view('my-subscription');
			// })->name('my-subscription');

			// partner acount
			Route::get(LaravelLocalization::transRoute('routes.account-album'), 'AlbumController@index');
			Route::get('account/album/create', 'AlbumController@create');
			Route::post('account/album-book', 'AlbumController@store');
			Route::get('account/album/{id}/edit', 'AlbumController@edit');
			Route::put('account/album/{id}', 'AlbumController@update');
			Route::get('account/album/{id}/delete', 'AlbumController@destroy');
			Route::post('account/album/delete', 'AlbumController@destroy');

			Route::get('account/album/genrate/{id}', 'AlbumController@genrate');
			Route::post('account/album/cropimg/{id}', 'AlbumController@cropimg');

			Route::get('account/album/{id}/downloadalbum', 'AlbumController@downloadalbum');

			Route::get('partner-public-profile/{id?}', 'EditController@userPartnerView')->name('partner-public-profile');
			
			Route::get('model-public-profile/{id}', 'EditController@userView')->name('model-public-profile');

			// Common Route for Model and Partner Profile.
			Route::get(LaravelLocalization::transRoute('routes.user').'/{slug?}', 'EditController@redirectUser')->name('user');

			Route::post('user-sendmail', 'EditController@userSendMail')->name('user-sendmail');

			Route::post('direct-message', 'ConversationsController@directMessage')->name('direct-message');


			Route::get(LaravelLocalization::transRoute('routes.partner-profile-edit'), 'EditController@EditPartnerProfile')->name('partner-profile-edit');
			Route::post('partner-profile-save', 'EditController@SavePartnerProfile')->name('partner-profile-save');
			Route::get('partner-public-portfolio/{id?}', 'EditController@partnerPortfolio')->name('partner-public-portfolio');

			Route::get(LaravelLocalization::transRoute('routes.partner-dashboard'), 'EditController@partnerDashboard');
			Route::get('img-zoom-popup/{id}', 'AlbumController@getAlbumImageById')->name('album-img-zoom-popup');

			//user posted jobs for model
			Route::get(LaravelLocalization::transRoute('routes.job-match-profile'), 'EditController@jobMatchProfile');
			Route::get('img-zoom-popup/{id}', 'AlbumController@getAlbumImageById')->name('album-img-zoom-popup');
			Route::get('account/album/album_gallery/{id}/{user_id}', 'AlbumController@album_gallery')->name('alubm-gallery');

			//  Social Wall
			Route::get(LaravelLocalization::transRoute('routes.social'), 'SocialController@index')->name('social');
			Route::get('account/social/facebook', 'SocialController@facebook');
			Route::get('account/social/rss', 'SocialController@rss');
			Route::get('account/social/twitter', 'SocialController@twitter');

			// Route::get('change-password', 'EditController@loadChangePassword')->name('change-password');
			Route::get(LaravelLocalization::transRoute('routes.change-password'), 'EditController@loadChangePassword')->name('change-password');
			Route::put('account/settings', 'EditController@updateSettings');
			Route::put('account/preferences', 'EditController@updatePreferences');
			Route::put('account/update', 'EditController@updateDetails');

			// Posts
			Route::get('account/saved-search', 'PostsController@getSavedSearch');
			$router->pattern('pagePath', '(my-posts|archived|favourite|pending-approval|saved-search)+');
			
			Route::get('account/{pagePath}', 'PostsController@getPage');
			Route::get('account/{pagePath}/{id}/repost', 'PostsController@archivedPost');
			Route::get('account/{pagePath}/{id}/delete', 'PostsController@destroy');
			Route::post('account/{pagePath}/delete', 'PostsController@destroy');
			Route::post('account/{pagePath}', 'PostsController@getMyPostSearch');

			// get user applied posts job list
			Route::get(LaravelLocalization::transRoute('routes.job-applied'), 'PostsController@getAppliedPosts')->name('job-applied');

			// Applications
			Route::get('account/my-posts/{id}/applications', 'PostsController@getApplications');
			Route::post('account/my-posts/{id}/applications', 'PostsController@getApplications');

			// Conversations
			Route::get(LaravelLocalization::transRoute('routes.messages'), 'ConversationsController@index')->name('messages');

			Route::post(LaravelLocalization::transRoute('routes.messages'), 'ConversationsController@index')->name('messages');

			Route::get('account/conversations/filter', 'ConversationsController@filter');
			Route::get('account/conversations/{id}/delete', 'ConversationsController@destroy');
			Route::post('account/conversations/delete', 'ConversationsController@destroy');
			Route::post('account/conversations/{id}/reply', 'ConversationsController@reply');
			$router->pattern('msgId', '[0-9]+');
			Route::get('account/conversations/{id}/messages/{page?}', 'ConversationsController@messages')->name('message-texts');
			
			Route::get('account/conversations/{id}/job/{jobId}', 'ConversationsController@messagesJob')->name('message-job');

			Route::get('account/conversations/{id}/messages/{msgId}/delete', 'ConversationsController@destroy');
			Route::post('account/conversations/{id}/messages/delete', 'ConversationsController@destroy');
			Route::post('account/{id}/contact', 'ConversationsController@contact');
			Route::post('account/messages/delete', 'ConversationsController@deleteMessages');
			
			//Notifications
			// Route::get('notifications/{status?}', 'ConversationsController@getnotification');

			// Notifications
			Route::get(LaravelLocalization::transRoute('routes.notifications'), 'ConversationsController@getnotification');

			Route::get(LaravelLocalization::transRoute('routes.t-notifications'), 'ConversationsController@getnotification');

			Route::post(LaravelLocalization::transRoute('routes.notifications'), 'ConversationsController@getnotification');
			Route::post(LaravelLocalization::transRoute('routes.t-notifications'), 'ConversationsController@getnotification');
			 

			
			Route::get('notification/search', 'ConversationsController@getsearchnotification');

			
			// Route::post('notifications/search', 'ConversationsController@getsearchnotification');
			// Transactions
			Route::get('account/transactions', 'TransactionsController@index')->name('transactions');

			Route::get('getTimeZoneAjaxCall', 'EditController@getTimeZoneAjaxCall');



		});

		// FEEDS
		Route::feeds();

		// Country Code Pattern
		$countryCodePattern = implode('|', array_map('strtolower', array_keys(getCountries())));
		$router->pattern('countryCode', $countryCodePattern);

		// XML SITEMAPS
		Route::get('{countryCode}/sitemaps.xml', 'SitemapsController@site');
		Route::get('{countryCode}/sitemaps/pages.xml', 'SitemapsController@pages');
		Route::get('{countryCode}/sitemaps/categories.xml', 'SitemapsController@categories');
		Route::get('{countryCode}/sitemaps/cities.xml', 'SitemapsController@cities');
		Route::get('{countryCode}/sitemaps/posts.xml', 'SitemapsController@posts');

		// STATICS PAGES
		Route::group(['middleware' => ['httpCache:yes', 'cacheResponse:864000']], function ($router) {

			// load more ajax route for magazine paginations
			Route::get(LaravelLocalization::transRoute('routes.magazine').'/ajax', 'PageController@magazine');
			Route::get(LaravelLocalization::transRoute('routes.blog-category').'/ajax', 'PageController@category_magazine');
			Route::get(LaravelLocalization::transRoute('routes.t-magazine-tag').'/ajax', 'PageController@tag_magazine');

			//Route::get(LaravelLocalization::transRoute('routes.page'), 'PageController@index');
			// Route::get(LaravelLocalization::transRoute('routes.contact'), 'PageController@contact');
			// Route::post(LaravelLocalization::transRoute('routes.contact'), 'PageController@contactPost');
			Route::post(LaravelLocalization::transRoute('routes.contact'), 'PageController@contactPost');
			Route::get(LaravelLocalization::transRoute('routes.sitemap'), 'SitemapController@index');
			Route::get(LaravelLocalization::transRoute('routes.companies-list'), 'Search\CompanyController@index');

			//new routes
			//Route::get(LaravelLocalization::transRoute('routes.book-a-model'), 'PageController@bookModel');
			// Route::get(LaravelLocalization::transRoute('routes.about-us'), 'PageController@aboutUs');
			//Route::get(LaravelLocalization::transRoute('routes.go-premium'), 'PageController@premiumMembership');
			// Route::get(LaravelLocalization::transRoute('routes.redirect-premium'), 'PageRedirectController@redirectPremium');
			
			// Route::get(LaravelLocalization::transRoute('routes.models-category'), 'PageController@categories');
			
			// Route::get('baby-models/become-a-baby-model', 'PageController@modelCategoryPage');
			// Route::get(LaravelLocalization::transRoute('routes.baby-model-page'), 'CategoryController@load')->name('baby-model-page');
			// Route::get(LaravelLocalization::transRoute('routes.child-model-page'), 'CategoryController@load')->name('kid-model-page');
			// Route::get(LaravelLocalization::transRoute('routes.model-page'), 'CategoryController@load')->name('model-page');
			// Route::get(LaravelLocalization::transRoute('routes.senior-model-page'), 'CategoryController@load')->name('senior-model-page');
			// Route::get(LaravelLocalization::transRoute('routes.pluszie-model-page'), 'CategoryController@load')->name('pluszie-model-page');
			// Route::get(LaravelLocalization::transRoute('routes.fitness-model-page'), 'CategoryController@load')->name('fitness-model-page');

			// Route::get(LaravelLocalization::transRoute('routes.post-a-job'), 'PageController@postJob');
			Route::post(LaravelLocalization::transRoute('routes.post-a-job'), 'PageController@submitJob');
			// Route::get(LaravelLocalization::transRoute('routes.magazine'), 'PageController@magazine');
			// Route::get(LaravelLocalization::transRoute('routes.pricing'), 'PageController@packages');
			//Route::get(LaravelLocalization::transRoute('routes.faq'), 'PageController@faq');
			// Route::get(LaravelLocalization::transRoute('routes.feedback'), 'PageController@feedback');
			Route::post(LaravelLocalization::transRoute('routes.feedback'), 'PageController@feedbackPost');
			Route::get(LaravelLocalization::transRoute('routes.ourVision'), 'PageController@ourVision');
			Route::get(LaravelLocalization::transRoute('routes.benefits'), 'PageController@benefits');
			Route::get(LaravelLocalization::transRoute('routes.videos'), 'PageController@videos');
			
			// Route::get('kontakt', 'PageController@contactUs')->name('contact');
			// Route::get(LaravelLocalization::transRoute('routes.professionals'), 'PageController@professionals');
			// Route::get('magazin/{id}/details', 'PageController@magazine_read')->name('magazine_read');

			// Route::get('magazin/{id}/details', 'PageController@magazine_read');

			// Route::get(LaravelLocalization::transRoute('routes.blog-category'), 'PageController@category_magazine');
			// Route::get(LaravelLocalization::transRoute('routes.t-magazine'), 'PageController@magazine_read');

			// Route::get(LaravelLocalization::transRoute('routes.t-magazine-tag'), 'PageController@tag_magazine');

			// Route::get('blog-category/{slug}', 'PageController@category_magazine');
			//Route::get('magazine/{slug}', 'PageController@magazine_read');
			//Route::get('magazine/tag/{slug}', 'PageController@tag_magazine');


			//Route::get('nutzervereinbarung', 'PageController@agreement')->name('nutzervereinbarung');
			//Route::get('nutzervereinbarung-partner', 'PageController@agreementPartner')->name('nutzervereinbarung_partner');
			Route::get('datenschutz', 'PageController@security')->name('datenschutz');

			// Route::get('kategorien/{slug}', 'CategoryController@load')->name('category.baby');
			Route::get(LaravelLocalization::transRoute('routes.page-category'), 'CategoryController@load');

			// Route::get('50plus/{slug?}', 'CategoryController@findMatchCategory');
			// Route::get('baby-models/{slug?}', 'CategoryController@findMatchCategory');
			// Route::get('child-models/{slug?}', 'CategoryController@findMatchCategory');
			// Route::get('models/{slug?}', 'CategoryController@findMatchCategory');
			// Route::get('plus-size/{slug?}', 'CategoryController@findMatchCategory');
			// Route::get('fitnessmodel/{slug?}', 'CategoryController@findMatchCategory');

			


			// terms Conditions 
			// Route::get(LaravelLocalization::transRoute('routes.terms-conditions-model'), 'PageController@getTerms')->name('terms-conditions-model');
			// Route::get(LaravelLocalization::transRoute('routes.terms-conditions-client'), 'PageController@getTerms')->name('terms-conditions-client');
		});

		//minify the static pages
		Route::group(['middleware' => ['httpCache:yes', 'cacheResponse:864000', 'pagespeed']], function ($router) {
			Route::get(LaravelLocalization::transRoute('routes.models-category'), 'PageController@categories');
			Route::get(LaravelLocalization::transRoute('routes.professionals'), 'PageController@professionals');
			Route::get(LaravelLocalization::transRoute('routes.magazine'), 'PageController@magazine');
			Route::get(LaravelLocalization::transRoute('routes.academy'), 'PageController@academy');
			Route::get(LaravelLocalization::transRoute('routes.post-a-job'), 'PageController@postJob');
			Route::get(LaravelLocalization::transRoute('routes.about-us'), 'PageController@aboutUs');
			Route::get(LaravelLocalization::transRoute('routes.contact'), 'PageController@contact');
			Route::get(LaravelLocalization::transRoute('routes.feedback'), 'PageController@feedback');

			Route::get(LaravelLocalization::transRoute('routes.baby-model-page'), 'CategoryController@load')->name('baby-model-page');
			Route::get(LaravelLocalization::transRoute('routes.child-model-page'), 'CategoryController@load')->name('kid-model-page');
			Route::get(LaravelLocalization::transRoute('routes.model-page'), 'CategoryController@load')->name('model-page');
			Route::get(LaravelLocalization::transRoute('routes.senior-model-page'), 'CategoryController@load')->name('senior-model-page');
			Route::get(LaravelLocalization::transRoute('routes.pluszie-model-page'), 'CategoryController@load')->name('pluszie-model-page');
			Route::get(LaravelLocalization::transRoute('routes.fitness-model-page'), 'CategoryController@load')->name('fitness-model-page');
			Route::get(LaravelLocalization::transRoute('routes.tattoo-model-page'), 'CategoryController@load')->name('tattoo-model-page');
			Route::get(LaravelLocalization::transRoute('routes.male-model-page'), 'CategoryController@load')->name('male-model-page');

			// Route::get(LaravelLocalization::transRoute('routes.terms-conditions-model'), 'PageController@getTerms')->name('terms-conditions-model');
			// Route::get(LaravelLocalization::transRoute('routes.terms-conditions-client'), 'PageController@getTerms')->name('terms-conditions-client');

			// magazine category page
			Route::get(LaravelLocalization::transRoute('routes.blog-category'), 'PageController@category_magazine');

			Route::get(LaravelLocalization::transRoute('routes.t-magazine'), 'PageController@magazine_read');
			Route::get(LaravelLocalization::transRoute('routes.t-magazine-tag'), 'PageController@tag_magazine');
		});

		// Get term conditions
		Route::get(LaravelLocalization::transRoute('routes.terms-conditions-model'), 'PageController@getTerms')->name('terms-conditions-model');
		Route::get(LaravelLocalization::transRoute('routes.terms-conditions-client'), 'PageController@getTerms')->name('terms-conditions-client');
		

		// DYNAMIC URL PAGES
		Route::group(['middleware' => ['auth', 'adminRedirect']], function ($router) {
			$router->pattern('id', '[0-9]+');
			$router->pattern('username', '[a-zA-Z0-9]+');

			// MODEL LIST
			// Route::get(LaravelLocalization::transRoute('routes.model-list-slug'), 'Model\SearchController@index');
			Route::get(LaravelLocalization::transRoute('routes.model-list'), 'Model\SearchController@index');
			Route::post(LaravelLocalization::transRoute('routes.model-list'), 'Model\SearchController@index');

			Route::get(LaravelLocalization::transRoute('routes.t-model-list'), 'Model\SearchController@index');
			Route::post(LaravelLocalization::transRoute('routes.t-model-list'), 'Model\SearchController@index');
			
			// Jobs info page
			Route::get(LaravelLocalization::transRoute('routes.job-info'), 'PageController@jobInfo');
			
			// Route::post(LaravelLocalization::transRoute('routes.model-list-slug'), 'Model\SearchController@index');

			//GET ALL JOBS
			Route::get(LaravelLocalization::transRoute('routes.search'), 'Search\SearchController@index');
			//GET ALL FAVOURITES JOBS OR JOBS BASED ON USER
			Route::get(LaravelLocalization::transRoute('routes.t-search'), 'Search\SearchController@index');

			Route::get(LaravelLocalization::transRoute('routes.search-user'), 'Search\UserController@index');
			Route::get(LaravelLocalization::transRoute('routes.search-username'), 'Search\UserController@profile');
			Route::get(LaravelLocalization::transRoute('routes.search-company'), 'Search\CompanyController@profile');
			Route::get(LaravelLocalization::transRoute('routes.search-tag'), 'Search\TagController@index');
			Route::get(LaravelLocalization::transRoute('routes.search-city'), 'Search\CityController@index');
			Route::get(LaravelLocalization::transRoute('routes.search-subCat'), 'Search\CategoryController@index');
			Route::get(LaravelLocalization::transRoute('routes.search-cat'), 'Search\CategoryController@index');
		});

		// PARTNER LIST
		Route::group(['middleware' => ['auth', 'adminRedirect']], function ($router) {
			Route::get(LaravelLocalization::transRoute('routes.partner-list'), 'Partner\SearchController@index');
			Route::get(LaravelLocalization::transRoute('routes.partner-list-favourites'), 'Partner\SearchController@favoritePartners');
			// Route::get('favorite-partners', 'Partner\SearchController@favoritePartners')->name('favorite-partners');
			Route::get('partner-category:{catSlug}', 'Partner\CategoryController@index');
		});

		// Route::get('sitemaps/generatexml', 'SitemapsController@generateXml');

		// MODEL LIST
		// Route::group(['middleware' => ['auth']], function ($router) {
		// 	Route::get('model-list/{slug}', 'Model\SearchController@index');
		// 	Route::post('model-list/{slug}', 'Model\SearchController@index');
		// 	Route::get('model-list', 'Model\SearchController@index');
		// 	Route::post('model-list', 'Model\SearchController@index');
		// });

	});
});

Route::group(['middleware' => ['web'], 'namespace' => 'App\Http\Controllers'], function () {
	// Route::get('{locale}/contract', 'Auth\ContractController@redirectLink');
	Route::get('{locale}/specials/{id}', 'Post\DetailsController@showImages');
	Route::get('specials/{id}', 'Post\DetailsController@showImages1');
	Route::get('string-translations/{locale}/{filename}/{ext1?}/{ext2?}/{ext3?}', 'StringTranslationController@readFromLanguageFile');

	Route::get('images/{plugin}/{filename}', 'PageController@setupImageRoutes');
	Route::get('assets/{plugin}/{type}/{file}', 'PageController@setupAssetsRoutes');

	Route::get('/getCountryInfo', 'Ajax\CountryController@getCountryInfo');

});

// custom string transaltion modules route
// Route::group(['namespace' => 'App\Http\Controllers'], function ($router) {
// 	Route::get('string-translations/{locale}/{filename}/{ext1?}/{ext2?}/{ext3?}', 'StringTranslationController@readFromLanguageFile');
// });

/**** page fallback routes *****/
Route::group(['namespace' => 'App\Http\Controllers'], function ($router) {
	Route::group(['middleware' => ['web', 'pagespeed', 'cacheResponse:864000']], function ($router) {
		Route::fallback('PageController@index');
	});
});
/**** page fallback routes *****/

//new design routes
// Route::get('/style_guide', function () {
// 	return view('style_guide');
// });

// auth views
// Route::get('/registration', function () {
// 	return view('auth/registration');
// })->name('registration');

// Route::get('/reset_password', function () {
// 	return view('auth/reset_password');
// })->name('reset_password');

// Route::get('/feedback', function () {
// 	return view('feedback');
// })->name('feedback');

// Route::get('/thanks', function () {
// 	return view('thanks');
// })->name('thanks');

// in-app views - model

// Route::get('/route-list', function () {
// 	$routes = array_map(function (\Illuminate\Routing\Route $route) {
// 		return $route->uri;
// 	}, (array) Route::getRoutes()->getIterator()
// 	);

// 	foreach ($routes as $route) {
// 		if ($route == 'route-list') {
// 			continue;
// 		}

// 		echo 'http://go-model.local/' . $route . '<br />';
// 	}
// });

// testing route to show demo table for shoe and dress unit measurement in Germany, UK, US
// Route::get('/shoe-size-units', function () {
// 	return view('shoe-size-units');
// });

// Route::get('/dress-size-units', function () {
// 	return view('dress-size-units');
// });

// testing route to show demo table for shoe and dress unit measurement in Germany, UK, US - End

// Route::get('/my-job-details', function () {
// 	return view('model/my-job-details');
// })->name('my-job-details');

// Route::get('/my-job-message-texts', function () {
// 	return view('model/my-job-message-texts');
// })->name('my-job-message-texts');

// in-app views - partner

// Route::get('/partner', function () {
// 	return view('partner/partner-dashboard');
// })->name('partner-dashboard');

// Route::get('/find-model', function () {
// 	return view('partner/find-model');
// })->name('find-model');

// Route::get('/my-posted-jobs', function () {
// 	return view('partner/my-posted-jobs');
// })->name('my-posted-jobs');

// Route::get('/posted-job-profile', function () {
// 	return view('partner/posted-job-profile');
// })->name('posted-job-profile');

// Route::get('/posted-job-details', function () {
// 	return view('partner/posted-job-details');
// })->name('posted-job-details');

// Route::get('/posted-job-messages', function () {
// 	return view('partner/posted-job-messages');
// })->name('posted-job-messages');

// Route::get('/posted-job-message-texts', function () {
// 	return view('partner/posted-job-message-texts');
// })->name('posted-job-message-texts');

// Route::get('/post-new-job', function () {
// 	return view('partner/post-new-job');
// })->name('post-new-job');

// Route::get('/partner-profile-edit', function () {
// 	return view('partner/partner-profile-edit');
// })->name('partner-profile-edit');

// Route::get('/partner-public-profile', function () {
// 	return view('partner/public-profile');
// })->name('partner-public-profile');

// Route::get('/partner-portfolio', function () {
// 	return view('partner/public-profile-portfolio');
// })->name('partner-portfolio');

// in-app views - general

// Route::get('/job-profile', function () {
// 	return view('job-profile');
// })->name('job-profile');

// Route::get('/message-details', function () {
// 	return view('message-details');
// })->name('message-details');

// Route::get('/message-texts/{id}', function () {
// 	return view('message-texts');
// })->name('message-texts');


// Route::get('add-model-to-job-popup', function () {
// 	return view('childs.add-model-to-job-popup');
// })->name('add-model-to-job-popup');

// if get Invalid or blog route
// Route::group(['namespace' => 'App\Http\Controllers'], function ($router) {
// 	Route::fallback('PageRedirectController@findMatchBlog');
// });