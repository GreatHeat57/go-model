<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\LtmTranslations;
use DB;

class StringTranslationController extends Controller
{
    public $file_path = '';
    public $lanugage = '';
    public $extension = '.php';

    public function __construct()
	{
		$this->file_path = resource_path('lang/');
		$this->lanugage = Language::pluck('abbr', 'id')->toArray();
	}

    public function readFromLanguageFile($locale = null, $filename = null, $ext1 = null, $ext2 = null, $ext3 = null){

        if( isset($ext1) && $ext1 != "" ){
            $filename .= '/'.$ext1;
        }

        if( isset($ext2) && $ext2 != "" ){
            $filename .= '/'.$ext2;
        }

        if( isset($ext3) && $ext3 != "" ){
            $filename .= '/'.$ext3;
        }


    	$content = array();

    	// if( isset($locale) && !empty($locale) && in_array($locale, $this->lanugage) ){
        if( isset($locale) && !empty($locale) ){
    		
    		if(file_exists($this->file_path.'/'.$locale.'/'.$filename.$this->extension)){
    			
    			$content = include $this->file_path.'/'.$locale.'/'.$filename.$this->extension;
    			$sub_array = array();

                // echo "<pre>"; print_r ($content); echo "</pre>"; exit();

    			if(isset($content) && !empty($content) && count($content) > 0){
    				foreach ($content as $key => $value) {
    					if(is_array($value)){

    						$return = $this->recusrsionArray($key, $value);
    						$sub_array = array_merge($sub_array, $return);
    						unset($content[$key]);

    						if(!empty($sub_array)){
    							$content = array_merge($content, $sub_array);
    						}
    					}else{
    						$content[$key] = htmlspecialchars($value);
    					}
    				}
    			}

    			if(isset($content) && !empty($content) && count($content) > 0 ){
    				$content = $this->createInsertArray($content, $locale, $filename);

    				if(!empty($content)){

    					foreach ($content as $key => $transArr) {
	    					
                            $update = LtmTranslations::where(DB::raw('BINARY `key`'), $transArr['key'])
                                                    ->where('group', $transArr['group'])
                                                    ->where('locale', $transArr['locale'])
                                                    ->first();

                            if(isset($update) && !empty($update)){
                                try{
                                    $update->update($transArr);
                                }catch(Exceptions $e){
                                    echo json_encode(['status' => 'false', 'message' => $e->getMessage()]); exit();
                                }
                            }else{
                                try{
                                    LtmTranslations::insert($transArr);
                                }catch(Exceptions $e){
                                    echo json_encode(['status' => 'false', 'message' => $e->getMessage()]); exit();
                                }
                            }
    					}

    					echo json_encode(['status' => 'true', 'message' => 'Translation string sync successfully']); exit();
    				}
    			} else {
                    echo json_encode(['status' => 'false', 'message' => 'Records not found']); exit();
		    	}

    		} else {
                echo json_encode(['status' => 'false', 'message' => 'file dose not exist in translations']); exit();
            }

    	}else{
    		echo json_encode(['status' => 'false', 'message' => 'Invalid locale found']); exit();
    	}

    }

    function recusrsionArray($keyname, $array, $subkeyname = ''){
    	$formArr = array();

    	if( isset($array) && count($array) > 0 ){
    		foreach ($array as $key => $value) {

    			if(is_array($value)){
    				$res = $this->recusrsionArray($keyname, $value, $key);
    				$formArr = array_merge($formArr, $res);
    			}else{
    				if($subkeyname != ""){
    					$formArr[$keyname.'.'.$subkeyname.'.'.$key] = htmlspecialchars($value);
    				}else{
    					$formArr[$keyname.'.'.$key] = htmlspecialchars($value);
    				}
    			}
    		}
    	}

    	return $formArr;
    }

    function createInsertArray($mainArray, $locale = null, $filename = null){
    	$returnArr = array();

    	if(isset($mainArray) && !empty($mainArray) && count($mainArray) > 0 ){
    		$icount = 0;
    		foreach ($mainArray as $key => $value) {

    			$returnArr[$icount]['status'] = 1;
    			$returnArr[$icount]['locale'] = $locale;
    			$returnArr[$icount]['group'] = $filename;
    			$returnArr[$icount]['key'] = $key;
    			$returnArr[$icount]['value'] = $value;
    			$returnArr[$icount]['created_at'] = date('Y-m-d H:i:s');
    			$returnArr[$icount]['updated_at'] = date('Y-m-d H:i:s');

    			$icount++;
    		}
    	}

    	return $returnArr;
    }
}
