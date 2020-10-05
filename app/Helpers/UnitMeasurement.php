<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Models\ValidValue;
use App\Models\UserHeightUnitOptions;
use Illuminate\Support\Facades\Log;
use App\Models\Country;
use App\Models\UserDressSizeOptions;
use App\Models\UserWeightUnitsOptions;
use App\Models\UserShoesUnitsOptions;
use App\Models\UserWaistUnitOptions;
use App\Models\UserChestUnitOptions;
use App\Models\UserHipsUnitOptions;


class UnitMeasurement {

	public $country_code;
	public $unit_code;
	public $unit_array = array();
	public $country;
	public $is_standard = 0;
	public $is_men_unit = false;
	public $is_women_unit = false;
	public $is_child_unit = false;

	public function __construct($country_code = null) {
		// check country code is not given then check auth user country and if it is not exists then get default_units_country and if it is also not set then set country code
		

		// $this->country_code = ($country_code) ? $country_code : ( (\Auth::User())? isset(\Auth::User()->country)? \Auth::User()->country->code : config('app.default_units_country')  : ( (config('app.default_units_country'))? config('app.default_units_country') : config('country.locale')));


		if(!empty($country_code)){
			$this->country_code = $country_code;
		}else if(auth()->check() && !empty(auth()->user()->country)){
			$this->country_code = auth()->user()->country->code;
		}elseif (config('app.default_units_country')) {
			$this->country_code = config('app.default_units_country');
		}else{
			$this->country_code = config('country.locale');
		}
 		// based on contry code select country
		$this->country = Country::where('code', strtoupper($this->country_code))->first();
	}

	//public static $height_from = 48; 
	//public static $height_to = 215;

	//public static $weigth_from = 5;
	//public static $weigth_to = 115;

	//public static $dress_size_from = 32;
	//public static $dress_size_to = 164;

	// public static $shoe_size_from = 15;
	// public static $shoe_size_to = 52;

	public static $age_from = 1;
	public static $age_to = 100;

	// public static $chest_from = 65;
	// public static $chest_to = 149;

	// public static $waist_from = 65;
	// public static $waist_to = 149;

	// public static $hips_from = 60;
	// public static $hips_to = 149;

	// height unit (CM)
	public static $CM_unit = 'CM';
	// weight unit (KG)
	public static $KG_unit = 'KG';
	// dress unit (EU)
	public static $EU_unit = 'EU';

	public static $unites = [
		//'height' => [ 'from' => '', 'to' =>  '' ],
		//'weigth' => [ 'from' => '', 'to' =>  '' ],
		//'dress_size' => [ 'from' => '', 'to' =>  '' ],
		// 'shoe_size' => [ 'from' => '', 'to' =>  '' ],
		'age' => [ 'from' => '', 'to' =>  '' ],
		// 'chest' => [ 'from' => '', 'to' =>  '' ],
		// 'waist' => [ 'from' => '', 'to' =>  '' ],
		// 'hips' => [ 'from' => '', 'to' =>  '' ],
	];

	public static function getUnitMeasurement(){

		//self::$unites['height']['from'] = self::$height_from;
		//self::$unites['height']['to'] = self::$height_to;
		//self::$unites['height']['unit'] = self::$CM_unit;

		//self::$unites['weigth']['from'] = self::$weigth_from;
		//self::$unites['weigth']['to'] = self::$weigth_to;
		//self::$unites['weigth']['unit'] = self::$KG_unit;
		
		//self::$unites['dress_size']['from'] = self::$dress_size_from;
		//self::$unites['dress_size']['to'] = self::$dress_size_to;
		//self::$unites['dress_size']['unit'] = self::$EU_unit;
		
		// self::$unites['shoe_size']['from'] = self::$shoe_size_from;
		// self::$unites['shoe_size']['to'] = self::$shoe_size_to;
		// self::$unites['shoe_size']['unit'] = '';

		self::$unites['age']['from'] = self::$age_from;
		self::$unites['age']['to'] = self::$age_to;
		self::$unites['age']['unit'] = '';


		// self::$unites['chest']['from'] = self::$chest_from;
		// self::$unites['chest']['to'] = self::$chest_to;
		// self::$unites['chest']['unit'] = '';

		// self::$unites['waist']['from'] = self::$waist_from;
		// self::$unites['waist']['to'] = self::$waist_to;
		// self::$unites['waist']['unit'] = '';

		// self::$unites['hips']['from'] = self::$hips_from;
		// self::$unites['hips']['to'] = self::$hips_to;
		// self::$unites['hips']['unit'] = '';

		if(count(self::$unites) > 0 ){
			$unitMesArr = array();
			foreach (self::$unites as $key => $value) {
				$unitMesArr[$key] = self::getRangeFromUnits($value['from'], $value['to'], $value['unit']);
			}
			return $unitMesArr;
		}
	}
	
	public static function getRangeFromUnits($fromUnit, $toUnit, $unit){
		$UArray = array();
		
		if(isset(self::$unites['age'])){
			// month array 
			$getMonth = self::getAgeMonth(); 
		}
		
		for ($i=$fromUnit; $i <= $toUnit; $i++) {

			// chek curent unots is age, array push get month array
			if(isset(self::$unites['age'])){ 
				$label = t('years');
				if($i == 1){ $label = t('year'); } 
				$getMonth[$i] = $i.' '.$label;
			}else{

				if(!empty($unit)){
					$UArray[$i] = $i.' '.$unit;
				} else{
					$UArray[$i] = $i;
				}
			}
		}

		if(isset(self::$unites['age'])){
			$UArray = $getMonth;
		}
		return $UArray;
	}

	// get age month 
	public static function getAgeMonth(){
		$arr = array();
		for ($k = 1; $k <= 11; $k = $k + 1) {
			$key = number_format($k/100, 2);
			$label = t('months');
			if($k == 1){ $label = t('month'); }
			$val = str_replace(',', '.', $key);
			$arr[''.trim($val).''] = ltrim(substr($val, strpos($val, '.')), ".0").' '.$label;
		}
		return $arr;
 	}


	// new unit measurement functions start

	/*
	* getUnit return height, weight, dress size, shoe size, age, chest, waist, hips size
	*/
	public function getUnit($allUnit = false, $returnUnitArr = array()){


    	// get old units from the old functions
    	$old_unites = self::getUnitMeasurement();

    	// get height measurement start
    	// $height_unit_code = ( isset($this->country) && !empty($this->country) ) ? (($this->country->height_units !== null && $this->country->height_units !== '')? $this->country->height_units : config('app.default_units_country')) : config('app.default_units_country');

    	if(in_array('height', $returnUnitArr) || $allUnit == true){

			// get height measurement start
			if(isset($this->country) && !empty($this->country) && $this->country->height_units != null && !empty($this->country->height_units)){
	    		$height_unit_code = $this->country->height_units;
	    	}else{
	    		$height_unit_code = config('app.default_units_country');
	    	}
			
			$height = self::getHeight($height_unit_code.config('app.units_alias'));

	    	//replace older heights values array with new array
	    	if( isset($height) && count($height) > 0 ){
	    		$old_unites['height'] = $height;
	    	}
	    }
    	// height measurement end

    	
    	// get dress size measurement start
    	// $dress_size_unit_code = ( isset($this->country) && !empty($this->country) ) ? (($this->country->dress_size_unit !== null && $this->country->dress_size_unit !== "")? $this->country->dress_size_unit : 'standard' ) : 'standard';


    	if(in_array('dress_size', $returnUnitArr) || $allUnit == true){

    		$dress_size_unit_alias = config('app.units_alias');
    		$dress_size_unit_cat_alias = "";
    		
    		$is_dress_unit = false;
    		
    		if($this->is_child_unit != true && $this->is_women_unit == true){
    			$dress_size_unit_cat_alias = config('app.women_alias');
    			$is_dress_unit = true;
    		}

    		if($this->is_child_unit != true && $this->is_men_unit == true){
    			$dress_size_unit_cat_alias = config('app.men_alias');
    			$is_dress_unit = true;
    		}

    		if($this->is_child_unit == true){
    			$dress_size_unit_cat_alias = config('app.kid_alias');
    			$is_dress_unit = true;
    		}

	    	// get dress size measurement start
	    	if(isset($this->country) && !empty($this->country) && $this->country->dress_size_unit != null && !empty($this->country->dress_size_unit)){
	    		$dress_size_unit_code = $this->country->dress_size_unit;
	    	}else{

	    		$dress_size_unit_code = config('app.default_units_country');
	    		// $dress_size_unit_cat_alias = "";
	    	}

	    	// if($this->is_women_unit == false && $this->is_child_unit == false && $this->is_men_unit == false){
	    	// 	$dress_size_unit_code = 'standard';
	    	// }

	    	$dress_size = array();

	    	if($is_dress_unit == true ){
	    		$dress_size = self::getDressSize($dress_size_unit_code.$dress_size_unit_alias.$dress_size_unit_cat_alias);
	    	}

	    	$old_unites['dress_size'] = $dress_size;
			


	    	//replace older heights values array with new array
	    	// if( isset($dress_size) && count($dress_size) > 0 ){
	    	// 	$old_unites['dress_size'] = $dress_size;
	    	// }
	    }

    	// dress size measurement end

    	// get weight measurement start
    	// $weight_unit_code = ( isset($this->country) && !empty($this->country) ) ? (($this->country->weight_units !== null && $this->country->weight_units !== '')? $this->country->weight_units : config('app.default_units_country')) : config('app.default_units_country');
    	
	    if(in_array('weight', $returnUnitArr) || $allUnit == true){
	    	
	    	if(isset($this->country) && !empty($this->country) && $this->country->weight_units != null && !empty($this->country->weight_units)){
	    		$weight_unit_code = $this->country->weight_units;
	    	}else{
	    		$weight_unit_code = config('app.default_units_country');
	    	}

	    	$weight = self::getWeight($weight_unit_code.config('app.units_alias'));


	    	//replace older heights values array with new array
	    	if( isset($weight) && count($weight) > 0 ){
	    		$old_unites['weight'] = $weight;
	    	}
	    }
    	// weight measurement end

	    // shoe size measurement start
    	if(in_array('shoe_size', $returnUnitArr) || $allUnit == true){

    		$shoe_size_unit_alias = config('app.units_alias');
    		$shoe_size_unit_cat_alias = "";

    		$is_shoe_unit = false;
    		
    		if($this->is_child_unit != true && $this->is_women_unit == true){
    			$shoe_size_unit_cat_alias = config('app.women_alias');
    			$is_shoe_unit = true;
    		}

    		if($this->is_child_unit != true && $this->is_men_unit == true){
    			$shoe_size_unit_cat_alias = config('app.men_alias');
    			$is_shoe_unit = true;
    		}

    		if($this->is_child_unit == true){
    			$shoe_size_unit_cat_alias = config('app.kid_alias');
    			$is_shoe_unit = true;
    		}

	    	if(isset($this->country) && !empty($this->country) && $this->country->shoe_units != null && !empty($this->country->shoe_units)){
	    		$shoe_size_unit_code = $this->country->shoe_units;
	    	}else{
	    		$shoe_size_unit_code = config('app.default_units_country');
	    		// $shoe_size_unit_cat_alias = "";
	    	}

	    	// if($this->is_women_unit == false && $this->is_child_unit == false && $this->is_men_unit == false){
	    	// 	$shoe_size_unit_code = 'standard';
	    	// }
	    	$shoe_size = array();
	    	if($is_shoe_unit == true){
	    		$shoe_size = self::getShoeSize($shoe_size_unit_code.$shoe_size_unit_alias.$shoe_size_unit_cat_alias);
	    	}

	    	$old_unites['shoe_size'] = $shoe_size;

	    	// //replace older heights values array with new array
	    	// if( isset($shoe_size) && count($shoe_size) > 0 ){
	    	// 	$old_unites['shoe_size'] = $shoe_size;
	    	// }
	    }
	    // shoe size measurement end

	   	// height measurement end

	   	// waist measurement start
	   	if(in_array('waist', $returnUnitArr) || $allUnit == true){

			// get waist measurement start
			if(isset($this->country) && !empty($this->country) && $this->country->waist_units != null && !empty($this->country->waist_units)){
	    		$waist_unit_code = $this->country->waist_units;
	    	}else{
	    		$waist_unit_code = config('app.default_units_country');
	    	}
			
			$waist = self::getWaist($waist_unit_code.config('app.units_alias'));

	    	//replace older heights values array with new array
	    	if( isset($waist) && count($waist) > 0 ){
	    		$old_unites['waist'] = $waist;
	    	}
	    }
    	// waist measurement end


    	// chest measurement start
	   	if(in_array('chest', $returnUnitArr) || $allUnit == true){

			// get waist measurement start
			if(isset($this->country) && !empty($this->country) && $this->country->chest_units != null && !empty($this->country->chest_units)){
	    		$chest_unit_code = $this->country->chest_units;
	    	}else{
	    		$chest_unit_code = config('app.default_units_country');
	    	}
			
			$chest = self::getChest($chest_unit_code.config('app.units_alias'));

	    	//replace older heights values array with new array
	    	if( isset($chest) && count($chest) > 0 ){
	    		$old_unites['chest'] = $chest;
	    	}
	    }
    	// chest measurement end


    	// hips measurement start
	   	if(in_array('hips', $returnUnitArr) || $allUnit == true){

			// get hips measurement start
			if(isset($this->country) && !empty($this->country) && $this->country->hips_units != null && !empty($this->country->hips_units)){
	    		$hips_unit_code = $this->country->hips_units;
	    	}else{
	    		$hips_unit_code = config('app.default_units_country');
	    	}
			
			$hips = self::getHips($hips_unit_code.config('app.units_alias'));

	    	//replace older heights values array with new array
	    	if( isset($hips) && count($hips) > 0 ){
	    		$old_unites['hips'] = $hips;
	    	}
	    }
    	// hips measurement end

    	return $old_unites;
    }

	/*
	* getHeight return height units from country wise
	* Description: return user height range from combination of country code and unit slug to create column name
	*/
	public static function getHeight($column){
        $units = array();

		try{
        	
        	$units = UserHeightUnitOptions::pluck($column, 'id')->toArray();

        	if(isset($units) && count($units) > 0 ){
	            return $units;
	        }
        }catch(\Exception $e){
        	Log::error($e->getMessage());
        	return $units = [];
        }

        return $units = [];
    }

    /*
	* getDressSize return dress size units from country wise
	* Description: return user dress size from combination of country code and unit slug to create column name
	*/
	public static function getDressSize($column){
        $units = array();

		try{
        	
        	$units = UserDressSizeOptions::whereNotNull($column)->pluck($column, 'id')->toArray();

        	if(isset($units) && count($units) > 0 ){
	            return $units;
	        }
        }catch(\Exception $e){
        	Log::error($e->getMessage());
        	return $units = [];
        }

        return $units = [];
    }

    /*
    * getWeight return weight units from country wise
	* Description: return user weight range from combination of country code and unit slug to create column name
	*/
    public static function getWeight($column){
        $units = array();
        try{
        	
        	$units = UserWeightUnitsOptions::pluck($column, 'id')->toArray();

        	if(isset($units) && count($units) > 0 ){
	            return $units;
	        }
        }catch(\Exception $e){
        	Log::error($e->getMessage());
        	return $units = [];
        }

        return $units = [];
    }

    /*
	* getShoeSize return shoe size units from country wise
	* Description: return user shoe size from combination of country code and unit slug to create column name
	*/
	public static function getShoeSize($column){
        $units = array();

		try{
        	
        	$units = UserShoesUnitsOptions::whereNotNull($column)->pluck($column, 'id')->toArray();

        	if(isset($units) && count($units) > 0 ){
	            return $units;
	        }
        }catch(\Exception $e){
        	Log::error($e->getMessage());
        	return $units = [];
        }

        return $units = [];
    }

    public function getDressSizeByPost(){


    	$dress_size_unit_alias = config('app.units_alias');

		$dress_size_unit_cat_alias = "";

		$is_both = false;
		
		// get dress size measurement start
    	if(isset($this->country) && !empty($this->country) && $this->country->dress_size_unit != null && !empty($this->country->dress_size_unit)){
    		$dress_size_unit_code = $this->country->dress_size_unit;

    		$kid_column = $dress_size_unit_code.$dress_size_unit_alias.config('app.kid_alias');
    		$men_column = $dress_size_unit_code.$dress_size_unit_alias.config('app.men_alias');
			$women_column = $dress_size_unit_code.$dress_size_unit_alias.config('app.women_alias');

    	}else{
    		$dress_size_unit_code = 'standard';
    		$dress_size_unit_cat_alias = "";

    		$kid_column = $dress_size_unit_code.$dress_size_unit_alias;
    		$men_column = $dress_size_unit_code.$dress_size_unit_alias;
			$women_column = $dress_size_unit_code.$dress_size_unit_alias;
    	}	
		
		$units = array();

		$units = UserDressSizeOptions::select('id', $kid_column, $men_column, $women_column)->get();

		$result = array();
		 
		if(!empty($units) && $units->count() > 0){

			foreach ($units as $value) {

				if($value->$men_column != null){
					$result['men_dress'][$value->id] = $value->$men_column;
				}
					
				if($value->$women_column != null){
						 
					$result['women_dress'][$value->id] = $value->$women_column;
				}

				if($value->$kid_column != null){
						 
					$result['baby_dress'][$value->id] = $value->$kid_column;
				}
			}

			return $result;
		}
		return $result;  
    }

    public function getShoeSizeByPost(){


    	$shoe_size_unit_alias = config('app.units_alias');

		$shoe_size_unit_cat_alias = "";

		$is_both = false;
		
		// get shoe size measurement start
    	if(isset($this->country) && !empty($this->country) && $this->country->shoe_units != null && !empty($this->country->shoe_units)){
    		$shoe_size_unit_code = $this->country->shoe_units;

    		$kid_column = $shoe_size_unit_code.$shoe_size_unit_alias.config('app.kid_alias');
    		$men_column = $shoe_size_unit_code.$shoe_size_unit_alias.config('app.men_alias');
			$women_column = $shoe_size_unit_code.$shoe_size_unit_alias.config('app.women_alias');

    	}else{
    		$shoe_size_unit_code = 'standard';
    		$shoe_size_unit_cat_alias = "";

    		$kid_column = $shoe_size_unit_code.$shoe_size_unit_alias;
    		$men_column = $shoe_size_unit_code.$shoe_size_unit_alias;
			$women_column = $shoe_size_unit_code.$shoe_size_unit_alias;
    	}	
		
		$units = array();

		$units = UserShoesUnitsOptions::select('id', $kid_column, $men_column, $women_column)->get();

		$result = array();
		 
		if(!empty($units) && $units->count() > 0){

			foreach ($units as $value) {

				if($value->$men_column != null){
					$result['men_shoe'][$value->id] = $value->$men_column;
				}
					
				if($value->$women_column != null){
						 
					$result['women_shoe'][$value->id] = $value->$women_column;
				}

				if($value->$kid_column != null){
						 
					$result['baby_shoe'][$value->id] = $value->$kid_column;
				}
			} 

			return $result;
		}
		return $result;  
    }

    /*
	* getWaist return waist units from country wise
	* Description: return user waist range from combination of country code and unit slug to create column name
	*/
	public static function getWaist($column){
        $units = array();

		try{
        	
        	$units = UserWaistUnitOptions::orderBy('id')->pluck($column, 'id')->toArray();

        	if(isset($units) && count($units) > 0 ){
	            return $units;
	        }
        }catch(\Exception $e){
        	Log::error($e->getMessage());
        	return $units = [];
        }

        return $units = [];
    }

    /*
	* getChest return chest units from country wise
	* Description: return user chest range from combination of country code and unit slug to create column name
	*/
	public static function getChest($column){
        $units = array();

		try{
        	
        	$units = UserChestUnitOptions::orderBy('id')->pluck($column, 'id')->toArray();

        	if(isset($units) && count($units) > 0 ){
	            return $units;
	        }
        }catch(\Exception $e){
        	Log::error($e->getMessage());
        	return $units = [];
        }

        return $units = [];
    }

    /*
	* getHips return hips units from country wise
	* Description: return user hips range from combination of country code and unit slug to create column name
	*/
	public static function getHips($column){
        $units = array();

		try{
        	
        	$units = UserHipsUnitOptions::orderBy('id')->pluck($column, 'id')->toArray();

        	if(isset($units) && count($units) > 0 ){
	            return $units;
	        }
        }catch(\Exception $e){
        	Log::error($e->getMessage());
        	return $units = [];
        }

        return $units = [];
    }
}
