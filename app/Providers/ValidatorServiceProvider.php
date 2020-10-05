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

namespace App\Providers;

use App\Helpers\Validator\BlacklistValidator;
use App\Helpers\Validator\GlobalValidator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class ValidatorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Validator::extend('whitelist_domain', function ($attribute, $value) {
            return BlacklistValidator::checkDomain($value);
        });
        
        Validator::extend('whitelist_email', function ($attribute, $value) {
            return BlacklistValidator::checkEmail($value);
        });
        
        Validator::extend('whitelist_word', function ($attribute, $value) {
            return BlacklistValidator::checkWord($value);
        });
        
        Validator::extend('whitelist_word_title', function ($attribute, $value) {
            return BlacklistValidator::checkTitle($value);
        });
        
        Validator::extend('mb_between', function ($attribute, $value, $parameters, $validator) {
            return GlobalValidator::mbBetween($value, $parameters);
        });
        Validator::replacer('mb_between', function($message, $attribute, $rule, $parameters) {
            $min = (isset($parameters[0])) ? (int)$parameters[0] : 0;
            $max = (isset($parameters[1])) ? (int)$parameters[1] : 999999;
            return str_replace([':min', ':max'], [$min, $max], $message);
        });
        Validator::extend('web_domain_valid', function ($attribute, $value) {
            return GlobalValidator::checkWebDomain($value);
        });
        Validator::extend('street_validate', function ($attribute, $value) {
            return GlobalValidator::checkStreet($value);
        });

        Validator::extend('valid_username', '\App\Helpers\Validator\UsernameValidator@isValid');
        Validator::extend('allowed_username', '\App\Helpers\Validator\UsernameValidator@isAllowed');

        //Grater than validation 
        Validator::extend('greater_than', function($attribute, $value, $params, $validator){
            $other = Request::input($params[0]);
            return abs($value) > abs($other);
        });

        Validator::replacer('greater_than', function($message, $attribute, $rule, $params) {
            return str_replace('_', ' ' , t('The :attribute1 must be greater than the  :attribute2', ['attribute1' => t($attribute), 'attribute2' => t($params[0])]));
        });

        //Grater than or equal to validation 
        Validator::extend('greater_than_or_qual', function($attribute, $value, $params, $validator){
            $other = Request::input($params[0]);
            return intval($value) >= intval($other);
        });

        Validator::replacer('greater_than_or_qual', function($message, $attribute, $rule, $params) {
            return str_replace('_', ' ' , t('The :attribute1 must be greater than or equal to  :attribute2', ['attribute1' => t($attribute), 'attribute2' => t($params[0])]));
        });

        //end date grater than start date
        Validator::extend('after_date', function($attribute, $value, $params, $validator){
            $start_date = Request::input($params[0]);
            return Carbon::parse($value) > Carbon::parse($start_date);
        });

        Validator::replacer('after_date', function($message, $attribute, $rule, $params) {
            return str_replace('_', ' ' , trans('validation.previus_end_date_validation'));
        });


    }
    
    public function register()
    {
        //
    }
}
