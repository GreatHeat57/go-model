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

class CompanyRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Validation Rules
		$rules = [
			'company.name'        => 'required|mb_between:2,200|whitelist_word_title',
			'company.description' => 'required|mb_between:100,1000|whitelist_word',
		];
	
		// Check 'logo' is required
		if ($this->hasFile('company.logo')) {
			$rules['company.logo'] = 'required|image|mimes:' . getUploadFileTypes('image') . '|max:' . (int)config('settings.upload.max_file_size', 1000);
		}

        if($this->input('company.phone') !== "" && !empty($this->input('company.phone'))){
            $rules['company.phone'] = 'mb_between:5,20|numeric';
        }

        if($this->input('company.fax') !== "" && !empty($this->input('company.fax'))){
            $rules['company.fax'] = "digits_between:2,10";
        }

        if($this->input('company.email') !== "" && !empty($this->input('company.email'))){
            $rules['company.email'] = "email";
        }

        if($this->input('company.website') !== "" && !empty($this->input('company.website'))){
            $rules['company.website'] = "web_domain_valid|whitelist_domain|max:100";
        }

        if ($this->filled('company.facebook')) {
            $rules['company.facebook'] = 'url';
        }

        if ($this->filled('company.twitter')) {
            $rules['company.twitter'] = 'url';
        }


        if ($this->filled('company.linkedin')) {
            $rules['company.linkedin'] = 'url';
        }


        if ($this->filled('company.pinterest')) {
            $rules['company.pinterest'] = 'url';
        }

        
        return $rules;
    }
    
    /**
     * @return array
     */
    public function messages()
    {
        $messages = [];
        
        return $messages;
    }
}
