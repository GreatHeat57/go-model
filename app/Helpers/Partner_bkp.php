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
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Str;

class PartnerSearch_bkp {
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
			'branches as c' => ['c.id', 'posts.category_id'],
			'branches as cp' => ['cp.id', 'c.parent_id'],
		],
	];
	public $forceAverage = true; // Force relevance's average
	public $average = 1; // Set relevance's average

	// Pre-Search vars
	public $city = null;
	public $admin = null;
	public $favoritePartner = null;

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
		'type' => 'a.post_type_id',
		'minSalary' => 'a.salary_min',
		'maxSalary' => 'a.salary_max',
		'postedDate' => 'a.created_at',
	];
	protected $orderMapping = [
		'salaryAsc' => ['name' => 'a.salary_max', 'order' => 'ASC'],
		'salaryDesc' => ['name' => 'a.salary_max', 'order' => 'DESC'],
		'relevance' => ['name' => 'relevance', 'order' => 'DESC'],
		'date' => ['name' => 'a.created_at', 'order' => 'DESC'],
	];

	/**
	 * Search constructor.
	 * @param array $preSearch
	 */
	public function __construct($preSearch = []) {
		// Pre-Search
		if (isset($preSearch['city']) && !empty($preSearch['city'])) {
			$this->city = $preSearch['city'];
		}
		if (isset($preSearch['admin']) && !empty($preSearch['admin'])) {
			$this->admin = $preSearch['admin'];
		}

		// Distance (Max & Default distance)
		self::$maxDistance = config('settings.listing.search_distance_max', self::$maxDistance);
		self::$distance = config('settings.listing.search_distance_default', self::$distance);

		// Ads per page
		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;
		if ($this->perPage < 4) {
			$this->perPage = 4;
		}

		if ($this->perPage > 40) {
			$this->perPage = 40;
		}

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
		$this->arrSql->select[] = "a.*";
		$this->arrSql->select[] = "p.id as pid, p.go_code, p.first_name, p.last_name, p.logo, p.company_name, p.street,p.zip,p.city,p.country, p.description, p.allow_search";

		// Post category relation
		$this->arrSql->join[] = "INNER JOIN " . table('user_profile') . " as p ON p.user_id=a.id";

		$this->arrSql->where = [
			//'a.country_code' => " = :countryCode",
			// 'a.country_code' => " = 'AT'",
			'a.user_type_id' => " = 2",
			'(a.verified_email' => " = 1 AND a.verified_phone = 1)",
			'a.deleted_at' => ' IS NULL',
			'a.active' => ' = 1',
			'p.allow_search' => ' = 1',
		];

		// if (empty($preSearch['favoritePartner'])) {
		$this->bindings['countryCode'] = config('country.code');
		// }

		// Check reviewed ads
		if (config('settings.single.posts_review_activation')) {
			$this->arrSql->where['a.reviewed'] = " = 1";
		}

		if (isset($preSearch['favoritePartner']) && !empty($preSearch['favoritePartner'])) {
			$this->arrSql->where['a.id in'] = '(' . $preSearch['favoritePartner'] . ')';
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
		// echo $sql . "<br/>";
		// echo
		// echo config('country.code');
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
		$count = $this->countPosts();
		$sql = $this->builder() . "\n" . "LIMIT " . (int) $this->sqlCurrLimit . ", " . (int) $this->perPage;
		
		// var_dump($this->city->name); die;
		// Count real query ads (Request::input('type') is an array in JobClass)
		$total = $count->get('all');

		// echo $sql;
		// Fetch Query !
		$paginator = self::query($sql, $this->bindings, 0);
		$count = count($paginator);
		$paginator = new LengthAwarePaginator($paginator, $total, $this->perPage, $this->currentPage);
		$paginator->setPath(Request::url());
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
			// $this->setLocationByCityCoordinates($this->city->latitude, $this->city->longitude);
			$this->setCity($this->city->name);
		}
		// if (!empty($this->favoritePartner)) {
		// $this->setLocationByCityCoordinates($this->city->latitude, $this->city->longitude);
		// $this->FavoritePartner($this->favoritePartner->name);
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

		$sql = "SELECT count(*) as total FROM (" . $this->builder($where) . ") as x";

		// Fetch Queries !
		$all = self::query($sql, $this->bindings, 0);

		$count['all'] = (isset($all[0])) ? $all[0]->total : 0;

		return collect($count);
	}

	/**
	 * @param array $where
	 * @return string
	 */
	private function builder($where = []) {
		// Set SELECT
		$this->sql->select = 'SELECT DISTINCT ' . implode(', ', $this->arrSql->select);

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
				$this->sql->orderBy .= "\n" . 'ORDER BY a.created_at DESC';
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
			if (!Str::contains(implode(',', $this->arrSql->join), 'branches as c')) {
				$this->arrSql->join[] = "LEFT JOIN " . table('branches') . " as c ON c.id=p.category_id AND c.active=1";
			}
			$this->arrSql->where['c.id'] = ' = :catId';
			// $this->arrSql->where[':catId'] = ' IN (c.id, cp.id)';
			$this->bindings['catId'] = $catId;
		}
		// SubCategory
		else {
			if (!Str::contains(implode(',', $this->arrSql->join), 'branches')) {
				$this->arrSql->join[] = "INNER JOIN " . table('branches') . " as c ON c.id=p.category_id AND c.active=1 AND c.translation_lang = :translationLang";
				$this->bindings['translationLang'] = config('lang.abbr');
			}
			$this->arrSql->where['p.category_id'] = ' = :subCatId';
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
		$this->arrSql->where['p.city'] = ' = :city';
		$this->bindings['city'] = $city;

		return $this;
	}

	/**
	 * @param $city
	 * @return $this
	 */
	// public function setFavoritePartner($partnerid) {
	// 	if (trim($favoriteid) == '') {
	// 		return $this;
	// 	}
	// 	$this->arrSql->whereIn['p.id'] = ' = :partnerid';
	// 	$this->bindings['partnerid'] = $partnerid;

	// 	return $this;
	// }

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
		$this->arrSql->select[] = '3959 * acos(cos(radians(' . $lat . ')) * cos(radians(a.lat))' . '* cos(radians(a.lon) - radians(' . $lon . '))' . '+ sin(radians(' . $lat . ')) * sin(radians(a.lat))) as distance';
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
