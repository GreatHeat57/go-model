<?php

namespace Larapen\Admin\PanelTraits;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

trait FakeFields
{
    /**
     * Refactor the request array to something that can be passed to the model's create or update function.
     * The resulting array will only include the fields that are stored in the database and their values,
     * plus the '_token' and 'redirect_after_save' variables.
     *
     * @param Request $request - everything that was sent from the form, usually \Request::all()
     * @param string  $form    - create/update - to determine what fields should be compacted
     *
     * @return array
     */
    public function compactFakeFields($request, $form = 'create')
    {
        $fake_field_columns_to_encode = [];

        // get the right fields according to the form type (create/update)
        switch (strtolower($form)) {
            case 'update':
                $fields = $this->update_fields;
                break;

            default:
                $fields = $this->create_fields;
                break;
        }

        // go through each defined field
        foreach ($fields as $k => $field) {
			if (isset($fields[$k]['type']) && $fields[$k]['type'] == 'custom_html') {
				continue;
			}
            // if it's a fake field
            if (isset($fields[$k]['fake']) && $fields[$k]['fake'] == true) {
                // add it to the request in its appropriate variable - the one defined, if defined
                if (isset($fields[$k]['store_in'])) {
                    $request[$fields[$k]['store_in']][$fields[$k]['name']] = $request[$fields[$k]['name']];

                    // remove the fake field
                    array_pull($request, $fields[$k]['name']);

                    if (! in_array($fields[$k]['store_in'], $fake_field_columns_to_encode, true)) {
                        array_push($fake_field_columns_to_encode, $fields[$k]['store_in']);
                    }
                } else {
                    //otherwise in the one defined in the $crud variable

                    $request['extras'][$fields[$k]['name']] = $request[$fields[$k]['name']];

                    // remove the fake field
                    array_pull($request, $fields[$k]['name']);

                    if (! in_array('extras', $fake_field_columns_to_encode, true)) {
                        array_push($fake_field_columns_to_encode, 'extras');
                    }
                }
            }
        }

        // json_encode all fake_value columns in the database, so they can be properly stored and interpreted
        if (count($fake_field_columns_to_encode)) {
            foreach ($fake_field_columns_to_encode as $key => $value) {
                if (!isValidJson($request[$value])) {
                    $request[$value] = json_encode($request[$value]);
                }
            }
        }

        // blog entry slug update by blog name
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogEntryController')){

            // remove special characters
            // $blog_string = preg_replace("/[^a-zA-Z0-9 ]+/", "", $request['name']);

            // $blog_slug = str_replace(" ", "-", strtolower($blog_string));
            // $request['slug'] = $blog_slug;
            
            /**
             * Call helper to make slug.
             */
           $request['slug'] = \App\Helpers\CommonHelper::setSlugName($request['name']);
        }

        // blog category slug update by blog category name
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogCategoryController')){

            // remove special characters
            // $blogCategory_string = preg_replace("/[^a-zA-Z0-9 ]+/", "", $request['name']);

            // $category_slug = str_replace(" ", "-", strtolower($blogCategory_string));
            // $request['slug'] = $category_slug;

            /**
             * Call helper to make slug.
             */
            $request['slug'] = \App\Helpers\CommonHelper::setSlugName($request['name']);
        }

        // blog tags slug update by tag name
        if (Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogTagController')){

            // remove special characters
            // $blogTags_string = preg_replace("/[^a-zA-Z0-9 ]+/", "", $request['tag']);

            // $tag_slug = str_replace(" ", "-", strtolower($blogTags_string));
            // $request['slug'] = $tag_slug;

            /**
             * Call helper to make slug.
             */
            $request['slug'] = \App\Helpers\CommonHelper::setSlugName($request['tag']);
        }
        
        // if there are no fake fields defined, this will just return the original Request in full
        // since no modifications or additions have been made to $request
        return $request;
    }
}
