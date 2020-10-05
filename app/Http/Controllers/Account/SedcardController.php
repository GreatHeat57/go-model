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

use App\Http\Requests\SedcardRequest;
use App\Models\Sedcard;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\ValidValueTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Torann\LaravelMetaTags\Facades\MetaTag;

class SedcardController extends AccountBaseController {
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
		dd('jj');
		// Get all User's sedcard
		//$sedcards = $this->sedcards->paginate($this->perPage);

		$sedcards = Sedcard::where('user_id', Auth::user()->id)->where('active', 1)->orderby("image_type", "ASC")->paginate($this->perPage);
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
			);
		}
		ksort($sed);

		$data[] = $sedcards;
		$data[] = $sed;
		// echo "<pre>";
		// print_r($data);
		// die();
		// Meta Tags

		MetaTag::set('title', t('My sedcards List'));
		MetaTag::set('description', t('My sedcards List - :app_name', ['app_name' => config('settings.app.name')]));

		return view('account.sedcard.index')->with('data', $data);
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
	public function store(SedcardRequest $request) {
		$sedcard_count = Sedcard::where('user_id', Auth::user()->id)->where('active', 1)->get();
		if ($sedcard_count->count() != 5) {
			// echo "<pre>";
			// print_r($_POST);
			// echo "</pre>";
			// die();
			// Create Sedcard
			$secardInfo = [
				'country_code' => config('country.code'),
				'user_id' => Auth::user()->id,
				'name' => $request->input('sedcard.name'),
				'image_type' => $_POST['typ_id'],
				'active' => 1,
			];
			$sedcard = new Sedcard($secardInfo);
			$sedcard->save();

			// Save the Sedcard's File
			if ($request->hasFile('sedcard.filename')) {
				$sedcard->filename = $request->file('sedcard.filename');
				$sedcard->save();
			}

			flash(t("Your sedcard has created successfully"))->success();

			return redirect(config('app.locale') . '/account/sedcards');
		} else {
			flash(t("Your sedcard maximum upload limit is 5."))->error();

			return redirect(config('app.locale') . '/account/sedcards');
		}
	}

	// Genrate Sedcard PDF

	public function genrate($id, SedcardRequest $request) {

		//$user_id=$request->all();
		//print_r($id);
		//die();
		$user_id = $id;
		//$sedcards = Sedcard::where('user_id', Auth::user()->id)->where('active',1)->get();
		$sedcards = Sedcard::where('user_id', $user_id)->where('active', 1)->paginate($this->perPage);
		$data = array("sedcards" => $sedcards, 'user_id' => $user_id);
		//$sedcards = $this->sedcards->paginate($this->perPage);

		echo "<pre>";
		print_r($sedcards);
		echo "</pre>";

		// echo "<pre>";
		// print_r($sedcards);
		// echo "<pre>";
		// die();

		return view('account.sedcard.genrate')->with('data', $data);

	}

	// to Crop image

	public function cropimg($id, SedcardRequest $request) {

		$_POST = $request->all(); // This will get all the request data.
		$imgUrl = $_POST['imgUrl'];
		$imgUrl = config('filesystems.default') . '/sedcard/' . strtolower(config('country.code')) . '/' . Auth::user()->id . '/' . basename($imgUrl);
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

		$imgUrlpath = config('filesystems.default') . '/sedcard/' . strtolower(config('country.code')) . '/' . Auth::user()->id;

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

			$sedcard->cropped_image = $output_filename . $type;
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
	public function downloadsdcard($id, SedcardRequest $request) {

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

		$image_url[0] = '';
		$image_url[1] = '';
		$image_url[2] = '';
		$image_url[3] = '';
		$image_url[4] = '';

		$userdata = UserProfile::where('user_id', $uid)->get();
		if (isset($userdata[0])) {

			$height_data = ValidValueTranslation::where('valid_value_id', $userdata[0]->height_id)->where('locale', $lang)->get();
			if (isset($height_data[0])) {
				$height = $height_data[0]->value . "(cm)";
				$height;
			}
			$weight_data = ValidValueTranslation::where('valid_value_id', $userdata[0]->weight_id)->where('locale', $lang)->get();

			if (isset($weight_data[0])) {
				$weight = $weight_data[0]->value . "(kg)";
			}

			$city = $userdata[0]->city;
			$clothing_size_data = ValidValueTranslation::where('valid_value_id', $userdata[0]->clothing_size_id)->where('locale', $lang)->get();
			if (isset($clothing_size_data[0])) {
				$clothing_size = $clothing_size_data[0]->value;
			}
			$eyecolor_data = ValidValueTranslation::where('valid_value_id', $userdata[0]->eye_color_id)->where('locale', $lang)->get();
			if (isset($eyecolor_data[0])) {
				$eyecolor = $eyecolor_data[0]->value;
			}

			$piercing = $userdata[0]->piercing;
			$tattoo = $userdata[0]->tattoo;
			$haircolor_data = ValidValueTranslation::where('valid_value_id', $userdata[0]->hair_color_id)->where('locale', $lang)->get();
			if (isset($haircolor_data[0])) {
				$haircolor = $haircolor_data[0]->value;
			}
			$size_data = ValidValueTranslation::where('valid_value_id', $userdata[0]->size_id)->where('locale', $lang)->get();
			if (isset($size_data[0])) {
				$size = $size_data[0]->value;
			}

			$shoes_size_data = ValidValueTranslation::where('valid_value_id', $userdata[0]->shoes_size_id)->where('locale', $lang)->get();
			if (isset($shoes_size_data[0])) {
				$shoes_size = $shoes_size_data[0]->value;
			}

			$skincolor_data = ValidValueTranslation::where('valid_value_id', $userdata[0]->skin_color_id)->where('locale', $lang)->get();
			if (isset($skincolor_data[0])) {
				$skincolor = $skincolor_data[0]->value;
			}

			if (isset($userdata[0]->birth_day)) {
				$birth_day = $userdata[0]->birth_day;
				$age = $this->get_age_vivid($birth_day);
			}

		}

		$userinfo = User::where('id', $uid)->get();
		//     	    echo "<pre>";
		// print_r($userinfo[0]);
		// echo "</pre>";

		//$firstname = $userdata->user_login;//$userdata->display_name;
		if (isset($userdata[0])) {
			$name = $userinfo[0]->name;
			$email = $userinfo[0]->email;
			$roles = $userinfo[0]->user_type_id;
			$firstname = $userdata[0]->first_name;
			$go_code = $userdata[0]->go_code;
		}

		$i = 0;

		//$sedcards = $this->sedcards->paginate($this->perPage);
		$sedcards = Sedcard::where('user_id', $uid)->where('active', 1)->paginate($this->perPage);

		foreach ($sedcards as $key => $sedcard) {

			if ($sedcard->cropped_image != "") {
				// $image_url[$i] =  url($sedcard->cropped_image);
				$image_url[$i] = $sedcard->cropped_image;
			} else {
				$image_url[$i] = config('filesystems.default') . '/' . $sedcard->filename;
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
  background: #fff;
  color: #000;
  margin: 0cm;
  font-family: \'Open Sans\', sans-serif;
  font-size: 9pt;
  line-height: 100%;


}

body  p {
  font-size:14px;
     margin-bottom: 10px;
  line-height:1.2px;
}
 </style><table style="margin:0 auto;">
	<tr>
		<td style="padding-right: 15px;">';
		if ($image_url[0] != "") {

			$final_html .= '<img src="' . $image_url[0] . '" style="padding-bottom:7px;max-height: 560px;width:450px;">';
		} else {
			$final_html .= '<img src="images/user.jpg" style="padding-bottom:7px;max-height: 560px;width:450px;">';
		}
		$final_html .= '<p ><b>' . $firstname . '</b>, ' . $size . ', ' . $city . ' </p>
		</td>
		<td style="padding-left: 15px;vertical-align: baseline;">
			<table>
				<tr >';
		if ($image_url[1] != "") {

			$final_html .= '<td  style="padding-right: 7px; padding-bottom:7px;"><img style="width:220px;height:250px" src="' . $image_url[1] . '"></td>';
		} else {
			$final_html .= '<td  style="padding-right: 7px; padding-bottom:7px;"><img style="width:220px;height:250px" src="images/user.jpg"></td>';
		}
		if ($image_url[2] != "") {
			$final_html .= '<td style="padding-left: 7px; padding-bottom:7px;"><img style="width:220px;height:250px"  src="' . $image_url[2] . '"></td>';
		} else {
			$final_html .= '<td  style="padding-right: 7px; padding-bottom:7px;"><img style="width:220px;height:250px" src="images/user.jpg"></td>';
		}

		$final_html .= '</tr><tr>';
		if ($image_url[3] != "") {

			$final_html .= '<td  style="padding-right: 7px; padding-bottom:7px;"><img style="width:220px;height:250px" src="' . $image_url[3] . '"></td>';
		} else {
			$final_html .= '<td  style="padding-right: 7px; padding-bottom:7px;"><img style="width:220px;height:250px" src="images/user.jpg"></td>';
		}

		if ($image_url[4] != "") {
			$final_html .= '<td style="padding-left: 7px; padding-bottom:7px;"><img style="width:220px;height:250px" src="' . $image_url[4] . '"></td>';
		} else {
			$final_html .= '<td  style="padding-right: 7px; padding-bottom:7px;"><img style="width:220px;height:250px" src="images/user.jpg"></td>';
		}
		$final_html .= '</tr>
				<tr>
					<td colspan="2" style="text-align: right; padding-top:4px;color:#233553;font-family: "Open Sans", sans-serif;line-height:1.2px;">
						<p> <b>' . t('Shoesize') . ':</b> ' . $shoes_size . ', <b>' . t('Hair Color') . ':</b> ' . $haircolor . ',<b> ' . t('Eye Color') . ':</b> ' . $eyecolor . '</p>
					    <p> <b>' . t('Height') . ':</b> ' . $height . ',<b> ' . t('Weight') . ':</b> ' . $weight . ', <b>' . t('Skin') . ':</b> ' . $skincolor . ',<b> ' . t('Age') . ': </b>' . $age . '</p>
						<p style="margin-top:5px;">' . $go_code . '</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr style="padding-top:0px;">
		<td style="text-align:left;padding-top:40px;">
		<img src="' . $logo . '"/>
		</td>
		<td style="text-align:right;padding-top:40px;color:#233553;font-family: "Open Sans", sans-serif;">
			<small><a href="https://go-models.com/de/">www.go-models.com</a> | <a href="mailto:support@go-models.com">support@go-models.com</a></small>
		</td>
	</tr>
</table>
  ';
		// echo $final_html;
		// die();
		$filename = $uid . '' . $name;
		$filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).]|[\.]{2,})", '', $filename);
		$filename_path = config('filesystems.default') . '/sedcard/download/' . $filename . '.pdf';

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

	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function show($id) {
		return redirect(config('app.locale') . '/account/sedcards/' . $id . '/edit');
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

		// Meta Tags
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
	public function destroy($id = null) {
		// Get Entries ID
		$ids = [];
		if (Request::filled('entries')) {
			$ids = Request::input('entries');
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

		// Confirmation
		if ($nb == 0) {
			flash(t("No deletion is done, Please try again"))->error();
		} else {
			$count = count($ids);
			if ($count > 1) {
				flash(t("x :entities has been deleted successfully", ['entities' => t('sedcard'), 'count' => $count]))->success();
			} else {
				flash(t("1 :entity has been deleted successfully", ['entity' => t('sedcard')]))->success();
			}
		}

		return redirect(config('app.locale') . '/account/sedcards');
	}

}