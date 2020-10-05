<?php

namespace Larapen\Admin\PanelTraits;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Support\Str;

trait Delete
{
    /*
    |--------------------------------------------------------------------------
    |                                   DELETE
    |--------------------------------------------------------------------------
    */

    /**
     * Delete a row from the database.
     *
     * @param  [int] The id of the item to be deleted.
     * @param int $id
     *
     * @return [bool] Deletion confirmation.
     *
     * TODO: should this delete items with relations to it too?
     */
    public function delete($id)
    {
        $result = $this->model->destroy($id);

        // Purge cache, if blog entry is deleted.
        if ($result == true 
            && Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogEntryController')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogCategoryController')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BlogTagController')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\ModelCategoryController')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\BranchController')
            || Str::contains(Route::currentRouteAction(), 'App\Http\Controllers\Admin\PageController')) {

            ResponseCache::clear();
            
        }

        return $result;
    }
}
