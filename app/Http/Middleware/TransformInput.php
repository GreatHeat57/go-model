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

namespace App\Http\Middleware;

use Closure;
use Mews\Purifier\Facades\Purifier;

class TransformInput
{
	/**
	 * @param $request
	 * @param Closure $next
	 * @return mixed
	 */
    public function handle($request, Closure $next)
    {
        if (in_array(strtolower($request->method()), ['post', 'put', 'patch'])) {
            $this->proccessBeforeValidation($request);
        }
        
        return $next($request);
    }

	/**
	 * @param $request
	 */
    public function proccessBeforeValidation($request)
    {
        $input = $request->all();
	
		// title
		if ($request->filled('title')) {
			$input['title'] = strCleanerLite($request->input('title'));
			$input['title'] = onlyNumCleaner($input['title']);
		}
	
		// name
		if ($request->filled('name')) {
			$input['name'] = strCleanerLite($request->input('name'));
			if ($request->filled('email') || $request->filled('phone')) {
				$input['name'] = onlyNumCleaner($input['name']);
			}
		}
	
		// contact_name
		if ($request->filled('contact_name')) {
			$input['contact_name'] = strCleanerLite($request->input('contact_name'));
			$input['contact_name'] = onlyNumCleaner($input['contact_name']);
		}

        // description
        if ($request->filled('description')) {
            if (config('settings.single.simditor_wysiwyg') || config('settings.single.ckeditor_wysiwyg')) {
				try {
                	$input['description'] = Purifier::clean($request->input('description'));
				} catch (\Exception $e) {
					$input['description'] = $request->input('description');
				}
            } else {
                $input['description'] = strCleaner($request->input('description'));
            }
        }

        // salary_min
        if ($request->filled('salary_min')) {
            $input['salary_min'] = str_replace(',', '.', $request->input('salary_min'));
            $input['salary_min'] = preg_replace('/[^0-9\.]/', '', $input['salary_min']);
        }

        // salary_max
		if ($request->filled('salary_max')) {
            $input['salary_max'] = str_replace(',', '.', $request->input('salary_max'));
			$input['salary_max'] = preg_replace('/[^0-9\.]/', '', $input['salary_max']);
		}
	
		// phone
		// if ($request->filled('phone')) {
		// 	$input['phone'] = phoneFormatInt($request->input('phone'), $request->input('country', session('country_code')));
		// }
	
		// login (phone)
		if ($request->filled('login')) {
			try{
				$loginField = getLoginField($request->input('login'));
				if ($loginField == 'phone') {
					$input['login'] = phoneFormatInt($request->input('login'), $request->input('country', session('country_code')));
				}
            }
            catch(\Exception $e){
				\Log::info('TransformInput check', ['url' => \Request::url(), 'value' => $request->input('login')]);
				\Log::info('TransformInput error message', ['message' => $e->getMessage()]);
            }
		}
        
        $request->replace($input);
    }
}
