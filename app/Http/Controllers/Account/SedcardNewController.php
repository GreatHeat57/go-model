<?php

namespace App\Http\Controllers\Account;

use App\Helpers\UnitMeasurement;
use App\Http\Controllers\Controller;
use App\Http\Requests\SedcardRequest;
use App\Models\Sedcard;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\ValidValueTranslation;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Validator;
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Storage;
use App\Models\City;
use App\Models\Country;
use PDF;


class SedcardNewController extends AccountBaseController {
	private $perPage = 10;
	public $pagePath = 'sedcards';

	public function __construct() {
		parent::__construct();

		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

		view()->share('pagePath', $this->pagePath);
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
		// Get all User's sedcard
		//$sedcards = $this->sedcards->paginate($this->perPage);
		$sedcards = Sedcard::where('user_id', Auth::user()->id)->orderby("image_type", "ASC")->paginate($this->perPage);

		// die();
		// if(isset(var))
		$index = array(1, 2, 3, 4, 5);
		$sed = array();
		$ids = array();
		foreach ($sedcards as $key => $sedcard) {
			$sed[$sedcard->image_type] = array("id" => $sedcard->id,
				"cropped_image" => $sedcard->cropped_image,
				"filename" => $sedcard->filename,
				"image_type" => $sedcard->image_type,
				"user_id" => $sedcard->user_id,
				"active" => $sedcard->active,
			);
			$ids[] = $sedcard->image_type;
		}

		$results = array_diff($index, $ids);
		foreach ($results as $key => $result) {
			$sed[$result] = array("id" => 0,
				"cropped_image" => "",
				"filename" => "",
				"image_type" => $result,
				"user_id" => Auth::user()->id,
				"active" => 0,
			);
		}
		ksort($sed);

		$data[] = $sedcards;
		$data[] = $sed;

		// Meta Tags
		MetaTag::set('title', t('My Sedcards List - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My Sedcards List - :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		/*count sedcard*/
		$sedcard = Sedcard::where('user_id', Auth::id())->count();
		$data[] = $sedcard;
		if ($sedcard == 0) {
			$countSedcard = '1';
		} else {
			$countSedcard = $sedcard + 1;
		}

		// set sedcard title and descriptions based on model category slug
		$model_category_slug = "";
		if(isset(Auth::user()->profile) && isset(Auth::user()->profile->modelcategory)){
			$model_category_slug = Auth::user()->profile->modelcategory->slug;
		}

		$sedcard_desc = array();
		
		$sedcard_desc['sedcard_title_1'] = (trans('global.'.$model_category_slug.'-sedcard-title-1') !== 'global.'.$model_category_slug.'-sedcard-title-1')? trans('global.'.$model_category_slug.'-sedcard-title-1') : trans('global.Portrait photo');

		$sedcard_desc['sedcard_title_2'] = (trans('global.'.$model_category_slug.'-sedcard-title-2') !== 'global.'.$model_category_slug.'-sedcard-title-2')? trans('global.'.$model_category_slug.'-sedcard-title-2') : trans('global.Full body photo');

		$sedcard_desc['sedcard_title_3'] = (trans('global.'.$model_category_slug.'-sedcard-title-3') !== 'global.'.$model_category_slug.'-sedcard-title-3')? trans('global.'.$model_category_slug.'-sedcard-title-3') : trans('global.Beauty Shot');

		$sedcard_desc['sedcard_title_4'] = (trans('global.'.$model_category_slug.'-sedcard-title-4') !== 'global.'.$model_category_slug.'-sedcard-title-4')? trans('global.'.$model_category_slug.'-sedcard-title-4') : trans('global.Outfit');

		$sedcard_desc['sedcard_title_5'] = (trans('global.'.$model_category_slug.'-sedcard-title-5') !== 'global.'.$model_category_slug.'-sedcard-title-5')? trans('global.'.$model_category_slug.'-sedcard-title-5') : trans('global.Free choice');


		$sedcard_desc['sedcard_description_1'] = (trans('global.'.$model_category_slug.'-sedcard-description-1') !== 'global.'.$model_category_slug.'-sedcard-description-1')? trans('global.'.$model_category_slug.'-sedcard-description-1') : trans('global.upload portrait instruction');

		$sedcard_desc['sedcard_description_2'] = (trans('global.'.$model_category_slug.'-sedcard-description-2') !== 'global.'.$model_category_slug.'-sedcard-description-2')? trans('global.'.$model_category_slug.'-sedcard-description-2') : trans('global.whole body instruction');

		$sedcard_desc['sedcard_description_3'] = (trans('global.'.$model_category_slug.'-sedcard-description-3') !== 'global.'.$model_category_slug.'-sedcard-description-3')? trans('global.'.$model_category_slug.'-sedcard-description-3') : trans('global.beauty photo instruction');

		$sedcard_desc['sedcard_description_4'] = (trans('global.'.$model_category_slug.'-sedcard-description-4') !== 'global.'.$model_category_slug.'-sedcard-description-4')? trans('global.'.$model_category_slug.'-sedcard-description-4') : trans('global.outfit instruction');

		$sedcard_desc['sedcard_description_5'] = (trans('global.'.$model_category_slug.'-sedcard-description-5') !== 'global.'.$model_category_slug.'-sedcard-description-5')? trans('global.'.$model_category_slug.'-sedcard-description-5') : trans('global.free choice instruction');

		// return view('account.sedcard.index')->with([
		// 	'data' => $data,
		// 	'user' => Auth::user(),
		// 	'countSedcard' => $countSedcard]);


		return view('model/model-sedcard-edit')->with([
			'data' => $data,
			'user' => Auth::user(),
			'countSedcard' => $countSedcard,
			'sedcard_desc' => $sedcard_desc
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create($id, SedcardRequest $request) {

		// Meta Tags
		MetaTag::set('title', t('Create a sedcard'));
		MetaTag::set('description', t('Create a sedcard - :app_name', ['app_name' => config('settings.app.name')]));

		return view('account.sedcard.create')->with('id', $id);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param SedcardRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request) {

		$req = $request->all();

		$sedcard_count = Sedcard::where('user_id', Auth::user()->id)->pluck('id', 'image_type')->toArray();

		$imagefound = $sedcardexists = $image_error = false;
		
		if(isset($req['sedcard']) && count($req['sedcard']) > 0 ){

			foreach ($req['sedcard'] as $key => $value) {

				//check image is not currepted
				if(!$request->file('sedcard.' . $key)->isValid()){
					$image_error = true;
					$error_file_name[] = $request->file('sedcard.' . $key)->getClientOriginalName();

				} else {

					if ($request->hasFile('sedcard.' . $key)) {
						
						$id = explode('filename', $key);
						
						if($id){
							$id = $id[count($id)-1];
						}
						
						$imagefound = true;
						$secardInfo = array(
							'country_code' => Auth::user()->country_code,
							'user_id' => Auth::user()->id,
							'name' => $request->file('sedcard.' . $key)->getClientOriginalName(),
							'image_type' => $id,
							// 'active' => 1,
						);
						
						if(array_key_exists($id, $sedcard_count)){ 
							$sedcardexists = true;
							
							$sedcard = Sedcard::where('user_id', Auth::user()->id)->where('image_type', $id)->first();

							$sedcard->name = $secardInfo['name'];
							$sedcard->image_type = $secardInfo['image_type'];
							$sedcard->filename = $request->file('sedcard.' . $key);

						}else{
							$sedcard = new Sedcard($secardInfo);
							$sedcard->filename = $request->file('sedcard.' . $key);
						}
						
						$sedcard->save();
					}
				}
			}
		} else {

			if(isset($sedcard_count) && count($sedcard_count) < 5){
				flash(t("Please upload sedcard images"))->error();
				return redirect()->back();
			}else{
				flash(t("You have already uploaded sedcard images"))->error();
				return redirect()->back();
			}
		}

		if($image_error){

			if(count($error_file_name) > 0 ){
				$images =implode(', ', $error_file_name);
			}

			$error_msg = t("uploaded images are corrupted").' ( '.$images.' )';
			
			if(count($error_file_name) == 1){
				$error_msg = t("uploaded image is corrupted").' ( '.$images.' )';
			}
			
			flash($error_msg)->error();
			return redirect()->back();

		}
		
		// exit();
		if(!$imagefound && count($sedcard_count) == 0){
			flash(t("Error found"))->error();
		}elseif($imagefound && $sedcardexists){
			flash(t("Your sedcard has updated successfully"))->success();
		}elseif($imagefound && !$sedcardexists) {
			flash(t("Your sedcard has created successfully"))->success();
		}
		return redirect()->back();

		
	}

	// Genrate Sedcard PDF

	public function genrate($id = null, SedcardRequest $request) {

		$user_id = $id;

		if(Auth::user()->user_type_id == 3){

			if(empty($user_id)){
				$user_id = Auth::user()->id;
			}

			$sedcards = Sedcard::where('user_id', $user_id)->orderby('image_type','ASC')->paginate($this->perPage);
			$data = array("sedcards" => $sedcards, 'user_id' => $user_id);

			// Meta Tags
			MetaTag::set('title', t('Genrate sedcards - :app_name', ['app_name' => config('app.app_name')]));
			MetaTag::set('description', t('Genrate sedcards - :app_name', ['app_name' => config('settings.app.name')]));
			CommonHelper::ogMeta();

			// if(isset($sedcards) && $sedcards->count() == 0 ){
			// 	flash(t("Sedcard images are pending for approval or rejected"))->error();
			// }

			return view('account.sedcard.genrate')->with('data', $data);
			
		}else{
			
			flash(t("You don't have permission to open this page"))->error();
			return redirect()->back();
		}

	}

	// to Crop image

	public function cropimg($id, SedcardRequest $request) {

		// testing
		/*echo Auth::user()->country_code;
		exit;*/

		$_POST = $request->all(); // This will get all the request data.
		$imgUrl = $_POST['imgUrl'];

		$user_id = Auth::user()->id;
		
		// $imgUrl = config('filesystems.default') . '/sedcard/' . strtolower(Auth::user()->country_code) . '/' . Auth::user()->id . '/' . basename($imgUrl);


		$imgUrl = substr($imgUrl , strpos($imgUrl, 'uploads/'));

		/*testing */
		/*echo $imgUrl ;
			exit;*/

		// original sizes
		$imgInitW = $_POST['imgInitW'];
		$imgInitH = $_POST['imgInitH'];
		// resized sizes
		$imgW = $_POST['imgW'];
		$imgH = $_POST['imgH'];
		// offsets
		$imgY1 = $_POST['imgY1'];
		$imgX1 = $_POST['imgX1'];
		// crop box
		$cropW = $_POST['cropW'];
		$cropH = $_POST['cropH'];
		// rotation angle
		$angle = $_POST['rotation'];

		$jpeg_quality = 100;


		$imageDirPath = 'sedcard/' . $user_id . '/cropimg';
		$imgUrlpath = config('filesystems.default') . '/sedcard/' . $user_id . '/cropimg';

		// $imgUrlpath = config('filesystems.default') . '/sedcard/' . $user_id;

		// $imgUrlpath = config('filesystems.default') . '/sedcard/' . strtolower(Auth::user()->country_code) . '/' . Auth::user()->id;

		// testing
		/* echo $imgUrlpath ;
            exit;*/

        if(!Storage::exists($imageDirPath)){
			Storage::makeDirectory($imageDirPath , 0775, true);
		}
		
		// uncomment line below to save the cropped image in the same location as the original image.
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
			$sedcard = Sedcard::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
			$imgName = str_replace('uploads/', '', $output_filename);
			$sedcard->cropped_image = $imgName . $type;
			$sedcard->save();
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
	public function downloadsdcard($id) {
		ini_set('zlib.output_compression', 'Off');

		$pdf = \App::make('dompdf.wrapper');
		
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
		$country = '';
		$chest = 0;
		$waist = 0;
		$hips = 0;


		$image_url[0] = '';
		$image_url[1] = '';
		$image_url[2] = '';
		$image_url[3] = '';
		$image_url[4] = '';

		$userdata = User::where('id', $uid)->first();
		$sedcards = Sedcard::where('user_id', $uid)->orderby('image_type','ASC')->get();
		$file_prefix = 'compCard';

		if(isset($sedcards) && count($sedcards) > 0 ){
			
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
				
				// only show first name
				$full_name = $firstname;

				if ($userdata->profile->height_id != 0) {
					
					$height = isset($unitoptions['height'][$userdata->profile->height_id]) ? $unitoptions['height'][$userdata->profile->height_id] : '';
				}

				if ($userdata->profile->weight_id != 0) {
					$weight = isset($unitoptions['weight'][$userdata->profile->weight_id]) ? $unitoptions['weight'][$userdata->profile->weight_id] : '';
				}
				
				// commented city code
				// $city_name = City::select('name')->where('id', $userdata->profile->city)->first();
				// if(!empty($city_name)){
				// 	$city = isset($city_name->name) ? $city_name->name : '';
				// }
				if(!empty($userdata->profile->city)){
					$city_name = explode(',', $userdata->profile->city);
                    $city = ( count($city_name) > 0 && isset($city_name[0]) )? $city_name[0] : $userdata->profile->city;
                }
				
				$country = "";

				if (!empty($userdata->country_code) && isset($userdata->country)) {
					$country = $userdata->country_name;
				}

				if ($userdata->profile->size_id != 0) {
					$clothing_size = isset($unitoptions['dress_size'][$userdata->profile->size_id]) ? $unitoptions['dress_size'][$userdata->profile->size_id] : '';
				}

				$eyecolor_data = ValidValueTranslation::where('valid_value_id', $userdata->profile->eye_color_id)->where('locale', $lang)->first();

				if (!empty($eyecolor_data)){
					$eyecolor = $eyecolor_data->value;
				}

				$piercing = $userdata->profile->piercing;
				$tattoo = $userdata->profile->tattoo;

				$haircolor_data = ValidValueTranslation::where('valid_value_id', $userdata->profile->hair_color_id)->where('locale', $lang)->first();
				
				if (!empty($haircolor_data)) {
					$haircolor = $haircolor_data->value;
				}

				$size_data = ValidValueTranslation::where('valid_value_id', $userdata->profile->size_id)->where('locale', $lang)->first();
				if (!empty($size_data)) {
					$size = $size_data->value;
				}

				if ($userdata->profile->shoes_size_id != 0) {
					$shoes_size = isset($unitoptions['shoe_size'][$userdata->profile->shoes_size_id]) ? $unitoptions['shoe_size'][$userdata->profile->shoes_size_id] : '';
				}

				$skincolor_data = ValidValueTranslation::where('valid_value_id', $userdata->profile->skin_color_id)->where('locale', $lang)->first();
				 
				if (!empty($skincolor_data)) {
					$skincolor = $skincolor_data->value;
				}
				
				if (isset($userdata->profile->birth_day)) {
					$birth_day = $userdata->profile->birth_day;
					// $age = $this->get_age_vivid($birth_day);

					$from = new \DateTime($birth_day);
					$to = new \DateTime('today');
					$pre = "";

					$age_label = t('Age');

					if($from->diff($to)->y > 0 ){
						$age = $from->diff($to)->y;
						($age)? ($age > 1 )? $pre = t('years') : $pre = t('year')  : '';
					}elseif($from->diff($to)->m > 0){
						$age = $from->diff($to)->m;
						($age)? ($age > 1 )? $pre = t('months') : $pre = t('month') : '';
					}else{
						$age = $from->diff($to)->d;
						($age)? ($age > 1 )? $pre = t('days') : $pre = t('day') : '' ;
					}
				}

				// if (isset($userdata->profile->chest_id) && $userdata->profile->chest_id != 0) {
				// 	$chest = $userdata->profile->chest_id;
				// }

				// if (isset($userdata->profile->waist_id) && $userdata->profile->waist_id != 0) {
				// 	$waist = $userdata->profile->waist_id;
				// }

				// if (isset($userdata->profile->hips_id) && $userdata->profile->hips_id != 0) {
				// 	$hips = $userdata->profile->hips_id;
				// }

				if (isset($userdata->profile->chest_id) && $userdata->profile->chest_id != 0) {
					$chest = isset($unitoptions['chest'][$userdata->profile->chest_id]) ? $unitoptions['waist'][$userdata->profile->chest_id] : '';
				}

				if (isset($userdata->profile->waist_id) && $userdata->profile->waist_id != 0) {
					$waist = isset($unitoptions['waist'][$userdata->profile->waist_id]) ? $unitoptions['waist'][$userdata->profile->waist_id] : '';
				}

				if (isset($userdata->profile->hips_id) && $userdata->profile->hips_id != 0) {
					$hips = isset($unitoptions['hips'][$userdata->profile->hips_id]) ? $unitoptions['hips'][$userdata->profile->hips_id] : '';
				}

			}else{
				flash(t("Something went wrong Please try again"))->error();
				return redirect()->back();
			}

		}else{
			flash(t("Sedcard not available for download"))->error();
			return redirect()->back();
		}


		if (!empty($userdata)) {
			$name = $userdata->name;
			$email = $userdata->email;
			$roles = $userdata->user_type_id;
			$go_code = $userdata->profile->go_code;
		}
		
		$i = 0;

		$heading_font = 'work_sansregular,Arial,Tahoma';
		$content_font = 'prataregular,arial,tahoma';

		$SedcardImagesCount = config('app.sedcard_images_count');
		
		$noimage1 = 'images/sedcard1_img.png';
		$noimage2 = 'images/sedcard2_img.png';

		for ($i=0; $i < $SedcardImagesCount; $i++) { 

			$defaultImage = $noimage2;
			if($i == 0){
				$defaultImage = $noimage1;
			}
			
			if(isset($sedcards[$i]) && !empty($sedcards[$i])){

				// if ($sedcards[$i]->cropped_image != "") {

				// 	$cropped_image = "";
				// 	if($sedcards[$i]->cropped_image !== "" && Storage::exists($sedcards[$i]->cropped_image)){
				//         $cropped_image = url(config('filesystems.default') . '/' .$sedcards[$i]->cropped_image);
				//     }else{
				//         $cropped_image = url(config('app.cloud_url').'/images/sedcard_img.jpg');
				//     }
				    
				// 	// $image_url[$i] =  url($sedcard->cropped_image);
				// 	$image_url[$i] = $cropped_image;
				// } else {

				// 	$sdfilename = "";
				// 	if($sedcards[$i]->filename !== "" && Storage::exists($sedcards[$i]->filename)){
				//         $sdfilename = url(config('filesystems.default') . '/' .$sedcards[$i]->filename);
				//     }else{
				//         $sdfilename = url(config('app.cloud_url').'/images/sedcard_img.jpg');
				//     }

				// 	$image_url[$i] = $sdfilename;
				// }

				

				    
					$sdfilename = "";
					
					if($sedcards[$i]->cropped_image !== "" && Storage::exists($sedcards[$i]->cropped_image)){
				        $sdfilename = url(config('filesystems.default') . '/' .$sedcards[$i]->cropped_image);

				    }else if($sedcards[$i]->filename !== "" && Storage::exists($sedcards[$i]->filename)){
				        $sdfilename = url(config('filesystems.default') . '/' .$sedcards[$i]->filename);
				    }else{
				        $sdfilename = url(config('app.cloud_url').'/'.$defaultImage);
				    }

					$image_url[$i] = $sdfilename;
				
			}else{
				$image_url[$i] = url(config('app.cloud_url').'/'.$defaultImage);
			}

			
		}

		// $logo = 'images/logo.png';
		$logo = url(config('app.cloud_url').'/'.$defaultImage);
		$app_url = config('app.url');
		
		    $html = '<html>
					<head>
					    <meta http-equiv="Content-Type" content="charset=utf-8" />
					    <style type="text/css">
					    @font-face {
					        font-family: "prataregular";           
					        src: local("prataregular"), url("'.$app_url.'/fonts/sedcardpdf/Prata-Regular.ttf") format("truetype");
					        font-weight: normal;
					        font-style: normal;

					    }        
					    
					    @font-face {
					        font-family: "work_sansregular";           
					        src: local("work_sansregular"), url("'.$app_url.'/fonts/sedcardpdf/WorkSans-Regular.ttf") format("truetype");
					        font-weight: normal;
					        font-style: normal;

					    }

					    @font-face {
					        font-family: "work_sans_semi_bold";           
					        src: local("work_sans_semi_bold"), url("'.$app_url.'/fonts/sedcardpdf/WorkSans-SemiBold.ttf") format("truetype");
					        font-weight: normal;
					        font-style: normal;

					    }

					    @font-face {
					        font-family: "work_sansbold";           
					        src: local("work_sansbold"), url("'.$app_url.'/fonts/sedcardpdf/WorkSans-Bold.ttf") format("truetype");
					        font-weight: normal;
					        font-style: normal;

					    }

					    @page { margin: 0px; }
						
						body { margin-top: 20px; font-family: work_sans }

					    </style>
					</head>
					<body>';

			$html .='<table style="margin:0 auto; width:82%; height:50%; max-height:600px; table-layout:fixed;" cellspacing="10px">';
			$html .='<tr>';
			if ($image_url[0] != "") {
            	$html .='<td rowspan="2" style="width:50%; height:542px;"><img src="'.$image_url[0].'" style="width:auto; height:100%; "></td>';	
            }else{
            	$html .='<td rowspan="2" style="width:50%; height:542px;"><img src="'.$noimage1.'" style="width:auto; height:100%;"></td>';
            }

            if ($image_url[1] != "") {
            	$html .='<td style="width:25%; height:260px;"><img src="'.$image_url[1].'" style=" width:auto; height:100%; "></td>';
        	}else{
        		$html .='<td style="width:25%; height:260px;"><img src="'.$noimage2.'" style=" width:auto; height:100%; "></td>';
        	}

        	if ($image_url[2] != "") {
            	$html .='<td style="width:25%; height:260px;"><img src="'.$image_url[2].'" style=" width:auto; height:100%; "></td>';
        	}else{
        		$html .='<td style="width:25%; height:260px;"><img src="'.$noimage2.'" style=" width:auto; height:100%; "></td>';
        	}
            
			$html .='</tr>';
			$html .='<tr>';
			if ($image_url[3] != "") {
            	$html .='<td style="width:25%; height:260px;"><img src="'.$image_url[3].'" style="width:auto; height:100%; "></td>';
        	}else{
        		$html .='<td style="width:25%; height:260px;"><img src="'.$noimage2.'"" style="width:auto; height:100%; "></td>';
        	}

        	if ($image_url[4] != "") {
            	$html .='<td style="width:25%; height:260px;"><img src="'.$image_url[4].'" style="width:auto; height:100%; "></td>';
        	}else{
        		$html .='<td style="width:25%; height:260px;"><img src="'.$noimage2.'"" style="width:auto; height:100%; "></td>';
        	}
			$html .='</tr>';
			$html .='<tr>';
			$html .=' <td style="width:50%;">';
			$html .='<table style="width:100%; table-layout:fixed;">
			  <tr>
                <td style="width:30%; font-size:14px; padding-right:13px; font-family:work_sansregular,arial,tahoma;" align="right" colspan="2">'.$go_code.'</td>
              </tr>
              <tr>
                <td style="width:40%; font-size:25px; font-family:prataregular,arial,tahoma;">'.$full_name.'</td>
              </tr>
              <tr>
                <td style="width:50%; padding-top:1px; font-family:work_sansregular,arial,tahoma;" colspan="2">'.$city.' - '.$country.'</td>
              </tr>
              <tr> <td>&nbsp;</td> </tr>
              <tr>
                <td style="width:40%;"><img src="images/logo.png" style="width:50%; height:auto;" /></td>
                <td style="width:40%; padding-right:13px;"  align="right"><a style="font-size:11px;font-family:work_sansregular,arial,tahoma;" href="'. config('app.url') .'">www.go-models.com</a></td>
              </tr>
            </table>';
            $html .=' </td>';

    //         $html .=' <td style="width:50%;">
    //         	<span style="width:100%; font-size:20px;" >'.$full_name.'</span><br><span>'.$city.' - '.$country.'';
            	
    //     	if($go_code && $go_code != ""){
    //     		$html .= ', '.$go_code;
    //     	}

    //         $html .='</span><br /><br /><br />
    //         	<img src="'.$logo.'" style="width:20%; height:auto; padding-right:20px;" />
	   //          <span>
				// 	<a style="font-size:12px;font-family:work_sansregular,arial,tahoma;" href="'. config('app.url') .'">www.go-models.com</a> &nbsp;&nbsp;|&nbsp;&nbsp; 
				// 	<a href="mailto:'. config('app.suppport_email') .'" style="font-size:12px;font-family:work_sansregular,arial,tahoma;">'. config('app.suppport_email') .'</a>
				// </span>
    //         </td>';

        $html .='<td style="padding-top:10px; width:25%; font-family: " work_sansbold",="" arial,="" tahoma;"="">
                <table>
                    <tbody>

                        <tr>
                           <td style="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;">'.t('Height').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$height.'</td>
                        </tr>
                        <tr>
                           <td style="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Weight').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$weight.'</td>
                        </tr>
                        <tr>
                           <td style="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;ont-size:12px;"> '.t('Breast').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$chest.'</td>
                        </tr>
                        <tr>
                           <td style="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Waist').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$waist.'</td>
                        </tr>
                        <tr>
                           <td style="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Hips').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$hips.'</td>
                        </tr>
                        <tr>
                           <td tyle="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Dress size').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$clothing_size.'</td>
                        </tr>
                        
                   </tbody>
               </table>
            </td>
            <td style="padding-top:10px; width:25%; font-family: " work_sans_semi_bold",="" arial,="" tahoma;"="">
                <table>
                    <tbody>
                    	<tr>
                           <td style="font-family:work_sansregular,arial,tahoma;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Age').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;' . $age.' '.$pre.'</td>
                        </tr>
                    	
                        <tr>
                           <td style="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Hair color').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$haircolor.'</td>
                        </tr>
                        
                        <tr>
                           <td style="font-family:work_sansregular,arial,tahoma;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Eye color').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$eyecolor.'</td>
                        </tr>
                        
                        <tr>
                           <td style="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Skin').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$skincolor.'</td>
                        </tr>

                    	<tr>
                           <td style="font-family:work_sansregular,arial,tahoma;font-size:12px;"> <span style="font-family:work_sans_semi_bold,prataregular,Arial,Tahoma;font-size:12px;"> '.t('Shoe size').'</span></td>
                           <td style="padding-left:10px;font-family:work_sansregular,arial,tahoma;font-size:12px;">&bull;&nbsp;'.$shoes_size.'</td>
                        </tr>
                           
                        <tr>
                        	<td>&nbsp;</td>
                        </tr> 
                   </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';

	$filename = $file_prefix.''.$uid.''.$name;
	$filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $filename);

	$pdf->loadHTML($html)->setPaper('a4', 'landscape');
	return $pdf->download($filename.'.pdf');

	/*
  		//echo $final_html;exit;
  		//temp commented this code once we get the proper ttf fonts for pdf generates
  
  		$defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
		$fontDirs = $defaultConfig['fontDir'];

		$defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
		$fontData = $defaultFontConfig['fontdata'];

		$mpdf = new \Mpdf\Mpdf([
		    'fontDir' => array_merge($fontDirs, [
		        base_path().'/public/fonts/pdf',
		    ]),
		    'fontdata' => $fontData + [
		        'work_sansbold' => [
		            'R' => 'WorkSans-Bold.ttf'
		        ],
		        'work_sans_semi_bold' => [
					'R' => 'WorkSans-SemiBold.ttf',
		        ],
		        'work_sansregular' => [
					'R' => 'WorkSans-Regular.ttf',
		        ],
		        'prataregular' => [
		            'R' => 'Prata-Regular.ttf',
		        ]
		    ],
		    'default_font' => 'work_sansregular',
		    'mode' => 'utf-8', 'format' => 'A3-L',
		]);


		// echo $final_html;
		// die();
		$filename = $file_prefix.''.$uid.''.$name;

		$filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $filename);

		$path = config('filesystems.default') . '/sedcard/download/';
		// check folder is exist, if no create download folder
		File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);

		$filename_path = config('filesystems.default') . DIRECTORY_SEPARATOR.'sedcard'.DIRECTORY_SEPARATOR.'download'.DIRECTORY_SEPARATOR. $filename . '.pdf';

		//$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);

		$mpdf->mirrorMargins = true;
		if (file_exists($filename_path)) {
			unlink($filename_path);
		}
		$mpdf->SetDisplayMode('fullpage', 'two');
		$final_html = mb_convert_encoding($final_html, 'UTF-8', 'UTF-8');
		$mpdf->WriteHTML($final_html);
		$mpdf->Output($filename_path, 'F');
		$path_parts = pathinfo($filename_path);

		header("Content-Disposition: attachment; filename=\"" . $path_parts["basename"] . "\"");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header("Content-Description: File Transfer");
		header("Content-Length: " . filesize($filename_path));
		flush(); // this doesn't really matter.
		$fp = fopen($filename_path, "r");
		while (!feof($fp)) {
			echo fread($fp, 65536);
			flush(); // this is essential for large downloads
		}
		fclose($fp);
		exit;

	*/
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function show($id) {
		
		$sedcard = Sedcard::where('id', $id)->firstOrFail();
		// ->where('user_id', Auth::user()->id)->firstOrFail();
	 	
	 	$show_title = '';

		if($sedcard->image_type == 1){
			$show_title = t('Portrait photo');
		}elseif($sedcard->image_type == 2) {
		 	$show_title = t('Whole body photo');
		}elseif($sedcard->image_type == 3) {
		 	$show_title = t('Beauty Shot');
		}elseif($sedcard->image_type == 4) {
		 	$show_title = t('Outfit');
		}elseif ($sedcard->image_type == 5) {
		 	$show_title = t('Free choice');
		}else{
			$show_title = t('Photo view full size');
		}

		$data['show_title'] = $show_title;
		$data['sedcard'] = $sedcard; 

		return view('childs.img-zoom-popup', $data);

		// return redirect(config('app.locale') . '/account/sedcards/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $id
	 * @return $this
	 */
	public function edit($id) {
		// Get the Sedcard
		$sedcard = Sedcard::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

		// // Meta Tags
		MetaTag::set('title', t('Edit the sedcard'));
		MetaTag::set('description', t('Edit the sedcard - :app_name', ['app_name' => config('settings.app.name')]));

		return view('account.sedcard.edit')->with('sedcard', $sedcard);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $id
	 * @param SedcardRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update($id, SedcardRequest $request) {
		// Get Sedcard
		$sedcard = Sedcard::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

		$sedcard->name = $request->input('sedcard.name');
		$sedcard->save();

		// Save the Sedcard's File
		if ($request->hasFile('sedcard.filename')) {
			$sedcard->filename = $request->file('sedcard.filename');
			$sedcard->save();
		}

		// Message Notification & Redirection
		flash(t("Your sedcard has updated successfully"))->success();

		return redirect(config('app.locale') . '/account/sedcards');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param null $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy($id = null, Request $request) {
		// Get Entries ID
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
		foreach ($ids as $item) {

			$sedcard = Sedcard::where('id', $item)->where('user_id', Auth::user()->id)->firstOrFail();
			if (!empty($sedcard)) {
				// Delete Entry
				$nb = $sedcard->delete();
			}
		}
		$message = '';
		// Confirmation
		if ($nb == 0) {
			if(!$request->ajax()) {
				flash(t("No deletion is done, Please try again"))->error();
			}else{
				$message = t("No deletion is done, Please try again");
			}
		} else {
			$count = count($ids);
			if ($count > 1 && !$request->ajax()) {
				flash(t("x :entities has been deleted successfully", ['entities' => t('sedcard'), 'count' => $count]))->success();
			} else {
				if(!$request->ajax()){
					flash(t("1 :entity has been deleted successfully", ['entity' => t('sedcard')]))->success();
				}
			}
			$message = t("sedcard_delete_success");
		}

		if($request->ajax()){
			return ['status' => 'success', 'message' => $message];  
        }
		// return redirect(config('app.locale') . '/account/sedcards');
		return redirect()->back();
	}
	
 	/*
	* Description: return slider popup images with selected image show first.
	* @param $id, $user_id
 	*/
	public function sedcardnew($id, $user_id){
        
        $imageArr = $selectedImg = array();

        if(isset($id) && isset($user_id) &&!empty($id) && !empty($user_id)){
        
            $sedcard = Sedcard::where('user_id', $user_id)->get()->toArray();
            
         	if(isset($sedcard) && count($sedcard) > 0 ){

             	foreach ($sedcard as $key => $sedcard_data) {

                 	if(isset($sedcard_data['id']) && $sedcard_data['id'] == $id){

                     	if (isset($sedcard_data['cropped_image']) && $sedcard_data['cropped_image'] != ""  && Storage::exists($sedcard_data['cropped_image'])){

                     		$selectedImg['src'] = \Storage::url($sedcard_data['cropped_image']);

                     	}elseif (isset($sedcard_data['filename']) && $sedcard_data['filename'] != ""  && Storage::exists($sedcard_data['filename'])){

                     		$selectedImg['src'] = \Storage::url($sedcard_data['filename']);

                     	}else{

                     		$selectedImg['src'] = config('app.cloud_url').'/uploads/app/default/picture.jpg';
                     	}
                     	
                        $selectedImg['titel'] = $sedcard_data['name'];
					}
					else{

                     	if (isset($sedcard_data['cropped_image']) && $sedcard_data['cropped_image'] != ""  && Storage::exists($sedcard_data['cropped_image'])){

                     		 $imageArr[$key]['src'] = \Storage::url($sedcard_data['cropped_image']);

                     	}elseif (isset($sedcard_data['filename']) && $sedcard_data['filename'] != ""  && Storage::exists($sedcard_data['filename'])){

                     		 $imageArr[$key]['src'] = \Storage::url($sedcard_data['filename']);

                     	}else{

                     		$imageArr[$key]['src'] = config('app.cloud_url').'/uploads/app/default/picture.jpg';
                     	}

                        $imageArr[$key]['titel'] = $sedcard_data['name'];
                 	}
                }
         	}
         	array_unshift($imageArr, $selectedImg);
            return response()->json(array('success' => true, 'imageArr'=> $imageArr));
        }
        return response()->json(array('success' => false, 'imageArr'=> $imageArr));
    }

    // profile pic croping
	public function cropSedcardImage(Request $request){
		
		$message = t('some error occurred');
		
		if(isset($request->image) && !empty($request->image)){

			$user_id = Auth::user()->id;
			$sedcard_image_type = $request->image_type;
			
			$image_array_1 = explode(";", $request->image);

	 	 	$extentionString = $image_array_1[0];

	 	 	$extentionArr = explode("/", $extentionString);

	 	 	$imageType = "png";
	 	 	
	 	 	// get extention Array
	 	 	if(isset($extentionArr[1])){

	 	 		$imageType = $extentionArr[1];
	 	 	}
	 	 	
	 	 	$image_array_2 = explode(",", $image_array_1[1]);
		 	
		 	$data = base64_decode($image_array_2[1]);

		 	$imageDirPath = 'sedcard/'.$user_id;
		 	$image_name = md5(microtime() . mt_rand()). '.'.$imageType;

		 	// check image path is exist
		 	if(!Storage::exists($imageDirPath)){
				
				// create image directory
				Storage::makeDirectory($imageDirPath , 0775, true);
			}

			// get record already exist by image type id
			$get_sedcard = Sedcard::where('user_id', Auth::user()->id)->where('image_type', $sedcard_image_type)->first();

			// if record exist, delete record 
			if(!empty($get_sedcard)){

				$get_sedcard->delete();
			}
			
			// set image name
			$fileName = $imageDirPath.'/'.$image_name;
			
			// save record array
			$secardInfo = array(
							'country_code' => Auth::user()->country_code,
							'user_id' => Auth::user()->id,
							'name' => $image_name,
							'image_type' => $sedcard_image_type,
							'filename' => $fileName,
							//'active' => 1,
						);
			$sedcard = new Sedcard($secardInfo);
			$sedcard->save();

			// save image in folder 
			file_put_contents('uploads/'.$fileName, $data);
			
			$status = true;
			$message = t('Your sedcard has created successfully');

			// image attr id
			$imageAttrId = 'sedcardFilename'.$sedcard_image_type.'-output';
			// image div id 
			$viewImageDivId = '#uploaded_image'.$sedcard_image_type;

			// show image in front side
			$returnHTML = '<img id="'.$imageAttrId.'" src="'.Storage::url($fileName).'" alt="'.trans('metaTags.Go-Models').'">';

			return response()->json(array('success' => true, 'html' => $returnHTML, 'message' => $message,'imagename' => $image_name, 'viewImageDivId' => $viewImageDivId));
		}else{
			
			$sedcard_image_type = $request->image_type;
			$imageAttrId = 'sedcardFilename'.$sedcard_image_type.'-output';
			$error_id = '#sedcardFilename'.$sedcard_image_type.'-error';

			$returnHTML = '<img id="'.$imageAttrId.'" src=""'.url(config('app.cloud_url').'/uploads/app/default/picture.jpg').'" alt="'.trans('metaTags.Go-Models').'" >';
	 		
	 		return response()->json(array('success' => false, 'html'=> $returnHTML, 'error' => $message, 'errorElementId' => $error_id));
	 	}
	}
}
