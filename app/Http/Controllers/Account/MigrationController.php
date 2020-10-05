<?php


namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Models\BlogCategory;
use App\Models\BlogEntry;
use App\Models\CountryLanguage;
use App\Models\BlogTag;
use App\Models\ModelCategory;
use App\Models\Branch;
use App\Models\ValidValue;
use App\Models\ValidValueTranslation;
use DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Scopes\VerifiedScope;
use App\Models\Scopes\ActiveScope;
use App\Models\City;
use App\Models\Category;
use App\Models\Package;
use App\Models\Resume;
use App\Models\Albem;
use App\Models\ModelBook;
use App\Models\Post;
use App\Models\Sedcard;
use App\Models\Country;
use App\Models\SavedPost;
use App\Models\PaymentMethod;
use App\Models\Payment;
use App\Models\Favorite;
use File;
use App\Models\BlogTagsToEntry;
use App\Models\JobApplication;
use App\Models\Company;
use App\Models\UserEducations;
use App\Models\UserExperiences;
use App\Models\UserReferences;
use App\Models\UserTalents;
use Carbon\Carbon;
use Mail;
use App\Mail\SendGeneratedPassword;
use App\Models\PostType;
use App\Models\Message;
use App\Models\UserHeightUnitOptions;
use App\Models\UserWeightUnitsOptions;

use App\Models\UserDressSizeOptions;

use App\Models\UserShoesUnitsOptions;
use App\Models\UserWaistUnitOptions;
use App\Models\UserChestUnitOptions;
use App\Models\UserHipsUnitOptions;

use App\Models\TimeZone;
use App\Models\Language;
use Google\Cloud\Translate\TranslateClient;
use App\Models\JobsTranslation;

class MigrationController extends AccountBaseController
{
    // public $url = "https://go-models.com/migrationapi/"; //"https://go-models.com/migrationapi/"; 
    // public $url = "https://go-models.com/migrationapi/";
    public $url = "https://stage.go-models.com/migrationapi";
    public $language_array = array('en_us');
    private $country_language = array();
    public $language_country_array = array('en_us' => 'USA', 'de' => 'Deutschland', 'ch' => 'Schweiz', 'at' => 'Österreich', 'li' => 'Liechtenstein', 'en' => 'UK', 'gb' => 'Great Britain');
    private $user_type = array('model' => 3, 'partner' => 2);
    private $wp_upload_folder = 'uploads';
    private $wp_sedcard_type = [ 'portrait' => 1, 'full_body' =>  2, 'beauty_style' => 3, 'fashion_style' => 4, 'free_choice' => 5 ];
    private $wp_payment_status = array('pending','approved','cancelled','refunded');

    private $modelCatSlug = ['baby-model-de','kid-model-de','baby-model-at','kid-model-at','baby-model','kid-model','baby-model-en','kid-model-en','baby-model-ch','kid-model-ch','baby-model-li','kid-model-li' ];

    private $model_log;
    private $update_log;
    private $migrationLogFilePath;

    public $dateFormat = 'd-m-Y';

    public $modelEyeColor;
    public $modelSkinColor;
    public $modelHairColor;
    public $packageUserType;
    public $packageIds;

    private $cityList;
    private $countryList;
    private $branchList;
    private $modelcategoryList;
    private $existingJobs;
    private $heightListArr;
    private $weightListArr;
    private $chestListArr;
    private $waistListArr;
    private $hipsListArr;

    // private $dressSizeKidArr;
    // private $dressSizeMenArr;
    // private $dressSizeWomenArr;

    // private $shoeSizeKidArr;
    // private $shoeSizeMenArr;
    // private $shoeSizeWomenArr;
    private $dressSizeArr;
    private $shoeSizeArr;
    private $wpModelCategory;
    private $wpUserIds;

    private $dressSizeMenArr;
    private $dressSizeWomenArr;
    private $dressSizeKidsArr;



    public $userTypeId;
    public $userName;

    public function __construct() {
      $this->model_log = "model_list_log_".time();
      $this->update_log = "update_log_".time();

      $this->migrationLogFilePath = public_path().'/migrationlog';
      if (!File::exists($this->migrationLogFilePath)){
        File::makeDirectory($this->migrationLogFilePath, 0755, true, true);
      }
      // get country language data (languageCode,countryCode,wp_language)
      $this->country_language = CountryLanguage::pluck('country_code', 'wp_language')->toArray();

    }


    public function migrationApiRequest(Request $request) {

      $action = $request->input('action');

      if ($action == '' || empty($action)) {
        $json['error'] = 'Action is missing';
        $response = json_encode($json);
        return response()->json($response);
      }

      switch ($action) {

      case 'get_blog_category':
        $this->getBlogCategory($request);
      break;
      
      // not needed as callled this function from inside get_blog_category
      /*case 'set_blog_category_parent':
        $this->setCategoryParent($request);
        break;
      */
      case 'get_tags':
        $this->getBlogTags($request);
      break;

      case 'posts':
        $this->getBlogs($request);
      break;

      case 'update_blog_author':
        $this->updateBlogAuthor($request);
      break;
      

      case 'get_job_category':
        $this->getJobCatgeories($request);
      break;

      // not needed as callled this function from inside get_job_category
      /*case 'set_job_category':
        $this->setJobCategory();
        break;
      */

      case 'get_packages':
        $this->getPackages($request);
      break;

      case 'get_model_color_category':
        $this->getModelColorCategory($request);
      break;

      case 'model_category':
        $this->getModelCategories($request);
      break;

      case 'partner_category':
        $this->getPartnerCategories($request);
      break;

      case 'jobs':
        $this->getJobs($request);
      break; 

      case 'update_jobs_units':
        $this->updateJobsUnits();
      break;
      
      // case 'set_favourite_model':
      //   $this->updateFavouriteUsers();
      // break;
      // case 'set_favourite_jobs':
      //   $this->updateFavouriteJobs();
      // break;

      case 'migrate_models':
        $paged = $request->input('paged');
        if ($paged == '' || empty($paged)) {
          $json['error'] = 'paged is missing';
          $response = json_encode($json);
          return response()->json($response);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => config('app.url')."/api/migrationApiRequest",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => array("action" => "get_model_list", "paged" => $paged),
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTPHEADER => array(
            // "Authorization: Basic bGVva3VzaGFsOmRkX25iaGZnZ2RlZWVmZ0hIZHd3d3cxMQ==",
            "Cache-Control: no-cache",
            "content-type: multipart/form-data"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return array('status' => false, 'response' => $err);
        } else {
          return array('status' => true, 'response' => $response);
        }
      break;

      case 'get_model_list':
        $this->getModelsList($request);
      break;

      case 'migrate_partners':
        $paged = $request->input('paged');
        if ($paged == '' || empty($paged)) {
          $json['error'] = 'paged is missing';
          $response = json_encode($json);
          return response()->json($response);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => config('app.url')."/api/migrationApiRequest",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => array("action" => "get_partner_list", "paged" => $paged),
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTPHEADER => array(
            // "Authorization: Basic bGVva3VzaGFsOmRkX25iaGZnZ2RlZWVmZ0hIZHd3d3cxMQ==",
            "Cache-Control: no-cache",
            "content-type: multipart/form-data"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return array('status' => false, 'response' => $err);
        } else {
          return array('status' => true, 'response' => $response);
        }
      break;

      case 'get_partner_list':
        $this->getPartnersList($request);
      break;

      case 'migrate_transactions':
        $paged = $request->input('paged');
        if ($paged == '' || empty($paged)) {
          $json['error'] = 'paged is missing';
          $response = json_encode($json);
          return response()->json($response);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => config('app.url')."/api/migrationApiRequest",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => array("action" => "get_transaction", "paged" => $paged),
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTPHEADER => array(
            // "Authorization: Basic bGVva3VzaGFsOmRkX25iaGZnZ2RlZWVmZ0hIZHd3d3cxMQ==",
            "Cache-Control: no-cache",
            "content-type: multipart/form-data"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return array('status' => false, 'response' => $err);
        } else {
          return array('status' => true, 'response' => $response);
        }
      break;

      case 'get_transaction':
        $this->getTransaction($request);
      break;

      case 'update_partner_username':
          $paged = $request->input('paged');
          if ($paged == '' || empty($paged)) {
            $json['error'] = 'paged is missing';
            $response = json_encode($json);
            return response()->json($response);
          }

          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.url')."/api/migrationApiRequest",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array("action" => "set_PartnerUsername", "paged" => $paged),
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
              // "Authorization: Basic bGVva3VzaGFsOmRkX25iaGZnZ2RlZWVmZ0hIZHd3d3cxMQ==",
              "Cache-Control: no-cache",
              "content-type: multipart/form-data"
            ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

          if ($err) {
            return array('status' => false, 'response' => $err);
          } else {
            return array('status' => true, 'response' => $response);
          }
      break;

      case 'set_PartnerUsername':
        $this->setPartnerUsername($request);
      break;

      case 'update_model_experiance':
        $this->updateModelExperiance($request);
      break;

      case 'update_user_birthdate':
        $this->updateUserBirthdate($request);
      break;

      case 'update_user_email':
        $this->updateUserEmail($request);
      break;      

      case 'update_job_status':
        $this->updateJobStatus($request);
      break;

      case 'update_post_city':
        $this->updateJobCity($request);
      break;

      case 'update_conversation':
        $this->updateUserConversation();
      break;

      case 'update_user_contract_expire':
        $this->updateUserContractExpire();
      break;

      case 'copy_blog_category_to_locale':
        $this->copyCategoryToLocale($request);
      break;

      case 'copy_tag_to_locale':
        $this->copyTagToLocale($request);
      break;

      case 'copy_blog_to_locale':
        $this->copyBlogToLocale($request);
      break;

      case 'copy_blogs_de_to_en':
        $this->copyBlogDeToEn();
      break;

      case 'blog_slug_replace_space_to_dash':
        $this->blogSlugReplaceSpaceToDash();
      break;

      case 'blog_category_deleted_to_null':
        $this->blogCategoryDeletedToNull();
      break;

      case 'copy_pages_us_to_uk':
        $this->copyPagesUsToUK();
      break;

      case 'get_models_sedcardimages':
        $this->getModelsSedcardImages();
      break;

      case 'update_user_chest_waist_hips':
        $this->updateUserChestWaistHips($request);
      break; 

      case 'update_user_last_login_at':
        $this->updateLastLoginAt($request);
      break;

      case 'update_user_active_new':
        $this->updateActiveNew($request);
      break;

      case 'find_user_not_in_db':
        $this->findUserNotInDb($request);
      break;

      case 'update_wp_payment_model':
        $this->updateWpModelPayment($request);
      break;

      case 'update_blog_slug':
        $this->blogSlugReplaceCharacter($request);
      break;

      case 'jobs_translation':
        $this->jobsTranslation($request);
      break;

      case 'update_user_time_zone':
        $this->updateUsersTimeZone($request);
      break;

      // case 'newActiveLanguageJobs':
      //   $this->newActiveLanguageJobs($request);
      // break;
      
      default:
        # code...
        break;
      }
      
    }

    /**
     * Comman Curl Requester
     * @param $url, $request
     * @return Status with response
    */
    public static function getCurlRequest($url, $request){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $request,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0,
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic bGVva3VzaGFsOmRkX25iaGZnZ2RlZWVmZ0hIZHd3d3cxMQ==",
            "Cache-Control: no-cache",
            "content-type: multipart/form-data"
          ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
          return array('status' => false, 'response' => $err);
        } else {
          return array('status' => true, 'response' => $response);
        }
    }


    public static function getLanguageCode($wp_code){
        $langCode = CountryLanguage::where('wp_language', $wp_code)->first()->toArray();
        if( !empty($langCode) ){
          return $langCode;
        }
        return [];
    }
    
    public function getBlogCategory($request)
    { 

        $req = $request->all();

        if( isset($req['lang']) && !empty($req['lang']) ){

          $req = array('action' => 'posts_categories' , 'lang' => $req['lang']);

          $res = $this->getCurlRequest($this->url, $req);

          $codeObj = $this->getLanguageCode($req['lang']);

          $country_code = $lang = '';
          
          if(!empty( $codeObj) ){
            $country_code = $codeObj['country_code'];
            $lang = $codeObj['language_code'];
          }

          $data = array();

          if( $res['status'] == true ){
            $data = json_decode($res['response'], true);
          } else {
            echo json_encode([
                'status' => 'error',
                'message' => "SSL certificate problem: unable to get local issuer certificate"
              ]);
            exit();
          }

          if(count($data) > 0 ){
            $cat_updated = 1;
            $valueArr = array();


            foreach ($data as $key => $value) {

              if( isset($value['term_id']) && !empty($value['term_id']) ){

                  $termInfo = BlogCategory::getParentNode($value['term_id']);

                  if(isset($termInfo) && !empty($termInfo) ){
                    
                    $termInfo->translation_lang = $lang;
                    $termInfo->country_code = $country_code;
                    $termInfo->wp_term_id = trim($value['term_id']);
                    $termInfo->wp_parent_id = trim($value['parent']);
                    $termInfo->wp_translation_of = (is_numeric($value['translation_of'])? $value['translation_of'] : 0 );
                    $termInfo->name = trim($value['name']);

                    try{
                      $termInfo->save();
                      $cat_updated++;
                    }
                    catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'term_id' => $value['term_id'],
                        'message' => $e->getMessage()
                      ]); exit();
                    }
                    
                  } else {

                    $valueArr[$key]['translation_lang'] = $lang;
                    $valueArr[$key]['country_code'] = $country_code;
                    $valueArr[$key]['wp_term_id'] = trim($value['term_id']);
                    $valueArr[$key]['wp_parent_id'] = trim($value['parent']);
                    $valueArr[$key]['wp_translation_of'] = (is_numeric($value['translation_of'])? $value['translation_of'] : 0 );
                    $valueArr[$key]['name'] = trim($value['name']);
                    $valueArr[$key]['slug'] = trim($value['slug']);
                  }
              }
            }
            
            if( count($valueArr) > 0 ){

                try{
                  $catInfo = BlogCategory::insert($valueArr);

                    if($catInfo){

                      if($catInfo > 0 ){

                        echo json_encode([
                          'status' => 'success',
                          'language_code' => $lang,
                          'total' => count($valueArr)
                        ]);
                      }
                    }
                  }
                  catch(\Exception $e){
                    
                    echo json_encode([
                      'status' => 'error',
                      'language_code' => $lang,
                      'message' => $e->getMessage()
                    ]);

                    exit();
                  }
            } else {

              echo json_encode([
                'status' => 'success',
                'language_code' => $lang,
                'updated' => $cat_updated,
                'inserted' => count($valueArr),
                'total' => ($cat_updated + count($valueArr))
              ]);
            }

            //update wp_id for parent category
            $this->setCategoryParent();

          } // end of : if(count($data) > 0 )

        } //end of : if( isset($req['lang']) && !empty($req['lang']) )
        else { 

          $status = ['status' => 'false', 'message' => 'Language Code is required'];
          echo json_encode($status);
          exit();
        }
    }

    public function setCategoryParent(){

        $catArr = BlogCategory::get()->toArray();

        if( count($catArr) > 0 ){
          foreach ($catArr as $key => $cat) {

            //update translation of id
            if(isset($cat) && isset($cat['wp_translation_of']) && ($cat['wp_translation_of'] != 0) ){
              $parent = BlogCategory::getParentNode($cat['wp_translation_of']);
              
              if( isset($parent) && !empty($parent) ){
               
                  $status = BlogCategory::updateTranslationOf($parent->id, $cat['wp_term_id'],'translation_of');
                  
                  if( !$status['status'] ){
                    echo json_encode(['status' => false, 'message' => $status['message'], 'term_id' => $cat['wp_term_id'], 'parent_id' => $parent->id]);
                    exit();
                  }
              }
            }

            //update parent id
            if(isset($cat) && isset($cat['wp_parent_id']) && ($cat['wp_parent_id'] != 0) ){

              $parent = BlogCategory::getParentNode($cat['wp_parent_id']);
              
              if( isset($parent) && !empty($parent) ){
               
                  $status = BlogCategory::updateTranslationOf($parent->id, $cat['wp_term_id'], 'parent');
                  
                  if( !$status['status'] ){
                    echo json_encode(['status' => false, 'message' => $status['message'], 'term_id' => $cat['wp_term_id'], 'parent_id' => $parent->id]);
                    exit();
                  }
              }
            }

          }
          
          echo json_encode(['status' => true, 'message' => 'Parent Id updated successfully']);
          exit();
        }
    }
    
    public function getBlogs($request)
    { 
      $data = array();
      $blogInsertArr = array();
      $blogUpdateArr = array();
      $is_update_parent = false;
      $tagToEntry = array();
      $k = 0;

      if(count($request->all()) > 0){
        
        if(isset($request['lang']) && !empty($request['lang'])){

          // get all country language detail
          $country_language = CountryLanguage::where('wp_language', $request['lang'])->first();
          if(!empty($country_language)){
            // call api posts
            $req = array('action' => 'posts' , 'lang' => $request['lang']);
            $res = $this->getCurlRequest($this->url, $req);
            // check status is true
            if($res['status'] == true){

              $result = json_decode($res['response'], true);
              $data = $result[$this->language_country_array[$country_language->wp_language]];
               // echo "<pre>";  print_r($data);  "</pre>"; exit(); 
              if(count($data) > 0){

                $i = 0;

                // get all blogEntry records
                $getAllBlogs = BlogEntry::select('id','translation_lang','translation_of','wp_post_id','wp_translation_of')->get()->toArray();
                 
                //get blog categories
                $getAllBlogsCategories = BlogCategory::pluck('wp_term_id', 'id')->toArray();

                foreach($data as $val) {
                  
                  if($val['post_status'] == 'publish'){

                    $key_exist = false;
                    // check record exist in db
                    if(count($getAllBlogs) > 0){
                      $key_exist = array_search($val['post_id'], array_column($getAllBlogs , 'wp_post_id'));
                    }
                    
                    if($val['post_id'] == $val['translation_of']){
                      $wp_translation_of = 0;
                    }else{
                      $wp_translation_of = $val['translation_of'];   
                    }
                    
                    // categories array to string comma separated 
                    $categoriesArr = array();
                    $categories = '';
                    if(isset($val['categories']) && count($val['categories']) > 0){
                      
                      // find new category id
                      foreach($val['categories'] as $cat){
                        
                        // category exist ot not in blog category table
                        $catId = array_search($cat, $getAllBlogsCategories);
                        
                        // if category exist, stop loop 
                        if(!empty($catId) && $catId != "" && $catId > 0){
                          
                          // $categoriesArr[] = $catId;
                          $categories = $catId; 
                          break;
                        }
                      }
                      
                      // $categories = implode(",", $categoriesArr);
                    }

                    $blogImg = '';
                    // get blog image name
                    if (isset($val['post_feature_image']) && !empty($val['post_feature_image'])) {

                      $blogImg = substr($val['post_feature_image'] , strpos($val['post_feature_image'], 'uploads/'));
                      $blogImg = ltrim($blogImg, "uploads/");
                    }

                    $blogThumbnailImg = "";
                    if (isset($val['post_feature_image_cropped']) && count($val['post_feature_image_cropped']) > 0) {

                      $val['post_feature_image_cropped'] = array_values(array_unique($val['post_feature_image_cropped']));
                      $blogThumbnailImg = json_encode(array_map(
                          function($str) {
                              return ltrim(substr($str , strpos($str, 'uploads/')), "uploads/");
                          },
                          $val['post_feature_image_cropped']
                      ));
                    }
                    
                    if($key_exist !== false){
                        
                      $is_update_parent = true;
                      // update blog
                      $blogUpdateArr["translation_lang"] = $country_language->language_code;
                      $blogUpdateArr["country_code"] = strtoupper($country_language->country_code);
                      $blogUpdateArr["wp_translation_of"] = $wp_translation_of;
                      $blogUpdateArr["name"] = trim($val['post_title']);
                      $blogUpdateArr["category_id"] = $categories;
                      $blogUpdateArr["picture"] = $blogImg;
                      $blogUpdateArr["thumbnails"] = $blogThumbnailImg;
                      $blogUpdateArr["long_text"] = trim($val['post_content']);
                      $blogUpdateArr["slug"] = trim($val['post_name']);
                      $blogUpdateArr["wp_post_author"] = trim($val['post_author']);
                      $blogUpdateArr['created_at'] = date("Y-m-d H:i:s", strtotime($val['post_date']));
                      $blogUpdateArr['updated_at'] = date("Y-m-d  H:i:s", strtotime($val['post_modified']));
                      $blogUpdateArr["active"] = 1;

                      try{
                          // update if blog already exist
                          $update = BlogEntry::where('wp_post_id', $val['post_id'])->update($blogUpdateArr);
                        }
                        catch(\Exception $e){
                          echo json_encode([
                            'status' => 'false',
                            'post_id' => $val['post_id'],
                            'message' => $e->getMessage()
                          ]); exit();
                        }
                    }else{

                      $is_update_parent = true;
                      // create insert array
                      $blogInsertArr[$i]["translation_lang"] = $country_language->language_code;
                      $blogInsertArr[$i]["country_code"] = strtoupper($country_language->country_code);
                      $blogInsertArr[$i]["wp_post_id"] = $val['post_id'];
                      $blogInsertArr[$i]["wp_translation_of"] = $wp_translation_of;
                      $blogInsertArr[$i]["name"] = trim($val['post_title']);
                      $blogInsertArr[$i]["category_id"] = $categories;
                      $blogInsertArr[$i]["picture"] = $blogImg;
                      $blogInsertArr[$i]["thumbnails"] = $blogThumbnailImg;
                      $blogInsertArr[$i]["long_text"] = trim($val['post_content']);
                      $blogInsertArr[$i]["slug"] = trim($val['post_name']);
                      $blogInsertArr[$i]["wp_post_author"] = trim($val['post_author']);
                      $blogInsertArr[$i]['created_at'] = date("Y-m-d H:i:s", strtotime($val['post_date']));
                      $blogInsertArr[$i]['updated_at'] = date("Y-m-d  H:i:s", strtotime($val['post_modified']));
                      $blogInsertArr[$i]["active"] = 1;
                      $i++;
                    }

                    if(isset($val['tags']) && count($val['tags']) > 0){

                      foreach ($val['tags'] as $key => $tags) {
                        $tagToEntry[$k]['entry_id'] = $val['post_id'];
                        $tagToEntry[$k]['tag_id'] = $tags;
                        $tagToEntry[$k]['wp_entry_id'] = $val['post_id'];
                        $tagToEntry[$k]['wp_tag_id'] = $tags;
                        $k++;
                      }
                    }
                  }
                }

                // insert new record
                if(!empty($blogInsertArr) && count($blogInsertArr) > 0){
                  try{
                    $blogInfo = BlogEntry::insert($blogInsertArr);
                      
                    if($blogInfo){

                      if($blogInfo > 0 ){

                        echo json_encode([
                          'status' => 'success',
                          'total' => count($blogInsertArr),
                          'message' => 'insert Successfully'
                        ]);
                      }
                    }
                  }
                  catch(\Exception $e){
                    
                    echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
                    exit();
                  }
                }

                if(count($tagToEntry) > 0){
                  try{

                    $wp_entry_id = array_column(array_values($tagToEntry), 'wp_entry_id');
                    
                    $delete = BlogTagsToEntry::whereIn('wp_entry_id', $wp_entry_id)->delete();

                    $saveTagToEntry = BlogTagsToEntry::insert($tagToEntry);

                    if($saveTagToEntry){

                      if($saveTagToEntry > 0 ){

                        echo json_encode([
                          'status' => 'success',
                          'total' => count($tagToEntry),
                          'message' => 'Blog Tag To Entry insert Successfully'
                        ]);
                      }
                    }
                  }
                  catch(\Exception $e){
                    
                    echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
                    exit();
                  }
                }
                
                if($is_update_parent == true){

                  try{
                      // update post author user id
                     // DB::table('blog_entries')
                     // ->join('users', 'blog_entries.wp_post_author', '=', 'users.wp_user_id')
                     // ->update([ 'blog_entries.post_author' => DB::raw('users.id' )]);


                    // update translation_of id
                    $blogParentUpdate = DB::table('blog_entries as b1')
                                          ->Join('blog_entries as b2', 'b1.wp_post_id', '=', 'b2.wp_translation_of')
                                          ->where('b2.wp_translation_of', '!=' , 0)
                                          ->update(['b2.translation_of' => DB::raw('b1.id')]);

                    echo json_encode([
                        'status' => 'success',
                        'message' => "Update Successfully"
                      ]);
                  } catch(\Exception $e){
                    echo json_encode([
                        'status' => 'false',
                        'message' => $e->getMessage()
                      ]);
                    exit();
                  }

                  try{
                    // update entry id && tag Id
                    $BlogTagsToEntry = DB::table('blog_tags_to_entries as b1')
                                          ->Join('blog_entries as b2', 'b1.wp_entry_id', '=', 'b2.wp_post_id')
                                          ->Join('blog_tags as t', 't.wp_tag_id', '=', 'b1.wp_tag_id')
                                          ->update(['b1.tag_id' => DB::raw('t.id'), 'b1.entry_id' => DB::raw('b2.id')]);
                    echo json_encode([
                        'status' => 'success',
                        'message' => "Blog Tags To Entry Update Successfully"
                      ]);
                  } catch(\Exception $e){
                    echo json_encode([
                        'status' => 'false',
                        'message' => $e->getMessage()
                      ]);
                    exit();
                  }
                }
              }else{
                echo json_encode([
                  'status' => 'true',
                  'message' => "No record found!"
                ]);
                exit();
              }
            }else{
              echo json_encode([
                  'status' => 'false',
                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                ]);
              exit();
            }
          }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }
    public function updateBlogAuthor($request)
    { 
      $data = array();
      $blogUpdateArr = array();

      if(count($request->all()) > 0){
        
        if(isset($request['lang']) && !empty($request['lang'])){

          // get all country language detail
          $country_language = CountryLanguage::where('wp_language', $request['lang'])->first();
          if(!empty($country_language)){
      
            // call api posts
            $req = array('action' => 'posts' , 'lang' => $request['lang']);
            $res = $this->getCurlRequest($this->url, $req);
            // check status is true

            if($res['status'] == true){

              $result = json_decode($res['response'], true);
              $data = $result[$this->language_country_array[$country_language->wp_language]];
              if(count($data) > 0){
                foreach($data as $val) {
                  
                  
                      // update blog
                      $blogUpdateArr["wp_post_author"] = trim($val['post_author']);
                      $blogUpdateArr['created_at'] = date("Y-m-d H:i:s", strtotime($val['post_date']));
                      $blogUpdateArr['updated_at'] = date("Y-m-d  H:i:s", strtotime($val['post_modified']));

                      try{
                          // update if blog already exist
                          $update = BlogEntry::where('wp_post_id', $val['post_id'])->update($blogUpdateArr);
                        }
                        catch(\Exception $e){
                          echo json_encode([
                            'status' => 'false',
                            'post_id' => $val['post_id'],
                            'message' => $e->getMessage()
                          ]); exit();
                        }
                  }
                  echo json_encode([
                    'status' => 'success',
                    'message' => "Update Successfully"
                  ]);

                
                
              }else{
                echo json_encode([
                  'status' => 'true',
                  'message' => "No record found!"
                ]);
                exit();
              }
            }else{
              echo json_encode([
                  'status' => 'false',
                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                ]);
              exit();
            }
          }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }
    public function getBlogTags($request){

      $data = array();
      $tagInsertArr = array();
      $tagUpdateArr = array();
      $is_update_parent = false;

      if(count($request->all()) > 0){

        if(isset($request['lang']) && !empty($request['lang'])){
          // get all country language detail
          $country_language = CountryLanguage::where('wp_language', $request['lang'])->first();
          
          if(!empty($country_language)){
            
            // call api get tags
            $req = array('action' => 'get_tags' , 'lang' => $country_language->wp_language);
            $res = $this->getCurlRequest($this->url, $req);

            if($res['status'] == true){

              $data = json_decode($res['response'], true);
              
              if(count($data) > 0){

                $i = 0;

                // get all tags records
                $getAllTags = BlogTag::select('id','translation_lang','translation_of','wp_tag_id','wp_translation_of')->get()->toArray();

                foreach($data as $val) {

                  $key_exist = false;
                  if(count($getAllTags) > 0){
                    // check record exist in db
                    $key_exist = array_search($val['term_id'], array_column($getAllTags , 'wp_tag_id'));
                  }

                  if($val['translation_of'] == 0){
                    $wp_translation_of = 0;
                  }else{
                    $wp_translation_of = $val['translation_of'];   
                  }

                  if($key_exist !== false){
                  
                    $is_update_parent = true;

                    // update tag
                    $tagUpdateArr["translation_lang"] = $country_language->language_code;
                    $tagUpdateArr["wp_tag_id"] = $val['term_id'];
                    $tagUpdateArr["tag"] = $val['name'];
                    $tagUpdateArr["slug"] = $val['slug'];
                    $tagUpdateArr["wp_translation_of"] = $wp_translation_of;
                          
                    try{
                      // update if tag already exist
                      $update = BlogTag::where('wp_tag_id', $val['term_id'])->update($tagUpdateArr);
                    }
                    catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'post_id' => $val['term_id'],
                        'message' => $e->getMessage()
                      ]); exit();
                    }
                  }
                  else{
                    $is_update_parent = true;
                    // Tag Insert Array
                    $tagInsertArr[$i]["translation_lang"] = $country_language->language_code;
                    $tagInsertArr[$i]["wp_tag_id"] = $val['term_id'];
                    $tagInsertArr[$i]["tag"] = $val['name'];
                    $tagInsertArr[$i]["slug"] = $val['slug'];
                    $tagInsertArr[$i]["wp_translation_of"] = $wp_translation_of;
                    $i++;
                  }
                }

                // insert new record
                if(!empty($tagInsertArr) && count($tagInsertArr) > 0){
                  try{
                    $tagInfo = BlogTag::insert($tagInsertArr);

                    if($tagInfo){

                      if($tagInfo > 0 ){

                        echo json_encode([
                          'status' => 'success',
                          'total' => count($tagInsertArr),
                          'message' => 'insert Successfully'
                        ]);
                      }
                    }
                  }
                  catch(\Exception $e){
                    
                    echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
                    exit();
                  }
                }
                if($is_update_parent == true){
                  
                  try{
                    // update translation_of id
                    $tagParentUpdate = DB::table('blog_tags as t1')
                                          ->Join('blog_tags as t2', 't1.wp_tag_id', '=', 't2.wp_translation_of')
                                          ->where('t2.wp_translation_of', '!=' , 0)
                                          ->update(['t2.translation_of' => DB::raw('t1.id')]);
                    echo json_encode([
                        'status' => 'success',
                        'message' => "Update Successfully"
                      ]);
                  } catch(\Exception $e){
                    echo json_encode([
                        'status' => 'false',
                        'message' => $e->getMessage()
                      ]);
                    exit();
                  }
                }
              }else{
                echo json_encode([
                  'status' => 'true',
                  'message' => "No record found!"
                ]);
                exit();
              }
            }else{
              echo json_encode([
                  'status' => 'false',
                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                ]);
              exit();
            }
          }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }

    /*
      action : get_model_list 
    */
    public function getModelsList($request){

      Log::info("================== process starting for model migration =============");
         Mail::send('emails.exception', ['error' => 'Model list migration started', 'url' => '', 'ErrorCode' => ''], function ($m) {
                    $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
                });


        //store log file
        $this->storeLog($this->model_log, 'Info', '=================== START CRON ===================');

        $getTotal = $per_page = 0;
        $modelArray = array();

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        $req = array('action' => 'get_models' , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);


        //set infinite execution time for get more than 2000 records
        ini_set('max_execution_time', 0);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);
            
            if( isset($result['total']) && !empty($result['total']) ){
              $getTotal = $result['total'];
            }

            //store log file
            $this->storeLog($this->model_log, 'Info' ,'init count =>'.$getTotal);


            // if( isset($result['per_page']) && !empty($result['per_page']) ){
            //   $per_page = $result['per_page'];
            // }

            // if($getTotal > 0 && $per_page != 0){
                
                // if($getTotal > $per_page){

                  // $pages = ceil( ( $getTotal/$per_page) );
                  //store log file
                  // $this->storeLog($this->model_log, 'Info', 'Total Pages =>'.$pages);
                  
                  // for ($i=1; $i <= $pages; $i++) {

                    $modelList = array();

                    // $req['paged'] = $i;

                    // if($i !== 1){
                    //   $req = array('action' => 'get_models' , 'paged' => $i);
                    //   $res = $this->getCurlRequest($this->url, $req);
                    // }

                    //store log file
                    // $this->storeLog($this->model_log, 'Info', 'Loop Start =>');

                    // if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
                      
                      // $result = json_decode($res['response'], true);

                      if( isset($result['results']) && !empty($result['results']) && count($result['results'])>0 ){

                          //fetch wordpress data properly and have model data to insert

                          $modelList = $result['results'];
                          echo "count: ".count($modelList);

                          //get existing jobs
                          $this->existingJobs = Post::pluck('id', 'wp_post_id')->toArray();

                          //get existing cities
                          $this->cityList = City::pluck('id', 'name')->toArray();
                          $this->cityList = array_change_key_case($this->cityList, CASE_LOWER); // change cities key to lower case


                          //get existing country
                          $this->countryList = Country::withoutGlobalScopes()->pluck('code', 'name')->toArray();
                          $this->countryList = array_change_key_case($this->countryList, CASE_LOWER); // change country key to lower case

                           //get existing partner branches
                          $this->branchList = Branch::withoutGlobalScopes()->pluck('id', 'slug')->toArray();

                          //get existing model categories
                          $this->modelcategoryList = ModelCategory::withoutGlobalScopes()->pluck('id', 'slug')->toArray();

                          // get all existing height 
                          $heightArr = UserHeightUnitOptions::pluck('at_unit', 'id')->toArray();
                          $this->heightListArr = preg_replace("/cm/", " ", $heightArr);

                          // get all existing weight 
                          $weightArr = UserWeightUnitsOptions::pluck('at_unit', 'id')->toArray();
                          $this->weightListArr = preg_replace("/kg/", " ", $weightArr);

                          // get all existing chest
                          $chestListArr = UserChestUnitOptions::pluck('at_unit', 'id')->toArray();
                          $this->chestListArr = preg_replace("/cm/", " ", $chestListArr);

                          // get all existing waist 
                          $waistListArr = UserWaistUnitOptions::pluck('at_unit', 'id')->toArray();
                          $this->waistListArr = preg_replace("/cm/", " ", $waistListArr);

                          // get all existing hips 
                          $hipsListArr = UserHipsUnitOptions::pluck('at_unit', 'id')->toArray();
                          $this->hipsListArr = preg_replace("/cm/", " ", $hipsListArr);

                          $this->modelEyeColor = $this->getEyeColor();
                          $this->modelSkinColor = $this->getSkinColor();
                          $this->modelHairColor = $this->getHairColor();

                          /*
                          // get all existing kids dress size array
                          $this->dressSizeKidArr = UserDressSizeOptions::whereNotNull('at_unit_kids')->pluck('at_unit_kids', 'id')->toArray();

                          // get all existing men dress size array
                          $this->dressSizeMenArr = UserDressSizeOptions::whereNotNull('at_unit_men')->pluck('at_unit_men', 'id')->toArray();

                          // get all existing women dress size array
                          $this->dressSizeWomenArr = UserDressSizeOptions::whereNotNull('at_unit_women')->pluck('at_unit_women', 'id')->toArray();

                          // get all existing kids shoe size array
                          $this->shoeSizeKidArr = UserShoesUnitsOptions::whereNotNull('at_unit_kids')->pluck('at_unit_kids', 'id')->toArray();

                          // get all existing men shoe size array
                          $this->shoeSizeMenArr = UserShoesUnitsOptions::whereNotNull('at_unit_men')->pluck('at_unit_men', 'id')->toArray();

                          // get all existing women shoe size array
                          $this->shoeSizeWomenArr = UserShoesUnitsOptions::whereNotNull('at_unit_women')->pluck('at_unit_women', 'id')->toArray();

                          */

                          // get standard unit for dress size and shoe size
                          $this->dressSizeArr = UserDressSizeOptions::whereNotNull('standard_unit')->pluck('standard_unit', 'id')->toArray();

                          $this->shoeSizeArr = UserShoesUnitsOptions::whereNotNull('standard_unit')->pluck('standard_unit', 'id')->toArray();


                            foreach ($modelList as $key => $model) {

                                //store log file
                                $this->storeLog($this->model_log, 'Info', 'Model Object Passed (storeUser) =>'.json_encode($model));
                                
                                $result = $this->storeUser($model, 3);


                                // echo json_encode([
                                //   'status' => 'success',
                                //   'message' => 'insert Successfully'
                                // ]);
                                // Mail::send('emails.exception', ['error' => "inserted successfully", 'url' => '', 'ErrorCode' => ''], function ($m) {
                                //       $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
                                // });

                                //store log file
                                // $this->storeLog($this->model_log, 'Info', 'Retrun Response (storeUser) =>'.json_encode($result));
                            }
                      }
                      else {
                          Log::info("No Model data found to insert");

                              echo $status = json_encode([
                                  'status' => 'false',
                                  'message' => "No Model data found to insert"
                                ]);

                              //store log file
                              $this->storeLog($this->model_log, 'Error', $status); 
                              Mail::send('emails.exception', ['error' => $status, 'url' => '', 'ErrorCode' => ''], function ($m) {
                                  $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
                              });
                              exit();
                          }
                    // } else {

                    //   $status = json_encode([
                    //     'status' => 'false',
                    //     'message' => "SSL certificate problem: unable to get local issuer certificate"
                    //   ]);

                    //   //store log file
                    //   $this->storeLog($this->model_log, 'Error', $status); 
                    //   Mail::send('emails.exception', ['error' => $status, 'url' => '', 'ErrorCode' => ''], function ($m) {
                    //               $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
                    //           });
                    //   exit();
                    // }

                    //store log file
                    // $this->storeLog($this->model_log, 'Info', 'Loop End =>');
                  //} //for loop ends
                  // Update favourites jobs favourites id
                  // $this->updateFavouriteJobs();
                  // Update Users jobs applied post_id
                  // $this->updateUserJobsApplied();
                  
                // }
            // } else {

            //   $status = json_encode([
            //     'status' => 'false',
            //     'message' => "SSL certificate problem: unable to get local issuer certificate"
            //   ]); 
              
            //   //store log file
            //   $this->storeLog($this->model_log, 'Error', $status); 
            //   Mail::send('emails.exception', ['error' => $status, 'url' => '', 'ErrorCode' => ''], function ($m) {
            //       $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
            //   });
            //   exit();

            // }

        } else {
          Log::info("Error in getting migration response");
          echo $status = json_encode([
                'status' => 'false',
                'message' => "SSL certificate problem: unable to get local issuer certificate"
              ]);

          //store log file
          $this->storeLog($this->model_log, 'Error', $status); 
          Mail::send('emails.exception', ['error' => $status, 'url' => '', 'ErrorCode' => ''], function ($m) {
              $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
          });
          exit();
      }
      Log::info("================== process ends for model migration =============");
      echo json_encode([
        'status' => 'success',
        'message' => 'insert Successfully'
      ]);
      Mail::send('emails.exception', ['error' => "inserted successfully", 'url' => '', 'ErrorCode' => ''], function ($m) {
            $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
      });

      Mail::send('emails.exception', ['error' => "model migration cron ended", 'url' => '', 'ErrorCode' => ''], function ($m) {
          $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
      });

      //store log file
      $this->storeLog($this->model_log, 'Info', '=================== END CRON ===================');
    }
    /*
      action : get_partner_list 
    */
    public function getPartnersList($request){

        Log::info("================== process starting for partner migration =============");
        Mail::send('emails.exception', ['error' => 'Partner list migration started', 'url' => '', 'ErrorCode' => ''],
        function ($m) {
            $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
        });

        //store log file
        $this->storeLog($this->model_log, 'Info', '=================== START CRON ===================');

        $getTotal = $per_page = $pages = 0;
        $partnerArray = array();

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        $req = array('action' => 'get_partners' , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);

        //set infinite execution time for get more than 2000 records
        ini_set('max_execution_time', 0);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){

            $total_page = '';

            $result = json_decode($res['response'], true);
            
            if(  isset($result['total']) && !empty($result['total']) ){
              $getTotal = $result['total'];
            }

            $pages = ceil( ( $getTotal/$result['per_page']) );

            //store log file
            $this->storeLog($this->model_log, 'Info' ,'init count =>'.$getTotal);

            $partnerList = array();

            if( isset($result['results']) && !empty($result['results']) && count($result['results'])>0 ){

                //fetch wordpress data properly and have model data to insert

                $partnerList = $result['results'];
                echo "count: ".count($partnerList);

                //get existing jobs
                $this->existingJobs = Post::pluck('id', 'wp_post_id')->toArray();

                //get existing cities
                $this->cityList = City::pluck('id', 'name')->toArray();
                $this->cityList = array_change_key_case($this->cityList, CASE_LOWER); // change cities key to lower case


                //get existing country
                $this->countryList = Country::withoutGlobalScopes()->pluck('code', 'name')->toArray();
                $this->countryList = array_change_key_case($this->countryList, CASE_LOWER); // change country key to lower case

                 //get existing partner branches
                $this->branchList = Branch::withoutGlobalScopes()->pluck('id', 'slug')->toArray();

                //get existing model categories
                $this->modelcategoryList = ModelCategory::withoutGlobalScopes()->pluck('id', 'slug')->toArray();

                foreach ($partnerList as $key => $partner) {
                    //store log file
                    $this->storeLog($this->model_log, 'Info', 'Partner Object Passed (storeUser) =>'.json_encode($partner));
                    
                    $result = $this->storeUser($partner, 2);

                    //store log file
                    $this->storeLog($this->model_log, 'Info', 'Retrun Response (storeUser) =>'.json_encode($result));
                }
            }
            else {
                Log::info("No Partner data found to insert");
                echo $status = json_encode([
                    'status' => 'false',
                    'message' => "No Partner data found to insert"
                  ]);

                //store log file
                $this->storeLog($this->model_log, 'Error', $status); 
                Mail::send('emails.exception', ['error' => $status, 'url' => '', 'ErrorCode' => ''], function ($m) {
                    $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
                });
                exit();
            }

        } else {
          Log::info("Error in getting migration response");
          echo $status = json_encode([
                'status' => 'false',
                'message' => "SSL certificate problem: unable to get local issuer certificate"
              ]);

          //store log file
          $this->storeLog($this->model_log, 'Error', $status); 
          Mail::send('emails.exception', ['error' => $status, 'url' => '', 'ErrorCode' => ''], function ($m) {
              $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
          });
          exit();
        }
        // Update favourites users favourites id 
        $this->updateFavouriteUsers();

        //update model applied jobs applications and messages in message table
        /* do not call this function here as we are calling partner migration page wise */
        //$this->updateUserConversation();

        try{ 
            $updatePostUserId = DB::table('posts as p')
            ->Join('users as u', 'u.wp_user_id', '=', 'p.wp_user_id')
            ->update(['p.user_id' => DB::raw('u.id')]);

            //store log file
            $this->storeLog($this->model_log, 'Info', 'Update posts user id successfully');
        }
        catch(\Exception $e){
            $status = json_encode([ 'status' => 'false', 'message' => $e->getMessage() ]);
            //store log file
            $this->storeLog($this->model_log, 'Error', $status);
            exit();
        }

        Log::info("================== process ends for partner migration =============");
        echo json_encode([
          'status' => 'success',
          'message' => 'insert Successfully'
        ]);
        
        Mail::send('emails.exception', ['error' => "partner migration cron ended", 'url' => '', 'ErrorCode' => ''], function ($m) {
            $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
        });

        //store log file
        $this->storeLog($this->model_log, 'Info', '=================== END CRON ===================');
    }
    /*public function getPartnersList_old(){

        $getTotal = $per_page = 0;
        $modelArray = array();

        //store log file
        $this->storeLog($this->model_log, 'Info', '=================== START CRON ===================');

        //set infinite execution time for get more than 3000 records
        ini_set('max_execution_time', 0);

        $req = array('action' => 'get_partners' , 'paged' => 1);
        $res = $this->getCurlRequest($this->url, $req);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);

            if( isset($result['total']) && !empty($result['total']) ){
              $getTotal = $result['total'];
            }

            //get existing jobs
            $this->existingJobs = Post::pluck('id', 'wp_post_id')->toArray();

            //get existing cities
            $this->cityList = City::pluck('id', 'name')->toArray();
            $this->cityList = array_change_key_case($this->cityList, CASE_LOWER); // change cities key to lower case


            //get existing country
            $this->countryList = Country::withoutGlobalScopes()->pluck('code', 'name')->toArray();
            $this->countryList = array_change_key_case($this->countryList, CASE_LOWER); // change country key to lower case

            //get existing partner branches
            $this->branchList = Branch::withoutGlobalScopes()->pluck('id', 'slug')->toArray();

            //get existing model categories
            $this->modelcategoryList = ModelCategory::withoutGlobalScopes()->pluck('id', 'slug')->toArray();


            //store log file
            $this->storeLog($this->model_log, 'Info' ,'init count =>'.$getTotal);

            if( isset($result['per_page']) && !empty($result['per_page']) ){
              $per_page = $result['per_page'];
            }

            if($getTotal > 0 && $per_page != 0){
                
                if($getTotal > $per_page){

                  $pages = ceil( ( $getTotal/$per_page) );

                  //store log file
                  $this->storeLog($this->model_log, 'Info', 'Total Pages =>'.$pages);
                  
                  for ($i=1; $i <= $pages; $i++) {

                    $partnerList = array();

                    $req['paged'] = $i;

                    if($i !== 1){
                      $req = array('action' => 'get_partners' , 'paged' => $i);
                      $res = $this->getCurlRequest($this->url, $req);
                    }

                    //store log file
                    $this->storeLog($this->model_log, 'Info', 'Loop Start =>'.$i);

                    if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
                      
                      $result = json_decode($res['response'], true);

                      if( isset($result['results']) && !empty($result['results']) ){
                          $partnerList = $result['results'];

                          
                          if( count($partnerList) > 0 ){

                            foreach ($partnerList as $key => $partner) {

                               //store log file
                                $this->storeLog($this->model_log, 'Info', 'Partner Object Passed (storeUser) =>'.json_encode($partner));
                                
                                $result = $this->storeUser($partner, 2);

                                 //store log file
                                $this->storeLog($this->model_log, 'Info', 'Retrun Response (storeUser) =>'.json_encode($result));
                            }

                          } else {
                              $status = json_encode([
                                  'status' => 'false',
                                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                                ]);

                              //store log file
                              $this->storeLog($this->model_log, 'Error', $status); exit();
                          }
                      } 
                    }else{
                          $status = json_encode([
                            'status' => 'false',
                            'message' => "SSL certificate problem: unable to get local issuer certificate"
                          ]);

                              //store log file
                              $this->storeLog($this->model_log, 'Error', $status); exit();
                    }
                  }

                  // Update favourites jobs favourites id 
                  // $this->updateFavouriteJobs();
                  // Update favourites users favourites id 
                  $this->updateFavouriteUsers();
                  // Update Users jobs applied post_id
                  // $this->updateUserJobsApplied();

                  echo json_encode([
                    'status' => 'success',
                    'message' => 'insert Successfully'
                  ]);
                }
            } else {

              $status = json_encode([
                  'status' => 'false',
                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                ]);

              //store log file
              $this->storeLog($this->model_log, 'Error', $status); exit();

            }

        } else {
          $status = json_encode([
              'status' => 'false',
              'message' => "SSL certificate problem: unable to get local issuer certificate"
            ]);

          //store log file
          $this->storeLog($this->model_log, 'Error', $status); exit();
        }

        try{ 
          $updatePostUserId = DB::table('posts as p')
          ->Join('users as u', 'u.wp_user_id', '=', 'p.wp_user_id')
          ->update(['p.user_id' => DB::raw('u.id')]);

          //store log file
          $this->storeLog($this->model_log, 'Info', 'Update posts user id successfully');
        }
        catch(\Exception $e){
            $status = json_encode([ 'status' => 'false', 'message' => $e->getMessage() ]);
            //store log file
            $this->storeLog($this->model_log, 'Error', $status);
            exit();
        }

        //store log file
        $this->storeLog($this->model_log, 'Info', '=================== END CRON ===================');
          
    }*/

    public function storeUser($wp_user, $user_type){
      
      $lastInsertId = $is_update = 0;
      $user = array();

      if(isset($wp_user) && !empty($wp_user)){

        if( isset($wp_user['user_id']) && $wp_user['user_id'] > 0 ){

          $modelObj = User::withoutGlobalScopes([VerifiedScope::class])->where('wp_user_id', $wp_user['user_id'])->first();

          $is_update = 1;

          if(empty($modelObj)){
            $modelObj = new User();
            $is_update = 0;
          }
        }

        //store log file
        $this->storeLog($this->model_log, 'Info', 'User Id =>'.$wp_user['user_id'].' User Type => '.$user_type);

        $gender_id = config('constant.gender_male');

        if( isset($wp_user['cs_sex']) && !empty($wp_user['cs_sex']) ){
          if($wp_user['cs_sex'] == "female"){
            $gender_id = config('constant.gender_female');
          }
        }

        $city = array();
        $latitude = "";
        $longitude = "";

        // remove city id and store city name direct in database
        // if( isset($wp_user['cs_post_loc_city']) && !empty($wp_user['cs_post_loc_city']) ){
        //     if( isset($wp_user['cs_post_loc_city']) && !empty($wp_user['cs_post_loc_city']) ){
        //       $wp_user['cs_post_loc_city'] = strtolower(trim($wp_user['cs_post_loc_city']));
        //       $city_id = (isset($this->cityList[$wp_user['cs_post_loc_city']]))? $this->cityList[$wp_user['cs_post_loc_city']] : '';
        //     }
        // }

        $cityname = isset($wp_user['cs_post_loc_city'])? $wp_user['cs_post_loc_city'] : '';

        $allow_search = 0;
        if( isset($wp_user['cs_allow_search']) && !empty($wp_user['cs_allow_search']) ){
            if($wp_user['cs_allow_search'] === 'yes'){
              $allow_search = 1;
            }
        }

        $user_status = 0;
        if( isset($wp_user['cs_user_status']) &&  !empty($wp_user['cs_user_status']) ){
            if($wp_user['cs_user_status'] === 'active'){
              $user_status = 1;
            }
        }

        $user_country_code = strtoupper($wp_user['cs_loc_iso_code']);
        if( empty($wp_user['cs_loc_iso_code']) ){
            if(isset($wp_user['cs_post_loc_country']) && !empty($wp_user['cs_post_loc_country'])){
                $wp_user['cs_post_loc_country'] = strtolower(trim($wp_user['cs_post_loc_country']));
                $user_country_code = (isset($this->countryList[$wp_user['cs_post_loc_country']]))? $this->countryList[$wp_user['cs_post_loc_country']] : '';
            }
        }

        $modelObj->wp_user_id = (isset($wp_user['user_id']))? $wp_user['user_id'] : 0;
        $modelObj->email = (isset($wp_user['email']))? $wp_user['email'] : '';
        $modelObj->active = $user_status;
        $modelObj->gender_id = $gender_id;

        if(isset($wp_user['user_name'])){
          $modelObj->username = $wp_user['user_name'];
        }
        else if(isset($wp_user['username'])){
          $modelObj->username = $wp_user['username'];
        }
        else{
          $modelObj->username = '';
        }
        // $modelObj->username = (isset($wp_user['user_name']))? $wp_user['user_name'] : (isset($wp_user['username'])) ? $wp_user['username'] : '';
        // $modelObj->username = (isset($wp_user['user_name']))? $wp_user['user_name'] : '';
        $modelObj->hash_code = (isset($wp_user['user_hash']))? $wp_user['user_hash'] : '';

        $modelObj->latitude = (isset($wp_user['cs_post_loc_latitude']))? $wp_user['cs_post_loc_latitude'] : '';
        $modelObj->longitude = (isset($wp_user['cs_post_loc_longitude']))? $wp_user['cs_post_loc_longitude'] : '';

        $modelObj->country_code = $user_country_code;
        $modelObj->phone = (isset($wp_user['cs_phone_number']))? $wp_user['cs_phone_number'] : 0;
        $modelObj->phone_code = (isset($wp_user['cs_loc_tel_prefix']))? $wp_user['cs_loc_tel_prefix'] : '';
        $modelObj->ip_addr = (isset($wp_user['cs_ip_address']))? $wp_user['cs_ip_address'] : '';
        $modelObj->user_type_id = $user_type;
        $modelObj->name = (isset($wp_user['first_name']))? $wp_user['first_name'] : '';
        $modelObj->verified_email = 1;
        $modelObj->verified_phone = 1;
        // $modelObj->about = (isset($wp_user['description']))? $wp_user['description'] : '';

        try {
          $modelObj->save();
          
          //store log file
          $this->storeLog($this->model_log, 'Info', ' Store User ['.$wp_user['user_id'].'] => '.$modelObj->id);

        } catch(\Exception $e){
          $status =  json_encode([ 'status' => 'false','message' => $e->getMessage(), 'wp_user_id' => $wp_user['user_id'] ]);

          //store log file
          $this->storeLog($this->model_log, 'Error', json_encode($status));
          exit();
        }

        //$is_kid_model = false;

        if($modelObj->id){

          /* GET MODEL OR PARNTER CATEGORY FROM SLUG START */
           
            $model_category = 0;
            $partner_category = 0;

            /* User Type => parnter => 2 and model => 3 */
            if( isset($wp_user['cs_specialisms']) && !empty($wp_user['cs_specialisms']) ){
                
                if(is_array($wp_user['cs_specialisms'])){
                  if(isset($wp_user['cs_specialisms'][0])){
                    $wp_user['cs_specialisms'] = $wp_user['cs_specialisms'][0];
                  }
                }
                // check user type is partner
                if($user_type == 2){
                  if( isset($wp_user['cs_specialisms']) && !empty($wp_user['cs_specialisms']) ){
                    $wp_user['cs_specialisms'] = strtolower(trim($wp_user['cs_specialisms']));
                    $partner_category = (isset($this->branchList[$wp_user['cs_specialisms']]))? $this->branchList[$wp_user['cs_specialisms']] : 0;
                  }
                }

                // check user type is model
                if($user_type == 3){
                    
                    if( isset($wp_user['cs_specialisms']) && !empty($wp_user['cs_specialisms']) ){
                      
                      $wp_user['cs_specialisms'] = strtolower(trim($wp_user['cs_specialisms']));
                     
                      $model_category = (isset($this->modelcategoryList[$wp_user['cs_specialisms']]))? $this->modelcategoryList[$wp_user['cs_specialisms']] : 0;

                      // check model category, kid or othore 
                      // if(in_array(strtolower(trim($wp_user['cs_specialisms'])) , config('app.baby_model_slugs')) ){
                        
                      //   $is_kid_model = true;
                      // }
                    }
                }
            }

            /* GET MODEL OR PARNTER CATEGORY FROM SLUG END */

            $cs_tfp = 0;
            if( isset($wp_user['cs_tfp']) && !empty($wp_user) ){
              if($wp_user['cs_tfp'] === 'yes'){
                $cs_tfp = 1;
              }
            }


          /* save user_profile code starts */
            if($is_update){
              $modelProfile = UserProfile::where('user_id', $modelObj->id)->first();
              
              if( empty($modelProfile) ){
                $modelProfile = new UserProfile();
              }
            } else {
              $modelProfile = new UserProfile();
            }

            $modelProfile->preventAttrSet = true;

            /* GET USER PROFILE IMAGE AND SPLIT WITH uploads FOLDER AND STORE THE REMAIN STRING AS PATH */
            $profile_picture = "";
            if( isset($wp_user['profile_picture']) && !empty($wp_user['profile_picture']) ){
              if( is_array(['profile_picture']) && !empty($wp_user['profile_picture'])){
                foreach ($wp_user['profile_picture'] as $key => $value) {
                  if( $key == 0 ){
                    $split = explode($this->wp_upload_folder, $value[$key]);

                    if( isset($split) && count($split) > 0 ){
                      $profile_picture = (isset($split[1]))? ltrim($split[1], '/') : '';
                    }
                  }
                }
              }
            }

            //store log file
            $this->storeLog($this->model_log, 'Info', 'GET USER PROFILE IMAGE AND SPLIT WITH uploads FOLDER AND STORE THE REMAIN STRING AS PATH');

            /* GET USER COVER IMAGE AND SPLIT WITH uploads FOLDER AND STORE THE REMAIN STRING AS PATH */
            $cover_picture = "";
            if( isset($wp_user['cover_picture']) && !empty($wp_user['cover_picture']) ){
              if( is_array(['cover_picture']) && !empty($wp_user['cover_picture'])){
                foreach ($wp_user['cover_picture'] as $key => $value) {
                  if( $key == 0 ){
                    $coversplit = explode($this->wp_upload_folder, $value[$key]);

                    if( isset($coversplit) && count($coversplit) > 0 ){
                      $cover_picture = (isset($coversplit[1]))? ltrim($coversplit[1], '/') : '';
                    }
                  }
                }
              }
            }

            $modelProfile->user_id = $modelObj->id;
            $modelProfile->first_name = (isset($wp_user['first_name']))? $wp_user['first_name'] : '';
            $modelProfile->last_name = (isset($wp_user['last_name']))? $wp_user['last_name'] : '';

            // if model is baby model then store gardian first and last name
            $modelProfile->fname_parent = (isset($wp_user['p_first_name']))? $wp_user['p_first_name'] : '';
            $modelProfile->lname_parent = (isset($wp_user['p_last_anme']))? $wp_user['p_last_anme'] : '';
            
            //$modelProfile->birth_day = (isset($wp_user['cs_birth_day']))? date("Y-m-d", strtotime($wp_user['cs_birth_day'])) : NULL;

            $birth_day = NULL;
            if(isset($wp_user['cs_birth_day']) && !empty($wp_user['cs_birth_day'])){
              $wp_user['cs_birth_day'] = trim($wp_user['cs_birth_day']);
              if($wp_user['cs_birth_day'] !== '1970-01-01' && $wp_user['cs_birth_day'] !== '0000-00-00'){
                $birth_day = date("Y-m-d", strtotime($wp_user['cs_birth_day']));
              }
            }
            
            $modelProfile->birth_day = $birth_day;

            if(isset($wp_user['go_code']) && !empty($wp_user['go_code'])){
              $modelProfile->go_code = $wp_user['go_code'];
            }


            $modelProfile->category_id = ($user_type == 2)? $partner_category : $model_category;

            $modelProfile->logo = $profile_picture;
            $modelProfile->cover = $cover_picture;
            // $modelProfile->about_me = (isset($wp_user['description']))? $wp_user['description'] : '';
            
            $modelProfile->company_name = (isset($wp_user['company_name']))? $wp_user['company_name'] : '';

            // $modelProfile->company_name = (isset($wp_user['description']))? $wp_user['description'] : '';
            $modelProfile->tfp = $cs_tfp;
            // commented phone number code
            // $modelProfile->phone_number = (isset($wp_user['cs_phone_number']))? $wp_user['cs_phone_number'] : '';
            $modelProfile->ip_address = (isset($wp_user['ip_address']))? $wp_user['ip_address'] : '';
            $modelProfile->street = (isset($wp_user['cs_street']))? $wp_user['cs_street'] : '';
            $modelProfile->zip = (isset($wp_user['cs_zip_code']))? $wp_user['cs_zip_code'] : '';
            $modelProfile->city = $cityname;
            //$modelProfile->country = $user_country_code;
            
            // $modelProfile->piercing = (isset($wp_user['cs_piercing']))? $wp_user['cs_piercing'] : 0;
            // $modelProfile->tattoo = (isset($wp_user['cs_tattoo']))? $wp_user['cs_tattoo'] : 0;

            $tattoo = 0;
            if(isset($wp_user['cs_tattoo']) && !empty($wp_user['cs_tattoo'])){
              $tattoo = 2;
              if($wp_user['cs_tattoo'] === 'yes'){
                $tattoo = 1;
              }
            }

            $piercing = 0;
            if(isset($wp_user['cs_piercing']) && !empty($wp_user['cs_piercing'])){
              $piercing = 2;
              if($wp_user['cs_piercing'] === 'yes'){
                $piercing = 1;
              }
            }

            $modelProfile->piercing = $tattoo;
            $modelProfile->tattoo = $piercing;

            $modelProfile->allow_search = $allow_search;
            $modelProfile->description = (isset($wp_user['description']))? $wp_user['description'] : '';
            $modelProfile->status = strtoupper((isset($wp_user['cs_user_status']))? $wp_user['cs_user_status'] : "inactive");

            $height_id = (isset($wp_user['cs_candidate_height']))? $wp_user['cs_candidate_height'] : '';

            if(!empty($height_id)){ 
              
              $height_id = array_search((int) $height_id, $this->heightListArr);
            }
            
            $modelProfile->height_id = (!empty($height_id)) ? $height_id : 0;

            $weight_id = (isset($wp_user['cs_candidate_weight']))? $wp_user['cs_candidate_weight'] : '';

            if(!empty($weight_id)){
              $weight_id = array_search((int) $weight_id, $this->weightListArr);
            }

            $modelProfile->weight_id = (!empty($weight_id)) ? $weight_id : 0;

            $dress_size_id = (isset($wp_user['cs_candidate_clothing_size']))? $wp_user['cs_candidate_clothing_size'] : 0;

            if($dress_size_id != 0){
              
              // model category is kids or baby-model
              // if($dress_size_id != 0 && $is_kid_model == true){
                
              //   $dress_size_id = array_search((int) $dress_size_id, $this->dressSizeKidArr);
              // }

              // // model category is not kid, gender is female.
              // if($dress_size_id != 0 && $is_kid_model == false && $gender_id == config('constant.gender_female')){
                
              //   $dress_size_id = array_search((int) $dress_size_id, $this->dressSizeWomenArr);
              // }

              // // model category is not kid, gender is male.
              // if($dress_size_id != 0 && $is_kid_model == false && $gender_id == config('constant.gender_male')){

              //   $dress_size_id = array_search((int) $dress_size_id, $this->dressSizeMenArr);
              // }

              $dress_size_id = array_search((int) $dress_size_id, $this->dressSizeArr);
            }
            
            // $modelProfile->size_id = (isset($wp_user['cs_candidate_clothing_size']))? $wp_user['cs_candidate_clothing_size'] : 0;

            $modelProfile->size_id = (!empty($dress_size_id)) ? $dress_size_id : 0;

            $modelProfile->clothing_size_id = (isset($wp_user['cs_candidate_clothing_size']))? $wp_user['cs_candidate_clothing_size'] : 0;

            if($user_type == 3){

              $eye_color_id = '';
              //  model Eye color
              if(isset($wp_user['cs_candidate_eyecolor']) && !empty($wp_user['cs_candidate_eyecolor'])){
                 
                $eye_color_id = (isset($this->modelEyeColor[$wp_user['cs_candidate_eyecolor']]))? $this->modelEyeColor[$wp_user['cs_candidate_eyecolor']] : '';
                
                //store log file
                $this->storeLog($this->model_log, 'Info',' Model Eye Color');
              }

              $hair_color_id = '';
              //  model Hair color
              if(isset($wp_user['cs_candidate_haircolor']) && !empty($wp_user['cs_candidate_haircolor'])){
                
                $hair_color_id = (isset($this->modelHairColor[$wp_user['cs_candidate_haircolor']]))? $this->modelHairColor[$wp_user['cs_candidate_haircolor']] : '';

                //store log file
                $this->storeLog($this->model_log, 'Info',' Model Hair Color');
              }

              $skin_color_id = '';
              //  model skin color 
              if(isset($wp_user['cs_candidate_skincolor']) && !empty($wp_user['cs_candidate_skincolor'])){
                
                $skin_color_id = (isset($this->modelSkinColor[$wp_user['cs_candidate_skincolor']]))? $this->modelSkinColor[$wp_user['cs_candidate_skincolor']] : '';

                //store log file
                $this->storeLog($this->model_log, 'Info',' Model Skin Color');
              }
            
              $modelProfile->eye_color_id = $eye_color_id;
              $modelProfile->hair_color_id = $hair_color_id;
              $modelProfile->skin_color_id = $skin_color_id;
            }

            $shoes_size_id = (isset($wp_user['cs_candidate_shoes_size']))? $wp_user['cs_candidate_shoes_size'] : 0;


            if($shoes_size_id != 0){
              
              // model category is kids or baby-model
              // if($shoes_size_id != 0 && $is_kid_model == true){
                
              //   $shoes_size_id = array_search((int) $shoes_size_id, $this->shoeSizeKidArr);
              // }

              // // model category is not kid, gender is female.
              // if($shoes_size_id != 0 && $is_kid_model == false && $gender_id == config('constant.gender_female')){
                
              //   $shoes_size_id = array_search((int) $shoes_size_id, $this->shoeSizeWomenArr);
              // }

              // // model category is not kid, gender is male.
              // if($shoes_size_id != 0 && $is_kid_model == false && $gender_id == config('constant.gender_male')){

              //   $shoes_size_id = array_search((int) $shoes_size_id, $this->shoeSizeMenArr);
              // }

              $shoes_size_id = array_search((int) $shoes_size_id, $this->shoeSizeArr);
            }

            // $modelProfile->shoes_size_id = (isset($wp_user['cs_candidate_shoes_size']))? $wp_user['cs_candidate_shoes_size'] : 0;

            $modelProfile->shoes_size_id = (!empty($shoes_size_id)) ? $shoes_size_id : 0;


            if(isset($wp_user['cs_size'])){
              
              if(!empty($wp_user['cs_size'])){
                
                $cs_size = explode('-', $wp_user['cs_size']);

                $modelProfile->chest_id = (isset($cs_size[0]))? $cs_size[0] : '';
                $modelProfile->waist_id = (isset($cs_size[1]))? $cs_size[1] : '';
                $modelProfile->hips_id = (isset($cs_size[2]))? $cs_size[2] : '';
              }

              if(!empty($modelProfile->chest_id)){ 
                $modelProfile->chest_id = array_search((int) $modelProfile->chest_id, $this->chestListArr);
              }

              if(!empty($modelProfile->waist_id)){ 
                $modelProfile->waist_id = array_search((int) $modelProfile->waist_id, $this->waistListArr);
              }

              if(!empty($modelProfile->hips_id)){ 
                $modelProfile->hips_id = array_search((int) $modelProfile->hips_id, $this->hipsListArr);
              }


            }

            // $modelProfile->education = (count($education_arr) > 0 )? json_encode($education_arr) : '';
            // $modelProfile->experience = (count($experiance_arr) > 0 )? json_encode($experiance_arr) : '';
            // $modelProfile->reference = (count($reference_arr) > 0 )? json_encode($reference_arr) : '';
            // $modelProfile->talent = (count($talent_arr) > 0 )? json_encode($talent_arr) : '';


            $modelProfile->facebook   = (isset($wp_user['cs_facebook']))? $wp_user['cs_facebook'] : '';
            $modelProfile->twitter = (isset($wp_user['cs_twitter']))? $wp_user['cs_twitter'] : '';
            $modelProfile->google_plus = (isset($wp_user['cs_google_plus']))? $wp_user['cs_google_plus'] : '';
            $modelProfile->linkedin = (isset($wp_user['cs_linkedin']))? $wp_user['cs_linkedin'] : '';

            if(isset($wp_user['cs_port_list_array']) && !empty($wp_user['cs_port_list_array'])){
              if(is_array($wp_user['cs_port_list_array']) && count($wp_user['cs_port_list_array']) > 0){
                  $modelProfile->wp_cs_port_list = json_encode((Object)array_unique($wp_user['cs_port_list_array']));
              }
            }

            $modelProfile->wp_cs_transaction_id = (isset($wp_user['_cs_transaction_id']))? $wp_user['_cs_transaction_id'] : '';
            $modelProfile->wp_terms_condition_check = (isset($wp_user['_terms_condition_check']))? $wp_user['_terms_condition_check'] : '';

            $modelProfile->website_url = (isset($wp_user['website']))? $wp_user['website'] : '';
            $modelProfile->address_line1 = (isset($wp_user['cs_post_comp_address']))? $wp_user['cs_post_comp_address'] : '';
            
            try {

              $access = '_access_partner';
              
              if($user_type == 3){
                $access = '_access';
              }

              if(!empty( $modelObj->hash_code )) {
                $modelProfile->contract_link = config('app.url') .'/'. config('app.locale') .'/contract/?code='. $modelObj->hash_code . '&d=' .strtoupper($modelObj->country_code).'&id=' .$modelObj->username. '&subid='. $access;
              }
              
              $modelProfile->save(); 

              //store log file
              $this->storeLog($this->model_log, 'Info',' Store Model Profile Data');

              $status = [
                  'status' => 'true',
                  'message' => "records updated"
                ];

            } catch(\Exception $e){
              $status = json_encode([
                'status' => 'false',
                'message' => $e->getMessage(),
                'wp_user_id' => $wp_user['user_id']
              ]); 

              //store log file
              $this->storeLog($this->model_log, 'Error', $status); exit();

            }

            /* save user_profile code ends */

            //store log file
            $this->storeLog($this->model_log, 'Info', 'GET USER COVER IMAGE AND SPLIT WITH uploads FOLDER AND STORE THE REMAIN STRING AS PATH');

            /* GET USER PORTFOLIO IMAGES START */
            $protfolio_picture = array();
            if(isset($wp_user['protfolio_picture']) && count($wp_user['protfolio_picture']) > 0 ){
              foreach ($wp_user['protfolio_picture'] as $protfolio_key => $protfolio) {

                if(is_array($protfolio)){

                  foreach ($protfolio as $value_k => $value) {


                    $protfolio_picture[$value_k]['name'] = '';
                   
                    // USER PORTFOLIO TITLE SAVE IN MODELBOOK COLUMN(name)
                    if(isset($wp_user['protfolio_picture_title'][0])){
                      if(is_array($wp_user['protfolio_picture_title'][0])){

                       $port_pic_title =  $wp_user['protfolio_picture_title'][0];
                        $protfolio_picture[$value_k]['name'] = (isset($port_pic_title[$value_k])) ? $port_pic_title[$value_k] : '';
                      }
                    }

                    $protfolio_split = explode($this->wp_upload_folder, $value);
                    
                    if( isset($protfolio_split) && count($protfolio_split) > 0 ){
                      $protfolio_filename = (isset($protfolio_split[1]))? ltrim($protfolio_split[1], "/") : '';
                    }

                    $protfolio_picture[$value_k]['country_code'] = $user_country_code;
                    $protfolio_picture[$value_k]['filename'] =  $protfolio_filename;
                    $protfolio_picture[$value_k]['user_id'] = $modelObj->id;
                    $protfolio_picture[$value_k]['created_at'] = date('Y-m-d H:i:s');

                    $protfolio_picture[$value_k]['active'] = 1;
                  }
                }
              }
            }

            // Remove images and update with new
            if($user_type == 3){
              
              $userBook = ModelBook::withoutGlobalScopes([ActiveScope::class])->where('user_id', $modelObj->id)->delete();
              
              try {
                ModelBook::insert($protfolio_picture);
              } catch(\Exception $e){
                //store log file
                $this->storeLog($this->model_log, 'Error', $e->getMessage());
              }

            //store log file
            $this->storeLog($this->model_log, 'Info', 'STORE MODEL BOOK IMAGES');

            } else {

              $userBook = Albem::withoutGlobalScopes([ActiveScope::class])->where('user_id', $modelObj->id)->delete();
              
              try {
                Albem::insert($protfolio_picture);
              } catch(\Exception $e){
                //store log file
                $this->storeLog($this->model_log, 'Error', $e->getMessage());
              }

              //store log file
              $this->storeLog($this->model_log, 'Info', 'STORE ALBUM IMAGES');
            }
            /* GET USER PORTFOLIO IMAGES END*/

            //store log file
            $this->storeLog($this->model_log, 'Info', 'GET USER PORTFOLIO IMAGES AND STORE END');

            /* GET USER SEDCARD IMAGES START */
            if($user_type == 3){
              if( isset($wp_user['sedcard_picture']) && !empty($wp_user['sedcard_picture'])){
                //store log file
                $this->storeLog($this->model_log, 'Info', 'GET MODEL SEDCARD IMAGES');
                $this->storeLog($this->model_log, 'Info', json_encode($wp_user['sedcard_picture']));
                
                $this->storeModelSedcard($wp_user['sedcard_picture'],  $modelObj->id, $user_country_code);
              }
            }
            /* GET USER SEDCARD IMAGES START */


            /* GET USER EDUCATION AND CONVERT INTO JSON ARRAY */
            $education_arr = array();
            if( isset($wp_user['cs_edu_list_array']) && !empty($wp_user['cs_edu_list_array']) ){
              
              foreach ($wp_user['cs_edu_list_array'] as $key => $value) {
                
                $education_title = $education_from = $education_to = $education_institute = $education_description = "";

                $education_arr[$key]['wp_edcuation_id'] = $value;

                if(isset($wp_user['cs_edu_title_array']) && !empty($wp_user['cs_edu_title_array'])){
                  $education_title = isset($wp_user['cs_edu_title_array'][$key])? $wp_user['cs_edu_title_array'][$key] : '';
                }

                if(isset($wp_user['cs_edu_to_date_array']) && !empty($wp_user['cs_edu_to_date_array'])){
                  $education_to = isset($wp_user['cs_edu_to_date_array'][$key])? $wp_user['cs_edu_to_date_array'][$key] : '';
                  
                  if(!empty($education_to)){
                    $date = Carbon::createFromFormat($this->dateFormat, $education_to);
                    $education_to = $date->format('Y-m-d');
                  }
                }

                if(isset($wp_user['cs_edu_from_date_array']) && !empty($wp_user['cs_edu_from_date_array'])){
                  $education_from = isset($wp_user['cs_edu_from_date_array'][$key])? $wp_user['cs_edu_from_date_array'][$key] : '';

                  if(!empty($education_from)){
                    $date = Carbon::createFromFormat($this->dateFormat, $education_from);
                    $education_from = $date->format('Y-m-d');
                  }
                   
                }

                if(isset($wp_user['cs_edu_institute_array']) && !empty($wp_user['cs_edu_institute_array'])){
                  $education_institute = isset($wp_user['cs_edu_institute_array'][$key])? $wp_user['cs_edu_institute_array'][$key] : '';
                }

                if(isset($wp_user['cs_edu_desc_array']) && !empty($wp_user['cs_edu_desc_array'])){
                  $education_description = isset($wp_user['cs_edu_desc_array'][$key])? $wp_user['cs_edu_desc_array'][$key] : '';
                }

                $education_arr[$key]['user_id'] = $modelObj->id;
                $education_arr[$key]['title'] = $education_title;
                $education_arr[$key]['from_date'] = $education_from;
                $education_arr[$key]['to_date'] = $education_to;
                $education_arr[$key]['institute'] = $education_institute;
                $education_arr[$key]['description'] = $education_description;
                $education_arr[$key]['created_at'] = date('Y-m-d H:i:s');

              }
            }

            //store user education 
            if(isset($education_arr) && count($education_arr) > 0 ){
              
              /*foreach ($education_arr as $key => $value) {
                  $educationObj = UserEducations::where('wp_edcuation_id', $value['wp_edcuation_id'])->first();
                  
                  if(!empty($educationObj) ){
                    $educationObj->user_id = $value['user_id'];
                    $educationObj->title = $value['title'];
                    $educationObj->from_date = $value['from_date'];
                    $educationObj->to_date = $value['to_date'];
                    $educationObj->institute = $value['institute'];
                    $educationObj->description = $value['description'];
                    $educationObj->wp_edcuation_id = $value['wp_edcuation_id'];

                    try {
                      $educationObj->save();
                      unset($education_arr[$key]);
                      //store log file
                      $this->storeLog($this->model_log, 'Info', 'Update user eduction => '.$value['wp_edcuation_id']);
                    } catch(\Exception $e){
                      //store log file
                      $this->storeLog($this->model_log, 'Error', $e->getMessage());
                    }
                  }
              }*/

              // Insert new records
              if( isset($education_arr) && count($education_arr) ){
                  try {
                    UserEducations::insert($education_arr);
                    $this->storeLog($this->model_log, 'Info', 'Insert new user eduction');
                  } catch(\Exception $e){
                    //store log file
                    $this->storeLog($this->model_log, 'Error', $e->getMessage());
                  }
              }
            }

            /* GET USER EXPERIANCE AND CONVERT INTO JSON ARRAY */
            $experiance_arr = array();
            if( isset($wp_user['cs_exp_list_array']) && !empty($wp_user['cs_exp_list_array']) ){

              foreach ($wp_user['cs_exp_list_array'] as $key => $value) {
                
                $experiance_title = $experiance_from = $experiance_to = $experiance_up_to_date = $experiance_company = $experiance_description = '';

                
                $experiance_arr[$key]['wp_experiance_id'] = $value;

                if(isset($wp_user['cs_exp_title_array']) && !empty($wp_user['cs_exp_title_array'])){
                  $experiance_title = isset($wp_user['cs_exp_title_array'][$key])? $wp_user['cs_exp_title_array'][$key] : '';
                }

                if(isset($wp_user['cs_exp_from_date_array']) && !empty($wp_user['cs_exp_from_date_array'])){
                  $experiance_from = isset($wp_user['cs_exp_from_date_array'][$key])? $wp_user['cs_exp_from_date_array'][$key] : '';

                  if(!empty($experiance_from)){
                    $date = Carbon::createFromFormat($this->dateFormat, $experiance_from);
                    $experiance_from = $date->format('Y-m-d');
                  }

                }

                if(isset($wp_user['cs_exp_to_date_array']) && !empty($wp_user['cs_exp_to_date_array'])){
                  $experiance_to = isset($wp_user['cs_exp_to_date_array'][$key])? $wp_user['cs_exp_to_date_array'][$key] : '';

                  if(!empty($experiance_to)){
                    
                    $date = Carbon::createFromFormat($this->dateFormat, $experiance_to);
                    $experiance_to = $date->format('Y-m-d');
                  }
                }

                if(isset($wp_user['cs_exp_to_present_array']) && !empty($wp_user['cs_exp_to_present_array'])){
                  $experiance_up_to_date = 0;

                  if(isset($wp_user['cs_exp_to_present_array'][$key]) && $wp_user['cs_exp_to_present_array'][$key] === 'on'){
                      $experiance_up_to_date = 1;
                  }
                }

                if(isset($wp_user['cs_exp_company_array']) && !empty($wp_user['cs_exp_company_array'])){
                  $experiance_company = isset($wp_user['cs_exp_company_array'][$key])? $wp_user['cs_exp_company_array'][$key] : '';
                }

                if(isset($wp_user['cs_exp_desc_array']) && !empty($wp_user['cs_exp_desc_array'])){
                  $experiance_description = isset($wp_user['cs_exp_desc_array'][$key])? $wp_user['cs_exp_desc_array'][$key] : '';
                }

                $experiance_arr[$key]['user_id'] = $modelObj->id;
                $experiance_arr[$key]['title'] = $experiance_title;
                $experiance_arr[$key]['from_date'] = $experiance_from;
                $experiance_arr[$key]['to_date'] = $experiance_to;
                $experiance_arr[$key]['up_to_date'] = $experiance_up_to_date;
                $experiance_arr[$key]['company'] = $experiance_company;
                $experiance_arr[$key]['description'] = $experiance_description;
                $experiance_arr[$key]['created_at'] = date('Y-m-d H:i:s');
              }
            }

            //store user experiance 
            if(isset($experiance_arr) && count($experiance_arr) > 0 ){
              
              foreach ($experiance_arr as $key => $value) {
                  $experianceObj = UserExperiences::where('wp_experiance_id', $value['wp_experiance_id'])->first();
                  
                  if(!empty($experianceObj) ){
                    $experianceObj->user_id = $value['user_id'];
                    $experianceObj->title = $value['title'];
                    $experianceObj->from_date = $value['from_date'];
                    $experianceObj->to_date = $value['to_date'];
                    $experianceObj->up_to_date = $value['up_to_date'];
                    $experianceObj->company = $value['company'];
                    $experianceObj->description = $value['description'];
                    $experianceObj->wp_experiance_id = $value['wp_experiance_id'];

                    try {
                      $experianceObj->save();
                      unset($experiance_arr[$key]);
                      //store log file
                      $this->storeLog($this->model_log, 'Info', 'Update user experiance => '.$value['wp_experiance_id']);
                    } catch(\Exception $e){
                      //store log file
                      $this->storeLog($this->model_log, 'Error', $e->getMessage());
                    }
                  }
              }

              // Insert new records
              if( isset($experiance_arr) && count($experiance_arr) > 0 ){
                  try {
                    UserExperiences::insert($experiance_arr);
                    $this->storeLog($this->model_log, 'Info', 'Insert new user experiance');
                  } catch(\Exception $e){
                    //store log file
                    $this->storeLog($this->model_log, 'Error', $e->getMessage());
                  }
              }
            }

            /* GET USER REFERENCE AND CONVERT INTO JSON ARRAY */
            $reference_arr = array();
            if( isset($wp_user['cs_award_list_array']) && !empty($wp_user['cs_award_list_array']) ){

              foreach ($wp_user['cs_award_list_array'] as $key => $value) {
                
                $reference_title = $reference_date = $reference_description = '';

                
                $reference_arr[$key]['wp_reference_id'] = $value;

                if(isset($wp_user['cs_award_name_array']) && !empty($wp_user['cs_award_name_array'])){
                  $reference_title = isset($wp_user['cs_award_name_array'][$key])? $wp_user['cs_award_name_array'][$key] : '';
                }

                if(isset($wp_user['cs_award_year_array']) && !empty($wp_user['cs_award_year_array'])){
                  $reference_date = isset($wp_user['cs_award_year_array'][$key])? $wp_user['cs_award_year_array'][$key] : '';

                  if(!empty($reference_date)){
                    $reference_date_arr = explode(' ', $reference_date);
                    $date = Carbon::createFromFormat($this->dateFormat, $reference_date_arr[0]);
                    $reference_date = $date->format('Y-m-d');
                  }
                }

                if(isset($wp_user['cs_award_description_array']) && !empty($wp_user['cs_award_description_array'])){
                  $reference_description = isset($wp_user['cs_award_description_array'][$key])? $wp_user['cs_award_description_array'][$key] : '';
                }

                $reference_arr[$key]['user_id'] = $modelObj->id;
                $reference_arr[$key]['title'] = $reference_title;
                $reference_arr[$key]['date'] = $reference_date;
                $reference_arr[$key]['description'] = $reference_description;
                $reference_arr[$key]['created_at'] = date('Y-m-d H:i:s');
              }
            }

            //store user references 
            if(isset($reference_arr) && count($reference_arr) > 0 ){
              
              foreach ($reference_arr as $key => $value) {
                  $referenceObj = UserReferences::where('wp_reference_id', $value['wp_reference_id'])->first();
                  
                  if(!empty($referenceObj) ){
                    $referenceObj->user_id = $value['user_id'];
                    $referenceObj->title = $value['title'];
                    $referenceObj->date = $value['date'];
                    $referenceObj->description = $value['description'];
                    $referenceObj->wp_reference_id = $value['wp_reference_id'];

                    try {
                      $referenceObj->save();
                      unset($reference_arr[$key]);
                      //store log file
                      $this->storeLog($this->model_log, 'Info', 'Update user references => '.$value['wp_reference_id']);
                    } catch(\Exception $e){
                      //store log file
                      $this->storeLog($this->model_log, 'Error', $e->getMessage());
                    }
                  }
              }

              // Insert new records
              if( isset($reference_arr) && count($reference_arr) > 0){
                  try {
                    UserReferences::insert($reference_arr);
                    $this->storeLog($this->model_log, 'Info', 'Insert new user references');
                  } catch(\Exception $e){
                    //store log file
                    $this->storeLog($this->model_log, 'Error', $e->getMessage());
                  }
              }
            }

            /* GET USER TALENT AND CONVERT INTO JSON ARRAY */
            $talent_arr = array();

            if( isset($wp_user['cs_skills_list_array']) && !empty($wp_user['cs_skills_list_array']) ){

              foreach ($wp_user['cs_skills_list_array'] as $key => $value) {
                
                $telent_title = $telent_date = $telent_proportion = '';

                
                $talent_arr[$key]['wp_talent_id'] = $value;

                if(isset($wp_user['cs_skill_title_array']) && !empty($wp_user['cs_skill_title_array'])){
                  $telent_title = isset($wp_user['cs_skill_title_array'][$key])? $wp_user['cs_skill_title_array'][$key] : '';
                }

                if(isset($wp_user['cs_skill_percentage_array']) && !empty($wp_user['cs_skill_percentage_array'])){
                  $telent_proportion = isset($wp_user['cs_skill_percentage_array'][$key])? $wp_user['cs_skill_percentage_array'][$key] : '';
                }

                $talent_arr[$key]['user_id'] = $modelObj->id;
                $talent_arr[$key]['title'] = $telent_title;
                $talent_arr[$key]['proportion'] = $telent_proportion;
                $talent_arr[$key]['created_at'] = date('Y-m-d H:i:s');
              }
            }

            //store user talents 
            if(isset($talent_arr) && count($talent_arr) > 0 ){
              
              foreach ($talent_arr as $key => $value) {
                  $talentObj = UserTalents::where('wp_talent_id', $value['wp_talent_id'])->first();
                  
                  if(!empty($talentObj) ){
                    $talentObj->user_id = $value['user_id'];
                    $talentObj->title = $value['title'];
                    $talentObj->proportion = $value['proportion'];
                    $talentObj->wp_talent_id = $value['wp_talent_id'];

                    try {
                      $talentObj->save();
                      unset($talent_arr[$key]);
                      //store log file
                      $this->storeLog($this->model_log, 'Info', 'Update user talents => '.$value['wp_talent_id']);
                    } catch(\Exception $e){
                      //store log file
                      $this->storeLog($this->model_log, 'Error', $e->getMessage());
                    }
                  }
              }

              // Insert new records
              if( isset($talent_arr) && count($talent_arr) > 0){
                  try {
                    UserTalents::insert($talent_arr);
                    $this->storeLog($this->model_log, 'Info', 'Insert new user talents');
                  } catch(\Exception $e){
                    //store log file
                    $this->storeLog($this->model_log, 'Error', $e->getMessage());
                  }
              }
            }

            

            $cv_title = "";
            if(isset($wp_user['cs_cover_letter']) && !empty($wp_user['cs_cover_letter'])){
                $cv_title = $wp_user['cs_cover_letter'];
            }

            $cs_candidate_cv = "";
            if( isset($wp_user['cs_candidate_cv']) && !empty($wp_user['cs_candidate_cv']) ){
                
                $cv_split = explode($this->wp_upload_folder, $wp_user['cs_candidate_cv']);

                if( isset($cv_split) && count($cv_split) > 0 ){
                  $cs_candidate_cv = (isset($cv_split[1]))? ltrim($cv_split[1], '/') : '';
                }

                $resume = Resume::where('user_id', $modelObj->id)->first();
                
                if( empty($resume) ){
                  $resume = "";
                  $resume = new Resume();
                }

                $resume->preventAttrSet = true;
                $resume->country_code = $user_country_code;
                $resume->user_id = $modelObj->id;
                $resume->name = $cv_title;
                $resume->filename = $cs_candidate_cv;
                $resume->active = 1;
                

                try {
                  $resume->save();
                } catch(\Exception $e){
                  //store log file
                  $this->storeLog($this->model_log, 'Error', $e->getMessage());
                }
            }


            
            $company_name = '';
            if( isset($wp_user['company_name']) && !empty($wp_user['company_name']) ){
              //store log file
              $this->storeLog($this->model_log, 'Info', "Store Company Name");

              $company_name  = $wp_user['company_name'];
              $wp_user['company_name'] = trim($wp_user['company_name']);
              $companyObj = Company::where('user_id', $modelObj->id)->where('name', $wp_user['company_name'])->first();

              if( empty($companyObj) ){
                $companyObj = new Company();
                $companyObj->user_id = $modelObj->id;
                $companyObj->name = $wp_user['company_name'];

               try {
                  $companyObj->save();
                  //store log file
                  $this->storeLog($this->model_log, 'Info', "Create new company successfully");
                } catch(\Exception $e){
                  //store log file
                  $this->storeLog($this->model_log, 'Error', $e->getMessage());
                }
              }
            }

            
            // save applied jobs
            $this->saveUserJobsApplied($wp_user, $modelObj->id);

            // save favourites jobs
            $this->saveFavouriteJobs($wp_user, $modelObj->id);

            // favourites users, Only partner
            if($user_type == 2){
              $this->saveFavouriteUsers($wp_user, $modelObj->id);
            }
            

            // if( !$modelProfile->id){
            //     $status = [
            //       'status' => 'false',
            //       'message' => "records not updated"
            //     ];
            //     //store log file
            //     $this->storeLog($this->model_log, 'Error', json_encode($status));

            // } else {
            //     $status = [
            //       'status' => 'true',
            //       'message' => "records updated"
            //     ];

            //     //store log file
            //     $this->storeLog($this->model_log, 'Info', json_encode($status));
            // }

            return $status;

        } else {
          $status = [
            'status' => 'false',
            'message' => "unable to stroe records"
          ];
          //store log file
          $this->storeLog($this->model_log, 'Info', json_encode($status));
          return $status;
        }

      }

    }

    public function getJobCatgeories($request){

      $req = $request->all();

      if( isset($req['lang']) && !empty($req['lang']) ){

          $req = array('action' => 'jobs_category' , 'lang' => $req['lang']);

          $res = $this->getCurlRequest($this->url, $req);

          $codeObj = $this->getLanguageCode($req['lang']);

          if( isset($res) && $res['status'] == 1 && !empty($res['response'])){

            $result = json_decode($res['response'], true);

            if( count($result) > 0 ){

              foreach ($result as $key => $category) {
                  
                  $categoryObj = Category::withoutGlobalScopes([ActiveScope::class])->where('wp_term_id', $category['term_id'])->first();

                  if(!$categoryObj){
                    $categoryObj = new Category();
                  }

                  $translation_of = 0;
                  if( $category['translation_of'] != 0 && !is_array($category['translation_of'])){
                      $translation_of = $category['translation_of'];
                  }

                  $categoryObj->translation_lang = $codeObj['language_code'];
                  // $categoryObj->country_code = $codeObj['country_code'];
                  $categoryObj->wp_term_id = $category['term_id'];
                  $categoryObj->wp_translation_of = $translation_of;
                  $categoryObj->wp_parent_id = $category['parent'];
                  $categoryObj->name = $category['name'];
                  $categoryObj->slug = $category['slug'];
                  $categoryObj->description = $category['description'];
                  $categoryObj->active = 1;

                  try{
                    $categoryObj->save();
                  }catch(\Exception $e){
                    echo $e->getMessage();
                    exit();
                  }

                  if(!$categoryObj->id){

                    $status = [
                      'status' => 'error',
                      'term_id' => $category['term_id'],
                      'lang' => $codeObj['wp_language'],
                      'message' => "Some Error occure while insert records"
                    ];
                    
                    echo json_encode($status); exit();
                  }
              }
              echo json_encode(['status' => 'success', 'message' => 'records inserted successfully']); 
              //update wp_id with laravel id
              $this->setJobCategory();
              exit();

            } else {
              echo json_encode(['status' => 'error', 'message' => 'result not found']); exit();
            }

          } else { 
              echo json_encode([
                'status' => 'error',
                'message' => "SSL certificate problem: unable to get local issuer certificate"
              ]);
              exit();
          }

      } else { 
        echo json_encode(['status' => 'error', 'message' => 'Language Code is required']);
        exit();
      }
    }


    public function setJobCategory(){
        $categoryList = Category::withoutGlobalScopes([ActiveScope::class])->whereNotNull('wp_term_id')->get();
        
        if( isset($categoryList) && count($categoryList) > 0 ){

          foreach ($categoryList as $key => $category) {

            $wp_translation_of = $category->wp_translation_of;

            if( isset($wp_translation_of) && !empty($wp_translation_of) ){

                $categoryObj = Category::withoutGlobalScopes([ActiveScope::class])->where('wp_term_id', $wp_translation_of)->first();

                if( isset($categoryObj) && !empty($categoryObj) ){
                  $category->translation_of = $categoryObj->id;
                  
                  try{
                    $category->save();
                  }catch(\Exception $e){
                    echo json_encode(['status' => 'error','translation_of' => $wp_translation_of, 'id' => $categoryObj->id ,'message' => $e->getMessage()]); exit();
                  }

                }
            }
          }
          echo json_encode(['status' => 'true', 'message' => "Records updated successfully"]); exit();
        } else {
          echo json_encode(['status' => 'error', 'message' => "Records not found"]); exit();
        }
    }

  
    public function getModelCategories($request){

      $data = array();
      $catupdateArr = array();
      $catInsertArr = array();
      $is_update_parent = false;

      if(count($request->all()) > 0){

        if(isset($request['lang']) && !empty($request['lang'])){
          
          // get all country language detail
          $country_language = CountryLanguage::where('wp_language', $request['lang'])->first();
          
          if(!empty($country_language)){

            // call api Model category
            $req = array('action' => 'model_category' , 'lang' => $country_language->wp_language);
            $res = $this->getCurlRequest($this->url, $req);

            if($res['status'] == true){

              $data = json_decode($res['response'], true);

              if(count($data) > 0){
                
                $i = 0;

                // get all Model category records
                $getAllModelCategory = ModelCategory::select('id','translation_lang','translation_of','wp_category_id','wp_translation_of')->get()->toArray();
                
                foreach($data as $val) {
                  
                  $key_exist = false;
                  
                  if(count($getAllModelCategory) > 0){
                    // check record exist in db
                    $key_exist = array_search($val['term_id'], array_column($getAllModelCategory , 'wp_category_id'));
                  }

                  $wp_translation_of = 0;
                  if($val['translation_of'] !== 0){
                    $wp_translation_of = $val['translation_of'];
                  }
                   
                  // if record is exist, update category record
                  if($key_exist !== false){
                    
                    $is_update_parent = true;

                    // update Model Category
                    // $catUpdateArr["country_code"] = strtoupper($country_language->country_code);
                    $catUpdateArr["translation_lang"] = $country_language->language_code;
                    $catUpdateArr["wp_category_id"] = $val['term_id'];
                    $catUpdateArr["wp_translation_of"] = $wp_translation_of;
                    // $catUpdateArr["wp_parent_id"] = $val['parent'];
                    $catUpdateArr["name"] = $val['name'];
                    $catUpdateArr["slug"] = $val['slug'];
                    $catUpdateArr["description"] = $val['description'];
                    
                    $catUpdateArr["is_baby_model"] = 0;

                    if( isset($catUpdateArr["slug"]) && !empty($catUpdateArr["slug"]) ){
                      $catUpdateArr["is_baby_model"] = (in_array(strtolower($catUpdateArr["slug"]), $this->modelCatSlug))? 1 : 0;
                    }

                    try{
                      // update if Model Category already exist
                      $update = ModelCategory::where('wp_category_id', $val['term_id'])->update($catUpdateArr);
                    }
                    catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'post_id' => $val['term_id'],
                        'message' => 'Not updated'
                      ]); exit();
                    }
                  }
                  else{
                    $is_update_parent = true;
                    // Model Category Insert Array
                    // $catInsertArr[$i]["country_code"] = strtoupper($country_language->country_code);
                    $catInsertArr[$i]["translation_lang"] = $country_language->language_code;
                    $catInsertArr[$i]["wp_category_id"] = $val['term_id'];
                    $catInsertArr[$i]["wp_translation_of"] = $wp_translation_of;
                    // $catInsertArr[$i]["wp_parent_id"] = $val['parent'];
                    $catInsertArr[$i]["name"] = $val['name'];
                    $catInsertArr[$i]["slug"] = $val['slug'];
                    $catInsertArr[$i]["description"] = $val['description'];

                    $catInsertArr[$i]["is_baby_model"] = 0;
                    
                    if( isset($catInsertArr[$i]["slug"]) && !empty($catInsertArr[$i]["slug"]) ){
                      $catInsertArr[$i]["is_baby_model"] = (in_array(strtolower($catInsertArr[$i]["slug"]), $this->modelCatSlug))? 1 : 0;
                    }
                    
                    $i++;
                  }
                }
                // insert new record
                if(!empty($catInsertArr) && count($catInsertArr) > 0){

                   
                  try{
                     
                    $catInfo = ModelCategory::insert($catInsertArr);

                    if($catInfo){

                      if($catInfo > 0 ){

                        echo json_encode([
                          'status' => 'success',
                          'total' => count($catInsertArr),
                          'message' => 'insert Successfully'
                        ]);
                      }
                    }
                  }
                  catch(\Exception $e){
                    
                    echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
                    exit();
                  }
                }
                if($is_update_parent == true){
                  try{
                    
                    // update translation_of id
                    $catParentUpdate = DB::table('model_categories as m1')
                                          ->Join('model_categories as m2', 'm1.wp_category_id', '=', 'm2.wp_translation_of')
                                          ->where('m2.wp_translation_of', '!=' , 0)
                                          ->update(['m2.translation_of' => DB::raw('m1.id')]);
                    echo json_encode([
                        'status' => 'success',
                        'message' => "Update Successfully"
                      ]);
                  } catch(\Exception $e){
                    echo json_encode([
                        'status' => 'false',
                        'message' => $e->getMessage()
                      ]);
                    exit();
                  }
                }
              }else{
                echo json_encode([
                  'status' => 'true',
                  'message' => "No record found!"
                ]);
                exit();
              }
            }else{
              echo json_encode([
                  'status' => 'false',
                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                ]);
              exit();
            }
          }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }

    public function getPartnerCategories($request){

      $data = array();
      $catupdateArr = array();
      $catInsertArr = array();
      $is_update_parent = false;

      if(count($request->all()) > 0){

        if(isset($request['lang']) && !empty($request['lang'])){

          // get all country language detail
          $country_language = CountryLanguage::where('wp_language', $request['lang'])->first();
          
          if(!empty($country_language)){

            // call api Partner category
            $req = array('action' => 'partner_category' , 'lang' => $country_language->wp_language);
            $res = $this->getCurlRequest($this->url, $req);

            if($res['status'] == true){

              $data = json_decode($res['response'], true);

              if(count($data) > 0){

                $i = 0;

                // get all Partner category records
                $getAllPartnerCategory = Branch::select('id','translation_lang','translation_of','wp_category_id','wp_translation_of')->get()->toArray();

                foreach($data as $val) {
                  
                  $key_exist = false;
                  // check record exist in db
                  if(count($getAllPartnerCategory) > 0){
                    $key_exist = array_search($val['term_id'], array_column($getAllPartnerCategory , 'wp_category_id'));
                  }

                  $wp_translation_of = 0;
                  if($val['translation_of'] !== 0){
                    $wp_translation_of = $val['translation_of'];
                  }

                  // if record is exist, update category record
                  if($key_exist !== false){
                    
                    $is_update_parent = true;

                    // update Model Category
                    // $catUpdateArr["country_code"] = strtoupper($country_language->country_code);
                    $catUpdateArr["translation_lang"] = $country_language->language_code;
                    $catUpdateArr["wp_category_id"] = $val['term_id'];
                    $catUpdateArr["wp_translation_of"] = $wp_translation_of;
                    // $catUpdateArr["wp_parent_id"] = $val['parent'];
                    $catUpdateArr["name"] = $val['name'];
                    $catUpdateArr["slug"] = $val['slug'];
                    $catUpdateArr["description"] = $val['description'];
                    
                    try{
                      // update if Partner Category already exist
                      $update = Branch::where('wp_category_id', $val['term_id'])->update($catUpdateArr);
                    }
                    catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'post_id' => $val['term_id'],
                        'message' => 'Not updated'
                      ]); exit();
                    }
                  }
                  else{
                    $is_update_parent = true;
                    // Model Category Insert Array
                    // $catInsertArr[$i]["country_code"] = strtoupper($country_language->country_code);
                    $catInsertArr[$i]["translation_lang"] = $country_language->language_code;
                    $catInsertArr[$i]["wp_category_id"] = $val['term_id'];
                    $catInsertArr[$i]["wp_translation_of"] = $wp_translation_of;
                    // $catInsertArr[$i]["wp_parent_id"] = $val['parent'];
                    $catInsertArr[$i]["name"] = $val['name'];
                    $catInsertArr[$i]["slug"] = $val['slug'];
                    $catInsertArr[$i]["description"] = $val['description'];
                    $i++;
                  }
                }
                // insert new record
                if(!empty($catInsertArr) && count($catInsertArr) > 0){
                  try{
                    $catInfo = Branch::insert($catInsertArr);

                    if($catInfo){

                      if($catInfo > 0 ){

                        echo json_encode([
                          'status' => 'success',
                          'total' => count($catInsertArr),
                          'message' => 'insert Successfully'
                        ]);
                      }
                    }
                  }
                  catch(\Exception $e){
                    
                    echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
                    exit();
                  }
                }

                if($is_update_parent == true){
                  try{
                    
                    // update translation_of id
                    $catParentUpdate = DB::table('branches as b1')
                                            ->Join('branches as b2', 'b1.wp_category_id', '=', 'b2.wp_translation_of')
                                            ->where('b2.wp_translation_of', '!=' , 0)
                                            ->update(['b2.translation_of' => DB::raw('b1.id')]); 
                      echo json_encode([
                        'status' => 'success',
                        'message' => "Update Successfully"
                      ]);
                  } catch(\Exception $e){
                    echo json_encode([
                        'status' => 'false',
                        'message' => $e->getMessage()
                      ]);
                    exit();
                  }
                }
              }else{
                echo json_encode([
                  'status' => 'true',
                  'message' => "No record found!"
                ]);
                exit();
              }
            }else{
              echo json_encode([
                  'status' => 'false',
                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                ]);
              exit();
            }
          }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }


    public function getPackages($request){

      $req = array('action' => 'get_packages');
      $res = $this->getCurlRequest($this->url, $req);

      if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
         
         $result = json_decode($res['response'], true);

          if( count($result) > 0 ){
            
            $user_type_id = 0;

            foreach ($result as $key => $packageArr) {
  
              $user_type_id = ($this->user_type[$key])? $this->user_type[$key] : 0;

              if(is_array($packageArr) && count($packageArr) > 0 ){

                  foreach ($packageArr as $pkey => $package) {
                    
                    
                    /* Model packages */ 
                    if( isset($package['package_id']) && !empty($package['package_id']) ){

                      $packageObj = Package::getWPackageFromId($package['package_id']);

                        if(empty($packageObj)){
                          $packageObj = new Package();
                        } 

                          $packageObj->wp_package_id = ($package['package_id'])? $package['package_id'] : '';
                          $packageObj->name = ($package['package_title'])? $package['package_title'] : '';
                          $packageObj->translation_lang = ($package['package_country'])? strtoupper($package['package_country']) : '';
                          $packageObj->short_name = ($package['package_title_internal'])? $package['package_title_internal'] : '';
                          $packageObj->user_type_id = $user_type_id;

                          
                          $packageObj->price = ($package['package_price'])? $package['package_price'] : '';

                          $packageObj->price_dummy = ($package['package_price_dummy'])? $package['package_price_dummy'] : '';

                          $packageObj->currency_code = ($package['package_country_cur'])? $package['package_country_cur'] : '';
                          
                          $packageObj->wp_package_country = ($package['package_country'])? strtoupper($package['package_country']) : '';

                          $packageObj->duration = ($package['package_duration'])? $package['package_duration'] : '';
                          $packageObj->duration_period = ($package['package_duration_period'])? $package['package_duration_period'] : '';

                          $packageObj->description = ($package['package_description'])? $package['package_description'] : '';
                          $packageObj->package_uid = ($package['package_uid'])? $package['package_uid'] : '';

                          $packageObj->package_type = ($package['package_type'])? $package['package_type'] : '';
                          
                          $packageObj->package_listings = ($package['package_listings'])? $package['package_listings'] : '';
                          
                          $packageObj->package_cvs = ($package['package_cvs'])? $package['package_cvs'] : '';

                          $packageObj->package_submission_limit = ($package['package_submission_limit'])? $package['package_submission_limit'] : '';

                          $packageObj->cs_list_dur = ($package['cs_list_dur'])? $package['cs_list_dur'] : '';
                          
                          $packageObj->package_feature = ($package['package_feature'])? $package['package_feature'] : '';

                          $packageObj->active = 1;

                          $packageObj->country_code = (isset($this->country_language[$package['package_country']]))? $this->country_language[$package['package_country']] : '';
                          


                          try{
                            $packageObj->save();
                          }catch(\Exception $e){
                            echo $e->getMessage(); exit();
                          }

                          if(!$packageObj->id){

                            $status = [
                              'status' => 'false',
                              'package_id' => $package['package_id'],
                              'message' => "Some Error occure while insert records"
                            ];
                            
                            echo json_encode($status); exit();
                          }
                    }

                    /* Partner packages */ 
                    if(isset($package['cv_pkg_id']) && !empty($package['cv_pkg_id'])){
                     
                      $packageObj = Package::withoutGlobalScopes([ActiveScope::class])->where('wp_package_id', $package['cv_pkg_id'])->first();

                        if(empty($packageObj)){
                          $packageObj = new Package();
                        }

                          $packageObj->wp_package_id = ($package['cv_pkg_id'])? $package['cv_pkg_id'] : '';
                          $packageObj->name = ($package['cv_pkg_title'])? $package['cv_pkg_title'] : '';
                          $packageObj->translation_lang = ($package['cv_pkg_country'])? strtoupper($package['cv_pkg_country']) : '';
                          $packageObj->short_name = ($package['cv_pkg_title'])? $package['cv_pkg_title'] : '';
                          $packageObj->user_type_id = $user_type_id;
                          $packageObj->price = ($package['cv_pkg_price'])? $package['cv_pkg_price'] : '';
                          $packageObj->currency_code = ($package['cv_pkg_country_cur'])? $package['cv_pkg_country_cur'] : '';

                          $packageObj->wp_package_country = ($package['cv_pkg_country'])? strtoupper($package['cv_pkg_country']) : '';

                          $packageObj->duration = ($package['cv_pkg_dur'])? $package['cv_pkg_dur'] : '';
                          $packageObj->duration_period = ($package['cv_pkg_dur_period'])? $package['cv_pkg_dur_period'] : '';

                          $packageObj->description = ($package['cv_pkg_desc'])? $package['cv_pkg_desc'] : '';

                          $packageObj->package_uid = ($package['cv_pkg_uid'])? $package['cv_pkg_uid'] : '';
                          $packageObj->package_cvs = ($package['cv_pkg_cvs'])? $package['cv_pkg_cvs'] : '';
                          $packageObj->active = 1;
                          $packageObj->country_code = (isset($this->country_language[$package['cv_pkg_country']]))? $this->country_language[$package['cv_pkg_country']] : '';

                          try{
                            $packageObj->save();
                          }catch(\Exception $e){
                            echo $e->getMessage(); exit();
                          }

                          if(!$packageObj->id){

                            $status = [
                              'status' => 'false',
                              'package_id' => $package['cv_pkg_id'],
                              'message' => "Some Error occure while insert records"
                            ];
                            
                            echo json_encode($status); exit();
                          }
                    }
                  }
                   
              } else {
                  $status = ['status' => 'false', 'message' => 'result not found'];
                  echo json_encode($status); exit();
              }
            }
            
            $status = ['status' => 'true', 'message' => 'Packages fetch successfully'];
            echo json_encode($status); exit();

          } else {
            echo json_encode([
                'status' => 'false',
                'message' => "SSL certificate problem: unable to get local issuer certificate"
              ]); exit();
          }

      } else {
          echo json_encode([
            'status' => 'false',
            'message' => "SSL certificate problem: unable to get local issuer certificate"
          ]); exit();
      }
    }


    /* request: wp_category=model_eye_color_category|model_hair_color_category|model_skin_color_category
    */
    public function getModelColorCategory($request){
      
      $data = array();
      $updateArr = array();
      $insertArr = array();
      $transInsertArr = array();
      $status = false;
      $wp_action = '';
      
      $i = 0;
      // echo '<pre>';
      // echo "============ request starts =========";
      // echo "<br>lang: ".$request['lang'];

      if(count($request->all()) > 0){

        // check valid wp_category (wp action call api)
        if(isset($request->wp_category) && !empty($request->wp_category)){
          
          $wp_action = $request->wp_category;
        }
        else{
          echo json_encode([
              'status' => 'false',
              'message' => "Please Enter valid wp_category key and value!"
            ]);
          exit();
        }
         

        if($wp_action == 'model_eye_color_category'){
          $type = 'eye_color';
        }elseif($wp_action == 'model_hair_color_category') {
          $type = 'hair_color';
        }elseif($wp_action == 'model_skin_color_category') {
          $type = 'skin_color';
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "Invalid wp_category key and value!"
            ]);
          exit();
        }

        if(isset($request['lang']) && !empty($request['lang'])){
          
          // get all country language detail
          $country_language = CountryLanguage::where('wp_language', $request['lang'])->first();
          // echo "<br><br>-- country language mapping --";
          // print_r($country_language);
          
          if(!empty($country_language)){
            
            // call api model eye color 
            $req = array('action' => $wp_action , 'lang' => $request['lang']);
            $res = $this->getCurlRequest($this->url, $req);
            // echo "<br><br>-- curl response --";
            // print_r($res['status']);
            
            // check status is true
            if($res['status'] == true){
             
              $data = json_decode($res['response'], true);

              // echo "<br><br>-- curl response data --";
              // print_r($data);
              
              if(count($data) > 0){
                
                // get all valid value 
                $getAllValidValue = ValidValue::where('type', 'like', '%'.$type.'%')->pluck('wp_id', 'id')->toArray();

                // echo "<br><br>-- existing valid value --";
                // print_r($getAllValidValue);

                // get all valid value translation 
                $getAllValidValueTrans = ValidValueTranslation::where('locale', $country_language->language_code )->pluck('id', 'valid_value_id')->toArray();
                // echo "<br><br>-- existing valid value translation --";
                // print_r($getAllValidValueTrans);

                // first api call to parent language en_us
                if(count($getAllValidValue) == 0) {
                  if($request['lang'] !== 'en_us'){
                    echo json_encode([
                        'status' => 'false',
                        'message' => 'please first api call with language en_us'
                      ]); exit();
                  }
                }

                foreach($data as $val) {

                  $wp_translation_of = 0;

                  if(is_array($val['translation_of'])){
                    if(count($val['translation_of']) > 0){
                      $wp_translation_of = @$val['translation_of']['term_id'];
                    }
                  }


                  $key_exist = false;
                  $valid_value_id = 0;

                  if(count($getAllValidValue) > 0){
                    
                    // check record exist in db
                    if($request['lang'] == 'en_us'){
                      // echo "<br>-- search getAllValidValue for term_id: ".$val['term_id'];
                      $key_exist = array_search($val['term_id'] , $getAllValidValue);
                    }else{
                     // echo "<br>-- search getAllValidValue for wp_translation_of : ".$wp_translation_of;
                      // get valid value id
                      $key_exist = array_search($wp_translation_of , $getAllValidValue);
                    }
                  }else{
                    // echo "<br>-- search valid value getAllValidValue for wp_translation_of : ".$wp_translation_of;
                    //  get valid value id
                    $valid_value_id = array_search($wp_translation_of , $getAllValidValue);
                  }

                  // echo "<br><br>--- key_exist: $key_exist --- ";
                  // echo "<br><br>--- valid_value_id: $valid_value_id --- ";

                  // if record is exist, update record
                  if($key_exist !== false){

                    // ValidValueTranslation array update
                    $updateTransArr['value'] = $val['name'];
                    $updateTransArr['slug'] = $val['slug'];

                    try{

                      $validvalueStatus = false;

                      if(count($getAllValidValueTrans) > 0){ 
                        
                        // check record already exist in valid value translation
                        if (array_key_exists($key_exist, $getAllValidValueTrans)) {
                            
                            // update if already exist
                            $updateTranslation = ValidValueTranslation::where('valid_value_id', $key_exist)->where('locale', $country_language->language_code)->update($updateTransArr);
                            $validvalueStatus = true;
                            $status = true;
                            // echo "<br><br>-- update existing valid value translation --";
                            // echo "<br> valid_value_id: ".$key_exist." country_code: ".$country_language->country_code." locale: ".$country_language->language_code;
                            // print_r($updateTransArr);
                        }
                      }
                    }
                    catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'post_id' => $val['term_id'],
                        'message' => 'Not updated'
                      ]); exit();
                    }

                    // valid value trans record not exist insert array
                    if($validvalueStatus == false){
                      
                      // valid_value_translations array
                      // $transInsertArr[$val['term_id']]['country_code'] = $country_language->country_code;
                      $transInsertArr[$val['term_id']]['locale'] = $country_language->language_code;
                      $transInsertArr[$val['term_id']]['value'] = $val['name'];
                      $transInsertArr[$val['term_id']]['slug'] = $val['slug'];
                      $transInsertArr[$val['term_id']]['valid_value_id'] = $key_exist;
                    }
                  }
                  else{
                    
                    // valid_value_translations array
                    // $transInsertArr[$val['term_id']]['country_code'] = $country_language->country_code;
                    $transInsertArr[$val['term_id']]['locale'] = $country_language->language_code;
                    $transInsertArr[$val['term_id']]['value'] = $val['name'];
                    $transInsertArr[$val['term_id']]['slug'] = $val['slug'];
                     
                    // Insert Array in valid value
                    if($request['lang'] == 'en_us'){
                      $insertArr[$i]["wp_id"] = $val['term_id'];
                      $insertArr[$i]["key"] = 'name';
                      $insertArr[$i]["type"] = $type;
                      $i++;
                    }else{

                      $transInsertArr[$val['term_id']]['valid_value_id'] = $valid_value_id;
                    }
                  }
                }//endforeach

                $getNewAllValidValue = array();
                
                // insert new record
                if(!empty($insertArr) && count($insertArr) > 0){
                  
                  try{
                     
                    $insert = 0;

                    if($request['lang'] == 'en_us'){
                      $insert = ValidValue::insert($insertArr);
                      // echo "<br><br>-- insert value values --";
                      // print_r($insertArr);
                      $getNewAllValidValue = ValidValue::pluck('wp_id', 'id')->toArray();
                    }
                    if($insert > 0 ){

                      echo json_encode([
                        'status' => 'success',
                        'total' => count($insertArr),
                        'message' => 'Insert Valid Values Successfully'
                      ]);
                    }
                  }
                  catch(\Exception $e){
                    
                    echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
                    exit();
                  }
                   
                  foreach ($insertArr as $v) { 

                    $key_search = array_search($v['wp_id'], $getNewAllValidValue);
                    
                    if($key_search !== false){ 
                      $transInsertArr[$v['wp_id']]['valid_value_id'] = $key_search;
                    } 
                  }
                }
                
                if(count($transInsertArr) > 0){
                  
                  if(count($getAllValidValueTrans) > 0){
                    
                    foreach ($transInsertArr as $key => $t) {
                      
                      // check valid value already save in db
                      if (!empty($t['valid_value_id']) && array_key_exists($t['valid_value_id'], $getAllValidValueTrans)){
                        unset($transInsertArr[$key]);
                      }
                      if(empty($t['valid_value_id'])){
                        unset($transInsertArr[$key]);
                      }
                    }
                  }
                  
                  if(count($transInsertArr) > 0){
                    
                    try{
                      // check valid value translation save in db
                      $insertTranslation = ValidValueTranslation::insert($transInsertArr);
                      // echo "<br><br>-- insert value values translation --";
                      // print_r($transInsertArr);

                      echo json_encode([
                        'status' => 'success',
                        'total' => count($transInsertArr),
                        'message' => "Insert Valid Value Translations Record Successfully"
                      ]);
                    }catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'message' => $e->getMessage()
                      ]);
                      exit();
                    }
                  }
                }
                if($status == true) {
                  echo json_encode([
                    'status' => 'true',
                    'message' => "Update Successfully"
                  ]);
                  exit();
                }
              }else{
                echo json_encode([
                  'status' => 'true',
                  'message' => "No record found!"
                ]);
                exit();
              }
            }else{
              echo json_encode([
                  'status' => 'false',
                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                ]);
              exit();
            }
          }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "Invalid language code!"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }

    /*
    action: jobs
    page: 1
    post_per_page: 20
    */
    public function getJobs($request){

      $page = '';
      $post_per_page = '';
      $postType = '';

      $insertArr = array();
      $updateArr = array();
      $data = array();

      if(count($request->all()) > 0){
        
        if(isset($request->post_per_page) && !empty($request->post_per_page)){
          
          $post_per_page = $request->post_per_page;
        }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid post_per_page key and value!"
            ]);

          exit();
        }

        if(isset($request->page) && !empty($request->page)){
          
        $page = $request->page;
        
        } else {
          $page = 1;
          // echo json_encode([
          //     'status' => 'false',
          //     'message' => "Invalid page key and value!"
          //   ]);
          // exit();
        }

        // call api model eye color 
        $req = array('action' => $request->action , 'page' => $page, 'post_per_page' => $post_per_page);
        $res = $this->getCurlRequest($this->url, $req);

        $postId_arr = Post::withoutGlobalScopes()->where('wp_post_id', '!=', 0)->pluck('wp_post_id')->toArray();

        $total_records = 0;

        // check status is true
        if($res['status'] == true){
         
          $dataArr = json_decode($res['response'], true);

          if(isset($dataArr['data']) && !empty($dataArr['data'])){
            $data = $dataArr['data'];
          }else{
            echo json_encode([
              'status' => 'false',
              'message' => "No record found!"
            ]);
            exit();
          }

          $total_records = $dataArr['total'];
          $total_pages = 1;

          if( ($total_records > 0) && $post_per_page != ''){
            if($total_records > $post_per_page){
              $total_pages = ceil( ( $total_records/$post_per_page) );
            }
          }


          // echo "<br><br>-- curl response data --";
          // print_r($data);

          
          if(count($data) > 0){

            $i = 0;
            $meta_data = array();
            $gender = 0;

            //get job categories
            $jobCategories = Category::pluck('id', 'wp_term_id')->toArray();
            $modelCategories = ModelCategory::pluck('id', 'wp_category_id')->toArray();
            $partnerCategories = Branch::pluck('id', 'wp_category_id')->toArray();
            $postJobTypeObj = PostType::where('name', 'others')->first()->toArray();
            $CurrencyCode = Country::withoutGlobalScopes()->pluck('currency_code', 'code')->toArray();
            
            // get all existing height 
            $heightArr = UserHeightUnitOptions::pluck('at_unit', 'id')->toArray();
            $this->heightListArr = preg_replace("/cm/", " ", $heightArr);

            // get standard dress size
            $UserDressSizeObj = New UserDressSizeOptions();
            //::whereNotNull('standard_unit')->pluck('standard_unit', 'id')->toArray();

            // get standard shoe size
            $this->shoeSizeArr = UserShoesUnitsOptions::whereNotNull('standard_unit')->pluck('standard_unit', 'id')->toArray();

            $this->wpModelCategory = ModelCategory::pluck('is_baby_model', 'wp_category_id')->toArray();

            $this->wpUserIds = User::pluck('id', 'wp_user_id')->toArray();

            $this->dressSizeKidsArr = $UserDressSizeObj->whereNotNull('at_unit_kids')->pluck('at_unit_kids', 'id')->toArray();

            $this->dressSizeKidsArr = array_map(
                function($str) {
                    return str_replace(' EU', '', $str);
                },
                $this->dressSizeKidsArr
            );

            $this->dressSizeMenArr = $UserDressSizeObj->whereNotNull('at_unit_men')->pluck('at_unit_men', 'id')->toArray();

            $this->dressSizeMenArr = array_map(
                function($str) {
                    return str_replace(' EU', '', $str);
                },
                $this->dressSizeMenArr
            );

            $this->dressSizeWomenArr = $UserDressSizeObj->whereNotNull('at_unit_women')->pluck('at_unit_women', 'id')->toArray();

            $this->dressSizeWomenArr = array_map(
                function($str) {
                    return str_replace(' EU', '', $str);
                },
                $this->dressSizeWomenArr
            );


            if( isset($postJobTypeObj) && !empty($postJobTypeObj) && isset($postJobTypeObj['translation_of']) ){
              $postType = $postJobTypeObj['translation_of'];
            }

            // echo "<pre>jobCategories: ";print_r($jobCategories);
            // echo "<br>";
            // echo "<pre>modelCategories: ";print_r($modelCategories);
            // echo "<br>";
            // echo "<pre>partnerCategories: ";print_r($partnerCategories);
            // echo "<br>";

            for($i = 1; $i <= $total_pages; $i++) { 
               
              if($i != 1){
                // call api for get transaction param (action, page No) 
                  $req = array('action' => $request->action , 'page' => $i, 'post_per_page' => $post_per_page);
                  $res = $this->getCurlRequest($this->url, $req);
              }

              if($res['status'] == true){

                $dataArr = json_decode($res['response'], true);
                $data = $dataArr['data'];

                if( isset($data) && !empty($data) && count($data) > 0 ){
                  
                  $insertArr = array();
                  $is_update = false;
                  $update_count = 0;

                  foreach ($data as $k => $val) {

                    $meta_data = $val['meta_data'];
                    
                    if(isset($meta_data['gender'])){
                      if($meta_data['gender'] == 'female'){
                        $gender = config('constant.gender_female');
                      }elseif($meta_data['gender'] == 'male'){
                        $gender = config('constant.gender_male');
                      }else{
                        $gender = 0;
                      }
                    }

                    $is_reviewed  = 0;
                    if( isset($val['post_status']) && !empty($val['post_status']) ){
                        if($val['post_status'] === 'publish'){
                          $is_reviewed = 1;
                        }
                    }
                    $is_archived = 1;
                    if( isset($meta_data['cs_job_status']) && !empty($meta_data['cs_job_status']) ){
                        if($meta_data['cs_job_status'] === 'active'){
                          $is_archived = 0;
                        }
                    }

                    $ismodel = 0;
                    if( isset($meta_data['cs_radio_job']) && !empty($meta_data['cs_radio_job']) ){
                      if($meta_data['cs_radio_job'] === 'candidate'){
                        $ismodel = 1;
                      }
                    }
                    // echo "<br>cs_job_specialisms: ==";print_r($meta_data['cs_job_specialisms']);
                    $categories_ids = '';
                    $is_baby_model_category = 0;
                    $is_available_model_category = 0;

                    if(isset($meta_data) && isset($meta_data['cs_job_specialisms'])){
                      if(is_array($meta_data['cs_job_specialisms'])){
                        //map model category ids
                        $categories_ids = implode(',', $meta_data['cs_job_specialisms']);
                      }else{
                        $categories_ids = $meta_data['cs_job_specialisms'];
                      }
                    }

                    //map specialization with model/partner category
                    $specialization = explode(",", $categories_ids);
                    $modelCategoriesInsArray = $partnerCategoriesInsArray = array();
                    if(count($specialization)>0){
                      foreach($specialization as $cid){
                        if($ismodel){
                          if(isset($modelCategories[$cid])){
                            $modelCategoriesInsArray[] = $modelCategories[$cid];
                          }

                          if(isset($this->wpModelCategory[$cid]) && $this->wpModelCategory[$cid] == 1)
                          {
                            $is_baby_model_category = 1;
                          } else {
                            $is_available_model_category = 1;
                          }

                        }else{
                          if(isset($partnerCategories[$cid])){
                            $partnerCategoriesInsArray[] = $partnerCategories[$cid];
                          }
                        }
                      }
                    }

                    $modelCategoriesIns = $partnerCategoriesIns = '';
                    if(count($modelCategoriesInsArray)>0) $modelCategoriesIns = implode(",",$modelCategoriesInsArray);
                    if(count($partnerCategoriesInsArray)>0) $partnerCategoriesIns = implode(",",$partnerCategoriesInsArray);

                    // echo "<br>modelCategoriesIns: ==".$modelCategoriesIns;
                    // echo "<br>partnerCategoriesInsArray: ==".$partnerCategoriesIns;

                    $salary_min = $salary_max = '';
                    $paymentArr = array();
                    if(isset($meta_data) && isset($meta_data['payment']) && !empty($meta_data['payment'])){
                        $paymentArr = explode('-', $meta_data['payment']);

                        if(is_array($paymentArr) && !empty($paymentArr)){
                          $salary_min = $paymentArr[0];
                          $salary_max = $paymentArr[1];
                        }
                    }

                    $company_name = "";
                    if(isset($meta_data['cs_array_data']) && isset($meta_data['cs_array_data']['cs_company_name'])){
                      $company_name = $meta_data['cs_array_data']['cs_company_name'];
                    }

                    $cs_post_loc_zoom = 0;
                    if(isset($meta_data['cs_array_data']) && isset($meta_data['cs_array_data']['cs_post_loc_zoom'])){
                      $cs_post_loc_zoom = $meta_data['cs_array_data']['cs_post_loc_zoom'];
                    }


                    $experience_type_id = 1;
                    if(isset($meta_data['experiencetotal']) && !empty($meta_data['experiencetotal'])){
                        if($meta_data['experiencetotal'] === 'advanced'){
                          $experience_type_id = 2;
                        } else if($meta_data['experiencetotal'] === 'professionals'){
                          $experience_type_id = 3;
                        }
                    }
                    
                    // insert data array job posts
                    $post_author = '';
                    if(isset($val['post_author']) && !empty($val['post_author'])){
                        $post_author = isset($this->wpUserIds[trim($val['post_author'])])? trim($val['post_author']) : '';
                    }
                    $insertArr[$k]['user_id'] = $post_author;
                    $insertArr[$k]['wp_post_id'] = trim($val['ID']);
                    $insertArr[$k]['wp_user_id'] = $val['post_author'];
                    $insertArr[$k]['description'] = $val['post_content'];
                    $insertArr[$k]['title'] = $val['post_title'];
                    $insertArr[$k]['archived'] = $is_archived;
                    $insertArr[$k]['reviewed'] = $is_reviewed;
                    
                    $insertArr[$k]['wp_post_url'] = $val['guid'];
                    $insertArr[$k]['email'] = isset($meta_data['cs_emp_email']) ? $meta_data['cs_emp_email'] : '';

                    //map category id
                    $insertArr[$k]['category_id'] = '';
                    if(isset($meta_data['cs_job_types'])){
                      if(isset($jobCategories[$meta_data['cs_job_types']])){
                        $insertArr[$k]['category_id'] = $jobCategories[$meta_data['cs_job_types']];
                      }
                    }
                    // $insertArr[$k]['category_id'] = isset($meta_data['cs_job_types']) ? $meta_data['cs_job_types'] : '';

                    $insertArr[$k]['contact_name'] = isset($meta_data['cs_user']) ? $meta_data['cs_user'] : '';

                    $insertArr[$k]['ismodel'] = $ismodel;

                    // if($ismodel){
                      $insertArr[$k]['model_category_id'] = $modelCategoriesIns;
                    // } else {
                      $insertArr[$k]['partner_category_id'] = $partnerCategoriesIns;
                    // }

                    $insertArr[$k]['salary_min'] = $salary_min;
                    $insertArr[$k]['salary_max'] = $salary_max;

                    $insertArr[$k]['experience_type_id'] = $experience_type_id;
                    $insertArr[$k]['gender_type_id'] = $gender;

                    $insertArr[$k]['tfp'] = isset($meta_data['tfp']) ? $meta_data['tfp'] : 0;

                    $insertArr[$k]['height_from'] = isset($meta_data['height_min']) ? $meta_data['height_min'] : 0;
                    $insertArr[$k]['height_to'] = isset($meta_data['height_max']) ? $meta_data['height_max'] : 0;

                    if( $insertArr[$k]['height_from'] != 0 ){
                      $insertArr[$k]['height_from'] = array_search((int) $insertArr[$k]['height_from'], $this->heightListArr);
                    }

                    if( $insertArr[$k]['height_to'] != 0 ){
                      $insertArr[$k]['height_to'] = array_search((int) $insertArr[$k]['height_to'], $this->heightListArr);
                    }

                    // $insertArr[$k]['height_from'] = isset($meta_data['height_min']) ? $meta_data['height_min'] : 0;

                    // $insertArr[$k]['height_to'] = isset($meta_data['height_max']) ? $meta_data['height_max'] : 0;

                    $insertArr[$k]['age_from'] = isset($meta_data['age_min']) ? $meta_data['age_min'] : 0;

                    $insertArr[$k]['age_to'] = isset($meta_data['age_max']) ? $meta_data['age_max'] : 0;


                    // $insertArr[$k]['dressSize_from'] = isset($meta_data['clothing_size_min']) ? $meta_data['clothing_size_min'] : 0;

                    // $insertArr[$k]['dressSize_to'] = isset($meta_data['clothing_size_max']) ? $meta_data['clothing_size_max'] : 0;

                    // if($insertArr[$k]['dressSize_from'] != 0){
                    //     $insertArr[$k]['dressSize_from'] = array_search((int) $insertArr[$k]['dressSize_from'], $this->dressSizeArr);
                    // }

                    // if($insertArr[$k]['dressSize_to'] != 0){
                    //     $insertArr[$k]['dressSize_to'] = array_search((int) $insertArr[$k]['dressSize_to'], $this->dressSizeArr);
                    // }
                    
                    $dress_kid_size_array = $dress_men_size_array = $dress_women_size_array= array();
                    $clothing_size_arr = array();
                    
                    $clothing_size_max_range = '';
                    $clothing_size_min_range = '';

                    if(isset($meta_data['clothing_size']) && $meta_data['clothing_size'] != "" ){
                      
                      $clothing_size_arr = explode(',', $meta_data['clothing_size']);

                      if( count($clothing_size_arr) > 0 ){
                        $clothing_size_min_range = (isset($clothing_size_arr[0]))? $clothing_size_arr[0] : '';
                        $clothing_size_max_range = (isset($clothing_size_arr[1]))? $clothing_size_arr[1] : '';
                      }
                    }

                    
                    $dressSize_min_range = ($clothing_size_min_range != "") ? $clothing_size_min_range : $meta_data['clothing_size_min'];

                    $dressSize_max_range = ($clothing_size_max_range != "") ? $clothing_size_max_range : $meta_data['clothing_size_max'];
                    
                    $insertArr[$k]['dress_size_baby'] = NULL;
                    $insertArr[$k]['dress_size_women'] = NULL;
                    $insertArr[$k]['dress_size_men'] = NULL;

                    if( $is_baby_model_category == 1 && $ismodel ){

                      $dressSize_kid_min_range = $this->returnClosestValue($this->dressSizeKidsArr, $dressSize_min_range);
                    
                      $dressSize_kid_max_range = $this->returnClosestValue($this->dressSizeKidsArr, $dressSize_max_range);

                      if( $dressSize_kid_min_range != 0 && $dressSize_kid_max_range != 0 ) {
                        foreach ($this->dressSizeKidsArr as $key => $dressSize) {
                          if($dressSize >= $dressSize_kid_min_range && $dressSize <= $dressSize_kid_max_range)
                            {
                              $dress_kid_size_array[] = $key;
                            }
                        }
                      }

                      if( isset($dress_kid_size_array) && count($dress_kid_size_array) > 0 ){
                        $insertArr[$k]['dress_size_baby'] = implode(',', $dress_kid_size_array);
                      }
                      
                    }

                    if( $is_available_model_category == 1 && $ismodel ){


                      if(isset($gender) && ( $gender == config('constant.gender_male') || $gender == 0) ){
                        
                        $dressSize_men_min_range = $this->returnClosestValue($this->dressSizeMenArr, $dressSize_min_range);
                      
                        $dressSize_men_max_range = $this->returnClosestValue($this->dressSizeMenArr, $dressSize_max_range);

                        if( $dressSize_men_min_range != 0 && $dressSize_men_max_range != 0 ) {
                          foreach ($this->dressSizeMenArr as $key => $dressSize) {
                            if($dressSize >= $dressSize_men_min_range && $dressSize <= $dressSize_men_max_range)
                              {
                                $dress_men_size_array[] = $key;
                              }
                          }
                        }

                        if( isset($dress_men_size_array) && count($dress_men_size_array) > 0 ){
                          $insertArr[$k]['dress_size_men'] = implode(',', $dress_men_size_array);
                        }

                      }

                      
                      
                      if(isset($gender) && ( $gender == config('constant.gender_female') || $gender == 0 )){
                        
                        $dressSize_women_min_range = $this->returnClosestValue($this->dressSizeWomenArr, $dressSize_min_range);
                    
                        $dressSize_women_max_range = $this->returnClosestValue($this->dressSizeWomenArr, $dressSize_max_range);

                        if( $dressSize_women_min_range != 0 && $dressSize_women_max_range != 0 ) {
                          foreach ($this->dressSizeWomenArr as $key => $dressSize) {
                            if($dressSize >= $dressSize_women_min_range && $dressSize <= $dressSize_women_max_range)
                              {
                                $dress_women_size_array[] = $key;
                              }
                          }
                        }

                        if( isset($dress_women_size_array) && count($dress_women_size_array) > 0 ){
                          $insertArr[$k]['dress_size_women'] = implode(',', $dress_women_size_array);
                        }
                        
                      }

                    }

                    $insertArr[$k]['end_application'] = isset($meta_data['cs_application_closing_date']) ? date('Y-m-d H:i:s', $meta_data['cs_application_closing_date']) : '';

                    $insertArr[$k]['country_code'] = isset($meta_data['cs_loc_iso_code']) ? strtoupper($meta_data['cs_loc_iso_code']) : '';

                    $insertArr[$k]['city'] = isset($meta_data['cs_post_loc_city']) ? $meta_data['cs_post_loc_city'] : '';
                    
                    $insertArr[$k]['address'] = isset($meta_data['cs_post_comp_address']) ? $meta_data['cs_post_comp_address'] : '';

                    $insertArr[$k]['lon'] = isset($meta_data['cs_post_loc_latitude']) ? $meta_data['cs_post_loc_latitude'] : '';

                    $insertArr[$k]['lat'] = isset($meta_data['cs_post_loc_longitude']) ? $meta_data['cs_post_loc_longitude'] : '';

                    $insertArr[$k]['start_date'] = isset($meta_data['cs_job_posted']) ?  date('Y-m-d', $meta_data['cs_job_posted'])  : '';

                    $insertArr[$k]['end_date'] = isset($meta_data['cs_job_expired']) ?  date('Y-m-d', $meta_data['cs_job_expired'])  : '';


                    $insertArr[$k]['package'] = isset($meta_data['cs_job_package']) ? $meta_data['cs_job_package'] : '';
                    $insertArr[$k]['company_name'] = $company_name;
                    
                    $insertArr[$k]['created_at'] = date("Y-m-d", strtotime($val['post_date']));
                    $insertArr[$k]['updated_at'] = date("Y-m-d", strtotime($val['post_modified']));

                    $insertArr[$k]['wp_comment_status'] = isset($val['comment_status'])? $val['comment_status'] : '';
                    $insertArr[$k]['wp_ping_status'] = isset($val['ping_status'])? $val['ping_status'] : '';
                    $insertArr[$k]['wp_post_password'] = isset($val['post_password'])? $val['post_password'] : '';
                    $insertArr[$k]['wp_post_name'] = isset($val['post_name'])? $val['post_name'] : '';
                    $insertArr[$k]['wp_post_parent'] = isset($val['post_parent'])? $val['post_parent'] : 0;
                    
                    $insertArr[$k]['wp_cs_post_loc_zoom'] = $cs_post_loc_zoom;

                    $insertArr[$k]['wp_jh_email_notification'] = isset($meta_data['jh_email_notification'])? $meta_data['jh_email_notification'] : 0;

                    $insertArr[$k]['wp_cs_job_id'] = isset($meta_data['cs_job_id'])? $meta_data['cs_job_id'] : 0;
                    // $insertArr[$k]['cs_job_username'] = isset($meta_data['cs_job_username'])? $meta_data['cs_job_username'] : 0;

                    $insertArr[$k]['verified_email'] = 1;
                    $insertArr[$k]['verified_phone'] = 1;

                    $insertArr[$k]['wp_cs_count_views_new'] = isset($meta_data['cs_count_views_new']) ? $meta_data['cs_count_views_new'] : 0;

                    $insertArr[$k]['wp_cs_job_detail_url'] = isset($meta_data['cs_array_data']['cs_job_detail_url']) ? $meta_data['cs_array_data']['cs_job_detail_url'] : null;

                    $insertArr[$k]['wp_cs_company_name'] = isset($meta_data['cs_array_data']['cs_company_name']) ? $meta_data['cs_array_data']['cs_company_name'] : null;

                    $insertArr[$k]['wp_cs_org_name'] = isset($meta_data['cs_array_data']['cs_org_name']) ? $meta_data['cs_array_data']['cs_org_name'] : null;

                    $insertArr[$k]['post_type_id'] = $postType;

                    $insertArr[$k]['currency_code'] = isset($CurrencyCode[strtoupper($insertArr[$k]['country_code'])])? $CurrencyCode[strtoupper($insertArr[$k]['country_code'])] : 'EUR';

                    if(in_array(trim($val['ID']), $postId_arr)){
                        try{ 
                          Post::withoutGlobalScopes()->where('wp_post_id', $val['ID'])->update($insertArr[$k]);
                          //If record is updated then remove from insert array
                          unset($insertArr[$k]);
                          $is_update = true;
                          $update_count++;
                        }
                        catch(\Exception $e){
                          echo json_encode([
                            'status' => 'false',
                            'wp_post_id' => $val['ID'],
                            'message' => $e->getMessage()
                          ]);
                          exit();
                        }
                    }
                    
                  }

                  if(!empty($insertArr) && count($insertArr) > 0 ){

                    try{ 
                      $postinfo = Post::insert($insertArr);
                    }
                    catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'wp_post_id' => $val['ID'],
                        'message' => $e->getMessage()
                      ]);
                      
                    }

                  }
                }
              }
               
            }


            //update phone code in post table
            
            DB::statement(" UPDATE posts INNER JOIN users ON posts.user_id = users.id INNER JOIN user_profile ON users.id = user_profile.user_id SET posts.contact_name = user_profile.first_name, posts.email = users.email, posts.phone = users.phone, posts.phone_code = users.phone_code WHERE ( posts.wp_post_id IS NOT NULL OR  posts.wp_post_id != '' ) AND ( posts.user_id IS NOT NULL || posts.user_id != '') ");


            echo json_encode([
              'status' => 'true',
              'message' => "Records updated successfully"
            ]);           
            exit();

            
          }else{
            echo json_encode([
              'status' => 'false',
              'message' => "No record found!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "SSL certificate problem: unable to get local issuer certificate"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }

    public function getTransaction($request){
      
      if(count($request->all()) > 0){

        Log::info("================== process starting for transaction migration =============");
        Mail::send('emails.exception', ['error' => 'Transaction list migration started', 'url' => '', 'ErrorCode' => ''],
        function ($m) {
            $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
        });

        //store log file
        // $this->storeLog($this->model_log, 'Info', '=================== START CRON ===================');

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        // call api model eye color 
        $req = array('action' => 'get_transaction' , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);

        // check Api response status
        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
             
          $dataArr = json_decode($res['response'], true);
           
          $total_pages = $dataArr['total_page'];

          // check record is exist
          // if($total_pages > 0){
          if( isset($dataArr['data']) && !empty($dataArr['data']) && count($dataArr['data'])>0 ){

            $paymentMethod = PaymentMethod::pluck('id', 'name')->toArray();
            $this->packageUserType = Package::withoutGlobalScopes()->pluck('user_type_id', 'wp_package_id')->toArray();
            $this->packageIds = Package::withoutGlobalScopes()->pluck('id', 'wp_package_id')->toArray();

            $userArr =  DB::table('users')->where('wp_user_id' , '!=' , 0)->pluck('id', 'wp_user_id')->toArray();

            $this->userTypeId =  DB::table('users')->where('wp_user_id' , '!=' , 0)->pluck('user_type_id', 'wp_user_id')->toArray();

            $this->userName =  DB::table('users')->where('wp_user_id' , '!=' , 0)->pluck('username', 'wp_user_id')->toArray();

            if(count($userArr) == 0){
              echo json_encode([
                    'status' => 'true',
                    'message' => "Users table record does not exist!"
              ]);
              Log::info("Error: Sorry, we don't recognize the user");
              exit();
            }
            if(count($paymentMethod) == 0){
                echo json_encode([
                    'status' => 'true',
                    'message' => "Payment methods table record does not exist!"
                ]);
                Log::info("Error: Payment method does not exist");
                exit();
            }
            // for loop total pages
            // for($i = 1; $i <= $total_pages; $i++) { 
              
              // echo "page No ====================" .$i . "=================================";

              // if($i !== 1){
              //   // call api for get transaction param (action, page No) 
              //   $req = array('action' => 'get_transaction' , 'paged' => $i);
              //   $res = $this->getCurlRequest($this->url, $req);
              // }

              // check Api response status
              // if($res['status'] == true){

                // $dataArr = json_decode($res['response'], true);
                $data = $dataArr['data'];
                $total_pages = $dataArr['total_page'];

                // if(count($data) > 0){

                  // echo "============== response data =============";
                  // echo "<pre>";
                  // print_r ($data);
                  $this->saveTransactionData($data, $paymentMethod, $userArr);
                // } // end if count data conditions 
                // else{
                //   echo json_encode([
                //       'status' => 'true',
                //       'message' => "No record found!"
                //   ]);
                //   exit();
                // }
              // } // end if check Api response status
              // else{
              //   echo json_encode([
              //       'status' => 'false',
              //       'message' => "SSL certificate problem: unable to get local issuer certificate"
              //     ]);
              //   exit();
              // }
              
            // } // end for loop

                echo json_encode([
                  'status' => 'true',
                  'message' => "Saved Transaction Successfully"
                ]);
                Log::info("================== process ends for transaction migration =============");
                Mail::send('emails.exception', ['error' => "partner migration cron ended", 'url' => '', 'ErrorCode' => ''], function ($m) {
                    $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
                });
                exit();
          } // end total_pages if conditions
          else{
            echo json_encode([
                'status' => 'false',
                'message' => "No record found!"
              ]);
            Log::info("Error: No record found for migration");
            exit();
          }
        } // end if check Api response status
        else{
            echo json_encode([
                'status' => 'false',
                'message' => "SSL certificate problem: unable to get local issuer certificate"
              ]);
            Log::info("Error: Error in fetching migration records");
            exit();
        }
      } // end if check request data !empty
      else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
        Log::info("Error: Invalid request");
        exit();
      }
    }


    public function saveTransactionData($data, $paymentMethod, $userArr){
      
      $metaDataArr = array();

      // get all post data record 
      $postArr =  DB::table('posts')->whereNotNull('wp_post_id')->pluck('id', 'wp_post_id')->toArray();

      // get all payments data record 
      $paymentArr =  DB::table('payments')->whereNotNull('wp_post_id')->pluck('post_id', 'wp_post_id')->toArray();

      
      foreach ($data as $val){

        // meteData array
        $metaDataArr = $val['meta_data'];

        $newPost = 0;
        //  check post already exist, if not exist save new post 
        if(!array_key_exists($val['ID'], $postArr)){
           
          $postObj = new Post();
          
          $postObj->wp_post_id = $val['ID'];
          $postObj->wp_user_id = $val['post_author'];
          $postObj->created_at = date("Y-m-d H:i:s", strtotime($val['post_date']));
          $postObj->updated_at = date("Y-m-d H:i:s", strtotime($val['post_modified']));
          $postObj->wp_post_url = $val['guid'];
          $postObj->package =  isset($this->packageIds[$metaDataArr['transaction_package']])? $this->packageIds[$metaDataArr['transaction_package']] : 0;

          $subid = '_access';
          $username = "";
          if(isset($val['post_author']) && array_key_exists($val['post_author'], $this->userTypeId)){
            // store subid
            if($this->userTypeId[$val['post_author']] == 2){
              $subid = '_access_partner';
            }

            // store username
            if(isset($this->userName[$val['post_author']])){
              $username = $this->userName[$val['post_author']];
            }

          }

          $postObj->subid = $subid;
          $postObj->username = $username;
          
          //  check array users exist 
          if(array_key_exists($val['post_author'], $userArr)){
            $postObj->user_id = $userArr[$val['post_author']];
          } else {
            // store Payment user which are not exist in user table
            $userId = $this->storePaymentUser($metaDataArr, $val['ID']);
            if($userId){
              $postObj->user_id = $userId;
            }
          }

          try {
            // save post data in db
            $postObj->save();
            $newPost = 1;
          } catch(\Exception $e){
            echo json_encode([
              'status' => 'false',
              'message' => $e->getMessage(),
              'wp_post_id' => $val['ID']
            ]); exit();
          }
        }
        
        if($newPost == 1){
          if(array_key_exists($val['ID'], $paymentArr)){
            // delete payment record, if new post create and payment record already exist 
            $deleteSavedPost = Payment::where('wp_post_id', $val['ID'])->delete();
            //  unset array key deleted record
            unset($paymentArr[$val['ID']]); 
          }
        }

        //  check payment already exist, if not exist save new payment
        if(!array_key_exists($val['ID'], $paymentArr)){
           
          $paymentObj = new Payment();

          if($newPost == 0){
            $paymentObj->post_id = $postArr[$val['ID']];
          }else{
            $paymentObj->post_id = $postObj->id;
          }

          $status = 'cancelled';
          if(isset($metaDataArr['transaction_status']) && !empty($metaDataArr['transaction_status'])){
              if(in_array($metaDataArr['transaction_status'], $this->wp_payment_status)){
                $status = $metaDataArr['transaction_status'];
              }
          }
          $transaction_expiry_date = '';
          if(!empty($metaDataArr['transaction_expiry_date'])){
            $transaction_expiry_date = date('Y-m-d', $metaDataArr['transaction_expiry_date']);
          }

          $paymentObj->wp_post_id = $val['ID'];
          $paymentObj->wp_package_id = $metaDataArr['transaction_package'];
          $paymentObj->transaction_id = $metaDataArr['transaction_id'];
          $paymentObj->transaction_amount = isset($metaDataArr['transaction_amount'])? $metaDataArr['transaction_amount'] : 0;

          $paymentObj->transaction_status = $status;
          
          if(!empty($transaction_expiry_date)){
            $paymentObj->transaction_expiry_date = $transaction_expiry_date;
          }

          $paymentObj->transaction_listings = isset($metaDataArr['transaction_listings'])? $metaDataArr['transaction_listings'] : '';
          
          $paymentObj->transaction_listing_expiry = isset($metaDataArr['transaction_listing_expiry'])? $metaDataArr['transaction_listing_expiry'] : '';
          
          $paymentObj->transaction_listing_period = isset($metaDataArr['transaction_listing_period'])? $metaDataArr['transaction_listing_period'] : '';

          if(!empty($val['post_date'])){
            
            $paymentObj->post_date = date("Y-m-d H:i:s", strtotime($val['post_date']));
          }
           
          $otherWayToPayment = true;
          
          if(isset($metaDataArr['transaction_pay_method']) && !empty($metaDataArr['transaction_pay_method'])){
            // check transaction method exist in db
            if(array_key_exists($metaDataArr['transaction_pay_method'], $paymentMethod)){
              $paymentObj->payment_method_id = $paymentMethod[$metaDataArr['transaction_pay_method']];
              $otherWayToPayment = false;
            } 
          } 

          if($otherWayToPayment == true){
            $paymentObj->payment_method_id = $paymentMethod['other'];
          }

          $is_active = 0;
          if($val['post_status'] == 'publish'){
            $is_active = 1;
          }

          $paymentObj->active = $is_active;

          try{
            // save payment in db
            $paymentObj->save();
          }catch(\Exception $e){
            
            echo json_encode([
              'status' => 'false',
              'message' => $e->getMessage(),
              'wp_post_id' => $val['ID']
            ]); exit();
          }
        }
      } // end foreach loop
    }


    // Call function while fetch model profile date and store models sedcard images
    public function storeModelSedcard($sedcardArr = array(), $user_id = null, $country_code = null){

        /* GET USER SEDCARED IMAGE AND SPLIT WITH uploads FOLDER AND STORE THE REMAIN STRING AS PATH */

          $sedcard_filename = "";
          $sedcard_imageName = "";
          $sedcaredInserdArr = array();
          $index = 0;

          if( isset($sedcardArr) && !empty($sedcardArr) ){
            
            if(isset($this->wp_sedcard_type) && count($this->wp_sedcard_type)>0){
              $i = 0;
              
              //store log file
              $this->storeLog($this->model_log, 'Info', 'IN SEDCARD STORE FUNCTION');

              foreach ($this->wp_sedcard_type as $type => $type_id) {

                  if(isset($sedcardArr[0][$type]) && !empty($sedcardArr[0][$type])){

                      $split = explode($this->wp_upload_folder, $sedcardArr[0][$type]);

                      if(isset($split) && count($split) > 0 ){
                        $sedcard_filename = (isset($split[1]))? ltrim($split[1], '/') : '';  
                        $sedcard_imageName = substr(strrchr(rtrim($sedcard_filename, '/'), '/'), 1); 
                      }

                      $sedcaredInserdArr[$i]['user_id'] = $user_id;
                      $sedcaredInserdArr[$i]['country_code'] =  $country_code;
                      $sedcaredInserdArr[$i]['name'] = $sedcard_imageName;
                      $sedcaredInserdArr[$i]['filename'] = $sedcard_filename;
                      $sedcaredInserdArr[$i]['active'] = 1;
                      $sedcaredInserdArr[$i]['image_type'] = $type_id;
                      $sedcaredInserdArr[$i]['created_at'] = date('Y-m-d H:i:s');
                  }
                  $i++;
              }

              $this->storeLog($this->model_log, 'Info', 'SEDCARD =>'.count($sedcaredInserdArr));
              
              if(isset($sedcaredInserdArr) && count($sedcaredInserdArr) > 0 ){
                $userSedcard = Sedcard::withoutGlobalScopes([ActiveScope::class])->where('user_id', $user_id)->delete();
                      
                    try{ 
                      Sedcard::insert($sedcaredInserdArr);
                      $this->storeLog($this->model_log, 'Info', 'STORED SEDCARD IMAGES');
                    }
                    catch(\Exception $e){
                      $this->storeLog($this->model_log, 'Info', 'SEDCARD =>'.$e->getMessage());
                    }
                
              }

            }

          }

          return true;

        /* End SEDCARD Process */
    }

    public function saveFavouriteJobs($wp_user, $user_id){
       
      // $count = SavedPost::where('user_id', $user_id)->count();
      
      // if($count > 0){
        $deleteSavedPost = SavedPost::where('user_id', $user_id)->delete();
      // }
      
      $favJobsInsertArr = array();
      
      if(isset($wp_user['cs-user-jobs-wishlist']) && !empty($wp_user['cs-user-jobs-wishlist']))
        {  

          if(is_array($wp_user['cs-user-jobs-wishlist']) && count($wp_user['cs-user-jobs-wishlist']) > 0)
          {
            
            $i = 0;
            foreach ($wp_user['cs-user-jobs-wishlist'] as $key => $val) {
              if(isset($this->existingJobs[$val['post_id']])) {
                $favJobsInsertArr[$i]['user_id'] = $user_id;
                $favJobsInsertArr[$i]['post_id'] = $this->existingJobs[$val['post_id']];
                $favJobsInsertArr[$i]['created_at'] = isset($val['date_time']) ? date('Y-m-d H:i:s', $val['date_time']) : '';
                // $favJobsInsertArr[$i]['wp_user_id'] = $wp_user['user_id'];
                // $favJobsInsertArr[$i]['wp_post_id'] = $val['post_id'];
                $i++; 
              }              
            }

            if(count($favJobsInsertArr) > 0){ 
              try{
                  $save = SavedPost::insert($favJobsInsertArr);

                  //store log file
                  $this->storeLog($this->model_log, 'Info', 'Store Favourite Jobs');
              }
              catch(\Exception $e){
                $status =  json_encode(['status' => 'false','error' => $e->getMessage(),'message' => 'save jobs error']);
                //store log file
                $this->storeLog($this->model_log, 'Error', $status);
                exit();
              }
            }
          }
        }

      return true;
    }

    public function saveFavouriteUsers($wp_user, $user_id){

      // $count = Favorite::where('wp_user_id', $wp_user['user_id'])->count();
    
      // if($count > 0){
        $deleteSavedPost = Favorite::where('wp_user_id', $wp_user['user_id'])->delete();
      // }

      $favUserInsertArr = array();
      
      if(isset($wp_user['cs-user-resumes-wishlist']))
        {   
          if(!empty($wp_user['cs-user-resumes-wishlist'])){

            if(count($wp_user['cs-user-resumes-wishlist']) > 0){

                $i = 0;
                foreach ($wp_user['cs-user-resumes-wishlist'] as $key => $val){
                  
                  $favUserInsertArr[$i]['wp_user_id'] = $wp_user['user_id'];
                  $favUserInsertArr[$i]['wp_fav_id'] = $val['post_id'];
                  $favUserInsertArr[$i]['created_at'] = isset($val['date_time']) ? date('Y-m-d H:i:s', $val['date_time']) : '';

                  $favUserInsertArr[$i]['user_id'] = $user_id;

                  $i++;
                }
                
                if(count($favUserInsertArr) > 0){ 
                  try{
                    $save = Favorite::insert($favUserInsertArr);
                    //store log file
                    $this->storeLog($this->model_log, 'Info', 'Store Favourite Users'); 
                  }
                  catch(\Exception $e){
                              
                    echo json_encode([
                      'status' => 'false',
                      'error' => $e->getMessage(),
                      'message' => 'save favorites users error',
                    ]);
                    exit();
                  }
                }
            }
          }
        }
    }

    public function storeLog($logfile, $type, $message){

        $content = "['".$type."' => ".$message."] \n";
        $fp = fopen($this->migrationLogFilePath."/".$logfile.".txt","a");
        fwrite($fp, $content);
        fclose($fp);
    }

    public function updateFavouriteUsers(){

      try{
        // Update favourites users favourites id 
        $updateFavouriteUsers = DB::table('favorites as f')
              ->Join('users as u', 'u.wp_user_id', '=', 'f.wp_fav_id')
              ->update(['f.fav_user_id' => DB::raw('u.id')]);
      }catch(\Exception $e){
        echo json_encode([
            'status' => 'false',
            'message' => 'Update favorites user fail!',
            'error' => $e->getMessage()
          ]);
        exit();
      }
      return true;
    }

    public function saveUserJobsApplied($wp_user, $user_id){
      
      // $count = JobApplication::where('user_id', $user_id)->count();
    
      // if($count > 0){
        $delete = JobApplication::where('user_id', $user_id)->delete();
      // }

      $insertArr = array();

      if(isset($wp_user['cs-user-jobs-applied-list'])){
        
        if(!empty($wp_user['cs-user-jobs-applied-list'])){
          
          if(count($wp_user['cs-user-jobs-applied-list']) > 0){
              
            $i = 0;
            
            foreach ($wp_user['cs-user-jobs-applied-list'] as $val) {
              //insert record if job existing in db
              if(isset($this->existingJobs[$val['post_id']])){
                $insertArr[$i]['user_id'] = $user_id;
                $insertArr[$i]['post_id'] = $this->existingJobs[$val['post_id']];                
                // $insertArr[$i]['wp_post_id'] = $val['post_id'];
                // $insertArr[$i]['wp_user_id'] = $wp_user['user_id'];
                $insertArr[$i]['created_at'] =  isset($val['date_time']) ? date('Y-m-d H:i:s', $val['date_time']) : '';
                $i++;
              }
              
            }
            if(count($insertArr) > 0){ 
              try{
                $save = JobApplication::insert($insertArr);
                //store log file
                $this->storeLog($this->model_log, 'Info', 'Store user jobs applied'); 
              }
              catch(\Exception $e){
                          
                echo json_encode([
                  'status' => 'false',
                  'error' => $e->getMessage(),
                  'message' => 'Save user jobs applied error!',
                ]);
                exit();
              }
            }
          }
        }
      }
    }

    public function getEyeColor(){
      return ValidValue::select('valid_value_translations.slug','valid_value_translations.valid_value_id')
              ->join('valid_value_translations', 'valid_values.id', '=', 'valid_value_translations.valid_value_id')
             ->where('valid_values.type', 'eye_color')
             ->get()
             ->pluck('valid_value_id', 'slug')
             ->toArray();
    }

    public function getSkinColor(){
      return ValidValue::select('valid_value_translations.slug','valid_value_translations.valid_value_id')
              ->join('valid_value_translations', 'valid_values.id', '=', 'valid_value_translations.valid_value_id')
             ->where('valid_values.type', 'skin_color')
             ->get()
             ->pluck('valid_value_id', 'slug')
             ->toArray();
    }

    public function getHairColor(){
      return ValidValue::select('valid_value_translations.slug','valid_value_translations.valid_value_id')
              ->join('valid_value_translations', 'valid_values.id', '=', 'valid_value_translations.valid_value_id')
             ->where('valid_values.type', 'hair_color')
             ->get()
             ->pluck('valid_value_id', 'slug')
             ->toArray();
    }

    public function storePaymentUser($paymentUser, $postid){
      if( isset($paymentUser['summary_email']) && !empty($paymentUser['summary_email'])){
        
        $user_type_id = 0;
        if( isset($paymentUser['transaction_package']) && !empty($paymentUser['transaction_package']) ){
          $user_type_id = isset($this->packageUserType[$paymentUser['transaction_package']])? $this->packageUserType[$paymentUser['transaction_package']] : 0;
        }

        $userObj = new User();
        $userObj->wp_user_id = isset($paymentUser['transaction_user'])? $paymentUser['transaction_user'] : 0;
        $userObj->email = isset($paymentUser['summary_email'])? $paymentUser['summary_email'] : '';
        $userObj->user_type_id = $user_type_id;
        $userObj->active = 0;
        $userObj->verified_email = 0;
        $userObj->verified_phone = 0;
        $userObj->deleted_at = date('Y-m-d H:i:s');

        try{
          $userObj->save();
        }catch(Exception $e){
          echo json_encode([
              'status' => 'false',
              'message' => $e->getMessage(),
              'wp_post_id' => $postid
            ]); exit();
        }

        if($userObj->id){
          $userProfObj = new UserProfile();
          $userProfObj->user_id = $userObj->id;
          $userProfObj->first_name = isset($paymentUser['first_name'])? $paymentUser['first_name'] : '';
          $userProfObj->last_name = isset($paymentUser['last_name'])? $paymentUser['last_name'] : '';
          $userProfObj->address_line1 = isset($paymentUser['full_address'])? $paymentUser['full_address'] : '';

          try{
            $userProfObj->save();
          }catch(Exception $e){
            echo json_encode([
                'status' => 'false',
                'message' => $e->getMessage(),
                'wp_post_id' => $postid
              ]); exit();
          }
        }

        return $userObj->id;
      } else {
        return 0;
      }
    }



    public function setPartnerUsername($request){

        Log::info("================== process starting for partner username migration =============");
        // Mail::send('emails.exception', ['error' => 'Partner username migration started', 'url' => '', 'ErrorCode' => ''],
        // function ($m) {
        //     $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
        // });

        //store log file
        $this->storeLog($this->model_log, 'Info', '=================== START CRON ===================');

        $getTotal = $per_page = 0;
        $partnerArray = array();

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        $req = array('action' => 'get_partners' , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);

        //set infinite execution time for get more than 2000 records
        ini_set('max_execution_time', 0);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);
            
            if( isset($result['total']) && !empty($result['total']) ){
              $getTotal = $result['total'];
            }

            //store log file
            $this->storeLog($this->model_log, 'Info' ,'init count =>'.$getTotal);

            $partnerList = array();

            if( isset($result['results']) && !empty($result['results']) && count($result['results'])>0 ){

                //fetch wordpress data properly and have model data to insert

                $partnerList = $result['results'];
                // echo "count: ".count($partnerList);

                foreach ($partnerList as $key => $partner) {

                  if(isset($partner) && isset($partner['username']) && !empty($partner['username'])){
                    try{
                        //store log file
                    // $this->storeLog($this->model_log, 'Info', 'Partner Object Passed (storeUser) =>'.json_encode($partner));
                        $update = User::where('wp_user_id', $partner['user_id'])->update(['username' => trim($partner['username'])]);

   
                        // $this->storeLog($this->update_log, 'Update', 'user_id => '.$partner['user_id'].' user_name =>'.$partner['username']);

                      }catch(Exception $e){
                        
   
                        // $this->storeLog($this->update_log, 'Error', 'user_id => '.$partner['user_id'].' user_name =>'.$partner['username']);

                        echo json_encode([
                          'status' => 'false',
                          'message' => $e->getMessage()
                        ]); exit();
                      }
                  }
                }
            }
            else {
                Log::info("No Partner data found to insert");
                echo $status = json_encode([
                    'status' => 'false',
                    'message' => "No Partner data found to insert"
                  ]);

                //store log file
                // $this->storeLog($this->model_log, 'Error', $status); 
                // Mail::send('emails.exception', ['error' => $status, 'url' => '', 'ErrorCode' => ''], function ($m) {
                //     $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
                // });
                exit();
            }
        } else {
          Log::info("Error in getting migration response");
          echo $status = json_encode([
                'status' => 'false',
                'message' => "SSL certificate problem: unable to get local issuer certificate"
              ]);

          //store log file
          // $this->storeLog($this->model_log, 'Error', $status); 
          // Mail::send('emails.exception', ['error' => $status, 'url' => '', 'ErrorCode' => ''], function ($m) {
          //     $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
          // });
          exit();
      }

      Log::info("================== process ends for partner username migration =============");
      echo json_encode([
        'status' => 'success',
        'message' => 'update Successfully'
      ]);
      
      // Mail::send('emails.exception', ['error' => "partner username migration cron ended", 'url' => '', 'ErrorCode' => ''], function ($m) {
      //     $m->to(config('app.admin_email_migration'), 'admin')->subject( trans('mail.error_subject') );
      // });

      //store log file
      $this->storeLog($this->model_log, 'Info', '=================== END CRON ===================');
    }


     /*public function updateUserName(){

        $getTotal = $per_page = 0;
        $partnerArray = array();

        //set infinite execution time for get more than 3000 records
        ini_set('max_execution_time', 0);

        $req = array('action' => 'get_partners' , 'paged' => 1);
        $res = $this->getCurlRequest($this->url, $req);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);

            if( isset($result['total']) && !empty($result['total']) ){
              $getTotal = $result['total'];
            }

            if( isset($result['per_page']) && !empty($result['per_page']) ){
              $per_page = $result['per_page'];
            }

            $count = 0;

            if($getTotal > 0 && $per_page != 0){
                
                if($getTotal > $per_page){

                  $pages = ceil( ( $getTotal/$per_page) );

                  for ($i=1; $i <= $pages; $i++) {

                    $partnerList = array();

                    $req['paged'] = $i;

                    if($i !== 1){
                      $req = array('action' => 'get_partners' , 'paged' => $i);
                      $res = $this->getCurlRequest($this->url, $req);
                    }

                  
                    if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
                      
                      $result = json_decode($res['response'], true);

                      if( isset($result['results']) && !empty($result['results']) ){
                          $partnerList = $result['results'];

                          
                          if( count($partnerList) > 0 ){

                            foreach ($partnerList as $key => $partner) {
                                if(isset($partner) && isset($partner['username']) && !empty($partner['username'])){

                                    try{
                                      $update = User::where('wp_user_id', $partner['user_id'])->update(['username' => trim($partner['username'])]);

                 
                                      $this->storeLog($this->update_log, 'Update', 'user_id => '.$partner['user_id'].' user_name =>'.$partner['username']);

                                    }catch(Exception $e){
                                      
                 
                                      $this->storeLog($this->update_log, 'Error', 'user_id => '.$partner['user_id'].' user_name =>'.$partner['username']);

                                      echo json_encode([
                                        'status' => 'false',
                                        'message' => $e->getMessage()
                                      ]); exit();
                                    }

                                }
                            }

                          } else {
                              echo json_encode([
                                  'status' => 'false',
                                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                                ]); exit();
                          }
                      } 
                    }else{

                          echo json_encode([
                            'status' => 'false',
                            'message' => "SSL certificate problem: unable to get local issuer certificate"
                          ]); exit();
                    }
                  }
                  
                  echo json_encode([
                    'status' => 'success',
                    'message' => 'Username updated Successfully'
                  ]); exit();

                }
            } else {

              echo json_encode([
                  'status' => 'false',
                  'message' => "SSL certificate problem: unable to get local issuer certificate"
                ]); exit();

            }

        } else {
          echo json_encode([
              'status' => 'false',
              'message' => "SSL certificate problem: unable to get local issuer certificate"
            ]); exit();
        }
    }*/

    /* Update all users experiance till date flag update */
    public function updateModelExperiance($request){
      
        $getTotal = $per_page = 0;
        $partnerArray = array();

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        $req = array('action' => 'get_models' , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);

        //set infinite execution time for get more than 2000 records
        ini_set('max_execution_time', 0);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);
            
            if( isset($result['total']) && !empty($result['total']) ){
              $getTotal = $result['total'];
            }

            
            $userList = array();

            if( isset($result['results']) && !empty($result['results']) && count($result['results'])>0 ){

                $userList = $result['results'];
                $i = 0;
                $update_user_experiance = array();
                
                foreach ($userList as $key => $user) {
                  if(isset($user['cs_exp_list_array']) && !empty($user['cs_exp_list_array']) && count($user['cs_exp_list_array'])>0){
                    if( isset($user['cs_exp_to_present_array']) && !empty($user['cs_exp_to_present_array'])){
                      foreach ($user['cs_exp_list_array'] as $key => $expId) {
                        if(isset($user['cs_exp_to_present_array'][$key]) && !empty($user['cs_exp_to_present_array'][$key])){
                            $update_user_experiance[$i] = trim($expId);
                            $i++;
                        }
                      }
                    }
                  }
                }

                $update_arr_ids = "";
                if(isset($update_user_experiance) && count($update_user_experiance) > 0 ){
                  
                  try{
                    UserExperiences::whereIn('wp_experiance_id', $update_user_experiance)->update(['up_to_date' => 1]);
                  }catch(\Exception $e){
                    die($e->getMessage());
                  }

                }

                die("records updated successfully");
            }
            else {
              die("results not found");
            }

        } else {
           die("Invalid request");
        }
        
    }


    public function updateJobStatus($request){

      $page = '';
      $post_per_page = '';

      $insertArr = array();
      $updateArr = array();

      if(count($request->all()) > 0){
        
        if(isset($request->post_per_page) && !empty($request->post_per_page)){
          
          $post_per_page = $request->post_per_page;
        }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid post_per_page key and value!"
            ]);

          exit();
        }

        if(isset($request->page) && !empty($request->page)){
          
        $page = $request->page;
        
        } else {
          $page = 1;
          // echo json_encode([
          //     'status' => 'false',
          //     'message' => "Invalid page key and value!"
          //   ]);
          // exit();
        }

        // call api model eye color 
        $req = array('action' => 'jobs' , 'page' => $page, 'post_per_page' => $post_per_page);
        $res = $this->getCurlRequest($this->url, $req);

        $total_records = 0;

        // check status is true
        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
         
          $dataArr = json_decode($res['response'], true);
          $data = $dataArr['data'];

          $total_records = $dataArr['total'];
          $total_pages = 1;

          if( ($total_records > 0) && $post_per_page != ''){
            if($total_records > $post_per_page){
              $total_pages = ceil( ( $total_records/$post_per_page) );
            }
          }

          if(count($data) > 0){

            $i = 0;
            $meta_data = array();
            $gender = 0;

            for($i = 1; $i <= $total_pages; $i++) { 
               
              if($i != 1){
                // call api for get transaction param (action, page No) 
                  $req = array('action' => 'jobs' , 'page' => $i, 'post_per_page' => $post_per_page);
                  $res = $this->getCurlRequest($this->url, $req);
              }

              if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){

                $dataArr = json_decode($res['response'], true);
                // echo '<pre>';print_r($dataArr);echo '</pre>';
                $data = $dataArr['data'];

                if( count($data) > 0 ){
                  
                  $insertArr = array();
                  $is_update = false;
                  $update_count = 0;

                  foreach ($data as $k => $val) {
                    $meta_data = $val['meta_data'];
                    
                    $is_archived = 1;
                    if( isset($meta_data['cs_job_status']) && !empty($meta_data['cs_job_status']) ){
                        if($meta_data['cs_job_status'] === 'active'){
                          $is_archived = 0;
                        }
                    }
                    $insertArr[$k]['archived'] = $is_archived;
                    echo "<br><br>";
                    echo "ID: ".$val['ID']. " - ". $meta_data['cs_job_status']. " - ". $is_archived;
                    try{ 
                      Post::withoutGlobalScopes()->where('wp_post_id', $val['ID'])->update($insertArr[$k]);
                      //If record is updated then remove from insert array
                      unset($insertArr[$k]);
                      $is_update = true;
                      $update_count++;
                    }
                    catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'wp_post_id' => $val['ID'],
                        'message' => $e->getMessage()
                      ]);
                      exit();
                    }                    
                  }
                }
              }
               
            }

            echo json_encode([
              'status' => 'true',
              'message' => "Records updated successfully"
            ]);           
            exit();

            
          }else{
            echo json_encode([
              'status' => 'true',
              'message' => "No record found!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "SSL certificate problem: unable to get local issuer certificate"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }

    /* Update user Birthdate */
    /* url = api/migrationApiRequest?action=update_user_birthdate&paged=1&user_type=model */
    public function updateUserBirthdate($request){

        if( isset($request['user_type']) && !empty($request['user_type']) ){
          
          if($request['user_type'] === 'partner'){
            $user_type = 'get_partners';
          }else{
            $user_type = 'get_models';
          }

        }else{
          die("missing parameter: user type");
        }

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        $req = array('action' => $user_type , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);

        //set infinite execution time for get more than 2000 records
        ini_set('max_execution_time', 0);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);
            
            $userList = array();

            if( isset($result['results']) && !empty($result['results']) && count($result['results'])>0 ){

                $userList = $result['results'];

                $i = 0;
                
                $tattoo_yes_arr = array();
                $tattoo_no_arr = array();
                $piercing_yes_arr = array();
                $piercing_no_arr = array();

                foreach ($userList as $key => $user) {

                  $birth_day = NULL;

                  if(isset($user['cs_birth_day']) && !empty($user['cs_birth_day'])){
                    $user['cs_birth_day'] = trim($user['cs_birth_day']);
                    if($user['cs_birth_day'] !== '1970-01-01' && $user['cs_birth_day'] !== '0000-00-00'){
                      $birth_day = date("Y-m-d", strtotime($user['cs_birth_day']));
                    }
                  }

                  if(isset($user['cs_tattoo']) && !empty($user['cs_tattoo'])){
                    if($user['cs_tattoo'] === 'yes'){
                      $tattoo_yes_arr[] = $user['user_id'];
                    }else{
                      $tattoo_no_arr[] = $user['user_id'];
                    }
                  }

                  if(isset($user['cs_piercing']) && !empty($user['cs_piercing'])){
                    if($user['cs_piercing'] === 'yes'){
                      $piercing_yes_arr[] = $user['user_id'];
                    }else{
                      $piercing_no_arr[] = $user['user_id'];
                    }
                  }

                  try{                    
                    
                    $update = DB::table('users as u')
                        ->Join('user_profile as up', 'u.id', '=', 'up.user_id')
                        ->where('u.wp_user_id', '=' , $user['user_id'])
                        ->update(['up.birth_day' => $birth_day]);
                    
                    $this->storeLog($this->update_log, 'Update', 'user_id => '.$user['user_id'].' Birthdate =>'.$birth_day);
                  }catch(\Exception $e){
                    echo $e->getMessage(); exit();
                  }                  
                }

                  try{                    
                    if( count($tattoo_yes_arr) > 0 ){
                         $update = DB::table('users as u')
                              ->Join('user_profile as up', 'u.id', '=', 'up.user_id')
                              ->whereIn('u.wp_user_id', $tattoo_yes_arr)
                              ->update(['up.tattoo' => 1]);
                      }
                  }catch(\Exception $e){
                    echo $e->getMessage(); exit();
                  }


                  try{                    
                    if( count($tattoo_no_arr) > 0 ){
                       $update = DB::table('users as u')
                            ->Join('user_profile as up', 'u.id', '=', 'up.user_id')
                            ->whereIn('u.wp_user_id', $tattoo_no_arr)
                            ->update(['up.tattoo' => 2]);
                    }
                  }catch(\Exception $e){
                    echo $e->getMessage(); exit();
                  }   
                  
                  try{                    
                    if( count($piercing_yes_arr) > 0 ){
                       $update = DB::table('users as u')
                            ->Join('user_profile as up', 'u.id', '=', 'up.user_id')
                            ->whereIn('u.wp_user_id', $piercing_yes_arr)
                            ->update(['up.piercing' => 1]);
                    }
                  }catch(\Exception $e){
                    echo $e->getMessage(); exit();
                  } 

                
                  try{                    
                    if( count($piercing_no_arr) > 0 ){
                       $update = DB::table('users as u')
                            ->Join('user_profile as up', 'u.id', '=', 'up.user_id')
                            ->whereIn('u.wp_user_id', $piercing_no_arr)
                            ->update(['up.piercing' => 2]);
                    }
                  }catch(\Exception $e){
                    echo $e->getMessage(); exit();
                  }
                

                die("records updated successfully");
            }
            else {
              die("results not found");
            }
        } else {
           die("Invalid request");
        }
    }

    public function updateJobCity($request){

      $page = '';
      $post_per_page = '';
      //$city_id = 0;

      $insertArr = array();
      
      $this->cityList = City::pluck('id', 'name')->toArray();
      $this->cityList = array_change_key_case($this->cityList, CASE_LOWER);

      if(count($request->all()) > 0){
        
        if(isset($request->post_per_page) && !empty($request->post_per_page)){
          
          $post_per_page = $request->post_per_page;
        }else{
            echo json_encode([
              'status' => 'false',
              'message' => "Invalid post_per_page key and value!"
            ]);

          exit();
        }

        if(isset($request->page) && !empty($request->page)){
          
        $page = $request->page;
        
        } else {
          echo json_encode([
              'status' => 'false',
              'message' => "Invalid page key and value!"
            ]);
          exit();
        }

        // call api model eye color 
        $req = array('action' => 'jobs' , 'page' => $page, 'post_per_page' => $post_per_page);
        $res = $this->getCurlRequest($this->url, $req);

        $total_records = 0;

        // check status is true
        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
         
          $dataArr = json_decode($res['response'], true);
          $data = $dataArr['data'];

          $total_records = $dataArr['total'];
          $total_pages = 1;

          if( ($total_records > 0) && $post_per_page != ''){
            if($total_records > $post_per_page){
              $total_pages = ceil( ( $total_records/$post_per_page) );
            }
          }

          if(count($data) > 0){

            $i = 0;
            $meta_data = array();
           
            for($i = 1; $i <= $total_pages; $i++) { 
               
              if($i != 1){
                // call api for get transaction param (action, page No) 
                  $req = array('action' => 'jobs' , 'page' => $i, 'post_per_page' => $post_per_page);
                  $res = $this->getCurlRequest($this->url, $req);
              }

              if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){

                $dataArr = json_decode($res['response'], true);
                // echo '<pre>';print_r($dataArr);echo '</pre>';
                $data = $dataArr['data'];

                if( count($data) > 0 ){
                 
                  foreach ($data as $k => $val) {
                    $meta_data = $val['meta_data'];
                    
                    // if( isset($meta_data['cs_post_loc_city']) && !empty($meta_data['cs_post_loc_city']) ){ 
                    //     $meta_data['cs_post_loc_city'] = strtolower(trim($meta_data['cs_post_loc_city']));
                    //     $city_id = (isset($this->cityList[$meta_data['cs_post_loc_city']]))? $this->cityList[$meta_data['cs_post_loc_city']] : '';
                    // }

                    // $insertArr[$k]['city_id'] = $city_id;
                    $insertArr[$k]['city'] = isset($meta_data['cs_post_loc_city'])? $meta_data['cs_post_loc_city'] : '';

                    try{ 
                      Post::withoutGlobalScopes()->where('wp_post_id', $val['ID'])->update($insertArr[$k]);
                      //If record is updated then remove from insert array
                      unset($insertArr[$k]);
                      $this->storeLog($this->update_log, 'Update', 'wp_post_id => '.$val['ID'].' City =>'.$insertArr[$k]['city']);
                    }
                    catch(\Exception $e){
                      echo json_encode([
                        'status' => 'false',
                        'wp_post_id' => $val['ID'],
                        'message' => $e->getMessage()
                      ]);
                      exit();
                    }                    
                  }
                }
              }
               
            }

            echo json_encode([
              'status' => 'true',
              'message' => "Records updated successfully"
            ]);           
            exit();

            
          }else{
            echo json_encode([
              'status' => 'true',
              'message' => "No record found!"
            ]);
            exit();
          }
        }else{
          echo json_encode([
              'status' => 'false',
              'message' => "SSL certificate problem: unable to get local issuer certificate"
            ]);
          exit();
        }
      }else{
        echo json_encode([
              'status' => 'false',
              'message' => "Invalid request data!"
            ]);
          exit();
      }
    }

    public function updateUserConversation(){
      
      //get all job applications and prepare data to isnert into messages table
      $conversationUsers = DB::table('job_applications as ja')->select('ja.post_id','u1.id as from_user_id','u1.name as from_name','u1.email as from_email','u1.phone as from_phone','u.id as to_user_id','u.name as to_name','u.email as to_email','u.phone as to_phone')
      ->LEFTJOIN('posts as p', 'p.id', '=', 'ja.post_id')
      ->LEFTJOIN('users as u', 'u.id', '=', 'p.user_id')
      ->LEFTJOIN('users as u1', 'u1.id', '=', 'ja.user_id')
      ->get()->toArray();

      // echo count($conversationUsers);die;

      if( isset($conversationUsers) && count($conversationUsers) > 0 ){

          // Message::truncate();

          $convertedArr = array();
          $index = 0;
          foreach ($conversationUsers as $key => $value) {
            //set missing values for messages table for job application type
            $convertedArr[$index] = (array)$value;
            $convertedArr[$index]['parent_id'] = 0;
            $convertedArr[$index]['message_type'] = 'Job application';
            $convertedArr[$index]['invitation_status'] = '1';
            $convertedArr[$index]['is_read'] = '1';
            $convertedArr[$index]['created_at'] = date('Y-m-d H:i:s');
            $convertedArr[$index]['subject'] = trans('mail.apply_for_job');
            $index++;

            //set missing values for messages table for conversation type
            $convertedArr[$index] = (array)$value;
            $convertedArr[$index]['parent_id'] = 0;
            $convertedArr[$index]['message_type'] = 'Conversation';
            $convertedArr[$index]['invitation_status'] = '1';
            $convertedArr[$index]['is_read'] = '1';
            $convertedArr[$index]['created_at'] = date('Y-m-d H:i:s');
            $convertedArr[$index]['subject'] = trans('mail.apply_for_job');
            $index++;

            // $conversationUsers[$key]->parent_id = 0;
            // $conversationUsers[$key]->message_type = 'Job application';
            // $conversationUsers[$key]->invitation_status = '1';
            // $conversationUsers[$key]->is_read = '1';
            // $conversationUsers[$key]->created_at = date('Y-m-d H:i:s');
            // $conversationUsers[$key]->subject = trans('mail.apply_for_job');

            // array_push($convertedArr, (array)$conversationUsers[$key]);
          }

          if(isset($convertedArr) && count($convertedArr) > 0 ){
            try{
              $save = Message::insert($convertedArr);

              //update messages partner id
              $messages = DB::statement("UPDATE messages AS job JOIN messages AS msg ON msg.post_id = job.post_id AND msg.from_user_id = job.from_user_id AND msg.message_type = 'Conversation' SET msg.parent_id=job.id WHERE job.message_type IN( 'Job Application')");

              //store log file
              $this->storeLog($this->model_log, 'Info', 'Store user inviations'); 
              echo json_encode([
                'status' => 'true',
                'error' => "",
                'message' => 'Store user inviations',
              ]);
            }
            catch(\Exception $e){
                        
              echo json_encode([
                'status' => 'false',
                'error' => $e->getMessage(),
                'message' => 'Save user invitation error!',
              ]);

              exit();
            }
            $this->storeLog($this->update_log, 'Update', 'invitations inserted successfully');  
            echo json_encode([
                'status' => 'true',
                'error' => "",
                'message' => 'invitations inserted successfully',
              ]);
          }else{
            $this->storeLog($this->update_log, 'Update', 'records not converted to array');  
            echo json_encode([
                'status' => 'false',
                'error' => "",
                'message' => 'records not converted to array',
              ]);
          }
      }else{
        $this->storeLog($this->update_log, 'Update', 'Invitations not founds');
        echo json_encode([
                'status' => 'true',
                'error' => "",
                'message' => 'Invitations not founds',
              ]);
      }
    }
    public function updateUserContractExpire(){

      // SELECT post_date, post_id, id, user_id, transaction_status , transaction_amount from (select `p`.`post_date`, `p`.`post_id`, `p`.`id`, `posts`.`user_id`,p.transaction_status,p.transaction_amount  from `payments` as `p` 
      // inner join `posts` as `posts` on `p`.`post_id` = `posts`.`id`  
      // where `posts`.`user_id` is not null and `p`.`post_date` is not null AND posts.user_id IN (49743, 49786) 
      // order by posts.user_id, `p`.`post_date` DESC) tbl group BY user_id

        try{

          $sub = DB::table('payments as p')
            ->select('p.post_date', 'p.post_id', 'p.id', 'posts.user_id', 'p.transaction_status' , 'p.transaction_amount')
            ->Join('posts as posts', 'p.post_id', '=', 'posts.id')
            ->whereNotNull('posts.user_id')
            ->whereNotNull('p.post_date')
            ->where('p.transaction_status' , 'approved')
            ->orderBy('posts.user_id', 'DESC')
            ->orderBy('p.post_date','DESC');
      
          $query = DB::table( DB::raw("({$sub->toSql()}) as tbl") )
                  ->select('tbl.post_date', 'tbl.post_id', 'tbl.id', 'tbl.user_id', 'tbl.transaction_status' , 'tbl.transaction_amount', 'u.username', 'u.contract_expire_on')
                  ->Join('users as u', 'tbl.user_id', '=', 'u.id')
                  ->mergeBindings($sub)
                  ->groupBy('user_id');
          
          $query->update(['u.contract_expire_on' => DB::raw('tbl.post_date')]);

          echo json_encode([
                      'status' => 'true',
                      'message' => 'Records updated successfully'
                    ]);
            exit();
        }catch(\Exception $e){
            echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
            exit();
        }
    }

    public function returnClosestValue($array, $number){
      $closest = 0;
      foreach ($array as $item) {
        if ($closest === 0 || abs($number - $closest) > abs($item - $number)) {
           $closest = $item;
        }
      }
      return $closest;
    }

    public function updateJobsUnits(){

      $postedjobs = Post::get();

        if(isset($postedjobs) && !empty($postedjobs) && count($postedjobs) > 0 ){

            $UserDressSizeObj = New UserDressSizeOptions();
          
            $this->dressSizeKidsArr = $UserDressSizeObj->whereNotNull('at_unit_kids')->pluck('at_unit_kids', 'id')->toArray();

            $this->dressSizeKidsArr = array_map(
                function($str) {
                    return str_replace(' EU', '', $str);
                },
                $this->dressSizeKidsArr
            );

            $this->dressSizeMenArr = $UserDressSizeObj->whereNotNull('at_unit_men')->pluck('at_unit_men', 'id')->toArray();

            $this->dressSizeMenArr = array_map(
                function($str) {
                    return str_replace(' EU', '', $str);
                },
                $this->dressSizeMenArr
            );

            $this->dressSizeWomenArr = $UserDressSizeObj->whereNotNull('at_unit_women')->pluck('at_unit_women', 'id')->toArray();

            $this->dressSizeWomenArr = array_map(
                function($str) {
                    return str_replace(' EU', '', $str);
                },
                $this->dressSizeWomenArr
            );

            $this->wpModelCategory = ModelCategory::pluck('is_baby_model', 'id')->toArray();

            foreach ($postedjobs as $key => $job) {
              $jobArr = array();
              $id = $job->id;

              if(isset($job->dressSize_from) && !empty($job->dressSize_from) && isset($job->dressSize_to) && !empty($job->dressSize_to)){
              
                $gender = $job->gender_type_id;

                $model_category_id = isset($job->model_category_id)? explode(',', $job->model_category_id) : '';

                $is_baby_model = 0;
                $is_available_model = 0;


                if( is_array($model_category_id) ){
                  
                  foreach ($this->wpModelCategory as $m_key => $m_value) {

                    if(in_array($m_key, $model_category_id)){

                      if( isset($this->wpModelCategory[$m_key])){

                        if($this->wpModelCategory[$m_key] == 1){
                          $is_baby_model = 1;
                        }
                        
                        if($this->wpModelCategory[$m_key] == 0){
                          $is_available_model = 1;
                        }
                      }
                    }
                  }
                }

                $dress_kid_size_array = $dress_men_size_array = $dress_women_size_array= array();
                
                $clothing_size_arr = array();
                
                $clothing_size_max_range = '';
                $clothing_size_min_range = '';

                $dressSize_min_range = ($job->dressSize_from != "") ? $job->dressSize_from : '';

                $dressSize_max_range = ($job->dressSize_to != "") ? $job->dressSize_to : '';
                
                if( $is_baby_model == 1 ){

                  $dressSize_kid_min_range = $this->returnClosestValue($this->dressSizeKidsArr, $dressSize_min_range);

                  $dressSize_kid_max_range = $this->returnClosestValue($this->dressSizeKidsArr, $dressSize_max_range);


                  if( $dressSize_kid_min_range != 0 && $dressSize_kid_max_range != 0 ) {
                    foreach ($this->dressSizeKidsArr as $key => $dressSize) {
                      if($dressSize >= $dressSize_kid_min_range && $dressSize <= $dressSize_kid_max_range)
                        {
                          $dress_kid_size_array[] = $key;
                        }
                    }
                  }

                  if( isset($dress_kid_size_array) && count($dress_kid_size_array) > 0 ){
                    $jobArr['dress_size_baby'] = implode(',', $dress_kid_size_array);
                  }
                  
                }

                if( $is_available_model == 1 ){


                  if(isset($gender) && ( $gender == config('constant.gender_male') || $gender == 0) ){
                    
                    $dressSize_men_min_range = $this->returnClosestValue($this->dressSizeMenArr, $dressSize_min_range);
                  
                    $dressSize_men_max_range = $this->returnClosestValue($this->dressSizeMenArr, $dressSize_max_range);

                    if( $dressSize_men_min_range != 0 && $dressSize_men_max_range != 0 ) {
                      foreach ($this->dressSizeMenArr as $key => $dressSize) {
                        if($dressSize >= $dressSize_men_min_range && $dressSize <= $dressSize_men_max_range)
                          {
                            $dress_men_size_array[] = $key;
                          }
                      }
                    }

                    if( isset($dress_men_size_array) && count($dress_men_size_array) > 0 ){
                      $jobArr['dress_size_men']  = implode(',', $dress_men_size_array);
                    }

                  }

                  
                  
                  if(isset($gender) && ( $gender == config('constant.gender_female') || $gender == 0 )){
                    
                    $dressSize_women_min_range = $this->returnClosestValue($this->dressSizeWomenArr, $dressSize_min_range);
                
                    $dressSize_women_max_range = $this->returnClosestValue($this->dressSizeWomenArr, $dressSize_max_range);

                    if( $dressSize_women_min_range != 0 && $dressSize_women_max_range != 0 ) {
                      foreach ($this->dressSizeWomenArr as $key => $dressSize) {
                        if($dressSize >= $dressSize_women_min_range && $dressSize <= $dressSize_women_max_range)
                          {
                            $dress_women_size_array[] = $key;
                          }
                      }
                    }

                    if( isset($dress_women_size_array) && count($dress_women_size_array) > 0 ){
                      $jobArr['dress_size_women']  = implode(',', $dress_women_size_array);
                    }
                    
                  }

                }

                try{
                  post::find($id)->update($jobArr);
                } catch(\Exception $e){
                  echo json_encode([
                    'status' => 'false',
                    'term_id' => $job->id,
                    'message' => $e->getMessage()
                  ]); exit();
                }
             

              }

            }
            
        echo json_encode(['status' => 'true', 'message' => "Records updated successfully"]); exit();
      }
    }

    /* COPY US blog categories to UK */
    public function copyCategoryToLocale($request){

      $req = $request->all();

      $locale = 'en';

      if( isset($req) && isset($req['locale']) && !empty($req['locale']) ){
        
        $copy_locale = strtolower($req['locale']);

          if($locale == $copy_locale){
            echo json_encode([
              'status' => 'false',
              'message' => 'locale should not be default locale'
            ]); exit();
          }

          // get all category for english translation language
          $BlogCategoryUS = BlogCategory::withoutGlobalScopes()->where('translation_lang', $locale)->where('active', 1)->get()->toArray();

          // get all blog category for uk translation if exists then update it or insert new.
          $BlogCategoryUK = BlogCategory::withoutGlobalScopes()->where('translation_lang', $copy_locale)->pluck('id', 'translation_of')->toArray();

          if(isset($BlogCategoryUS) && !empty($BlogCategoryUS) && count($BlogCategoryUS) > 0 ){
              $newRecords = $updateRecords = 0;
              
              foreach ($BlogCategoryUS as $key => $blogcatus) {

                $blogcatObject = "";
                
                  if(isset($blogcatus['id']) && !array_key_exists($blogcatus['id'], $BlogCategoryUK)){
                      
                      $blogcatObject = new BlogCategory();
                      $blogcatObject->translation_lang = $copy_locale;
                      $blogcatObject->country_code = strtoupper($copy_locale);
                      $blogcatObject->translation_of = $blogcatus['id'];
                      $blogcatObject->name =  $blogcatus['name'];
                      $blogcatObject->slug =  $blogcatus['slug'].'-'.$copy_locale;
                      $blogcatObject->meta_title =  $blogcatus['meta_title'];
                      $blogcatObject->meta_description =  $blogcatus['meta_description'];
                      $blogcatObject->meta_keywords =  $blogcatus['meta_keywords'];
                      $blogcatObject->active =  $blogcatus['active'];
                      $blogcatObject->save();

                      $newRecords++;

                  }else{

                       $update = BlogCategory::withoutGlobalScopes()
                                    ->where('translation_of', $blogcatus['id'])
                                    ->where('translation_lang', $copy_locale)
                                    ->first();

                      if(isset($update) && !empty($update)){

                          $update->translation_lang = $copy_locale;
                          $update->country_code = strtoupper($copy_locale);
                          $update->translation_of = $blogcatus['id'];
                          $update->name =  $blogcatus['name'];
                          $update->slug =  $blogcatus['slug'].'-'.$copy_locale;
                          $update->meta_title =  $blogcatus['meta_title'];
                          $update->meta_description =  $blogcatus['meta_description'];
                          $update->meta_keywords =  $blogcatus['meta_keywords'];
                          $update->active =  $blogcatus['active'];
                          $update->save();
                      }

                      $updateRecords++;
                  } 
              }

              if($newRecords > 0 || $updateRecords > 0){
                echo json_encode([
                  'status' => 'true',
                  'message' => $newRecords. ' records inserted and '.$updateRecords.' records updated successfully'
                ]);
              }else{
                echo json_encode([
                  'status' => 'true',
                  'message' => 'New records not found'
                ]);
              }

          }else{
              echo json_encode([
                'status' => 'false',
                'message' => 'No records founds'
              ]);
          }

      }else{
          echo json_encode([
            'status' => 'false',
            'message' => 'locale should not be empty'
          ]); exit();
      }


    }

    /* COPY US blog tags to locale tags */
    public function copyTagToLocale($request){

      $req = $request->all();

      $locale = 'en';

      if( isset($req) && isset($req['locale']) && !empty($req['locale']) ){
        
        $copy_locale = strtolower($req['locale']);

          if($locale == $copy_locale){
            echo json_encode([
              'status' => 'false',
              'message' => 'locale should not be default locale'
            ]); exit();
          }

          // get all tags for english translation language
          $BlogTagUS = BlogTag::withoutGlobalScopes()->where('translation_lang', $locale)->get()->toArray();

          // get all blog tags for uk translation if exists then update it or insert new.
          $BlogTagUK = BlogTag::withoutGlobalScopes()->where('translation_lang', $copy_locale)->pluck('id', 'translation_of')->toArray();;

          if(isset($BlogTagUS) && !empty($BlogTagUS) && count($BlogTagUS) > 0 ){
              $newRecords = $updateRecords = 0;
              
              foreach ($BlogTagUS as $key => $blogtagus) {

                $blogtagObject = "";
                
                  if(isset($blogtagus['id']) && !array_key_exists($blogtagus['id'], $BlogTagUK)){
                      
                      $blogtagObject = new BlogTag();

                      $blogtagObject->translation_lang = $copy_locale;
                      $blogtagObject->translation_of = $blogtagus['id'];
                      $blogtagObject->tag =  $blogtagus['tag'].'-'.$copy_locale;
                      $blogtagObject->slug =  $blogtagus['slug'].'-'.$copy_locale;
                      $blogtagObject->meta_title =  $blogtagus['meta_title'];
                      $blogtagObject->meta_description =  $blogtagus['meta_description'];
                      $blogtagObject->meta_keywords =  $blogtagus['meta_keywords'];
                      $blogtagObject->save();

                      $newRecords++;
                  } else {

                    $update = BlogTag::withoutGlobalScopes()
                                  ->where('translation_of', $blogtagus['id'])
                                  ->where('translation_lang', $copy_locale)
                                  ->first();

                    if(isset($update) && !empty($update)){

                        $update->translation_of = $blogtagus['id'];
                        $update->tag =  $blogtagus['tag'].'-'.$copy_locale;
                        $update->slug =  $blogtagus['slug'].'-'.$copy_locale;
                        $update->meta_title =  $blogtagus['meta_title'];
                        $update->meta_description =  $blogtagus['meta_description'];
                        $update->meta_keywords =  $blogtagus['meta_keywords'];
                        $update->save();
                    }

                    $updateRecords++;

                  } 
              }

              if($newRecords > 0 || $updateRecords > 0){
                echo json_encode([
                  'status' => 'true',
                  'message' => $newRecords. ' records inserted and '.$updateRecords.' records updated successfully'
                ]);
              }else{
                echo json_encode([
                  'status' => 'true',
                  'message' => 'New records not found'
                ]);
              }

          }else{
              echo json_encode([
                'status' => 'false',
                'message' => 'No records founds'
              ]);
          }

          

      }else{
          echo json_encode([
            'status' => 'false',
            'message' => 'locale should not be empty'
          ]); exit();
      }

      

    }

    // blog us to locale translation
    public function copyBlogToLocale($request){

      $req = $request->all();
      $locale = 'en';

      if( isset($req) && isset($req['locale']) && !empty($req['locale']) ){
        
        $copy_locale = strtolower($req['locale']);

          if($locale == $copy_locale){
            echo json_encode([
              'status' => 'false',
              'message' => 'locale should not be default locale'
            ]); exit();
          }

          // get all blogEntry records
          $getAllBlogs = BlogEntry::withoutGlobalScopes()->where('translation_lang' , $locale)->whereNull('deleted_at')->get()->toArray();

          // get all blog uk language
          $getAllBlogsLocale = BlogEntry::withoutGlobalScopes()->where('translation_lang' , $copy_locale)->pluck('translation_lang', 'translation_of')->toArray();

          // get all blog tags to entry [entry_id] => 'tag_id'
          // $getBlogTagsToEntry = BlogTagsToEntry::get()->toArray();

          //  echo "<pre>";  print_r($getBlogTagsToEntry);  "</pre>"; exit(); 
          
          $ukInsertArray = array();
          $ukUpdateArray = array();
          // $i = 0;

          if(!empty($getAllBlogs) && count($getAllBlogs) > 0){
            
            foreach ($getAllBlogs as $key => $value) {
                
                $blogArray['translation_lang'] = $copy_locale;
                $blogArray['post_author'] = $value['post_author'];
                $blogArray['translation_of'] = $value['id'];
                $blogArray['name'] = $value['name'];
                $blogArray['category_id'] = $value['category_id'];
                $blogArray['picture'] = $value['picture'];
                $blogArray['short_text'] = $value['short_text'];
                $blogArray['long_text'] = $value['long_text'];
                $blogArray['slug'] = $value['slug'].'-'.$copy_locale;
                $blogArray['meta_title'] = $value['meta_title'];
                $blogArray['meta_description'] = $value['meta_description'];
                $blogArray['meta_keywords'] = $value['meta_keywords'];
                $blogArray['active'] = $value['active'];
                $blogArray['featured'] = $value['featured'];
                $blogArray['start_date'] = $value['start_date'];
                $blogArray['created_at'] = date('Y-m-d H:i:s');
                $blogArray['updated_at'] = date('Y-m-d H:i:s');

                $localeTags = DB::select('select bt.tag_id, bt.entry_id, tag.id as locale_tag_id from blog_tags_to_entries bt join blog_tags tag on tag.translation_of=bt.tag_id and tag.translation_lang=? where bt.entry_id=?' , [$copy_locale, $value['id']]);

                $BlogCategoryLocale = BlogCategory::select('id')->withoutGlobalScopes()->where('translation_lang', $copy_locale)->where('translation_of', $value['category_id'])->first();

                if(!empty($BlogCategoryLocale) && $BlogCategoryLocale->count() > 0){
                  
                  $blogArray['category_id'] = $BlogCategoryLocale->id;
                }
              
              if(!isset($getAllBlogsLocale[$value['id']])){ 

                $blogInfo = BlogEntry::insertGetId($blogArray);
                $tagsInsertArr = array();
                $t = 0;
                if(!empty($localeTags) && count($localeTags) > 0){
                    
                  foreach ($localeTags as $v) {
                    
                    $tagsInsertArr[$t]['tag_id'] = $v->locale_tag_id;
                    $tagsInsertArr[$t]['entry_id'] = $blogInfo;
                    $t++;
                  }

                  $blogInfo = BlogTagsToEntry::insert($tagsInsertArr);
                }
              }else{
                // get blog
                $update = BlogEntry::where('translation_lang' , $copy_locale)->where('translation_of', $value['id'])->first(); 
                
                $slug = $value['slug'].'-'.$copy_locale;
                $category_id = $blogArray['category_id'];
                
                $getExistLocaleTags = array();

                if(isset($update->id) && $update->id){

                // update blog
                $blogParentUpdate = DB::table('blog_entries')
                                            ->where('id', '=' , $update->id)
                                            ->update(['post_author' => $value['post_author'], 'name' => $value['name'], 'category_id' => $category_id, 'picture' => $value['picture'], 'short_text' => $value['short_text'], 'long_text' => $value['long_text'], 'slug' => $slug, 'meta_title' => $value['meta_title'], 'meta_description' => $value['meta_description'], 'meta_keywords' => $value['meta_keywords'], 'active' => $value['active'], 'featured' => $value['featured'], 'start_date' => $value['start_date'], 'updated_at' => date('Y-m-d H:i:s') ]);
                // get BlogTagsToEntry
                $getExistLocaleTags = BlogTagsToEntry::where('entry_id', $update->id)->pluck('entry_id', 'tag_id')->toArray();

                }


                $tagsInsertArr = array();
                $t = 0;
                if(!empty($localeTags) && count($localeTags) > 0){
                    
                  foreach ($localeTags as $v) {
                    
                    // uk tags not exist in BlogTagsToEntry table 
                    if(!empty($getExistLocaleTags) && !isset($getExistLocaleTags[$v->locale_tag_id])) {
                      
                      $tagsInsertArr[$t]['tag_id'] = $v->locale_tag_id;
                      $tagsInsertArr[$t]['entry_id'] = $update->id;
                      $t++;
                    }
                  }
                  
                  if(!empty($tagsInsertArr) && count($tagsInsertArr) > 0){
                    // insert new BlogTagsToEntry
                    BlogTagsToEntry::insert($tagsInsertArr);
                  }
                }
              }
            }
          }
          die("blog migration completed");
          

      }else{
          echo json_encode([
            'status' => 'false',
            'message' => 'locale should not be empty'
          ]); exit();
      }
      
      
    }

    public function copyBlogDeToEn()
    {
        DB::statement( "ALTER TABLE `blog_categories` ADD `de_trans_id` INT(11) NULL AFTER `deleted_at`;" );

        DB::statement( "insert into blog_categories (translation_lang, country_code, translation_of, name, slug, meta_title, meta_description, meta_keywords, active, created_at, updated_at, de_trans_id) ( SELECT 'en', 'US', translation_of, name, slug, meta_title, meta_description, meta_keywords, active, created_at, updated_at, id FROM `blog_categories` where translation_lang='de' and translation_of=0 );" );

        DB::statement( "update `blog_categories` as de_trans join blog_categories as en_trans on en_trans.de_trans_id=de_trans.id set de_trans.translation_of=en_trans.id where de_trans.translation_lang='de' ;" );

        DB::statement( "ALTER TABLE `blog_tags` ADD `de_trans_id` INT(11) NOT NULL AFTER `deleted_at`;" );

        DB::statement( "insert into blog_tags (translation_lang, translation_of, tag, slug, meta_title, meta_description, meta_keywords, created_at, updated_at, de_trans_id) 
          ( SELECT 'en', 0, tag, slug, meta_title, meta_description, meta_keywords, now(), now(), id FROM `blog_tags` where translation_lang='de' and translation_of=0  );" );

        DB::statement( "update blog_tags as de_trans 
          join blog_tags as en_trans on en_trans.de_trans_id=de_trans.id
          set de_trans.translation_of=en_trans.id
          where de_trans.translation_lang='de';" );

        DB::statement( "ALTER TABLE `blog_entries` ADD `de_trans_id` INT(11) NULL AFTER `deleted_at`;;" );

        DB::statement( "INSERT into blog_entries (translation_lang, country_code, translation_of, name, category_id, picture, thumbnails, short_text, long_text, slug, meta_title, meta_description, meta_keywords, active, start_date, de_trans_id)
          ( SELECT 'en', 'US', 0, name, category_id, picture, thumbnails, short_text, long_text, slug, meta_title, meta_description, meta_keywords, active, start_date, id FROM `blog_entries` where translation_lang='de' and translation_of=0 );" );

        DB::statement( "update `blog_entries` as de_trans 
          join blog_entries as en_trans on en_trans.de_trans_id=de_trans.id 
          set de_trans.translation_of=en_trans.id 
          WHERE de_trans.`translation_lang` = 'de' and de_trans.translation_of=0;" );
    }
    
    // blog slug replace space to dash
    public function blogSlugReplaceSpaceToDash(){
      
      DB::statement("UPDATE blog_entries SET slug = LOWER(REPLACE(slug , ' ', '-'))");
      die("slug update successfully");
    }

    // deleted category replace to active "bodyandsoul"
    public function blogCategoryDeletedToNull(){
      
      DB::statement("UPDATE blog_categories SET deleted_at = NULL where slug = 'bodyandsoul' or slug = 'bodyandsoul-de' or slug = 'bodyandsoul-uk'");
      die("blog category update successfully");
    }


    public function copyPagesUsToUK(){

      try{

          DB::statement(" insert into pages (translation_lang, translation_of, type, name, slug, page_slug, title, picture, content, external_link, name_color, title_color, target_blank, excluded_from_footer, page_layout, active, created_at, updated_at)
          ( SELECT 'uk', id, type, name, slug, page_slug, title, picture, content, external_link, name_color, title_color, target_blank, excluded_from_footer, page_layout, active, now(), now() 
          FROM pages  where translation_lang='en'  and id not in (SELECT translation_of FROM pages where translation_lang='uk')) ");
          
        }catch(\Exception $e){
            echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
            exit();
        }

        try{

          DB::statement(" update pages as uk 
            join pages as us on us.id=uk.translation_of
            set uk.type = us.type, uk.name = us.name, uk.slug = us.slug, uk.page_slug = us.page_slug, uk.title = us.title, uk.picture = us.picture, uk.content = us.content, uk.external_link = us.external_link, uk.name_color = us.name_color, uk.title_color = us.title_color, uk.target_blank = us.target_blank, uk.excluded_from_footer = us.excluded_from_footer, uk.page_layout = us.page_layout, uk.active = us.active 
            where uk.translation_lang='uk' ");
          
        }catch(\Exception $e){
            echo json_encode([
                      'status' => 'false',
                      'message' => $e->getMessage()
                    ]);
            exit();
        }
      
        echo json_encode([ 'status' => 'true', 'message' => 'New pages inserted as well as existing pages are updated successfully' ]);
        exit();
      
    }

    public function getModelsSedcardImages()
    {
        $req = array('action' => 'get_models_sedcardimages' , 'paged' => 1);

        $res = $this->getCurlRequest($this->url, $req);

        $data = array();
        if( $res['status'] == true ){
          echo $data = $res['response'];
          exit();
        } else {
          echo json_encode([
              'status' => 'error',
              'message' => "SSL certificate problem: unable to get local issuer certificate"
            ]);
          exit();
        }
    }

    /* Update user Birthdate */
    /* url = api/migrationApiRequest?action=update_user_email&paged=1&user_type=model */
    public function updateUserEmail($request){

        if( isset($request['user_type']) && !empty($request['user_type']) ){
          
          if($request['user_type'] === 'partner'){
            $user_type = 'get_partners';
          }else{
            $user_type = 'get_models';
          }

        }else{
          die("missing parameter: user type");
        }

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        $req = array('action' => $user_type , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);

        //set infinite execution time for get more than 2000 records
        ini_set('max_execution_time', 0);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);
            
            $userList = array();

            if( isset($result['results']) && !empty($result['results']) && count($result['results'])>0 ){

                $userList = $result['results'];

                $i = 0;

                foreach ($userList as $key => $user) {

                  $email = NULL;

                  if(isset($user['email']) && !empty($user['email'])){
                    $email = trim($user['email']);
                  }

                  try{
                    $update = DB::table('users as u')
                        ->where('u.wp_user_id', '=' , $user['user_id'])
                        ->update(['u.email' => $email]);
                    
                    $this->storeLog($this->update_log, 'Update', 'user_id => '.$user['user_id'].' email =>'.$email);
                  }catch(\Exception $e){
                    echo $e->getMessage(); exit();
                  }                  
                }
                die("records updated successfully");
            }
            else {
              die("results not found");
            }
        } else {
           die("Invalid request");
        }
    }

    /* Update user chest, waist and hips */
    /* url = api/migrationApiRequest?action=update_user_chest_waist_hips&paged=1&user_type=model */
    public function updateUserChestWaistHips($request){

        // get all existing chest
        $chestListArr = UserChestUnitOptions::pluck('at_unit', 'id')->toArray();
        $this->chestListArr = preg_replace("/cm/", " ", $chestListArr);

        // get all existing waist 
        $waistListArr = UserWaistUnitOptions::pluck('at_unit', 'id')->toArray();
        $this->waistListArr = preg_replace("/cm/", " ", $waistListArr);

        // get all existing hips 
        $hipsListArr = UserHipsUnitOptions::pluck('at_unit', 'id')->toArray();
        $this->hipsListArr = preg_replace("/cm/", " ", $hipsListArr);

        if( isset($request['user_type']) && !empty($request['user_type']) ){
          
          if($request['user_type'] === 'partner'){
            $user_type = 'get_partners';
          }else{
            $user_type = 'get_models';
          }

        }else{
          die("missing parameter: user type");
        }

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        $req = array('action' => $user_type , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);

        //set infinite execution time for get more than 2000 records
        ini_set('max_execution_time', 0);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);

            $userList = array();

            if( isset($result['results']) && !empty($result['results']) && count($result['results'])>0 ){

                $userList = $result['results'];

                $i = 0;
                
                $chest_id = $waist_id = $hips_id = 1;

                foreach ($userList as $key => $user) {

                  if(isset($user['cs_size'])){
              
                    if(!empty($user['cs_size'])){
                      
                      $cs_size = explode('-', $user['cs_size']);

                      $chest_id = (isset($cs_size[0]))? $cs_size[0] : 1;
                      $waist_id = (isset($cs_size[1]))? $cs_size[1] : 1;
                      $hips_id = (isset($cs_size[2]))? $cs_size[2] : 1;
                    }

                    if(!empty($chest_id)){ 
                      $chest_id = (array_search((int) $chest_id, $this->chestListArr))? array_search((int) $chest_id, $this->chestListArr) : $chest_id;
                    }

                    if(!empty($modelProfile->waist_id)){ 
                      $waist_id = (array_search((int) $waist_id, $this->waistListArr))? array_search((int) $waist_id, $this->waistListArr) : $waist_id;
                    }

                    if(!empty($modelProfile->hips_id)){ 
                      $hips_id = (array_search((int) $hips_id, $this->hipsListArr))? array_search((int) $hips_id, $this->hipsListArr) : $hips_id;
                    }
                  }

                  try{
                    $update = DB::table('users as u')
                        ->join('user_profile as up', 'u.id', '=', 'up.user_id')
                        ->where('u.wp_user_id', '=' , $user['user_id'])
                        ->update(['up.chest_id' => $chest_id, 'up.waist_id' => $waist_id, 'up.hips_id' => $hips_id]);
                    
                    $this->storeLog($this->update_log, 'Update', 'user_id => '.$user['user_id'].' c-w-h =>'.$chest_id.'-'.$waist_id.'-'.$hips_id);

                  }catch(\Exception $e){
                    echo $e->getMessage(); exit();
                  }                  
                }
                die("records updated successfully");
            }
            else {
              die("results not found");
            }
        } else {
           die("Invalid request");
        }
    }

    /* Update user last_login */
    /* url = api/migrationApiRequest?action=update_user_last_login_at&paged=1&user_type=model */
    public function updateLastLoginAt($request){
      
        if( isset($request['user_type']) && !empty($request['user_type']) ){
          
          if($request['user_type'] === 'partner'){
            $user_type = 'get_partners';
          }else{
            $user_type = 'get_models';
          }

        }else{
          die("missing parameter: user type");
        }

        if( isset($request['paged']) && !empty($request['paged']) ){
          $paged = $request['paged'];
        }else{
          die("missing parameter: paged");
        }

        $req = array('action' => $user_type , 'paged' => $paged);
        $res = $this->getCurlRequest($this->url, $req);

        //set infinite execution time for get more than 2000 records
        ini_set('max_execution_time', 0);

        if( isset($res['status']) && $res['status'] == true && !empty($res['response'])){
            
            $result = json_decode($res['response'], true);
            
            $userList = array();

            if( isset($result['results']) && !empty($result['results']) && count($result['results'])>0 ){

                $userList = $result['results'];

                $i = 0;

                foreach ($userList as $key => $user) {

                  $last_update = NULL;
                  $last_login_at = "";
                  
                  // if user type is partner then look into user_last_login fields 
                  if($request['user_type'] === 'partner'){

                    if(isset($user['user_last_login']) && !empty($user['user_last_login'])){
                      $last_update = trim($user['user_last_login']);
                    }

                    if( isset($last_update) && !empty($last_update) ){
                      $last_login_at = date('Y-m-d H:i:s', $last_update); 
                    }

                  }else{

                    // if user type is model then look into last_update fields

                    if(isset($user['last_update']) && !empty($user['last_update'])){
                      $last_update = trim($user['last_update']);
                    }

                    if( isset($last_update) && !empty($last_update) ){
                      $last_login_at = date('Y-m-d H:i:s', $last_update); 
                    }
                  }
                  
                  

                  try{

                    if($last_login_at != ""){
                      $update = DB::table('users as u')
                          ->where('u.wp_user_id', '=' , $user['user_id'])
                          ->update(['u.last_login_at' => $last_login_at]);
                      
                      $this->storeLog($this->update_log, 'Update', 'user_id => '.$user['user_id'].' last_login_at =>'.$last_login_at);
                    }
                    
                  }catch(\Exception $e){
                    echo $e->getMessage(); exit();
                  }                  
                }
                die("records updated successfully");
            }
            else {
              die("results not found");
            }
        } else {
           die("Invalid request");
        }
    }



    /* Update user active_new as 1 if exits in wordpres data */
    /* url = api/migrationApiRequest?action=update_user_active_new&paged=1&user_type=model */
    public function updateActiveNew($request){

      //$wpusers1 = DB::table('csv_table_new')->select(DB::raw('LOWER(wpusername) as wpusername, go_code, profile_id'))->get()->toArray();

      // get all active users username and go-code
      $wpusers = DB::table('csv_table_new')->pluck(DB::raw('LOWER(wpusername) as wpusername'), 'go_code')->toArray();

      $page = $request->get('paged');
      $user_type = $request->get('user_type');
      $per_page = 4000;
      $offset = ($page - 1) * $per_page;

      if( isset($user_type) && !empty($user_type) && $user_type === 'partner'){
        $user_type_id = 2;
      }else{
        $user_type_id = 3;
      }

      if(empty($page)){
        die("Page number not define");
      }

      if(isset($user_type_id) && !empty($user_type_id) && !empty($wpusers) ){
       
          $users = User::SELECT(DB::raw('id, wp_user_id, user_type_id, LOWER(username) as username, email'))
            ->where('user_type_id', $user_type_id)
            ->whereNotNull('wp_user_id')
            ->whereNotNull('email')
            ->skip($offset)
            ->take($per_page)
            ->get();

          if( isset($users) && !empty($users) ){

            $updateusers = array();
            $count = 0;
            foreach ($users as $key => $user) {
              if(array_search($user->username, $wpusers, true)){
                $updateusers[$count] = $user->id;
                $count++;
              }
            }

            if(isset($updateusers) && count($updateusers) > 0){
              
              try{
                $update = DB::table('users')->whereIn('id', $updateusers)
                    ->update(['active_new' => 1]);
                
              }catch(\Exception $e){
                echo $e->getMessage(); exit();
              }

              die(count($updateusers)." records update successfully");

            }else{
              die("results not found to update");
            }

          }else {
            die("results not found");
          }
         
      }else {
         die("Invalid request");
      }

    }



    /* find users whoes entry not found in the database
    /* url = api/migrationApiRequest?action=find_user_not_in_db&user_type=model */
    public function findUserNotInDb($request){

      // get all users username and id
      $users = DB::table('users')->pluck(DB::raw('LOWER(username) as username'), 'id')->toArray();

      // get all active users from wordpress username and go_code
      $wpusers = DB::table('csv_table_new')->pluck(DB::raw('LOWER(wpusername) as wpusername'), 'go_code')->toArray();


      if(isset($users) && !empty($users) && isset($users) && !empty($wpusers) ){
       
            $updateusers = array();
            $count = 0;
            
            foreach ($wpusers as $key => $name) {
              if(!array_search($name, $users, true)){
                $updateusers[$count]['go_code'] = $key;
                $updateusers[$count]['wpusername'] = $name;
                $count++;
              }
            }

            echo "<pre>"; print_r ($updateusers); echo "</pre>"; exit();
         
      }else {
         die("Invalid request");
      }

    }


    /* get all users from wordpress paid model table and update paid in current user table */
    /* url = api/migrationApiRequest?action=update_wp_payment_model&type=paid&user_type=model&paged=1 */
    public function updateWpModelPayment($request){

      $type = $request->get('type');

      //check type is paid then get all wordpress paid models list else get all free models
      if( isset($type) && !empty($type) && $type === 'paid'){
        
        // get all active users username and go-code
        $wpusers = DB::table('paid_model_csv')->pluck(DB::raw('LOWER(wpusername) as wpusername'), 'go_code')->toArray();

      }else{
        
        // get all active users username and go-code
        $wpusers = DB::table('csv_table_new')->where('profile_id', 1)->pluck(DB::raw('LOWER(wpusername) as wpusername'), 'go_code')->toArray();

      }

      $page = $request->get('paged');
      $user_type = $request->get('user_type');
      $per_page = 4000;
      $offset = ($page - 1) * $per_page;

      if( isset($user_type) && !empty($user_type) && $user_type === 'partner'){
        $user_type_id = 2;
      }else{
        $user_type_id = 3;
      }

      if(empty($page)){
        die("Page number not define");
      }

      if(isset($user_type_id) && !empty($user_type_id) && !empty($wpusers) ){
       
          $users = User::SELECT(DB::raw('id, wp_user_id, user_type_id, LOWER(username) as username, email'))
            ->where('user_type_id', 3)
            ->skip($offset)
            ->take($per_page)
            ->get();

          if( isset($users) && !empty($users) ){

            $updateusers = array();
            $count = 0;
            foreach ($users as $key => $user) {
              if(array_search($user->username, $wpusers, true)){
                $updateusers[$count] = $user->id;
                $count++;
              }
            }

            if(isset($updateusers) && count($updateusers) > 0){
              
              try{
                if( isset($type) && !empty($type) && $type === 'paid'){
                  $update = DB::table('users')->whereIn('id', $updateusers)
                      ->update(['active' => 1, 'subscribed_payment' => 'complete', 'subscription_type' => 'paid']);

                }else{
                  $update = DB::table('users')->whereIn('id', $updateusers)
                      ->update(['active' => 1, 'subscribed_payment' => 'complete', 'subscription_type' => 'free']);                  
                }
                
              }catch(\Exception $e){
                echo $e->getMessage(); exit();
              }

              die(count($updateusers)." records update successfully");

            }else{
              die("results not found to update");
            }

          }else {
            die("results not found");
          }
         
      }else {
         die("Invalid request");
      }

    }

    // blog slug replace charcter to keyWord. 
    public function blogSlugReplaceCharacter(){

      // get all blogEntry records
      $getAllBlogEntryslug = BlogEntry::withoutGlobalScopes()->whereNull('deleted_at')->pluck('slug','id')->toArray();

      foreach ($getAllBlogEntryslug as $getAllBlogEntryKey => $getSingleBlogslugValue) {

        $newBlogEntrySlug = \App\Helpers\CommonHelper::setSlugName($getSingleBlogslugValue);

        $updateBlogEntrySlug = BlogEntry::withoutGlobalScopes()->where('id', $getAllBlogEntryKey)->update(['slug' => $newBlogEntrySlug]);
       
        if($updateBlogEntrySlug == 1){
          echo "<pre>";
          echo "<br> Updated BlogEntry Id========>".$getAllBlogEntryKey."</br>";
          echo "<br> Updated BlogEntry slug========>".$newBlogEntrySlug."</br>";
          echo "</pre>";
        }else{
          echo "<pre>";
          echo "<br> ==== Error ====</br>";
          echo "<br> Error BlogEntry Id========>".$getAllBlogEntryKey."</br>";
          echo "<br> Error BlogEntry slug========>".$newBlogEntrySlug."</br>";
          echo "</pre>";
        }
      }

      // get all BlogCategory records
      $getAllBlogCategorySlug = BlogCategory::withoutGlobalScopes()->whereNull('deleted_at')->pluck('slug','id')->toArray();

      foreach ($getAllBlogCategorySlug as $getAllBlogCategoryKey => $getSingleBlogCategorySlug) {
 
        $newBlogCategorySlug = \App\Helpers\CommonHelper::setSlugName($getSingleBlogCategorySlug);

        $updateBlogCategorySlug = BlogCategory::withoutGlobalScopes()->where('id', $getAllBlogCategoryKey)->update(['slug' => $newBlogCategorySlug]);
      
        if($updateBlogCategorySlug == 1){
          echo "<pre>";
          echo "<br> Updated BlogCategory Id========>".$getAllBlogCategoryKey."</br>";
          echo "<br> Updated BlogCategory slug========>".$newBlogCategorySlug."</br>";
          echo "</pre>";
        }else{
          echo "<pre>";
          echo "<br> ==== Error ====</br>";
          echo "<br> Error BlogCategory Id========>".$getAllBlogCategoryKey."</br>";
          echo "<br> Error BlogCategory slug========>".$newBlogCategorySlug."</br>";
          echo "</pre>";
        }
      }

      // get all blogEntry records
      $getAllBlogTag = BlogTag::withoutGlobalScopes()->whereNull('deleted_at')->pluck('slug','id')->toArray();

      foreach ($getAllBlogTag as $getAllBlogTagKey => $getSingleBlogTagValue) {

        $newBlogTagSlug = \App\Helpers\CommonHelper::setSlugName($getSingleBlogTagValue);

        $updateBlogTagSlug = BlogEntry::withoutGlobalScopes()->where('id', $getAllBlogTagKey)->update(['slug' => $newBlogTagSlug]);
       
        if($updateBlogTagSlug == 1){
          echo "<pre>";
          echo "<br> Updated BlogTagSlug Id========>".$getAllBlogTagKey."</br>";
          echo "<br> Updated BlogTagSlug slug========>".$newBlogTagSlug."</br>";
          echo "</pre>";
        }else{
          echo "<pre>";
          echo "<br> ==== Error ====</br>";
          echo "<br> Error BlogTag Id========>".$getAllBlogTagKey."</br>";
          echo "<br> Error BlogTag slug========>".$newBlogTagSlug."</br>";
          echo "</pre>";
        }
      }
      die();
    }

    /**
      * Job translattion existing record translate language code like en,de,uk
      * Required param: action = jobs_translation, offset, limit
      * return Status with response
    */
    public function jobsTranslation($request){
      
      // get post
      $posts = DB::table('posts')
              ->select('id', 'title', 'description') 
              ->where('title', '!=' ,  "")
              ->whereNull('deleted_at')
              ->offset($request->offset)
              ->limit($request->limit)
              ->get();

      // if empty record redirct back
      if($posts->count() == 0){
        echo json_encode([
          'status' => 'false', 
          'message' => "Posts table record does not exist!"
        ]); exit();
      }
      
      // Copy-Paste for all languages
      $languages = Language::where('active', 1)->get();
      $insertArr = array();
      
      // google api key
      $google_cloud_translation_api_key = (config('app.google_cloud_translation_api_key')) ? config('app.google_cloud_translation_api_key') : '';
      
      // google translate object create
      $translate = new TranslateClient([
          'key' => $google_cloud_translation_api_key
      ]);

      $i = 0;

      // posts loop
      foreach ($posts as $key => $value) {
          
          $isTranslate = true;

          // default decatect language code.
          $result['languageCode'] = 'de';

          if(!empty($value->title)){
            
            // Detect the language of a string.
            $result = $translate->detectLanguage($value->title);
          }
          
          // delete already exist record
          $jobs = JobsTranslation::where('job_id', $value->id)->delete();
          
          // default value set title and description
          $description = $value->description;
          $title = $value->title;

          // language loop
          foreach ($languages as $lang) {
            
            $insertArr[$i]['translation_lang'] = $lang->abbr;
            $insertArr[$i]['job_id'] = $value->id;
            
            // check already translate current record.
            if($isTranslate == true){
              
              // check title content language. and set target language code
              if($result['languageCode'] != 'de'){
                
                $targetLangCode = 'de';
              }else{
                
                $targetLangCode = 'en';
              }

              try{

                $g_description['text'] = '';
                $g_title['text'] = '';
                
                if(!empty($description)){
                  
                  // description translate
                  $g_description = $translate->translate($description, [
                      'target' => $targetLangCode,
                  ]);
                }
                  
                if(!empty($title)){
                  
                  // title translate
                  $g_title = $translate->translate($title, [
                    'target' => $targetLangCode,
                  ]);
                }

              }catch(\Exception $e){

                echo json_encode([
                  'status' => 'false',
                  'term_id' => $value->id,
                  'message' => $e->getMessage()
                ]); exit();
              }
              
              $isTranslate = false;
            }

            $insertArr[$i]['title'] = $title;
            $insertArr[$i]['description'] = $description;

            switch ($lang->abbr) {
              case 'en':
                  if ($targetLangCode == 'en' ) {
                    $insertArr[$i]['title'] = $g_title['text'];
                    $insertArr[$i]['description'] = $g_description['text'];
                  } 
              break;
              case 'de':
                  if ($targetLangCode == 'de' ){
                    $insertArr[$i]['title'] = $g_title['text'];
                    $insertArr[$i]['description'] = $g_description['text'];
                  }
              break;
              case 'uk':
                  if ($targetLangCode == 'en' ) {
                    $insertArr[$i]['title'] = $g_title['text'];
                    $insertArr[$i]['description'] = $g_description['text'];
                  }
              break;
              
              default:
                # code...
                break;
            }
            $i ++;
          }
      } 
      
      // save jobs translation
      $saveJobTranslation = JobsTranslation::insert($insertArr);

      echo json_encode([
        'status' => 'true', 
        'message' => "Success"
      ]); exit();
    }

    /**
      * Curl: Admin new language active.
      * return Status with response.
    */
    // public function newActiveLanguageJobs($request){

    //   $translation_lang = $request->translation_lang;
    //   $targetLang = $request->targetLang;
    //   $defaultLanguage = $request->defaultLanguage;
    //   $offset = $request->offset;
    //   $limit = $request->limit;
      
    //   // get JobsTranslation by default language
    //   $jobsTranslation  =  jobsTranslation::select('job_id', 'title', 'description')->where('translation_lang', $defaultLanguage)->offset($offset)->limit($limit)->get();
      
    //   // if empty record redirct back
    //   if($jobsTranslation->count() == 0){
        
    //     echo json_encode([
    //       'status' => false, 
    //       'message' => "All record update successfully."
    //     ]); exit();
    //   }
      
    //   // google api key
    //   $google_cloud_translation_api_key = (config('app.google_cloud_translation_api_key')) ? config('app.google_cloud_translation_api_key') : '';
      
    //   // google translate object create
    //   $translate = new TranslateClient([
    //       'key' => $google_cloud_translation_api_key
    //   ]);

    //   $insertArr = array();
    //   $i = 0;

    //   // Current Activealed language any record exist count
    //   $CurrentLanguageExist = JobsTranslation::where('translation_lang', $translation_lang)->count();

    //   $getAllCurrentLanguageJobs = array();
      
    //   if($CurrentLanguageExist > 0){

    //     // Curent Activated language all record get
    //     $getAllCurrentLanguageJobs = JobsTranslation::where('translation_lang', $translation_lang)->pluck('id', 'job_id')->toArray();
    //   }
      
    //   // jobs translation loop
    //   foreach ($jobsTranslation as $jobs) {
        
    //     // check already record exist or not
    //     if(!isset($getAllCurrentLanguageJobs[$jobs->job_id])){
          
    //       $insertArr[$i]['translation_lang'] = $translation_lang;
    //       $insertArr[$i]['job_id'] = $jobs->job_id;
    //       $g_description['text'] = $jobs->description;
    //       $g_title['text'] = $jobs->title;
        
    //       try{
    //           if(!empty($jobs->description)){
                
    //             // description translate
    //             $g_description = $translate->translate($jobs->description, [
    //                 'target' => $targetLang,
    //             ]);
    //           }
    //           if(!empty($jobs->title)){
                  
    //             // title translate
    //             $g_title = $translate->translate($jobs->title, [
    //               'target' => $targetLang,
    //             ]);
    //           }
    //         }catch(\Exception $e){
              
    //           echo json_encode([
    //             'status' => false,
    //             'term_id' => $jobs->job_id,
    //             'message' => $e->getMessage()
    //           ]); exit();
    //         }
        
    //       $insertArr[$i]['title'] = $g_title['text'];
    //       $insertArr[$i]['description'] = $g_description['text'];
    //       $i++;
    //     }
    //   }
      
    //   // save jobs translation
    //   $saveJobTranslation = JobsTranslation::insert($insertArr);
    //   echo json_encode([
    //     'status' => true, 
    //     'message' => "Success"
    //   ]); exit();
    // }

    /**
      * Update time zone id US country users 
      * Required param: action = update_user_time_zone
      * return Status with response
    */
    public function updateUsersTimeZone($request){

      // get all US country user
      $usersObj = User::with('profile')->withoutGlobalScopes()
                  ->where('country_code', 'US')
                  // ->skip($request->from)
                  // ->take($request->to)
                  ->get();
      $updateCount = 0;
      foreach ($usersObj as $key => $user) {

        if($user->profile->timezone == 0 || $user->profile->timezone == ''){

          echo PHP_EOL ;
          echo PHP_EOL ;
          echo "=========== process starting for user_id ".$user->id." =============";
          $country_name = "United States";
          $country_code = "US";
          $longlat = array();
          // get lat long to address.
          $street = $user->profile->street;
          $zip = $user->profile->zip;
          $city_name = $user->profile->city;
          $address    = $street.", ".$zip.', '.$city_name.', '.$country_name;
          $longlat = array();
          $address = urlencode ($address);

          $googleurl = config('app.g_latlong_url');
          $google_api_key_maps = config('app.latlong_api');
          $google_timezone_api_url = config('app.google_timezone_api_url');
          $url = $googleurl.$address.'&sensor=false&language=en&components=country:'.$country_code.'&key='.$google_api_key_maps;
          
          // call google maps api
          $geocode = file_get_contents($url);
          $output = json_decode($geocode);

          // current timestamps
          $current_timestamp = strtotime("now");
          $dbTimeZoneId = 153;
          $timeZoneName = 'America/New_York';

          $is_call_timeZone_api = true;

          if ($output->status == 'OK'){
            
            $longlat[]= str_replace(",", ".", $output->results[0]->geometry->location->lat);
            $longlat[]= str_replace(",", ".", $output->results[0]->geometry->location->lng);

            foreach ($output->results as $result) {
          
              foreach($result->address_components as $addressPart) {

                if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
                    $longlat[] = $addressPart->long_name;
                else if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
                    $longlat[] = $addressPart->long_name;
                else if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
                          $longlat[] = $addressPart->long_name;
              }
            } 
          }
          else{
            echo PHP_EOL ;
            echo json_encode([
              'status' => 'false', 
              'message' => "Error : latitude longitude api call",
              'user_id' => $user->id,
            ]);
          }

          $geo_lat    =  isset($longlat[0])? strval($longlat[0]) : '';
          $geo_long   =  isset($longlat[1])? strval($longlat[1]) : '';
          $geo_city   =  isset($longlat[2])? $longlat[2] : '';
          $geo_state  =  isset($longlat[3])? $longlat[3] : '';
          $geo_country = $country_name;
          $geo_full = $street.", ".$zip.', '.$geo_city;

          if(isset($longlat[3])){

            echo PHP_EOL ;
            echo "=========== State Name ".$longlat[3]." =============";

            // if default time zone empty, get state wise timeZone in state table 
            $stateTimeZone = States::where('country_code', 'US')->where('state_name', $longlat[3])->first();

            if(!empty($stateTimeZone)){
              
              $dbTimeZoneId = $stateTimeZone->timeZone->id;
              $timeZoneName = $stateTimeZone->timeZone->time_zone_id;
              $is_call_timeZone_api = false;
            }
          }

          if($is_call_timeZone_api == true && $output->status == 'OK'){

            Log::info('google_timezone_api_url url', ['google_timezone_api_url url' => $google_timezone_api_url]);

            // Get Google TimeZone Api call url 
            $timeZoneUrl = $google_timezone_api_url.$longlat[0].','.$longlat[1].'&timestamp='.$current_timestamp.'&key='.$google_api_key_maps;
            Log::info('Timezone request url', ['Request url' => $timeZoneUrl]);

            // call google maps api, Get TimeZone
            $getTimeZoneApiCall = file_get_contents($timeZoneUrl);
            $getTimeZone = json_decode($getTimeZoneApiCall);

            echo PHP_EOL ;
            echo "======== timezone response : ".$getTimeZoneApiCall." =============";
            $is_timezone_api_call_success = false;
            if(!empty($getTimeZone)){
          
              if(isset($getTimeZone->status)){
                
                if($getTimeZone->status == 'OK'){
                  $is_timezone_api_call_success = true;
                  // get timezone by google time zone id
                  $dbTimeZone = TimeZone::where('time_zone_id', $getTimeZone->timeZoneId)->first();
                  
                  if(isset($dbTimeZone->id)){
                    
                    $dbTimeZoneId = $dbTimeZone->id;
                    $timeZoneName = $dbTimeZone->time_zone_id;

                    if(isset($longlat[3])){
                      // Save new timezone in state table
                      $states = array(
                        'country_code' => 'US',
                        'state_name' => $longlat[3],
                        'time_zone_id' => $dbTimeZone->id,
                      );
                      $statesObj = new States($states); 
                      $statesObj->save();
                    }
                  }
                }
              }
            }
            // check time zone api call success or fail
            if($is_timezone_api_call_success == false){
              echo PHP_EOL ;
                echo json_encode([
                  'status' => 'false', 
                  'message' => "Error : timezone api call",
                  'user_id' => $user->id,
                ]);
            }
          }
          
          // CRM API CALL
          $req_arr = array(
            'action' => 'update', //required
            'wpusername' => $user->username, // required api
            'timeZoneId' => $dbTimeZoneId,
            'timeZoneName' => $timeZoneName,
            'geo_lat' => $geo_lat,
            'geo_long' => $geo_long,
            'geo_city' => $city_name,
            'geo_state' => $geo_state,
            'geo_country' => $geo_country,
            'geo_full' => $geo_full,
          );

          Log::info('CRM timezone update Request Array', ['Request Array' => $req_arr]);

          $response = \App\Helpers\CommonHelper::go_call_request($req_arr);
          
          if ($response->getStatusCode() == 200) {
            echo PHP_EOL ;
            echo "=========== CRM API CALL SUCCESS =============";
          }else{
            echo PHP_EOL ;
            echo "=========== CRM API CALL FAIL =============";
          }

          $user->profile->timezone = $dbTimeZoneId;
          // Save
          $user->profile->save(); 

          echo PHP_EOL ;
          echo "=========== Update user_id ".$user->id." time_zone_id ".$dbTimeZoneId." =============";
          echo PHP_EOL ;
          echo "=========== END PROCESS USER ".$user->id." =============";
          echo "==========================================================================";
          echo PHP_EOL ;
          $updateCount++;
        } 
      }

      echo json_encode([
        'status' => 'true', 
        'message' => "Success",
        'total_user' => $usersObj->count(),
        'update_count' => $updateCount,
      ]); exit();
      
      // UK
      // DB::statement("UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 341 where `u`.`country_code` = 'UK' and `up`.`timezone` = 0");
      
      // // DE
      // DB::statement("UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 321 where `u`.`country_code` = 'DE' and `up`.`timezone` = 0");
      
      // // AT
      // DB::statement("UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 369 where `u`.`country_code` = 'AT' and `up`.`timezone` = 0");
      
      // // CH
      // DB::statement("UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 375 where `u`.`country_code` = 'CH' and `up`.`timezone` = 0");
      
      // // IE
      // DB::statement("UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 329 where `u`.`country_code` = 'IE' and `up`.`timezone` = 0");
      
      // // LI
      // DB::statement("UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 367 where `u`.`country_code` = 'LI' and `up`.`timezone` = 0"); 

      /*
      **** AT ****
      SELECT * FROM `users` AS `u` INNER JOIN `user_profile` AS `up` ON `u`.`id` = `up`.`user_id`   WHERE `u`.`country_code` = 'AT' AND `timezone` != 369 

      SELECT b.bug_text_id, os_build, project_id, user_type, wpusername, os, bt.address, bt.city, bt.zip, bt.geo_full, geo_city, geo_country, geo_state, timezone_id, timezone_name FROM `bugs_bug_table` b join bugs_bug_text_table bt on bt.id = b.bug_text_id where b.os_build='AT' and timezone_id != 369 order by b.id desc

      ##laravel change timezone_id
        UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 369 where `u`.`country_code` = 'AT'

      ##crm change timezone id
        UPDATE bugs_bug_text_table bt join `bugs_bug_table` b on bt.id = b.bug_text_id
        set timezone_id = 369, timezone_name='Europe/Vienna'
        where b.os_build='AT' and timezone_id != 369


      **** CH ****
      SELECT * FROM `users` AS `u` INNER JOIN `user_profile` AS `up` ON `u`.`id` = `up`.`user_id`   WHERE `u`.`country_code` = 'CH' AND `timezone` != 375 
      
      SELECT b.bug_text_id, os_build, project_id, user_type, wpusername, os, bt.address, bt.city, bt.zip, bt.geo_full, geo_city, geo_country, geo_state, timezone_id, timezone_name FROM `bugs_bug_table` b join bugs_bug_text_table bt on bt.id = b.bug_text_id where b.os_build='CH' and timezone_id != 375 order by b.id desc

      ##laravel change timezone_id
        UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 375 where `u`.`country_code` = 'CH'

      ##crm change timezone id
        UPDATE bugs_bug_text_table bt join `bugs_bug_table` b on bt.id = b.bug_text_id
        set timezone_id = 375, timezone_name='Europe/Zurich'
        where b.os_build='CH' and timezone_id != 375


      **** DE ****
      SELECT * FROM `users` AS `u` INNER JOIN `user_profile` AS `up` ON `u`.`id` = `up`.`user_id`   WHERE `u`.`country_code` = 'DE' AND `timezone` != 321 

      SELECT b.bug_text_id, os_build, project_id, user_type, wpusername, os, bt.address, bt.city, bt.zip, bt.geo_full, geo_city, geo_country, geo_state, timezone_id, timezone_name FROM `bugs_bug_table` b join bugs_bug_text_table bt on bt.id = b.bug_text_id where b.os_build='DE' and timezone_id != 321 order by b.id desc

      ##laravel change timezone_id
        UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 321 where `u`.`country_code` = 'DE'

      ##crm change timezone id
        UPDATE bugs_bug_text_table bt join `bugs_bug_table` b on bt.id = b.bug_text_id
        set timezone_id = 321, timezone_name='Europe/Berlin'
        where b.os_build='DE' and timezone_id != 321


      **** IE ****
      SELECT * FROM `users` AS `u` INNER JOIN `user_profile` AS `up` ON `u`.`id` = `up`.`user_id`   WHERE `u`.`country_code` = 'IE' AND `timezone` != 329 

      SELECT b.bug_text_id, os_build, project_id, user_type, wpusername, os, bt.address, bt.city, bt.zip, bt.geo_full, geo_city, geo_country, geo_state, timezone_id, timezone_name FROM `bugs_bug_table` b join bugs_bug_text_table bt on bt.id = b.bug_text_id where b.os_build='IE' and timezone_id != 329 order by b.id desc

      ##laravel change timezone_id
        UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 329 where `u`.`country_code` = 'IE'

      ##crm change timezone id
        UPDATE bugs_bug_text_table bt join `bugs_bug_table` b on bt.id = b.bug_text_id
        set timezone_id = 329, timezone_name='Europe/Dublin'
        where b.os_build='IE' and timezone_id != 329


      **** LI ****
      SELECT * FROM `users` AS `u` INNER JOIN `user_profile` AS `up` ON `u`.`id` = `up`.`user_id`   WHERE `u`.`country_code` = 'LI' AND `timezone` != 367 

      SELECT b.bug_text_id, os_build, project_id, user_type, wpusername, os, bt.address, bt.city, bt.zip, bt.geo_full, geo_city, geo_country, geo_state, timezone_id, timezone_name FROM `bugs_bug_table` b join bugs_bug_text_table bt on bt.id = b.bug_text_id where b.os_build='LI' and timezone_id != 367 order by b.id desc

      ##laravel change timezone_id
        UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 367 where `u`.`country_code` = 'LI'

      ##crm change timezone id
        UPDATE bugs_bug_text_table bt join `bugs_bug_table` b on bt.id = b.bug_text_id
        set timezone_id = 367, timezone_name='Europe/Vaduz'
        where b.os_build='LI' and timezone_id != 367


      **** UK ****
      SELECT * FROM `users` AS `u` INNER JOIN `user_profile` AS `up` ON `u`.`id` = `up`.`user_id`   WHERE `u`.`country_code` = 'UK' AND `timezone` != 341 

      SELECT b.bug_text_id, os_build, project_id, user_type, wpusername, os, bt.address, bt.city, bt.zip, bt.geo_full, geo_city, geo_country, geo_state, timezone_id, timezone_name FROM `bugs_bug_table` b join bugs_bug_text_table bt on bt.id = b.bug_text_id where b.os_build='UK' and timezone_id != 341 order by b.id desc

      ##laravel change timezone_id
        UPDATE `users` as `u` inner join `user_profile` as `up` on `u`.`id` = `up`.`user_id`  SET `timezone` = 341 where `u`.`country_code` = 'UK'

      ##crm change timezone id
        UPDATE bugs_bug_text_table bt join `bugs_bug_table` b on bt.id = b.bug_text_id
        set timezone_id = 341, timezone_name='Europe/London'
        where b.os_build='UK' and timezone_id != 341


      **** US ****

      SELECT wpusername, project_id, user_type, b.bug_text_id, os_build, bt.address, bt.city, bt.zip, bt.geo_full, geo_city, geo_country, geo_state, timezone_id, timezone_name FROM `bugs_bug_table` b join bugs_bug_text_table bt on bt.id = b.bug_text_id join time_zones on time_zones.id = timezone_id where b.os_build='US' and time_zones.country_code != 'US' order by b.id desc

      */
    }
}