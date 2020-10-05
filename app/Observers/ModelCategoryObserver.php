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

namespace App\Observer;

use App\Models\ModelCategory;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModelCategoryObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  ModelCategory $modelCategory
     * @return void
     */
    public function deleting(ModelCategory $modelCategory)
    {
        // Delete all translated modelCategoryes
        $modelCategory->translated()->delete();
	
		// Delete all the ModelCategory's Posts
        $posts = Post::where('category_id', $modelCategory->id)->get();
        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                $post->delete();
            }
        }
    
        // Don't delete the default pictures
        $defaultPicture = 'app/default/modelCategoryes/fa-folder-' . config('settings.style.app_skin', 'skin-default') . '.png';
        if (!Str::contains($modelCategory->picture, $defaultPicture)) {
            // Delete the modelCategory picture
            Storage::delete($modelCategory->picture);
        }
    
        // If the modelCategory is a parent modelCategory, delete all its children
        if ($modelCategory->parent_id == 0) {
			$subCats = ModelCategory::where('parent_id', $modelCategory->id)->get();
            if ($subCats->count() > 0) {
                foreach ($subCats as $subCat) {
					$subCat->delete();
                }
            }
        }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  ModelCategory $modelCategory
     * @return void
     */
    public function saved(ModelCategory $modelCategory)
    {
        // Removing Entries from the Cache
        $this->clearCache($modelCategory);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  ModelCategory $modelCategory
     * @return void
     */
    public function deleted(ModelCategory $modelCategory)
    {
        // Removing Entries from the Cache
        $this->clearCache($modelCategory);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $modelCategory
     */
    private function clearCache($modelCategory)
    {
        Cache::flush();
    }
}
