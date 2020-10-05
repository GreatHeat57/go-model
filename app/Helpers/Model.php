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
use App\Models\Favorite;
use App\Helpers\Localization\Helpers\Country as CountryHelper;
use Illuminate\Support\Str;

class ModelSearch {
	public $country;
	public $lang;
	public static $queryLength = 1; // Minimum query characters
	public static $distance = 100; // km
	public static $maxDistance = 500; // km
	public $perPage = 12;
	public $currentPage = 0;
	protected $table = 'users';
	protected $searchable = [
		'columns' => [
			// 'a.name'       => 10,
			// 'a.email' => 10,
		],
		'joins' => [
			'model_categories as c' => ['c.id', 'posts.category_id'],
			'model_categories as cp' => ['cp.id', 'c.parent_id'],
		],
	];
	public $forceAverage = true; // Force relevance's average
	public $average = 1; // Set relevance's average

	// Pre-Search vars
	public $city = null;
	public $admin = null;
	public $latitude = "";
	public $longitude = "";
	public $genderId = "";
	public $is_baby_model = "";
	public $dress_size = array();
	public $shoe_size = array();
	public $tattoo = "";
	public $is_premium_partner = "";
	public $country_type = "";

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
		'eyeColor' => 'p.eye_color_id',
		'skinColor' => 'p.skin_color_id',
		'hairColor' => 'p.hair_color_id',
		'minSalary' => 'a.salary_min',
		'maxSalary' => 'a.salary_max',
		'minHeight' => 'p.height_id',
		'maxHeight' => 'p.height_id',
		'minWeight' => 'p.weight_id',
		'maxWeight' => 'p.weight_id',
		'minChest' => 'p.chest_id',
		'maxChest' => 'p.chest_id',
		'minWaist' => 'p.waist_id',
		'maxWaist' => 'p.waist_id',
		'minHips' => 'p.hips_id',
		'maxHips' => 'p.hips_id',
		//'minDressSize' => 'p.size_id',
		//'maxDressSize' => 'p.size_id',
		'minShoeSize' => 'p.shoes_size_id',
		'maxShoeSize' => 'p.shoes_size_id',
		'minAge' => 'p.birth_day',
		'maxAge' => 'p.birth_day',
		'lastActivity' => 'a.last_login_at',
		//'gender_id' => 'a.gender_id',
		// 'countryid' => 'a.country_code',
		'category_id' => 'p.category_id',
		'cityid' => 'p.city',
		'search_content' => 'p.first_name OR p.last_name',
	];
	protected $orderMapping = [
		'salaryAsc' => ['name' => 'a.salary_max', 'order' => 'ASC'],
		'salaryDesc' => ['name' => 'a.salary_max', 'order' => 'DESC'],
		'relevance' => ['name' => 'relevance', 'order' => 'DESC'],
		'lastActivity' => ['name' => 'a.last_login_at', 'order' => 'DESC'],
	];

	/**
	 * Search constructor.
	 * @param array $preSearch
	 */
	public function __construct($preSearch = []) { 
		
		$params = Request::all();

		// echo "<pre>"; print_r ($preSearch); echo "</pre>"; exit();
		// Pre-Search
		if (isset($preSearch['city']) && !empty($preSearch['city'])) {
			$this->city = $preSearch['city'];
		}
		if (isset($preSearch['admin']) && !empty($preSearch['admin'])) {
			$this->admin = $preSearch['admin'];
		}

		if(isset($preSearch['latitude']) && !empty($preSearch['latitude'])){
			$this->latitude = $preSearch['latitude'];
		}

		if(isset($preSearch['longitude']) && !empty($preSearch['longitude'])){
			$this->longitude = $preSearch['longitude'];
		}

		// Distance (Max & Default distance)
		self::$maxDistance = config('settings.listing.search_distance_max', self::$maxDistance);
		self::$distance = config('settings.listing.search_distance_default', self::$distance);


		if(isset($preSearch['search_distance']) && !empty($preSearch['search_distance'])){
			self::$distance = $preSearch['search_distance'];
		}


		if(isset($preSearch['is_baby_model']) && !empty($preSearch['is_baby_model'])){
			$this->is_baby_model = $preSearch['is_baby_model'];
		}

		// Ads per page
		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
		
		if (isset($preSearch['perpage']) && !empty($preSearch['perpage'])) {
			$this->perPage = $preSearch['perpage'];
		}

		if(isset($params) && isset($params['dress_size_kids']) && count($params['dress_size_kids']) > 0 ){
			$this->dress_size = array_merge($this->dress_size, $params['dress_size_kids']);
		}

		if(isset($params) && isset($params['dress_size_men']) && count($params['dress_size_men']) > 0 ){
			$this->dress_size = array_merge($this->dress_size, $params['dress_size_men']);
		}

		if(isset($params) && isset($params['dress_size_women']) && count($params['dress_size_women']) > 0 ){
			$this->dress_size = array_merge($this->dress_size, $params['dress_size_women']);
		}

		if( count($this->dress_size) > 0 ){
			$this->dress_size = array_unique($this->dress_size);
		}


		if(isset($params) && isset($params['shoe_size_kids']) && count($params['shoe_size_kids']) > 0 ){
			$this->shoe_size = array_merge($this->shoe_size, $params['shoe_size_kids']);
		}

		if(isset($params) && isset($params['shoe_size_men']) && count($params['shoe_size_men']) > 0 ){
			$this->shoe_size = array_merge($this->shoe_size, $params['shoe_size_men']);
		}

		if(isset($params) && isset($params['shoe_size_women']) && count($params['shoe_size_women']) > 0 ){
			$this->shoe_size = array_merge($this->shoe_size, $params['shoe_size_women']);
		}

		if( count($this->shoe_size) > 0 ){
			$this->shoe_size = array_unique($this->shoe_size);
		}

		if (isset($preSearch['tattoo']) && $preSearch['tattoo'] != "") {
			$this->tattoo = $preSearch['tattoo'];
		}

		if (isset($preSearch['country_code']) && $preSearch['country_code'] != "") {
			$this->country = $preSearch['country_code'];
		}


		if (isset($preSearch['country_type']) && $preSearch['country_type'] != "") {
			$this->country_type = $preSearch['country_type'];
		}


		$this->is_premium_partner = (isset($preSearch['is_premium_partner']) && $preSearch['is_premium_partner'])? true : false;
		
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
		$this->arrSql->select[] = "a.id,a.country_code,a.user_type_id,a.gender_id,a.name,a.phone,a.username,a.email,a.active,a.lang_locale,
a.verified_email,a.verified_phone,a.blocked,a.created_at,a.last_login_at,a.latitude,a.longitude, p.birth_day";

		$this->arrSql->select[] = "p.id as pid, p.go_code, p.first_name, p.last_name, p.logo, p.company_name, p.street,p.zip,p.city, p.category_id, p.description, p.user_id, p.allow_search, CONCAT(UPPER(SUBSTRING(p.first_name,1,1)),LOWER(SUBSTRING(p.first_name,2)),' ', '') as full_name, IF(a.user_register_type='".config('constant.user_type_premium')."', IF(a.subscription_type = 'paid', 1, 2), IF(a.user_register_type='".config('constant.user_type_premium_send')."', 1, 2)) as subscription_type";
		
		// Post category relation
		$this->arrSql->join[] = "INNER JOIN " . table('user_profile') . " as p ON p.user_id=a.id";

		//$this->arrSql->select[] = "ct.name as city_name, ct.asciiname as city_asciiname";

		//$this->arrSql->join[] = "LEFT JOIN " . table('cities') . " as ct ON ct.id=p.city";

		// $this->arrSql->join[] = "LEFT JOIN " . table('countries') . " as cn ON cn.code=p.country";
		
		$is_favourite = 0;

		if(isset($preSearch['is_favourite'])){
			if($preSearch['is_favourite'] == 1){
				// Post favourite relation
				$this->arrSql->join[] = "INNER JOIN " . table('favorites') . " as f ON f.fav_user_id = a.id";
				$is_favourite = 1;
			}
		}

		$this->arrSql->where = [
			//'a.country_code' => " = :countryCode",
			'a.user_type_id' => " = 3",
			'a.active' => " = 1",
			// 'a.is_profile_completed' => " = '1' ",
			'(a.verified_email' => " = 1 AND a.verified_phone = 1)",
			'p.allow_search = 1',
		];

		if (isset($preSearch['is_featured']) && !empty($preSearch['is_featured'])) {
			$this->arrSql->where = [
				//'a.country_code' => " = :countryCode",
				'a.user_type_id' => " = 3",
				'a.active' => " = 1",
				// 'a.is_profile_completed' => " = '1' ",
				'a.featured' => " = 1",
				'(a.verified_email' => " = 1 AND a.verified_phone = 1)",
				'p.allow_search = 1',
			];
		} else {
			$this->arrSql->where = [
				//'a.country_code' => " = :countryCode",
				'a.user_type_id' => " = 3",
				'a.active' => " = 1",
				'a.blocked' => " = 0",
				// 'a.is_profile_completed' => " = '1' ",
				'(a.verified_email' => " = 1 AND a.verified_phone = 1)",
				'p.allow_search = 1',
			];
		}

		// dress size query update
		if(count($this->dress_size) > 0 ){

			$dressSize_where = [];

			foreach ($this->dress_size as $key => $value) {
				$dressSize_where[] = "p.size_id = ".$value."";
			}


			$where_cluase = "";
			if(count($dressSize_where) > 0 ){
				if(count($dressSize_where) > 1){
					$where_cluase = implode(' OR ', $dressSize_where);
					$this->arrSql->where[] = " ( ".$where_cluase." ) ";
				}else{
					$this->arrSql->where[] = $dressSize_where[0];
				}
			}
		}

		// shoe size query update
		if(count($this->shoe_size) > 0 ){

			$shoeSize_where = [];

			foreach ($this->shoe_size as $key => $value) {
				$shoeSize_where[] = " p.shoes_size_id = ".$value;
			}

			$where_cluase = "";
			if(count($shoeSize_where) > 0 ){
				if(count($shoeSize_where) > 1){
					$where_cluase = implode(' OR ', $shoeSize_where);
					$this->arrSql->where[] = " ( ".$where_cluase." ) ";
				}else{
					$this->arrSql->where[] = $shoeSize_where[0];
				}
			}
		}

		if (isset($params) && isset($params['gender_id'])) {

			$gender_male = config('constant.gender_male');
			$gender_female = config('constant.gender_female');

			if( $params['gender_id'] == 0 ){
				$this->arrSql->where[] = "( a.gender_id = ".$gender_male." OR a.gender_id = ".$gender_female.")"; 
			}else{
				$this->arrSql->where[] = " a.gender_id = ".$params['gender_id'];
			}
		}

		if($this->tattoo != ""){
			$this->arrSql->where[] = " p.tattoo = ".$this->tattoo;
		}

		if($is_favourite == 1){
			$this->arrSql->where['f.user_id'] = " = ".Auth()->User()->id;
		}

		// $this->bindings['countryCode'] = config('country.code');
		
		$this->arrSql->where['a.deleted_at'] = ' IS NULL';

		// Check reviewed ads
		if (config('settings.single.posts_review_activation')) {
			$this->arrSql->where['a.reviewed'] = " = 1";
		}

		if($this->country != ""){
			$this->arrSql->where[] = " a.country_code = '".$this->country."' ";
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

		if (!empty($this->city)) {
			// $this->setLocationByCityCoordinates($this->city->latitude, $this->city->longitude);
			$this->setCity($this->city);
		}


		if(!empty($this->latitude) && !empty($this->longitude)){ 
			$this->setLocationByCityCoordinates($this->latitude, $this->longitude);
		}

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
			}
			$totalRecord = $show_record + $remaining_record;
			$curent_page = $totalRecord  / $perPage;
			$this->currentPage = ceil($curent_page);
			
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

		// echo "<pre>"; print_r ($sql); echo "</pre>"; exit();

		// Fetch Query !
		$paginator = self::query($sql, $this->bindings, 0);

		$paginator = new LengthAwarePaginator($paginator, $total, $this->perPage, $this->currentPage);

		$paginator->setPath(Request::url());


		// Append the Posts 'uri' attribute
		$paginator->getCollection()->transform(function ($user) {

			//  get translate country name 
			$country = new CountryHelper();

	        if ($name = $country->get($user->country_code, config('app.locale'))) {
	            $user->country_name =  $name;
	        } else {
	            $user->country_name =  '';
	        }

			return $user;
		});

		$paginator->is_last_page = $is_last_page;

		return ['paginator' => $paginator, 'count' => $count];


		/*


		$sql = $this->builder() . "\n" . "LIMIT " . (int) $this->sqlCurrLimit . ", " . (int) $this->perPage;

		// echo "<pre>"; print_r ($sql); echo "</pre>"; exit();
		// var_dump($sql); die;
		// Count real query ads (Request::input('type') is an array in JobClass)
		$total = $count->get('all');
		
		// Fetch Query !
		$paginator = self::query($sql, $this->bindings, 0);

		$count = 0;
		if($paginator){
			$count = count($paginator);
		}
		$paginator = new LengthAwarePaginator($paginator, $total, $this->perPage, $this->currentPage);
		$paginator->setPath(Request::url());


		// Append the Posts 'uri' attribute
		$paginator->getCollection()->transform(function ($user) {

			//  get translate country name 
			$country = new CountryHelper();

	        if ($name = $country->get($user->country_code, config('app.locale'))) {
	            $user->country_name =  $name;
	        } else {
	            $user->country_name =  '';
	        }

			return $user;
		});

		return ['paginator' => $paginator, 'count' => $count];

		*/
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

		// if (!empty($this->city)) {
		// 	// $this->setLocationByCityCoordinates($this->city->latitude, $this->city->longitude);
		// 	$this->setCity($this->city);
		// }


		// if(!empty($this->latitude) && !empty($this->longitude)){ 
		// 	$this->setLocationByCityCoordinates($this->latitude, $this->longitude);
		// }

		$this->setRequestFilters();

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

		// echo $sql = "SELECT count(*) as total FROM (" . $this->builder($where) . ") as x";

		// Fetch Queries !
		// $all = self::query($this->builder($where), $this->bindings, 0);

		$sql = $this->builder(array(), $select=array("count(DISTINCT(a.id)) as totalcount"));
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
		if(isset($select) && count($select) > 0){
			$this->sql->select = 'SELECT '.implode(', ', $select);
		}else{
			$this->sql->select = 'SELECT DISTINCT ' . implode(', ', $this->arrSql->select);
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
			if (!in_array('a.created_at', array_keys($this->arrSql->orderBy))) {
				$this->sql->orderBy .= ', a.created_at DESC';
			}
		} else {

			if ($this->sql->orderBy == '') {

				if($this->is_premium_partner){

					if($this->country_type != "" && $this->country_type == config('constant.country_free')){
						$this->sql->orderBy .= "\n" . 'ORDER BY a.is_profile_completed DESC, a.last_login_at DESC';
						$this->sql->orderBy .= ', a.created_at DESC';
					}else{
						$this->sql->orderBy .= "\n" . 'ORDER BY subscription_type ASC, a.is_profile_completed DESC, a.last_login_at DESC';
						$this->sql->orderBy .= ', a.created_at DESC';
					}

				}else{

					if($this->country_type != "" && $this->country_type == config('constant.country_premium')){
						$this->sql->orderBy .= "\n" . 'ORDER BY subscription_type ASC, a.is_profile_completed DESC, a.last_login_at DESC';
						$this->sql->orderBy .= ', a.created_at DESC';
					}else{
						$this->sql->orderBy .= "\n" . 'ORDER BY a.is_profile_completed DESC, a.last_login_at DESC';
						$this->sql->orderBy .= ', a.created_at DESC';
					}
				}

			} else {
				$this->sql->orderBy .= ', a.created_at DESC';
			}
		}

		// Set Query
		$sql = $this->sql->select . "\n" . "FROM " . table($this->table) . " as a" . $this->sql->join . $this->sql->where . $this->sql->groupBy . $this->sql->having . $this->sql->orderBy;

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

		$select = [];
		$select[] = "( a.name LIKE :keywords OR a.email LIKE :keywords ) ";
		$this->bindings['keywords'] = $keywords . '%';
		$this->arrSql->where[] = implode("+\n", $select);
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
			if (!Str::contains(implode(',', $this->arrSql->join), 'model_categories as c')) {
				// $this->arrSql->join[] = "LEFT JOIN " . table('model_categories') . " as c ON c.id=p.category_id AND c.active=1";
				$this->arrSql->join[] = "INNER JOIN " . table('model_categories') . " as c ON FIND_IN_SET(c.id, p.category_id) AND c.active=1";

			}
			// $this->arrSql->where['c.id'] = ' = :catId';
			$this->arrSql->where['c.id'] = ' = '. $catId; 
			// $this->arrSql->where[':catId'] = ' IN (c.id, cp.id)';
			$this->bindings['catId'] = $catId;
		}
		// SubCategory
		else {
			if (!Str::contains(implode(',', $this->arrSql->join), 'model_categories')) {
				$this->arrSql->join[] = "INNER JOIN " . table('model_categories') . " as c ON c.id=p.category_id AND c.active=1 AND c.translation_lang = :translationLang";
				$this->bindings['translationLang'] = config('lang.abbr');
			}
			// $this->arrSql->where['p.category_id'] = ' = :subCatId';
			$this->arrSql->where['p.category_id'] = ' = '. $subCatId;
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
		$this->arrSql->where['a.user_id'] = ' = :userId';
		$this->bindings['userId'] = $userId;

		return $this;
	}

	/**
	 * @param $city
	 * @return $this
	 */
	public function setCity($city) {
		if (trim($city) == '') {
			return $this;
		}
		$this->arrSql->where['LOWER(p.city)'] = ' = "'.strtolower($city).'" ';
		// $this->bindings['city'] = $city;

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
		$this->arrSql->where['a.company_id'] = ' = :companyId';
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

		$this->arrSql->where[] = 'FIND_IN_SET(:tag, LOWER(a.tags)) > 0';
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
			$this->arrSql->join[] = "INNER JOIN " . table('cities') . " as cia ON cia.id=a.city_id";
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

		$this->arrSql->orderBy['a.created_at'] = ' DESC'; // @todo:new

		// Ortho(A,B)=6371 x acos[cos(LatA) x cos(LatB) x cos(LongB-LongA)+sin(LatA) x sin(LatB)]
		$this->arrSql->where[] = '3959 * acos(cos(radians(' . $lat . ')) * cos(radians(a.latitude))' . '* cos(radians(a.longitude) - radians(' . $lon . '))' . '+ sin(radians(' . $lat . ')) * sin(radians(a.latitude))) <=' .self::$distance;

		//$this->arrSql->having['distance'] = ' <= '.self::$distance;
		// $this->bindings['distance'] = self::$distance;
		// $this->arrSql->orderBy['distance'] = ' ASC';

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
		$this->arrSql->where['a.city_id'] = ' = :cityId';
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

				if(array_key_exists("maxSalary", $parameters) && empty($parameters['maxSalary'])){
				 	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
				}

				$specParams[] = $key;
			}
			if ($key == 'maxSalary') {
				// Max. Salary
				$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value;
				$specParams[] = $key;
			}
			// $query_height = '';
			if ($key == 'minHeight') {
				// Min. Height
				$query_height = ' AND p.height_id >= ' . $value;
				
				if(array_key_exists("maxHeight", $parameters) && empty($parameters['maxHeight'])){
				 	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
				} 
				$specParams[] = $key;
			}
			if ($key == 'maxHeight') {
				$min_height = (isset($query_height)? $query_height : '' );
				// Max. Height
				$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value . $min_height;
				$specParams[] = $key;
			}
			// $query_weight ='';
			if ($key == 'minWeight') { 
				// Min. Weight
				$query_weight = ' AND p.weight_id >= ' . $value;

				if(array_key_exists("maxWeight", $parameters) && empty($parameters['maxWeight'])){
				 	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
				} 
				$specParams[] = $key;
			}
			if ($key == 'maxWeight') {
				$min_weight = (isset($query_weight)? $query_weight : '' );
				// Max. Weight
				$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value . $min_weight;
				$specParams[] = $key;
			}
			// $query_chest ='';
			if ($key == 'minChest') {
				// Min. Chest
				$query_chest = ' AND p.chest_id >= ' . $value;

				if(array_key_exists("maxChest", $parameters) && empty($parameters['maxChest'])){
				 	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
				} 

				$specParams[] = $key;
			}
			if ($key == 'maxChest') {

				$min_chest = (isset($query_chest)? $query_chest : '' );
				// Max. Chest
				$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value . $min_chest;
				$specParams[] = $key;
			}

			// $query_waist = '';
			if ($key == 'minWaist') {
				// Min. Waist
				$query_waist = ' AND p.waist_id >= ' . $value;

				if(array_key_exists("maxWaist", $parameters) && empty($parameters['maxWaist'])){
				 	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
				}

				$specParams[] = $key;
			}
			if ($key == 'maxWaist') {

				$min_waist = (isset($query_waist)? $query_waist : '' );
				// Max. Waist
				$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value . $min_waist;
				$specParams[] = $key;
			}

			// $query_hips = '';
			if ($key == 'minHips') {
				// Min. Hips
				$query_hips = ' AND p.hips_id >= ' . $value;

				if(array_key_exists("maxHips", $parameters) && empty($parameters['maxHips'])){
				 	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
				}

				$specParams[] = $key;
			}
			if ($key == 'maxHips') {
				$min_hips = (isset($query_hips)? $query_hips : '' );
				// Max. Hips
				$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value . $min_hips;
				$specParams[] = $key;
			}

			// if ($key == 'minDressSize' && $this->is_baby_model == 1) {
			// 	$query_dressSize = ' AND p.dress_size_baby FIND_IN_SET("'.$value.'", p.dress_size_baby) ' . $value;
			// }

			// $query_dressSize = '';
			// if ($key == 'minDressSize') {
			// 	// Min. DressSize
			// 	$query_dressSize = ' AND p.size_id >= ' . $value;

			// 	if(array_key_exists("maxDressSize", $parameters) && empty($parameters['maxDressSize'])){
			// 	 	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
			// 	}

			// 	$specParams[] = $key;
			// }
			// if ($key == 'maxDressSize') {
			// 	$min_dressSize = (isset($query_dressSize)? $query_dressSize : '' );
			// 	// Max. DressSize
			// 	$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value . $min_dressSize;
			// 	$specParams[] = $key;
			// }

			// $query_shoeSize = '';
			// if ($key == 'minShoeSize') {
			// 	// Min. ShoeSize
			// 	$query_shoeSize = ' AND p.shoes_size_id >= ' . $value;

			// 	if(array_key_exists("maxShoeSize", $parameters) && empty($parameters['maxShoeSize'])){
			// 	 	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
			// 	}

			// 	$specParams[] = $key;
			// }
			// if ($key == 'maxShoeSize') {
			// 	$min_shoeSize = (isset($query_shoeSize)? $query_shoeSize : '' );
			// 	// Max. ShoeSize
			// 	$this->arrSql->where[$this->filters[$key]] = ' <= ' . $value . $min_shoeSize;
			// 	$specParams[] = $key;
			// }

			// $query_age = '';
			if ($key == 'minAge') {
				// Min. Age
				// $query_age = ' AND p.birth_day <= now() - INTERVAL ' . ($value - 1) . ' YEAR';
				// if(array_key_exists("maxAge", $parameters) && empty($parameters['maxAge'])){
				//  	$this->arrSql->where[$this->filters[$key]] = ' >= ' . $value;
				// }
				
				if(array_key_exists("maxAge", $parameters) && empty($parameters['maxAge']) && isset($value) && !empty($value)){

					// calculation of month
					if($value >= 1){
						$month = 12 * $value;
					}else{
						$month = $value * 100;
					}
					
					$this->arrSql->where['12 * (YEAR(CURDATE()) - YEAR(p.birth_day)) + (MONTH(CURDATE()) - MONTH(p.birth_day))'] = ' >= ' . $month . '';

					// $this->arrSql->where['YEAR(CURDATE()) - YEAR(p.birth_day)'] = ' >= ' . $value . '';

					// $this->arrSql->where["floor(datediff(curdate(), p.birth_day) / 365)"] = ' >= ' . $value . '';
					//floor(datediff(curdate(),'1987-11-08') / 365)
				}

				$specParams[] = $key;
			}
			if ($key == 'maxAge') {
				// $min_age = (isset($query_age)? $query_age : '' );
				// // Max. Age
				// $this->arrSql->where[$this->filters[$key]] = ' >= now() - INTERVAL ' . $value . ' YEAR + INTERVAL 1 DAY' . $min_age;

				if(array_key_exists("minAge", $parameters) && !empty($parameters['minAge'])){

					// calculation of month form minAge
					if($parameters['minAge'] >= 1){
						$minAge = 12 * $parameters['minAge'];
					}else{
						$minAge = $parameters['minAge'] * 100;
					}

					// calculation of month form maxAge
					if($parameters['maxAge'] >= 1){
						$maxAge = 12 * $parameters['maxAge'];
					}else{
						$maxAge = $parameters['maxAge'] * 100;
					} 
					
					$this->arrSql->where[] = '( 12 * (YEAR(CURDATE()) - YEAR(p.birth_day)) + (MONTH(CURDATE()) - MONTH(p.birth_day)) >= ' . $minAge . ' AND 12 * (YEAR(CURDATE()) - YEAR(p.birth_day)) + (MONTH(CURDATE()) - MONTH(p.birth_day)) <= ' . $maxAge . ')';

					// $this->arrSql->where[] = '( floor(datediff(curdate(), p.birth_day) / 365) >= ' . $parameters['minAge'] . ' AND floor(datediff(curdate(), p.birth_day) / 365) <= ' . $parameters['maxAge'] . ')';
				}else{
					//$this->arrSql->where[$this->filters[$key]] = ' >= now() - INTERVAL ' . $value . ' YEAR';

					// $this->arrSql->where["floor(datediff(curdate(), p.birth_day) / 365)"] = ' <= ' . $value . '';

					if($value >= 1){
						$value = 12 * $value;
					}else{
						$value = $value * 100;
					} 

					$this->arrSql->where["12 * (YEAR(CURDATE()) - YEAR(p.birth_day)) + (MONTH(CURDATE()) - MONTH(p.birth_day))"] = ' <= ' . $value . '';
				}

				$specParams[] = $key;
			}

			// if ($key == 'lastActivity') {
			// 	// Date
			// 	$this->arrSql->where[$this->filters[$key]] = ' BETWEEN DATE_SUB(NOW(), INTERVAL :lastActivity DAY) AND NOW()';
			// 	$this->bindings['lastActivity'] = $value;
			// 	$specParams[] = $key;
			// }

			// if ($key == 'countryid') {
			// 	// Min. Salary
			// 	$this->arrSql->where[$this->filters[$key]] = " = '" . $value."'";
			// 	$specParams[] = $key;
			// }

			

			if ($key == 'cityid') {
				// Min. Salary
				$this->arrSql->where[$this->filters[$key]] = " = '" . $value."'";
				$specParams[] = $key;
			}
			
			if ($key == 'category_id') {

				// Min. Salary
				$this->arrSql->where[$this->filters[$key]] = ' IN ('.implode(',', $value).')';
				$specParams[] = $key;
			}

			if ($key == 'search_content') {
				// Min. Salary
				// $this->arrSql->where[$this->filters[$key]] = " LIKE '%".$value."%'";

				$this->arrSql->where[] = "(p.first_name LIKE '%".$value."%' OR p.last_name LIKE '%".$value."%' OR p.go_code LIKE '%".$value."%')";
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

	public function favourite(){
       $f_ids = Favorite::where('user_id', Auth()->User()->id)->pluck('fav_user_id')->toArray();

       if( count($f_ids) > 0 ){

            $f_ids = implode(',', $f_ids);

            $sql = "SELECT DISTINCT a.*, p.* FROM users as a 
                INNER JOIN user_profile as p ON p.user_id=a.id 
                WHERE a.user_type_id = 3 
                AND a.active = 1 
                -- AND a.is_profile_completed = '1'
                AND a.id IN (".$f_ids.")
                AND (a.verified_email = 1 AND a.verified_phone = 1)
                ORDER BY a.created_at";

            $paginator = self::query($sql);
            $count = count($paginator);

            $sql = $sql . "\n" . "LIMIT " . (int)$this->sqlCurrLimit . ", " . (int)$this->perPage;
            $paginator = self::query($sql);

            $paginator = new LengthAwarePaginator($paginator, $count, $this->perPage, $this->currentPage);
            $paginator->setPath(Request::url());

            return ['paginator' => $paginator, 'count' => $count];
       }
    }
}
