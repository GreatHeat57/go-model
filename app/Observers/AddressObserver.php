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

use Illuminate\Support\Facades\Cache;

class AddressObserver {
	/**
	 * Listen to the Entry deleting event.
	 *
	 * @param  UserProfile $profile
	 * @return void
	 */
	public function deleting(UserAddress $address) {
		// Remove UserProfile files (if exists)
		// if (!empty($profile->logo)) {
		// 	$logo = str_replace('uploads/', '', $profile->logo);
		// 	Storage::delete($logo);
		// }

		// if (!empty($profile->cover)) {
		// 	$cover = str_replace('uploads/', '', $profile->cover);
		// 	Storage::delete($cover);
		// }
	}

	/**
	 * Listen to the Entry saved event.
	 *
	 * @param  UserProfile $profile
	 * @return void
	 */
	public function saved(UserAddress $address) {
		// Removing Entries from the Cache
		$this->clearCache($profile);
	}

	/**
	 * Listen to the Entry deleted event.
	 *
	 * @param  UserProfile $profile
	 * @return void
	 */
	public function deleted(UserAddress $address) {
		// Removing Entries from the Cache
		$this->clearCache($profile);
	}

	/**
	 * Removing the Entity's Entries from the Cache
	 *
	 * @param $profile
	 */
	private function clearCache($address) {
		$limit = config('larapen.core.selectUserAddressInto', 5);
		Cache::forget('UserAddress.take.' . $limit . '.where.user.' . $address->user_id);
		Cache::forget('UserAddress.where.user.' . $address->user_id);
	}
}
