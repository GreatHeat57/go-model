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

use App\Models\BlogTag;
use App\Models\BlogTagsToEntry;
use Illuminate\Support\Facades\Cache;

class BlogTagObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function deleting(BlogTag $blogTag)
    {
        // Delete all translated entries
        $blogTag->translated()->delete();

        // Delete all the postType's posts
        $blog_tags_to_entries = BlogTagsToEntry::where('tag_id',$blogTag->id)->get();
        foreach ($blog_tags_to_entries as $blog_tag_to_entry) {
            $blog_tag_to_entry->delete();
        }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function saved(BlogTag $blogTag)
    {
        // Removing Entries from the Cache
        $this->clearCache($blogTag);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function deleted(BlogTag $blogTag)
    {
        // Removing Entries from the Cache
        $this->clearCache($blogTag);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $postType
     */
    private function clearCache($blogTag)
    {
        Cache::flush();
    }
}
