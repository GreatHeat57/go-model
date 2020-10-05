<?php

$protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
$serverName = (isset($_SERVER['SERVER_NAME'])) ? $_SERVER['SERVER_NAME'] : php_uname("n");
$appUrl = $protocol . $serverName;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    */

    'name' => 'Go-Models',

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services your application utilizes. Set this in your ".env" file.
    |
    */
    
    'env' => (function_exists('env')) ? env('APP_ENV', 'local') : 'local',
    
    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */
    
    'debug' => (function_exists('env')) ? env('APP_DEBUG', true) : true,
    
    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => (function_exists('env')) ? env('APP_URL', $appUrl) : $appUrl,
    'asset_url' => (function_exists('env')) ? env('ASSET_URL', null) : null,
    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */
    
    'timezone' => 'UTC',
    
    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */
    
    'locale' => (function_exists('env')) ? env('APP_LOCALE', 'en') : 'en',
    
    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */
    
    'fallback_locale' => (function_exists('env')) ? env('APP_FALLBACK_LOCALE', 'en') : 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => (function_exists('env')) ? env('APP_KEY', 'SomeRandomStringWith32Characters') : 'SomeRandomStringWith32Characters',

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => (function_exists('env')) ? env('APP_LOG', 'daily') : 'daily',

	'log_max_files' =>  (function_exists('env')) ? env('APP_LOG_MAX_FILES', 30) : 30,

    'log_level' => (function_exists('env')) ? env('APP_LOG_LEVEL', 'debug') : 'debug',
    
    'app_name' => (function_exists('env')) ? env('APP_NAME', 'Go-Models') : 'Go-Models',
    'domain_name' => (function_exists('env')) ? env('DOMAIN_NAME', 'go-models.com') : 'go-models.com',
    'main_url' => (function_exists('env')) ? env('MAIN_URL', '') : '',
    'main_url_user' => (function_exists('env')) ? env('MAIN_URL_user', 'api') : 'api',
    'main_url_pw' => (function_exists('env')) ? env('MAIN_URL_pw', '') : '',
    'receivepageurl' => (function_exists('env')) ? env('receivepageurl', '') : '',
    'go_api_key' => (function_exists('env')) ? env('go_api_key', '') : '',

    'recent_blogs_limit' => (function_exists('env')) ? env('RECENT_BLOGS_LIMIT', '3') : '3',
    'popular_blogs_limit' => (function_exists('env')) ? env('POPULAR_BLOGS_LIMIT', '6') : '6',
    
    'purchase_code' => (function_exists('env')) ? env('PURCHASE_CODE', '') : '',

    'stripe_key' => (function_exists('env')) ? env('STRIPE_KEY', '') : '',
    'stripe_secret' => (function_exists('env')) ? env('STRIPE_SECRET', '') : '',
    'stripe_country' => (function_exists('env')) ? env('STRIPE_COUNTRY', 'AT') : 'AT',

    'paypal_username' => (function_exists('env')) ? env('PAYPAL_USERNAME', '') : '',
    'paypal_password' => (function_exists('env')) ? env('PAYPAL_PASSWORD', '') : '',
    'paypal_signature' => (function_exists('env')) ? env('PAYPAL_SIGNATURE', '') : '',
    'paypal_mode' => (function_exists('env')) ? env('PAYPAL_MODE', 'sandbox') : 'sandbox',

    'admin_email' =>  (function_exists('env')) ? env('ADMIN_MAIL_TO', '') : '',
    'admin_email2' =>  (function_exists('env')) ? env('ADMIN_MAIL_BCC', '') : '',
    'admin_email_migration' =>  (function_exists('env')) ? env('ADMIN_EMAIL_MIGRATION', '') : '',
    'suppport_email' => (function_exists('env')) ? env('SUPPORT_EMAIL',''): '',
    'feedback_receiver_email' => (function_exists('env')) ? env('FEEDBACK_RECEIVER_EMAIL', '') : '',
    'feedback_receiver_name' => (function_exists('env')) ? env('FEEDBACK_RECEIVER_NAME', '') : '',
    'conatct_receiver_email' => (function_exists('env')) ? env('CONTACT_RECEIVER_EMAIL', '') : '',
    'contact_receiver_name' => (function_exists('env')) ? env('CONTACT_RECEIVER_NAME', '') : '',
    'job_request_receiver_email' => (function_exists('env')) ? env('JOB_REQUEST_RECEIVER_EMAIL', '') : '',
    'job_request_receiver_name' => (function_exists('env')) ? env('JOB_REQUEST_RECEIVER_NAME', '') : '',

    'model_category_image_path' => (function_exists('env')) ? env('MODEL_CATEGORY_IMAGE_PATH',''):'',
    'partner_category_image_path' => (function_exists('env')) ? env('PARTNER_CATEGORY_IMAGE_PATH',''):'',
    'email_traker' => (function_exists('env')) ? env('EMAIL_TRACKER',''):'',

    'cloud_url' => (function_exists('env')) ? env('CLOUD_URL',''):'',
    'recent_Blogs_category_limit' => (function_exists('env')) ? env('RECENT_BLOGS_CATEGORY_LIMIT',''):'4',
    'blog_top_image' => '350x210',
    'blog_bottom_image' => '350x210',
    'blog_top_image_new' => '397x239',
    'blog_bottom_image_new' => '407x246',
    'blog_right_image' => '120x90',
    'go_model_facebook' => (function_exists('env')) ? env('GO_MODEL_FACEBOOK',''):'',
    'go_model_instagram' => (function_exists('env')) ? env('GO_MODEL_INSTAGRAM',''):'',
    'go_model_twiiter' => (function_exists('env')) ? env('GO_MODEL_TWITTER',''):'',
    'go_model_youtube' => (function_exists('env')) ? env('GO_MODEL_YOUTUBE',''):'',
    'go_model_pinterest' => (function_exists('env')) ? env('GO_MODEL_PINTEREST',''):'',

    'default_units_country' => 'at',
    'units_alias' => '_unit',
    'kid_alias' => '_kids',
    'men_alias' => '_men',
    'women_alias' => '_women',
    'baby_model_slugs' => ['baby-model','baby-model-de','kid-model','kid-model-de'],

    'num_counter' => 99,
    
    'page_access_token' => (function_exists('env')) ? env('FACEBOOK_PAGE_ACCESS_TOKEN',''):'',
    'fb_api_version' => (function_exists('env')) ? env('FACEBOOK_API_VERSION',''):'',
    'facebook_page_id' => (function_exists('env')) ? env('FACEBOOK_PAGE_ID',''):'',

    'facebook_app_id' => (function_exists('env')) ? env('FACEBOOK_APP_ID',''):'',
    'facebook_app_secret' => (function_exists('env')) ? env('FACEBOOK_APP_SECRET',''):'',

    'hide_or_show_latest_jobs_front_side' => (function_exists('env')) ? env('HIDE_OR_SHOW_LATEST_JOBS_FRONT_SIDE','true'):'',
    
    'g_latlong_url' => 'https://maps.google.com/maps/api/geocode/json?address=',
    'latlong_api' => (function_exists('env')) ? env('GOOGLE_API_KEY',''):'',
    'google_timezone_api_url' => (function_exists('env')) ? env('GOOGLE_TIMEZONE_API_URL',''):'',
    'google_siteverify' => 'https://www.google.com/recaptcha/api/siteverify?secret=',
    'google_cloud_translation_api_key' => (function_exists('env')) ? env('GOOGLE_CLOUD_TRANSLATION_API_KEY',''): 'AIzaSyDFl653JhFNw7W3U_rcrwil-4EESsf3nNI',
    'url_encrypt_method' => (function_exists('env')) ? env('URL_ENCRYPT_METHOD',''): '',
    'url_secret_key' => (function_exists('env')) ? env('URL_SECRET_KEY',''): '',
    'url_secret_iv' => (function_exists('env')) ? env('URL_SECRET_IV',''): '',
    
    'sedcard_images_count' => 5,
    'HTACCESS_AUTH_ARR' => [
        'priyanka' => '_hgjZGhgzT44111222',
        'jacek'=>'_jNhd_jnvhvgdqsdsdwe',
        'go' => '_jdnvh_hdvhffe111',
        // 'local' => '123',
        //'mm'=>'$apr1$16MNz8PG$L2oerOV39ON7Sg.IlrXTy.',
        //'kathi'=>'$apr1$44Bb10Ud$1HtKLFJC3XVUB95xvKxN7/',
        //'expertteam'=>'$apr1$30iv/qt6$CIFcce4Tg0fJteTk5agKm/',
        //'neha'=>'$apr1$d/8souBn$T/YrmCjbfWOpMHSUT7Uoa1',
        //'nikos'=>'$apr1$I6.JK06J$iQfP.AKFKfBl0ChQ/KUrf0',
        //'priyanka'=>'$apr1$UpfLF37W$NYScGd6D/wxwFDIlq9kwH/',
        //'rakesh'=>'$apr1$AbT4cC72$tRix8e51t9Kph5G1ImXAX.',
        //'vaibhav'=>'$apr1$IEzBkk0K$I67Fizza4UwR.O2o.OtLZ.',
        //'an'=>'$apr1$rLjuNIG5$WPtOhdbaK51.bbgAULXBR0',
        //'huber'=>'$apr1$rsqegrfj$JQl3pb2Ji7RdOiAUe8FIs1',
        //'hinal'=>'$apr1$o2F3xgMR$.VsHP6i/bKDAq9untWVz3.',
        //'robert'=>'$apr1$B414PrM5$sv28zfgEi3FVS/RwlFm7I1',
        //'kunmar'=>'$apr1$ZHnskxCc$fJXlnYUtWmaK0PmPT0n211',
        //'google'=>'$apr1$gYNp/jy7$fJZ3SmSmRbwmmERr.PjnB/',
    ],


    'twitter_consumer_key' => (function_exists('env')) ? env('TWITTER_CONSUMER_KEY',''):'',
    'twitter_consumer_secret' => (function_exists('env')) ? env('TWITTER_CONSUMER_SECRET',''):'',
    'twitter_oauth_access_token' => (function_exists('env')) ? env('TWITTER_OAUTH_ACCESS_TOKEN',''):'',
    'twitter_oauth_access_token_secret' => (function_exists('env')) ? env('TWITTER_OAUTH_ACCESS_TOKEN_SECRET',''):'',

    'instagram_id' => (function_exists('env')) ? env('INSTAGRAM_ID',''):'',
    'instagram_access_token' => (function_exists('env')) ? env('INSTAGRAM_ACCESS_TOKEN',''):'',
    'instagram_redirect_url' => (function_exists('env')) ? env('INSTAGRAM_REDIRECT_URL',''):'',
    'instagram_client_id' => (function_exists('env')) ? env('INSTAGRAM_CLIENT_ID',''):'',

    'kickbox_api_key_staging' => (function_exists('env')) ? env('KICKBOX_API_KEY_STAGING') : '',
    'kickbox_api_key_live'    => (function_exists('env')) ? env('KICKBOX_API_KEY_LIVE') : '',
    'is_verify_email'         => (function_exists('env')) ? env('IS_VERIFY_EMAIL',''):'',
    'kickbox_api_timeout'     => (function_exists('env')) ? env('KICKBOX_API_TIMEOUT') : '',
    'kickbox_api_verify'      => (function_exists('env')) ? env('KICKBOX_API_VERIFY') : false,
    'available_contact_start_time' => (function_exists('env')) ? env('AVAILABLE_CONTACT_START_TIME',''):'',
    'available_contact_end_time' => (function_exists('env')) ? env('AVAILABLE_CONTACT_END_TIME',''):'',
    'zerobounce_api_key_staging' => (function_exists('env')) ? env('ZEROBOUNCE_API_KEY_STAGING') : '',
    'zerobounce_api_key_live'    => (function_exists('env')) ? env('ZEROBOUNCE_API_KEY_LIVE') : '',
    'zerobounce_api_timeout'     => (function_exists('env')) ? env('ZEROBOUNCE_API_TIMEOUT') : '',
    'zerobounce_api_verify'      => (function_exists('env')) ? env('ZEROBOUNCE_API_VERIFY') : false,

    'sedcard_jobs_email' => (function_exists('env')) ? env('SEDCARD_JOBS_EMAIL') : '',
    'is_log_timezone' => (function_exists('env')) ? env('IS_LOG_TIMEZONE') : '',
    'is_log_latlong' => (function_exists('env')) ? env('IS_LOG_LATLONG') : '',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */
    
    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        // Illuminate\Translation\TranslationServiceProvider::class,
        'Barryvdh\TranslationManager\TranslationServiceProvider',
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\ValidatorServiceProvider::class,
        App\Providers\PluginsServiceProvider::class,
        // App\Providers\CookieConsentProvider::class,

        Larapen\TextToImage\TextToImageServiceProvider::class,
        Laracasts\Flash\FlashServiceProvider::class,
        Creativeorange\Gravatar\GravatarServiceProvider::class,
        Larapen\LaravelMetaTags\MetaTagsServiceProvider::class,
        // Greggilbert\Recaptcha\RecaptchaServiceProvider::class,
        Larapen\LaravelLocalization\LaravelLocalizationServiceProvider::class,
        'Ignited\LaravelOmnipay\LaravelOmnipayServiceProvider',
        Larapen\Admin\AdminServiceProvider::class,
        'Prologue\Alerts\AlertsServiceProvider',
        Larapen\Elfinder\ElfinderServiceProvider::class,
        'Spatie\Backup\BackupServiceProvider',
        NotificationChannels\Twilio\TwilioProvider::class,
		Larapen\Feed\FeedServiceProvider::class,
		Larapen\Impersonate\ImpersonateServiceProvider::class,
        Jackiedo\DotenvEditor\DotenvEditorServiceProvider::class,
        'Sofa\Eloquence\BaseServiceProvider',
        'Barryvdh\TranslationManager\ManagerServiceProvider',
        // Way\Generators\GeneratorsServiceProvider::class,
        // Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class,
        Orangehill\Iseed\IseedServiceProvider::class,
        Astrotomic\Translatable\TranslatableServiceProvider::class,
        // MichalKoval\SEO\SEOServiceProvider::class,
        Propa\BrowscapPHP\BrowscapServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Barryvdh\DomPDF\ServiceProvider::class,
        'Buzz\LaravelGoogleCaptcha\CaptchaServiceProvider',
        PulkitJalan\GeoIP\GeoIPServiceProvider::class,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */
    
    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
		
        'Flash' => Laracasts\Flash\Flash::class,
        'Gravatar' => Creativeorange\Gravatar\Facades\Gravatar::class,
        'MetaTag' => Torann\LaravelMetaTags\Facades\MetaTag::class,
        // 'Recaptcha' => Greggilbert\Recaptcha\Facades\Recaptcha::class,
        'LaravelLocalization' => Larapen\LaravelLocalization\Facades\LaravelLocalization::class,
        'TextToImage' => Larapen\TextToImage\Facades\TextToImage::class,
		'DotenvEditor' => Jackiedo\DotenvEditor\Facades\DotenvEditor::class,
        'Omnipay' => 'Ignited\LaravelOmnipay\Facades\OmnipayFacade',
        'Alert' => 'Prologue\Alerts\Facades\Alert',
        // 'SEO' => MichalKoval\SEO\SEOFacade::class,
        'Browscap' => Propa\BrowscapPHP\Facades\Browscap::class,
        'Image' => Intervention\Image\Facades\Image::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,
        'Captcha' => '\Buzz\LaravelGoogleCaptcha\CaptchaFacade',
        'Input' => Illuminate\Support\Facades\Request::class,
        'GeoIP' => PulkitJalan\GeoIP\Facades\GeoIP::class
    ],
    
    'version' => '3.6',

];
