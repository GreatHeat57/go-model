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

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\UnitMeasurement;
use App\Models\ModelCategory;

class UnitsController extends FrontController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAjaxUnits(Request $request)
    {           
        $unitArr = array();
        $allUnits = false;

        $category_id = '';
        $gender = '';
        $country_code = "";

        if(isset($request->allUnits)){
            $allUnits = true;
        }

        if(isset($request->height)){
            $unitArr[] = 'height';
        }

        if(isset($request->weight)){
            $unitArr[] = 'weight';
        }

        if(isset($request->dress_size)){
            $unitArr[] = 'dress_size';
        }

        if(isset($request->shoe_size)){
            $unitArr[] = 'shoe_size';
        }

        if(isset($request->waist_size)){
            $unitArr[] = 'waist_size';
        }

        if(isset($request->chest_size)){
            $unitArr[] = 'chest_size';
        }

        if(isset($request->hips_size)){
            $unitArr[] = 'hips_size';
        }

        if(isset($request->category_id)){
            $category_id = $request->category_id;
        }

        if(isset($request->gender)){
           $gender = $request->gender;
        }

        if(isset($request->country_code)){
           $country_code = $request->country_code;
        }

        if(isset($country_code) && !empty($country_code) ){
            $units = new UnitMeasurement($country_code);
        }else{
            $units = new UnitMeasurement();
        }

        if(isset($category_id) && !empty($category_id) ){
            
            $modelCategory = ModelCategory::select('id','translation_of','is_baby_model')->where('id', $category_id)->first();

            if(isset($modelCategory->is_baby_model)){

                if($modelCategory->is_baby_model == 1){
                    $units->is_child_unit = true;
                }
            }
        }

        if( isset($gender) && !empty($gender) ){
            switch ($gender) {
                case config('constant.gender_male'):
                    $units->is_men_unit = true;
                    $units->is_women_unit = false;
                    break;
                case config('constant.gender_female'):
                    $units->is_women_unit = true;
                    $units->is_men_unit = false;
                    break;
                default:
                    $units->is_men_unit = $units->is_women_unit = false;
            }
        }

        /*
            function : getUnit 

            param 1 : get all record in array (true, false)
            param 1 : set default (false)
            param 2 : set specific record key in array like, height, weight, dress_size, shoes_size, waist_size, chest_size, hips_size
        */
       
        $status = ['success' => true, 'data' => $units->getUnit($allUnits, $unitArr)];
        return response($status);
    }
}
