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
use App\Http\Requests\Admin\PackageRequest as StoreRequest;
use App\Http\Requests\Admin\PackageRequest as UpdateRequest;

class PackageController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Package');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/package');
		$this->xPanel->setEntityNameStrings(__t('package'), __t('packages'));
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
			'name'  => 'name',
			'label' => __t("Name"),
		]);
		$this->xPanel->addColumn([
			'name'  => 'price',
			'label' => __t("Price"),
		]);
		$this->xPanel->addColumn([
			'name'  => 'currency_code',
			'label' => __t("Currency"),
		]);
		$this->xPanel->addColumn([
			'label'         => __t("Country"),
			'name'          => 'country_code',
			'type'          => 'model_function',
			'function_name' => 'getCountryHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => __t("Active"),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'              => 'name',
			'label'             => __t("Name"),
			'type'              => 'text',
			'hint'              => '<br>',
			'attributes'        => [
				'placeholder' => __t("Name"),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'short_name',
			'label'             => __t('Short Name'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Short Name'),
			],
			'hint'              => __t('Short name for ribbon label'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		
		$this->xPanel->addField([
			'name'              => 'price',
			'label'             => __t("Price"),
			'type'              => 'text',
			'placeholder'       => __t("Price"),
			'hint'              => '<br>',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'label'             => __t("Currency"),
			'name'              => 'currency_code',
			'model'             => 'App\Models\Currency',
			'entity'            => 'currency',
			'attribute'         => 'code',
			'type'              => 'select2',
			'hint'              => '<br>',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'tax',
			'label'             => __t("Tax"),
			'type'              => 'text',
			'placeholder'       => __t("Tax"),
			'hint'              => '<br>',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'ribbon',
			'label'             => __t('Ribbon'),
			'type'              => 'enum',
			'hint'              => __t('Show ads with ribbon when viewing ads in search results list'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'duration',
			'label'             => __t('Duration'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Duration'),
			],
			'hint'              => __t('Duration to show posts, You need to schedule the AdsCleaner command'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);	

		$this->xPanel->addField([
			'name'              => 'duration_period',
			'label'             => __t('Duration Period'),
			'type'              => 'enum',
			'hint'              => __t('Duration Period to show days, months and years'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'name'              => 'package_uid',
			'label'             => __t('Package Uid'),
			'type'              => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'name'              => 'has_badge',
			'label'             => __t("Show ads with a badge (in addition)"),
			'type'              => 'checkbox',
			'hint'              => '<br>',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'name'       => 'features',
			'label'      => t("Features"),
			'type'       => (config('settings.single.simditor_wysiwyg'))
				? 'simditor'
				: ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
			'attributes' => [
				'placeholder' => t("Features"),
				'id'          => 'pageContent',
				'rows'        => 20,
			],
		]);

		// $this->xPanel->addField([
		// 	'label'             => __t("Country"),
		// 	'name'              => 'country_code',
		// 	'model'             => 'App\Models\Country',
		// 	'entity'            => 'country',
		// 	'attribute'         => 'asciiname',
		// 	'type'              => 'select2',
		// 	'wrapperAttributes' => [
		// 		'class' => 'form-group col-md-6',
		// 	],
		// ]);

		$this->xPanel->addField([
            'label'       => __t("Country"),
            'name'        => 'country_code',
            'attribute' => 'asciiname',
            'entity' => 'country',
            'type'        => 'select_from_array',
            'options'     => $this->getActiveCountry(),
            'allows_null' => false,
            'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
        ]);

		$this->xPanel->addField([
			'name'              => 'user_type_id',
			'label'             => __t("Type"),
			'model'             => 'App\Models\UserType',
			'entity'            => 'userType',
			'attribute'         => 'name',
			'type'              => 'select2',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => __t('Description'),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => __t('Description'),
			],
		]);
		$this->xPanel->addField([
			'name'              => 'lft',
			'label'             => __t('Position'),
			'type'              => 'text',
			'hint'              => __t('Quick Reorder') . ': '
				. __t('Enter a position number') . ' '
				. __t('NOTE: High number will allow to show ads in top in ads listing Low number will allow to show ads in bottom in ads listing'),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'active',
			'label'             => __t("Active"),
			'type'              => 'checkbox',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
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

	public function getActiveCountry() {
        return \App\Models\Country::where('active', 1)->pluck('asciiname','code')->toArray();
    }
}
