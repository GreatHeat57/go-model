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
use App\Http\Requests\Admin\CountryRequest as StoreRequest;
use App\Http\Requests\Admin\CountryRequest as UpdateRequest;
use App\Models\TimeZone;

class CountryController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\Country');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/country');
		$this->xPanel->setEntityNameStrings(__t('country'), __t('countries'));
		
		/*
		|--------------------------------------------------------------------------
		| COLUMNS AND FIELDS
		|--------------------------------------------------------------------------
		*/
		// COLUMNS
		$this->xPanel->addColumn([
			'name'  => 'code',
			'label' => __t("Code"),
		]);
		$this->xPanel->addColumn([
			'name'  => 'name',
			'label' => __t("Local Name"),
		]);
		$this->xPanel->addColumn([
			'name'          => 'asciiname',
			'label'         => __t("Name"),
			'type'          => 'model_function',
			'function_name' => 'getNameHtml',
		]);
		$this->xPanel->addColumn([
			'name'          => 'active',
			'label'         => __t("Active"),
			'type'          => 'model_function',
			'function_name' => 'getActiveHtml',
		]);
		
		// FIELDS
		$this->xPanel->addField([
			'name'              => 'code',
			'label'             => __t('Code'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Enter the country code (ISO Code)'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		], 'create');
		
		$this->xPanel->addField([
			'name'              => 'name',
			'label'             => __t('Local Name'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Local Name'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'asciiname',
			'label'             => __t("Name"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Enter the country name (In English)'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'capital',
			'label'             => __t('Capital') . ' (' . __t('Optional') . ')',
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Capital'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'continent_code',
			'label'             => __t('Continent'),
			'type'              => 'select2',
			'attribute'         => 'name',
			'model'             => 'App\Models\Continent',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'tld',
			'label'             => __t('TLD') . ' (' . __t('Optional') . ')',
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Enter the country tld (E g bj for Benin)'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'currency_code',
			'label'             => __t("Currency Code"),
			'type'              => 'select2',
			'attribute'         => 'code',
			'model'             => 'App\Models\Currency',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		if (request()->segment(4) == 'edit') {
			$this->xPanel->addField([
	            'name'        => 'time_zone_id',
	            'label'       =>__t("Default Time Zone"),
	            'type'        => 'select2_from_array',
	            'options'     => $this->getTimeZone(),
	            'wrapperAttributes' => [
					'class' => 'form-group col-md-6',
				],
	            'allows_null' => false,
	        ]); 
      	}
		$this->xPanel->addField([
			'name'              => 'phone',
			'label'             => __t("Phone Ind") . ' (' . __t('Optional') . ')',
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Enter the country phone ind (E g +229 for Benin)'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'languages',
			'label'             => __t("Languages"),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Enter the locale code (ISO) separate with comma'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		// social links
		$this->xPanel->addField([
			'name'              => 'facebook_link',
			'label'             => __t('Facebook link'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Facebook link'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'instagram_link',
			'label'             => __t('Instagram link'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Instagram link'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'twitter_link',
			'label'             => __t('Twitter link'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Twitter link'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'pinterest_link',
			'label'             => __t('Pinterest link'),
			'type'              => 'text',
			'attributes'        => [
				'placeholder' => __t('Pinterest link'),
			],
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
            'label'       => __t("feature_fallback_countries"),
            'name'        => 'feature_fallback_countries',
            'attribute' => 'asciiname',
            'entity' => 'country',
            'type'        => 'select2_from_array',
            'options'     => $this->getActiveCountry(),
            'allows_null' => false,
            'allows_multiple' => true,
            'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
        ]);

        $this->xPanel->addField([
            'name'        => 'country_type',
            'label'       =>__t("Default country_type"),
            'type'        => 'enum',
            'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
            'allows_null' => false,
        ]); 

		$this->xPanel->addField([
			'name'   => 'background_image',
			'label'  => __t("Background Image"),
			'type'   => 'image',
			'upload' => true,
			'disk'   => 'uploads',
			'hint'   => __t('Choose a picture from your computer') . '<br>' . __t('This picture will override the homepage header background image for this country'),
		]);

		$this->xPanel->addField([
			'name' => 'shoe_units',
			'label' => __t('shoe_units'),
			'type' => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'name' => 'dress_size_unit',
			'label' => __t('dress_size_unit'),
			'type' => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'name' => 'height_units',
			'label' => __t('height_units'),
			'type' => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);


		$this->xPanel->addField([
			'name' => 'weight_units',
			'label' => __t('weight_units'),
			'type' => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'name' => 'waist_units',
			'label' => __t('waist_units'),
			'type' => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name' => 'chest_units',
			'label' => __t('chest_units'),
			'type' => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name' => 'hips_units',
			'label' => __t('hips_units'),
			'type' => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name' => 'time_format',
			'label' => __t('Time Format'),
			'type' => 'enum',
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);
		$this->xPanel->addField([
			'name'              => 'admin_type',
			'label'             => __t("Administrative Division's Type"),
			'type'              => 'enum',
			'hint'              => __t("Default_value_Admin_Division_Admin_Division"),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
			],
		]);

		$this->xPanel->addField([
			'name'              => 'admin_field_active',
			'label'             => __t("Active Administrative Division's Field"),
			'type'              => 'checkbox',
			'hint'              => __t("Active the administrative division's field in the items form. You need to set the :admin_type_hint to 1 or 2.", [
				'admin_type_hint' => __t("Administrative Division's Type"),
			]),
			'wrapperAttributes' => [
				'class' => 'form-group col-md-6',
				'style' => 'margin-top: 20px;',
			],
		]);
		
		$this->xPanel->addField([
            'name'       => 'terms_conditions_model',
            'label'      => __t("Terms and Condition Model"),
            'type'       => (config('settings.single.simditor_wysiwyg'))
                ? 'simditor'
                : ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
            'attributes' => [
                'placeholder' => __t("Terms and Condition"),
                'id'          => 'terms-conditions-model',
                'rows'        => 20,
            ],
        ]);
        $this->xPanel->addField([
            'name'       => 'terms_conditions_free_model',
            'label'      => __t("Terms and Condition For Free Model"),
            'type'       => (config('settings.single.simditor_wysiwyg'))
                ? 'simditor'
                : ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
            'attributes' => [
                'placeholder' => __t("Terms and Condition For Free Model"),
                'id'          => 'terms-conditions-free-model',
                'rows'        => 20,
            ],
        ]);

        $this->xPanel->addField([
            'name'       => 'terms_conditions_client',
            'label'      => __t("Terms and Condition Client"),
            'type'       => (config('settings.single.simditor_wysiwyg'))
                ? 'simditor'
                : ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
            'attributes' => [
                'placeholder' => __t("Terms and Condition"),
                'id'          => 'terms-conditions-client',
                'rows'        => 20,
            ],
        ]);

		/*
		$this->xPanel->addField([
			'name'  => 'active',
			'label' => __t("Active"),
			'type'  => 'checkbox',
		]);
		*/
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}

	public function getTimeZone() {
		$res = array();
		// Get the current Entry
        if (request()->segment(4) == 'edit') {
			// get time zone current edit company
			$result = TimeZone::where('country_code', request()->segment(3))->pluck('time_zone_id', 'id')->toArray();
            $res[0] = '-';
            foreach ($result as $key => $val) {
        	  	$res[$key] =   $val;
            } 
		} 
		return $res;
    }

	public function getActiveCountry() {
        return \App\Models\Country::where('active', 1)->pluck('asciiname','code')->toArray();
	}

}
