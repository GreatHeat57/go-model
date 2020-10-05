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

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Post\Traits\EditTrait;
use App\Http\Controllers\Auth\Traits\VerificationTrait;
use App\Http\Requests\EditPostRequest;
use App\Models\Company;
use App\Models\PostType;
use App\Models\Category;
use App\Models\Branch;
use App\Models\ModelCategory;
use App\Models\ExperienceType;
use App\Models\ValidValue;
use App\Models\Package;
use App\Models\PaymentMethod;
use App\Models\SalaryType;
use App\Http\Controllers\FrontController;
use App\Helpers\Localization\Helpers\Country as CountryLocalizationHelper;
use App\Helpers\Localization\Country as CountryLocalization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Helpers\UnitMeasurement;
use App\Models\Gender;
use Illuminate\Support\Facades\Gate;

class EditController extends FrontController
{
    use EditTrait, VerificationTrait;

    public $data;
    public $msg = [];
    public $uri = [];

    /**
     * EditController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        // $page_terms = $page_termsclient = array();
        // if(isset($this->pages) && !empty($this->pages) && $this->pages->count() > 0){
        //     foreach($this->pages as $page){
        //         if($page->type == "terms"){
        //             $page_terms = $page;
        //         }elseif($page->type == "termsclient") {
        //             $page_termsclient = $page;
        //         }
        //     }
        // }
        // view()->share('page_terms', $page_terms);
        // view()->share('page_termsclient', $page_termsclient);
		
        $this->middleware(function ($request, $next) {
            $this->commonQueries();
            return $next($request);
        });
    }

    /**
     * Common Queries
     */
    public function commonQueries()
    {
        // References
        $data = [];
    
        // Get Countries
        $data['countries'] = $this->countries = CountryLocalizationHelper::transAll(CountryLocalization::getCountries(), config('lang.locale'));
        $this->countries = $data['countries'];
        view()->share('countries', $data['countries']);
    
        // Get Categories
        $data['categories'] = Category::trans()->where('parent_id', 0)->with([
            'children' => function ($query) {
                $query->trans();
            },
        ])->orderBy('lft')->get();
        view()->share('categories', $data['categories']);
    
        // Get Post Types
        $data['postTypes'] = PostType::trans()->get();
        view()->share('postTypes', $data['postTypes']);
    
        // Get Salary Types
        $data['salaryTypes'] = SalaryType::trans()->get();
        view()->share('salaryTypes', $data['salaryTypes']);
	
		// Get the User's Company
		if (Auth::check()) {
			$data['companies'] = Company::where('user_id', Auth::user()->id)->get();
			view()->share('companies', $data['companies']);
        }

        // Get ModelCategories
		$cacheId = 'modelCategories.parentId.0.with.children' . config('app.locale');
		$data['modelCategories'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$modelCategories = ModelCategory::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('ordering')->get();
			
			return $modelCategories;
		});
		view()->share('modelCategories', $data['modelCategories']);

        $data['modelCategories'] = ModelCategory::trans()->where('parent_id', 0)->with([
                'children' => function ($query) {
                    $query->trans();
                },
            ])->orderBy('ordering')->get();
        $categoryArr = array();
        $categoryArr['models_category'] = array();
        $categoryArr['babyModels_category'] = array();

        $i = 0;

        if(!empty($data['modelCategories']) && $data['modelCategories']->count() > 0){

            foreach ($data['modelCategories'] as $key => $cat) { 

                if($cat->is_baby_model == 1){

                    $categoryArr['babyModels_category'][$cat->parent_id] = $cat->name;
                }else{
                    $categoryArr['models_category'][$cat->parent_id] = $cat->name;
                } 
            }
        }
        
        // view()->share('modelsCategory', $categoryArr['models_category']);
        // view()->share('babyModelsCategory', $categoryArr['babyModels_category']);

        view()->share('models_category', $categoryArr['models_category']);
        view()->share('babyModels_category', $categoryArr['babyModels_category']);
        

		// Get branches
		$cacheId = 'branches.parentId.0.with.children' . config('app.locale');
		$data['branches'] = Cache::remember($cacheId, $this->cacheExpiration, function () {
			$branches = Branch::trans()->where('parent_id', 0)->with([
				'children' => function ($query) {
					$query->trans();
				},
			])->orderBy('lft')->get();
			
			return $branches;
		});
		view()->share('branches', $data['branches']);

		// Experience types
		$data['experienceTypes'] = ExperienceType::all();
		view()->share('experienceTypes', $data['experienceTypes']);
        
        // properties
		// $property = [];
		// $validValues = ValidValue::all();
		// foreach($validValues as $val){
		// 	$translate = $val->getTranslation(app()->getLocale());
		// 	$property[$val->type][$val->id] = $translate->value;
		// }

        //$unitArr = UnitMeasurement::getUnitMeasurement();
        //$property = array_merge($property, $unitArr);

  //       $unitArr = new UnitMeasurement();
  //       $unitoptions = $unitArr->getUnit(true);
  //       $property = array_merge($property, $unitoptions);

		// $data['properties'] = $property;
		// view()->share('properties', $data['properties']);
    
        // Count Packages
        $data['countPackages'] = Package::trans()->applyCurrency()->count();
        view()->share('countPackages', $data['countPackages']);
    
        // Count Payment Methods
        $data['countPaymentMethods'] = $this->countPaymentMethods;

        $data['genders'] = Gender::trans()->get();
        view()->share('genders', $data['genders']);
    
        // Save common's data
        $this->data = $data;
    }
    
    /**
     * Show the form the create a new ad post.
     *
     * @param $postId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getForm($postId)
    {   

        if (Auth::User() && Auth::User()->user_type_id != 2) {
            // check permission to allow only for partner
            flash(t("You don't have permission to open this page"))->error();
            return redirect(config('app.locale'));
        }
        
        view()->share('uriId', $postId);

        view()->share('uriPathPageId', $postId);
        
        return $this->getUpdateForm($postId);
    }
    
    /**
     * Store a new ad post.
     *
     * @param $postId
     * @param EditPostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postForm($postId, EditPostRequest $request)
    {
        return $this->postUpdateForm($postId, $request);
    }
}
