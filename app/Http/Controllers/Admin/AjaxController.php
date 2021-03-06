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

use Illuminate\Support\Facades\File;
use Larapen\Admin\app\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\City;
use App\Models\SubAdmin1;
use App\Models\SubAdmin2;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Prologue\Alerts\Facades\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\ResponseCache\Facades\ResponseCache;
use Illuminate\Support\Str;

class AjaxController extends Controller
{
	public static $msg = 'This feature has been turned off in demo mode';
	
    /**
     * @param $table
     * @param $field
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAjaxRequest($table, $field, Request $request)
    {   
        $primaryKey = $request->input('primaryKey');
        $status = 0;
        $result = [
            'table'      => $table,
            'field'      => $field,
            'primaryKey' => $primaryKey,
            'status'     => $status,
        ];
        
        // Check parameters
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
        }
        if (!Schema::hasTable($table)) {
            return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
        }
        if (!Schema::hasColumn($table, $field)) {
            return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
        }
        $sql = 'SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = "' . DB::getTablePrefix() . $table . '" AND COLUMN_NAME = "' . $field . '"';
        $info = DB::select(DB::raw($sql));
        if (empty($info)) {
            return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
        } else {
            if (isset($info[0]) && isset($info[0]->DATA_TYPE)) {
                if ($info[0]->DATA_TYPE != 'tinyint' && $table != 'settings') {
                    return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
                }
                if ($info[0]->DATA_TYPE != 'text' && $table == 'settings' && $field == 'value') {
                    return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
                }
            } else {
                return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
            }
        }
	
		// Check Demo Website
		if (isDemo()) {
			Alert::error(t(self::$msg))->flash();
			return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
		}
        
        // Get model namespace
        $namespace = '\\App\Models\\';
        
        // Get model name
        $model = null;
        $modelsPath = app_path('Models');
        $modelFiles = array_filter(\File::glob($modelsPath . '/' . '*.php'), 'is_file');
        if (count($modelFiles) > 0) {
            foreach ($modelFiles as $filePath) {
                $filename = last(explode('/', $filePath));
                $modelName = head(explode('.', $filename));
                
                if (!Str::contains(strtolower($filename), '.php') || Str::contains(strtolower($modelName), 'base')) {
                    continue;
                }
                
                eval('$modelChecker = new ' . $namespace . $modelName . '();');
                if (\Schema::hasTable($modelChecker->getTable())) {
                    if ($modelChecker->getTable() == $table) {
                        $model = $modelName;
                        break;
                    }
                }
            }
        }
        
        // Get table data
        $item = null;
        if (!empty($model)) {
            $model = $namespace . $model;
            $item = $model::find($primaryKey);
        }
        
        // Check item
        if (empty($item)) {
            return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
        }
        
        // UPDATE - the tinyint field
		
        if ($table == 'countries' && $field == 'active') {
        
			// COUNTRY activation (Geonames: Country, Admin Divisions & Cities data installation)
            if (strtolower(config('settings.geo_location.default_country_code')) != strtolower($item->code)) {
                $resImport = false;
                if ($item->{$field} == 0) {
                    $resImport = $this->importGeonamesSql($item->code);
                } else {
                    $resImport = $this->removeGeonamesDataByCountryCode($item->code);
                }
                
                // Save data
                if ($resImport) {
                    $item->{$field} = ($item->{$field} == 0) ? 1 : 0;
                    $item->save();
                }

                //create new package for the specific country activations
                $createPackage = \App\Models\Package::createCountryPackage($request->get('primaryKey'), $item);
                
                $isDefaultCountry = 0;
            } else {
                $isDefaultCountry = 1;
                $resImport = true;
            }
        } else if ($table == 'payments' && $field == 'active') {
	
			// PAYMENT activation
			// Save data
			$item->{$field} = ($item->{$field} == 0) ? 1 : 0;
			$item->save();
	
			// Update the 'reviewed' field of the related Post (Used by the Offline Payment plugin)
			$post = Post::find($item->post_id);
			if (!empty($post)) {
				$post->reviewed = $item->{$field};
				$post->featured = $item->{$field};
				$post->save();
			}
		} else if ($table == 'languages' && $field == 'active') {
            
            $is_active = ($item->{$field} == 0) ? 1 : 0;
            
            if($is_active == 1){
                
                // get language, default is 1
                $defaultlanguage = $model::select('locale')->where('default' , 1)->first();
                
                // default language find for locale
                $defaultlanguage = substr($defaultlanguage['locale'], 0, strpos($defaultlanguage['locale'], '_'));
                /*
                    *   insert new activated language jobs_translation
                    *   get all default language record.
                */
                DB::statement("insert into jobs_translation(job_id, translation_lang, title, description) (SELECT job_id, '".$primaryKey."', title, description FROM `jobs_translation` where translation_lang ='".$defaultlanguage."' and job_id NOT IN (SELECT job_id from jobs_translation where translation_lang = '".$primaryKey."'));");

                // // get activated language 
                // $getActivatedLanguage = $model::select('locale')->where('abbr' , $primaryKey)->first(); 

                // // target language find for locale
                // $targetLang = substr($getActivatedLanguage['locale'], 0, strpos($getActivatedLanguage['locale'], '_'));
                
                // curl: url
                // $url    =   config('app.url').'/api/migrationApiRequest';
                // $status = true;
                // $offset = 0;
                // $limit = 20;
                
                // while($status == true) {

                //     // set post fields
                //     $postData = [
                //         'action' => 'newActiveLanguageJobs',
                //         'translation_lang' => $primaryKey,
                //         'targetLang' => $targetLang,
                //         'defaultLanguage' => $defaultlanguage,
                //         'offset' => $offset,
                //         'limit'   => $limit,
                //     ];

                //     \Log::info("== new Active Language == offset =".$offset."limit".$limit);
                //     // Curl
                //     $ch =   curl_init();
                //             curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                //             curl_setopt($ch, CURLOPT_URL, $url);
                //             curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                //             curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                //             curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                //             $data = curl_exec($ch);
                //             curl_close($ch);
                //             $output = json_decode($data);
                            

                //             \Log::info("== output->status".json_encode($output));
                //             // if status false, break loop.
                //             if($output->status == false){
                                

                //                 $status = false;
                //             }else{

                //                 // increase offset in curl get record  
                //                 $offset = $offset + $limit;
                //             }
                // }
            }
            
            // Save data
            $item->{$field} = ($item->{$field} == 0) ? 1 : 0;
            $item->save();
        }else {
        	
            // Save data
            $item->{$field} = ($item->{$field} == 0) ? 1 : 0;
            $item->save(); 
            ResponseCache::clear(); 
            // Set translations
            $this->updateTranslations($model, $item, $field, $item->{$field});
        }
        
        // JS data
        $result = [
            'table'      => $table,
            'field'      => $field,
            'primaryKey' => $primaryKey,
            'status'     => 1,
            'fieldValue' => $item->{$field},
        ];
        
        if (isset($isDefaultCountry)) {
            $result['isDefaultCountry'] = $isDefaultCountry;
        }
        if (isset($resImport)) {
            $result['resImport'] = $resImport;
        }

        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);
    }
    
    
    /**
     * Import the Geonames data for the country
     *
     * @param $countryCode
     * @return bool
     */
    private function importGeonamesSql($countryCode)
    {
		// Check Demo Website
		if (isDemo()) {
			Alert::error(t(self::$msg))->flash();
			return false;
		}
		
        // Remove all country data
        $this->removeGeonamesDataByCountryCode($countryCode);
	
		// Default Country SQL File
		$filePath = storage_path('database/geonames/countries/' . strtolower($countryCode) . '.sql');
	
		// Check if file exists
		if (!File::exists($filePath)) {
			return false;
		}
	
		// Import the SQL file
		$res = importSqlFile(DB::connection()->getPdo(), $filePath, DB::getTablePrefix());
	
		return $res;
    }
    
    /**
     * Remove all the country's data
     *
     * @param $countryCode
     * @return bool
     */
    private function removeGeonamesDataByCountryCode($countryCode)
    {
		// Check Demo Website
		if (isDemo()) {
			Alert::error(t(self::$msg))->flash();
			return false;
		}
		
        $deletedRows = SubAdmin1::countryOf($countryCode)->delete();
        $deletedRows = SubAdmin2::countryOf($countryCode)->delete();
        $deletedRows = City::countryOf($countryCode)->delete();
        
        // Delete all Posts entries
        $posts = Post::countryOf($countryCode)->get();
        if ($posts->count() > 0) {
            foreach ($posts as $post) {
                $post->delete();
            }
        }
        
        return true;
    }
    
    /**
     * Update translations entries - If model has translatable fields
     *
     * @param $model
     * @param $item
     * @param $field
     * @param $value
     */
    private function updateTranslations($model, $item, $field, $value)
    {
        if (property_exists($model, 'translatable')) {
            // If the entry is a default language entry, copy-paste its translations common data
            if ($item->id == $item->translation_of) {
                // ... AND don't select the current translated entry to prevent infinite recursion
                $entries = $model::where('id', '!=', $item->id)->where('translation_of', $item->translation_of)->get();
                
                // Copy-Paste for all languages
                if (!empty($entries)) {
                    foreach ($entries as $entry) {
                        $entry->{$field} = $value;
                        $entry->save();
                    }
                }
            }
        }
    }
}
