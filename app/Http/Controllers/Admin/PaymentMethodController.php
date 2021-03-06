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

use App\Models\Country;
use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\PaymentMethodRequest as StoreRequest;
use App\Http\Requests\Admin\PaymentMethodRequest as UpdateRequest;

class PaymentMethodController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\PaymentMethod');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/payment_method');
		$this->xPanel->setEntityNameStrings(__t('payment method'), __t('payment methods'));
		$this->xPanel->enableReorder('display_name', 1);
		$this->xPanel->allowAccess(['reorder']);
		$this->xPanel->denyAccess(['create', 'delete']);
		if (!request()->input('order')) {
			$this->xPanel->orderBy('lft', 'ASC');
		}
		
		// Get Countries codes
		$countries = Country::get(['code']);
		$countriesCodes = [];
		if ($countries->count() > 0) {
			$countriesCodes = $countries->keyBy('code')->keys()->toArray();
		}
		
		// Get the current Entry
		$entry = null;
		if (request()->segment(4) == 'edit') {
			$entry = $this->xPanel->model->find(request()->segment(3));
		}
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'display_name',
			'label' => __t("Name"),
		]);
		$this->xPanel->addColumn([
			'name'  => 'description',
			'label' => __t("Description"),
		]);
		$this->xPanel->addColumn([
			'name'          => 'countries',
			'label'         => __t("Countries"),
			'type'          => 'model_function',
			'function_name' => 'getCountriesHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => __t("Active"),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'       => 'display_name',
			'label'      => __t("Name"),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => __t("Name"),
			],
		]);
		$this->xPanel->addField([
			'name'       => 'description',
			'label'      => __t('Description'),
			'type'       => 'textarea',
			'attributes' => [
				'placeholder' => __t('Description'),
			],
			'hint'       => __t('HTML tags are supported'),
		]);
		
		$countriesFieldParams = [
			'name'       => 'countries',
			'label'      => __t('Countries Codes'),
			'type'       => 'text',
			'attributes' => [
				'placeholder' => __t('Countries Codes') . ' (' . __t('separated by commas') . ')',
			],
			'hint'       => '<strong>' . __t('Enter the codes (ISO 3166-1 alpha-2 code  (separated by commas)) of the countries in which this payment method is used Use the codes below or leave blank to allow this method of payment to be accepted in all countries') . ':</strong><br>' . implode(', ', $countriesCodes),
		];
		if (!empty($entry)) {
			$countriesFieldParams['value'] = $entry->countries;
		}
		$this->xPanel->addField($countriesFieldParams);
		
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
