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

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use App\Helpers\Localization\Helpers\Country as CountryHelper;
use Illuminate\Support\Str;

class Search {
	public $country;
	public $lang;
	public static $queryLength = 1; // Minimum query characters
	public static $distance = 100; // km
	public static $maxDistance = 500; // km
	public $perPage = 12;
	public $currentPage = 1;
	protected $table = 'posts';
	protected $searchable = [
		'columns' => [
			'j.title' => 10,
			'j.description' => 10,
			'cl.name' => 5,
			//'cl.description'  => 1,
			//'cpl.description' => 1,
		],
		'joins' => [
			'categories as category' => ['category.id', 'posts.category_id'],
			'categories as cp' => ['cp.id', 'category.parent_id'],
		],
	];
	public $forceAverage = true; // Force relevance's average
	public $average = 1; // Set relevance's average

	// Pre-Search vars
	public $city = null;
	public $admin = null;

	/**
	 * Ban this words in query search
	 * @var array
	 */
	//protected $banWords = ['sell', 'buy', 'vendre', 'vente', 'achat', 'acheter', 'ses', 'sur', 'de', 'la', 'le', 'les', 'des', 'pour', 'latest'];
	protected $banWords = [];
	protected $arrSql = [
		'select' => [],
		'join' => [],
		'where' => [],
		'groupBy' => [],
		'having' => [],
		'orderBy' => [],
	];
	protected $bindings = [];
	protected $sql = [
		'select' => '',
		'from' => '',
		'join' => '',
		'where' => '',
		'groupBy' => '',
		'having' => '',
		'orderBy' => '',
	];
	// Only for WHERE
	protected $filters = [
		'type' => 'post.post_type_id',
		'minSalary' => 'post.salary_min',
		'maxSalary' => 'post.salary_max',
		'postedDate' => 'post.created_at',
	];
	protected $orderMapping = [
		'salaryAsc' => ['name' => 'post.salary_max', 'order' => 'ASC'],
		'salaryDesc' => ['name' => 'post.salary_max', 'order' => 'DESC'],
		'relevance' => ['name' => 'relevance', 'order' => 'DESC'],
		'date' => ['name' => 'post.created_at', 'order' => 'DESC'],
	];

	/**
	 * Search constructor.
	 * @param array $preSearch
	 */
	public function __construct($preSearch = []) {
		
		$this->is_partner = false;
		$this->user_id = '';
		$this->partner_id = (isset($preSearch['partner_id'])? $preSearch['partner_id'] : '' );

		$this->height_id = (isset($preSearch['height_id'])? $preSearch['height_id'] : '' );
		$this->weight_id = (isset($preSearch['weight_id'])? $preSearch['weight_id'] : '' );
		$this->size_id = (isset($preSearch['size_id'])? $preSearch['size_id'] : '' );
		$this->shoes_size_id = (isset($preSearch['shoes_size_id'])? $preSearch['shoes_size_id'] : '' );
		$this->eye_color_id = (isset($preSearch['eye_color_id'])? $preSearch['eye_color_id'] : '' );
		$this->hair_color_id = (isset($preSearch['hair_color_id'])? $preSearch['hair_color_id'] : '' );
		$this->skin_color_id = (isset($preSearch['skin_color_id'])? $preSearch['skin_color_id'] : '' );
		$this->piercing = (isset($preSearch['piercing'])? $preSearch['piercing'] : '' );
		$this->model_category_id = (isset($preSearch['model_category_id'])? $preSearch['model_category_id'] : '' );
		$this->category_id = (isset($preSearch['category_id'])? $preSearch['category_id'] : '');

		$this->is_favourites = (isset($preSearch['is_favourites'])? $preSearch['is_favourites'] : '');

		$this->search_content = (isset($preSearch['search_content'])? $preSearch['search_content'] : '');
		$this->age = (isset($preSearch['age'])? $preSearch['age'] : '');

		$this->waist_id = (isset($preSearch['waist_id'])? $preSearch['waist_id'] : '' );
		$this->hips_id = (isset($preSearch['hips_id'])? $preSearch['hips_id'] : '' );
		$this->chest_id = (isset($preSearch['chest_id'])? $preSearch['chest_id'] : '' );

		$this->partner_category_id = (isset($preSearch['partner_category_id'])? $preSearch['partner_category_id'] : '' );
		$this->gender_id = (isset($preSearch['gender_id'])? $preSearch['gender_id'] : '' );

		$this->post_id = (isset($preSearch['post_id'])? $preSearch['post_id'] : '' );

		$this->is_baby_model = (isset($preSearch['is_baby_model'])? $preSearch['is_baby_model'] : false );
	 	
	 	// Pre-Search
		// if (isset($preSearch['city']) && !empty($preSearch['city'])) {
		// 	$this->city = $preSearch['city'];
		// }
		// if (isset($preSearch['admin']) && !empty($preSearch['admin'])) {
		// 	$this->admin = $preSearch['admin'];
		// }
		
		if (isset($preSearch['user_type']) && !empty($preSearch['user_type']) && $preSearch['user_type'] == config('constant.partner_type_id')) {
			$this->user_type = $preSearch['user_type'];
			$this->is_partner = true;
			$this->user_id = auth()->user()->id;
		}

		// Distance (Max & Default distance)
		//self::$maxDistance = config('settings.listing.search_distance_max', self::$maxDistance);
		//self::$distance = config('settings.listing.search_distance_default', self::$distance);

		// Ads per page
		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

		if (isset($preSearch['perpage']) && !empty($preSearch['perpage'])) {
			$this->perPage = $preSearch['perpage'];
		}
		
		// if ($this->perPage < 4) {
		// 	$this->perPage = 4;
		// }

		// if ($this->perPage > 40) {
		// 	$this->perPage = 40;
		// }

		// Init.
		array_push($this->banWords, strtolower(config('country.name')));
		$this->arrSql = Arr::toObject($this->arrSql);
		$this->sql = Arr::toObject($this->sql);
		$this->sql->select = '';
		$this->sql->from = '';
		$this->sql->join = '';
		$this->sql->where = '';
		$this->sql->groupBy = '';
		$this->sql->having = '';
		$this->sql->orderBy = '';

		// Build the global SQL
		// $this->arrSql->select[] = "post.*, country.name as country_name, city.name as city_name";
		$this->arrSql->select[] = "post.*, country.name as country_name, currencies.html_entity, currencies.font_arial, company.logo as company_logo, company.name as company_name, j.translation_lang, j.title, j.description, j.job_id";


		// left join to company table
		$this->arrSql->join[] = "LEFT JOIN " . table('jobs_translation') . " as j ON j.job_id = post.id AND j.translation_lang='".config('app.locale')."'";


		if(!empty($this->category_id) && $this->category_id != 0 && $this->category_id != null){
			
			// Post category relation
			$this->arrSql->join[] = "INNER JOIN " . table('categories') . " as category ON FIND_IN_SET(category.id, post.category_id) AND category.active=1";
		}
		// post user relation
		$this->arrSql->join[] = "INNER JOIN " . table('users') . " as user ON user.id = post.user_id AND user.active = 1 ";

		// left join to company table
		$this->arrSql->join[] = "LEFT JOIN " . table('companies') . " as company ON post.company_id = company.id";

		// FAVOURITES JOB RELATION
		if(!empty($this->is_favourites)){
			$this->arrSql->join[] = "INNER JOIN " . table('saved_posts') . " as sp ON sp.post_id = post.id AND sp.user_id = ".auth()->user()->id." ";
		}

		/* commented as category has not parent-child relation */
		// Category parent relation
		// $this->arrSql->join[] = "LEFT JOIN " . table('categories') . " as cp ON cp.id=c.parent_id AND cp.active=1";

		// Post payment relation
		// $this->arrSql->join[] = "LEFT JOIN " . table('payments') . " as py ON py.post_id=a.id";
		
		/* commented as job post is not having payment at a moment */
		// $this->arrSql->join[] = "LEFT JOIN (SELECT MAX(id) max_id, post_id FROM " . table('payments') . " WHERE active=1 GROUP BY post_id) mpy ON mpy.post_id = a.id AND a.featured=1";
		// $this->arrSql->join[] = "LEFT JOIN " . table('payments') . " as py ON py.id=mpy.max_id";
		// $this->arrSql->join[] = "LEFT JOIN " . table('packages') . " as p ON p.id=py.package_id";

		$this->arrSql->join[] = "LEFT JOIN " . table('countries') . " as country ON country.code = post.country_code ";

		// left join to currenct table
		$this->arrSql->join[] = "LEFT JOIN " . table('currencies') . " as currencies ON currencies.code = country.currency_code";

		// direct store city name in db so no need to join with city table
		//$this->arrSql->join[] = "LEFT JOIN " . table('cities') . " as city ON city.id = post.city_id ";
		
		$this->arrSql->where = [
			//'post.country_code' => " = :countryCode",
			' (post.verified_email' => " = 1 AND post.verified_phone = 1)",
			'post.archived' => " != 1",
			'post.deleted_at' => " IS NULL",
		];

		if(!empty($this->post_id)){
			// $this->arrSql->where[] = " ( post.id = ".$this->post_id." OR post.user_id = ".$this->user_id."  ) ";
			$this->arrSql->where['post.id'] = " = ".$this->post_id;
		}

		if (isset($preSearch['user_type']) && !empty($preSearch['user_type']) && $preSearch['user_type'] == config('constant.model_type_id')) {

			$model_where = [];

			if($this->height_id != ''){
				$model_where[] = "( (post.height_from = 0 OR post.height_from IS NULL OR post.height_to = 0 OR post.height_to IS NULL) OR ($this->height_id BETWEEN post.height_from and post.height_to) ) ";
			}

			if($this->weight_id != ''){
				$model_where[] = " ( (post.weight_from = 0 OR post.weight_from IS NULL OR post.weight_to = 0 OR post.weight_to IS NULL) OR (".$this->weight_id ." BETWEEN post.weight_from AND post.weight_to ) ) ";
			}

			if($this->size_id != ''){
				
				if($this->gender_id == config('constant.gender_male') && $this->is_baby_model == false ){
					$model_where[] = " ( ( post.dress_size_men = 0 OR post.dress_size_men IS NULL ) OR ( FIND_IN_SET(".$this->size_id.", post.dress_size_men) ) ) ";
				}

				if($this->gender_id == config('constant.gender_female') && $this->is_baby_model == false ){
					$model_where[] = " ( ( post.dress_size_women = 0 OR post.dress_size_women IS NULL ) OR ( FIND_IN_SET(".$this->size_id.", post.dress_size_women) ) ) ";
				}

				if($this->is_baby_model == true ){
					$model_where[] = " ( ( post.dress_size_baby = 0 OR post.dress_size_baby IS NULL ) OR ( FIND_IN_SET(".$this->size_id.", post.dress_size_baby) ) ) ";
				}
				
			}

			// if($this->size_id != ''){
			// 	$model_where[] = " (  (post.dressSize_from = 0 OR post.dressSize_from IS NULL OR post.dressSize_to = 0 OR post.dressSize_to IS NULL) OR (".$this->size_id." BETWEEN post.dressSize_from AND post.dressSize_to ) ) ";
			// }

			if($this->waist_id != ''){
				$model_where[] = " ( ( ".$this->waist_id." BETWEEN post.waist_from AND post.waist_to ) or (post.waist_from <= 0 and post.waist_to >= 0) ) ";
			}

			if($this->chest_id != ''){
				$model_where[] = " ( ( ".$this->chest_id." BETWEEN post.chest_from AND post.chest_to ) or (post.chest_from <= 0 and post.chest_to >= 0) ) ";
			}

			if($this->hips_id != ''){
				$model_where[] = " ( (".$this->hips_id." BETWEEN post.hips_from AND post.hips_to ) or (post.hips_from <= 0 and post.hips_to >= 0) ) ";
			}

			if($this->shoes_size_id != ''){

				if($this->gender_id == config('constant.gender_male') && $this->is_baby_model == false ){
					$model_where[] = " ( ( post.shoe_size_men = 0 OR post.shoe_size_men IS NULL ) OR ( FIND_IN_SET(".$this->shoes_size_id.", post.shoe_size_men) ) ) ";
				}

				if($this->gender_id == config('constant.gender_female') && $this->is_baby_model == false ){
					$model_where[] = " ( ( post.shoe_size_women = 0 OR post.shoe_size_women IS NULL ) OR ( FIND_IN_SET(".$this->shoes_size_id.", post.shoe_size_women) ) ) ";
				}

				if($this->is_baby_model == true ){
					$model_where[] = " ( ( post.shoe_size_baby = 0 OR post.shoe_size_baby IS NULL ) OR ( FIND_IN_SET(".$this->shoes_size_id.", post.shoe_size_baby) ) ) ";
				}
				
			}

			// if($this->shoes_size_id != ''){
			// 	$model_where[] = " ( (".$this->shoes_size_id." BETWEEN post.shoeSize_from AND post.shoeSize_to ) OR (post.shoeSize_from = 0 and post.shoeSize_to = 0)) ";
			// }

			if($this->eye_color_id != ''){
				$model_where[] = " ( post.eyeColor = ".$this->eye_color_id." or post.eyeColor IS NULL ) ";
			}

			if($this->hair_color_id != ''){
				$model_where[] = " ( post.hairColor = ".$this->hair_color_id." or post.hairColor IS NULL ) ";
			}

			if($this->skin_color_id != ''){
				$model_where[] = " ( post.skinColor = ".$this->skin_color_id." or post.skinColor IS NULL ) ";
			}

			if($this->age != ''){
				$model_where[] = " ( ".$this->age." BETWEEN post.age_from AND post.age_to ) ";
			}
			

			$where_cluase = "";
			if(count($model_where) > 0 ){
				$where_cluase = implode('AND', $model_where);
				$this->arrSql->where[] = " ( ".$where_cluase." ) ";
			}
			
			if( $this->model_category_id != "" ){
				$this->arrSql->where[] = " ( FIND_IN_SET($this->model_category_id, post.model_category_id) ) ";
			}
		} else {

			if( $this->partner_category_id != "" ){
				$this->arrSql->where[] = " ( FIND_IN_SET($this->partner_category_id, post.partner_category_id) ) ";
			}
		}

		$cat_model_where = array();


		if(!empty($this->category_id) && $this->category_id != 0 && $this->category_id != null){

 			$catArr = explode(',', $this->category_id);
 			foreach ($catArr as $catId) {
 				$cat_model_where[] = " ( FIND_IN_SET($catId , post.category_id) ) ";
 			}

 			if( count($cat_model_where) > 0 ){
 				$this->arrSql->where[] = " ( ".implode('OR', $cat_model_where)." ) ";
 			}
		}
		if(!empty($this->search_content)){
			$this->arrSql->where[] = "(j.title LIKE '%".$this->search_content."%' OR post.company_name LIKE '%".$this->search_content."%')";
		}
		
		if($this->is_partner) {
			$this->arrSql->where['post.ismodel'] = " = 0";
		}else{
			$this->arrSql->where['post.ismodel'] = " = 1";
		}


		if (isset($preSearch['user_type']) && !empty($preSearch['user_type']) && $preSearch['user_type'] == config('constant.model_type_id')) {
			//match if job is for model's gender or for all gender
			$this->arrSql->where[] = " ( post.gender_type_id = ".$this->gender_id." OR post.gender_type_id = 0 ) ";
		}
		
		//$this->bindings['countryCode'] = config('country.code');

		// Check reviewed ads
		if (config('settings.single.posts_review_activation')) {
			$this->arrSql->where['post.reviewed'] = " = 1";
		}

		if($this->partner_id != ''){
			$this->arrSql->where['post.user_id'] = " = ".$this->partner_id;
		}
		
		// Priority setter
		if (Request::filled('distance') and is_numeric(Request::input('distance')) and Request::input('distance') > 0) {
			self::$distance = Request::input('distance');
			if (Request::input('distance') > self::$maxDistance) {
				self::$distance = self::$maxDistance;
			}
		}
		if (Request::filled('orderBy')) {
			$this->setOrder(Request::input('orderBy'));
		}

		// Pagination Init.
		$this->currentPage = (Request::input('page') < 0) ? 0 : (int) Request::input('page');
		$page = (Request::input('page') <= 1) ? 1 : (int) Request::input('page');
		$this->sqlCurrLimit = ($page <= 1) ? 0 : $this->perPage * ($page - 1);
	}

	/**
	 * @param $sql
	 * @param array $bindings
	 * @return mixed
	 */
	public static function query($sql, $bindings = []) {
		// DEBUG
		// echo 'SQL<hr><pre>' . $sql . '</pre><hr>'; //exit();
		// echo 'BINDINGS<hr><pre>'; print_r($bindings); echo '</pre><hr>';

		try {
			$result = DB::select(DB::raw($sql), $bindings);
		} catch (\Exception $e) {
			$result = null;

			// DEBUG
			// dd($e->getMessage());
		}

		return $result;
	}

	/**
	 * @return array
	 */
	public function fetch() {

		$perPage = isset($this->perPage)? $this->perPage : 12;
		$is_last_page = 0;
		$count = $this->countPosts();
		$total = $count->get('all');

		if($this->currentPage > 1){
			
			$show_record = (Request::input('show_record')) ? Request::input('show_record') : 0;

			$page = $this->currentPage - 2;

			if($page <= 0){
				$page = 1;
			}

			$remaining_record = $show_record - ($page * $perPage);

			if($remaining_record < 0){
				$remaining_record = $remaining_record * (-1);
			}else if ($remaining_record == 0) {
				$remaining_record = $perPage;
				// $this->currentPage = $this->currentPage - 1;
			}
			$totalRecord = $show_record + $remaining_record;
			$curent_page = $totalRecord  / $perPage;
			$this->currentPage = ceil($curent_page);

			// echo "remaining_record :". $remaining_record;
			// echo "<br />";
			// echo "total :". $total;
			// echo "<br />";
			// echo "totalRecord : ".$totalRecord;
			// echo "<br />";
			// echo "curent_page : ".$curent_page;
			// echo "<br />";
			// echo "currentPage : ".$this->currentPage;
			
			$perPage = $remaining_record;

			if($totalRecord >= $total){
				$is_last_page = 1;
			}


			$sql = $this->builder() . "\n" . "LIMIT " . (int) $show_record . ", " . (int) $perPage;
		}else{

			if($perPage >= $total){
				$is_last_page = 1;
			}

			$sql = $this->builder() . "\n" . "LIMIT " . (int) $this->sqlCurrLimit . ", " . (int) $perPage;
		}

		// $sql = $this->builder() . "\n" . "LIMIT " . (int) $this->sqlCurrLimit . ", " . (int) $this->perPage;


		// echo "<pre>"; print_r ($sql); echo "</pre>"; exit();
		// Count real query ads (Request::input('type') is an array in JobClass)

		// Fetch Query !
		$paginator = self::query($sql, $this->bindings, 0);

		$paginator = new LengthAwarePaginator($paginator, $total, $perPage , $this->currentPage);

		$paginator->setPath(Request::url());

		// Append the Posts 'uri' attribute
		$paginator->getCollection()->transform(function ($post) {
			$post->uri = trans('routes.v-post', ['slug' => slugify($post->title), 'id' => $post->id]);

			//  get translate country name 
			$country = new CountryHelper();

	        if ($name = $country->get($post->country_code, config('app.locale'))) {
	            $post->country_name =  $name;
	        } else {
	            $post->country_name =  '';
	        }
			return $post;
		});

		$paginator->is_last_page = $is_last_page; 

		return ['paginator' => $paginator, 'count' => $count];
	}

	/**
	 * @return array
	 */
	public function fechAll() {
		if (Request::filled('q')) {
			$this->setQuery(Request::input('q'));
		}
		if (Request::filled('c')) {
			if (Request::filled('sc')) {
				$this->setCategory(Request::input('c'), Request::input('sc'));
			} else {
				$this->setCategory(Request::input('c'));
			}
		}
		if (Request::filled('r') && !empty($this->admin) && !Request::filled('l')) {
			$this->setLocationByAdminCode($this->admin->code);
		}
		if (Request::has('l') && !empty($this->city)) {
			$this->setLocationByCityCoordinates($this->city->latitude, $this->city->longitude);
		}

		$this->setRequestFilters();

		if (auth()->check()) {
			if (auth()->user()->user_type_id == 3) {
				$this->setProfile(auth()->user());
			}

		}

		// Execute
		return $this->fetch();
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function countPosts() {
		// Remove the type with her SQL clause
		$where = $wherePostType = $this->arrSql->where;
		if (Request::filled('type')) {
			//unset($where['a.post_type_id']); // @todo: delete me
		}

		// $sql = "SELECT count(*) as total FROM (" . $this->builder($where) . ") as x";

		// Fetch Queries !
		// $all = self::query($this->builder($where), $this->bindings, 0);

		// $count['all'] = (isset($all[0])) ? $all[0]->total : 0;
		// $count['all'] = (isset($all)) ? count($all) : 0;
		$sql = $this->builder(array(), $select=array("count(DISTINCT(post.id)) as totalcount"));
		$all = self::query($sql, $this->bindings, 0);

		$count['all'] = (isset($all)) ? (isset($all[0]->totalcount)) ? $all[0]->totalcount : 0 : 0;
		return collect($count);
	}

	/**
	 * @param array $where
	 * @return string
	 */
	private function builder($where = [], $select = []) {
		// Set SELECT
		// $this->sql->select = 'SELECT DISTINCT ' . implode(', ', $this->arrSql->select) . ', py.package_id as py_package_id';
		if(isset($select) && count($select) > 0){
			$this->sql->select = 'SELECT '.implode(', ', $select);
		}else{
			$this->sql->select = 'SELECT DISTINCT ' . implode(', ', $this->arrSql->select) ;
		}

		// Set JOIN
		$this->sql->join = '';
		if (count($this->arrSql->join) > 0) {
			$this->sql->join = "\n" . implode("\n", $this->arrSql->join);
		}

		// Set WHERE
		$where_arr = ((count($where) > 0) ? $where : $this->arrSql->where);
		$this->sql->where = '';
		if (count($where_arr) > 0) {
			foreach ($where_arr as $key => $value) {
				if (is_numeric($key)) {
					$key = '';
				}
				if ($this->sql->where == '') {
					$this->sql->where .= "\n" . 'WHERE ' . $key . $value;
				} else {
					$this->sql->where .= ' AND ' . $key . $value;
				}
			}
		}

		// Set GROUP BY
		$this->sql->groupBy = '';
		if (count($this->arrSql->groupBy) > 0) {
			$this->sql->groupBy = "\n" . 'GROUP BY ' . implode(', ', $this->arrSql->groupBy);
		}

		// Set HAVING
		$this->sql->having = '';
		if (count($this->arrSql->having) > 0) {
			foreach ($this->arrSql->having as $key => $value) {
				if ($this->sql->having == '') {
					$this->sql->having .= "\n" . 'HAVING ' . $key . $value;
				} else {
					$this->sql->having .= ' AND ' . $key . $value;
				}
			}
		}

		// Set ORDER BY
		$this->sql->orderBy = '';
		// commented to solve error tab post_type
		// $this->sql->orderBy .= "\n" . 'ORDER BY p.lft DESC';
		if (count($this->arrSql->orderBy) > 0) {
			foreach ($this->arrSql->orderBy as $key => $value) {
				if ($this->sql->orderBy == '') {
					$this->sql->orderBy .= "\n" . 'ORDER BY ' . $key . $value;
				} else {
					$this->sql->orderBy .= ', ' . $key . $value;
				}
			}
		}

		if (count($this->arrSql->orderBy) > 0) {
			if (!in_array('post.created_at', array_keys($this->arrSql->orderBy))) {
				$this->sql->orderBy .= ', post.created_at DESC';
			}
		} else {
			if ($this->sql->orderBy == '') {
				$this->sql->orderBy .= "\n" . 'ORDER BY post.created_at DESC';
			} else {
				$this->sql->orderBy .= ', post.created_at DESC';
			}
		}

		// Set Query
		$sql = $this->sql->select . "\n" . "FROM " . table($this->table) . " as post" . $this->sql->join . $this->sql->where . $this->sql->groupBy . $this->sql->having . $this->sql->orderBy;

		return $sql;
	}

	/**
	 * @param $keywords
	 * @return bool
	 */
	public function setQuery($keywords) {
		if (trim($keywords) == '') {
			return false;
		}

		// Query search SELECT array
		$select = [];

		// Get all keywords in array
		$words_tab = preg_split('/[\s,\+]+/', $keywords);

		//-- If third parameter is set as true, it will check if the column starts with the search
		//-- if then it adds relevance * 30
		//-- this ensures that relevant results will be at top
		$select[] = "(CASE WHEN j.title LIKE :keywords THEN 300 ELSE 0 END) ";
		$this->bindings['keywords'] = $keywords . '%';

		foreach ($this->searchable['columns'] as $column => $relevance) {
			$tmp = [];
			foreach ($words_tab as $key => $word) {
				// Skip short keywords
				if (strlen($word) <= self::$queryLength) {
					continue;
				}
				// @todo: Find another way
				if (in_array(mb_strtolower($word), $this->banWords)) {
					continue;
				}
				$tmp[] = $column . " LIKE :word_" . $key;
				$this->bindings['word_' . $key] = '%' . $word . '%';
			}
			if (count($tmp) > 0) {
				$select[] = "(CASE WHEN " . implode(' || ', $tmp) . " THEN " . $relevance . " ELSE 0 END) ";
			}
		}
		if (count($select) <= 0) {
			return false;
		}

		$this->arrSql->select[] = implode("+\n", $select) . "as relevance";

		// Post category relation
		if (!Str::contains(implode(',', $this->arrSql->join), 'categories as category')) {
			$this->arrSql->join[] = "INNER JOIN " . table('categories') . " as category ON FIND_IN_SET(category.id, post.category_id) AND category.active=1";
		}
		// Category parent relation
		if (!Str::contains(implode(',', $this->arrSql->join), 'categories as cp')) {
			$this->arrSql->join[] = "LEFT JOIN " . table('categories') . " as cp ON cp.id=category.parent_id AND cp.active=1";
		}

		// Search with categories language
		$this->arrSql->join[] = "LEFT JOIN " . table('categories') . " as cl ON cl.translation_of=category.id AND cl.translation_lang = :translationLang";
		$this->arrSql->join[] = "LEFT JOIN " . table('categories') . " as cpl ON cpl.translation_of=cp.id AND cpl.translation_lang = :translationLang";
		$this->bindings['translationLang'] = config('lang.abbr');

		//-- Selects only the rows that have more than
		//-- the sum of all attributes relevances and divided by count of attributes
		//-- e.i. (20 + 5 + 2) / 4 = 6.75
		$average = array_sum($this->searchable['columns']) / count($this->searchable['columns']);
		$average = fixFloatVar($average);
		if ($this->forceAverage) {
			// Force average
			$average = $this->average;
		}
		$this->arrSql->having['relevance'] = ' >= :average';
		$this->bindings['average'] = $average;

		//-- Orders the results by relevance
		$this->arrSql->orderBy['relevance'] = ' DESC';
		$this->arrSql->groupBy[] = "post.id, relevance";
	}

	/**
	 * @param $catId
	 * @param null $subCatId
	 * @return $this
	 */
	public function setCategory($catId, $subCatId = null) {
		if (empty($catId)) {
			return $this;
		}

		// Category
		if (empty($subCatId)) {
			if (!Str::contains(implode(',', $this->arrSql->join), 'categories as category')) {
				$this->arrSql->join[] = "INNER JOIN " . table('categories') . " as category ON FIND_IN_SET(category.id, a.category_id) AND category.active=1";
			}
			if (!Str::contains(implode(',', $this->arrSql->join), 'categories as cp')) {
				$this->arrSql->join[] = "INNER JOIN " . table('categories') . " as cp ON cp.id=category.parent_id AND cp.active=1";
			}
			//$this->arrSql->where['cp.id'] = ' = :catId';
			$this->arrSql->where[':catId'] = ' IN (category.id, cp.id)';
			$this->bindings['catId'] = $catId;
		}
		// SubCategory
		else {
			if (!Str::contains(implode(',', $this->arrSql->join), 'categories')) {
				$this->arrSql->join[] = "INNER JOIN " . table('categories') . " as category ON FIND_IN_SET(category.id, post.category_id) AND category.active=1 AND category.translation_lang = :translationLang";
				$this->bindings['translationLang'] = config('lang.abbr');
			}
			$this->arrSql->where['post.category_id'] = ' = :subCatId';
			$this->bindings['subCatId'] = $subCatId;
		}

		return $this;
	}

	/**
	 * @param $userId
	 * @return $this
	 */
	public function setUser($userId) {
		if (trim($userId) == '') {
			return $this;
		}
		$this->arrSql->where['post.user_id'] = ' = :userId';
		$this->bindings['userId'] = $userId;

		return $this;
	}

	/**
	 * @param $user
	 * @return $this
	 */
	public function setProfile($user) {

		return $this;
	}

	/**
	 * @param $companyId
	 * @return $this
	 */
	public function setCompany($companyId) {
		if (trim($companyId) == '') {
			return $this;
		}
		$this->arrSql->where['post.company_id'] = ' = :companyId';
		$this->bindings['companyId'] = $companyId;

		return $this;
	}

	/**
	 * @param $tag
	 * @return $this
	 */
	public function setTag($tag) {
		if (trim($tag) == '') {
			return $this;
		}

		$tag = rawurldecode($tag);

		$this->arrSql->where[] = 'FIND_IN_SET(:tag, LOWER(post.tags)) > 0';
		$this->bindings['tag'] = mb_strtolower($tag);

		return $this;
	}

	/**
	 * Search including Administrative Division by adminCode
	 *
	 * @param $adminCode
	 * @return $this|Search
	 */
	public function setLocationByAdminCode($adminCode) {
		if (in_array(config('country.admin_type'), ['1', '2'])) {
			// Get the admin. division table info
			$adminType = config('country.admin_type');
			$adminTable = 'subadmin' . $adminType;
			$adminForeignKey = 'subadmin' . $adminType . '_code';

			// Query
			$this->arrSql->join[] = "INNER JOIN " . table('cities') . " as cia ON cia.id=post.city_id";
			$this->arrSql->join[] = "INNER JOIN " . table($adminTable) . " as admin ON admin.code=cia." . $adminForeignKey;
			$this->arrSql->where['admin.code'] = ' = :adminCode';
			$this->bindings['adminCode'] = $adminCode;

			return $this;
		}

		return $this;
	}

	/**
	 * Search including City by City Coordinates (lat & lon)
	 *
	 * @param $lat
	 * @param $lon
	 * @return $this
	 */
	public function setLocationByCityCoordinates($lat, $lon) {
		if ($lat == 0 || $lon == 0) {
			return $this;
		}
		$this->arrSql->orderBy['post.created_at'] = ' DESC'; // @todo:new

		// Ortho(A,B)=6371 x acos[cos(LatA) x cos(LatB) x cos(LongB-LongA)+sin(LatA) x sin(LatB)]
		$this->arrSql->select[] = '3959 * acos(cos(radians(' . $lat . ')) * cos(radians(post.lat))' . '* cos(radians(post.lon) - radians(' . $lon . '))' . '+ sin(radians(' . $lat . ')) * sin(radians(post.lat))) as distance';
		$this->arrSql->having['distance'] = ' <= :distance';
		$this->bindings['distance'] = self::$distance;
		$this->arrSql->orderBy['distance'] = ' ASC';

		return $this;
	}

	/**
	 * Search including City by City Id
	 *
	 * @param $cityId
	 * @return $this
	 */
	public function setLocationByCityId($cityId) {
		if (trim($cityId) == '') {
			return $this;
		}
		$this->arrSql->where['post.city_id'] = ' = :cityId';
		$this->bindings['cityId'] = $cityId;

		return $this;
	}

	/**
	 * @param $field
	 * @return bool
	 */
	public function setOrder($field) {
		if (!isset($this->orderMapping[$field])) {
			return false;
		}

		// Check essential field
		if ($field == 'relevance' and !Str::contains($this->sql->orderBy, 'relevance')) {
			return false;
		}

		$this->arrSql->orderBy[$this->orderMapping[$field]['name']] = ' ' . $this->orderMapping[$field]['order'];
	}

	/**
	 * @return $this
	 */
	public function setRequestFilters() {
		$parameters = Request::all();
		if (count($parameters) == 0) {
			return $this;
		}

		foreach ($parameters as $key => $value) {
			if (!isset($this->filters[$key])) {
				continue;
			}
			if (!is_array($value) and trim($value) == '') {
				continue;
			}

			// Special parameters
			$specParams = [];
			if ($key == 'minSalary') {
				// Min. Salary
				$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
				$specParams[] = $key;
			}
			if ($key == 'maxSalary') {
				// Max. Salary
				$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value;
				$specParams[] = $key;
			}
			if ($key == 'postedDate') {
				// Date
				$this->arrSql->where[$this->filters[$key]] = ' BETWEEN DATE_SUB(NOW(), INTERVAL :postedDate DAY) AND NOW()';
				$this->bindings['postedDate'] = $value;
				$specParams[] = $key;
			}

			// No-Special parameters
			if (!in_array($key, $specParams)) {
				if (is_array($value)) {
					$tmpArr = [];
					foreach ($value as $k => $v) {
						if (is_array($v)) {
							continue;
						}

						if (!is_array($v) && trim($v) == '') {
							continue;
						}

						$tmpArr[$k] = $v;
					}
					if (!empty($tmpArr)) {
						$this->arrSql->where[$this->filters[$key]] = ' IN (' . implode(',', $tmpArr) . ')';
					}
				} else {
					$this->arrSql->where[$this->filters[$key]] = ' = ' . $value;
				}
			}
		}

		return $this;
	}
}
