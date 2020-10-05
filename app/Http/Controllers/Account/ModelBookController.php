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

namespace App\Http\Controllers\Account;

use App\Helpers\UnitMeasurement;
use App\Http\Requests\ModelBookRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\ModelBook;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserType;
use App\Models\ValidValueTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request as RequestFacade;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Http\Request;

class ModelBookController extends AccountBaseController {
	private $perPage = 10;
	public $pagePath = 'model-book';
	public $imageUploadLimit = 30;


	public function __construct() {
		parent::__construct();

		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

		// view()->share('pagePath', $this->pagePath);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {

		if (Auth::User() && Auth::User()->user_type_id != 3) {
			// check permission to allow only for model
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$data = array();

		$imageUploadLimit = $this->imageUploadLimit;
		
		if(Auth::User()->user_register_type == config('constant.user_type_free')){
			$imageUploadLimit = config('constant.free_model_book_upload_limit');
		}	
		
		// Get all User's model book
		$modelbooks = ModelBook::getModelBook(Auth::user()->id, $this->perPage, $count = false);

		
		if($modelbooks->count() == 0 && $modelbooks->currentPage() > 1){
			
			$redirectPage  = $modelbooks->currentPage() - 1;
			
			if($modelbooks->url($redirectPage)){
				
				return redirect($modelbooks->url($redirectPage));
			}
		}
		
		// Get Count of all model book Current user
		$totalCount = ModelBook::getModelBook(Auth::user()->id, $this->perPage, $count = true);
		$data['modelbooks'] = $modelbooks;
		$data['totalCount'] = $totalCount;
		$data['imageUploadLimit'] = $imageUploadLimit;

		// Meta Tags
		MetaTag::set('title', t('My Model Books List - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::get('description');
		CommonHelper::ogMeta();
		
		// return view('account.modelbook.index')->with('modelbooks', $modelbooks);
		return view('model/model-portfolio-edit', $data);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create() {
		// Meta Tags
		MetaTag::set('title', t('Create a modelbook'));
		MetaTag::set('description', t('Create a model book - :app_name', ['app_name' => config('settings.app.name')]));

		if(Auth::user()->user_type_id == 3){
			return view('account.modelbook.create');
		}else{
			flash(t("You don't have permission to open this page"))->error();
			return redirect()->back();
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ModelBookRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(ModelBookRequest $request) {
		

		//check uploaded image is proper and not corrupted
		// if(!$request->file('modelbook.filename')->isValid()){
			
		// 	flash(t("uploaded image is corrupted"))->error();
		// 	return redirect()->back();
		// }

		if(Auth::user()->user_type_id != 3){
			
			flash(t("You don't have permission to open this page"))->error();
			return redirect()->back();
		}

		$modelbook_count = ModelBook::where('user_id', Auth::user()->id)->where('active', 1)->get();

		if (count($request->file('modelbook.filename')) > 5) {

			flash(t("max select image upload valid"))->error();
			return redirect()->back();
			// return redirect(config('app.locale') . '/account/album');
		}

		$totalImageCount = $modelbook_count->count() + count($request->file('modelbook.filename'));

		if ($totalImageCount > 30) {
			
			flash(t("You can upload a maximum of 30 pictures"))->error();
			return redirect()->back();
		}

		if ($request->hasFile('modelbook.filename') && count($request->file('modelbook.filename')) > 0) {
			
			// Create ModelBook
			// $req = $request->all();
			$user_id = Auth::user()->id;

			// Create ModelBook album
			if(!Storage::exists('modelbooks/' . $user_id)){
				Storage::makeDirectory('modelbooks/' . $user_id , 0775, true);
			}


			$name = '';
			if ($request->input('modelbook.name')) {
				$name = $request->input('modelbook.name');
			}

			$count = count($request->file('modelbook.filename'));

			$i = 0;
			$v = 1;
			
			foreach ($request->file('modelbook.filename') as $value) {

				$SaveName = '';

				if (!empty($name)) {

					if ($count > 1) {
						$SaveName = $name . '-' . $v;
					} else {
						$SaveName = $name;
					}
				}

				$image_file = $value;
				$destinationPath = 'uploads/modelbook/' . $user_id;
				$image_name = $image_file->getClientOriginalName();

				// check image oriantation and correct it
				$filename = $image_file->getPathName();
	            CommonHelper::checkImageOriatation($filename);

				$image = value(function () use ($image_file) {
					$filename = str_random(15) . '.' . $image_file->getClientOriginalExtension();
					return strtolower($filename);
				});

				// $image_file         = $request->file('album.filename');
				// $destinationPath    = 'uploads/album/';
				// $image_name         = $image_file->getClientOriginalName();
				// $image              = value(function() use ($image_file){
				//       $filename = str_random(15) . '.' . $image_file->getClientOriginalExtension();
				//         return strtolower($filename);
				// });

				$value->move($destinationPath, $image);
				$filename = 'modelbook/'.$user_id.'/'.$image;
				
				$modelBookInfo[$i] = [

					'country_code' => config('country.code'),
					'user_id' => Auth::user()->id,
					'name' => $SaveName,
					'filename' => $filename,
					'active' => 1,
					'created_at' => date('Y-m-d H:i:s'),
					'updated_at' => date('Y-m-d H:i:s'),
				];

				$i++;
				$v++;
			}


			// Save the ModelBook's File
			$modelBook = ModelBook::insert($modelBookInfo);
			flash(t("Your Picture has added successfully"))->success();
			return redirect()->back();

			// $name = ($request->input('modelbook.name') && !empty($request->input('modelbook.name')))? $request->input('modelbook.name') : '';

			// $modelbookInfo = [
			// 	'country_code' => config('country.code'),
			// 	'user_id' => Auth::user()->id,
			// 	'name' => $name,
			// 	'active' => 1,
			// ];

			// $modelbook = new ModelBook($modelbookInfo);
			// $modelbook->save();

			// // Save the ModelBook's File
			// if ($request->hasFile('modelbook.filename')) {
			// 	$modelbook->filename = $request->file('modelbook.filename');
			// 	$modelbook->save();
			// }

			// flash(t("Your photo has been uploaded successfully"))->success();
			// // return redirect(config('app.locale') . '/account/model-book');
			// return redirect()->back();
		} else {

			flash(t("File is required"))->error();
			return redirect()->back();

			// flash(t("Something went wrong Please try again"))->error();

			// return redirect()->back();

			// flash(t("You can upload a maximum of 30 images to the model book"))->error();
			// // return redirect(config('app.locale') . '/account/model-book');
			// return redirect()->back();
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function show($id) {

		//$modelbooks = ModelBook::where('user_id', $id)->get();

		/*if (isset($modelbooks) && $modelbooks->count() > 0) { 
			foreach ($modelbooks as $key => $modelbook) 
			{
				$image_exist = 0;
	            if ($modelbook->cropped_image == "" && !empty($modelbook->filename) && Storage::exists($modelbook->filename)) {
	                $image_path = \Storage::url($modelbook->filename);
	                $image_exist = 1;
	            }elseif ($modelbook->filename != "" && !empty($modelbook->cropped_image) && Storage::exists($modelbook->cropped_image)){

	                $image_path = \Storage::url($modelbook->cropped_image);
	                $image_exist = 1;
	            }elseif ($modelbook->filename != "" && Storage::exists($modelbook->filename)) {
	                $image_path = \Storage::url($modelbook->filename);
	                $image_exist = 1;
	               
					);
	            }
	            $data[$key]['src']=$image_path;

			}
		}*/

		$modelbook = ModelBook::where('id', $id)->first();
		$title = t('Model Book Photo');

		if(!empty($modelbook)){
			if(isset($modelbook->name) && !empty($modelbook->name)){
				$title = $modelbook->name;
			}
		}

		$data['show_title'] = $title;
		$data['modelbook'] = $modelbook;
		//print json_encode($data);
		return view('childs.img-zoom-popup', $data);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $id
	 * @return $this
	 */
	public function edit($id) {
		// Get the ModelBook
		
		if(Auth::user()->user_type_id != 3){
			flash(t("You don't have permission to open this page"))->error();
			return redirect()->back();
		}

		$modelbook = ModelBook::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

		// Meta Tags
		MetaTag::set('title', t('Edit the model book'));
		MetaTag::set('description', t('Edit the model book - :app_name', ['app_name' => config('settings.app.name')]));
		return view('account.modelbook.edit')->with('modelbook', $modelbook);
	}

	// Genrate Sedcard PDF

	public function genrate($id, ModelBookRequest $request) {
		//$modelbook = $this->modelbooks->paginate($this->perPage);
		if(Auth::user()->user_type_id != 3){
			flash(t("You don't have permission to open this page"))->error();
			return redirect()->back();
		}

		$user_id = $id;
		$modelbook = ModelBook::where('user_id', $user_id)->where('active', 1)->orderBy('id', 'DESC')->paginate($this->perPage);



		$data = array("modelbook" => $modelbook, 'user_id' => $user_id);

		// Meta Tags
		MetaTag::set('title', t('Genrate model-book - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::get('description');
		CommonHelper::ogMeta();

		return view('account.modelbook.genrate')->with('data', $data);
	}

	// to Crop image

	public function cropimg($id, ModelBookRequest $request) {
		
		if(Auth::user()->user_type_id != 3){
			return Array(
				"status" => 'error',
				"message" => t("You don't have permission to open this page"),
			);
		}

		$_POST = $request->all(); // This will get all the request data.

		$imgUrl = $_POST['imgUrl'];
		$user_id = Auth::user()->id;
		$imgUrl = substr($imgUrl , strpos($imgUrl, 'uploads/'));
		
		// original sizes
		$imgInitW = $_POST['imgInitW'];
		$imgInitH = $_POST['imgInitH'];

		Log::info('Image Data Array', ['Image Data Array' => $_POST['imgW'] . " " . $_POST['imgH']]);
		// resized sizes
		$imgW = ($_POST['imgW'] == 'NAN' || $_POST['imgW'] == NAN) ? $imgInitW : $_POST['imgW'];
		$imgH = ($_POST['imgH'] == 'NAN' || $_POST['imgW'] == NAN) ? $imgInitH : $_POST['imgH'];
		// offsets
		$imgY1 = $_POST['imgY1'];
		$imgX1 = $_POST['imgX1'];
		// crop box
		$cropW = $_POST['cropW'];
		$cropH = $_POST['cropH'];
		// rotation angle
		$angle = $_POST['rotation'];

		$jpeg_quality = 100;
		
		$imageDirPath = 'modelbooks/' . $user_id . '/cropimg';
		$imgUrlpath = config('filesystems.default') . '/modelbooks/' . $user_id . '/cropimg';

		if(!Storage::exists($imageDirPath)){
			Storage::makeDirectory($imageDirPath , 0775, true);
		}

		$output_filename = $imgUrlpath . "/croppedImg_" . rand();

		$what = getimagesize($imgUrl);

		switch (strtolower($what['mime'])) {
			case 'image/png':
				$img_r = imagecreatefrompng($imgUrl);
				$source_image = imagecreatefrompng($imgUrl);
				$type = '.png';
				break;
			case 'image/jpeg':
				$img_r = imagecreatefromjpeg($imgUrl);
				$source_image = imagecreatefromjpeg($imgUrl);
				error_log("jpg");
				$type = '.jpeg';
				break;
			case 'image/gif':
				$img_r = imagecreatefromgif($imgUrl);
				$source_image = imagecreatefromgif($imgUrl);
				$type = '.gif';
				break;
			default:die('image type not supported');
		}

		//Check write Access to Directory

		if (!is_writable(dirname($output_filename))) {
			$response = Array(
				"status" => 'error',
				"message" => 'Can`t write cropped File',
			);
		} else {

			// resize the original image to size of editor
			$resizedImage = imagecreatetruecolor($imgW, $imgH);
			imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
			// rotate the rezized image
			$rotated_image = imagerotate($resizedImage, -$angle, imagecolorallocatealpha($resizedImage, 0, 0, 0, 127));
			// find new width & height of rotated image
			$rotated_width = imagesx($rotated_image);
			$rotated_height = imagesy($rotated_image);
			// diff between rotated & original sizes
			$dx = $rotated_width - $imgW;
			$dy = $rotated_height - $imgH;
			if (is_numeric($angle) && $angle != 0) {
				// crop rotated image to fit into original rezized rectangle
				$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
				imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
				imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
				// crop image into selected area
				$final_image = imagecreatetruecolor($cropW, $cropH);
				imagefill($final_image, 0, 0, imagecolorallocatealpha($final_image, 0, 0, 0, 127));
				imagesavealpha($final_image, true);
				//imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
				imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
			} else {
				// crop image into selected area
				$final_image = imagecreatetruecolor($cropW, $cropH);
				imagefill($final_image, 0, 0, imagecolorallocatealpha($final_image, 0, 0, 0, 127));
				imagesavealpha($final_image, true);
				//imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
				imagecopyresampled($final_image, $resizedImage, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
			}
			imagejpeg($final_image, $output_filename . $type, 200);
			$response = Array(
				"status" => 'success',
				"url" => url($output_filename . $type),
			);
			// Updated cropped image in Sedcard
			$modelbook = ModelBook::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
			$imgName = str_replace('uploads/', '', $output_filename);
			$modelbook->cropped_image = $imgName . $type;
			$modelbook->save();
		}

		print json_encode($response);
	}

	// age
	function get_age_vivid($originalDate) {
		$newDate = date("m/d/Y", strtotime($originalDate));
		$birthDate = $newDate;
		//explode the date to get month, day and year
		$birthDate = explode("/", $birthDate);
		//get age from date or birthdate
		$age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
			? ((date("Y") - $birthDate[2]) - 1)
			: (date("Y") - $birthDate[2]));

		return $age;
	}

	// Download PDF
	function downloadsdcard($id, ModelBookRequest $request) {

		$lang = config('app.locale');
		//$uid = Auth::user()->id;
		$uid = $id;
		$age = '';
		$clothing_size = '';
		$eyecolor = '';
		$piercing = '';
		$tattoo = '';
		$haircolor = '';
		$size = '';
		$skincolor = '';
		$shoes_size = '';
		$name = '';
		$email = '';
		$roles = '';
		$firstname = '';
		$go_code = '';
		$height = '';
		$weight = '';
		$city = '';
		$sex = '';
		$profile_image = '';
		$portfolio_images = '';
		$country = '';
		$profile_image_1 = '';
		$empty = '';
		$gender = '';
		$urls = [];
		$city = "";
		$country = "";
		$chest = 0;
		$waist = 0;
		$hips = 0;
		
		$userdata = User::where('id', $uid)->first();
		$file_prefix = 'ModelBook';

		$is_baby_category = false;

		if (isset($userdata->profile) && !empty($userdata->profile)) {

			if(isset($userdata->profile->modelcategory) && $userdata->profile->modelcategory->is_baby_model == 1){
				$is_baby_category = true;
			}
			//$unitArr = UnitMeasurement::getUnitMeasurement();
			
			$unitArr = new UnitMeasurement();
			
			$unitArr->is_women_unit = (config('constant.gender_female') == $userdata->gender_id)? true : false;
			$unitArr->is_men_unit = (config('constant.gender_male') == $userdata->gender_id)? true : false;
			$unitArr->is_child_unit = ($is_baby_category)? true : false;

			$unitoptions = $unitArr->getUnit(true);

			$firstname = ($userdata->profile->first_name)? ucfirst($userdata->profile->first_name) : '';
			$lastname = ($userdata->profile->last_name)? ucfirst($userdata->profile->last_name) : '';

			if($firstname){
				$firstname = (strlen($firstname) > 15) ? substr($firstname,0,15).'..' : $firstname;
			}

			if($lastname){
				$lastname = (strlen($lastname) > 15) ? substr($lastname,0,15).'..' : $lastname;
			}

			$full_name = $firstname;	


			if ($userdata->profile->height_id != 0) {
				
				$height = isset($unitoptions['height'][$userdata->profile->height_id]) ? $unitoptions['height'][$userdata->profile->height_id] : '';
			}
			
			if ($userdata->profile->weight_id != 0) {
				$weight = isset($unitoptions['weight'][$userdata->profile->weight_id]) ? $unitoptions['weight'][$userdata->profile->weight_id] : '';
			}
			

			if ($userdata->profile->size_id != 0) {
				$clothing_size = isset($unitoptions['dress_size'][$userdata->profile->size_id]) ? $unitoptions['dress_size'][$userdata->profile->size_id] : '';
			}

			$eyecolor_data = ValidValueTranslation::where('valid_value_id', $userdata->profile->eye_color_id)->where('locale', $lang)->first();

			if (!empty($eyecolor_data)){
				$eyecolor = $eyecolor_data->value;
			}

			$haircolor_data = ValidValueTranslation::where('valid_value_id', $userdata->profile->hair_color_id)->where('locale', $lang)->first();
			
			if (!empty($haircolor_data)) {
				$haircolor = $haircolor_data->value;
			}

			$skincolor_data = ValidValueTranslation::where('valid_value_id', $userdata->profile->skin_color_id)->where('locale', $lang)->first();
			 
			if (!empty($skincolor_data)) {
				$skincolor = $skincolor_data->value;
			}

			if ($userdata->profile->shoes_size_id != 0) {
				$shoes_size = isset($unitoptions['shoe_size'][$userdata->profile->shoes_size_id]) ? $unitoptions['shoe_size'][$userdata->profile->shoes_size_id] : '';
			}

			// $city_name = City::select('name')->where('id', $userdata->profile->city)->first();

		 // 	if (!empty($city_name)) {
			//  	$city = isset($city_name->name) ? $city_name->name : '';
		 // 	}

		 	if (!empty($userdata->profile->city)) {
				$city_name = explode(',', $userdata->profile->city);
				$city = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $userdata->profile->city;
		 	}

			$piercing = $userdata->profile->piercing;
			if ($piercing == 1) {
				$piercing = t("Yes");
			} else if ($piercing == 2) {
				$piercing = t('No');
			} else {
				$piercing = t('No');
			}

			$tattoo = $userdata->profile->tattoo;

			if ($tattoo == 1) {
				$tattoo = t("Yes");
			} else if ($tattoo == 2) {
				$tattoo = t('No');
			} else {
				$tattoo = t('No');
			}

			if (isset($userdata->profile->birth_day)) {
				$birth_day = $userdata->profile->birth_day;
				// $age = $this->get_age_vivid($birth_day);

				$from = new \DateTime($birth_day);
				$to = new \DateTime('today');
				$pre = "";

				if($from->diff($to)->y > 0 ){
					$age = $from->diff($to)->y;
					($age)? ($age > 1 )? $pre =t('years') : $pre =t('year')  : '';
				}elseif($from->diff($to)->m > 0){
					$age = $from->diff($to)->m;
					($age)? ($age > 1 )? $pre = t('months') : $pre = t('month') : '';
				}else{
					$age = $from->diff($to)->d;
					($age)? ($age > 1 )? $pre = t('days') : $pre = t('day') : '' ;
				}
			}
		}

	 	
		if (!empty($userdata->profile->logo)) {
			$profile_image = $userdata->profile->logo;
			$empty = $profile_image;
		}

		if (!empty($userdata->country_code)) {
			$country = isset($userdata->country_name) ? $userdata->country_name : '';
		}

		if (isset($userdata->profile->chest_id) && $userdata->profile->chest_id != 0) {
			$chest = isset($unitoptions['chest'][$userdata->profile->chest_id]) ? $unitoptions['waist'][$userdata->profile->chest_id] : '';
		}

		if (isset($userdata->profile->waist_id) && $userdata->profile->waist_id != 0) {
			$waist = isset($unitoptions['waist'][$userdata->profile->waist_id]) ? $unitoptions['waist'][$userdata->profile->waist_id] : '';
		}

		if (isset($userdata->profile->hips_id) && $userdata->profile->hips_id != 0) {
			$hips = isset($unitoptions['hips'][$userdata->profile->hips_id]) ? $unitoptions['hips'][$userdata->profile->hips_id] : '';
		}

		$user_data_info = array(
			t('Height') => $height,
			t("Weight") => $weight,
			t("Clothing") => $clothing_size,
			t("Eyecolor") => $eyecolor,
			t("Haircolor") => $haircolor,
			t("Skincolor") => $skincolor,
			t("Shoessize") => $shoes_size,
			t("Breast") => $chest,
			t("Waist") => $waist,
			t("Hips") => $hips,
		);

		//$modelbooks = $this->modelbooks->paginate($this->perPage);
		$modelbooks = ModelBook::where('user_id', $uid)->where('active', 1)->orderBy('id', 'DESC')->get();
		foreach ($modelbooks as $key => $modelbook) {

			if ($modelbook->cropped_image != "") {
				 
				$cropped_image = "";
				if($modelbook->cropped_image !== "" && Storage::exists($modelbook->cropped_image)){
			        $cropped_image = url(config('filesystems.default') . '/' .$modelbook->cropped_image);
			    }else{
			        $cropped_image = url(config('app.cloud_url').'/images/sedcard_img.jpg');
			    }

				$urls[] =  $cropped_image;

			} else {

				$sdfilename = "";
				if($modelbook->filename !== "" && Storage::exists($modelbook->filename)){
			        $sdfilename = url(config('filesystems.default') . '/' .$modelbook->filename);
			    }else{
			        $sdfilename = url(config('app.cloud_url').'/images/sedcard_img.jpg');
			    }

				$urls[] = $sdfilename;
			}
		}

		
		$profile_image = isset($urls[0])? $urls[0] : url(config('app.cloud_url').'/images/sedcard_img.jpg');
		
		$urls = array_values($urls);
		
		//Log::info('Modelbook Array', ['Modelbook Array' => $urls]);
		
		$roles_data = '';
		$roles = "";
		 
		if (!empty($userdata)) {
			$name = $userdata->name;
			$email = $userdata->email;
			$roles_id = $userdata->user_type_id;
			$sex = $userdata->gender_id;
			$roles_data = UserType::where('id', $roles_id)->first();
			$roles = isset($roles_data->name) ? $roles_data->name : '';
			$go_code = $userdata->profile->go_code;
		}

		$gender = "";
		if(isset($userdata->gender_id) && !empty($userdata->gender_id)){
			if( $userdata->gender_id == config('constant.gender_male') ){
				$gender = t('Male');
			}

			if( $userdata->gender_id == config('constant.gender_female') ){
				$gender = t('Female');
			}
		}
		
		// $logo = 'images/logo.png';
		$logo = url(config('app.cloud_url').'/images/logo.png');
		
		//$filename_path = config('filesystems.default') . '/modelbooks/download/' . $filename . '.pdf';
		
		//$mpdf = new \Mpdf\Mpdf();

		//$mpdf->allow_charset_conversion = true;
		//$mpdf->charset_in = 'UTF-8';
		$image_html = '';
		$data_str = '';
		foreach ($user_data_info as $key => $value) {

			$data_str .= '<tr id="profile" style="font-family:work_sansregular,Arial,Tahoma;padding-top:10px;"><td style="font-size: 17px;font-family:work_sans_semi_bold,Arial,Tahoma;padding-top:10px;"><span style="font-family:work_sans_semi_bold,Arial,Tahoma;letter-spacing: 0.1em;  font-size:12px;">' . $key .'</span> </td></tr>
				<tr id="profile"><td style="font-size:12px;font-family:work_sansregular,Arial,Tahoma;"><span style="font-size:12px;list-style-type: disc;"><ul><li>'. $value . '</ul></li></span></td>';
		}

		$html_init = '

		<!DOCTYPE html>
		<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		  <meta charset="UTF-8">
			<style type="text/css">/* Main Body */
		@font-face {
			font-family: \'Open Sans\';
			font-style: normal;
			font-weight: normal;
			src: local(\'Open Sans\'), local(\'OpenSans\'), url(https://themes.googleusercontent.com/static/fonts/opensans/v7/yYRnAC2KygoXnEC8IdU0gQLUuEpTyoUstqEm5AMlJo4.ttf) format(\'truetype\');
		}
		@font-face {
			font-family: \'Open Sans\';
			font-style: normal;
			font-weight: bold;
			src: local(\'Open Sans Bold\'), local(\'OpenSans-Bold\'), url(https://themes.googleusercontent.com/static/fonts/opensans/v7/k3k702ZOKiLJc3WVjuplzMDdSZkkecOE1hvV7ZHvhyU.ttf) format(\'truetype\');
		}
		@font-face {
			font-family: \'Open Sans\';
			font-style: italic;
			font-weight: normal;
			src: local(\'Open Sans Italic\'), local(\'OpenSans-Italic\'), url(https://themes.googleusercontent.com/static/fonts/opensans/v7/O4NhV7_qs9r9seTo7fnsVCZ2oysoEQEeKwjgmXLRnTc.ttf) format(\'truetype\');
		}
		@font-face {
			font-family: \'Open Sans\';
			font-style: italic;
			font-weight: bold;
			src: local(\'Open Sans Bold Italic\'), local(\'OpenSans-BoldItalic\'), url(https://themes.googleusercontent.com/static/fonts/opensans/v7/PRmiXeptR36kaC0GEAetxrQhS7CD3GIaelOwHPAPh9w.ttf) format(\'truetype\');
		}

		body {
			background: #fff;
			color: #000;
			margin: 0cm;
			font-family: \'Open Sans\', sans-serif;
			font-size: 9pt;
			line-height: 100%;

		    /*background-image: url("https://static.go-models.com/ci/sedcard_bg_pdf.jpg");
		     background-position: top center;
		    background-image-resize: 6;*/

		}

		   /* footer {
			position: absolute;
			bottom: -2cm;
			left: 0;
			right: 0;
			height: 4cm; 	text-align: center;
			border-top: 0.1mm solid gray;
			margin-bottom: 0;
			padding-top: 2mm;
		}   */

		    #footer {

			bottom: -5cm;

			}

			img {
				padding-top :5px;
			}
			@page  {
				sheet-size:6in 8.20in;
				margin: 0.7cm  0.7cm 0.7cm 0.7cm !important;
				background: #fff;
			}
	

		 </style>
			
		</head>
		';

		$header = "<tr>
                <th colspan=2 style='text-align:right'>

             </th>
            </tr>
            <tr>
                <td style='padding-top:5px;'>
                    <span style='font-size:18px; font-family:prataregular,Arial,Tahoma;color:#243552;'>";
                    
                    /*if ($firstname != '') {
						$header .= ucfirst($firstname);
					}

					if ($lastname != '') {
						$header .= ' '.ucfirst($lastname);
					}*/

					$header .= $full_name;
					$header.="</span>
                </td>
                <td style='font-family:work_sansregular,arial,tahoma;text-align:right; vertical-align:top; padding-top:12px; line-height: normal;'>
                     <span style='font-size:13px; font-family:work_sansregular,arial,tahoma;'>";
					if ($city != '') {
						$header .= $city;
					}
					if ($country != '') {
						$header .= " - " . $country;
					}

					$header .= "</span>";

					if($go_code != ""){
						$header .= "<br /><span style='font-size:13px; font-family:work_sansregular,arial,tahoma;color:#243552;text-decoration:underline;'>".$go_code."</span>";
					}
                $header .= "</td>
            </tr>
            ";
            $header1 = "<tr style='margin-bottom:10px'>
                <th colspan=2 style='text-align:right'>

             </th>
            </tr>
            <tr>
                <td style='padding-top:5px;'>
                    <span style='font-size:22px; font-family:prataregular,Arial,Tahoma;color:#243552;'>";
                    /*if ($firstname != '') {
						$header1 .= ucfirst($firstname);
					}

					if ($lastname != '') {
						$header1 .= ' '.ucfirst($lastname);
					}*/
					$header .= $full_name;
					$header1.="</span>
                </td>
                <td style='font-family:work_sansregular,arial,tahoma;text-align:right; vertical-align:top;padding-bottom:10px; padding-top:12px; line-height: normal;'>
                     <span style='font-size:18px; font-family:work_sansregular,arial,tahoma;'>";
					if ($city != '') {
						$header1 .= $city;
					}
					if ($country != '') {
						$header1 .= " - " . $country;
					}

					$header1 .= "</span>";

					if($go_code != ""){
						$header1 .= "<br /><span style='font-size:18px; font-family:work_sansregular,arial,tahoma;color:#243552 !important;'>".$go_code."</span>";
					}
                $header1 .= "</td>
            </tr>
            ";

		$subheader= "<tr><td colspan=2 style='margin-top:10px;border-bottom: 1px dotted;padding-top:10px;'></td></tr>";
		$subheader1= "<br><br><tr><td colspan=2 style='border-top: 1px dotted;'></td></tr>";


		$footer ='<tr><td colspan=2 style="border-top: 1px dotted;"></td></tr>
				<tr style="padding-top:10px;">
				<td style="padding-top:10px;width:30%">
					<img src='.$logo.' style="height:25px;">
				</td>
				<td style="padding-top:10px;text-align:right;font-size:12px;font-family:work_sansregular,arial,tahoma;width:70%">
					<span><a style="font-size:12px;font-family:work_sansregular,arial,tahoma;" href="'.config('app.url').'">www.go-models.com</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a style="font-size:12px;font-family:work_sansregular,arial,tahoma;" href="mailto:'.config('app.suppport_email').'">'.config('app.suppport_email').'</a></span>
				</td>
			</tr>
			';

			$footer1 ='<tr width="100%">
		<tr style="padding-top:10px;"><td colspan=2 style="padding-top:30px;border-bottom: 1px dotted;"></td>
				</tr><br>
				<tr style="padding-top:15px;">
				<td style="padding-top:15px;width:30%">
					<img src='.$logo.' style="height:25px;">
				</td>
				<td style="padding-top:15px;text-align:right;font-size:12px;font-family:work_sansregular,arial,tahoma;width:70%">
					<span><a style="font-size:12px;font-family:work_sansregular,arial,tahoma;" href="'.config('app.url').'">www.go-models.com</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a style="font-size:12px;font-family:work_sansregular,arial,tahoma;" href="mailto:'.config('app.suppport_email').'">'.config('app.suppport_email').'</a></span>
				</td>
			</tr>
			';


		$count = count($urls);
		// $baseurl = $uploads['baseurl'].'/';
		//$profile_image = $urls[0];
		$image_html = '<table><tr>';
		$i = 1;
		for ($k = 1; $k <= count($urls) - 1; $k++) {
			$url = $urls[$k];
			$image_html .= "<td  style='padding:15px;'>
        					<div style='margin:10px;'>
        					<img style='object-fit: cover;margin:8px; max-height: 100%;
                            max-width: 100%;
                            width: auto;
                            height: auto;' src='$url'>
        					 </div>
        				</td>";
			if ($i % 4 == 0) {
				$image_html .= '</tr><tr>';
			}
			$i++;

		}
		$image_html .= '</tr></table>';

		$final_html = '';
		$final_html .= $html_init;

		$pages = $header;
		$pages .= $subheader1;
		$pages .= "<table width='100%' ><tr width='100%'>
 				   <td width='30%'><table id='profiletable'  width='100%'> <tr width='100%' style='padding-bottom:20px;text-align:left;'> {$data_str} </tr></table></td>
 					<td width='70%' valign='top' style='height:500px; text-align:right;'><img style='object-fit: contain;padding-top:20px;' src='$profile_image' height='456px' max-width='360px'   max-height='500px' /></td>
 					<tr></table>";

		$final_html .= '<table style="width:100%">';
		$final_html .= $pages;
		$final_html .= "<tr>";
		$final_html .= "<td colspan='2'></td>";
		//  $final_html.="<td colspan='2'>{$image_html}</td>";

		$final_html .= "<tr>";
		$final_html .= $footer1;
		$final_html .= '</table>';
		//$final_html .= $newfooter1;

		if (count($urls) > 1) # only break if user has a gallery
		{
			$final_html .= "<pagebreak />";
		}

		for ($i = 1; $i < count($urls); $i++) {

			$src = $urls[$i];

			if (!empty($src) && @getimagesize($src)) {
				$final_html .= '<table align="center"  style="width:100%">';
				$final_html .= $header;
				$final_html .= $subheader1;
				$final_html .= "<tr>
                    <td colspan=2 align='center' style='height: 570px'>
                    <div style=''>
                    <img src ='$src' style='
                            max-width: 100%;
                            width: auto;
                            height: 500px;
                            position: absolute;
                            top: 0;
                            bottom: 0;
                            left: 0;
                            right: 0;
                            margin: auto;'/>
                    </div>
                    </td>
                    </tr>";
                    $final_html .= $footer;
				$final_html .= '</table>';
				if ($i != count($urls) - 1) {
					$final_html .= "<pagebreak />";
				}
			}

		}

		$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];

		$mpdf = new \Mpdf\Mpdf([
		    'fontDir' => array_merge($fontDirs, [
		        base_path().'/public/fonts/sedcardpdf',
		    ]),
		    'fontdata' => $fontData + [
		        'work_sansbold' => [
		            'R' => 'WorkSans-Bold.ttf'
		        ],
		        'work_sansregular' => [
					'R' => 'WorkSans-Regular.ttf',
		        ],
		        'work_sans_semi_bold' => [
					'R' => 'WorkSans-SemiBold.ttf',
		        ],
		        'prataregular' => [
		            'R' => 'Prata-Regular.ttf',
		        ]
		    ],
		    'default_font' => 'work_sansregular',
		    'mode' => 'utf-8', 'format' => 'A4-P',
		]);

		$filename = $file_prefix.''.$uid.''.$name;
		$filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $filename);

		$path = config('filesystems.default') . '/modelbooks/download/';
		// check folder is exist, if no create download folder
		File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

		$filename_path = config('filesystems.default') . DIRECTORY_SEPARATOR.'modelbooks'.DIRECTORY_SEPARATOR.'download'.DIRECTORY_SEPARATOR. $filename . '.pdf';

		// $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);

		// echo  $final_html;die;
		//$mpdf->SetHTMLFooter($footer, 'O');
		//$mpdf->SetHTMLFooter($footer, 'E');

		// $mpdf->SetDisplayMode('fullpage');

		$mpdf->mirrorMargins = true;
		if (file_exists($filename_path)) {
			unlink($filename_path);
		}

		$mpdf->SetDisplayMode('fullpage', 'two');
		$final_html = mb_convert_encoding($final_html, 'UTF-8', 'UTF-8');
		$mpdf->WriteHTML($final_html);
		$mpdf->Output($filename_path, 'F');

		//if ($fd = fopen($filename_path, "r")) {
			$fsize = filesize($filename_path);
			$path_parts = pathinfo($filename_path);
			$ext = strtolower($path_parts["extension"]);
			
			// switch ($ext) {
			// case "pdf":
			// 	header("Content-type: application/octet-stream");
			// 	header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\""); // use 'attachment' to force a file download
			// 	break;
			// // add more headers for other content types here
			// default;
			// 	header("Content-type: application/octet-stream");
			// 	header("Content-Disposition: filename=\"" . $path_parts["basename"] . "\"");
			// 	break;
			// }

			header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\"");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");
			header("Content-Description: File Transfer");
			header("Content-length: $fsize");
			header("Cache-control: private"); //use this to open files directly
			//ob_clean();
			flush();
			$fd = fopen($filename_path, "r");
			while (!feof($fd)) {
				$buffer = fread($fd, 65536);
				echo $buffer;
			}
		//}
		fclose($fd);
		exit;
	}
	/**
	 * Update the specified resource in storage.
	 *
	 * @param $id
	 * @param ModelBookRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update($id, ModelBookRequest $request) {
		// Get ModelBook
		if(Auth::user()->user_type_id == 2){
			flash(t("You don't have permission to open this page"))->error();
			return redirect()->back();
		}

		$modelbook = ModelBook::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
		$user_id = Auth::user()->id;

		$req = $request->all();

		try {

			if($request->file('modelbook.filename') !== null){
				if (!$request->file('modelbook.filename')->isValid()){
					flash(t("uploaded image is corrupted"))->error();
					return redirect()->back();
				}
			}
		} catch (Exception $e) { }

		$name = ($request->input('modelbook.name') && !empty($request->input('modelbook.name')))? $request->input('modelbook.name') : '';

		$modelbook->name = $name;
		$modelbook->save();

		// Save the ModelBook's File
		if ($request->hasFile('modelbook.filename')) {

			$old_image = $modelbook->filename;
			$old_crop_image = $modelbook->cropped_image;

			$modelbook->cropped_image = NULL;
			$modelbook->filename = $request->file('modelbook.filename');
			$modelbook->save();
			if(Storage::exists($old_crop_image)){
				Storage::delete($old_crop_image);
			}
		}

		// Message Notification & Redirection
		flash(t("Your photo has been updated successfully"))->success();
		return redirect(config('app.locale') . '/' . trans('routes.model-portfolio-edit'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param null $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy($id = null, Request $request) {

		// Get Entries ID

		if(Auth::user()->user_type_id == config('constant.partner_type_id')){
			flash(t("You don't have permission to open this page"))->error();
			return redirect()->back();
		}
		
		$ids = [];
		if (RequestFacade::filled('entries')) {
			$ids = RequestFacade::input('entries');
		} else {
			if (!is_numeric($id) && $id <= 0) {
				$ids = [];
			} else {
				$ids[] = $id;
			}
		}
		// Delete
		$nb = 0;
		$userid = Auth::user()->id;
		foreach ($ids as $item) {
			$modelbook = ModelBook::where('id', $item)->where('user_id', Auth::user()->id)->first();
			if (!empty($modelbook)) {
				$nb = $modelbook->delete();
			}
		}

		$status = false;
		// Confirmation
		if ($nb == 0) {
			
			flash(t("No deletion is done, Please try again"))->error();
			$message = t('No deletion is done, Please try again');
		} else {
			
			$count = count($ids);
			
			if ($count > 1) {
				
				flash(t("Your photos have been deleted successfully"))->success();
			} else {
				$status = true;
				// flash(t("Your photo has been deleted successfully"))->success();
				$message = t('Your photo has been deleted successfully');
			}
		}

		if ($request->ajax()) {

			// Get Count of all model book Current user
			$totalCount = ModelBook::getModelBook(Auth::user()->id, null, $count = true);

			$returnUrl = '';
			if($totalCount == 0){

				$returnUrl = trans('routes.model-portfolio-edit');
			}

			$response = array('status' => $status, 'message' => $message, 'returnUrl' => $returnUrl);
			return response()->json($response);
		}
		
		return redirect(lurl(trans('routes.model-portfolio-edit')));

		// return redirect()->back();
		// return redirect(config('app.locale') . '/account/model-book');
	}
	public function getModelBookAjaxCall(Request $request){

		$data = [];
		$returnHTML = '';

		if($request->input('user_id') && !empty($request->input('user_id'))){
			$user = User::withoutGlobalScopes([VerifiedScope::class])->find($request->input('user_id'));
		
			$modelbooks = ModelBook::where('user_id', $request->input('user_id'))->orderBy('id', 'DESC')->offset(12)->limit(30)->get();

			$data['user_id'] = $request->input('user_id');
			$data['user'] = $user;
			$data['modelbooks'] = $modelbooks;
			$data['is_load_more_modelbook'] = false;
			
			$returnHTML = view('model.inc.model-book-list' , $data)->render();
			// return response()->json(array('success' => true, 'html'=> $returnHTML));
		} 

		return response()->json(array('success' => true, 'html'=> $returnHTML));
	}

	/*
	* Description: return slider popup images with selected image show first.
	* @param $id, $user_id
 	*/
 	
	public function showGallery($id, $user_id){
        
        $imageArr = $selectedImg = array();

        if(isset($id) && isset($user_id) &&!empty($id) && !empty($user_id)){
        
            $modelbooks = ModelBook::where('user_id', $user_id)->get()->toArray();
            
         	if(isset($modelbooks) && count($modelbooks) > 0 ){

             	foreach ($modelbooks as $key => $modelbooks_data) {

                 	if(isset($modelbooks_data['id']) && $modelbooks_data['id'] == $id){

                     	if (isset($modelbooks_data['cropped_image']) && $modelbooks_data['cropped_image'] != ""  && Storage::exists($modelbooks_data['cropped_image'])){

                     		$selectedImg['src'] = \Storage::url($modelbooks_data['cropped_image']);

                     	}elseif (isset($modelbooks_data['filename']) && $modelbooks_data['filename'] != ""  && Storage::exists($modelbooks_data['filename'])){

                     		$selectedImg['src'] = \Storage::url($modelbooks_data['filename']);

                     	}else{

                     		$selectedImg['src'] = config('app.cloud_url').'/uploads/app/default/picture.jpg';
                     	}
                     	                       
                        $selectedImg['titel'] = $modelbooks_data['name'];
					}
					else{

                     	if (isset($modelbooks_data['cropped_image']) && $modelbooks_data['cropped_image'] != ""  && Storage::exists($modelbooks_data['cropped_image'])){

                     		 $imageArr[$key]['src'] = \Storage::url($modelbooks_data['cropped_image']);

                     	}elseif (isset($modelbooks_data['filename']) && $modelbooks_data['filename'] != ""  && Storage::exists($modelbooks_data['filename'])){

                     		 $imageArr[$key]['src'] = \Storage::url($modelbooks_data['filename']);

                     	}else{

                     		$imageArr[$key]['src'] = config('app.cloud_url').'/uploads/app/default/picture.jpg';
                     	}

                        $imageArr[$key]['titel'] = $modelbooks_data['name'];
                 	}
                }
         	}

         	array_unshift($imageArr, $selectedImg);
            return response()->json(array('success' => true, 'imageArr'=> $imageArr));
        }
        return response()->json(array('success' => false, 'imageArr'=> $imageArr));
    }

}
