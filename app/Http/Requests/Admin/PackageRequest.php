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

namespace App\Http\Requests\Admin;

class PackageRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|min:2|max:255',
            'short_name'    => 'required|min:2|max:255',
            'price'         => 'required|numeric',
            'currency_code' => 'required',
            'tax'           => 'numeric',
            'country_code' => 'required',
            'user_type_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'short_name.required' => 'Short Name is required',
            'price.required' => 'Price is required',
            'currency_code.required' => 'Currency is required',
            'tax.required' => 'Tax is required',
            'country_code.required' => 'Country is required',
            'user_type_id.required' => 'Type is required',
        ];
    }
}
