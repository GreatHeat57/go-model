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

use App\Models\Branch;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BranchObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Branch $branch
     * @return void
     */
    public function deleting(Branch $branch)
    {
        // Delete all translated branches
        $branch->translated()->delete();
	
		// Delete all the Branch's Posts
        $posts = Post::where('category_id', $branch->id)->get();
        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                $post->delete();
            }
        }
    
        // Don't delete the default pictures
        $defaultPicture = 'app/default/branches/fa-folder-' . config('settings.style.app_skin', 'skin-default') . '.png';
        if (!Str::contains($branch->picture, $defaultPicture)) {
            // Delete the branch picture
            Storage::delete($branch->picture);
        }
    
        // If the branch is a parent branch, delete all its children
        if ($branch->parent_id == 0) {
			$subCats = Branch::where('parent_id', $branch->id)->get();
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
     * @param  Branch $branch
     * @return void
     */
    public function saved(Branch $branch)
    {
        // Removing Entries from the Cache
        $this->clearCache($branch);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Branch $branch
     * @return void
     */
    public function deleted(Branch $branch)
    {
        // Removing Entries from the Cache
        $this->clearCache($branch);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $branch
     */
    private function clearCache($branch)
    {
        Cache::flush();
    }
}
