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
use App\Http\Requests\Admin\ReportTypeRequest as StoreRequest;
use App\Http\Requests\Admin\ReportTypeRequest as UpdateRequest;

class ReportTypeController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\ReportType');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/report_type');
		$this->xPanel->setEntityNameStrings(__t('report type'), __t('report types'));
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
			'label' => __t("Name"),
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'       => 'name',
			'label'      => __t("Name"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => __t("Name"),
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
