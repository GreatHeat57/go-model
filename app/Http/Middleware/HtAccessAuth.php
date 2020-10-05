<?php

namespace App\Http\Middleware;

use Closure;

class HtAccessAuth
{
  
    protected $auth_access_array = array();


    public function __construct()
    {
        $this->auth_access_array = config('app.HTACCESS_AUTH_ARR');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        //Get url prefix
        $routePrefix            =  $request->route()->getPrefix();
        $is_htaccess_auth_check =  false;
        $app_env                =  config('app.env');
        
        if($app_env !== 'live' && $app_env !== 'local'){$is_htaccess_auth_check = true;}
        if($app_env == 'live' && ($routePrefix == '/admin' || $routePrefix == 'translations') ){$is_htaccess_auth_check = true;}

        //check if staging envirment is set then check authentication
        // if(config('app.env') !== 'live'){
        if($is_htaccess_auth_check == true){

            header('Cache-Control: no-cache, must-revalidate, max-age=0');

            //check user fill the username and password, so check the authentications
            $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));

            // default authentication set false.
            $is_not_authenticated = true;

            // check user name in auth access array key and check password in array value 
            if( isset($this->auth_access_array) && !empty($this->auth_access_array) && $has_supplied_credentials){
                if(isset($this->auth_access_array[$_SERVER['PHP_AUTH_USER']]) ){
                    if($this->auth_access_array[$_SERVER['PHP_AUTH_USER']] === $_SERVER['PHP_AUTH_PW']){
                        $is_not_authenticated = false;
                    }
                }
            }

            // $is_not_authenticated = (
            //     !$has_supplied_credentials ||
            //     $_SERVER['PHP_AUTH_USER'] != $this->auth_user ||
            //     $_SERVER['PHP_AUTH_PW']   != $this->auth_password
            // );

            // if user is not authenitcated then threw error
            if ($is_not_authenticated) {
                header('HTTP/1.1 401 Authorization Required');
                header('WWW-Authenticate: Basic realm="Access denied"');
                exit;
            }
        }

        return $next($request);
    }
}
