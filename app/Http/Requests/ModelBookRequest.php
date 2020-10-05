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

class ModelBookRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Validation Rules
        $rules = [];


        // $rules = ['album.filename.*' => 'required|mimes:' . getUploadFileTypes('image') . '|max:' . (int) config('settings.upload.max_file_size', 1000)];

        // $messages = ['album.filename.*.required' => t("Please upload an image"),
        //     'album.filename.*.mimes' => t("image extension valid"),
        //     'album.filename.*.max' => t("max file size valid"),
        // ];

        // Check 'modelbook' is required
        if ($this->hasFile('modelbook.filename')) {
            $rules['modelbook.filename.*'] = 'required|mimes:' . getUploadFileTypes('image') . '|max:' . (int)config('settings.upload.max_file_size', 1000);
        }
        return $rules;
    }
    
    /**
     * @return array
     */
    public function messages()
    {
        // $messages = [];

        $messages = [

                    'modelbook.filename.*.required' => t("Please upload an image"),
                    'modelbook.filename.*.mimes' => t("image extension valid"),
                    'modelbook.filename.*.max' => t("max file size valid"),
                ];
        return $messages;
    }
}
