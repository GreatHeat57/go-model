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

use App\Models\BlogCategory;
use App\Models\BlogEntry;
use Illuminate\Support\Facades\Cache;

class BlogCategoryObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function deleting(BlogCategory $blogCategory)
    {
        // Delete all translated entries
        $blogCategory->translated()->delete();
    
        // Delete all the postType's posts
        $posts = BlogEntry::where('category_id', $blogCategory->id)->get();
        if (!empty($posts)) {
            foreach ($posts as $post) {
                $post->delete();
            }
        }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function saved(BlogCategory $blogCategory)
    {
        // Removing Entries from the Cache
        $this->clearCache($blogCategory);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function deleted(BlogCategory $blogCategory)
    {
        // Removing Entries from the Cache
        $this->clearCache($blogCategory);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $postType
     */
    private function clearCache($blogCategory)
    {
        Cache::flush();
    }
}
