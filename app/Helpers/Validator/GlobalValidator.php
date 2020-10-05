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

namespace App\Helpers\Validator;

class GlobalValidator
{
    /**
     * @param $value
     * @param $parameters
     * @return bool
     */
    public static function mbBetween($value, $parameters)
    {
        $min = (isset($parameters[0])) ? (int)$parameters[0] : 0;
        $max = (isset($parameters[1])) ? (int)$parameters[1] : 999999;
    
        $value = strip_tags($value);
        
        if (mb_strlen($value) < $min) {
            return false;
        } else {
            if (mb_strlen($value) > $max) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $value
     * @param $parameters
     * @return bool
     */
    public static function checkWebDomain($domain)
    {
        return preg_match('/^((?:https?:\/\/)?[a-zA-Z0-9 -]+(?:\.[^.]+)+(?:\/.*)?)$/i', $domain);
    }

    /**
     * @param $value
     * @param $parameters
     * @return bool
     */
    public static function checkStreet($value)
    {   
        //if(preg_match('/[`~<>;\':@#%^&$*"\/\[\]\|{}()=_+-]/', $value)){
        if(preg_match('/[`!~<>;\':@#%^&$*"\[\]\|{}()=_+]/', $value)){
            
            return false;
        }
        return true;
    }
}
