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

use App\Http\Requests\Admin\ModelCategoryRequest as StoreRequest;
use App\Http\Requests\Admin\ModelCategoryRequest as UpdateRequest;
use Larapen\Admin\app\Http\Controllers\PanelController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class ModelCategoryController extends PanelController {
	public $parentId = 0;

	public function setup() {
		/*
			|--------------------------------------------------------------------------
			| BASIC CRUD INFORMATION
			|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\ModelCategory');
		$this->xPanel->addClause('where', 'parent_id', '=', 0);
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/model-categories');
		$this->xPanel->setEntityNameStrings(t('Model Category'), t('Model Categories'));
		$this->xPanel->enableReorder('name', 1);
		$this->xPanel->enableDetailsRow();
		$this->xPanel->allowAccess(['reorder', 'details_row']);
		if (!request()->input('order')) {
			$this->xPanel->orderBy('lft', 'ASC');
		}

		/*
			|--------------------------------------------------------------------------
			| COLUMNS AND FIELDS
			|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name' => 'id',
			'label' => "ID",
		]);
		$this->xPanel->addColumn([
			'name' => 'name',
			'label' => __t("Name"),
			'type' => 'model_function',
			'function_name' => 'getNameHtml',
		]);
		$this->xPanel->addColumn([
			'name' => 'active',
			'label' => __t("Active"),
			'type' => 'model_function',
			'function_name' => 'getActiveHtml',
			'on_display' => 'checkbox',
		]);

		// FIELDS
		$this->xPanel->addField([
			'name' => 'parent_id',
			'type' => 'hidden',
			'value' => $this->parentId,
		]);
		$this->xPanel->addField([
			'name' => 'name',
			'label' => __t("Name"),
			'type' => 'text',
			'attributes' => [
				'placeholder' => __t("Name"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		if (Str::contains(Route::currentRouteAction(), 'ModelCategoryController@create')) {
			
			$this->xPanel->addField([
				'name' => 'slug',
				'label' => __t('Slug'),
				'type' => 'text',
				'attributes' => [
					'placeholder' => __t('Will be automatically generated from your name, if left empty'),
				],
				'hint' => __t('Will be automatically generated from your name, if left empty'),
				'wrapperAttributes' => [
					'class' => 'form-group col-md-6',
				],
			]);
		}else{

			$this->xPanel->addField([
				'name' => 'slug',
				'label' => __t('Slug'),
				'type' => 'text',
				'attributes' => [
					'placeholder' => __t('Will be automatically generated from your name, if left empty'),
					'readonly'=> 'readonly',
				],
				'hint' => __t('Will be automatically generated from your name, if left empty'),
				'wrapperAttributes' => [
					'class' => 'form-group col-md-6',
				],
			]);
		}

		$this->xPanel->addField([
			'name' => 'title',
			'label' => __t('Page Title'),
			'type' => 'text',
			'attributes' => [
				'placeholder' => __t("Title"),
			],
		]);

		$this->xPanel->addField([
			'name' => 'age_range',
			'label' => __t('age_range'),
			'type' => 'text',
			'attributes' => [
				'placeholder' => __t('age_range'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);

		$this->xPanel->addField([
			'name' => 'meta_title',
			'label' => __t('Meta Title'),
			'type' => 'text',
			'attributes' => [
				'placeholder' => __t('Meta Title'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);

		$this->xPanel->addField([
			'name' => 'meta_description',
			'label' => __t('Meta Description'),
			'type' => 'text',
			'attributes' => [
				'placeholder' => __t('Meta Description'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);

		$this->xPanel->addField([
			'name' => 'meta_keywords',
			'label' => __t('Meta Keywords'),
			'type' => 'text',
			'attributes' => [
				'placeholder' => __t('Meta Keywords'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-12',
			],
		]);

		
		$this->xPanel->addField([
			'name' => 'description',
			'label' => __t('Description'),
			'type' => (config('settings.single.simditor_wysiwyg'))
			? 'simditor'
			: ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
			'rows' => '4',
			'attributes' => [
				'placeholder' => __t('Description'),
				'id' => 'pageContent',
				'rows' => 20,
			],
		]);

		$this->xPanel->addField([
			'name' => 'faq_text',
			'label' => __t('FAQs Text'),
			'type' => (config('settings.single.simditor_wysiwyg'))
			? 'simditor'
			: ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
			'rows' => '4',
			'attributes' => [
				'placeholder' => __t('FAQs Text'),
				'id' => 'faq_text',
				'rows' => 20,
			],
		]);

		$this->xPanel->addField([
			'name' => 'faq_script',
			'label' => __t('FAQs Script'),
			'type' => 'textarea',
			'rows' => '4',
			'attributes' => [
				'placeholder' => __t('FAQs Script'),
				'id' => 'faq_script',
				'rows' => 10,
			],
		]);

		$this->xPanel->addField([
			'name' => 'footer_text',
			'label' => __t('footer_text'),
			'type' => 'textarea',
			'rows' => '4',
			'attributes' => [
				'placeholder' => __t('footer_text'),
				'id' => 'footer_text',
				'rows' => 10,
			],
		]);

		
		$this->xPanel->addField([
			'name' => 'active',
			'label' => __t("Active"),
			'type' => 'checkbox',
		]);
	}

	public function store(StoreRequest $request) {
		return parent::storeCrud();
	}

	public function update(UpdateRequest $request) {
		return parent::updateCrud();
	}
}
