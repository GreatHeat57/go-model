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

use App\Models\Blacklist;
use App\Helpers\Ip;
use Illuminate\Support\Str;

class BlacklistValidator
{
    /**
     * @return bool
     */
    public static function checkIp()
    {
        $ip = Ip::get();
        $res = Blacklist::ofType('ip')->where('entry', $ip)->first();
        if ($res) {
            return false;
        }
        
        return true;
    }
    
    /**
     * @param $domain
     * @return bool
     */
    public static function checkDomain($domain)
    {
        $domain = strtolower($domain);
        $domain = str_replace(['http://', 'www.'], '', $domain);
        if (Str::contains($domain, '/')) {
            $domain = strstr($domain, '/', true);
        }
        if (Str::contains($domain, '@')) {
            $domain = strstr($domain, '@');
            $domain = str_replace('@', '', $domain);
        }
        $res = Blacklist::ofType('domain')->where('entry', $domain)->first();
        if ($res) {
            return false;
        }
        
        return true;
    }
    
    /**
     * @param $email
     * @return bool
     */
    public static function checkEmail($email)
    {
        $email = strtolower($email);
        $res = Blacklist::ofType('email')->where('entry', $email)->first();
        if ($res) {
            return false;
        }
        
        return true;
    }
    
    /**
     * @param $text
     * @return bool
     */
    public static function checkWord($text)
    {
        $text = trim(mb_strtolower($text));
        $words = Blacklist::ofType('word')->get();
        if ($words->count() > 0) {
            foreach ($words as $word) {
                // Check if a ban's word is contained in the user entry
                $patten = '\s-.,;:=/#\|_s';
                try {
                    if (preg_match('|[' . $patten . '\\\]+' . $word->entry . '[' . $patten . '\\\]+|i', ' ' . $text . ' ')) {
                        return false;
                    }
                } catch (\Exception $e) {
                    if (preg_match('|[' . $patten . ']+' . $word->entry . '[' . $patten . ']+|i', ' ' . $text . ' ')) {
                        return false;
                    }
                }
            }
        }
        
        return true;
    }
    
    /**
     * @param $text
     * @return bool
     */
    public static function checkTitle($text)
    {
        if (!self::checkWord($text)) {
            return false;
        }
        // Banned all domain name from title
        $tlds = config('tlds');
        if (count($tlds) > 0) {
            foreach ($tlds as $tld => $label) {
                if (Str::contains($text, '.' . strtolower($tld))) {
                    return false;
                }
            }
        }
        
        return true;
    }
}