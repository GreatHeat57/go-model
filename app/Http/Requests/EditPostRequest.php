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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class EditPostRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$cat = null;

		$rules = [
			'post_type' => 'required|not_in:0',
			'title' => 'required|whitelist_word_title',
			'description' => 'required|mb_between:100,6000|whitelist_word',
			// 'salary_type'  => 'required|not_in:0',
			'contact_name' => 'required|mb_between:2,200',
			'email' => 'max:100|whitelist_email|whitelist_domain',
			// 'phone' => 'max:20',
			// 'phone' => 'nullable|numeric|digits:10',
			// 'city' => 'required|not_in:0',
			// 'experience_type' => 'required|not_in:0',
			'gender_type' => 'required',
			'parent' => 'required|not_in:0',
			// 'country' => 'required',
			// 'city' => 'required',
			'end_application' => 'required',
		];

		if (!Gate::allows('free_country_user', auth()->user())) {
			$rules['country'] = 'required';
			$rules['city'] = 'required';
        }

		// CREATE
		if (in_array($this->method(), ['POST', 'CREATE'])) {
			// $rules['parent'] = 'required|not_in:0';

			// Recaptcha
			// if (config('settings.security.recaptcha_activation')) {
			// 	$rules['g-recaptcha-response'] = 'required';
			// }
		}

		if ($this->filled('ismodel') && $this->input('ismodel') == 1) {

			$rules['modelCategory'] = 'required|not_in:0';
			 
			// if ($this->filled('is_baby') && $this->input('is_baby') == 1) {
				
			// 	$rules['babyDressSize'] = 'required|not_in:0';
			// }

			$model_cat = false;
			
			if($this->input('is_model_category') && $this->input('is_model_category') == 1){
				$model_cat = true;
			}
			
			// dress size required comments #01-09-2020 #AJ
			// if($this->filled('gender_type') && $this->input('gender_type') == config('constant.gender_male')  && $model_cat == true){
			// 	$rules['menDressSize'] = 'required|not_in:0';
			// }else if ($this->filled('gender_type') && $this->input('gender_type') == config('constant.gender_female')  && $model_cat == true) {
			// 	$rules['womenDressSize'] = 'required|not_in:0';
			// }else{
				
			// 	if($model_cat == true){
			// 		$rules['womenDressSize'] = 'required|not_in:0';
			// 		$rules['menDressSize'] = 'required|not_in:0';
			// 	}
			// }

			// $rules['modelCategory'] = 'required|not_in:0';
			// $rules['height_from'] = 'required|not_in:0';
			// $rules['height_to'] = 'required|not_in:0';
			// $rules['weight_from'] = 'required|not_in:0';
			// $rules['weight_to'] = 'required|not_in:0';
			$rules['age_from'] = 'required|not_in:0';
			$rules['age_to'] = 'required|not_in:0';
			// $rules['dressSize_from'] = 'required|not_in:0';
			// $rules['dressSize_to'] = 'required|not_in:0';
		} else {
			$rules['branch'] = 'required|not_in:0';
		}

		if ($this->filled('salary_min')) {
			$rules['salary_min'] = 'numeric';
		}

		if ($this->filled('salary_max')) {
			$rules['salary_max'] = 'numeric';
		}

		// if ($this->filled('start_date')) {
		// 	$rules['start_date'] = 'required|date';
		// }

		// if ($this->filled('is_one_day') && $this->input('is_one_day') != 1) {
		// 	$rules['end_date'] = 'required|date|after_date:start_date';
		// }

		if($this->input('is_date_announce') != 1){
			
			$rules['start_date'] = 'required|date';

			if ($this->filled('is_one_day') && $this->input('is_one_day') != 1) {
				
				$rules['end_date'] = 'required|date|after_date:start_date';
			}
		}
		// UPDATE
		// if (in_array($this->method(), ['PUT', 'PATCH', 'UPDATE'])) {}

		// COMMON

		// Location
		if (in_array(config('country.admin_type'), ['1', '2']) && config('country.admin_field_active') == 1) {
			$rules['admin_code'] = 'required|not_in:0';
		}

		// Email
		if ($this->filled('email')) {
			$rules['email'] = 'email|' . $rules['email'];
		}
		if (isEnabledField('email')) {
			if (isEnabledField('phone') && isEnabledField('email')) {
				if (Auth::check()) {
					$rules['email'] = 'required_without:phone|' . $rules['email'];
				} else {
					// Email address is required for Guests
					$rules['email'] = 'required|' . $rules['email'];
				}
			} else {
				$rules['email'] = 'required|' . $rules['email'];
			}
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
		// if (isEnabledField('phone')) {
		// 	if (isEnabledField('phone') && isEnabledField('email')) {
		// 		$rules['phone'] = 'required_without:email|' . $rules['phone'];
		// 	} else {
		// 		$rules['phone'] = 'required|' . $rules['phone'];
		// 	}
		// }

		// Company
		if (!$this->filled('company_id') || empty($this->input('company_id')) || $this->input('company_id') == 0) {
			$rules['company.name'] = 'required|mb_between:2,200|whitelist_word_title';
			$rules['company.description'] = 'required|mb_between:100,1000|whitelist_word';

			// Check 'logo' is required
			if ($this->file('company.logo')) {
				$rules['company.logo'] = 'required|image|mimes:' . getUploadFileTypes('image') . '|max:' . (int) config('settings.upload.max_file_size', 1000);
			}
		} else {
			$rules['company_id'] = 'required|not_in:0';
		}

		// Application URL
		if ($this->filled('application_url')) {
			$rules['application_url'] = 'url';
		}

		/*
			 * Tags (Only allow letters, numbers, spaces and ',;_-' symbols)
			 *
			 * Explanation:
			 * [] 	=> character class definition
			 * p{L} => matches any kind of letter character from any language
			 * p{N} => matches any kind of numeric character
			 * _- 	=> matches underscore and hyphen
			 * + 	=> Quantifier — Matches between one to unlimited times (greedy)
			 * /u 	=> Unicode modifier. Pattern strings are treated as UTF-16. Also causes escape sequences to match unicode characters
		*/
		if ($this->filled('tags')) {
			$rules['tags'] = 'regex:/^[\p{L}\p{N} ,;_-]+$/u';
		}

		if( $this->filled('salary_max') && $this->filled('salary_min') ){
			$rules['salary_max'] = 'greater_than:salary_min|not_in:0|required';
		}

		if( $this->filled('weight_from') && $this->filled('weight_to') ){
			$rules['weight_to'] = 'greater_than:weight_from|not_in:0|required';
		}

		if( $this->filled('age_from') && $this->filled('age_to') ){
			$rules['age_to'] = 'greater_than:age_from|not_in:0|required';
		}

		if( $this->filled('height_from') && $this->filled('height_to') ){
			$rules['height_to'] = 'greater_than:height_from|not_in:0|required';
		}

		// if( $this->filled('dressSize_from') && $this->filled('dressSize_to') ){
		// 	$rules['dressSize_to'] = 'greater_than:dressSize_from|not_in:0|required';
		// }

		if( $this->filled('chest_to') ){
			$rules['chest_from'] = 'not_in:0|required';
		}

		if( $this->filled('chest_from') ){
			$rules['chest_to'] = 'not_in:0|required';
		}

		if( $this->filled('chest_from') && $this->filled('chest_to') ){
			$rules['chest_to'] = 'greater_than:chest_from|not_in:0|required';
		}

		if( $this->filled('waist_to') ){
			$rules['waist_from'] = 'not_in:0|required';
		}

		if( $this->filled('waist_from') ){
			$rules['waist_to'] = 'not_in:0|required';
		}


		if( $this->filled('waist_from') && $this->filled('waist_to') ){
			$rules['waist_to'] = 'greater_than:waist_from|not_in:0|required';
		}

		if( $this->filled('hips_to') ){
			$rules['hips_from'] = 'not_in:0|required';
		}

		if( $this->filled('hips_from') ){
			$rules['hips_to'] = 'not_in:0|required';
		}

		if( $this->filled('hips_from') && $this->filled('hips_to') ){
			$rules['hips_to'] = 'greater_than:hips_from|not_in:0|required';
		}

		// if( $this->filled('shoeSize_to') ){
		// 	$rules['shoeSize_from'] = 'not_in:0|required';
		// }

		// if( $this->filled('shoeSize_from') ){
		// 	$rules['shoeSize_to'] = 'not_in:0|required';
		// }

		// if( $this->filled('shoeSize_from') && $this->filled('shoeSize_to') ){
		// 	$rules['shoeSize_to'] = 'greater_than:shoeSize_from|not_in:0|required';
		// }

		return $rules;
	}

	/**
	 * @return array
	 */
	public function messages() {
		
		$messages = [
			'end_date.after_date' => trans('validation.previus_end_date_validation')
			// 'modelCategory.required' => 'The sub category field is required',
			// 'branch.required' => 'The sub category field is required',
			// 'parent.required' => 'The category field is required',
		];
		return $messages;
	}
}
