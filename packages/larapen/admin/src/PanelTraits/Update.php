<?php

namespace Larapen\Admin\PanelTraits;

use App\Models\Language;
use Illuminate\Support\Facades\Route;
use App\Models\UserProfile;
use App\Models\JobsTranslation;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Support\Str;

trait Update
{
    /*
    |--------------------------------------------------------------------------
    |                                   UPDATE
    |--------------------------------------------------------------------------
    */

    /**
     * Update a row in the database.
     *
     * @param  [Int] The entity's id
     * @param  [Request] All inputs to be updated.
     *
     * @return [Eloquent Collection]
     */
    public function update($id, $data)
    {   
        $item = $this->model->findOrFail($id);
        if (str_contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\CountryController@update')){
            $is_change_country_type = false;
            if($item->country_type != $data['country_type']){
                $is_change_country_type = true;
            }
        }
        $values_to_store = $this->compactFakeFields($data, 'update');
        $updated = $item->update($values_to_store);
        // save job translations
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\PostController@update')){
            if(isset($data['translation_lang'])){ 

                $translations_lang = $data['translation_lang'];
                $jobsTranslation = JobsTranslation::where('job_id', $item['id'])->where('translation_lang', $translations_lang)->first();
                
                if(!empty($jobsTranslation)){

                    $jobsTranslation->description = $data['description'];
                    $jobsTranslation->title = $data['title'];
                    $jobsTranslation->save();
                }else{
                    $jobsTranslation = new JobsTranslation();
                    $jobsTranslation->job_id = $item['id'];
                    $jobsTranslation->translation_lang = $translations_lang;
                    $jobsTranslation->description = $data['description'];
                    $jobsTranslation->title = $data['title'];
                    $jobsTranslation->save();
                }
            }
        }
        
        // check action
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\UserController@update')){
                
            // entry to user profile data
            $userProfile =  UserProfile::where('user_id', $item['id'])->first();

            if(empty($userProfile)){
                
                $userProfile = new UserProfile();
                $userProfile->user_id = $item['id'];
            }
            
            if(isset($values_to_store['logo']) && !empty($values_to_store['logo']) && file_exists($_FILES['logo']['tmp_name'])){
                
                $oldImg = $userProfile->logo;
                // upload image in folder
                $userProfile->logo = UserProfile::saveLogo($values_to_store['logo'], $item['id']);
                
                
                // unlink image
                if (isset($oldImg) && $oldImg != "" && file_exists(public_path('uploads/'.$oldImg))){ 
                    
                    unlink(public_path('uploads/'.$oldImg));
                }
            }
            
            $userProfile->save();
        }

        // update partner user register type for partner
        if (str_contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\CountryController@update')){
            if($is_change_country_type == true){
             $user = \App\Models\User::where('user_type_id', config('constant.partner_type_id'))->where('country_code', $data['code'])
                ->update( 
                       array( 
                             "user_register_type" => $data['country_type']
                             )
                       );
            }
        }

        // Purge cache, if blog entry is updated.
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogEntryController@update')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogCategoryController@update')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogTagController@update')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\ModelCategoryController@update')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BranchController@update')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\PageController@update')) {
            ResponseCache::clear();
        }

        return $item;
    }

    /**
     * Get all fields needed for the EDIT ENTRY form.
     *
     * @param  [integer] The id of the entry that is being edited.
     * @param int $id
     *
     * @return [array] The fields with attributes, fake attributes and values.
     */
    public function getUpdateFields($id)
    {
        $fields = $this->update_fields;
        $entry = $this->getEntry($id);

        foreach ($fields as $k => $field) {
            // set the value
            if (! isset($fields[$k]['value'])) {
                if (isset($field['subfields'])) {
                    $fields[$k]['value'] = [];
                    foreach ($field['subfields'] as $key => $subfield) {
                        $fields[$k]['value'][] = $entry->{$subfield['name']};
                    }
                } else {
                    $fields[$k]['value'] = $entry->{$field['name']};
                }
            }
        }

        // always have a hidden input for the entry id
        $fields['id'] = [
                        'name'  => $entry->getKeyName(),
                        'value' => $entry->getKey(),
                        'type'  => 'hidden',
                    ];

        return $fields;
    }

    /**
     * Update translations entries - If model has translatable fields
     *
     * @param $item
     * @param $values_to_store
     */
    private function updateTranslations($item, $values_to_store)
    {
        if (property_exists($this->model, 'translatable')) {
            // If the entry is a default language entry, copy-paste its translations common data
            if ($item->id == $item->translation_of) {
                // ... AND don't select the current translated entry to prevent infinite recursion
                $entries = $this->model->where('id', '!=', $item->id)->where('translation_of', $item->translation_of)->get();

                // Copy-Paste for all languages
                if (!empty($entries)) {
                    foreach ($entries as $entry) {
                        // Update the entry values
                        foreach ($values_to_store as $field => $value) {
                            // Reject all non fillable fields
                            if (!$this->model->isFillable($field)) {
                                continue;
                            }
                            // Don't overwrite translatable data
                            if (in_array($field, $this->model->translatable)) {
                                continue;
                            }
                            $entry->{$field} = $value;
                        }
                        // Save
                        $entry->save();
                    }
                }
            }
        }
    }
}
