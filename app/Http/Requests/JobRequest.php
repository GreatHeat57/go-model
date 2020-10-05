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

class JobRequest extends Request {
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		$rules = [
			'name' => 'required|mb_between:2,100|regex:/^[a-zA-Z\s]+$/',
			'email' => 'required|email|whitelist_email|whitelist_domain',
			'company'        => 'required|mb_between:2,200|regex:/^[a-zA-Z0-9\s]+$/',
			'message' => 'required|mb_between:5,500',
			// 'terms' => 'accepted'
			// 'g-recaptcha-response' => (config('settings.security.recaptcha_activation')) ? 'required' : '',
		];
		if (config('settings.security.recaptcha_activation')) {
			$rules['g-recaptcha-response'] = 'required';
		}
		return $rules;
	}

	/**
	 * @return array
	 */
	public function messages() {
		$messages = [];

		return $messages;
	}
}
