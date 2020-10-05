<?php

namespace Larapen\Admin\PanelTraits;

use App\Models\Language;
use Illuminate\Support\Facades\Route;
use App\Models\BlogCategory;
use App\Models\UserProfile;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Support\Str;

trait Create
{
    /*
    |--------------------------------------------------------------------------
    |                                   CREATE
    |--------------------------------------------------------------------------
    */

    /**
     * Insert a row in the database.
     *
     * @param $data
     * @return mixed
     */
    public function create($data)
    {   
        $values_to_store = $this->compactFakeFields($data, 'create');
        
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BranchController') || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\CategoryController') || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\PageController') || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\ModelCategoryController')){

            // check fields slug exist
            if(isset($data['slug']) && !empty($data['slug'])){
            
                $slug = $data['slug'];
            }
            else{
                
                $slug = $data['name'];
            }
            // call slug create function in common helper file
            $values_to_store['slug'] = \App\Helpers\CommonHelper::setSlugName($slug);
        }
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\UserController@store')){
            // if user type is autor, active this user
            if(isset($values_to_store['user_type_id']) && $values_to_store['user_type_id'] == 5){

                $values_to_store['active'] = 1;
            }
        }
        $item = $this->model->create($values_to_store);

        // check action
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\UserController@store')){

            // entry to user profile table
            $userProfile = new UserProfile();
            $userProfile->user_id = $item['id'];
            
            if(isset($values_to_store['logo']) && !empty($values_to_store['logo']) && file_exists($_FILES['logo']['tmp_name'])){
                
                $userProfile->logo = userProfile::saveLogo($values_to_store['logo'], $item['id']);
            }

            $userProfile->save();
        }

        // Purge cache, if new blog entry is created.
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogEntryController@store')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogCategoryController@store')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogTagController@store')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\ModelCategoryController@store')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BranchController@store')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\PageController@store')) {
            
                ResponseCache::clear();
                
        }
        
        // Create translations entries - If model has translatable fields
        $this->createTranslations($item, $values_to_store);

        // if there are any relationships available, also sync those
        $this->syncPivot($item, $data);

        return $item;
    }

    /**
     * Get all fields needed for the ADD NEW ENTRY form.
     *
     * @return mixed
     */
    public function getCreateFields()
    {
        return $this->create_fields;
    }

    /**
     * Get all fields with relation set (model key set on field).
     *
     * @param string $form
     * @return array
     */
    public function getRelationFields($form = 'create')
    {
        if ($form == 'create') {
            $fields = $this->create_fields;
        } else {
            $fields = $this->update_fields;
        }

        $relationFields = [];

        foreach ($fields as $field) {
            if (isset($field['model'])) {
                array_push($relationFields, $field);
            }

            if (isset($field['subfields']) &&
                is_array($field['subfields']) &&
                count($field['subfields'])) {
                foreach ($field['subfields'] as $subfield) {
                    array_push($relationFields, $subfield);
                }
            }
        }

        return $relationFields;
    }

    /**
     * @param $model
     * @param $data
     * @param string $form
     */
    public function syncPivot($model, $data, $form = 'create')
    {
        $fields_with_relationships = $this->getRelationFields($form);

        foreach ($fields_with_relationships as $key => $field) {
            if (isset($field['pivot']) && $field['pivot']) {
                $values = isset($data[$field['name']]) ? $data[$field['name']] : [];
                $model->{$field['name']}()->sync($values);

                if (isset($field['pivotFields'])) {
                    foreach ($field['pivotFields'] as $pivotField) {
                        foreach ($data[$pivotField] as $pivot_id =>  $field) {
                            $model->{$field['name']}()->updateExistingPivot($pivot_id, [$pivotField => $field]);
                        }
                    }
                }
            }

            if (isset($field['morph']) && $field['morph']) {
                $values = isset($data[$field['name']]) ? $data[$field['name']] : [];
                if ($model->{$field['name']}) {
                    $model->{$field['name']}()->update($values);
                } else {
                    $model->{$field['name']}()->create($values);
                }
            }
        }
    }

    /**
     * Fix the 'translation_of' field for the default language entry &
     * Create translations entries - If model has translatable fields
     *
     * @param $item
     * @param $values_to_store
     */
    private function createTranslations($item, $values_to_store)
    {   
        if (property_exists($this->model, 'translatable')) {
            // Set 'translation_of' value when creating new entry.
            if (!empty($item)) {
                if ($item->hasAttribute('translation_of')) {
                    if (!isset($item->translation_of) || empty($item->translation_of)) { 
                        
                        $item->translation_of = $item->id;
                        $item->save();
                    }
                } else { 
                     
                    // blogCategory column translation_of not update first inserted record
                    if (!Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogCategoryController') AND !Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogEntryController') AND !Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BranchController') AND !Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\CategoryController') AND !Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\ModelCategoryController') AND !Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\PackageController')) { 

                        $item->setTranslationOfAttribute($item->id);
                        $item->save();

                    }else{

                        // store country wise package translations
                        if(Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\PackageController')){
                            
                            $item->translation_of = $item->id;
                            $item->save();
                            
                            $item->setCountryTranslations($item);
                        }
                    }
                }
            }

            if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogEntryController')){

                $parent_category = $values_to_store['category_id'];
                // get parent blog category 
                $categories = BlogCategory::where('translation_of', $parent_category)->where('active', 1)->pluck('id', 'translation_lang')->toArray();
            }
            
            // Copy-Paste for all languages
            $languages = Language::where('active', 1)->where('abbr', '!=', $item->translation_lang)->get();
            if (!empty($languages)) {
                foreach ($languages as $language) {

                    $values_to_store['translation_lang'] = $language->abbr;
                    $values_to_store['translation_of'] = $item->id;

                    if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogTagController')){
                        // call function cteate slug in common helper file
                        $values_to_store['slug'] = \App\Helpers\CommonHelper::setSlugName($values_to_store['tag'], $language->abbr);
                    } 

                    if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogCategoryController')){

                        // call function cteate slug in common helper file
                        $values_to_store['slug'] = \App\Helpers\CommonHelper::setSlugName($values_to_store['name'], $language->abbr);
                    }

                    if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogEntryController')){

                        // call function cteate slug in common helper file
                        $values_to_store['slug'] = \App\Helpers\CommonHelper::setSlugName($values_to_store['name'], $language->abbr);

                        if(isset($categories[$language->abbr]) && !empty($categories[$language->abbr])){

                            $values_to_store['category_id'] = $categories[$language->abbr];
                        }else{

                            // get parent category
                            $getParent = BlogCategory::select('name', 'slug', 'id')->where('id', $parent_category)->where('active', 1)->first();
                            
                            $newBlogCategoryCreate = array();
                            $newBlogCategoryCreate['translation_lang'] = $language->abbr;
                            $newBlogCategoryCreate['translation_of'] = $parent_category;
                            $newBlogCategoryCreate['country_code'] = strtoupper($language->abbr);
                            $newBlogCategoryCreate['name'] = $getParent->name;

                            // call function cteate slug in common helper file
                            $newBlogCategoryCreate['slug']  = \App\Helpers\CommonHelper::setSlugName($getParent->slug, $language->abbr);

                            $newBlogCategoryCreate['active'] = 1;

                            // Store the Blog Category
                            $newBlogCategoryCreate = new BlogCategory($newBlogCategoryCreate);
                            $newBlogCategoryCreate->save();

                            $values_to_store['category_id'] = $newBlogCategoryCreate->id;
                        }
                    } 

                    // check if request frmo package controller then skip default translations creations
                    if (!Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\PackageController')){
                        $translatedItem = $this->model->create($values_to_store);
                    }
                }
            }
        }
    }
}
