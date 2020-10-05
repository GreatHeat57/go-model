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

use App\Models\ModelBook;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class ModelBookObserver
{
    /**
     * Listen to the Entry deleting event.
     *
     * @param  ModelBook $modelbook
     * @return void
     */
    public function deleting(ModelBook $modelbook)
    {   
        // Remove modelbook files (if exists)
        if (!empty($modelbook->filename)) {
            Storage::delete($modelbook->filename);
        }
        if(!empty($modelbook->cropped_image))
        {
            Storage::delete($modelbook->cropped_image);
        }
    }
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  ModelBook $modelbook
     * @return void
     */
    public function saved(ModelBook $modelbook)
    {
        // Removing Entries from the Cache
        $this->clearCache($modelbook);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  ModelBook $modelbook
     * @return void
     */
    public function deleted(ModelBook $modelbook)
    {
        // Removing Entries from the Cache
        $this->clearCache($modelbook);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $modelbook
     */
    private function clearCache($modelbook)
    {
		$limit = config('larapen.core.selectModelBookInto', 5);
        Cache::forget('modelbooks.take.' . $limit . '.where.user.' . $modelbook->user_id);
		Cache::forget('modelbook.where.user.' . $modelbook->user_id);
    }
}
