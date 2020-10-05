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
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\CommonHelper;
use App\Models\Setting;
use App\Models\Language;

// use App\Http\Requests\SedcardRequest;
// use App\Models\Sedcard;

class SocialController extends AccountBaseController {
	private $perPage = 10;
	public $pagePath = 'social';

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

		
		$sedcards = "";
		// Meta Tags
		MetaTag::set('title', t('Social - :app_name', ['app_name' => config('app.app_name')]));
		// Open Graph
		CommonHelper::ogMeta();

		// return view('account.social.index')->with('sedcards', $sedcards);
		return view('social')->with('sedcards', $sedcards);
	}

	public function facebook() {
		// SET YOUR FACEBOOK API DETAILS HERE
		// $app_id = '1361542810599209';
		// $app_secret = 'fdaecfad91d4a3349414ea01e6b4b20e';


		// $app_id = config('services.facebook.client_id');
		// $app_secret = config('services.facebook.client_secret');

		$app_id = config('settings.social_auth.facebook_client_id');
		$app_secret = config('settings.social_auth.facebook_client_secret');		
		$app_access_token = config('settings.social_auth.facebook_access_token');
		$page_access_token = config('app.page_access_token');

		// DO NOT EDIT BELOW THIS LINE
		ini_set('display_errors', '0');
		error_reporting(E_ALL | E_STRICT);

		// $app_access_token = config('app.page_access_token');
		// $app_access_token = config('app.page_access_token');
		
		$page_id = isset($_GET['id']) ? $_GET['id'] : '';
		$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
		$limit = $limit > 50 ? 50 : $limit;
		$feed = isset($_GET['feed']) ? $_GET['feed'] : 'feed';
		//$api = 'v2.8';
		$api = config('app.fb_api_version');
		
		//some fields are deprecated in new version
		//$fields = "id,message,picture,link,name,description,type,icon,created_time,from,object_id,likes,comments,attachments{media{image}}";

		//Regenerate access token if it is expires
		$app_access_token_resp = CommonHelper::refreshFacebookToken($app_access_token, $app_id, $app_secret, $api);

		//check if refresh is true then its regenerated token and need to update in database
		if( isset($app_access_token_resp['refresh']) && $app_access_token_resp['refresh'] == true ){
			$setting = Setting::where('key','social_auth')->first();

			if(isset($setting) && !empty($setting)){
				$value = jsonToArray($setting->value);

				if(isset($value) && isset($value['facebook_access_token'])){
					$value['facebook_access_token'] = $app_access_token_resp['access_token'];
				}

				$setting->value = json_encode($value);
				$setting->save();
			}
		}

		$locale = "";

		//get lanugage locale to translate the facebook feeds based on site locale
		$languageLocale = Language::where('abbr', config('app.locale'))->first();

		// if lanugage locale found and is not empty language locale the set in $locale.
		if( isset($languageLocale) && isset($languageLocale->abbr) && !empty($languageLocale->abbr) ){
			$locale = $languageLocale->locale;
		}

		$app_access_token = ($app_access_token_resp['access_token'])? $app_access_token_resp['access_token'] : $page_access_token;

		$fields = "full_picture,message,id,picture,likes,status_type,icon,created_time,from,comments,attachments{media,url}";

		// link,name,description,type,object_id,

		if ($feed == "posts") {
			$fields = "id,message,picture,icon,created_time,from,likes,attachments{media{image}}";
		}

		
		if(!empty($locale)){
			$locale = "&locale=".$locale;
		}

		$graphUrl = 'https://graph.facebook.com/' . $api . '/' . $page_id . '/' . $feed . '?access_token=' . $app_access_token . '&fields='.$fields.'&limit=' . $limit.$locale;

		$pageUrl = 'https://graph.facebook.com/' . $api . '/' . $page_id . '?&access_token=' . $app_access_token . '&fields=id,link,name'.$locale;

		
		//$graphUrl = "https://graph.facebook.com/".$api."/".$page_id."/".$feed."?fields=".$fields."&access_token=$app_access_token";


		// get page details
		$pageObject = "";
		try {
			$pageObject = file_get_contents($pageUrl);
			
			if ($pageObject === false) {
				$pageObject = $this->dc_curl_get_contents($pageUrl);
			}
		} catch (\Exception $e) {
			\Log::error("Facebook pageObject error : ". $e->getMessage());
		}


		$pageDetails = ($pageObject != "")? json_decode($pageObject) : '';
		$pageLink = isset($pageDetails->link) ? $pageDetails->link : 'https://web.facebook.com/groups/' . $page_id;
		$pageName = isset($pageDetails->name) ? $pageDetails->name : '';

		// get page feed
		// $graphObject = file_get_contents($graphUrl);
		$graphObject = "";
		try {
			$graphObject = file_get_contents($graphUrl);
			
			if ($graphObject === false) {
				$graphObject = $this->dc_curl_get_contents($graphUrl);
			}

		} catch (\Exception $e) {
			\Log::error("Facebook graphObject error : ". $e->getMessage());
		}

		$pagefeed = "";
		if($graphObject != ""){
			$parsedJson = json_decode($graphObject);
			$pagefeed = $parsedJson->data;
		}
		$count = 0;
		$link_url = '';
		$json_decoded = array();

		$json_decoded['responseData']['feed']['link'] = "";
		if (is_array($pagefeed)) {
			
			foreach ($pagefeed as $data) {

				if (isset($data->message)) {
					$message = str_replace("\n", "</br>", $data->message);
				} else if (isset($data->story)) {
					$message = $data->story;
				} else {
					$message = '';
				}

				if (isset($data->description)) {
					$message .= ' ' . $data->description;
				}

				$link = isset($data->link) ? $data->link : '';
				$image = isset($data->full_picture) ? $data->full_picture : null;
				$type = isset($data->status_type) ? $data->status_type : '';

				if ($link == '') {
					$id = isset($data->id) ? $data->id : '';
					$idArray = explode('_', $id);
					$link = $pageLink . '/posts/' . $idArray[1];
				}

				if ($link_url == $link) {
					//	continue;
				}

				$link_url = $link;

				if ($message == '' || $link == '') {
					//	continue;
				}

				if ($type == 'status' && isset($data->story)) {
					continue;
				}

				//	if($type == 'event') {
				//		$link = 'https://facebook.com' . $link;
				//	}

				if (!isset($data->object_id) && $type != 'video') {
					$pic_id = explode("_", $image);
					if (isset($pic_id[1])) {
						$data->object_id = $pic_id[1];
					}
				}

				// if (isset($data->object_id)) {

				// 	if (strpos($image, 'safe_image.php') === false && is_numeric($data->object_id)) {
				// 		$image = 'https://graph.facebook.com/' . $data->object_id . '/picture?type=normal';
				// 	}

				// }

				if (isset($data->attachments->data)) {
					$imagefeed = $data->attachments->data;
					if (is_array($imagefeed)) {
						foreach ($imagefeed as $attach) {
							$image = isset($attach->media->image->src)? $attach->media->image->src : $image;
						}
					}
				}

				$json_decoded['responseData']['feed']['entries'][$count]['pageLink'] = $pageLink;
				$json_decoded['responseData']['feed']['entries'][$count]['pageName'] = $pageName;
				$json_decoded['responseData']['feed']['entries'][$count]['link'] = $link;
				$json_decoded['responseData']['feed']['entries'][$count]['content'] = $message;
				$json_decoded['responseData']['feed']['entries'][$count]['thumb'] = $image;
				$json_decoded['responseData']['feed']['entries'][$count]['publishedDate'] = date("D, d M Y H:i:s O", strtotime($data->created_time));
				$count++;
			}
		}

		header("Content-Type: application/json; charset=UTF-8");
		echo json_encode($json_decoded);
	}

	public function dc_curl_get_contents($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	public function rss() {
		ini_set('display_errors', '0');
		error_reporting(E_ALL | E_STRICT);

		header('Content-Type: application/json');
		$feed = new \DOMDocument();

		$page_id = isset($_GET['id']) ? $_GET['id'] : '';
		$limit = isset($_GET['limit']) ? $_GET['limit'] : 20;
		$type = isset($_GET['type']) ? $_GET['type'] : 'rss';

		if ($type == 'pinterest') {
			$source = isset($_GET['feed']) ? $_GET['feed'] : 'user';

			if ($source == 'board') {
				$feed_url = 'https://www.pinterest.com/' . $page_id . '.rss';
			} else {
				$feed_url = 'https://www.pinterest.com/' . $page_id . '/feed.rss';
			}
		} else {

			$feed_url = 'http://' . $page_id;

		}

		$feed->load($feed_url);
		$count = 0;
		$json = array();

		$feed_title = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
		$items = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('item');

		$json['item'] = array();

		foreach ($items as $item) {

			$title = $item->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
			$description = $item->getElementsByTagName('description')->item(0)->firstChild->nodeValue;

			$text = $item->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
			$image = $this->dc_get_image($text);

			//   $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($text))))));

			$clear = trim(preg_replace('/ +/', ' ', preg_replace('[^A-Za-z0-9áéíóúÁÉÍÓÚ]', ' ', urldecode(html_entity_decode(strip_tags($text))))));

			//  $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9\p{L}\s\p{N}\'\.\ ]+/u', ' ', urldecode(html_entity_decode(strip_tags($text))))));

			//  $standardimage = $item->getElementsByTagName('standardimage')->item(0)->firstChild->nodeValue;
			$link = $item->getElementsByTagName('guid')->item(0)->firstChild->nodeValue;
			$publishedDate = $item->getElementsByTagName('pubDate')->item(0)->firstChild->nodeValue;

			$json['item'][$count] = array("title" => $title, "description" => $description, "link" => $link, "publishedDate" => $publishedDate, "text" => $clear, "feedTitle" => $feed_title, "image" => $image);
			$count++;
		}

		echo json_encode($json);
	}

	public function dc_get_image($html) {
		$doc = new \DOMDocument();
		@$doc->loadHTML($html);
		$xpath = new \DOMXPath($doc);
		$src = $xpath->evaluate("string(//img/@src)"); # "/images/image.jpg"
		return $src;
	}
	public function twitter() {

	}

}
