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

use App\Models\Post;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SettingObserver
{
	/**
	 * Listen to the Entry updating event.
	 *
	 * @param  Setting $setting
	 * @return void
	 */
	public function updating(Setting $setting)
	{
		// Get the original object values
		$original = $setting->getOriginal();
		
		if (isset($original['value']) && !empty($original['value'])) {
			$original['value'] = jsonToArray($original['value']);
			
			// Remove old logo from disk (Don't remove the default logo)
			if (isset($setting->value['logo']) && isset($original['value']['logo'])) {
				if ($setting->value['logo'] != $original['value']['logo']) {
					if (!Str::contains($original['value']['logo'], config('larapen.core.logo'))) {
						Storage::delete($original['value']['logo']);
					}
				}
			}
			
			// Remove old favicon from disk (Don't remove the default favicon)
			if (isset($setting->value['favicon']) && isset($original['value']['favicon'])) {
				if ($setting->value['favicon'] != $original['value']['favicon']) {
					if (!Str::contains($original['value']['favicon'], config('larapen.core.favicon'))) {
						Storage::delete($original['value']['favicon']);
					}
				}
			}
			
			// Remove old body_background_image from disk
			if (isset($setting->value['body_background_image']) && isset($original['value']['body_background_image'])) {
				if ($setting->value['body_background_image'] != $original['value']['body_background_image']) {
					Storage::delete($original['value']['body_background_image']);
				}
			}
			
			// Enable Posts Approbation by User Admin (Post Review)
			if (isset($setting->value['posts_review_activation'])) {
				// If Post Approbation is enabled, then update all the existing Posts
				if ((int)$setting->value['posts_review_activation'] == 1) {
					Post::where('reviewed', '!=', 1)->update(['reviewed' => 1]);
				}
			}
		}
	}
    
    /**
     * Listen to the Entry saved event.
     *
     * @param  Setting $setting
     * @return void
     */
    public function saved(Setting $setting)
    {
		// If the Default Country is changed, then clear the 'country_code' from the sessions
		if (isset($setting->value['default_country_code'])) {
			session()->forget('country_code');
			session(['country_code' => $setting->value['default_country_code']]);
		}
		
        // Removing Entries from the Cache
        $this->clearCache($setting);
    }
    
    /**
     * Listen to the Entry deleted event.
     *
     * @param  Setting $setting
     * @return void
     */
    public function deleted(Setting $setting)
    {
        // Removing Entries from the Cache
        $this->clearCache($setting);
    }
    
    /**
     * Removing the Entity's Entries from the Cache
     *
     * @param $setting
     */
    private function clearCache($setting)
    {
        Cache::flush();
    }
}
