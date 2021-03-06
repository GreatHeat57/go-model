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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Models\PostType;
use App\Models\Category;
use Illuminate\Support\Facades\Request;
use App\Models\SalaryType;
use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\PostRequest as StoreRequest;
use App\Http\Requests\Admin\PostRequest as UpdateRequest;

class PostController extends PanelController
{
	use VerificationTrait;
	
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Post');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/post');
		$this->xPanel->setEntityNameStrings(__t('ad'), __t('ads'));
		$this->xPanel->denyAccess(['create']);
		$this->xPanel->denyAccess(['delete']);
		$this->xPanel->enableDetailsRow();
		$this->xPanel->allowAccess(['reorder', 'details_row']);
		if (!request()->input('order')) {
			if (config('settings.single.posts_review_activation')) {
				$this->xPanel->orderBy('reviewed', 'ASC');
			}
			$this->xPanel->orderBy('created_at', 'DESC');
		}
		
		// Hard Filters
		if (Request::filled('active')) {
			if (Request::input('active') == 0) {
				$this->xPanel->addClause('where', 'verified_email', '=', 0);
				$this->xPanel->addClause('orWhere', 'verified_phone', '=', 0);
				if (config('settings.single.posts_review_activation')) {
					$this->xPanel->addClause('orWhere', 'reviewed', '=', 0);
				}
			}
			if (Request::input('active') == 1) {
				$this->xPanel->addClause('where', 'verified_email', '=', 1);
				$this->xPanel->addClause('where', 'verified_phone', '=', 1);
				if (config('settings.single.posts_review_activation')) {
					$this->xPanel->addClause('where', 'reviewed', '=', 1);
				}
			}
		}
		
		// Filters
		// -----------------------
			// $this->xPanel->addFilter([
			// 	'name'  => 'id',
			// 	'type'  => 'text',
			// 	'label' => 'ID',
			// ],
			// false,
			// function ($value) {
			// 	$this->xPanel->addClause('where', 'id', '=', $value);
			// });
		// -----------------------
		// $this->xPanel->addFilter([
		// 	'name'  => 'from_to',
		// 	'type'  => 'date_range',
		// 	'label' => __t('Date range'),
		// ],
		// false,
		// function ($value) {
		// 	$dates = json_decode($value);
		// 	$this->xPanel->addClause('where', 'created_at', '>=', $dates->from);
		// 	$this->xPanel->addClause('where', 'created_at', '<=', $dates->to);
		// });
		// -----------------------
		// $this->xPanel->addFilter([
		// 	'name'  => 'title',
		// 	'type'  => 'text',
		// 	'label' => __t('Title'),
		// ],
		// false,
		// function ($value) {
		// 	$this->xPanel->addClause('where', 'title', 'LIKE', "%$value%");
		// });
		// -----------------------
		// $this->xPanel->addFilter([
		// 	'name'  => 'country',
		// 	'type'  => 'select2',
		// 	'label' => __t('Country'),
		// ],
		// getCountries(),
		// function ($value) {
		// 	$this->xPanel->addClause('where', 'country_code', '=', $value);
		// });
		// -----------------------
		// $this->xPanel->addFilter([
		// 	'name'  => 'city',
		// 	'type'  => 'text',
		// 	'label' => __t('City'),
		// ],
		// false,
		// function ($value) {
		// 	$this->xPanel->query = $this->xPanel->query->whereHas('city', function ($query) use ($value) {
		// 		$query->where('name', 'LIKE', "%$value%");
		// 	});
		// });
		// -----------------------
		// $this->xPanel->addFilter([
		// 	'name'  => 'status',
		// 	'type'  => 'dropdown',
		// 	'label' => __t('Status'),
		// ], [
		// 	1 => __t('Unactivated'),
		// 	2 => __t('Activated'),
		// ], function ($value) {
		// 	if ($value == 1) {
		// 		$this->xPanel->addClause('where', 'verified_email', '=', 0);
		// 		$this->xPanel->addClause('orWhere', 'verified_phone', '=', 0);
		// 		if (config('settings.single.posts_review_activation')) {
		// 			$this->xPanel->addClause('orWhere', 'reviewed', '=', 0);
		// 		}
		// 	}
		// 	if ($value == 2) {
		// 		$this->xPanel->addClause('where', 'verified_email', '=', 1);
		// 		$this->xPanel->addClause('where', 'verified_phone', '=', 1);
		// 		if (config('settings.single.posts_review_activation')) {
		// 			$this->xPanel->addClause('where', 'reviewed', '=', 1);
		// 		}
		// 	}
		// });
		
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		
		//added clauses to seperate jobs from posts
		$this->xPanel->addClause('where', 'company_name', '!=', NULL);
		// $this->xPanel->addClause('where', 'company_description', '!=', NULL);

		// COLUMNS
		$this->xPanel->addColumn([
			'name' => 'id',
			'label' => "ID",
		]);
		$this->xPanel->addColumn([
			'name'  => 'created_at',
			'label' => __t("Date"),
			'type'  => 'datetime',
		]);
		// $space = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		// $this->xPanel->addColumn([
		// 	'name'          => 'title',
		// 	'label'         => __t('Title') . $space,
		// 	// 'type'          => 'model_function',
		// 	// 'function_name' => 'getTitleHtml',
		// ]);

		$this->xPanel->addColumn([
			'name' => 'title',
			'label' => __t("Title"),
			'model' => 'App\Models\JobsTranslation',
			'entity' => 'jobsTranslation',
			'attribute' => 'title',
			'type' => 'select',
		]);

		$this->xPanel->addColumn([
			'name'          => 'logo', // Put unused field column
			'label'         => __t("Logo"),
			'type'          => 'model_function',
			'function_name' => 'getLogoHtml',
		]);
		$this->xPanel->addColumn([
			'name'  => 'company_name',
			'label' => __t("Company Name"),
		]);
		$this->xPanel->addColumn([
			'name'          => 'city_id',
			'label'         => __t("City"),
			'type'          => 'model_function',
			'function_name' => 'getCityHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'country_code',
			'label'         => __t("Country"),
			'type'          => 'model_function',
			'function_name' => 'getCountryHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'verified_email',
			'label'         => __t("Verified Email"),
			'type'          => 'model_function',
			'function_name' => 'getVerifiedEmailHtml',
		]);
		if (config('settings.sms.phone_verification')) {
			$this->xPanel->addColumn([
				'name'          => 'verified_phone',
				'label'         => __t("Verified Phone"),
				'type'          => 'model_function',
				'function_name' => 'getVerifiedPhoneHtml',
			]);
		}
		if (config('settings.single.posts_review_activation')) {
			$this->xPanel->addColumn([
				'name'          => 'reviewed',
				'label'         => __t("Reviewed"),
				'type'          => "model_function",
				'function_name' => 'getReviewedHtml',
			]);
		}
		
		// FIELDS
		$this->xPanel->addField([
			'name'       => 'translation_lang',
			'type'       => 'hidden',
			'value' 	 => $this->getLocale(),
		]);

		$this->xPanel->addField([
			'label'       => __t("Category"),
			'name'        => 'category_id',
			'type'        => 'select2_from_array',
			'options'     => $this->categories(),
			'allows_null' => false,
		]);
		$this->xPanel->addField([
			'name'       => 'company_name',
			'label'      => __t('Company Name'),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => __t('Company Name'),
			],
		]);
		$this->xPanel->addField([
			'name'   => 'logo',
			'label'  => __t('Logo') . ' (Supported file extensions: jpg, jpeg, png, gif)',
			'type'   => 'image',
			'upload' => true,
			'disk'   => 'uploads',
		]);

		
		$this->xPanel->addField([
			'name'       => 'company_description',
			'label'      => __t("Company Description"),
			'type'       => (config('settings.single.simditor_wysiwyg'))
				? 'simditor'
				: ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
			'attributes' => [
				'placeholder' => __t("Company Description"),
				'id'          => 'company_description',
				'rows'        => 10,
			],
		]);

		$this->xPanel->addField([
			'name'       => 'title',
			'label'      => __t('Title'),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => __t('Title'),
			],
		]);

		// $this->xPanel->addField([
		// 	'name' => 'title',
		// 	'label' => __t("Title"),
		// 	'model' => 'App\Models\JobsTranslation',
		// 	'entity' => 'jobsTranslation',
		// 	'attribute' => 'title',
		// 	'type' => 'select',
		// ]);
		
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => __t("Description"),
			'type'       => (config('settings.single.simditor_wysiwyg'))
				? 'simditor'
				: ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
			'attributes' => [
				'placeholder' => __t("Description"),
				'id'          => 'description',
				'rows'        => 10,
			],
		]);
		$this->xPanel->addField([
			'name'              => 'salary_min',
			'label'             => __t("Salary (min)"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t("Salary (min)"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'salary_max',
			'label'             => __t("Salary (max)"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t("Salary (max)"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'label'             => __t("Salary Type"),
			'name'              => 'salary_type_id',
			'type'              => 'select2_from_array',
			'options'           => $this->salaryType(),
			'allows_null'       => false,
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'negotiable',
			'label'             => __t("Negotiable Salary"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		
		$this->xPanel->addField([
			'name'              => 'contact_name',
			'label'             => __t('User Name'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('User Name'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'email',
			'label'             => __t('User Email'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('User Email'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'phone',
			'label'             => __t('User Phone'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('User Phone'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'phone_hidden',
			'label'             => __t("Hide contact phone"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$this->xPanel->addField([
			'label'             => __t("Post Type"),
			'name'              => 'post_type_id',
			'type'              => 'select2_from_array',
			'options'           => $this->postType(),
			'allows_null'       => false,
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'tags',
			'label'             => __t("Tags"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t("Tags"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'verified_email',
			'label'             => __t("Verified Email"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'verified_phone',
			'label'             => __t("Verified Phone"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		if (config('settings.single.posts_review_activation')) {
			$this->xPanel->addField([
				'name'              => 'reviewed',
				'label'             => __t("Reviewed"),
				'type'              => 'checkbox',
				'wrapperAttributes' => [
					'class' => 'form-group col-md-6',
					'style' => 'margin-top: 20px;',
				],
			]);
		}
		$this->xPanel->addField([
			'name'              => 'archived',
			'label'             => __t("Archived"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'featured',
			'label'             => __t("Featured"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		$this->xPanel->addField([
			'name'       => 'ip_addr',
			'label'      => "IP",
			'type'       => 'text',
			'attributes' => [
				'disabled' => true,
			],
		]);
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}
	
	public function postType()
	{
		$entries = PostType::trans()->get();
		
		return $this->getTranslatedArray($entries);
	}
	
	public function categories()
	{
		$entries = Category::trans()->where('parent_id', 0)->orderBy('lft')->get();
		if ($entries->count() <= 0) {
			return [];
		}
		
		$tab = [];
		foreach ($entries as $entry) {
			$tab[$entry->tid] = $entry->name;
			
			$subEntries = Category::trans()->where('parent_id', $entry->id)->orderBy('lft')->get();
			if (!empty($subEntries)) {
				foreach ($subEntries as $subEntrie) {
					$tab[$subEntrie->tid] = "---| " . $subEntrie->name;
				}
			}
		}
		
		return $tab;
	}
	
	public function salaryType()
	{
		$entries = SalaryType::trans()->get();
		
		return $this->getTranslatedArray($entries);
	}
	
	public function getLocale(){

		$return_language_code = 'en';
		
		if (request()->segment(4) != 'edit') {
			
			$return_language_code = request()->segment(4);
		}

		return $return_language_code;
	}
}
