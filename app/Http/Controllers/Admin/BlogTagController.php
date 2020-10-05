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
use App\Http\Requests\Admin\BlogTagRequest as StoreRequest;
use App\Http\Requests\Admin\BlogTagRequest as UpdateRequest;

class BlogTagController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\BlogTag');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/blog-tags');
		$this->xPanel->setEntityNameStrings(__t('blog_tag'), __t('blog_tags'));
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
            'name'  => 'tag',
            'label' => "TAG",
        ]);
        $this->xPanel->addColumn([
            'name'  => 'slug',
            'label' => "SLUG",
        ]);

		// FIELDS
        $this->xPanel->addField([
            'name'       => "tag",
            'label'      => __t('blog_tag'),
            'type'       => "text",
            'attributes' => [
                'placeholder' => __t('blog_tag'),
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
