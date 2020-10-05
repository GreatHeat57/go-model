<?php

namespace App\Http\Controllers\Account;

use App\Helpers\Localization\Country as CountryLocalization;
use App\Http\Requests\AlbumRequest;
use App\Models\Albem;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Validator;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Storage;

class AlbumController extends AccountBaseController {
	private $perPage = 10;
	public $pagePath = 'album';

	public function __construct() {
		parent::__construct();

		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

		view()->share('pagePath', $this->pagePath);
		view()->share('perPage', $this->perPage);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$data = Albem::where('user_id', Auth::user()->id)->where('active', '1')->orderby('id', 'desc')->paginate($this->perPage);
		$count = Albem::where('user_id', Auth::user()->id)->count();

		MetaTag::set('title', t('My album List - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My album List - :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		// return view('partner.albums.index')->with('data', $data);
		return view('partner.albums.album')->with('data', $data)->with('count', $count)->with('paginator', $data);

	}

	public function genrate($id, AlbumRequest $request) {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		//$modelbook = $this->modelbooks->paginate($this->perPage);
		$user_id = $id;
		$album = Albem::where('user_id', $user_id)->where('active', 1)->orderby('id', 'desc')->get();
		$data = array("album" => $album, 'user_id' => $user_id);

		$data['logo'] = "";
		$data['country'] = "";
		$data['city'] = "";

		if (Auth::User() && isset(Auth::User()->id)) {
			$data['logo'] = (Auth::User()->profile->logo) ? Auth::User()->profile->logo : '';
			$data['country'] = (Auth::User()->country_code) ? CountryLocalization::getCountryNameByCode(Auth::User()->country_code) : '';
			$data['city'] = (Auth::User()->profile->city) ? Auth::User()->profile->city : '';
		}

		MetaTag::set('title', t('meta-genrate-album - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('meta-genrate-album - :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();
		 
		return view('partner.albums.album-genrate')->with('data', $data);
	}

	public function cropimg($id, AlbumRequest $request) {

		$_POST = $request->all(); // This will get all the request data.

		$imgUrl = $_POST['imgUrl'];

		$user_id = Auth::user()->id;

		// $image = $user_id . '/' . basename($imgUrl);

		$imgUrl = substr($imgUrl , strpos($imgUrl, 'uploads/'));
		
		// $imgUrl = config('filesystems.default') . '/album/' . $image;

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

		// $imageDirPath = 'uploads/album/' . $user_id . '/cropimg';
		$imageDirPath = 'album/' . $user_id . '/cropimg';

		$imgUrlpath = config('filesystems.default') . '/album/' . $user_id . '/cropimg';

		if(!Storage::exists($imageDirPath)){
			Storage::makeDirectory($imageDirPath , 0775, true);
		}

		// uncomment line below to save the cropped image in the same location as the original image.
		$output_filename = $imgUrlpath . "/croppedImg_" . rand();

		$what = getimagesize($imgUrl);

		switch (strtolower($what['mime'])) {
		case 'image/png':
			// $img_r = imagecreatefrompng($imgUrl);
			$source_image = imagecreatefrompng($imgUrl);
			$type = '.png';
			break;
		case 'image/jpeg':
			// $img_r = imagecreatefromjpeg($imgUrl);
			$source_image = imagecreatefromjpeg($imgUrl);
			$type = '.jpeg';
			break;
		case 'image/gif':
			// $img_r = imagecreatefromgif($imgUrl);
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
			$modelbook = Albem::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

			if (isset($modelbook->cropped_image) && $modelbook->cropped_image != "") {

				if (Storage::exists($modelbook->cropped_image)) {
					unlink(public_path('uploads/'.$modelbook->cropped_image));
				}
			}
			
			$imgName = str_replace('uploads/', '', $output_filename);
			
			$modelbook->cropped_image = $imgName . $type;
			$modelbook->save();
		}

		print json_encode($response);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		$count = Albem::where('user_id', Auth::user()->id)->count();
		// Meta Tags

		MetaTag::set('title', t('My album List - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My album List - :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();
		 
		// return view('partner.albums.create');
		return view('partner.albums.form-album')->with('count', $count);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {

		$req = $request->all();

		if( isset($req) && isset($req['album']['filename']) && !empty($req['album']['filename']) ){

			$rules = ['album.filename.*' => 'required|mimes:' . getUploadFileTypes('image') . '|max:' . (int) config('settings.upload.max_file_size', 1000)];

			$messages = ['album.filename.*.required' => t("Please upload an image"),
				'album.filename.*.mimes' => t("image extension valid"),
				'album.filename.*.max' => t("max file size valid"),
			];

			$validator = Validator::make($request->all(), $rules, $messages);

			if ($validator->fails()) {
				return \Redirect::back()->withInput()->withErrors($validator->messages());
			}

			$album_count = Albem::where('user_id', Auth::user()->id)->where('active', 1)->get();

			$user_id = Auth::user()->id;

			if ($request->hasFile('album.filename') && count($request->file('album.filename')) > 0) {

				if (count($request->file('album.filename')) > 5) {
					flash(t("max select image upload valid"))->error();
					return redirect(config('app.locale') . '/account/album');
				}

				$totalImageCount = $album_count->count() + count($request->file('album.filename'));

				if ($totalImageCount > 30) {
					flash(t("You can upload a maximum of 30 pictures"))->error();
					return redirect(config('app.locale') . '/' . trans('routes.account-album'));
				}

				// Create ModelBook album
				if(!Storage::exists('album/' . $user_id)){
					Storage::makeDirectory('album/' . $user_id , 0775, true);
				}

				$name = '';
				if ($request->input('album.name')) {
					$name = $request->input('album.name');
				}

				$count = count($request->file('album.filename'));

				$i = 0;
				$v = 1;

				foreach ($request->file('album.filename') as $value) {

					$SaveName = '';

					if (!empty($name)) {

						if ($count > 1) {
							$SaveName = $name . '-' . $v;
						} else {
							$SaveName = $name;
						}
					}

					$image_file = $value;
					$destinationPath = 'uploads/album/' . $user_id;
					$image_name = $image_file->getClientOriginalName();
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
					$filename = 'album/'.$user_id.'/'.$image;

					$albumInfo[$i] = [
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
				$album = Albem::insert($albumInfo);
				flash(t("Your Picture has added successfully"))->success();
				return redirect(config('app.locale') . '/' . trans('routes.account-album'));
			} else {
				flash(t("Something went wrong Please try again"))->error();

				return redirect(config('app.locale') . '/' . trans('routes.account-album'));
			}

		} else {
			flash(t("Please upload album images"))->error();
			return redirect(config('app.locale') . '/' . trans('routes.account-album'));
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		// Get the album
		$album = Albem::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

		// Meta Tags
		MetaTag::set('title', t('My album List - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My album List - :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		// return view('partner.albums.edit')->with('modelbook', $modelbook);
		return view('partner.albums.form-album')->with('album', $album)->with('count', 0);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update($id, Request $request) {
		
		$rules = ['album.filename' => 'mimes:' . getUploadFileTypes('image') . '|max:' . (int) config('settings.upload.max_file_size', 1000)];

		$messages = ['album.filename.*.mimes' => t("image extension valid"),
			'album.filename.*.max' => t("max file size valid")];

		$validator = Validator::make($request->all(), $rules, $messages);

		if ($validator->fails()) {
			return \Redirect::back()->withInput()->withErrors($validator->messages());
		}

		// Get ModelBook
		$album = Albem::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();
		$user_id = Auth::user()->id;

		// Save the ModelBook's File
		if ($request->hasFile('album.filename')) {

			$old_image = $album->filename;
			$old_crop_image = $album->cropped_image;

			$image_file = $request->file('album.filename');
			$destinationPath = 'uploads/album/' . $user_id;
			$image_name = $image_file->getClientOriginalName();
			$image = value(function () use ($image_file) {
				$filename = str_random(15) . '.' . $image_file->getClientOriginalExtension();
				return strtolower($filename);
			});
			try {

				$request->file('album.filename')->move($destinationPath, $image);
				$filename = 'album/'.$user_id.'/'.$image;
				$album->filename = $filename;
				$album->cropped_image = Null;

				if ($album->save()) {

					if (isset($old_image) && $old_image !== "") {
						if (Storage::exists($old_image)) {
							unlink(public_path('uploads/'.$old_image));
						}
					}

					// check crop image is exist in folder then remove it
					if (isset($old_crop_image) && $old_crop_image !== null && $old_crop_image !== "") {
						if (Storage::exists($old_crop_image)) {
							unlink(public_path('uploads/'.$old_crop_image));
						}
					}
				}

			} catch (Exception $e) {
				Log::error('Image not update or delete while update album : ' . $id);
			}
		}

		// update album title
		$name = ($request->input('album.name') && !empty($request->input('album.name')))? $request->input('album.name') : '';

		$album->name = $name;
		$album->save();


		
		// if ($request->input('album.name')) {
		// 	$album->name = $request->input('album.name');
		// 	$album->save();
		// }

		// Message Notification & Redirection
		flash(t("Your Picture book has updated successfully"))->success();

		return redirect(config('app.locale') . '/' . trans('routes.account-album'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param null $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy($id = null) {
		// Get Entries ID
		$ids = array();
		if (RequestFacade::filled('entries')) {
			$ids = RequestFacade::input('entries');
		} else {
			if (!is_numeric($id) && $id <= 0) {
				$ids = array();
			} else {
				$ids[] = $id;
			}
		}

		// Delete
		$nb = 0;

		if (count($ids)) {
			foreach ($ids as $item) {
				$albumPictures = Albem::where('id', $item)->where('user_id', Auth::user()->id)->first();
				// remove images from folders and that after remove images from database.

				if (isset($albumPictures) && !empty($albumPictures)) {

					// check main image is exist in folder then remove it
					if (isset($albumPictures->filename) && $albumPictures->filename !== "") {
						if (Storage::exists($albumPictures->filename)) {
							unlink(public_path('uploads/'.$albumPictures->filename));
						}
					}

					// check crop image is exist in folder then remove it
					if (isset($albumPictures->cropped_image) && $albumPictures->cropped_image !== "") {
						if (Storage::exists($albumPictures->cropped_image)) {
							unlink(public_path('uploads/'.$albumPictures->cropped_image));
						}
					}
				}

				// remove records from database
				if (!empty($albumPictures)) {
					// Delete Entry
					$nb = $albumPictures->delete();
				}
			}
		}

		// Confirmation
		if ($nb == 0) {
			flash(t("No deletion is done, Please try again"))->error();
		} else {
			$count = count($ids);
			if ($count > 1) {
				flash(t("x :entities has been deleted successfully", ['entities' => t('Album Picture'), 'count' => $count]))->success();
			} else {
				flash(t("1 :entity has been deleted successfully", ['entity' => t('Album Picture')]))->success();
			}
		}

		return redirect(config('app.locale') . '/' . trans('routes.account-album'));
	}

	public function getAlbumImageById($id) {

		$album = Albem::where('id', $id)->firstOrFail();
		$title = '';

		if(!empty($album)){
			if(isset($album->name) && !empty($album->name)){
				$title = $album->name;
			}
		}

		$data['title'] = $title;
		$data['album'] = $album;
		
		return view('partner.albums.album-img-zoom-popup', $data);
	}

	// Download PDF
	public function downloadalbum($id) {

		set_time_limit(300);

		$lang = config('app.locale');
		//$uid = Auth::user()->id;
		$uid = $id;

		$image_url = array();

		$userdata = UserProfile::where('user_id', $uid)->get();
		$userinfo = User::where('id', $uid)->get();

		if (isset($userdata[0])) {
			$name = $userinfo[0]->name;
			$email = $userinfo[0]->email;
			$roles = $userinfo[0]->user_type_id;
			$firstname = $userdata[0]->first_name;
			$go_code = $userdata[0]->go_code;
		}

		$i = 0;

		$albem = Albem::where('user_id', $uid)->get();

		foreach ($albem as $key => $albem) {
			if ($albem->cropped_image != "") {
				// $image_url[$i] =  url($sedcard->cropped_image);
				$image_url[$i] = $albem->cropped_image;
			} else {
				$image_url[$i] = config('filesystems.default') . '/album/' . $albem->filename;
			}

			$i++;
		}

		$logo = 'images/logo.png';
		$final_html = "";
		$final_html .= '<style type="text/css">/* Main Body */
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
      color: #000;
      font-family: \'Open Sans\', sans-serif;
      font-size: 9pt;
    }

      * {
        box-sizing: border-box;
      }

      .column {
        float: left;
        width: 30%;
        padding: 5px;
      }

      /* Clearfix (clear floats) */
      .row::after {
        content: "";
        clear: both;
        display: table;
      }

     </style>
     <div class="row">';
		if (count($image_url) > 0) {
			foreach ($image_url as $key => $img) {

				if (isset($img) && $img !== "") {
					$final_html .= '<div class="column"><img src="' . url($img) . '" style="width:100%; height:80%;"></div>';
				}
			}
		} else {
			$final_html .= '<div class="column"><img src="images/user.jpg" style="width:100%"></div>';
		}

		$final_html .= '</div><div class="row"><h2><img src="' . $logo . '"/></h2><p><a href="https://go-models.com/de/">www.go-models.com</a> | <a href="mailto:support@go-models.com">support@go-models.com</a></p></div>';

		// check if folder is exists or not
		if (!file_exists(public_path('uploads/album/download'))) {
			mkdir(public_path('uploads/album/download'), 0777);
		}

		$filename = $uid . '' . $name;
		$filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $filename);
		$filename_path = config('filesystems.default') . '/album/download/' . $filename . '.pdf';

		$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);

		$mpdf->mirrorMargins = true;
		if (file_exists($filename_path)) {
			unlink($filename_path);
		}
		$mpdf->SetDisplayMode('fullpage', 'two');
		$final_html = mb_convert_encoding($final_html, 'UTF-8', 'UTF-8');
		$mpdf->WriteHTML($final_html);
		$mpdf->Output($filename_path, 'F');
		$path_parts = pathinfo($filename_path);

		// $mpdf = new \Mpdf\Mpdf();
		// $mpdf->WriteHTML('<h1>Working On It</h1>');
		// $mpdf->Output($filename_path, 'F');
		// header("Content-Disposition: attachment; filename=" .$filename_path);

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
	}

	public function getAlbumsAjaxCall(Request $request){

		$data = [];
		$returnHTML = '';

		if($request->input('user_id') && !empty($request->input('user_id'))){
			
			$user = User::withoutGlobalScopes([VerifiedScope::class])->find($request->input('user_id'));
		
			$albums = Albem::where('user_id', $request->input('user_id'))->orderBy('id', 'DESC')->offset(12)->limit(30)->get();
			
			$data['user_id'] = $request->input('user_id');
			$data['user'] = $user;
			$data['album'] = $albums;
			$data['is_load_more_albums'] = false;
			
			$returnHTML = view('partner.inc.album-list' , $data)->render();
		} 

		return response()->json(array('success' => true, 'html'=> $returnHTML));
	} 
	
	/*
	* Description: return slider popup images with selected image show first.
	* @param $id, $user_id
 	*/
 	
	public function album_gallery($id, $user_id){
        
        $imageArr = $selectedImg = array();

        if(isset($id) && isset($user_id) &&!empty($id) && !empty($user_id)){
        
            $albem = Albem::where('user_id', $user_id)->get()->toArray();
            
         	if(isset($albem) && count($albem) > 0 ){

             	foreach ($albem as $key => $albem_data) {

                 	if(isset($albem_data['id']) && $albem_data['id'] == $id){

                     	if (isset($albem_data['cropped_image']) && $albem_data['cropped_image'] != ""  && Storage::exists($albem_data['cropped_image'])){

                     		$selectedImg['src'] = \Storage::url($albem_data['cropped_image']);

                     	}elseif (isset($albem_data['filename']) && $albem_data['filename'] != ""  && Storage::exists($albem_data['filename'])){

                     		$selectedImg['src'] = \Storage::url($albem_data['filename']);

                     	}else{

                     		$selectedImg['src'] = URL::to(config('app.cloud_url').'/uploads/app/default/picture.jpg');
                     	}

                        $selectedImg['titel'] = $albem_data['name'];
					}
					else{

                     	if (isset($albem_data['cropped_image']) && $albem_data['cropped_image'] != ""  && Storage::exists($albem_data['cropped_image'])){

                     		 $imageArr[$key]['src'] = \Storage::url($albem_data['cropped_image']);

                     	}elseif (isset($albem_data['filename']) && $albem_data['filename'] != ""  && Storage::exists($albem_data['filename'])){

                     		 $imageArr[$key]['src'] = \Storage::url($albem_data['filename']);

                     	}else{

                     		$imageArr[$key]['src'] = URL::to(config('app.cloud_url').'/uploads/app/default/picture.jpg');
                     	}

                        $imageArr[$key]['titel'] = $albem_data['name'];
                 	}
                }
         	}
         	array_unshift($imageArr, $selectedImg);
            return response()->json(array('success' => true, 'imageArr'=> $imageArr));
        }
        return response()->json(array('success' => false, 'imageArr'=> $imageArr));
    }
}
