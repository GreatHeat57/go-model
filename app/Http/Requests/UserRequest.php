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

namespace App\Http\Requests;

use App\Models\Resume;
use App\Models\Country;
use Illuminate\Support\Facades\Auth;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Check if these fields has changed
        $emailChanged = ($this->input('email') != Auth::user()->email);
        $country= Country::where('code',Auth::user()->country_code)->select('phone')->first();
        // $usernameChanged = ($this->filled('username') && $this->input('username') != Auth::user()->username);
        $phoneChanged = '';
        
        // Validation Rules
        $rules = [];
        if (empty(Auth::user()->user_type_id) || Auth::user()->user_type_id == 0) {
            $rules['user_type'] = 'required|not_in:0';
        } else {

            // $rules['gender']    = 'required|not_in:0';
            // $rules['name']      = 'required|max:100';
            // $rules['phone_code']     = 'required';
            $rules['phone']     = 'required|mb_between:5,20|numeric';

            // if(!empty($this->input('phone'))){
            //     $old_phone = preg_replace("/^\+?{$country->phone}/", '', Auth::user()->phone);
            //     $phoneChanged = ($this->input('phone') != $old_phone);
            // }

            //$rules['email']     = 'required|email|whitelist_email|whitelist_domain';
            // $rules['username']  = 'valid_username|allowed_username|between:3,100';
            $rules['category']     = 'required';

            if ($this->hasFile('profile.logo')) {
                $rules['profile.logo'] = 'required|mimes:' . getUploadFileTypes('file') . '|max:' . (int)config('settings.upload.max_file_size', 1000);
            }

            if ($this->hasFile('profile.cover')) {
                $rules['profile.cover'] = 'required|mimes:' . getUploadFileTypes('file') . '|max:' . (int)config('settings.upload.max_file_size', 1000);
            }
	
			// Phone
			if (config('settings.sms.phone_verification') == 1) {
				if ($this->filled('phone')) {
					$countryCode = $this->input('country', config('country.code'));
					if ($countryCode == 'UK') {
						$countryCode = 'GB';
					}
					$rules['phone'] = 'phone:' . $countryCode . ',mobile|' . $rules['phone'];
				}
			}
            if ($phoneChanged) {
                //$rules['phone'] = 'unique:users,phone|' . $rules['phone'];
            }
	
			// Email
            // if ($emailChanged) {
            //     $rules['email'] = 'unique:users,email|' . $rules['email'];
            // }
	
			// Username
            // if ($usernameChanged) {
            //     $rules['username'] = 'required|unique:users,username|' . $rules['username'];
            // }


            // if($this->input('email') !== ""){
                $rules['zip'] = 'required|regex:/^[A-Za-z0-9_ ]+$/';   
            // }

                
            if(Auth::user()->user_type_id == config('constant.partner_type_id')){
                $rules['first_name'] = 'required|mb_between:2,35|regex:/^[A-Za-z\s]+$/';
                $rules['last_name'] = 'required|mb_between:2,35|regex:/^[A-Za-z\s]+$/';
                $rules['company_name'] = 'required|mb_between:2,200|whitelist_word_title';
                $rules['website_url']  = 'required|web_domain_valid|whitelist_domain|max:100';
                $rules['description']  = 'required';
                // $rules['street']  = 'required|regex:/^[A-Za-z0-9, -]+$/';
                $rules['street']  = 'required|street_validate';
                $rules['timezone'] = 'required';
            }

            if($this->filled('instagram')){
                $rules['instagram'] = 'url';
            }

            if($this->filled('facebook')){
                $rules['facebook'] = 'url';
            }

            if($this->filled('linkedin')){
                $rules['linkedin'] = 'url';
            }

            if($this->filled('twitter')){
                $rules['twitter'] = 'url';
            }

            if($this->filled('pinterest')){
                $rules['pinterest'] = 'url';
            }
        }
        
        if(Auth::user()->user_register_type !== config('constant.country_free')){
            $rules['phone_code']     = 'required';
        }

        return $rules;
    }
    
    /**
     * @return array
     */
    public function messages()
    {
        $messages = [
            'description.required' => t('The introduction field is required')
        ];
        return $messages;
    }
}
