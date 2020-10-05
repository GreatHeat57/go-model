<?php
/**
 * LaraClassified - Geo Classified Ads Software
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

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\BlogCategoryRequest as StoreRequest;
use App\Http\Requests\Admin\BlogCategoryRequest as UpdateRequest;
use App\Models\Country;

class BlogCategoryController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\BlogCategory');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/blog-categories');
		$this->xPanel->setEntityNameStrings(__t('blog_category'), __t('blog_categories'));
        $this->xPanel->enableDetailsRow();
        $this->xPanel->allowAccess(['details_row']);

		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/

		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'id',
			'label' => "ID",
		]);
        $this->xPanel->addColumn([
            'name'  => 'name',
            'label' => "NAME",
        ]);
        $this->xPanel->addColumn([
			'name' => 'country_code',
			'label' => __t("Country"), 
		]);
        $this->xPanel->addColumn([
            'name'          => 'active',
            'label'         => __t("Active"),
            'type'          => 'model_function',
            'function_name' => 'getActiveHtml',
        ]);

		// FIELDS
        $this->xPanel->addField([
            'name'       => "name",
            'label'      => __t('Name'),
            'type'       => "text",
            'attributes' => [
                'placeholder' => __t('Name'),
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

        // Country field
        $this->xPanel->addField([
			'label' => __t("Country"),
			'name' => 'country_code',
			'model' => 'App\Models\Country', 
			'entity' => 'country',
			'attribute' => 'asciiname',
			'type' => 'select2',
		]);

        $this->xPanel->addField([
            'name'  => 'active',
            'label' => __t("Active"),
            'type'  => 'checkbox',
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
}
