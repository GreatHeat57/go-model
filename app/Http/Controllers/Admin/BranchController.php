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

use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\BranchRequest as StoreRequest;
use App\Http\Requests\Admin\BranchRequest as UpdateRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class BranchController extends PanelController
{
	public $parentId = 0;
	
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Branch');
		$this->xPanel->addClause('where', 'parent_id', '=', 0);
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/branch');
		$this->xPanel->setEntityNameStrings(t('Branch'), t('Branches'));
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
			'name'  => 'id',
			'label' => "ID",
		]);
		$this->xPanel->addColumn([
			'name'          => 'name',
			'label'         => __t("Name"),
			'type'          => 'model_function',
			'function_name' => 'getNameHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => __t("Active"),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
			'on_display'    => 'checkbox',
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'  => 'parent_id',
			'type'  => 'hidden',
			'value' => $this->parentId,
		]);
		$this->xPanel->addField([
			'name'              => 'name',
			'label'             => __t("Name"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t("Name"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		if (Str::contains(Route::currentRouteAction(), 'BranchController@create')) {
			$this->xPanel->addField([
				'name'              => 'slug',
				'label'             => __t('Slug'),
				'type'              => 'text',
				'attributes'        => [
					'placeholder' => __t('Will be automatically generated from your name, if left empty'),
				],
				'hint'              => __t('Will be automatically generated from your name, if left empty'),
				'wrapperAttributes' => [
					'class' => 'form-group col-md-6',
				],
			]);
		}else{
			$this->xPanel->addField([
				'name'              => 'slug',
				'label'             => __t('Slug'),
				'type'              => 'text',
				'attributes'        => [
					'placeholder' => __t('Will be automatically generated from your name, if left empty'),
					'readonly'=> 'readonly',
				],
				'hint'              => __t('Will be automatically generated from your name, if left empty'),
				'wrapperAttributes' => [
					'class' => 'form-group col-md-6',
				],
			]);

		}
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => __t('Description'),
			'type'       => 'textarea',
			'attributes' => [
				'placeholder' => __t('Description'),
				'rows' => 5,
			],
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
