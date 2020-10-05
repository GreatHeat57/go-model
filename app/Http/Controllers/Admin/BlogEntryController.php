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

use App\Models\BlogCategory;
use App\Models\BlogEntry;
use Larapen\Admin\app\Http\Controllers\PanelController;
use App\Http\Requests\Admin\BlogEntryRequest as StoreRequest;
use App\Http\Requests\Admin\BlogEntryRequest as UpdateRequest;
use App\Models\Country;
use App\Models\User;

class BlogEntryController extends PanelController
{
	public function setup()
	{
		/*
		|--------------------------------------------------------------------------
		| BASIC CRUD INFORMATION
		|--------------------------------------------------------------------------
		*/
		$this->xPanel->setModel('App\Models\BlogEntry');
		$this->xPanel->setRoute(config('larapen.admin.route_prefix', 'admin') . '/blog-entries');
		$this->xPanel->setEntityNameStrings(__t('blog_entry'), __t('blog_entries'));
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
            'name'  => 'start_date',
            'label' => "START DATE",
        ]);
        $this->xPanel->addColumn([
            'name'          => 'active',
            'label'         => __t("Active"),
            'type'          => 'model_function',
            'function_name' => 'getActiveHtml',
        ]);
        $this->xPanel->addColumn([
            'name'          => 'featured',
            'label'         => __t("Featured"),
            'type'          => 'model_function',
            'function_name' => 'getFeaturedHtml',
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
        

        // $this->xPanel->addField([
        //     'name'        => 'category_id',
        //     'label'       => __t("Category"),
        //     'type'        => 'select_from_array',
        //     'options'     => BlogCategory::where('translation_lang',\App::getLocale())->pluck('name','id')->toArray(),
        //     'allows_null' => false,
        // ]);


        $this->xPanel->addField([
            'name'        => 'category_id',
            'label'       => __t("Category"),
            'type'        => 'select_from_array',
            'options'     => $this->getBlogCategory(),
            'allows_null' => false,
        ]);

        

        // Country field
        // $this->xPanel->addField([
        //     'label' => __t("Country"),
        //     'name' => 'country_code',
        //     'model' => 'App\Models\Country', 
        //     'entity' => 'country',
        //     'attribute' => 'asciiname',
        //     'type' => 'select2',
        // ]);

        $this->xPanel->addField([
            'label'       => __t("Country"),
            'name'        => 'country_code',
            'attribute' => 'asciiname',
            'entity' => 'country',
            'type'        => 'select_from_array',
            'options'     => $this->getActiveCountry(),
            'allows_null' => false,
        ]);

        // author fields
        $this->xPanel->addField([
            'name'        => 'post_author',
            'label'       => __t("Author"),
            'type'        => 'select_from_array',
            'options'     => User::where('user_type_id' , config('constant.POST_AUTHOR_ID'))->pluck('name','id')->toArray(),
            'allows_null' => false,
        ]);

        // $this->xPanel->addField([
        //     'name'   => 'picture',
        //     'label'  => __t('Picture'),
        //     'type'   => 'image',
        //     'upload' => true,
        //     'disk'   => 'uploads',
        // ]);

        $this->xPanel->addField([
            'name'        => 'picture',
            'label'       => __t('Picture'),
            'type'        => 'simple_image',
            'upload' => true,
            'disk'   => 'uploads'
        ]);

        $this->xPanel->addField([
            'name'       => "start_date",
            'label'      => __t('start_date'),
            'type'       => "datetime_picker",
            'attributes' => [
                'placeholder' => __t('start_date'),
                'id'          => 'startDate'
            ],
        ]);
        $this->xPanel->addField([
            'name'       => "short_text",
            'label'      => __t('short_text'),
            'type'       => "textarea",
            'attributes' => [
                'placeholder' => __t('short_text'),
                'id'          => 'shortText',
                'rows'        => 5
            ],
        ]);
        $this->xPanel->addField([
            'name'       => 'long_text',
            'label'      => __t("long_text"),
            'type'       => (config('settings.single.simditor_wysiwyg'))
                ? 'simditor'
                : ((!config('settings.single.simditor_wysiwyg') && config('settings.single.ckeditor_wysiwyg')) ? 'ckeditor' : 'textarea'),
            'attributes' => [
                'placeholder' => __t("long_text"),
                'id'          => 'longText',
                'rows'        => 20,
            ],
        ]);
        $this->xPanel->addField([
            'name'  => 'tags',
            'label' => __t('Tags'),
            'type'  => 'tags',
            'value' => $this->getBlogTags()
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
            'name'  => 'active',
            'label' => __t("Active"),
            'type'  => 'checkbox',
        ]);
        $this->xPanel->addField([
            'name'  => 'featured',
            'label' => __t("Featured"),
            'type'  => 'checkbox',
        ]);
	}
	
	public function store(StoreRequest $request)
	{
		return parent::storeCrud();
	}

    public function edit($id, $lang = 'en', $childId = null)
    {
        $this->xPanel->hasAccessOrFail('update');

        if (!empty($childId)) {
            $id = $childId;
        }

        // get the info for that entry
        $this->data['entry'] = $this->xPanel->getEntry($id);
        $this->data['xPanel'] = $this->xPanel;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->xPanel->getUpdateFields($id);
        $this->data['title'] = trans('admin::messages.edit') . ' ' . $this->xPanel->entity_name;

        $this->data['id'] = $id;

        return view('admin::panel.edit', $this->data);
    }
	
	public function update(UpdateRequest $request)
	{
		return parent::updateCrud();
	}

    public function getBlogCategory() {

        // Get the current Entry
        if (request()->segment(4) == 'edit') {

            $entry = $this->xPanel->model->select('translation_lang')->find(request()->segment(3));

            $result = BlogCategory::where('translation_lang', $entry->translation_lang)->pluck('name','id')->toArray();
        }
        else{

            $result = BlogCategory::where('translation_lang', \App::getLocale())->pluck('name','id')->toArray();
        }

        return $result;
    }

    public function getBlogTags(){
        
        $str = '';
        // check current action is edit
        if (request()->segment(4) == 'edit') {

            // Get the current Entry
            $blogDetails = BlogEntry::where('id', request()->segment(3))->first();
        
            if(!empty($blogDetails) && $blogDetails->count() > 0 && !empty($blogDetails->getTags) && $blogDetails->getTags->count() > 0){
                
                // get last tag id
                $lastTagId = isset($blogDetails->getTags->last()->id) ? $blogDetails->getTags->last()->id : 0;
                
                foreach ($blogDetails->getTags as $value) {

                    if($lastTagId != $value->id){
                        
                        $str .= $value->tag.',';
                    }else{
                        
                        $str .= $value->tag;
                    }
                }
            }
        }
        return rtrim($str, ','); 
    }

    public function getActiveCountry() {
        return \App\Models\Country::where('active', 1)->pluck('asciiname','code')->toArray();
    }
}
