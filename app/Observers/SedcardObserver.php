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

use App\Models\Sedcard;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class SedcardObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  Sedcard $sedcard
     * @return void
     */
    public function deleting(Sedcard $sedcard)
    {
        // Remove sedcard files (if exists)
        if (!empty($sedcard->filename)) {
            
            $filename = $sedcard->filename;
            Storage::delete($filename);
        }
        if(!empty($sedcard->cropped_image)){
            Storage::delete($sedcard->cropped_image);
        }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  Sedcard $sedcard
     * @return void
     */
    public function saved(Sedcard $sedcard)
    {
        // Removing Entries from the Cache
        $this->clearCache($sedcard);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Sedcard $sedcard
     * @return void
     */
    public function deleted(Sedcard $sedcard)
    {
        // Removing Entries from the Cache
        $this->clearCache($sedcard);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $sedcard
     */
    private function clearCache($sedcard)
    {
		$limit = config('larapen.core.selectSedcardInto', 5);
        Cache::forget('sedcard.take.' . $limit . '.where.user.' . $sedcard->user_id);
		Cache::forget('sedcard.where.user.' . $sedcard->user_id);
    }
}
