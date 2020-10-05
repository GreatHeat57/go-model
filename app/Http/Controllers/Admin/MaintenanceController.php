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

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Larapen\Admin\app\Http\Controllers\Controller;
use Prologue\Alerts\Facades\Alert;

class MaintenanceController extends Controller
{
	/**
	 * CacheController constructor.
	 */
	public function __construct()
	{
		$this->middleware('demo');
	}
	
	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function down(Request $request)
	{
		// Form validation
		$rules = [
			'message' => 'max:200',
		];
		$this->validate($request, $rules);
		
		$errorFound = false;
		
		// Go to maintenance with DOWN status
		try {
			if ($request->has('message')) {
				$exitCode = Artisan::call('down', ['--message' => $request->input('message')]);
			} else {
				$exitCode = Artisan::call('down');
			}
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = __t("The website has been putted in maintenance mode");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
	
	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function up()
	{
		$errorFound = false;
		
		// Restore system UP status
		try {
			$exitCode = Artisan::call('up');
		} catch (\Exception $e) {
			Alert::error($e->getMessage())->flash();
			$errorFound = true;
		}
		
		// Check if error occurred
		if (!$errorFound) {
			$message = __t("The website has left the maintenance mode");
			Alert::success($message)->flash();
		}
		
		return redirect()->back();
	}
}
