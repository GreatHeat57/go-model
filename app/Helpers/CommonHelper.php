<?php

namespace App\Helpers;
use GuzzleHttp\Client;
use ChrisKonnertz\OpenGraph\OpenGraph;
use Torann\LaravelMetaTags\Facades\MetaTag;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate;
use Mail;

class CommonHelper {

	public static function go_call_request($body) {
		$MAIN_URL = config('app.main_url');
		$MAIN_URL_user = config('app.main_url_user');
		$MAIN_URL_pw = config('app.main_url_pw');

		$mainurl = config('app.main_url') . config('app.receivepageurl');

		$go_api_key = config('app.go_api_key');

		if (is_array($body)) {
			$body['key'] = $go_api_key;
		}

		// $username = $MAIN_URL_user;//"leopedia";
		// $password = $MAIN_URL_pw;//"kfhjhJKd_kfhvTnfhdfeeecjddw";
		$auth = base64_encode($MAIN_URL_user . ':' . $MAIN_URL_pw);

		$client = new Client([
			'base_uri' => $MAIN_URL,
			'timeout' => 500,
		]);

		

		$response = $client->request('POST', $mainurl, [
			'headers' => [
				'Authorization' => 'Basic ' . $auth,
			],
			'verify' => false,
			'timeout' => 500,
			'form_params' => $body,
		]);

		return $response;
	}
	public static function language_support($data) {

		return [
			'Deutschland-de' => 'de',
			"English-en" => 'en',
			"Osterreich-at" => 'en',
			"Liechtensein-li" => 'li',
			'Schweiz-ch' => 'ch',
		];
	}

	public static function goModelMeta($user, $data = array()){
		

		if(!empty($user)){

			$metaTitle = '';
			if(!empty($data) && isset($data['title'])){

				$metaTitle = $data['title'];
			}else{

				if(!empty($user->username)){
					$metaTitle = $user->username.', ';
				}

				$metaTitle .= config('app.app_name');
			}
			
			// Meta Tags
			MetaTag::set('title', $metaTitle);
			if(!empty($user->profile->description)){
				MetaTag::set('description', strip_tags($user->profile->description));
			}
			$ogdataArr = array();
			if(isset($data['type'])){
				if(!empty($data['type'])){
					$ogdataArr['type'] = $data['type'];
				}
			}
			static::ogMeta($ogdataArr);
		}
		return true;
	}
	public static function goPartnerMeta($user, $data = array()){

		if(!empty($user)){

			$metaTitle = '';
			if(!empty($data) && isset($data['title'])){

				$metaTitle = $data['title'];
			}else{

				if(!empty($user->username)){
					$metaTitle = $user->username.', ';
				}

				$metaTitle .= config('app.app_name');
			}
			
			// Meta Tags
			MetaTag::set('title', $metaTitle);
			if(!empty($user->profile->description)){
				MetaTag::set('description', strip_tags($user->profile->description));
			}
			$ogdataArr = array();
			if(isset($data['type'])){
				if(!empty($data['type'])){
					$ogdataArr['type'] = $data['type'];
				}
			}
			static::ogMeta($ogdataArr);
		}
		return true;
	}
	public static function gojobMeta($data = array()){
		
		if(!empty($data)){
			
			$metaTitle = '';
			if(isset($data['title'])){
				$metaTitle = $data['title'];
			}

			MetaTag::set('title', $metaTitle);
			$ogdataArr = array();
			if(isset($data['type'])){
				if(!empty($data['type'])){
					$ogdataArr['type'] = $data['type'];
				}
			}
			static::ogMeta($ogdataArr);
		}
	}
	public static function ogMeta($data = array()){
		
		$title = MetaTag::get('title');
		$description = MetaTag::get('description');
		$type = 'article';
		
		if(!empty($data) && isset($data['type'])){
			$type = $data['type'];
		}

		// Open Graph
		$og = new OpenGraph();

		$locale = !empty(config('lang.locale')) ? config('lang.locale') : 'en_US';
		$locale = str_replace('_','-',$locale);
		
		try {
			$og->siteName(config('settings.app.name'))->locale($locale)->type($type)->url(url()->current())->title($title)->description(strip_tags($description));
		} catch (\Exception $e) {};
		view()->share('og', $og);
		return true;
	}

	// Change date in common formate
	public static function getFormatedDate($date, $time = false){
		
		$formated_date = "";
		$time_form = ' %I:%M';

		if( isset($date) && !empty($date) ){
			if(!$time)
			$time_form = '';
			// $formated_date = date("M d Y ".$time_form, strtotime($date));
			$formated_date = utf8_encode(strftime("%b %d %Y".$time_form , strtotime($date)));
		}

		return $formated_date;
	}

	// Change date in common formate for view calendar
	public static function getShowDate($date, $time =false){
		
		$formated_date = '';

		if( isset($date) && !empty($date) ){
			
			$formated_date = date("m/d/Y", strtotime($date));
		}


		return $formated_date;
	}

	public static function getThumbImage($user_id, $image_path, $size){

		$thumb = config('constant.THUMB');

		if( isset($image_path) && isset($size) && !empty($image_path) ){

			$thumb_image = str_replace($user_id.'/', $user_id.DIRECTORY_SEPARATOR.$thumb.DIRECTORY_SEPARATOR.$size.'_', $image_path);

			if(Storage::exists($thumb_image)){
				return $thumb_image;
			}
		}

		return $image_path;
	}

	// function to find url from string and replced with anchor tag.
	public static function  geturlfromstring($msgstring)
	{	
		//$reg_exUrl = "/((http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3})([\s.,;\?\!]|$)/";
		$reg_exUrl = '#((http|https|ftp|ftps)://(\S*?\.\S*?))([\s)\[\]{};"\':<]|\.\s|$)#i';

		if (preg_match_all($reg_exUrl, $msgstring, $matches)) {
		    
		    if(isset($matches[0]) && count($matches[0]) > 0){
		    	
		    	foreach ($matches[0] as $i => $match) {
		    		
		    		// if(isset($matches[1][$i]) && isset($matches[3][$i])){
		    			
		    			// if full url is match then replace it
		    			$msgstring = str_replace(
				            $match,
				            '<a href="'.$matches[0][$i].'" title="'.$matches[0][$i].'" class="details-desc" target="_blank">'.$matches[0][$i].'</a>',
				            $msgstring
				        );
		    		// }
			    }
		    }
		}

		return $msgstring;
		
		// $old_value=$replace_value=array();
		// $url_regex = '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i';
		// $match_url = '';
		// $result =preg_match_all($url_regex, $msgstring, $match_url);
		// $count_url_exist=count($match_url[0]);
		// if($count_url_exist >0)
		// {
		// 	for ($i =0; $i < $count_url_exist; $i++)
		// 	{
		// 		$old_value[$i] =$match_url[0][$i];

		// 		$str = $match_url[0][$i];

		// 		$replace_value[$i] = '<a href="$str" target="_blank">$str</a>';

		// 		// echo $link = '<a href="$str" target="_blank">$str</a>';
		// 	}
		// }
		// return str_replace($old_value, $replace_value, $msgstring);
	}


	public static function pageImageUploads($request, $field_name, $destination_path){

        $disk = config('filesystems.default');
		
		// if a new file is uploaded, store it on disk and its filename in the database
		if ($request->hasFile($field_name) && $request->file($field_name)->isValid()) {
			
			// 1. Generate a new file name
			$file = $request->file($field_name);

			$realName = $file->getClientOriginalName();

			$uploadDir = public_path($disk.'/'.$destination_path);

			$new_name = $realName;

			if (file_exists($uploadDir.DIRECTORY_SEPARATOR.$new_name)) {
				
			   $i = 1;
			   $file_ext     = substr($realName, strrpos($realName, '.'));
			   $file_part_name = substr($realName, 0, strrpos($realName, '.'));
			   do {
			       $new_name = $file_part_name . '-' . $i++ . $file_ext;
			   } while (file_exists($uploadDir.'/'.$new_name));
			}

			try{
				// 2. Move the new file to the correct path
				$file_path = $file->storeAs($destination_path, $new_name, $disk);
				return [ 'status' => true, 'message' => 'Your photo has been uploaded successfully', 'path' => $file_path];
            }
            catch(\Exception $e){
              return ['status' => false, 'message' => $e->getMessage(),'path' => '' ];
            }
		}else{
			return [ 'status' => false, 'message' => 'some error occurred', 'path' => $file_path];
		}
	}
	// Create Slug
	public static function setSlugName($slug, $locale = null){
		
		if(empty($slug)){ return $slug; }

		/**
		 * Change slug string. 
		 */
		$returnslug = self::transLiterateString($slug);

		// remove special characters
		$string = preg_replace("/[^a-zA-Z0-9 -]+/", "", $returnslug);
		// replace space to dash in string
		$slugName = str_replace(" ", "-", strtolower($string));

		if(!empty($locale)){
			
			return $slugName.'-'.$locale;
		}
		return $slugName;
	}

	public static function verifyRecaptchaResponse($captcha, $ipAddress = ''){

		$secretKey = config('captcha.secret');

		if($secretKey === ""){
			return [ 'status' => false, 'message' => 'site key is missing'];
		}

		if($captcha === ""){
			return [ 'status' => false, 'message' => 'captcha response is missing'];
		}

		$url = config('app.google_siteverify') . urlencode($secretKey) .  '&response=' . urlencode($captcha);
		
		if($ipAddress != ""){
			$url = $url.'&remoteip='.$ipAddress;
		}
  		
  		$response = file_get_contents($url);
        $responseKeys = json_decode($response,true);


		if($responseKeys["success"]) {
			return array('status' => true, 'key' => $captcha, 'ipaddress' => $ipAddress);
		} else {
			return array('status' => false, 'key' => $captcha, 'ipaddress' => $ipAddress);
		}

	}

	public static function transLiterateString($text) {
		
		/**
		 * Call all keyword file from config to change character.
		 */
		$transliterationTable  = config('allkeywords');

    	return str_replace(array_keys($transliterationTable), array_values($transliterationTable), $text);
	}


	/* 
	* Check facebook token expiry and if expired then regenerate new token and return it
	*/
	public static function refreshFacebookToken($app_access_token, $app_id, $app_secret, $api){
		if( isset($app_access_token) && !empty($app_access_token) ){

			$url = "https://graph.facebook.com/".$api."/debug_token?input_token=".$app_access_token."&access_token=".$app_access_token;
			$resp = CommonHelper::curlRequest($url);

			if( isset($resp) && isset($resp->data->expires_at) && $resp->data->is_valid == 1){

				//get expiered value.
				$expires_at = $resp->data->expires_at;

				if( isset($expires_at) && !empty($expires_at) ){

					// convert expiered value into date format and find the difference from current date
					$datetime1 = new \DateTime();
					$datetime2 = new \DateTime(date('Y-m-d', $expires_at));

					$difference = $datetime2->diff($datetime1)->format('%a');

					// check find the difference and difference less than 3 days then call the refresh token call
					if(isset($difference) && $difference <= 3){

						// regenerate the refresh token and return new token 
						$url = "https://graph.facebook.com/".$api."/oauth/access_token?grant_type=fb_exchange_token&client_id=".$app_id."&client_secret=".$app_secret."&fb_exchange_token=".$app_access_token;

						$access_resp = CommonHelper::curlRequest($url);

						// refresh flag set ture in token is regenerated
						if( isset($access_resp) && !empty($access_resp->access_token) ){
							return ['access_token' => $access_resp->access_token, 'refresh' => true];
						}
					}else{
						return ['access_token' => $app_access_token, 'refresh' => false];	
					}
				}else{
					return ['access_token' => $app_access_token, 'refresh' => false];
				}
			}
		}
	}

	/*
	* Comman curl request function
	*/
	public static function curlRequest($url){
		
		if( isset($url) && !empty($url) ){

			$handle = curl_init();

			// Set the url
			curl_setopt($handle, CURLOPT_URL, $url);
			// Set the result output to be a string.
			curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
			 
			$output = curl_exec($handle);
			 
			curl_close($handle);

			return json_decode($output);
		}
	}

	/*
	* check session has flash messages then regenerate flash to render in ajax request 
	*/
	public static function setFlashMessages(){

		// check session has flash message then regenerate flash message and render with ajax request
		if (session()->has('flash_notification')) {

			if(count((array) session('flash_notification')) == 1){
				foreach ((array) session('flash_notification') as $message){
					\Log::info('set flash message',['set message' => $message['message']]);
					if(isset($message['level']) && $message['level'] == 'success'){
						flash($message['message'])->success();
					}else if(isset($message['level']) && $message['level'] == 'danger'){
						flash($message['message'])->error();
					}
				}
			}
		}

		// check session has message then regenerate flash message and render with ajax request
		if (session()->has('message')) {
			flash(session('message'))->error();
		}

		// check session has success message then regenerate flash message and render with ajax request
		if (session()->has('success')) {
			flash(session('success'))->success();
		}
	}

	public static function dec_enc($action, $string) {
	    $output = false;
	 	
	 	$encrypt_method = (config('app.url_encrypt_method')) ? config('app.url_encrypt_method') : '';
		$secret_key = (config('app.url_secret_key')) ? config('app.url_secret_key') : '';
		$secret_iv = (config('app.url_secret_iv')) ? config('app.url_secret_iv') : '';
	 
	    // hash
	    $key = hash('sha256', $secret_key);
	    
	    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	    $iv = substr(hash('sha256', $secret_iv), 0, 16);
	 
	    if( $action == 'encrypt' ) {
	        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
	        $output = base64_encode($output);
	    }
	    else if( $action == 'decrypt' ){
	        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	    }
	 
	    return $output;
	}

	/**
	 * Get latitude longitude
	*/
	public static function getLatLong($url){
		
		if(config('app.is_log_latlong') == false) { return $longlat = array(); }

		// call google maps api
		$geocode = file_get_contents($url);
		$output = json_decode($geocode);
		$longlat = array();
		$region = '';
		\Log::info('latlong api response', ['Response Array' => $output]);
		if ($output->status == 'OK'){
			
			$longlat['latitude']= str_replace(",", ".", $output->results[0]->geometry->location->lat);
	    	$longlat['longitude']= str_replace(",", ".", $output->results[0]->geometry->location->lng);
     	
	     	foreach ($output->results as $result) {
				
				foreach($result->address_components as $addressPart) {

		            if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
		                $longlat['geo_city'] = $addressPart->long_name;
		            else if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
		                $longlat['geo_state'] = $addressPart->long_name;
		            else if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
		                $longlat['geo_country'] = $addressPart->long_name;
		        }
		    }
		}
		if(!empty($region)){
			$longlat['region'] = $region;
		}
		return $longlat; 
	}

	
	// check user is from free country registrations.
	public static function checkUserType($userType){
		if( \Auth::check() ){
			$user = \Auth::User();
			if( isset($user) && isset($user->country->country_type) && $user->country->country_type == $userType ){
				return true;
			}
			return false;
		}
		return false;
	}


	public static function createLink($gatename, $linkTitle, $href, $class=null, $id=null, $title=null, $additional=null, $startTag=null, $endTag=null){

		if(!empty($startTag) || !empty($endTag)){
			$linkTitle = $startTag.$linkTitle.$endTag;
		}

		if(!empty($id)){
			$id = " id='".$id."' ";
		}

		
		// if(!empty($class)){
		// 	$class = " class='open-popup ".$class."' ";
		// }else{
		// 	$class = " class='open-popup' ";
		// }

		if(!empty($title)){
			$title = " title='".$title."' ";
		}
		
		if( auth()->user() && isset($gatename) && !empty($gatename) ){
			if( Gate::allows($gatename, auth()->user()) ){
				return "<a href='".$href."' class='".$class."' $title  $id $additional >".$linkTitle."</a>";
			}else{
				return self::setUserLink(auth()->user(), $gatename, $linkTitle, $href, $class, $id, $title, $additional );
			}
		} else {
			return "<a href='".$href."' class='".$class."' $title $id $additional >".$linkTitle."</a>";
		}
	}

	public static function setUserLink($user, $gatename, $linkTitle, $href, $class=null, $id=null, $title=null, $additional=null){
		$link = "";
		if( Gate::allows('free_country_user', $user) ){

			$link = "<a href='#' data-target='#freejobs' data-toggle='modal' class='open-popup ".$class."' $title $id $additional >".$linkTitle."</a>";

		}else if(Gate::allows('premium_country_free_user', $user)){

			$link = "<a href='#' data-target='#freejobs' data-toggle='modal' class='open-popup ".$class."' $title $id $additional >".$linkTitle."</a>";
		}else if(Gate::allows('premium_country_paid_user', $user)){
			$link = "<a href='".$href."' class='".$class."' $title $id $additional >".$linkTitle."</a>";
		}

		return $link;

	}

	public static function generateContractLink($subscription_id='', $user = ""){
		$contract_link = "#";

		if($subscription_id == ""){
			$subscription_id = "_access";
		}

		if($user == ""){
			$user = \Auth::User();
		}

		if($user){
			
			$contract_link = $user->profile->contract_link;

			if( isset($contract_link) && !empty($contract_link) ){

				//parse the url
				$parse_url = parse_url($contract_link);
				$path = '/'.config('app.locale').'/contract/?';
				if( isset($parse_url) && !empty($parse_url) ){
					parse_str($parse_url['query'], $parse_str);

					if(isset($parse_str) && !empty($parse_str) && isset($parse_str['code'])){
						$link = "code=".$parse_str['code']."&d=".$parse_str['d']."&id=".$parse_str['id']."&subid=".$subscription_id;
						$contract_link = $path.self::dec_enc('encrypt', $link.'&'.config('constant.upgradelink') );
						
					}else{
						$link_url = self::dec_enc('decrypt', $parse_url['query']);
						parse_str($link_url, $parse_str);

						if(isset($parse_str) && !empty($parse_str) && isset($parse_str['code'])){
							$link = "code=".$parse_str['code']."&d=".$parse_str['d']."&id=".$parse_str['id']."&subid=".$subscription_id;
							$contract_link = $path.self::dec_enc('encrypt', $link.'&'.config('constant.upgradelink') );
						}
					}
				}

				

				return $contract_link;
			}
		}
		return $contract_link;
	}


	/**
	 *  Send email to Admin
	*/
	public static function crmApiCallFailedErrorMailToAdmin($mailDetails, $recipient = array()){

		if(config('app.env') == 'live'){
			if (count($recipient) == 0 && empty($recipient)) {
		 		$recipient = [ 'email' =>  array( config('app.admin_email') , config('app.admin_email2'))];
			}
	    	try{
	    		\Mail::send(new \App\Mail\CrmApiCallError($mailDetails, $recipient));
	        }catch(\Exception $e){
	        	\Log::error("============ Error failed CRM api call email send ===================");
	        	\Log::info('Error failed CRM api call email send', ['error' => $e->getMessage()]);
	        }
	    }
    	return true;
    }

    // check the image oriantion and if is rotated the correct it
    public static function checkImageOriatation($filename){
    	$exif = exif_read_data($filename);
	    if($exif && isset($exif['Orientation'])) {
	        $orientation = $exif['Orientation'];
	        if($orientation != 1){
	            $img = imagecreatefromjpeg($filename);
	            $deg = 0;

	            switch ($orientation) {
	              case 3:
	                $deg = 180;
	                break;
	              case 6:
	                $deg = 270;
	                break;
	              case 8:
	                $deg = 90;
	                break;
	            }
                
                if ($deg) {
                  	$img = imagerotate($img, $deg, 0);        
	               	try{
		                chmod($filename, 0777);
		                // then rewrite the rotated image back to the disk as $filename 
		                imagejpeg($img, $filename, 95);
	                }catch(Exceptions $e){}
                }
	        }
	    }
    }

	
}