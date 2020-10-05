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

namespace App\Http\Controllers\Model\Traits;

use App\Helpers\Search;
use App\Helpers\UnitMeasurement;
use App\Models\ValidValue;
use Illuminate\Support\Facades\Request;

trait TitleTrait {
	/**
	 * Get Search Title
	 *
	 * @return string
	 */
	public function getTitle() {
		$title = '';

		// Init.
		$title .= t('Jobs');

		// Keyword
		if (Request::filled('q')) {
			$title .= ' ' . t('for') . ' ';
			$title .= '"' . rawurldecode(Request::input('q')) . '"';
		}

		// Category
		if (isset($this->isCatSearch) && $this->isCatSearch) {
			if (isset($this->cat) && !empty($this->cat)) {
				// SubCategory
				if (isset($this->isSubCatSearch) && $this->isSubCatSearch) {
					if (isset($this->subCat) && !empty($this->subCat)) {
						$title .= ' ' . $this->subCat->name . ',';
					}
				}

				$title .= ' ' . $this->cat->name;
			}
		}

		// User
		if (isset($this->isUserSearch) && $this->isUserSearch) {
			if (isset($this->sUser) && !empty($this->sUser)) {
				$title .= ' ' . t('of') . ' ';
				$title .= $this->sUser->name;
			}
		}

		// Company
		if (isset($this->isCompanySearch) && $this->isCompanySearch) {
			if (isset($this->company) && !empty($this->company)) {
				$title .= ' ' . t('among') . ' ';
				$title .= $this->company->name;
			}
		}

		// Tag
		if (isset($this->isTagSearch) && $this->isTagSearch) {
			if (isset($this->tag) && !empty($this->tag)) {
				$title .= ' ' . t('for') . ' ';
				$title .= $this->tag . ' (' . t('Tag') . ')';
			}
		}

		// Location
		if ((isset($this->isCitySearch) && $this->isCitySearch) || (isset($this->isAdminSearch) && $this->isAdminSearch)) {
			if (Request::filled('r') && !Request::filled('l')) {
				// Administrative Division
				if (isset($this->admin) && !empty($this->admin)) {
					$title .= ' ' . t('inside') . ' ';
					$title .= $this->admin->name;
				}
			} else {
				// City
				if (isset($this->city) && !empty($this->city)) {
					$title .= ' ' . t('at') . ' ';
					$title .= $this->city->name;
				}
			}
		}

		// Country
		$title .= ', ' . config('country.name');

		view()->share('title', $title);

		return $title;
	}

	/**
	 * Get Search HTML Title
	 *
	 * @return string
	 */
	public function getHtmlTitle() {
		$fullUrl = url(Request::getRequestUri());
		$tmpExplode = explode('?', $fullUrl);
		$fullUrlNoParams = current($tmpExplode);

		// Title
		$htmlTitle = '';

		// Init.
		// $htmlTitle .= t('All jobs');

		// Location
		if ((isset($this->isCitySearch) && $this->isCitySearch) or (isset($this->isAdminSearch) && $this->isAdminSearch)) {
			if (Request::filled('l') || Request::filled('r')) {
				$searchUrl = qsurl($fullUrlNoParams, Request::except(['l', 'r', 'location']));
			} else {
				$attr = ['countryCode' => config('country.icode')];
				$searchUrl = lurl(trans('routes.v-search', $attr), $attr);
				$searchUrl = qsurl($searchUrl, Request::except(['l', 'r', 'location']));
			}

			if (Request::filled('r') && !Request::filled('l')) {
				// Administrative Division
				if (isset($this->admin) && !empty($this->admin)) {
					$htmlTitle .= ' ' . t('inside') . ' ';
					$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . $searchUrl . '">';
					$htmlTitle .= $this->admin->name;
					$htmlTitle .= '</a>';
				}
			} else {
				// City
				if (isset($this->city) && !empty($this->city)) {
					$htmlTitle .= ' ' . t('within') . ' ';
					$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . $searchUrl . '">';
					$htmlTitle .= t(':distance :unit around :city', [
						'distance' => Search::$distance,
						'unit' => unitOfLength(config('country.code')),
						'city' => $this->city->name,
					]);
					$htmlTitle .= '</a>';
				}
			}
		}

		// Category
		if (isset($this->isCatSearch) && $this->isCatSearch) {
			if (isset($this->cat) && !empty($this->cat)) {
				// SubCategory
				if (isset($this->isSubCatSearch) && $this->isSubCatSearch) {
					if (isset($this->subCat) && !empty($this->subCat)) {
						$htmlTitle .= ' ' . t('in') . ' ';

						if (Request::filled('sc')) {
							$searchUrl = qsurl($fullUrlNoParams, Request::except(['sc']));
						} else {
							$attr = [
								'countryCode' => config('country.icode'),
								'catSlug' => $this->cat->slug,
							];
							$searchUrl = lurl(trans('routes.v-search-cat', $attr), $attr);
							$searchUrl = qsurl($searchUrl, Request::except(['sc']));
						}

						$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . $searchUrl . '">';
						$htmlTitle .= $this->subCat->name;
						$htmlTitle .= '</a>';
					}
				}

				$htmlTitle .= ' ' . t('in') . ' ';

				if (Request::filled('c')) {
					$searchUrl = qsurl($fullUrlNoParams, Request::except(['c']));
				} else {
					$attr = ['countryCode' => config('country.icode')];
					$searchUrl = lurl(trans('routes.v-search', $attr), $attr);
					$searchUrl = qsurl($searchUrl, Request::except(['c']));
				}

				$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . $searchUrl . '">';
				$htmlTitle .= $this->cat->name;
				$htmlTitle .= '</a>';
			}
		}

		// Company
		if (isset($this->isCompanySearch) && $this->isCompanySearch) {
			if (isset($this->company) && !empty($this->company)) {
				$htmlTitle .= ' ' . t('among') . ' ';
				$attr = ['countryCode' => config('country.icode')];
				$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . lurl(trans('routes.v-search', $attr), $attr) . '">';
				$htmlTitle .= $this->company->name;
				$htmlTitle .= '</a>';
			}
		}

		// Tag
		if (isset($this->isTagSearch) && $this->isTagSearch) {
			if (isset($this->tag) && !empty($this->tag)) {
				$htmlTitle .= ' ' . t('for') . ' ';
				$attr = ['countryCode' => config('country.icode')];
				$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . lurl(trans('routes.v-search', $attr), $attr) . '">';
				$htmlTitle .= $this->tag;
				$htmlTitle .= '</a>';
			}
		}

		// Date
		if (Request::filled('lastActivity') && isset($this->dates) && isset($this->dates->{Request::input('lastActivity')})) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except(['lastActivity'])) . '">';
			$htmlTitle .= $this->dates->{Request::input('lastActivity')};
			$htmlTitle .= '</a>';
		}

		// Get all values
		$property = [];
		$validValues = ValidValue::all();

		foreach ($validValues as $val) {
			$translate = $val->getTranslation(app()->getLocale());
			$property[$val->type][$val->id] = (isset($translate->value)) ? $translate->value : '';
		}

		//$unitArr = UnitMeasurement::getUnitMeasurement();

		//$property = array_merge($property, $unitArr);
		
		$unitArr = new UnitMeasurement();
		$unitoptions = $unitArr->getUnit(true);
		$property = array_merge($property, $unitoptions);

		// Eye Color
		if (Request::filled('eyeColor')) {
			if (!is_array(Request::input('eyeColor'))) {
				$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except(['eyeColor'])) . '">';
				$htmlTitle .= $property['eye_color'][Request::input('eyeColor')];
				$htmlTitle .= '</a>';
			}
		}

		// Skin Color
		if (Request::filled('skinColor')) {
			if (!is_array(Request::input('skinColor'))) {
				$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except(['skinColor'])) . '">';
				$htmlTitle .= $property['skin_color'][Request::input('skinColor')];
				$htmlTitle .= '</a>';
			}
		}

		// Hair Color
		if (Request::filled('hairColor')) {
			if (!is_array(Request::input('hairColor'))) {
				$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except(['hairColor'])) . '">';
				$htmlTitle .= $property['hair_color'][Request::input('hairColor')];
				$htmlTitle .= '</a>';
			}
		}

		// Height
		if (Request::filled('minHeight') && Request::filled('maxHeight')) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except('minHeight', 'maxHeight')) . '">';
			$htmlTitle .= $property['height'][Request::input('minHeight')] . '-' . $property['height'][Request::input('maxHeight')];
			$htmlTitle .= '</a>';
		}

		// Weight
		if (Request::filled('minWeight') && Request::filled('maxWeight')) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except('minWeight', 'maxWeight')) . '">';
			$htmlTitle .= $property['weight'][Request::input('minWeight')] . '-' . $property['weight'][Request::input('maxWeight')];
			$htmlTitle .= '</a>';
		}

		// Chest
		if (Request::filled('minChest') && Request::filled('maxChest')) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except('minChest', 'maxChest')) . '">';
			$htmlTitle .= t('Chest') . ' : ' . Request::input('minChest') . '-' . Request::input('maxChest');
			$htmlTitle .= '</a>';
		}

		// Waist
		if (Request::filled('minWaist') && Request::filled('maxWaist')) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except('minWaist', 'maxWaist')) . '">';
			$htmlTitle .= t('Waist') . ' : ' . Request::input('minWaist') . '-' . Request::input('maxWaist');
			$htmlTitle .= '</a>';
		}

		// Hips
		if (Request::filled('minHips') && Request::filled('maxHips')) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except('minHips', 'maxHips')) . '">';
			$htmlTitle .= t('Hips') . ' : ' . Request::input('minHips') . '-' . Request::input('maxHips');
			$htmlTitle .= '</a>';
		}

		// DressSize
		if (Request::filled('minDressSize') && Request::filled('maxDressSize')) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except('minDressSize', 'maxDressSize')) . '">';
			$htmlTitle .= $property['dress_size'][Request::input('minDressSize')] . '-' . $property['dress_size'][Request::input('maxDressSize')];
			$htmlTitle .= '</a>';
		}

		// ShoeSize
		if (Request::filled('minShoeSize') && Request::filled('maxShoeSize')) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except('minShoeSize', 'maxShoeSize')) . '">';
			$htmlTitle .= t('Shoe size') . ' : ' . $property['shoe_size'][Request::input('minShoeSize')] . '-' . $property['shoe_size'][Request::input('maxShoeSize')];
			$htmlTitle .= '</a>';
		}

		// Age
		if (Request::filled('minAge') && Request::filled('maxAge')) {
			$htmlTitle .= '<a rel="nofollow" class="jobs-s-tag" href="' . qsurl($fullUrlNoParams, Request::except('minAge', 'maxAge')) . '">';
			$htmlTitle .= t('Age') . ' : ' . Request::input('minAge') . '-' . Request::input('maxAge');
			$htmlTitle .= '</a>';
		}

		view()->share('htmlTitle', $htmlTitle);

		return $htmlTitle;
	}

	/**
	 * Get Breadcrumbs Tabs
	 *
	 * @return array
	 */
	public function getBreadcrumb() {
		$bcTab = [];

		// City
		if (isset($this->city) && !empty($this->city)) {
			$title = t('in :distance :unit around :city', [
				'distance' => Search::$distance,
				'unit' => unitOfLength(config('country.code')),
				'city' => $this->city->name,
			]);

			$attr = [
				'countryCode' => config('country.icode'),
				'city' => slugify($this->city->name),
				'id' => $this->city->id,
			];
			$bcTab[] = [
				'name' => (isset($this->cat) ? t('All jobs') . ' ' . $title : $this->city->name),
				'url' => lurl(trans('routes.v-search-city', $attr), $attr),
				'position' => (isset($this->cat) ? 5 : 3),
				'location' => true,
			];
		}

		// Admin
		if (isset($this->admin) && !empty($this->admin)) {
			$title = $this->admin->name;

			$attr = ['countryCode' => config('country.icode')];
			$bcTab[] = [
				'name' => (isset($this->cat) ? t('All jobs') . ' ' . $title : $this->admin->name),
				'url' => lurl(trans('routes.v-search', $attr), $attr) . '?d=' . config('country.icode') . '&r=' . $this->admin->name,
				'position' => (isset($this->cat) ? 5 : 3),
				'location' => true,
			];
		}

		// Category
		if (isset($this->cat) && !empty($this->cat)) {
			if (isset($this->subCat) && !empty($this->subCat)) {
				$title = t('in :category', ['category' => $this->subCat->name]);

				$attr = ['countryCode' => config('country.icode'), 'catSlug' => $this->cat->slug];
				$bcTab[] = [
					'name' => $this->cat->name,
					'url' => lurl(trans('routes.v-search-cat', $attr), $attr),
					'position' => 3,
				];

				$attr = [
					'countryCode' => config('country.icode'),
					'catSlug' => $this->cat->slug,
					'subCatSlug' => $this->subCat->slug,
				];
				$bcTab[] = [
					'name' => (isset($this->city) ? $this->subCat->name : t('All ads') . ' ' . $title),
					'url' => lurl(trans('routes.v-search-subCat', $attr), $attr),
					'position' => 4,
				];
			} else {
				$title = t('in :category', ['category' => $this->cat->name]);

				$attr = ['countryCode' => config('country.icode'), 'catSlug' => $this->cat->slug];
				$bcTab[] = [
					'name' => (isset($this->city) ? $this->cat->name : t('All jobs') . ' ' . $title),
					'url' => lurl(trans('routes.v-search-cat', $attr), $attr),
					'position' => 3,
				];
			}
		}

		// Company
		if (isset($this->company) && !empty($this->company)) {
			$attr = ['countryCode' => config('country.icode'), 'id' => $this->company->id];
			$bcTab[] = [
				'name' => $this->company->name,
				'url' => lurl(trans('routes.v-search-company', $attr), $attr),
				'position' => (isset($this->cat) ? 5 : 3),
				'location' => true,
			];
		}

		// Sort by Position
		$bcTab = array_values(array_sort($bcTab, function ($value) {
			return $value['position'];
		}));

		view()->share('bcTab', $bcTab);

		return $bcTab;
	}
}
