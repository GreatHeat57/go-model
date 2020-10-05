<?php

namespace Larapen\Admin\app\Http\Controllers\Features;

trait ShowDetailsRow
{
    /**
     * Used with AJAX in the list view (datatables) to show extra information about that row that didn't fit in the table.
     * It defaults to showing all connected translations and their CRUD buttons.
     *
     * It's enabled by:
     * - setting the $crud['details_row'] variable to true;
     * - adding the details route for the entity; ex: Route::get('page/{id}/details', 'PageCrudController@showDetailsRow');
     *
     * @param $id (Parent ID)
     * @param null $childId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showDetailsRow($id, $childId = null)
    {
        if (!empty($childId)) {
            $id = $childId;
        }

        //check if package model is active then show package list by country wise.
        if($this->xPanel->entity_name === 'Package'){

            // Get the info for that entry
            $model = $this->xPanel->model;
            $this->data['entry'] = $model::find($id);
            //$this->data['entry']->addFakes($this->getFakeColumnsAsArray());
            $this->data['original_entry'] = $this->data['entry'];
            $this->data['xPanel'] = $this->xPanel;

            if (property_exists($model, 'translatable')) {
                $this->data['translations'] = $model::where('translation_of', $id)->where('id','!=', $id)->get();

                $languages = $model::where('translation_of', $id)->where('id','!=', $id)->pluck('translation_lang', 'id')->toArray();

                $country_languages = \App\Models\Language::select('languages.*')->withoutGlobalScopes()
                ->leftJoin('countries', 'languages.abbr', \DB::raw('lower(countries.code)'))
                ->where('countries.active', 1)->get();

                if(isset($languages) && !empty($languages)){
                    $langArr = \App\Models\Language::withoutGlobalScopes()->whereIn('abbr', $languages)->get();
                }

                // create a list of languages the item is not translated in
                $this->data['languages'] = $country_languages;

                $this->data['languages_already_translated_in'] = $langArr;

                $this->data['languages_to_translate_in'] = $this->data['languages']->diff($this->data['languages_already_translated_in']);

                $this->data['languages_to_translate_in'] = $this->data['languages_to_translate_in']->reject(function ($item) {
                    return $item->abbr == \Lang::locale();
                });
            }
        } else{

            // Get the info for that entry
            $model = $this->xPanel->model;
            $this->data['modelname'] = class_basename($model);
            $this->data['entry'] = $model::find($id);
            //$this->data['entry']->addFakes($this->getFakeColumnsAsArray());
            $this->data['original_entry'] = $this->data['entry'];
            $this->data['xPanel'] = $this->xPanel;

            if (property_exists($model, 'translatable')) {
                $this->data['translations'] = $this->data['entry']->translations();
                // create a list of languages the item is not translated in
                $this->data['languages'] = \App\Models\Language::where('active', 1)->get();
                $this->data['languages_already_translated_in'] = $this->data['entry']->translationLanguages();
                $this->data['languages_to_translate_in'] = $this->data['languages']->diff($this->data['languages_already_translated_in']);
                $this->data['languages_to_translate_in'] = $this->data['languages_to_translate_in']->reject(function ($item) {
                    return $item->abbr == \Lang::locale();
                });
            }
        }

        return view('admin::panel.details_row', $this->data);
    }
}
