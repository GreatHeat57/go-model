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

use App\Models\BlogEntry;
use App\Models\BlogTagsToEntry;
use Illuminate\Support\Facades\Cache;

class BlogEntryObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function deleting(BlogEntry $blogEntry)
    {   
        $translated_blog = $blogEntry->langTranslation; 
        
        if(!empty($translated_blog) && count($translated_blog) > 0){
           
            $parentID = $blogEntry->id;
            $key =  count($translated_blog);

            $transArr = array();
            foreach ($translated_blog as $val) {
                $transArr[] = $val->id;
            }

            // parent blog id push in translated_blog array
            array_push($transArr, $parentID);

            // delete blog tag to entry
            $blog_tags_to_entries = BlogTagsToEntry::whereIn('entry_id', $transArr)->delete(); 
            
            // Delete all translated entries
            $blogEntry->translated()->delete(); 

            // Delete Parent blog
            $blog = BlogEntry::where('id', $parentID)->delete();
        }else{ 

            // delete blog tag to entry 
            $blog_tags_to_entries = BlogTagsToEntry::where('entry_id', $blogEntry->id)->delete();

            // delete specific translated blog 
            $blog = BlogEntry::where('id', $blogEntry->id)->delete();
        } 
        
        // Delete all the postType's posts
        // $blog_tags_to_entries = BlogTagsToEntry::where('entry_id',$blogEntry->id)->get();
        // if (!empty($blog_tags_to_entries)) {
        //     foreach ($blog_tags_to_entries as $blog_tag_to_entry) {
        //         $blog_tag_to_entry->delete();
        //     }
        // }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function saved(BlogEntry $blogEntry)
    {
        // Removing Entries from the Cache
        $this->clearCache($blogEntry);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  PostType $postType
     * @return void
     */
    public function deleted(BlogEntry $blogEntry)
    {
        // Removing Entries from the Cache
        $this->clearCache($blogEntry);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $postType
     */
    private function clearCache($blogEntry)
    {
        Cache::flush();
    }
}
