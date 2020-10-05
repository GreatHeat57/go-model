<?php

namespace App\Http\Controllers\Api;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Post;
use App\Models\Scopes\StrictActiveScope;
use App\Models\Sedcard;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Response;

// use App\Models\City;
use App\Models\ModelCategory;
use App\Models\Branch;
use DB;
use App\Models\Company;
use App\Models\Country;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserNotification;
use App\Models\ValidValueTranslation;
use App\Models\ModelBook;
use App\Models\Language;
use App\Models\UserDressSizeOptions;
use App\Models\UserShoesUnitsOptions;
use App\Models\BlogEntry;
use App\Models\Page;
use App\Models\FeatureModels;
use App\Helpers\Payment as PaymentHelper;

// use App\Http\Controllers\Auth\Traits\EmailVerificationTrait;
use App;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Spatie\ResponseCache\Facades\ResponseCache;

class ApiController extends Controller {
	use VerificationTrait; 
	/*
		@param : $sedcardtype, $from, $to
		@description : Return latest updated sedcard images in crm for approval.
		@return: sedcard images object
	*/

	public $app_url = '';
	public $stages = array();

	public function __construct() {
		$this->app_url = config('app.url');
		$this->stages = array('lead','paid','contract','active');
	}

	public function callApiRequest(Request $request) {
		
		$action = $request->input('action');

		Log::info("====== Laravel api call with action = ".$action." ======");

		if ($action == '' || empty($action)) {
			$json['error'] = 'Action is missing';
			$response = json_encode($json);
			return response()->json($response);
		}

		switch ($action) {
		case 'cancel_subscriber':
			$this->cancel_subscriber($request);
			break;
		case 'complate_subscriber':
			$this->complate_subscriber($request);
			break;
		case 'add_partner':
			$this->add_employer($request);
			break;
		case 'deactive_user':
			$this->deactive_user($request);
			break;
		case 'delete_user':
			$this->delete_user($request);
			break;
		case 'check_user':
			$this->check_user($request);
			break;
		case 'assign_package':
			$this->assign_package($request);
			break;
		case 'set_status':
			$this->set_status($request);
			break;
		case 'check_profile':
			$this->check_profile($request);
			break;
		case 'get_sedcard':
			$this->getSedcard($request);
			break;
		case 'set_sedcard_status':
			$this->changeSedcardstatus($request);
			break;
		// case 'get_sedcard_by_id':
		// 	$this->getSedcardByid($request);
		// 	break;
		case 'update_user_data':
			$this->updateUserData($request);
			break;
		case 'get_user':
			$this->getUser($request);
			break;
		case 'get_post_highchart_data':
			$this->getPostHighchartData($request);
			break;
		case 'create_user':
			$this->createUser($request);
			break;
		case 'mautic_data':
			$this->mauticData($request);
			break;
		case 'get_model_book':
			$this->getModelBook($request);
			break;
		case 'update_user_password':
			$this->updateUserPassword($request);
			break;
		case 'get_user_profile_images':
			$this->getProfileImages($request);
			break;
		case 'set_profile_image_status':
			$this->changeProfileStatus($request);
			break;
		case 'get_all_pages':
			$this->getAllPages($request);
			break;
		case 'get_all_blogs':
			$this->getAllBlogs($request);
			break;
		case 'get_sedcard_go_code':
			$this->getSedcardGocode($request);
			break;
		//add new api job details
		case 'get_latest_jobs':
			$this->getJobDetails($request);
			break;
		case 'go_featured':
			$this->updateFeatureModels($request);
			break;
		case 'mark_user_as_unpaid':
			$this->markUserAsUnpaid($request);
			break;
		case 'un_delete_user':
			$this->unDeleteUser($request);
			break;
		case 'hard_delete_user':
			$this->hardDeleteUser($request);
		case 'suspend_user':
			$this->suspendUser($request);
			break;
		case 'un_suspend_user':
			$this->unsuspendUser($request);
			break;
		case 'complete_user_payment_in_crm':
			$this->paymentCrmApi($request);

		case 'complete_payment':
			$this->completePayment($request);
			break;

		case 'set_profile_data':
			$this->setProfileData($request);
			break;
		case 'EditorPick':
			$this->setEditorPickStatus($request);
		break;
		case 'RatingUpdate':
			$this->updateUserRatings($request);
		break;

		case 'delete_sedcard_by_image_id':
			$this->delete_sedcard_by_image_id($request);
		break;
		
		
		default:
			# code...
			break;
		}
		// Log::info("====== Laravel api call completed for action = ".$action." ======");
	}

	public function getSedcard(Request $request) {
		Log::info("Request data getSedcard : ".json_encode($request->all()));

		$offset = 0;
		$limit = 10;

		$req = $request->all();
		// check from to limit in request
		if (isset($req['from']) && !empty($req['from'])) { $offset = $req['from']; }
		if (isset($req['to']) && !empty($req['to'])) { $limit = $req['to']; }
		
		$application_date = (isset($req['application']) && !empty($req['application']))? $req['application'] : '';
		$payment_date = (isset($req['payment']) && !empty($req['payment']))? $req['payment'] : '';
		$user_type = (isset($req['user_type']) && !empty($req['user_type']))? $req['user_type'] : '';
		$sedcard_status = (isset($req['status'])) ? $req['status'] : 'nok';

		// check category in request
		// convert categories string to array
		$categories = (isset($req['platform']) && !empty($req['platform']))? explode(',', str_replace("'", "", $req['platform'])) : '';
		$sedcardtype = (isset($req['sedcardtype']))? $req['sedcardtype'] : '';
		$go_code = (isset($req['go_code']))? $req['go_code'] : array();
		$regions = (isset($req['regions']) && !empty($req['regions']))? explode(',', str_replace("'", "", $req['regions'])) : array();
		$stage = (isset($req['stage'])) ? $req['stage'] : '';
		
		if(!is_array($go_code) && !empty($go_code)){
			$go_code = explode(",", $req['go_code']);
		}

		$current_date = date('Y-m-d');
		if(isset($application_date) && !empty($application_date)){
			if($current_date < $application_date){
				echo json_encode(array(
					'status' => false,
					'message' => 'Invalid application date',
					'data' => []
				)); exit();
			}
		}

		if(isset($payment_date) && !empty($payment_date)){
			if($current_date < $payment_date){
				echo json_encode(array(
					'status' => false,
					'message' => 'Invalid payment date',
					'data' => []
				)); exit();
			}
		}

		// get sedcard function
		$data = Sedcard::getPendingSedcardRecords($sedcardtype, $offset, $limit, $user_type, $application_date, $payment_date, $current_date, $go_code, $sedcard_status, $categories, $regions, $stage);

		if ($data['status']) {
			echo json_encode($data); exit();
		} else {

			echo json_encode(array(
				'status' => false,
				'message' => 'records not found',
				'data' => []
			)); exit();
		}

	}

	/*
		@param : $user_id, $image_id, $status
		@description : update sedcard images status in approved/rejected in crm.
		@return: updated sedcard imnages status
	*/
	public function changeSedcardstatus(Request $request) {
		// Log::info("Request data : ".json_encode($request->all()));
		$req = $request->all();
		$go_code = isset($request->go_code) ? $request->go_code : '';
		$status = isset($request->status) ? $request->status : '';
		$image_id = isset($request->image_id) ? $request->image_id : '';

		
		if($go_code == ""){
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'go_code is required!',
				'data' => []
			));
			// save api log
			$this->apiLog($req, $responseData);
			exit();
		}

		if( $status == "" ){
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'status is required!',
				'data' => []
			));
			// save api log
			$this->apiLog($req, $responseData);
			exit();
		}

		if( $image_id == "" ){
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'sedcard image id is required!',
				'data' => []
			));
			// save api log
			$this->apiLog($req, $responseData);
			exit();
		}

		// $user = User::withoutGlobalScopes()->where('username', $go_code)->first();
		$user = User::withoutGlobalScopes()->select('users.id')->join('user_profile as up1', 'users.id', '=', 'up1.user_id')->where('go_code', $go_code)->first();

		if(empty($user)){
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'user does not exist!',
				'data' => []
			));
			// save api log
			$this->apiLog($req, $responseData);
			exit();
		}

		if ( isset($req) && isset($req['image_id']) ) {

			$user_id = ($user->id) ? $user->id : '';

			$imageObject = Sedcard::where('id', $image_id)->where('user_id', $user_id)->first();

			if (!empty($imageObject)) {
				$imageObject->active = $status;
				$imageObject->save();

				echo $responseData = json_encode(array(
					'status' => true,
					'message' => 'Status changed successfully',
					'data' => []
				));
				// save api log
				$this->apiLog($req, $responseData);
				Log::error("Error in action changeSedcardstatus : User id is required");
			} else {

				echo $responseData = json_encode(array(
					'status' => false,
					'message' => 'records not found',
					'data' => []
				));
				// save api log
				$this->apiLog($req, $responseData);
				Log::error("Error in action changeSedcardstatus : records not found");
			}

		} else {
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'Invalid request param',
				'data' => []
			));
			// save api log
			$this->apiLog($req, $responseData);
			Log::error("Error in action changeSedcardstatus : Invalid request param");
		}
	}

	

	/*
		url:http://stage.go-models.com/handler/
		Parameters:
		action:cancel_subscriber
		transaction_id:transactionid
	*/
	/*subscriber cancel*/
	function cancel_subscriber(Request $request) {
		// Log::info("Request data : ".json_encode($request->all()));
		$requestData =  $request->all();
		//take transaction id
		$transaction_id = $request->input('transaction_id');
		if ($transaction_id == '' || empty($transaction_id)) {
			$json['error'] = 'Transaction id is missing';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			die;
		}
		//set status
		$transaction_status = "cancelled";
		//archieve post
		$post = Post::withoutGlobalScopes()->where('id', $transaction_id)->first();

		if(empty($post)){
			$json['error'] = 'Invalid transaction id';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			die;
		}
		$requestData['wpusername']  = isset($post->user->username) ? $post->user->username : '';

		//fetch post_id using payment
		$currentPayment = Payment::withoutGlobalScope(StrictActiveScope::class)->where('post_id', $transaction_id)->orderBy('created_at', 'desc')->first();

		if (!empty($currentPayment)) {
			//update status in payment table
			$currentPayment->transaction_status = 'cancelled';
			$currentPayment->active = 0;
			$currentPayment->save();
			
			//set user status to inactive
			if (!empty($post)) {
				$user_id = $post->user_id;
				$user = User::where('id', $user_id)->first();
				$user->subscribed_payment = 'pending';
				$user->subscription_type = 'free'; 
				$user->save(); 
				$json['success'] = "true";
				$json['status'] = true;
				// save api log
				$this->apiLog($requestData, json_encode($json));
				echo json_encode($json);
				// Log::info("Return data of action cancel_subscriber : ".json_encode($json));
			}
		}else{
			$json['error'] = 'Payment does not exist!';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			die;
		}
	}

/*
url:http://stage.go-models.com/handler/
Parameters:
action:complate_subscriber
transaction_id:transactionid
 */
	function complate_subscriber(Request $request) {
		$requestData = $request->all();		
		$status = false;
		$return = array();
		// Log::info("Request data : ".json_encode($request->all()));
		$transaction_id = $request->input('transaction_id');
		if ($transaction_id == '' || empty($transaction_id)) {
			
			$json['error'] = 'Transaction id is missing';
			$json['success'] = $status;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			die;
		}
		
		//get post by post CRM transaction_id (transaction_id == laravel postId)
		// $getPostData = DB::table('posts')->where('id' , $transaction_id)->first();
		
		// // check post exist or not
		// if(!empty($getPostData)){
			
		// 	if(isset($getPostData->deleted_at) && !is_null($getPostData->deleted_at)){
		// 		// update post table deleted_at column value null
		// 		DB::statement("UPDATE posts SET deleted_at = NULL where id = ?", [$transaction_id ]);
		// 	}
		// }else{

		// 	Log::error("Error complate_subscriber : Invalid Transaction");
		// 	$json['error'] = 'Invalid Transaction';
		// 	echo json_encode($json);
		// 	exit();
		// }

		//archieve post
		$post = Post::withoutGlobalScopes()->where('id', $transaction_id)->first();
		if(empty($post)){
			// Log::error("Error complate_subscriber : Invalid Transaction");
			$json['error'] = 'Invalid Transaction';
			$json['success'] = $status;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			exit();
		}

		$post->deleted_at = NULL;
		$post->save();
		$requestData['wpusername']  = isset($post->user->username) ? $post->user->username : '';
		//fetch package data using paymentId/transaction_id
		$currentPayment = Payment::withoutGlobalScope(StrictActiveScope::class)->where('post_id', $transaction_id)->orderBy('created_at', 'desc')->first();

		if(empty($currentPayment)){

			// get package price by post package id
			$packageObj = Package::select('id','price')->withoutGlobalScopes([ActiveScope::class])->where('id', $post->package)->first(); 

			// create new payment entry
			$currentPayment = new Payment();
			$currentPayment->post_id = $transaction_id;
			$currentPayment->package_id = $post->package;
			$currentPayment->payment_method_id = 5;
			$currentPayment->transaction_amount = ($packageObj->price) ? $packageObj->price : '0.00';
			$currentPayment->save();
		} 
		
		// Log::info("Current payment result: ".json_encode($currentPayment));

		// print_r($currentPayment);exit;
		if (!empty($currentPayment) && $currentPayment->count() > 0) {

			$package_id = $currentPayment->package_id;

			//update payment status to approved
			$currentPayment->transaction_status = 'approved';
			$currentPayment->active = 1;
			$currentPayment->save();

			//add subscribed_payment ->yes/no in user table
			// $post = Post::withoutGlobalScopes()->where('id', $currentPayment->post_id)->first();

			// Log::info("Current Post result: ".json_encode($post));
			$user_id = $post->user_id;
			$user = User::where('id', $user_id)->first();

			// Log::info("Current user result: ".json_encode($user));

			//call generate passowrd api
			//update passowrd in user table
			//call activate api
			if($user->password == null || $user->password == ''){

				$req_arr = array(
					'action' => 'generate_pw', //required
					'wpusername' => $user->username, // required
					'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
				);

				$response = CommonHelper::go_call_request($req_arr);
				// Log::info('Request Array generate_pw partner', ['Request Array' => $req_arr]);
				$json = json_decode($response->getBody());
				// Log::info('Response Array', ['Response Array generate_pw partner' => $response->getBody()]);

				if ($response->getStatusCode() == 200) {

					$body = (string) $response->getBody();
					$user->password = bcrypt($body);
					$user->save();

					$req_arr = array(
						'action' => 'activate', //required
						'wpusername' => $user->username, // required
					);

					$res = CommonHelper::go_call_request($req_arr);
					// Log::info('Request Array activate user', ['Request Array' => $req_arr]);
					
					$json = json_decode($res->getBody());
					// Log::info('Response Array', ['Response Array activate partner' => $json]);

					if ($res->getStatusCode() == 200) {
						$status = true;
					}else{
						$status = false;
						$return['message'] = 'CRM activate api call failed!';
					}
				}else{
					$status = false;
					$return['message'] = 'CRM generate_pw api call failed!';
				}
			}else{
				$status = true;
			}

			if($status == true){

				// $user->subscribed_payment = 'complete';
				//add subscription_type in user table
				// $user->subscription_type = 'paid';
				$user->active = 1;
				$user->subscribed_payment = 'complete';
				$user->subscription_type = 'paid';
				// $user->profile->status = 'ACTIVE';
				$post->subscribed_payment = 'complete';
				$post->subscription_type = 'paid';
				$post->save();
				$user->profile->save();
				$user->save();
				// Log::info('Success Api Call', ['success' => true]);
				$return['message'] = 'User complate subscription successfully.';

				// Store payment response log in database
				try{
					$data = $request->all();
					PaymentHelper::logResponse($user->email, $transaction_id, $currentPayment->payment_method_id, 'offline', $data, 'pay');
				}catch(\Exception $e){
					\Log::error("Error in store offline payment request : ". $e->getMessage());
				}
			}
			else{
				Log::info('Error Api Call', ['Response get status Code' => $response->getStatusCode()]);
			}
		}else{
			$return['message'] = 'Payment does not exist!';
			Log::info('Invalid transaction_id', ['fetch package data using paymentId/transaction_id' => $transaction_id]);
		}
		
		
		$return['success'] = $status;
		// save api log
		$this->apiLog($requestData, json_encode($return));
		echo json_encode($return);
	}

	/*
		url:http://stage.go-models.com/handler/
		Parameters:

		[action] => add_partner //required
		[industry] => agency //required
		[company] => testingCompany
		[fname] => firstName
		[lname] => Emp
		[tel] => +36251478920
		[street] => testing street
		[zip] => 3965002
		[city] => surat
		[country] => india
		[email] => vividemp12@vivid.com //required (unique)
		[url] => www.vividinfo1.com
		[wpusername] => vivide12 //required(unique)
		[wppass] => vivid@123 //required

	*/
	function add_employer(Request $request) {
		// Log::info("Request data : ".json_encode($request->all()));
		$requestData =  $request->all();
		$username = $request->input('wpusername');
		$cs_user_role_type = 'employer';
		$signup_user_role = 'cs_employer';
		$email = $request->input('email');
		$random_password = $request->input('wppass');
		$cs_specialisms = $request->input('industry');
		$user_hash = $request->input('user_hash');

		if (empty($user_hash)) {
			$json['type'] = "error";
			$json['message'] = "User hash is required";
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Error in action add_employer : ".json_encode($json));
			exit();
		}

		if (empty($cs_specialisms)) {
			$json['type'] = "error";
			$json['message'] = "Please enter a industry.";
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Error in action add_employer : ".json_encode($json));
			exit();
		}

		if (empty($random_password)) {
			$json['type'] = "error";
			$json['message'] = "Passowrd are required.";
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Error in action add_employer : ".json_encode($json));
			exit();
		}

		if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {
			$json['type'] = "error";
			$json['message'] = "Please enter a valid email.";
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Error in action add_employer : ".json_encode($json));
			exit();
		}

		$is_user_exist = User::where('email', $email)->first();

		if (!empty($is_user_exist)) {
			$json['type'] = "error";
			$json['message'] = "User already exists. Please try another one.";
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Error in action add_employer : ".json_encode($json));
			die;
		} else {
			$userInfo = [
				'username' => $username,
				'user_type_id' => 2,
				'email' => $email,
				'password' => bcrypt($random_password),
				'hash_code' => $user_hash,
				'active' => 1,
			];
			// Conditions to Verify User's Email or Phone
			// $emailVerificationRequired = config('settings.mail.email_verification') == 1 && $request->filled('email');
			// $phoneVerificationRequired = config('settings.sms.phone_verification') == 1 && $request->filled('phone');

			// if ($emailVerificationRequired) {
			$userInfo['email_token'] = md5(microtime() . mt_rand());
			$userInfo['verified_email'] = 1;
			// }
			// Mobile activation key generation
			// if ($phoneVerificationRequired) {
			$userInfo['phone_token'] = mt_rand(100000, 999999);
			$userInfo['verified_phone'] = 1;
			// }
			// echo "<pre>";
			// print_r($userInfo);
			// echo "</pre>";exit();

			$user = new User($userInfo);
			$user->save();
			$user_id = $user->id;

			if ($cs_user_role_type == 'employer') {

				$company = !empty($request->input('company')) ? $request->input('company') : '';
				$user_url = !empty($request->input('url')) ? $request->input('url') : '';
				$first_name = !empty($request->input('fname')) ? $request->input('fname') : '';
				$last_name = !empty($request->input('lname')) ? $request->input('lname') : '';

				$current_user = User::withoutGlobalScopes([VerifiedScope::class])->where('id', $user_id)->first();

				// $current_user->profile->company_name = $company;
				// $current_user->profile->website_url = $user_url;
				// $current_user->profile->first_name = $first_name;
				// $current_user->profile->last_name = $last_name;
				// $current_user->profile->save();

				$profileInfo = array(
					'user_id' => $user->id,
					'company_name' => $company,
					'website_url' => $user_url,
					'first_name' => $first_name,
					'last_name' => $last_name,
					// 'status' => 'ACTIVE',
				);

				$userprofile = new UserProfile($profileInfo);
				$userprofile->save();

				$current_user->active = 1;

				$cs_loc_country = !empty($request->input('country')) ? $request->input('country') : '';

				// commented phone number code
				$cs_phone_no = !empty($request->input('tel')) ? $request->input('tel') : '';

				$current_user->country_code = strtoupper($cs_loc_country);
				$current_user->phone = $cs_phone_no;
				$current_user->phone_code = ($request->input('tel_prefix')) ? $request->input('tel_prefix') : '';
				$current_user->subscribed_payment = 'complete';
				$current_user->subscription_type = 'free';
				$current_user->updated_at = strtotime(date('d-m-Y'));
				$current_user->save();

				
				// commented phone number code
				// $cs_phone_no = !empty($request->input('tel')) ? $request->input('tel') : '';
				$cs_street = !empty($request->input('street')) ? $request->input('street') : '';
				$cs_zip = !empty($request->input('zip')) ? $request->input('zip') : '';
				$cs_city = !empty($request->input('city')) ? $request->input('city') : '';

				// $cs_post_loc_latitude = !empty($request->input('cs_post_loc_latitude')) ? $request->input('cs_post_loc_latitude') : '';
				// $cs_post_loc_longitude = !empty($request->input('cs_post_loc_longitude')) ? $request->input('cs_post_loc_longitude') : '';
				$cs_post_comp_address = !empty($request->input('cs_post_comp_address')) ? $request->input('cs_post_comp_address') : '';

				$partnerCat = Branch::withoutGlobalScopes([ActiveScope::class])->select('id','translation_of')->where('slug', $cs_specialisms)->first();


				if(isset($partnerCat->parent_id)){

					$current_user->profile->category_id = $partnerCat->parent_id;
				}

				// commented phone number code
				// $current_user->profile->phone_number = $cs_phone_no;
				$current_user->profile->street = $cs_street;
				$current_user->profile->zip = $cs_zip;
				$current_user->profile->city = $cs_city;
				$current_user->profile->address_line1 = $cs_post_comp_address;
				$current_user->profile->allow_search = 1;
				$current_user->profile->save();


				if(isset($request->company) && !empty($request->company)){
					
					$companyObj = new Company();
					$companyObj->user_id = $user->id;
					$companyObj->name = $request->input('company');
					$companyObj->country_code = strtoupper($cs_loc_country);
					// save company
					$companyObj->save();
				}

			}
			$json['success'] = true;

			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::info("Response of action add_employer : ".json_encode($json));
			exit;
		}
	}

	/*deactive_user
		Parameters:
		action:deactive_user
		wpusername:
	*/
	function deactive_user(Request $request) {
		// Log::info("Request data : ".json_encode($request->all()));
		$requestData =  $request->all();
		$username = $request->input('wpusername');
		if ($username == '' || empty($username)) {
			$json['error'] = 'username is missing';
			$json['status'] = false;
			echo json_encode($json);
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::eror("Error in action deactive_user : ".json_encode($json));
			die;
		}
		$user = User::where('username', $username)->first();
		if (!empty($user)) {
			$user->active = 0;
			// $user->profile->status = 'INACTIVE';
			$user->profile->save();
			$user->save();
			$json['success'] = 'deactive user done';
			$json['status'] = true;
			echo json_encode($json);
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::info("Response of action deactive_user : ".json_encode($json));
			die;
		} else {
			$json['error'] = 'username is not exists in wp';
			$json['status'] = false;
			echo json_encode($json);
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Response of action deactive_user : ".json_encode($json));
			die;
		}
	}

		/*delete_user
		Parameters:
		action:delete_user
		wpusername:
	*/
	function delete_user(Request $request) {

		// Log::info("Request data : ".json_encode($request->all()));
		$requestData =  $request->all();

		if(isset($request->wpusername) && !empty($request->wpusername)){

			$username = $request->wpusername;

			//get username by userData
			$user = User::withoutGlobalScopes()->where('username', $username)->withTrashed()->first();
			$requestName = 'username ';
		}
		else if(isset($request->email) && !empty($request->email)){
			$email = $request->email;

			//get username by userData
			$user = User::where('email', $email)->first();
			$requestName = 'email ';
		}else{

			$json['message'] = 'invalid email or username!';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action delete_user : ".json_encode($json));
			exit();
		}
		
		if(empty($user)){
			$json['message'] = $requestName.'does not exists';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action delete_user : ".json_encode($json));
			exit();
		}else{
					$user->delete();
			$json['message'] = 'delete user successfully';
			$json['status'] = true;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::info("Response of action delete_user : ".json_encode($json));
			die;
		}

		// $username = $request->input('wpusername');
		// if ($username == '' || empty($username)) {
		// 	$json['error'] = 'username is missing';
		// 	echo json_encode($json);
		// 	die;
		// }
		// $user = User::where('username', $username)->first();
		// if (!empty($user)) {
		// 	$user_id = $user->id;
		// 	//profile picture

		// 	if (!empty($user->profile->logo)) {
		// 		$user_profile_picture = \Storage::url($user->profile->logo);
		// 		if (file_exists($user_profile_picture)) {
		// 			Storage::delete($user_profile_picture);
		// 		}
		// 	}

		// 	if (!empty($user->profile->cover)) {
		// 		$user_cover_picture = \Storage::url($user->profile->cover);
		// 		if (file_exists($user_cover_picture)) {
		// 			Storage::delete($user_cover_picture);
		// 		}
		// 	}

		// 	$modelbooks = ModelBook::where('user_id', $user_id)->get();
		// 	foreach ($modelbooks as $key => $modelbook) {
		// 		if ($modelbook->cropped_image == "" && \Storage::url($modelbook->filename)) {
		// 			// echo "if";
		// 			$image_path = \Storage::url($modelbook->filename);
		// 		}
		// 		if ($modelbook->cropped_image != "" && url(config('filesystems.default') . '/' . str_replace("uploads", "", $modelbook->cropped_image))) {
		// 			// echo "else";
		// 			$image_path = url(config('filesystems.default') . '/' . str_replace("uploads", "", $modelbook->cropped_image));
		// 		}
		// 		if (file_exists($image_path)) {
		// 			Storage::delete($image_path);
		// 		}
		// 	}

		// 	$sedcards = Sedcard::where('user_id', $user_id)->get();
		// 	foreach ($sedcards as $key => $sedcard) {
		// 		if ($sedcard['cropped_image'] == "") {
		// 			$image_path = \Storage::url($sedcard['filename']);
		// 		} elseif ($sedcard['filename'] != "") {
		// 			$image_path = url(config('filesystems.default') . '/' . str_replace("uploads", "", $sedcard['cropped_image']));
		// 		}
		// 		if (file_exists($image_path)) {
		// 			Storage::delete($image_path);
		// 		}
		// 	}

		// 	$deletedRows = User::where('id', $user_id)->delete();

		// 	$json['success'] = 'delete user done';
		// 	echo json_encode($json);
		// 	die;
		// } else {
		// 	$json['error'] = 'username does not exists';
		// 	echo json_encode($json);
		// 	die;
		// }
	}

	/*check user
		Parameters: wpusername
		action: check_user,
	*/
	public function check_user(Request $request) {
		// Log::info("Request data : ".json_encode($request->all()));
		$requestData =  $request->all();
		$username = $request->input('wpusername');
		if ($username == '' || empty($username)) {
			$json['error'] = 'username is missing';
			$json['success'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			die();
		}
		$user = User::where('username', $username)->first();
		if (!empty($user)) {
			$user_id = $user->id;
			$wpusername = $user->username;
			//  echo "$wpusername == $username";
			if ($wpusername == $username) {
				// $user_status = get_user_meta($user_id, 'cs_user_status', 'inactive');
				$json['success'] = true;
				// save api log
				$this->apiLog($requestData, json_encode($json));
				echo json_encode($json); die();
				// Log::info("Response of action check_user : ".json_encode($json));
			}
			//echo $user_id;

		} else {
			$json['error'] = 'username is not exists in wp';
			$json['success'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action check_user : ".json_encode($json));
			die();
		}
	}

	/*
		*
		    [action] => assign_package
		    [wpusername] => final_test21
		    [subid] => _access_free
		    [language] => de
	*/
	public function assign_package(Request $request) {

		$requestData =  $request->all();
		// Log::info("Request data : ".json_encode($request->all())); 
		$wpusername = $request->input('wpusername');
		$get_subid = $request->input('subid');
		$get_language = $request->input('language');

		if (empty($wpusername) || $wpusername == '') {
			$json['error'] = 'username is missing';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action assign_package : ".json_encode($json));
			exit();
		}
		if (empty($get_subid) || $get_subid == '') {
			$json['error'] = 'subscription id is missing';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action assign_package : ".json_encode($json));
			exit();
		}
		if (empty($get_language) || $get_language == '') {
			$json['error'] = 'language is missing';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action assign_package : ".json_encode($json));
			exit();
		}
		
		// get user by username
		$user = User::where('username', $wpusername)->first();
		
		if (empty($user)) {
			$json['error'] = "username is wrong";
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action assign_package : ".json_encode($json));
			exit();
		}
		
		// user type is model, assign free package for model.
		if($user->user_type_id == config('constant.model_type_id')){
			
			// call function asign package function (param : user, subscription_type, country)
			$activeModelResponse = $this->assignPackageForModel($user, $get_subid, $get_language);
			
			if($activeModelResponse == true){

				$json['success'] = "package assign done";
			}else{

				$json['error'] = "package assign failed";
			}

			$json['status'] = $activeModelResponse;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::info("Response of action assign_package : ".json_encode($json));
			exit();
		}elseif ($user->user_type_id == config('constant.partner_type_id')) {
			
			// call partner asicn package
			$activePartnerResponse = $this->assignPackageForPartner($user, $get_subid, $get_language);
			
			if($activePartnerResponse == true){

				$json['success'] = "package assign done";
			}else{

				$json['error'] = "package assign failed";
			}

			$json['status'] = $activePartnerResponse;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::info("Response of action assign_package : ".json_encode($json));
			exit();
		}else{

			$json['error'] = 'Invalid user type id';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::info("Response of action assign_package : ".json_encode($json));
			exit();
		}
		
		/* OLD CODE COMMENTDE BY AJ (DATE : 18/11/2019)
		if ($user->user_type_id == 2 && $user->password == null) {
			$req_arr = array(
				'action' => 'generate_pw', //required
				'wpusername' => $user->username, // required
				'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
			);
			$response = CommonHelper::go_call_request($req_arr);
			Log::info('Request Array generate_pw partner', ['Request Array' => $req_arr]);
			$json = json_decode($response->getBody());
			Log::info('Response Array', ['Response Array generate_pw partner' => $response->getBody()]);
			if ($response->getStatusCode() == 200) {
				$body = (string) $response->getBody();
				$user->password = bcrypt($body);

				$req_arr = array(
					'action' => 'activate', //required
					'wpusername' => $user->username, // required
				);
				$res = CommonHelper::go_call_request($req_arr);
				Log::info('Request Array activate partner', ['Request Array' => $req_arr]);
				$json = json_decode($response->getBody());
				Log::info('Response Array', ['Response Array activate partner' => $json]);
				if ($res->getStatusCode() == 200) {
					$user->active = 1;
				}
				$user->save();
			}

			$id_address = \Request::getClientIp(true);
			$req_arr = array(
				'action' => 'create_sub', //required
				'wpusername' => $user->username, // required
				'transactionid' => '',
				'gateway' => 'free for partner',
				'type' => '',
				'currency' => 'free for partner',
				'description' => 'free for partner',
				'uid' => '_access_free',
				'rescission' => '',
				'ip' => $id_address,
				'agent' => '',
			);

			$response = CommonHelper::go_call_request($req_arr);
			Log::info('Request Array create_sub', ['Request Array' => $req_arr]);
			$json = json_decode($response->getBody());
			Log::info('Response Array', ['Response Array create_sub' => $json]);
		}

		$last_post = Post::withoutGlobalScopes()->where('user_id', $user_id)->orderBy('created_at', 'desc')->first();

		// Post Data
		$postInfo = [
			'country_code' => config('country.code'),
			'user_id' => $user->id,
			'category_id' => 0,
			'title' => '',
			'description' => '',
			'contact_name' => '',
			'city_id' => 0,
			'email' => $user->email,
			'tmp_token' => md5(microtime() . mt_rand(100000, 999999)),
			'code_token' => md5($user->hash_code),
			'verified_email' => 1,
			'verified_phone' => 1,
			'username' => $wpusername,
			'package' => $last_post->package,
			'subid' => $get_subid,
			'code_without_md5' => $user->hash_code,
		];
		$post = new Post($postInfo);
		$post->save();

		// echo "here";exit;
		// Save ad Id in session (for next steps)
		session(['tmpPostId' => $post->id]);
		// echo "post id" . $post->id . "<br/>";
		$new_post = Post::withoutGlobalScopes()->where('id', session('tmpPostId'))->orderBy('created_at', 'desc')->first();

		if (!empty($new_post)) {
			$currentPayment = Payment::where('post_id', $new_post->id)->orderBy('created_at', 'DESC')->first();

			if (Session::has('tmpPostId')) {
				$post = Post::withoutGlobalScopes()->where('id', session('tmpPostId'))->first();
			}
			$alreadyPaidPackage = false;
			if (!empty($currentPayment)) {
				if ($currentPayment->package_id == $post->package) {
					$alreadyPaidPackage = true;
				}
			}

			// for get ip address and browser details
			// When you call the detect function you will get a result object, from the current user's agent.
			//$browser_detail = \Browser::detect1($_SERVER['HTTP_USER_AGENT']);
			$browser_detail = '';

			// Function to get the client IP address
			$id_address = \Request::getClientIp(true);
			//  for get ip address and browser details
			 
			// Check if Payment is required
			$package = Package::find($post->package); 
			$paymentMethods = PaymentMethod::where('name', 'crm')->first();

			if (!empty($package) && $package->price > 0 && !empty($paymentMethods) && !$alreadyPaidPackage) {

				if ($get_subid == '_access' || $get_subid == '_access_both') {

					$req_arr = array(
						'action' => 'create_sub', //required
						'wpusername' => $user->username ? $user->username : '', // required
						'transactionid' => $post->id,
						'gateway' => $paymentMethods->display_name,
						'type' => $request->get('accept_method'),
						'currency' => $package->currency_code,
						'description' => $package->name,
						'uid' => $get_subid,
						'rescission' => '',
						'ip' => $id_address,
						'agent' => $browser_detail,
					);

					$response = CommonHelper::go_call_request($req_arr);

					if ($response->getStatusCode() == 200) {
						$res = $this->sendPayment($post, $package, $paymentMethods);
						echo json_encode($res);
						die;
					}

				}
			} else {

				if ($get_subid == '_access_free' || $get_subid == '_access_both') {
					$req_arr = array(
						'action' => 'generate_pw', //required
						'wpusername' => $user->username, // required
						'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
					);
					$response = CommonHelper::go_call_request($req_arr);
					Log::info('Request Array generate_pw _access_free', ['Request Array' => $req_arr]);

					$json = json_decode($response->getBody());
					Log::info('Response Array _access_free', ['Response Array generate_pw' => $json]);

					if ($response->getStatusCode() == 200) {
						$body = (string) $response->getBody();
						Log::info('Response Array password _access_free', ['Response password' => $body]);
						$user->password = bcrypt($body);

						$req_arr = array(
							'action' => 'activate', //required
							'wpusername' => $user->username, // required
						);
						$res = CommonHelper::go_call_request($req_arr);
						Log::info('Request Array activate', ['Request Array _access_free' => $req_arr]);
						$json = json_decode($response->getBody());
						Log::info('Response Array', ['Response Array activate _access_free' => $json]);
						if ($res->getStatusCode() == 200) {
							$user->active = 1;
						}

						$user->save();

						$post->ismade = 1;
						$post->save();

						$json['success'] = "package assign done";
						echo json_encode($json);
						Log::info("Response of action assign_package : ".json_encode($json));
						die;
					}
				}
			}
		}
		*/
	}
	// assign package free for model
	function assignPackageForModel($user, $get_subid, $get_language){

		$status = false;
		//  get free package
		$package = Package::where('price', 0.00)->where('user_type_id', 3)->where('country_code', $user->country_code)->first();

		//  get post by user
		$post = Post::withoutGlobalScopes()->select('id','user_id')->where('user_id' , $user->id)->orderBy('id', 'DESC')->first();
		
		if(empty($post)){
			
			// create new post object 
			$post = new Post();
		}
		// Post Data
		$post->country_code = $get_language;
		$post->user_id = $user->id;
		$post->email = $user->email;
		$post->tmp_token = md5(microtime() . mt_rand(100000, 999999));
		$post->code_token = md5($user->hash_code);
		$post->verified_email = 1;
		$post->verified_phone = 1;
		$post->username = $user->username;
		$post->package = ($package->id) ? $package->id : '';
		$post->subid = $get_subid;
		$post->subscribed_payment = 'complete';
		$post->code_without_md5 = $user->hash_code;
		$post->currency_code = ($package->currency_code) ? $package->currency_code : '';
		// $post->ismade = 1;
		$post->subscription_type = 'paid';
		$post->save();

		if($user->password == null || $user->password == ''){

			// call gernate password api
			$req_arr = array(
				'action' => 'generate_pw', //required
				'wpusername' => $user->username, // required
				'sendmail' => true,
			);

			$response = CommonHelper::go_call_request($req_arr);
			// Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

			$json = json_decode($response->getBody());
			// Log::info('Response Array', ['Response Array generate_pw' => $json]);

			if ($response->getStatusCode() == 200) {
			
				$body = (string) $response->getBody();
				// Log::info('Response Array password', ['Response password' => $body]);
				
				$user->password = bcrypt($body);
				$user->save();
				
				// active user api call in CRM
				$req_arr = array(
					'action' => 'activate', //required
					'wpusername' => $user->username, // required
				);

				$res = CommonHelper::go_call_request($req_arr);
				// Log::info('Request Array activate', ['Request Array' => $req_arr]);

				$json = json_decode($response->getBody());
				// Log::info('Response Array', ['Response Array activate' => $json]);
				
				if ($res->getStatusCode() == 200) {
					
					$status = true;
				}
				// $user->save();
			}
		}else{
			$status = true;
		}

		if($status == true){
			$user->active = 1;
			$user->is_register_complated = 1;
			$user->subscribed_payment = 'complete';
			$user->subscription_type = 'free';
			$user->user_register_type = config('constant.user_type_premium_send');
			$status = true;
			$user->save();
		}

			// call gernate password api
			// $req_arr = array(
			// 	'action' => 'generate_pw', //required
			// 	'wpusername' => $user->username, // required
			// 	'sendmail' => true,
			// );

			// $response = CommonHelper::go_call_request($req_arr);
			// Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

			// $json = json_decode($response->getBody());
			// Log::info('Response Array', ['Response Array generate_pw' => $json]);

			// if ($response->getStatusCode() == 200) {
				
			// 	$body = (string) $response->getBody();
			// 	Log::info('Response Array password', ['Response password' => $body]);
				
			// 	$user->password = bcrypt($body);
				
			// 	// active user api call in CRM
			// 	$req_arr = array(
			// 		'action' => 'activate', //required
			// 		'wpusername' => $user->username, // required
			// 	);

			// 	$res = CommonHelper::go_call_request($req_arr);
			// 	Log::info('Request Array activate', ['Request Array' => $req_arr]);

			// 	$json = json_decode($response->getBody());
			// 	Log::info('Response Array', ['Response Array activate' => $json]);
				
			// 	if ($res->getStatusCode() == 200) {
					
			// 		$user->active = 1;
			// 		$user->is_register_complated = 1;
			// 		$user->subscribed_payment = 'complete';
			// 		$user->subscription_type = 'free';
			// 		$status = true;
			// 	}
			// 	$user->save();
			// }
		return $status;
	}
	// assign package free for PArtner
	function assignPackageForPartner($user){

		$status = false;
		
		if($user->password == null || $user->password == ''){
			// generate password Api call in CRM
			$req_arr = array(
				'action' => 'generate_pw', //required
				'wpusername' => $user->username, // required
				'sendmail' => true
			);
			$response = CommonHelper::go_call_request($req_arr);
			// Log::info('Request Array generate_pw partner', ['Request Array' => $req_arr]);
			$json = json_decode($response->getBody());
			// Log::info('Response Array', ['Response Array generate_pw partner' => $response->getBody()]);
			if ($response->getStatusCode() == 200) {
			
				$body = (string) $response->getBody();
				$user->password = bcrypt($body);
				$user->save();

				// user active api call in CRM
				$req_arr = array(
					'action' => 'activate', //required
					'wpusername' => $user->username, // required
				);

				$res = CommonHelper::go_call_request($req_arr);
				// Log::info('Request Array activate partner', ['Request Array' => $req_arr]);
				
				$json = json_decode($response->getBody());
				// Log::info('Response Array', ['Response Array activate partner' => $json]);
				
				if ($res->getStatusCode() == 200) {
					// $user->active = 1;
					// $user->is_register_complated = 1;
					$status = true;
				}
				// $user->save();
			}
		}else{
			$status = true;
		}

		if($status == true){
			$user->active = 1;
			$user->is_register_complated = 1;
			$user->save();
		}
		// generate password Api call in CRM
		// $req_arr = array(
		// 	'action' => 'generate_pw', //required
		// 	'wpusername' => $user->username, // required
		// 	'sendmail' => true
		// );

		// $response = CommonHelper::go_call_request($req_arr);
		// Log::info('Request Array generate_pw partner', ['Request Array' => $req_arr]);
		// $json = json_decode($response->getBody());
		// Log::info('Response Array', ['Response Array generate_pw partner' => $response->getBody()]);

		// if ($response->getStatusCode() == 200) {
			
		// 	$body = (string) $response->getBody();
		// 	$user->password = bcrypt($body);

		// 	// user active api call in CRM
		// 	$req_arr = array(
		// 		'action' => 'activate', //required
		// 		'wpusername' => $user->username, // required
		// 	);

		// 	$res = CommonHelper::go_call_request($req_arr);
		// 	Log::info('Request Array activate partner', ['Request Array' => $req_arr]);
			
		// 	$json = json_decode($response->getBody());
		// 	Log::info('Response Array', ['Response Array activate partner' => $json]);
			
		// 	if ($res->getStatusCode() == 200) {
		// 		$user->active = 1;
		// 		$user->is_register_complated = 1;
		// 	}
		// 	$user->save();
		// 	$status = true;
		// }

		$id_address = \Request::getClientIp(true);

		$req_arr = array(
			'action' => 'create_sub', //required
			'wpusername' => $user->username, // required
			'transactionid' => '',
			'gateway' => 'free for partner',
			'type' => '',
			'currency' => 'free for partner',
			'description' => 'free for partner',
			'uid' => '_access_free',
			'rescission' => '',
			'ip' => $id_address,
			'agent' => '',
		);

		$response = CommonHelper::go_call_request($req_arr);
		// Log::info('Request Array create_sub', ['Request Array' => $req_arr]);
			
		$json = json_decode($response->getBody());
		// Log::info('Response Array', ['Response Array create_sub' => $json]);
		
		return $status;
	}
 
	public function sendPayment(Post $post, Package $package, PaymentMethod $payment_method) {
		// echo "<pre>";
		// print_r($post);
		// print_r($package);
		// print_r($payment_method);
		// echo "</pre>";
		// Save the Payment in database
		// Log::info("Request data : ".json_encode($request->all()));
		if (empty($post)) {
			return null;
			$json['error'] = 'Error occured while saving payment details';
		}

		// Update ad 'reviewed'
		$post->reviewed = 0;
		$post->featured = 0;
		$post->save();

		$price = !empty($package->price) ? $package->price : 0;
		$tax = !empty($package->tax) ? $package->tax : 0;
		$tax_amount = ($price * $tax)/100;
		$transaction_amount = round(($price + $tax_amount));

		$user_id = $post->user_id;
		$tmpToken = $post->tmpToken;
		// Save the payment
		$paymentInfo = [
			'post_id' => $post->id,
			'package_id' => $package->id,
			'payment_method_id' => $payment_method->id,
			'transaction_id' => null,
			'active' => 0,
			'transaction_amount' => (isset($transaction_amount)) ? $transaction_amount : 0,
			'transaction_status' => 'approved',
		];
		$payment = new Payment($paymentInfo);
		$payment->save();

		// Successful transaction
		$json['success'] = trans('offlinepayment::messages.We have received your offline payment request.');

		$params = session('params');
		$user = User::find($post->user_id);
		$req_arr = array(
			'action' => 'pay', //required
			'wpusername' => ($user->username) ? $user->username : '', // required
			'currency' => $package->currency_code,
			'description' => $package->name,
			'amount' => $transaction_amount,
		);

		$response = CommonHelper::go_call_request($req_arr);
		// Log::info('Request Array pay', ['Request Array' => $req_arr]);

		$json1 = json_decode($response->getBody());
		// Log::info('Response Array pay', ['Response Array' => $json1]);
		// Log::info('Response Array staus code', ['Response Array staus code' => $response->getStatusCode()]);

		$status = false;
		
		if ($response->getStatusCode() == 200) {

			if($user->password == null || $user->password == ''){

				$req_arr = array(
					'action' => 'generate_pw', //required
					'wpusername' => $user->username, // required
					'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
				);

				$response = CommonHelper::go_call_request($req_arr);
				// Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

				$json1 = json_decode($response->getBody());
				// Log::info('Response Array generate_pw', ['Response Array' => $json1]);

				if ($response->getStatusCode() == 200) {
					
					$body = (string) $response->getBody();
					// Log::info('Response Array password', ['Response password' => $body]);
					$user->password = bcrypt($body);
					$user->save();

					$req_arr_one = array(
						'action' => 'activate', //required
						'wpusername' => ($user->username) ? $user->username : '', // required
					);
					$res = CommonHelper::go_call_request($req_arr_one);
					// Log::info('Request Array activate finish', ['Request Array' => $req_arr_one]);

					$json1 = json_decode($response->getBody());
					// Log::info('Response Array activate finish', ['Response Array' => $json1]);

					if ($res->getStatusCode() == 200) {
						$status = true;
					}
				}
			}else{
				$status = true;
			}

			if($status == true){

				$user->active = 1;
				$user->subscribed_payment = 'complete';
				$user->subscription_type = 'paid';

				// $user->profile->status = 'ACTIVE';
				$user->profile->save();
				$user->save();
				// $post->ismade = 1;
				// $post->save();
			}


			// $req_arr = array(
			// 	'action' => 'generate_pw', //required
			// 	'wpusername' => $user->username, // required
			// 	'sendmail' => (!in_array($user->provider, ['google','facebook']))? true : false
			// );
			// $response = CommonHelper::go_call_request($req_arr);
			// Log::info('Request Array generate_pw', ['Request Array' => $req_arr]);

			// $json1 = json_decode($response->getBody());
			// Log::info('Response Array generate_pw', ['Response Array' => $json1]);

			// if ($response->getStatusCode() == 200) {
			// 	$body = (string) $response->getBody();
			// 	Log::info('Response Array password', ['Response password' => $body]);
			// 	$user->password = bcrypt($body);

			// 	$req_arr_one = array(
			// 		'action' => 'activate', //required
			// 		'wpusername' => ($user->username) ? $user->username : '', // required
			// 	);
			// 	$res = CommonHelper::go_call_request($req_arr_one);
			// 	Log::info('Request Array activate finish', ['Request Array' => $req_arr_one]);

			// 	$json1 = json_decode($response->getBody());
			// 	Log::info('Response Array activate finish', ['Response Array' => $json1]);

			// 	if ($res->getStatusCode() == 200) {
			// 		$user->active = 1;
			// 		$user->subscribed_payment = 'complete';
			// 		$user->subscription_type = 'paid';

			// 		$user->profile->status = 'ACTIVE';
			// 		$user->profile->save();
			// 	}

			// 	$user->save();

			// 	$post->ismade = 1;
			// 	$post->save();
			// }

		} else {
			// return redirect(config('app.locale') . '/');
			$return = array();
			$return['success'] = $status;
			echo json_encode($return);
		}

		if (Session::has('params')) {
			Session::forget('params');
		}

		// Clear the steps wizard
		if (session()->has('tmpPostId')) {

			// Apply finish actions
			$post->tmp_token = null;
			$post->save();
			session()->forget('tmpPostId');
		}
		Log::info("Response of action sendPayment : ".json_encode($json));
		return $json;

	}

	public function cs_update_transaction($cs_trans_array = array(), $cs_trans_id) {
		foreach ($cs_trans_array as $trans_key => $trans_val) {
			update_post_meta($cs_trans_id, "$trans_key", $trans_val);
		}
	}

	/*set_status
		     * parameters:
		      wpusername, status[active/deactive];
	*/
	public function set_status(Request $request) {
		$requestData =  $request->all();
		// Log::info("Request data : ".json_encode($request->all()));
		$username = $request->input('wpusername');
		$status = $request->input('status'); // active / deactive
		if ($username == '' || empty($username)) {
			$json['error'] = 'username is missing';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action set_status : ".json_encode($json));
			die;
		}
		if ($status == '' || empty($status)) {
			$json['error'] = 'status is missing';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action set_status : ".json_encode($json));
			die;
		}

		$user = User::where('username', $username)->first();

		if (!empty($user)) {
			// $user_id = $user->id;
			//echo $user_id;
			if ($status == 'active') {
				// $user = User::find($user_id);
				$user->active = 1;
				// $user->profile->status = 'ACTIVE';
				$user->save();
				// $user->profile->save();
				// update_user_meta($user_id, 'cs_user_status', 'active');
				$json['success'] = 'user status is activated';
				$json['status'] = true;
				// save api log
				$this->apiLog($requestData, json_encode($json));
				echo json_encode($json);
				// Log::info("Response of action set_status : ".json_encode($json));
				die;
			} else {
				// $user = User::find($user_id);
				$user->active = 0;
				// $user->profile->status = 'INACTIVE';
				$user->save();
				// $user->profile->save();
				// update_user_meta($user_id, 'cs_user_status', 'inactive');
				$json['success'] = 'user status is deactivated';
				$json['status'] = true;
				// save api log
				$this->apiLog($requestData, json_encode($json));
				echo json_encode($json);
				// Log::info("Response of action set_status : ".json_encode($json));
				die;
			}
		} else {
			$json['error'] = 'username is not exists';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::error("Response of action set_status : ".json_encode($json));
			die;
		}
	}

	/*
		action : check_profile
		wpusername : wpusername
	*/
	public function check_profile(Request $request) {
		$requestData =  $request->all();
		// Log::info("Request data : ".json_encode($request->all()));
		$username = $request->input('wpusername');
		if ($username == '' || empty($username)) {
			$json['error'] = 'username is missing';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::info("Response of action check_profile : ".json_encode($json));
			die;
		}
		$user = User::where('username', $username)->first();
		if (!empty($user)) {
			$user_id = $user->id;
			$user_logo = !empty($user->profile->logo) ? \Storage::url($user->profile->logo) : '';

			if (!empty($user_logo)) {
				$json['url'] = $user_logo;
				$json['status'] = true;
			} else {
				$json['error'] = 'image_not_found';
				$json['status'] = false;
			}
			// save api log
			$this->apiLog($requestData, json_encode($json));
			echo json_encode($json);
			// Log::info("Response of action check_profile : ".json_encode($json));
			die;
		}
	}

	/*
		@param : $sedcardtype, $from, $to
		@description : Return latest updated sedcard images in crm for approval.
		@return: sedcard images object
	*/
	/*public function getSedcardByid(Request $request) {
		// Log::info("Request data : ".json_encode($request->all()));
		$offset = 0;
		$limit = 10;

		$req = $request->all();

		if (isset($req['go_code']) && !empty($req['go_code'])) {

			$go_codes = $req['go_code'];
			if(is_string($req['go_code'])){
				$go_codes = array($req['go_code']);
			}

			$sedcardtype = (isset($req['sedcardtype']))? $req['sedcardtype'] : '';
			$application_date = (isset($req['application']) && !empty($req['application']))? $req['application'] : '';
			$payment_date = (isset($req['payment']) && !empty($req['payment']))? $req['payment'] : '';
			$user_type = (isset($req['user_type']) && !empty($req['user_type']))? $req['user_type'] : '';
			$current_date = date('Y-m-d');


			if(isset($application_date) && !empty($application_date)){
				if($current_date < $application_date){
					echo json_encode(array(
						'status' => false,
						'message' => 'Invalid application date',
						'data' => []
					)); exit();
				}
			}

			if(isset($payment_date) && !empty($payment_date)){
				if($current_date < $payment_date){
					echo json_encode(array(
						'status' => false,
						'message' => 'Invalid payment date',
						'data' => []
					)); exit();
				}
			}


			//$req['go_code'] = trim($req['go_code']);

			$data = Sedcard::getPendingSedcardRecordsById($go_codes, $sedcardtype, $user_type, $application_date, $payment_date, $current_date);

			if ($data['status']) {
				echo json_encode($data);
			} else {

				echo json_encode(array(
					'status' => false,
					'message' => $data['message'],
					'data' => []
				));
				Log::error("Response of action getSedcardByid : ".json_encode($data['message']));
			}

		} else {

			echo json_encode(array(
				'status' => false,
				'message' => 'Go-code is required',
				'data' => []
			));
			Log::error("Response of action getSedcardByid : Go-code is required");
		}
	}*/

	/*
		@Request : $request
		@description : Update usersdata by username or email in crm send data.
		@return: message , success, fail
	*/

	public function updateUserData(Request $request){
		$requestData =  $request->all();
		// Log::info("Request data : ".json_encode($request->all()));
		$username = $request->username;

		$requestData['wpusername'] = $username;
		// user_type_id : in crm (1 => model, 4  => partner)

		// if(isset($request->user_type_id)){
		// 	$user_type_id = $request->user_type_id;
		// }
		
		if ($username == '' || empty($username)) {
			$json['message'] = 'username is missing';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action updateUserData : ".json_encode($json));
			echo json_encode($json); exit();
		}

		//get username by userData
		$user = User::where('username', $username)->first();

		if (!empty($user)) {

			$user_type_id = $user->user_type_id;

			if(isset($request->country_code) && !empty($request->country_code)){

				$user->country_code = $request->country_code;
			}

			if(isset($request->latitude) && !empty($request->latitude)){

				$user->latitude = $request->latitude;
			}

			if(isset($request->longitude) && !empty($request->longitude)){

				$user->longitude = $request->longitude;
			}

			$user->save();

			if(isset($request->fname_parent) && !empty($request->fname_parent)){

				$user->profile->fname_parent =  $request->fname_parent;
			}

			if(isset($request->lname_parent) && !empty($request->lname_parent)){

				$user->profile->lname_parent =  $request->lname_parent;
			}

			if(isset($request->first_name) && !empty($request->first_name)){
				$user->profile->first_name =  $request->first_name;
			}

			if(isset($request->last_name) && !empty($request->last_name)){
				$user->profile->last_name =  $request->last_name;
			}

			if(isset($request->street) && !empty($request->street)){
				$user->profile->street =  $request->street;
			}

			if(isset($request->zip) && !empty($request->zip)){
				$user->profile->zip =  $request->zip;
			}

			if(isset($request->city) && !empty($request->city)){
				
				// get city id by city name
				$user->profile->city = $request->city;
				// $city_id = City::getWPCityIdByName($request->city);
				
				// if(!empty($city_id)){
				// 	$user->profile->city = $city_id;
				// }
			}
			
			if(isset($request->category_id) && !empty($request->category_id)){
				
				if($user_type_id == 2){
					
					// get partner category parent_id
					$partnerCategory = Branch::withoutGlobalScopes([ActiveScope::class])->where('slug', $request->category_id)->first();

					$user->profile->category_id = ($partnerCategory->parent_id) ? $partnerCategory->parent_id : 0;
				}
				else{
					
					// get model category parent_id
					$modelCategory = ModelCategory::withoutGlobalScopes([ActiveScope::class])->where('slug', $request->category_id)->first();

					$user->profile->category_id = ($modelCategory->parent_id) ? $modelCategory->parent_id : 0;
				}
			}

			if(isset($request->birth_day) && !empty($request->birth_day)){
				
				$user->profile->birth_day = $request->birth_day;
			}

			if(isset($request->allow_search)){ 

				$user->profile->allow_search = $request->allow_search;
			}
			
			if(isset($request->address_line1) && !empty($request->address_line1)){
				$user->profile->address_line1 = $request->address_line1;
			}

			$user->profile->save();

			$json['message'] = 'UserData Update successfully';
			$json['status'] = true;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::info("Record updated for action updateUserData : ".json_encode($json));
			echo json_encode($json); exit();
		} else {
			
			$json['message'] = 'username does not exists';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action updateUserData : ".json_encode($json));
			echo json_encode($json); exit();
		}
	}

	/*
		@Request : email or username
		@description : get usersdata by username or email in crm send data.
		@return: userData
	*/

	public function getUser(Request $request){

		// Log::info("Request data : ".json_encode($request->all()));
		$user = array();

		if(isset($request->username) && !empty($request->username)){

			$username = $request->username;

			//get username by userData
			$user = User::where('username', $username)->first();
			$requestName = 'username ';
		}
		else if(isset($request->email) && !empty($request->email)){
			$email = $request->email;
			
			//get username by userData
			$user = User::where('email', $email)->first();
			$requestName = 'email ';
		}
		else{
			$json['message'] = 'invalid email or username!';
			$json['status'] = false;
			$json['request'] = $request->all();
			Log::error("Error in action getUser".json_encode($json));
			echo json_encode($json); exit();
		}

		if(!empty($user)){
			
			$userData = array();
			$userProfileData = array();

			$userData['user_id'] = $user->id;
			$userData['email'] = $user->email;
			$userData['active'] = $user->active;
			$userData['user_last_login'] = $user->last_login_at->toDateTimeString();
			$userData['created_at'] = $user->created_at->toDateTimeString();
			$userData['last_update'] = $user->updated_at->toDateTimeString();
			
			// get all model profile data
			if(isset($request->getAllProfileDetail)){
				
				if($request->getAllProfileDetail == true){

					$userProfileData['nickname'] = $user->username;
					$userProfileData['first_name'] = $user->profile->first_name;
					$userProfileData['last_name'] = $user->profile->last_name;
					$userProfileData['description'] = $user->profile->description;
					$userProfileData['user_last_login'] = $user->last_login_at->toDateTimeString();
					$userProfileData['cs_user_last_activity_date'] = $user->updated_at->toDateTimeString();
					$userProfileData['last_update'] = $user->updated_at->toDateTimeString();
					// $userProfileData['cs_user_status'] = strtolower($user->profile->status);
					// commented phone number code
					// $userProfileData['cs_phone_number'] = $user->profile->phone_number;
					$userProfileData['cs_phone_number'] = $user->phone;
					$userProfileData['cs_allow_search'] = ($user->profile->allow_search == 1) ? 'yes' : 'no';

					$category = '';
					$modelCat = '';
					// get model category name by category id
					if(!empty($user->profile->category_id) && $user->user_type_id == 3){
						$modelCat = ModelCategory::withoutGlobalScopes([ActiveScope::class])->select('name','is_baby_model')->where('id', $user->profile->category_id)->first();

						if(!empty($modelCat)){
							$category = ($modelCat->name) ? $modelCat->name : '';
						}
					}

					// get partner category name by category id
					if(!empty($user->profile->category_id) && $user->user_type_id == 2){
						$partnerCat = Branch::withoutGlobalScopes([ActiveScope::class])->select('name')->where('id', $user->profile->category_id)->first();

						if(!empty($partnerCat)){
							$category = ($partnerCat->name) ? $partnerCat->name : '';
						}
					}

					$userProfileData['cs_specialisms'] = $category;

					$logoImg = '';

					// user logo image
					if(!empty($user->profile->logo) && !is_null($user->profile->logo)){
						$logoImg = $this->app_url.'/uploads/'.$user->profile->logo;
					}

					$userProfileData['user_img'] = $logoImg;

					$coverImg = '';

					// user cover image
					if(!empty($user->profile->cover) && !is_null($user->profile->cover)){
						$coverImg = $this->app_url.'uploads/'.$user->profile->cover;
					}

					$userProfileData['cover_user_img'] = $coverImg;

					$userProfileData['cs_facebook'] = $user->profile->facebook;
					$userProfileData['cs_twitter'] = $user->profile->twitter;
					$userProfileData['cs_linkedin'] = $user->profile->linkedin;
					$userProfileData['cs_google_plus'] = $user->profile->google_plus;
					$userProfileData['cs_instagram'] = $user->profile->instagram;
					$userProfileData['cs_pinterest'] = $user->profile->pinterest;
					$userProfileData['cs_post_loc_country'] = strtolower($user->country_code);
					$userProfileData['cs_post_loc_city'] = $user->profile->city;
					$userProfileData['cs_post_comp_address'] = $user->profile->address_line1;
					$userProfileData['cs_post_loc_latitude'] = $user->latitude;
					$userProfileData['cs_post_loc_longitude'] = $user->longitude;



					// $cs_award_list_array = array();
					$cs_award_array = array();

					// $cs_award_name_array = array();
					// $cs_award_year_array = array();
					// $cs_award_description_array = array();
					 
					 
			 		// get favorite user References
					if(isset($user->userReferences) && !empty($user->userReferences) && $user->userReferences->count() > 0){
						$i = 0;
						$k = 1;
						foreach ($user->userReferences as $references) {
							
							$cs_award_array[$i]['id'] = $references->id;
							$cs_award_array[$i]['title'] = $references->title;
							$cs_award_array[$i]['date'] = $references->date;
							$cs_award_array[$i]['description'] = $references->description;

							// $cs_award_list_array[$i] = $references->id;
							// $cs_award_name_array[$i] = $references->title;
							// $cs_award_year_array[$i] = $references->date;
							// $cs_award_description_array[$i] = $references->description;

							$userProfileData['cs_award_name_pop_'.$k] = $references->title;
							$userProfileData['cs_award_year_pop_'.$k] = $references->date;
							
							$k++;
							$i++;
						}
					}else{
						$userProfileData['cs_award_name_pop'] = '';
						$userProfileData['cs_award_year_pop'] = '';
					}

					$userProfileData['cs_award_array'] = json_encode($cs_award_array);

					
					// $userProfileData['cs_award_list_array'] = json_encode((Object)array_unique($cs_award_list_array));
					// $userProfileData['cs_award_name_array'] = json_encode((Object)array_unique($cs_award_name_array));
					// $userProfileData['cs_award_year_array'] = json_encode((Object)array_unique($cs_award_year_array));
					// $userProfileData['cs_award_description_array'] = json_encode((Object)array_unique($cs_award_description_array));


					// get user talent (skills)
					$user_talents = '';
					$cs_skills_array = array();
					// $userTalentIdArr = array();
					// $userTalentTitleArr = array();
					// $userTalentPercentageArr = array();
					
					if(isset($user->userTalentes) && !empty($user->userTalentes) && $user->userTalentes->count() > 0){
						$i = 0;
						foreach ($user->userTalentes as $key => $value) {

							if(!empty($value->title)){
								$user_talents .= !empty($value->title) ? $value->title : '';
							 	$user_talents .=', ';

							 	$cs_skills_array[$i]['id'] = $value->id;
							 	$cs_skills_array[$i]['title'] =$value->title;
							 	$cs_skills_array[$i]['percentage'] = $value->proportion; 

							 	// $userTalentIdArr[$i] = $value->id;
							 	// $userTalentTitleArr[$i] = !empty($value->title) ? $value->title : '';
							 	// $userTalentPercentageArr[$i] = $value->proportion; 
							 	$i++;
							}
						}

						$user_talents = rtrim($user_talents, ', ');
					}
					
					$userProfileData['cs_skill_title'] = $user_talents;

					$userProfileData['cs_skill_array'] = json_encode($cs_skills_array);

					// $userProfileData['cs_skill_percentage_array'] = json_encode((Object)array_unique($userTalentPercentageArr));
					// $userProfileData['cs_skills_list_array'] = json_encode((Object)array_unique($userTalentIdArr));
					// $userProfileData['cs_skill_title_array'] = json_encode((Object)array_unique($userTalentTitleArr));

					$cs_education_array = array();

					// $cs_edu_list_array = array();
					// $cs_edu_title_array = array();
					// $cs_edu_from_date_array = array();
					// $cs_edu_to_date_array = array();
					// $cs_edu_institute_array = array();
					// $cs_edu_desc_array = array();

					// get user educations (skills)
					if(isset($user->userEducations) && !empty($user->userEducations) && $user->userEducations->count() > 0){
						$i = 1;
						$k = 0;
						foreach ($user->userEducations as $key => $edu) {
							
							if(!empty($edu->title) && !is_null($edu->title)){
 
								$cs_education_array[$k]['id'] = $edu->id;
								$cs_education_array[$k]['title'] = $edu->title;
								$cs_education_array[$k]['from_date'] = $edu->from_date;
								$cs_education_array[$k]['to_date'] = $edu->to_date;
								$cs_education_array[$k]['institute'] = $edu->institute;
								$cs_education_array[$k]['description'] = $edu->description;

								// $cs_edu_list_array[$k] = $edu->id;
								// $cs_edu_title_array[$k] = $edu->title;
								// $cs_edu_from_date_array[$k] = $edu->from_date;
								// $cs_edu_to_date_array[$k] = $edu->to_date;
								// $cs_edu_institute_array[$k] = $edu->institute;
								// $cs_edu_desc_array[$k] = $edu->description;
								
								$userProfileData['cs_edu_title_'.$i] = $edu->title;
								$userProfileData['cs_edu_from_date_'.$i] = $edu->from_date;
								$userProfileData['cs_edu_to_date_'.$i] = $edu->to_date;
								$userProfileData['cs_edu_institute_'.$i] = $edu->institute;
								$userProfileData['cs_edu_desc_'.$i] = $edu->description;
								$i++;
								$k++;
							}
						}
					}else{
						$userProfileData['cs_edu_title'] = '';
						$userProfileData['cs_edu_from_date'] = '';
						$userProfileData['cs_edu_to_date'] = '';
						$userProfileData['cs_edu_institute'] = '';
						$userProfileData['cs_edu_desc'] = '';
					}
					$userProfileData['cs_education_array'] = json_encode($cs_education_array);

					// $userProfileData['cs_edu_list_array'] = json_encode((Object)array_unique($cs_edu_list_array));
					// $userProfileData['cs_edu_title_array'] = json_encode((Object)array_unique($cs_edu_title_array));
					// $userProfileData['cs_edu_from_date_array'] = json_encode((Object)array_unique($cs_edu_from_date_array));
					// $userProfileData['cs_edu_to_date_array'] = json_encode((Object)array_unique($cs_edu_to_date_array));
					// $userProfileData['cs_edu_institute_array'] = json_encode((Object)array_unique($cs_edu_institute_array));
					// $userProfileData['cs_edu_desc_array'] = json_encode((Object)array_unique($cs_edu_desc_array));

					$cs_eriences_array = array();

					// $cs_exp_list_array = array();
					// $cs_exp_title_array = array();
					// $cs_exp_from_date_array = array();
					// $cs_exp_to_date_array = array();
					// $cs_exp_company_array = array();
					// $cs_exp_desc_array = array();
					// get user Experiences
					if(isset($user->userExperiences) && !empty($user->userExperiences) && $user->userExperiences->count() > 0){
						$i = 1;
						$k = 0;
						foreach ($user->userExperiences as $exp) {
							
							if(!empty($exp->title) && !is_null($exp->title)){

								$cs_eriences_array[$k]['id'] = $exp->id;
								$cs_eriences_array[$k]['title'] = $exp->title;
								$cs_eriences_array[$k]['from_date'] = $exp->from_date;
								$cs_eriences_array[$k]['to_date'] = $exp->to_date;
								$cs_eriences_array[$k]['up_to_date'] = ($exp->up_to_date == 1) ? 'on' : '';
								$cs_eriences_array[$k]['company'] = $exp->company;
								$cs_eriences_array[$k]['description'] = $exp->description;



								// $cs_exp_list_array[$k] = $exp->id;
								// $cs_exp_title_array[$k] = $exp->title;
								// $cs_exp_from_date_array[$k] = $exp->from_date;
								// $cs_exp_to_date_array[$k] = $exp->to_date;
								// $cs_exp_to_present_array[$k] = ($exp->up_to_date == 1) ? 'on' : '';
								// $cs_exp_company_array[$k] = $exp->company;
								// $cs_exp_desc_array[$k] = $exp->description;

								$userProfileData['cs_exp_title_'.$i] = $exp->title;
								$userProfileData['cs_exp_from_date_'.$i] = $exp->from_date;
								$userProfileData['cs_exp_to_date_'.$i] = $exp->to_date;
								$userProfileData['cs_exp_company_'.$i] = $exp->company;
								$userProfileData['cs_exp_desc_'.$i] = $exp->description;
								$userProfileData['cs_exp_to_present_till_'.$i] = ($exp->up_to_date == 1) ? 'on' : '';
								$i++;
								$k++;
							}
						}
					}else{
						
						$userProfileData['cs_exp_title'] = '';
						$userProfileData['cs_exp_from_date'] = '';
						$userProfileData['cs_exp_to_date'] = '';
						$userProfileData['cs_exp_company'] = '';
						$userProfileData['cs_exp_desc'] = '';
					}

					$userProfileData['cs_eriences_array'] = json_encode($cs_eriences_array);

					// $userProfileData['cs_exp_list_array'] = json_encode((Object)array_unique($cs_exp_list_array));
					// $userProfileData['cs_exp_title_array'] = json_encode((Object)array_unique($cs_exp_title_array));
					// $userProfileData['cs_exp_from_date_array'] = json_encode((Object)array_unique($cs_exp_from_date_array));
					// $userProfileData['cs_exp_to_present_array'] = json_encode((Object)array_unique($cs_exp_to_present_array));
					// $userProfileData['cs_exp_company_array'] = json_encode((Object)array_unique($cs_exp_company_array));
					// $userProfileData['cs_exp_desc_array'] = json_encode((Object)array_unique($cs_exp_desc_array));
					 

					$resume = '';
					// get user Resume
					if(isset($user->resume) && !empty($user->resume) && $user->resume->count() > 0){
						if(!empty($user->resume->filename) && !is_null($user->resume->filename)){
							$resume = $this->app_url.'uploads/'.$user->resume->filename;
						}
					}

					$userProfileData['cs_candidate_cv'] = $resume;

					$age = '';
					$birth = '';
					// get user Age
					if(!empty($user->profile->birth_day) && !is_null($user->profile->birth_day)){
						$from = new \DateTime($user->profile->birth_day);
						$to = new \DateTime('today');
						$age = $from->diff($to)->y. ' Age';
						$birth = $user->profile->birth_day;
					}
					
					$userProfileData['c_birthday'] = $birth;
					$userProfileData['show-age'] = $age;

					$cs_array_data_Arr = array();

					$cs_array_data_Arr['cs_user_last_activity_date'] = $user->updated_at->toDateTimeString();
					$cs_array_data_Arr['cs_allow_search'] = ($user->profile->allow_search == 1) ? 'yes' : 'no';
					$cs_array_data_Arr['cs_post_loc_country'] = strtolower($user->country_code);
					$cs_array_data_Arr['cs_post_comp_address'] = $user->profile->address_line1;
					$cs_array_data_Arr['cs_post_loc_city'] = $user->profile->city;
					$cs_array_data_Arr['cs_post_loc_address'] = $user->profile->street;

					$userProfileData['cs_array_data'] = json_encode((Object)array_unique($cs_array_data_Arr));
					
					
					$userProfileData['billing_address_1'] = $user->profile->address_line1;
					$userProfileData['billing_address_2'] = $user->profile->address_line2;
					$userProfileData['billing_city'] = $user->profile->city;
					$userProfileData['billing_postcode'] = $user->profile->zip;
					$userProfileData['billing_country'] = strtolower($user->country_code);


					// get user Languages
					if(isset($user->userLanguages) && !empty($user->userLanguages) && $user->userLanguages->count() > 0){

						$getLanguagesArray = Language::pluck('name', 'abbr')->toArray();

						$i = 1;
						foreach ($user->userLanguages as $language) {
							
							if(!empty($language->language_name) && !is_null($language->language_name)){

								if(isset($getLanguagesArray[$language->language_name])){
									$userProfileData['language_'.$i] = $getLanguagesArray[$language->language_name];
									$i++;
								}
							}
						}
					}

					$userProfileData['cs_user'] = $user->id;
					$userProfileData['cs_port_list_array'] = $user->profile->wp_cs_port_list;

					$modelBookArr = array();
					
					// get user modelBook images
					if(isset($user->modelbook) && !empty($user->modelbook) && $user->modelbook->count() > 0){
						
						$i = 0;
						foreach ($user->modelbook as $modelbook) {
							
							$modelBookArr[$i]['title'] = $modelbook->name;
							if(!empty($modelbook->filename) && !is_null($modelbook->filename)){
								$modelBookArr[$i]['filename'] = $this->app_url.'uploads/'.$modelbook->filename;
							}else{
								$modelBookArr[$i]['filename'] = '';
							}
							if(!empty($modelbook->cropped_image) && !is_null($modelbook->cropped_image) && Storage::exists($modelbook->cropped_image)){
								$modelBookArr[$i]['cropped_image'] = $this->app_url.'uploads/'.$modelbook->cropped_image;
							}else{
								$modelBookArr[$i]['cropped_image'] = '';
							}
							$i++;
						}
					}


					$userProfileData['cs_images_array'] = json_encode($modelBookArr);

					$jobIdArr = array(); 

					// get user Job Application
					if(isset($user->jobApplication) && !empty($user->jobApplication) && $user->jobApplication->count() > 0){
						$i = 0;
						foreach ($user->jobApplication as $jobs) {
							$jobIdArr[$i]['post_id'] = $jobs->post_id;
							$jobIdArr[$i]['date_time'] = $jobs->created_at->toDateTimeString();
							$i++;
						}
					}

					// default unit code
					$default_unit_code = config('app.default_units_country').config('app.units_alias');
					// get height unit code by user country
					$height_unit_code = !empty($user->country->height_units) ? $user->country->height_units.config('app.units_alias') : $default_unit_code ;

					// get weight unit code by user country
					$weight_unit_code = !empty($user->country->weight_units) ? $user->country->weight_units.config('app.units_alias') : $default_unit_code ;
					

					$height = 0;

					if(isset($user->profile->getHeight) && $user->profile->getHeight->count() > 0){
					 	 
				 	 	$height = ($user->profile->getHeight->$height_unit_code) ? $user->profile->getHeight->$height_unit_code : 0;
					}

					$weight = 0;

					if(isset($user->profile->getWeight) && $user->profile->getWeight->count() > 0){
					 	 
				 	 	$weight = ($user->profile->getWeight->$weight_unit_code) ? $user->profile->getWeight->$weight_unit_code : 0;
					}

					$userProfileData['cs-jobs-applied'] = json_encode($jobIdArr);
					$userProfileData['cs_street'] = $user->profile->street;
					$userProfileData['cs_zip_code'] = $user->profile->zip;
					$userProfileData['cs_loc_iso_code'] = $user->country_code;
					$userProfileData['term_and_condi'] = 'yes';
					$userProfileData['user_hash'] = $user->hash_code;
					$userProfileData['cs_tfp'] = ($user->profile->tfp == 1) ? 'yes' : 'no';
					// $userProfileData['cs_candidate_height'] = $user->profile->height_id;
					$userProfileData['cs_candidate_height'] = $height;
					// $userProfileData['cs_candidate_weight'] = $user->profile->weight_id;
					$userProfileData['cs_candidate_weight'] = $weight;


					$dress_size = '';
					$shoe_size = '';

					$dress_size_unit_alias = config('app.units_alias');
					$dress_size_unit_cat_alias = "";

					$shoe_size_unit_alias = config('app.units_alias');
					$shoe_size_unit_cat_alias = "";

					$is_baby_model = 0;

				 	if(!empty($modelCat) && isset($modelCat->is_baby_model)){
				 		$is_baby_model = $modelCat->is_baby_model;
				 	} 

				 	if($user->user_type_id == 3){

				 		if($is_baby_model == 1){
							
							$dress_size_unit_cat_alias = config('app.kid_alias');
							$shoe_size_unit_cat_alias = config('app.kid_alias');
				 		}

				 		if($is_baby_model != 1 && $user->gender_id == config('constant.gender_male')){
				 			
				 			$dress_size_unit_cat_alias = config('app.women_alias');
				 			$shoe_size_unit_cat_alias = config('app.women_alias');
				 		}

				 		if($is_baby_model != 1 && $user->gender_id == config('constant.gender_female')){
				 			
				 			$dress_size_unit_cat_alias = config('app.women_alias');
				 			$shoe_size_unit_cat_alias = config('app.women_alias');
				 		}

				 		if(isset($user->country->dress_size_unit) && !empty($user->country->dress_size_unit) && $user->country->dress_size_unit != null ){

				 			$dress_size_unit_code = $user->country->dress_size_unit;
						}else{

							$dress_size_unit_code = config('app.default_units_country');
							$dress_size_unit_cat_alias = "";
						}

						$dress_column = $dress_size_unit_code.$dress_size_unit_alias.$dress_size_unit_cat_alias;

						if(!empty($user->profile->size_id)){

							$dressSizeunits = UserDressSizeOptions::select($dress_column)->where('id' , $user->profile->size_id)->first();

							if(isset($dressSizeunits->$dress_column)){
								$dress_size = $dressSizeunits->$dress_column;
							}
						}

						if(isset($user->country->shoe_units) && !empty($user->country->shoe_units) && $user->country->shoe_units != null ){

				 			$shoe_size_unit_code = $user->country->shoe_units;
						}else{

							$shoe_size_unit_code = config('app.default_units_country');
							$shoe_size_unit_cat_alias = "";
						}

						$shoe_column = $shoe_size_unit_code.$shoe_size_unit_alias.$shoe_size_unit_cat_alias;

						if(!empty($user->profile->shoes_size_id)){

							$shoeSizeunits = UserShoesUnitsOptions::select($shoe_column)->where('id' , $user->profile->shoes_size_id)->first();

							if(isset($shoeSizeunits->$shoe_column)){
								$shoe_size = $shoeSizeunits->$shoe_column;
							}
						}
					} 

					$userProfileData['cs_candidate_clothing_size'] = $dress_size;
					
					$eyeColor = '';
					//  model Eye color
		          	if(!empty($user->profile->eye_color_id) && $user->profile->eye_color_id != 0){
			            
			            $eye_color_id = $user->profile->eye_color_id;

						// get eyeColor by user eye_color_id
			            $eyeColorObj = ValidValueTranslation::select('slug')
					              	->where('valid_value_id', $eye_color_id)
					              	->where('locale', 'en')
					             	->first();

					    if(!empty($eyeColorObj) && isset($eyeColorObj->slug)){
		             		$eyeColor = $eyeColorObj->slug;
		             	}
					}

					$hairColor = '';
					
					//  model Hair color
		          	if(!empty($user->profile->hair_color_id) && $user->profile->hair_color_id != 0){
			            
			            $hair_color_id = $user->profile->hair_color_id;

						// get hairColor by user hair_color_id
			            $hairColorObj = ValidValueTranslation::select('slug')
					              	->where('valid_value_id', $hair_color_id)
					              	->where('locale', 'en')
					             	->first();

					    if(!empty($hairColorObj) && isset($hairColorObj->slug)){
		             		$hairColor = $hairColorObj->slug;
		             	}
					}

					$chest_id = 0;
					$waist_id = 0;
					$hips_id = 0;

					//  model Chest
		          	if(!empty($user->profile->chest_id) && $user->profile->chest_id != 0){
			            
			            $chest_id = $user->profile->chest_id;
					}
					//  model Waist
		          	if(!empty($user->profile->waist_id) && $user->profile->waist_id != 0){
			            
			            $waist_id = $user->profile->waist_id;
					}
					//  model Hips
		          	if(!empty($user->profile->hips_id) && $user->profile->hips_id != 0){
			            
			            $hips_id = $user->profile->hips_id;
					}

					$skinColor = '';
					//  model Skin color
		          	if(!empty($user->profile->skin_color_id) && $user->profile->skin_color_id != 0){
			            
			            $skin_color_id = $user->profile->skin_color_id;

			            // get skinColor by user skin_color_id
			            $skinColorObj = ValidValueTranslation::select('slug')
					              	->where('valid_value_id', $skin_color_id)
					              	->where('locale', 'en')
					             	->first();

					    if(!empty($skinColorObj) && isset($skinColorObj->slug)){
		             		$skinColor = $skinColorObj->slug;
		             	}
					}

					$userProfileData['cs_candidate_eyecolor'] = $eyeColor;
					$userProfileData['cs_candidate_haircolor'] = $hairColor;
					$userProfileData['cs_candidate_skincolor'] = $skinColor;
					$userProfileData['cs_size'] = $chest_id.'-'.$waist_id.'-'.$hips_id;
					$userProfileData['cs_candidate_shoes_size'] = $shoe_size;
					$userProfileData['cs_sex'] = ($user->gender_id == 1) ? 'male' : 'female';
					$userProfileData['cs_piercing'] = ($user->profile->piercing == 1) ? 'yes' : 'no';
					$userProfileData['cs_tattoo'] = ($user->profile->tattoo == 1) ? 'yes' : 'no';
					$userProfileData['go_code'] = $user->profile->go_code;

					$subscription_type = '';
					$selected_package = '';
					$transaction_id = '';
					$transaction_status = '';

					//  get post by user
					$post = Post::withoutGlobalScopes()->select('id','user_id')->where('user_id' , $user->id)->orderBy('id', 'DESC')->first();

					if(isset($post->id)){

				 		//  get payment details by user
			 		 	$payment = payment::where('post_id' , $post->id)->orderBy('id', 'DESC')->first();

			 		 	if(isset($payment->id)){

			 		 		$transaction_status = $payment->transaction_status;
							$transaction_id = $payment->transaction_id;


			 		 		if(!is_null($payment->package_id) && !empty($payment->package_id)){

			 		 			// get package details by users
			 		 			$pacakge = Package::where('id' , $payment->package_id)->first();

			 		 			if(isset($pacakge->id)){

									$subscription_type = ($pacakge->package_uid == '_access_free') ? 'FREE' : 'PREMIUM';
			 		 				$selected_package = $payment->package_id;
			 		 			}
			 		 		}
			 		 	}
			 		}

			 		$userProfileData['subscription_type'] = $subscription_type;
			 		$userProfileData['_selected_package'] = $selected_package;
			 		$userProfileData['_cs_transaction_id'] = $transaction_id;
			 		$userProfileData['_transaction_id_created'] = $transaction_id;
			 		$userProfileData['subscription_payment'] = $transaction_status;

			 		$favoriteUserArr = array();
			 		// get favorite user Application
					if(isset($user->favoriteUser) && !empty($user->favoriteUser) && $user->favoriteUser->count() > 0){
						$i = 0;
						foreach ($user->favoriteUser as $fav) {
							
							$favoriteUserArr[$i]['user_id'] = $fav->fav_user_id;
							
							if(!empty($fav->created_at) && !is_null($fav->created_at)){
								$favoriteUserArr[$i]['date_time'] = strtotime($fav->created_at->toDateTimeString());
							}
							$i++;
						}
					}

					$userProfileData['cs-user-resumes-wishlist'] = json_encode($favoriteUserArr);


					$favoritePostArr = array();
			 		// get favorite user Application
					if(isset($user->favoritePost) && !empty($user->favoritePost) && $user->favoritePost->count() > 0){
						$i = 0;
						foreach ($user->favoritePost as $favPost) {
							
							$favoritePostArr[$i]['post_id'] = $favPost->post_id;
							$favoritePostArr[$i]['date_time'] = !empty($favPost->created_at) && !is_null($favPost->created_at)? strtotime($favPost->created_at->toDateTimeString()) : '';
							$i++;
						}
					}

					$userProfileData['cs-user-jobs-wishlist'] = json_encode($favoritePostArr);

					$userProfileData['cs_ip_address'] = $user->profile->ip_address;

					$userProfileData['cs_user_agent'] = $user->profile->user_agent;

					$userProfileData['p_first_name'] = $user->profile->fname_parent;
					$userProfileData['p_last_anme'] = $user->profile->lname_parent;
					$userProfileData['cs_city'] = $user->profile->city;
					$userProfileData['cs_iso_code'] = $user->country_code;
					$userProfileData['_terms_condition_check'] = 'yes';


					// $cs_sedcard_image_upload_array = array();
					// $sed_card_edited_images = array();
					$cs_sedcard_image_array = array();
					// get user Sedcard
					if(isset($user->userSedcard) && !empty($user->userSedcard) && $user->userSedcard->count() > 0){
						
						$i = 0;
						foreach ($user->userSedcard as $sedcard) {

							$show_title = '';
							if($sedcard->image_type == 1){
								$show_title = 'Portrait photo';
							}elseif($sedcard->image_type == 2) {
							 	$show_title = 'Whole body photo';
							}elseif($sedcard->image_type == 3) {
							 	$show_title = 'Beauty Shot';
							}elseif($sedcard->image_type == 4) {
							 	$show_title = 'Outfit';
							}elseif ($sedcard->image_type == 5) {
							 	$show_title = 'Free choice';
							}

							if(!empty($show_title)){

								$cs_sedcard_image_array[$i]['image_type'] = $show_title;
								if(!empty($sedcard->filename) && !is_null($sedcard->filename)){
									$cs_sedcard_image_array[$i]['filename'] = $this->app_url.'uploads/'.$sedcard->filename;
								}else{
									$cs_sedcard_image_array[$i]['filename'] = '';
								}
								
								if(!empty($sedcard->cropped_image) && !is_null($sedcard->cropped_image) && Storage::exists($sedcard->cropped_image)){
									$cs_sedcard_image_array[$i]['cropped_image'] = $this->app_url.'uploads/'.$sedcard->cropped_image;
								}else{
									$cs_sedcard_image_array[$i]['cropped_image'] = '';
								}


								// $cs_sedcard_image_upload_array[$i]['image_type'] = $show_title;
								// $cs_sedcard_image_upload_array[$i]['filename'] = $sedcard->filename;
								// $sed_card_edited_images[$i]['image_type'] = $show_title;
								// $sed_card_edited_images[$i]['filename'] = $sedcard->cropped_image;
								$i++;
							}
						}
					}


					// $userProfileData['cs_sedcard_image_upload_array'] = json_encode($cs_sedcard_image_upload_array);
					$userProfileData['cs_sedcard_image_array'] = json_encode($cs_sedcard_image_array);
					// $userProfileData['sed_card_edited_images'] = json_encode($sed_card_edited_images);
				}
			}

			$json['message'] = 'success';
			$json['user'] = $userData;
			$json['userprofileData'] = $userProfileData;
			$json['status'] = true;
			// Log::info("found records for action getUser".json_encode($json));
			echo json_encode($json); exit();
		}
		else{
			
			$json['message'] = $requestName.'does not exists';
			$json['status'] = false;
			Log::error("Error in action getUser".json_encode($json));
			echo json_encode($json); exit();
		}
	}


	/*
		@description : get post data.
		@return: post date and count.
	*/

	public function getPostHighchartData(Request $request){
		// Log::info("Request data : ".json_encode($request->all()));
		echo $now = time();
		echo "<br />".$days = 30;

		try{

			$results = DB::table('posts')
					->select(DB::raw('DATE(created_at) as day, COUNT(id) as count'))
					->where(DB::raw('UNIX_TIMESTAMP(created_at)'), '>', $now - 86400*$days)
					->groupBy('day')
					->orderBy('day', 'ASC')
					->get();
			$json['message'] = 'success';
			$json['data'] = $results;
			$json['status'] = true;
			// Log::info("Response in action getPostHighchartData".json_encode($json));
			echo json_encode($json); exit();
		}
        catch(\Exception $e){

        	$json['message'] =$e->getMessage();
			$json['status'] = false;
			// Log::info("Response in action getPostHighchartData".json_encode($json));
			echo json_encode($json); exit();
		}
	}

	/*
		@Request : email and password
		@description : update User Password
		@return: status, true, false
	*/

	public function updateUserPassword(Request $request){

		// Log::info("Request data : ".json_encode($request->all()));
		$requestData =  $request->all();

		if(isset($request->email) && !empty($request->email)){

				$email = $request->email;
			
				//get username by userData
				$user = User::where('email', $email)->first();

				$requestData['wpusername'] = isset($user->username) ? $user->username : '';

				if(empty($user)){
					$json['message'] = 'invalid email address';
					$json['status'] = false;

					// save api log
					$this->apiLog($requestData, json_encode($json));
					// Log::error("Error found for action updateUserPassword : ".json_encode($json));
					echo json_encode($json); exit();
				}
			if(isset($request->password) && !empty($request->password)){
				$password = bcrypt($request->password);
				$user->password = $password;
				$user->save();
				
				$json['message'] = 'Password update successfully';
				$json['status'] = true;
				// save api log
				$this->apiLog($requestData, json_encode($json));
				// Log::info("record updated for updateUserPassword : ".json_encode($json));
				echo json_encode($json); exit();
			}else{
				$json['message'] = 'Password is required!';
				$json['status'] = false;
				// save api log
				$this->apiLog($requestData, json_encode($json));
				// Log::error("Error found for action updateUserPassword : ".json_encode($json));
				echo json_encode($json); exit();
			}
		}else{
			$json['message'] = 'please enter email address';
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action updateUserPassword : ".json_encode($json));
			echo json_encode($json); exit();
		}
	}

	function createUser(Request $request) {
		// Log::info("Request data : ".json_encode($request->all()));
		$requestData =  $request->all();
		$username = $request->wpusername;
		$email = $request->email;
		$user_type = $request->type;

		if(empty($user_type)){
			 
			$json['message'] = "User type is required";
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action createUser : ".json_encode($json));
			echo json_encode($json); exit();
		}
		
		if (empty($request->wpusername)) {
			 
			$json['message'] = "User name is required";
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action createUser : ".json_encode($json));
			echo json_encode($json); exit();
		}
		
		if (empty($request->industry)) {
			$json['message'] = "Please enter a industry.";
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action createUser : ".json_encode($json));
			echo json_encode($json); exit();
		}

		if (empty($request->wppass)) {

			$json['message'] = "Passowrd are required.";
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action createUser : ".json_encode($json));
			echo json_encode($json); exit();
		}

		if(empty($request->country)){
			$json['message'] = "Country are required.";
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action createUser : ".json_encode($json));
			echo json_encode($json); exit();
		}

		$country_code = Country::getCountryCodeByName($request->country);

		if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $email)) {

			$json['message'] = "Please enter a valid email.";
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action createUser : ".json_encode($json));
			echo json_encode($json); exit();
		}

		$is_user_exist = User::where('email', $email)->first();


		if (!empty($is_user_exist)) {

			$json['message'] = "User already exists. Please try another one.";
			$json['status'] = false;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::error("Error found for action createUser : ".json_encode($json));
			echo json_encode($json); exit();
		} else {


			$user_type_id = 3;
			if($user_type == 'partner'){
				$user_type_id = 2;
			}
			
			$hash_code = $this->getHashCode();

			$user = new User();
			$user->username = $username;
			$user->user_type_id = $user_type_id;
			$user->email = $email;
			$user->password = bcrypt($request->wppass);
			$user->country_code = $country_code;
			$user->subscribed_payment = 'complete';
			$user->updated_at = strtotime(date('d-m-Y'));
			$user->email_token = md5(microtime() . mt_rand());
			$user->phone_token = mt_rand(100000, 999999);
			$user->verified_email = 0;
			$user->verified_phone = 1;
			// commented phone number code
			if(isset($request->tel) && !empty($request->tel)){
				$user->phone = $request->tel;
			}
			$user->save();
			$user_id = $user->id;

			App::setLocale('en');

			// Send Admin Notification Email
			if (config('settings.mail.admin_email_notification') == 1) { 
				try {
					// Get all admin users
					$admins = User::where('is_admin', 1)->get();

					if ($admins->count() > 0) {
						foreach ($admins as $admin) {
							// send admin mail
							Mail::send(new UserNotification($user, $admin));
						}
					}
					// Send user mail
					$sendUserMail = $this->sendVerificationEmail($user); 
				
				} catch (\Exception $e) {
					
					$json['status'] = false;
					$json['message'] = $e->getMessage();
					Log::error("Error found for action createUser : ".json_encode($json));
					echo json_encode($json); exit();
				}
			}

			if ($user_type_id == 2) {

				$userprofile = new UserProfile();

				// get partner category parent_id
				$partnerCategory = Branch::withoutGlobalScopes([ActiveScope::class])->where('slug', $request->industry)->first();

				$profileInfo['category_id'] = ($partnerCategory->parent_id) ? $partnerCategory->parent_id : 0;

				if(isset($request->company) && !empty($request->company)){
					$userprofile->company_name = $request->company;
				}
				if(isset($request->fname) && !empty($request->fname)){

					$userprofile->first_name = $request->fname;
				}
				if(isset($request->lname) && !empty($request->lname)){

					$userprofile->last_name = $request->lname;
				}
				// commented phone number code
				// if(isset($request->tel) && !empty($request->tel)){

				// 	$userprofile->phone_number = $request->tel;
				// }
				if(isset($request->street) && !empty($request->street)){
					$userprofile->street = $request->street;
				}
				if(isset($request->zip) && !empty($request->zip)){
					$userprofile->zip = $request->zip;
				}
				if(isset($request->city) && !empty($request->city)){
					$userprofile->city = $request->city;
				}
				// if(isset($request->country) && !empty($request->country)){
					
				// 	$userprofile->country = $request->country;
				// }
				if(isset($request->url) && !empty($request->url)){

					$userprofile->website_url = $request->url;
				}
				$userprofile->allow_search = 1;
				$userprofile->user_id = $user_id;

				$userprofile->save();
				
				if(isset($request->company) && !empty($request->company)){
					$companyObj = new Company();

					$companyObj->user_id = $user->id;
					$companyObj->name = $request->company;
					$companyObj->country_code = $country_code;
					// save company
					$companyObj->save();
				}
			}
			
			$json['message'] = "User Create successfully";
			$json['status'] = true;
			// save api log
			$this->apiLog($requestData, json_encode($json));
			// Log::info("Response for action createUser : ".json_encode($json));
			echo json_encode($json); exit();
		}
	}

	public function mauticData(Request $request){

		// Log::info("Request data : ".json_encode($request->all()));
		if(!isset($request->username) || empty($request->username)){
			$json['message'] = 'username is missing';
			$json['status'] = false;
			Log::error("Error found for action mauticData : ".json_encode($json));
			echo json_encode($json); exit();
		}
		else{
			
			// get user by userName
		  	$userObj = User::where('username', $request->username)->first();

		  	$hairColor = '';
		  	$height_id = 0;
		  	$weight_id = 0;
		  	$eyeColor = '';
		  	$chest_id = 0;
		  	$waist_id = 0;
		  	$hips_id = 0;
		  	$shoes_size_id = 0;
		  	// $dress_size_id = 0;
		  	$skinColor = '';
		  	$piercing= 'no';
		  	$tattoo= 'no';

		  	if(isset($userObj->profile) && !empty($userObj->profile)){

		  		//  model Hair color
	          	if(!empty($userObj->profile->hair_color_id) && $userObj->profile->hair_color_id != 0){
		            
		            $hair_color_id = $userObj->profile->hair_color_id;
		            // get haircolor by user hair_color_id
		            $hairColorObj = ValidValueTranslation::select('slug')
				              	->where('valid_value_id', $hair_color_id)
				              	->where('locale', 'en')
				             	->first();

				    if(!empty($hairColorObj) && isset($hairColorObj->slug)){
	             		$hairColor = $hairColorObj->slug;
	             	}
				}

				// $dress_size_unit_alias = config('app.units_alias');
				// $dress_size_unit_cat_alias = "";

				$shoe_size_unit_alias = config('app.units_alias');
				$shoe_size_unit_cat_alias = "";

				$modelCat = '';
				
				// get model category name by category id
				if(!empty($$userObj->profile->category_id) && $userObj->user_type_id == 3){
					
					$modelCat = ModelCategory::withoutGlobalScopes([ActiveScope::class])->select('name','is_baby_model')->where('id', $userObj->profile->category_id)->first();
				}

				$is_baby_model = 0;

			 	if(!empty($modelCat) && isset($modelCat->is_baby_model)){
			 		
			 		$is_baby_model = $modelCat->is_baby_model;
			 	}

				if($is_baby_model == 1){
					
					// $dress_size_unit_cat_alias = config('app.kid_alias');
					$shoe_size_unit_cat_alias = config('app.kid_alias');
		 		}

		 		if($is_baby_model != 1 && $userObj->gender_id == config('constant.gender_male')){
		 			
		 			// $dress_size_unit_cat_alias = config('app.women_alias');
		 			$shoe_size_unit_cat_alias = config('app.women_alias');
		 		}

		 		if($is_baby_model != 1 && $userObj->gender_id == config('constant.gender_female')){
		 			
		 			// $dress_size_unit_cat_alias = config('app.women_alias');
		 			$shoe_size_unit_cat_alias = config('app.women_alias');
		 		}

		 	// 	if(isset($userObj->country->dress_size_unit) && !empty($userObj->country->dress_size_unit) && $userObj->country->dress_size_unit != null ){

		 	// 		$dress_size_unit_code = $userObj->country->dress_size_unit;
				// }else{

				// 	$dress_size_unit_code = 'standard';
				// 	$dress_size_unit_cat_alias = "";
				// }

				// $dress_column = $dress_size_unit_code.$dress_size_unit_alias.$dress_size_unit_cat_alias;

				// if(!empty($userObj->profile->size_id)  && $userObj->profile->size_id != 0){

				// 	$dressSizeunits = UserDressSizeOptions::select($dress_column)->where('id' , $userObj->profile->size_id)->first();

				// 	if(isset($dressSizeunits->$dress_column)){
				// 		$dress_size_id = $dressSizeunits->$dress_column;
				// 	}
				// }

				if(isset($userObj->country->shoe_units) && !empty($userObj->country->shoe_units) && $userObj->country->shoe_units != null ){

		 			$shoe_size_unit_code = $userObj->country->shoe_units;
				}else{

					$shoe_size_unit_code = config('app.default_units_country');
					$shoe_size_unit_cat_alias = "";
				}

				$shoe_column = $shoe_size_unit_code.$shoe_size_unit_alias.$shoe_size_unit_cat_alias;

				//  model Shoes Size

				if(!empty($userObj->profile->shoes_size_id) && $userObj->profile->shoes_size_id != 0){

					$shoeSizeunits = UserShoesUnitsOptions::select($shoe_column)->where('id' , $userObj->profile->shoes_size_id)->first();

					if(isset($shoeSizeunits->$shoe_column)){
						$shoes_size_id = $shoeSizeunits->$shoe_column;
					}
				} 

				// default unit code
				$default_unit_code = config('app.default_units_country').config('app.units_alias');

				// get height unit code by user country
				$height_unit_code = !empty($userObj->country->height_units) ? $userObj->country->height_units.config('app.units_alias') : $default_unit_code ;

				// get weight unit code by user country
				$weight_unit_code = !empty($userObj->country->weight_units) ? $userObj->country->weight_units.config('app.units_alias') : $default_unit_code ;

				$height_id = 0;

				//  model Height
				if(isset($userObj->profile->getHeight) && $userObj->profile->getHeight->count() > 0){
					 	 
			 	 	$height_id = ($userObj->profile->getHeight->$height_unit_code) ? $userObj->profile->getHeight->$height_unit_code : 0;
				}

				$weight_id = 0;
				//  model Weight
				if(isset($userObj->profile->getWeight) && $userObj->profile->getWeight->count() > 0){
					 	 
			 	 	$weight_id = ($userObj->profile->getWeight->$weight_unit_code) ? $userObj->profile->getWeight->$weight_unit_code : 0;
				}

				//  model Eye color
	          	if(!empty($userObj->profile->eye_color_id) && $userObj->profile->eye_color_id != 0){
		            
		            $eye_color_id = $userObj->profile->eye_color_id;

					// get eyeColor by user eye_color_id
		            $eyeColorObj = ValidValueTranslation::select('slug')
				              	->where('valid_value_id', $eye_color_id)
				              	->where('locale', 'en')
				             	->first();

				    if(!empty($eyeColorObj) && isset($eyeColorObj->slug)){
	             		$eyeColor = $eyeColorObj->slug;
	             	}
				}
				//  model Chest
	          	if(!empty($userObj->profile->chest_id) && $userObj->profile->chest_id != 0){
		            
		            $chest_id = $userObj->profile->chest_id;
				}
				//  model Waist
	          	if(!empty($userObj->profile->waist_id) && $userObj->profile->waist_id != 0){
		            
		            $waist_id = $userObj->profile->waist_id;
				}
				//  model Hips
	          	if(!empty($userObj->profile->hips_id) && $userObj->profile->hips_id != 0){
		            
		            $hips_id = $userObj->profile->hips_id;
				}
				// //  model Shoes Size
	   //        	if(!empty($userObj->profile->shoes_size_id) && $userObj->profile->shoes_size_id != 0){
		            
		  //           $shoes_size_id = $userObj->profile->shoes_size_id;
				// }
				//  model Skin color
	          	if(!empty($userObj->profile->skin_color_id) && $userObj->profile->skin_color_id != 0){
		            
		            $skin_color_id = $userObj->profile->skin_color_id;

		            // get skinColor by user skin_color_id
		            $skinColorObj = ValidValueTranslation::select('slug')
				              	->where('valid_value_id', $skin_color_id)
				              	->where('locale', 'en')
				             	->first();

				    if(!empty($skinColorObj) && isset($skinColorObj->slug)){
	             		$skinColor = $skinColorObj->slug;
	             	}
				}
				//  model piercing
	          	if(!empty($userObj->profile->piercing) && $userObj->profile->piercing != 0){
		            
		            $piercing = 'yes';
				}
				//  model Tattoo
	          	if(!empty($userObj->profile->tattoo) && $userObj->profile->tattoo != 0){
		            
		            $tattoo = 'yes';
				}
				
				// model user_agent
				$dataArr = array(
					'status' => true,
					'haircolor' => $hairColor,
					'height' => $height_id,
					'weight' => $weight_id,
					'eyecolor' => $eyeColor,
					'size' => $chest_id.'-'.$waist_id.'-'.$hips_id,
					'shoes_size' => $shoes_size_id,
					'skincolor' => $skinColor,
					'piercing' => $piercing,
					'tattoo' => $tattoo,
					'user_agent' => $userObj->profile->user_agent,
				);


				echo json_encode($dataArr);
				// Log::info("Response for action mauticData : ".json_encode($dataArr));
				exit();
			}else{
				$json['message'] = 'invalid username!';
				$json['status'] = false;
				Log::error("Error found for action mauticData : ".json_encode($json));
				echo json_encode($json); exit();
			}
		}
	}

	public function getModelBook(Request $request){
		// Log::info("Request data : ".json_encode($request->all()));
		$modelBookArr = array();

		if(!isset($request->username) || empty($request->username)){
			
			$json['message'] = 'username is missing';
			$json['modelBook'] = $modelBookArr;
			$json['status'] = false;
			// Log::info("Error found for action getModelBook : ".json_encode($json));
			echo json_encode($json); exit();
		}else{

			$wpusername = $request->username;
			if(isset($request->username) && is_string($request->username)){
				$wpusername = array($wpusername);
			}


			$users = User::withoutGlobalScopes()->whereIn('username', $wpusername)->with('modelbook')->get();
			// $user = User::withoutGlobalScopes()->whereIn('username', $wpusername)->first();

			
			$userModelbooks = array();
			if( isset($users) && !empty($users) && $users->count() > 0){
				
				foreach ($users as $key => $user) {
					
					if(isset($user->modelbook) && $user->modelbook->count() > 0){
						$modelBookArr = array();
						foreach ($user->modelbook as $value) {
							if(!empty($value->filename) && $value->filename != ''){
								$modelBookArr[] = $this->app_url.'/uploads/'.$value->filename;
							}
						} 


						$userModelbooks[$user->username] = $modelBookArr;

						$pos = array_search($user->username, $wpusername);

						// Remove from array
						unset($wpusername[$pos]);

					}else{
						$userModelbooks[$user->username] = [];
					}
				}
				
				if(isset($wpusername) && !empty($wpusername)){
					foreach ($wpusername as $name) {
					    $userModelbooks[$name] = [];
					}
				}

				if(isset($userModelbooks) && count($userModelbooks) > 0){
					echo json_encode(array(
						'status' => true,
						'message' => 'success',
						'modelBook' => $userModelbooks
					)); exit();
				}else{
					echo json_encode(array(
						'status' => false,
						'message' => 'record does not exist!',
						'modelBook' => []
					)); exit();
				}

			}else{

				echo json_encode(array(
					'status' => false,
					'message' => 'record does not exist!',
					'modelBook' => []
				)); exit();
			}





			/*if(empty($users)){
				$json['message'] = 'invalid username!';
				$json['modelBook'] = $modelBookArr;
				$json['status'] = false;
				// Log::info("Error found for action getModelBook : ".json_encode($json));
				echo json_encode($json); exit();
			}else{

				if(isset($user->modelbook) && $user->modelbook->count() > 0){

					$i = 0;

					foreach ($user->modelbook as $value) {

						if(!empty($value->filename) && $value->filename != ''){
							$modelBookArr[$i]['filename'] = $this->app_url.'/uploads/'.$value->filename;
							$i++;
						}
					} 
					
					$json['message'] = 'success';
					$json['modelBook'] = $modelBookArr;
					$json['status'] = true;
					// Log::info("Response for action getModelBook : ".json_encode($json));
					echo json_encode($json); exit();
 				}else{
					
					$json['message'] = 'record does not exist!';
					$json['modelBook'] = $modelBookArr;
					$json['status'] = false;
					// Log::info("Error found for action getModelBook : ".json_encode($json));
					echo json_encode($json); exit();
				}
			}*/
		}
	}

	/*
	url:http://go-models.com/handler/
	Parameters:
	action:get_user_profile_images
	from:0
	to:100 // number of records in the 
	go_code: GO-22953-FR // option param to get particular user detail
	status: 0/1/2 ( Pending, Approved, Rejected ) if go_code is set then do not check status
	stage: 'lead', 'paid', 'contract', 'active' (optional)
	timestamp:1574211600 (optional)
	user_type: 1/4 (1=> Model, 4 => Partner)
	Descriptions: return all user profile picture url whoes profile images are not approved
	 */

	public function getProfileImages(Request $request) {
		
		// Log::info("Request data getProfileImages : ".json_encode($request->all()));

		$req = $request->all();

		$offset = 0;
		$limit = 10;
		$go_code = "";
		//for particullar date
		$timestamp = "";
		$status = isset($req['status'])? $req['status'] : '';
		$user_type = isset($req['user_type'])? $req['user_type'] : '';
		$stage = isset($req['stage'])? strtolower($req['stage']) : '';
		$categories = (isset($req['platform']) && !empty($req['platform']))? explode(',', str_replace("'", "", $req['platform'])) : '';
		$regions = (isset($req['regions']) && !empty($req['regions']))? explode(',', str_replace("'", "", $req['regions'])) : array();
		// echo "<pre>"; print_r ($regions); echo "</pre>"; exit();

		if( isset($req) && !empty($req) ){

			/*if(isset($req['from']) && isset($req['to'])){
				if( ( $req['from'] > $req['to'] ) || ($req['from'] == $req['to']) ){
			// if(isset($req['from']) && isset($req['to'])){
			// 	if( ( $req['from'] > $req['to'] ) || ($req['from'] == $req['to']) ){
			// 		echo json_encode(array(
			// 			'status' => false,
			// 			'message' => 'To range should be grater than From range',
			// 			'data' => []
			// 		));

					Log::error("Error in action getProfileImages : To range should be grater than From range"); exit();
				}
			}*/

			if(isset($stage) && !empty($stage) ){
				if(!in_array(strtolower($stage), $this->stages)){

					echo json_encode(array(
						'status' => false,
						'message' => 'Invalid stage value',
						'data' => []
					));

					Log::error("Error in action getProfileImages : Invalid stage value"); exit();
				}
			}



			if (isset($req['from']) && !empty($req['from'])) {
				$offset = $req['from'];
			}

			if (isset($req['to']) && !empty($req['to'])) {
				$limit = $req['to'];
			}

			if ( isset($req['go_code']) && !empty($req['go_code']) ) {
				$go_code = explode(",", $req['go_code']);
			}
			//for particullar date
			if ( isset($req['timestamp']) && !empty($req['timestamp']) ) {
				$timestamp = $req['timestamp'];
			}

			
			if( isset($user_type) && !empty($user_type) ){
				
				if($user_type == config('constant.crm_model')){
					$user_type = config('constant.model_type_id');
				}

				if($user_type == config('constant.crm_partner')){
					$user_type = config('constant.partner_type_id');
				}
			}
			

			// if(isset($go_code) && empty($go_code)){

			// 	if(!isset($req['status'])){
			// 		echo json_encode(array(
			// 			'status' => false,
			// 			'message' => 'status is required',
			// 			'data' => []
			// 		));
			// 		Log::error("Error in action getProfileImages : status is required"); exit();
			// 	}
			// }
			
			$data = User::getPendingProfileImages($offset, $limit, $go_code, $status, $timestamp, $user_type, $stage, $categories, $regions);

			if ($data['status']) {
				echo json_encode($data);
			} else {

				echo json_encode(array(
					'status' => false,
					'message' => 'User data not found',
					'data' => []
				));

				Log::error("Error in action getProfileImages : Invalid request");
				exit();
			}
		}else{

			echo json_encode(array(
				'status' => false,
				'message' => 'Invalid request',
				'data' => []
			));

			Log::error("Error in action getProfileImages : Invalid request");
			exit();
		}
	}

	/*
	url:http://go-models.com/handler/
	Parameters:
	action:set_profile_image_status
	status: 1/0
	go_code: go-1234-fr
	Descriptions: Update particular user profile image status approval
	 */
	
	public function changeProfileStatus(Request $request) {

		// Log::info("Request data : ".json_encode($request->all()));
		$req = $request->all();

		if (isset($req) && isset($req['go_code']) ){

			
			$go_code = ($req['go_code']) ? $req['go_code'] : '';
			$status = ($req['status']) ? $req['status'] : 0;

			if (empty($go_code)) {
				echo json_encode(array(
					'status' => false,
					'message' => 'go_code is required',
					'data' => []
				));
				Log::error("Error in action changeProfileStatus : go_code is required");
				exit();
			}

			$userObject = User::withoutGlobalScopes()->select('users.id')->join('user_profile', 'users.id', '=', 'user_profile.user_id')->where('user_profile.go_code','=', $go_code)->first();

			if (!empty($userObject) && isset($userObject->id) && !empty($userObject->id)) {

				User::withoutGlobalScopes()->where('id', $userObject->id)->update(['is_profile_pic_approve'=> (int)$status]);

				echo json_encode(array('status' => true, 'message' => 'Status changed successfully','data' => []));
				Log::info("Success in action changeProfileStatus : User status updated successfully");
				exit(); 
			} else {

				echo json_encode(array('status' => false,'message' => 'records not found','data' => []));
				Log::error("Error in action changeProfileStatus : records not found");
				exit();
			}

		} else {
			echo json_encode(array(
				'status' => false,
				'message' => 'Invalid request param',
				'data' => []
			));
			Log::error("Error in action changeProfileStatus : Invalid request param");
			exit();
		}

	}


	/*
	url:http://go-models.com/handler/
	Parameters:
	action:get_all_pages
	translation_lang: en/de/uk
	Descriptions: get all pages from database.
	 */

	public function getAllPages(Request $request)
	{
		/**
		 * Check required parameters.
		 */
		if(!isset($request['translation_lang']) || empty($request['translation_lang'])){
			$json['message'] = "Translation Language is required";
			$json['status'] = false;
			$json['data'] = [];
			Log::error("Error found for action : ".json_encode($json));
			echo json_encode($json); exit();
		}

		/**
		 * Check active language.
		 */
		$languages = DB::table('languages')->where('abbr', strtolower($request['translation_lang']))->where('active', 1)->whereNull('deleted_at')->first();

		/**
		 * Invalid language.
		 */
		if(!isset($languages) && empty($languages)){
			$json['message'] = "Invalid language";
			$json['status'] = false;
			$json['data'] = [];
			Log::error("Error found for action not match language : ".json_encode($json));
			echo json_encode($json); exit();
		}

		/**
		 * Set valid language for pages.
		 */
		App::setLocale(strtolower($request['translation_lang']));

		/**
		 * Get all pages according to locale.
		 */
		$allPages = Page::withoutGlobalScopes()->select('id','title','created_at')->where('active', 1)->orderBy('translation_lang')->trans()->get();
		
		/**
		 * Get all pages.
		 */
		echo json_encode(array('status' => true, 'message' => 'pages fetch successfully','data' => $allPages));
		// Log::info("Successfully get pages according to language");
		exit();
	}


	/*
	url:http://go-models.com/handler/
	Parameters:
	action:get_all_blogs
	translation_lang: en/de/uk
	Descriptions: get all blogs from database.
	 */
	public function getAllBlogs(Request $request)
	{
		/**
		 * Check required parameters.
		 */
		if(!isset($request['translation_lang']) || empty($request['translation_lang'])){
			$json['message'] = "Translation Language is required";
			$json['status'] = false;
			$json['data'] = [];
			Log::error("Error found for action : ".json_encode($json));
			echo json_encode($json); exit();
		}

		/**
		 * Check active language.
		 */
		$languages = DB::table('languages')->where('abbr', strtolower($request['translation_lang']))->where('active', 1)->whereNull('deleted_at')->first();
	
		/**
		 * Invalid language.
		 */
		if(!isset($languages) && empty($languages)){
			$json['message'] = "Invalid language";
			$json['status'] = false;
			$json['data'] = [];
			Log::error("Error found for action not match language : ".json_encode($json));
			echo json_encode($json); exit();
		}

		/**
		 * Set valid language for pages.
		 */
		App::setLocale(strtolower($request['translation_lang']));

		/**
		 * Get all blogs according to locale.
		 */
		$allblogs = BlogEntry::withoutGlobalScopes()->select('id','name',DB::raw('IFNULL(created_at,"") as created'))->where('active', 1)->whereNull('deleted_at')->orderBy('translation_lang')->trans()->get();

		$blogArr = array();
		if(isset($allblogs) && $allblogs->count() > 0 ){
			foreach ($allblogs as $key => $blog) {
				$blogArr[$key]['id'] = $blog->id;
				$blogArr[$key]['title'] = ($blog->name != "")? $blog->name : '';
				$blogArr[$key]['created_at'] = ($blog->created != "")? $blog->created : '';
			}
		}

		/**
		 * Get all Blogs.
		 */
		echo json_encode(array('status' => true, 'message' => 'blogs fetch successfully','data' => $blogArr));
		// Log::info("Successfully get blogs according to language");
		exit();
	}

	/*
	url:http://go-models.com/handler/
	Parameters:
	action:get_sedcard_go_code
	from: 0 , to: 100, status: true/false
	Descriptions: get the gocode of a model which has status ative or inactive.
	 */
	public function getSedcardGocode(Request $request) {

		// Log::info("Request data : ".json_encode($request->all()));

		$req = $request->all();

		$offset = 0;
		$limit = 10;


		$sedcardType = [1, 2, 3, 4, 5];

		if ( isset($req['status']) ) {
			
			$status = $req['status'];

			if (isset($req['from']) && !empty($req['from'])) {
				$offset = $req['from'];
			}

			if (isset($req['to']) && !empty($req['to'])) {
				$limit = $req['to'];
			}

			if (isset($req['to']) && !empty($req['to'])) {
				$limit = $req['to'];
			}

			if(!isset($req['status'])){
				echo json_encode(array(
					'status' => false,
					'message' => 'status is required',
					'data' => []
				));
				Log::error("Error in action getSedcardGocode : status is required"); exit();
			}

			// return models go_code whoes sedcard images status 1/0
			$data = Sedcard::getSedcardGoCode($status, $offset, $limit);

			if ($data['status']) {
				echo json_encode($data);
			} else {

				echo json_encode(array(
					'status' => false,
					'message' => 'Invalid request found',
					'data' => []
				));
				Log::error("Error in action getSedcard : Invalid request found");
			}

		} else {

			echo json_encode(array(
				'status' => false,
				'message' => 'status is required',
				'data' => []
			));
			Log::error("Error in action getSedcardGocode : status is required");
		}
	}
	
	//get job details
	public function getJobDetails(Request $request) {
		
		// Log::info("Request data getJobDetails : ".json_encode($request->all()));

		$req = $request->all();

		$offset = 0;

		$limit = 10;
		
		//for particullar date
		$timeStamp = "";

		//Job type partner or model
		$jobType="";
		if( isset($req) && !empty($req) ){

			if (isset($req['from']) && !empty($req['from'])) {
				$offset = $req['from'];
			}

			if (isset($req['to']) && !empty($req['to'])) {
				$limit = $req['to'];
			}

			//for particullar date
			if ( isset($req['timeStamp']) && !empty($req['timeStamp']) ) {
				$timeStamp = $req['timeStamp'];
			}
			//job type 
			if ( isset($req['job_type']) && $req['job_type']!='') {
				$jobType=$req['job_type'];
			}
			//job details fetch

			$data = Post::getJobDetails($jobType , $timeStamp, $offset, $limit);

			if ($data['status']) {
				echo json_encode($data);
			} else {

				echo json_encode(array(
					'status' => false,
					'message' => 'Job data not found',
					'data' => []
				));

				Log::error("Error in action getJobDetails : Invalid request");
				exit();
			}
		}else{

			echo json_encode(array(
				'status' => false,
				'message' => 'Invalid request',
				'data' => []
			));

			Log::error("Error in action getJobDetails : Invalid request");
			exit();
		}
	}

	/*
	url:http://go-models.com/handler/
	Parameters:
	action:update_feature_models
	users: models list array
	Descriptions: truncate current feature models and update new feature models.
	 */
	public function updateFeatureModels(Request $request){
		
		//get all the request param
		$req = $request->all();

		// echo "<pre>"; print_r ($req['users']); echo "</pre>"; exit();

		// set flag for truncate operation is success or not
		$is_truncate_table = false;
		
		// check feature model data is set and is not empty 
		if( isset($req['users']) && !empty($req['users']) ){
		
			//if feature mode data is set then first truncate the model
			try{
				FeatureModels::truncate();
				
				// set is_truncate_table is true
				$is_truncate_table = true;
			}catch(\Exception $e){
				Log::error("Error while truncate table FeatureModels: ".$e->getMessage()); exit();
			}

			// if is_truncate_table is true then store request data into feature models table
			if($is_truncate_table){
				try{
					FeatureModels::insert($req['users']);
					
					// purge cache for the category and home page
					ResponseCache::forget(['/', '/de', '/uk', '/baby-modeling','/child-modeling','/become-a-model','/50-plus-model','/plus-size-model','/fitness-model','/de/baby-model-werden','/de/kindermodel-werden','/de/model-werden','/de/50-plus-model-werden','/de/curvy-model-werden','/de/fitness-model-werden','/uk/baby-modelling','/uk/child-modelling','/uk/become-a-model','/uk/50-plus-model','/uk/plus-size-model','/uk/fitness-model']);

				}catch(\Exception $e){
					// return error message
					echo json_encode(array(
						'status' => false,
						'message' => $e->getMessage()
					)); exit();
				}
			}

			// return success message
			echo json_encode(array(
				'status' => true,
				'message' => 'feature model data store successfully'
			));
			exit();

		}else{

			// return error message while not found request data
			echo json_encode(array(
				'status' => false,
				'message' => 'users is required',
				'data' => []
			));

			Log::error("Error in action updateFeatureModels : Invalid request");
			exit();
		}
	}

	public function createUserLead(Request $request){

		$data = $request->all();

		$req_arr = array(
          'action' => 'lead_create',
          'wpusername' => $data['wpusername'],
          'locale' => $data['locale'],
          'country' => $data['country'],
          'verification_link' => $data['verification_link'],
          'type' => $data['type'],
          'firstname' => $data['firstname'],
          'lastname' => $data['lastname'],
          'newsletter' => $data['newsletter'],
          'utm_source' => $data['utm_source'],
          'utm_medium' => $data['utm_medium'],
          'utm_campaign' => $data['utm_campaign'],
          'utm_content' =>  $data['utm_content'],
          'url' => $data['url'],
          'referer' => $data['referer'],
          'useragent' => $data['useragent'],
          'google_gclid' => $data['google_gclid'],
          'google_clientId' => $data['google_clientId'],
          'utm_term' => $data['utm_term'],
          'tel' => "",
          'tel_prefix' => ""
        );
        
        $response = CommonHelper::go_call_request($req_arr);
        $json = json_decode($response->getBody());
	}
	/*
		url:http://go-models.com/handler/
		Parameters: wpusername, transactionid
		action:mark_user_as_unpaid
		Descriptions: user transaction failed, update user details and payment details
 	*/
	public function markUserAsUnpaid(Request $request){
		$wpusername = ($request->wpusername) ? $request->wpusername : '';
		$post_id = ($request->transactionid) ? $request->transactionid : '';
		$requestData =  $request->all();
		if(empty($wpusername)) {
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'Username is required!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();	
		}

		if(empty($post_id)){
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'Transaction id is required!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();	
		}
		// get user by username
		$user = User::withoutGlobalScopes()->where('username', $wpusername)->first();

		$post = '';
		if(!empty($user) && isset($user->id)){
			$post = Post::withoutGlobalScopes()->where('id', $post_id)->where('user_id', $user->id)->first();
		}

		if(!empty($user) && !empty($post)){
			
			$user->subscribed_payment = 'pending';
			$user->subscription_type = 'free'; 
			$user->save();
			
			//fetch post_id using payment
			$currentPayment = Payment::withoutGlobalScope(StrictActiveScope::class)->where('post_id', $post_id)->orderBy('id', 'DESC')->first();

			if(!empty($currentPayment)){
				$currentPayment->transaction_status = 'cancelled';
				$currentPayment->save();
			}else{
				// return error message
				echo $responseData = json_encode(array(
					'status' => false,
					'message' => 'Payment does not exist!',
				));
				// save api log
				$this->apiLog($requestData, $responseData);
				exit();	
			}
		}else{
			// return success message
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'User does not exist!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();
		}
		
		// return success message
		echo $responseData = json_encode(array(
			'status' => true,
			'message' => 'Marked user as unpaid successfully',
		));
		// save api log
		$this->apiLog($requestData, $responseData);
		exit();	
	}

	/*
		url:http://go-models.com/handler/
		Parameters: wpusername
		action:un_delete_user
		Descriptions: We have to undelete user from laravel. make deleted_at flag null
 	*/
	public function unDeleteUser(Request $request){
		$requestData =  $request->all();
		$wpusername = ($request->wpusername) ? $request->wpusername : '';
		if(empty($wpusername)) {
			echo $responseData = json_encode(array(
								'status' => false,
								'message' => 'Username is required!',
							));
				// save api log
				$this->apiLog($requestData, $responseData);
			exit();	
		}
		// get user by username
		$user = User::withoutGlobalScopes()->where('username', $wpusername)->first();
		if(!empty($user)){
			$user->deleted_at = NULL;
			$user->save();
		}else{
			// return success message
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'User does not exist!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();
		}
		// return success message
		echo $responseData = json_encode(array(
			'status' => true,
			'message' => 'deleted user successfully.',
		));
		// save api log
		$this->apiLog($requestData, $responseData);
		exit();	
	}

	/*
		url:http://go-models.com/handler/
		Parameters: wpusername
		action:hard_delete_user
		Descriptions: We have to hard delete user and all his entries from all related tables from database.
 	*/
	public function hardDeleteUser(Request $request){
		$requestData =  $request->all();
	 	$wpusername = ($request->wpusername) ? $request->wpusername : '';
		if(empty($wpusername)) {
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'Username is required!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();	
		}
		
		// get user by username
		$user = User::withoutGlobalScopes()->where('username', $wpusername)->first(); 

		if(!empty($user)){
		 	// user type id: partner-2 and model-3 
		 	$user_type_id = $user->user_type_id;
		 	
			// Delete all favorite User
			$favoriteUser = \App\Models\Favorite::where('user_id', $user->id)->orWhere('fav_user_id', $user->id)->delete();

			// get user jobApplication
			if(isset($user->jobApplication) && !empty($user->jobApplication) && $user->jobApplication->count() > 0){
				$user->jobApplication()->delete();
			}

			// Delete all saved Posts
			$savedPosts = \App\Models\SavedPost::where('user_id', $user->id)->delete();

			// Delete all User view details
			$userView = \App\Models\UserView::where('user_id', $user->id)->delete();

			// Delete all messages
			$messages = \App\Models\Message::where('from_user_id', $user->id)->orWhere('to_user_id', $user->id)->delete();
			
			// get all post Id
			$post = Post::select('id')->withoutGlobalScopes()->where('user_id', $user->id)->get();
			$post_ids_arr = array();
			$payment_ids_arr = array();
			if($post->count() > 0){
				$ids = '';
				foreach ($post as $key => $val) {
				 	$ids.=$val->id.',';
				}
				$post_ids = rtrim($ids, ",");
				
				if(!empty($post_ids)){
					$post_ids_arr = explode(',', $post_ids);
				}
			}

			// ONLY MODEL RECORD DELETE
			if($user_type_id == 3){

				// get user Educations
			 	if(isset($user->userEducations) && !empty($user->userEducations) && $user->userEducations->count() > 0){
			 		$user->userEducations()->delete();
			 	}
			 	// get user Experiences
			 	if(isset($user->userExperiences) && !empty($user->userExperiences) && $user->userExperiences->count() > 0){
			 		$user->userExperiences()->delete();
			 	}
			 	// get user References
				if(isset($user->userReferences) && !empty($user->userReferences) && $user->userReferences->count() > 0){
					$user->userReferences()->delete();
				}
				// get user Talentes
				if(isset($user->userTalentes) && !empty($user->userTalentes) && $user->userTalentes->count() > 0){
					$user->userTalentes()->delete();
				}
				// get user Languages
				if(isset($user->userLanguages) && !empty($user->userLanguages) && $user->userLanguages->count() > 0){
					$user->userLanguages()->delete();
				}
				// get user Resume
				if(isset($user->resume) && !empty($user->resume) && $user->resume->count() > 0){
					
					if (file_exists(public_path('uploads/resumes/'.$user->id))) {
						File::deleteDirectory('uploads/resumes/'.$user->id);
					}
					// wp user delete resume
					if($user->wp_user_id > 0){
					 	// wp user delete resume
						if($user->wp_user_id > 0){
							if (isset($user->resume->filename) && $user->resume->filename != "" && Storage::exists($user->resume->filename)) 
							{ 
								unlink(public_path('uploads/'.$user->resume->filename));
							}
						}
					}
					$user->resume()->delete();
				}
				// get user user work settings
			 	if(isset($user->userWorkSettings) && !empty($user->userWorkSettings) && $user->userWorkSettings->count() > 0){
			 		$user->userWorkSettings()->delete();
			 	}
				// get user modelBook images
				if(isset($user->modelbook) && !empty($user->modelbook) && $user->modelbook->count() > 0){

					if (file_exists(public_path('uploads/modelbook/'.$user->id))) {
						File::deleteDirectory('uploads/modelbook/'.$user->id);
					} 

					// wp user delete modelbook
					if($user->wp_user_id > 0){
					 	foreach ($user->modelbook as $key => $value) {
						 	 
					 	 	if(!empty($value->filename)  && Storage::exists($value->filename)){
					 	 		unlink(public_path('uploads/'.$value->filename));
					 	 	}
						}
					}
					$user->modelbook()->delete();
				}
				// get user Sedcard
				if(isset($user->userSedcard) && !empty($user->userSedcard) && $user->userSedcard->count() > 0){
					
					if (file_exists(public_path('uploads/sedcard/'.$user->id))) {
						File::deleteDirectory('uploads/sedcard/'.$user->id);
					}

					// wp user delete sedCard
					if($user->wp_user_id > 0){

					 	foreach ($user->userSedcard as $key => $value) {
					 	 	if(!empty($value->filename) && Storage::exists($value->filename)){
					 	 		unlink(public_path('uploads/'.$value->filename));
					 	 	}
						}
					}
					$user->userSedcard()->delete();
				}
				
				/*
					delete all post, payment, payment coupon
				*/
				if(count($post_ids_arr) > 0){
					
					// get all payments Id
					$payment = Payment::select('id')->withoutGlobalScopes()->whereIn('post_id', $post_ids_arr)->get();
					if($payment->count() > 0){
					 	$pids = '';
					 	foreach ($payment as $key => $val) {
						 	$pids.=$val->id.',';
						}
						$payment_ids = rtrim($pids, ",");

						if(!empty($payment_ids)){
							$payment_ids_arr = explode(',', $payment_ids);
						}

						if(count($payment_ids_arr) > 0){
							// delete all payments coupon
							$paymentCoupon = \App\Models\PaymentCoupon::whereIn('payment_id', $payment_ids_arr)->delete();
						}
						
						// delete all payments coupon
						$paymentLog = \App\Models\paymentLog::whereIn('post_id', $post_ids_arr)->delete();
						// delete all payment
						$payment = Payment::withoutGlobalScopes()->whereIn('post_id', $post_ids_arr)->delete();
					}
				}
			}

			if($user_type_id == 2){
				
				// delete all albem
				if (file_exists(public_path('uploads/album/'.$user->id))) {
					File::deleteDirectory('uploads/album/'.$user->id);
				}

				// wp user delete album
				if($user->wp_user_id > 0){
					$album = \App\Models\Albem::where('user_id', $user->id)->get();
					if(!empty($album) && $album->count() > 0){

						foreach ($album as $key => $value) {
					 	 	if(!empty($value->filename) && Storage::exists($value->filename)){
					 	 		unlink(public_path('uploads/'.$value->filename));
					 	 	}
						}
					} 
				}
				$albem = \App\Models\Albem::where('user_id', $user->id)->delete();
				
				// company images path
				$destination_path = 'uploads/files/' . strtolower($user->country_code) . '/' . $user->id;
				 
				if (file_exists(public_path($destination_path))) {
					File::deleteDirectory($destination_path);
				}
				// delete all company
				$company = \App\Models\Company::where('user_id', $user->id)->delete();
				
				if(count($post_ids_arr) > 0){
					// delete all Jobs Translation
					$jobsTranslation = \App\Models\JobsTranslation::whereIn('job_id', $post_ids_arr)->delete();
					// delete all payments Job View
					$jobView = \App\Models\JobView::whereIn('job_id', $post_ids_arr)->delete();
				}
			}

			// delete all posts
			$post = Post::withoutGlobalScopes()->where('user_id', $user->id)->forceDelete();
			// get user Profile
		 	if(isset($user->profile) && !empty($user->profile) && $user->profile->count() > 0){
		 		if (file_exists(public_path('uploads/profile/cover/'.$user->id))) {
					File::deleteDirectory('uploads/profile/cover/'.$user->id);
				}
				if (file_exists(public_path('uploads/profile/logo/'.$user->id))) {
					File::deleteDirectory('uploads/profile/logo/'.$user->id);
				}
		 		$user->profile()->delete();
		 	}
		 	$user->forceDelete();
		}else{
			// return success message
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'User does not exist!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();
		}
		// return success message
		echo $responseData = json_encode(array(
			'status' => true,
			'message' => 'Deleted user successfully.',
		));
		// save api log
		$this->apiLog($requestData, $responseData);
		exit();
	}

	
	/*
		url:http://go-models.com/handler
		action: suspend_user
		Parameters: wpusername string/array
		Descriptions: suspend user to access the go-models
 	*/
	public function suspendUser(Request $request){
		$wpusername = ($request->wpusername) ? $request->wpusername : '';
		$requestData =  $request->all();
		if(empty($wpusername)) {
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'wpusername is required!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();	
		}

		$this->changeUserSuspension($requestData, 'suspend');
	}

	/*
		url:http://go-models.com/handler
		Parameters: wpusername string/array
		action: un_suspend_user
		Descriptions: suspend user status change to unsuspend
 	*/

	public function unsuspendUser(Request $request){
		$wpusername = ($request->wpusername) ? $request->wpusername : '';
		$requestData =  $request->all();

		if(empty($wpusername)) {
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'wpusername is required!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();	
		}

		$this->changeUserSuspension($requestData, 'unsuspend');
	}

	// common function to change the given username and status and update suspended status
	public function changeUserSuspension($requestData, $suspend_type='unsuspend'){

		$wpusername = $requestData['wpusername'];

		$suspension_status = ($suspend_type == 'suspend')? 1 : 0;
		$suspension_text = ($suspend_type == 'suspend')? 'suspended' : 'unsuspend';

		$user = User::withoutGlobalScopes()->where('username', $wpusername)->withTrashed()->first();

		if( isset($wpusername) && !empty($wpusername) && !empty($user)){
				try{
					$user->blocked = $suspension_status;
					$user->save();
			}catch(\Exception $e){
				echo $responseData = json_encode(array(
					'status' => false,
					'message' => $e->getMessage(),
				));
				// save api log
				$this->apiLog($requestData, $responseData);
				exit();
				}
			echo $responseData = json_encode(array(
				'status' => true,
				'message' => 'user ' . $suspension_text . ' successfully!',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();
		}else{
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'Invalid wpusername or user not found',
			));
			// save api log
			$this->apiLog($requestData, $responseData);
			exit();	
		}
	}
	// Save api log
	public function apiLog($request, $response){
		$action = isset($request['action']) ? $request['action'] : '';
		$wp_username = isset($request['wpusername']) ? $request['wpusername'] : '';
		$request = json_encode($request);

		// Api log Aarray
		$apiLogInfo = [
			'time' => time(),
			'wpusername' => $wp_username,
			'action' => $action,
			'request' => $request,
			'reaponse' => $response,
		];
		try{
			$apiLogInfo = new \App\Models\ApiLog($apiLogInfo);
			$apiLogInfo->save();
		}catch(\Exception $e){
			Log::error("====== Some error while saving API log ======");
			Log::error("API log request: ".$request);
			Log::error("API log response: ".$response);
			Log::error("API log error: ".$e->getMessage());
		}
	}


	public function completePayment($request){
		$param = $request->get('data');
		$post = "";

		$param['additional_charges'] = (empty($param['additional_charges']))? json_encode([]) : $param['additional_charges'];
		$param['coupon_data'] = (empty($param['coupon_data']))? [] : $param['coupon_data'];

		if( isset($param) && !empty($param) ){

			$post_id = (isset($param['post_id']) && !empty($param['post_id']))? $param['post_id'] : "";


			if(empty($post_id)){
				echo json_encode(array( 'status' => false, 'message' => 'post id is required')); exit();	
			}


			$post = Post::withoutGlobalScopes()->where('id', $post_id)->first();

			if(isset($post) &&  !empty($post)){

				try{
					PaymentHelper::paymentConfirmationActions($param, $post);
					echo json_encode(array( 'status' => true, 'message' => 'payment updated successfully')); exit();	
				}catch(\Exception $e){
					Log::error("completePayment log error: ".$e->getMessage());
					echo json_encode(array( 'status' => false, 'message' => $e->getMessage())); exit();	
				}

			}else{
				echo json_encode(array( 'status' => false, 'message' => 'post not found')); exit();	
			}
		}else{
			echo json_encode(array( 'status' => false, 'message' => 'Invalid request or data' )); exit();	
		}
	}
	
	public function setEditorPickStatus($request){
	 	
	 	$req = $request->all();
		$usersArr = isset($request->usernames) ? $request->usernames : array();
		
		$is_true_arr = array();
		$is_false_arr = array();
		
		if(count($usersArr) > 0){
			foreach ($usersArr as $key => $val) {
				
				if($val['status'] == 'true'){
					$is_true_arr[] = $val['wpusername'];
				}else{
					$is_false_arr[] = $val['wpusername'];
				}
			}
		}
		
		if(count($is_true_arr) > 0){
			User::withoutGlobalScopes()->whereIn('username', $is_true_arr)->update(['is_editor_pic'=> 1]);
		}
		
		if(count($is_false_arr) > 0){
			User::withoutGlobalScopes()->whereIn('username', $is_false_arr)->update(['is_editor_pic'=> 0]);
		}
		echo json_encode(array( 'status' => true, 'message' => 'updated successfully')); exit();
	}

	// update user ratings
	public function updateUserRatings($request){
		$req = $request->all();
		$usersArr = isset($request->usernames) ? $request->usernames : array();

		if(count($usersArr) > 0){
			foreach ($usersArr as $key => $val) {

				if(!empty($val['wpusername'])){
					$user = User::withoutGlobalScopes()->where('username', $val['wpusername'])->first();
					if(!empty($user)){
						
						if(isset($val['rating']) && isset($val['rating_count'])){
							
							$user->rating = (int)$val['rating'];
							$user->rating_count = (int)$val['rating_count'];
							$user->save();
						}
					}
				}
			}
		}
		echo json_encode(array( 'status' => true, 'message' => 'User rating updated successfully')); exit();
	}	

	public function clearCache(Request $request)
	{
		if(!isset($request->url) || empty($request->url)){
			echo json_encode(array("status"=>0, "message"=>"url not found"));
			exit;
		}
		try{
			ResponseCache::forget($request->url);
			echo json_encode(array("status"=>1, "message"=>"url cleared from cache"));
		}catch(Exception $e){
			echo json_encode(array("status"=>0, "message"=>$e->getMessage()));
		}

		//do not clear whole cache 
		
		/*try{
			ResponseCache::clear();
			echo json_encode(['success' => "true"]);
		}catch(Exception $e){
			echo json_encode(['error' => $e->getMessage()]);
		}*/
	}

	/*
		url:http://go-models.com/handler
		Parameters: image_id
		action: delete_sedcard_by_image_id
		Descriptions: delete sedcard by image id
 	*/
	public function delete_sedcard_by_image_id(Request $request) {
		$req = $request->all();
		$image_id = isset($request->image_id) ? $request->image_id : array();

		if(!is_array($image_id) && !empty($image_id)){
			
			$image_id = explode(",", $image_id);
		}

		if(count($image_id) == 0){
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'sedcard image id is required!',
				'data' => []
			));
			// save api log
			$this->apiLog($req, $responseData);
			exit();
		}

		if ( isset($image_id) && !empty($image_id) ) {

			$imageObject = Sedcard::whereIn('id', $image_id)->get();

			if(!empty($imageObject) && $imageObject->count() > 0 ){
				
				foreach ($imageObject as $key => $value) {

					if (isset($value->filename) && !empty($value->filename)) {
						if (file_exists(public_path('uploads/'.$value->filename))) {
							unlink(public_path('uploads/'.$value->filename));
						}
					}
				}
				
				$delete = Sedcard::whereIn('id', $image_id)->delete();

				echo $responseData = json_encode(array(
					'status' => true,
					'message' => 'Delete sedcard image successfully',
					'data' => []
				)); exit();
			}else{

				echo $responseData = json_encode(array(
					'status' => true,
					'message' => 'Record does not exist!',
					'data' => []
				)); exit();

				$this->apiLog($req, $responseData);
				Log::error("Error in action delete_sedcard_by_image_id : Record does not exist!");
				exit();
			}
		} else {
			echo $responseData = json_encode(array(
				'status' => false,
				'message' => 'Error in action delete_sedcard_by_image_id : Invalid request param',
				'data' => json_encode($req)
			));
			// save api log
			$this->apiLog($req, $responseData);
			Log::error("Error in action delete_sedcard_by_image_id : Invalid request param");
			exit();
		}
	}
}