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

namespace App\Http\Controllers\Account;

use App\Http\Requests\CompanyRequest;
use App\Models\City;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RequestFacade;
use Torann\LaravelMetaTags\Facades\MetaTag;
use App\Helpers\CommonHelper;

class CompanyController extends AccountBaseController {
	private $perPage = 10;
	public $pagePath = 'companies';

	public function __construct() {
		parent::__construct();

		$this->perPage = (is_numeric(config('settings.listing.items_per_page'))) ? config('settings.listing.items_per_page') : $this->perPage;

		view()->share('pagePath', $this->pagePath);
		view()->share('perPage', $this->perPage);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index() {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		// Get all User's Companies
		$companies = Company::myCompany(Auth::user()->id, $this->perPage, $count = null);

		$count = Company::myCompany(Auth::user()->id, $this->perPage, $count = true);

		// Meta Tags
		MetaTag::set('title', t('My Companies List - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('My Companies List - :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		// return view('account.company.index')->with('companies', $companies);
		return view('account.company.index')->with('companies', $companies)->with('count', $count)->with('paginator', $companies);
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create() {
		if (Auth::User() && Auth::User()->user_type_id != 2) {
			// check permission to allow only for partner
			flash(t("You don't have permission to open this page"))->error();
			return redirect(config('app.locale'));
		}
		// Meta Tags
		MetaTag::set('title', t('Create a new company - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('Create a new company - :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		// return view('account.company.create');
		return view('account.company.form-company');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param CompanyRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(CompanyRequest $request) {

		// Get Company Info
		$companyInfo = $request->input('company');
		if (!isset($companyInfo['user_id']) || empty($companyInfo['user_id'])) {
			$companyInfo += ['user_id' => Auth::user()->id];
		}
		if (!isset($companyInfo['country_code']) || empty($companyInfo['country_code'])) {
			$companyInfo += ['country_code' => config('country.code')];
		}

		// Create the User's Company
		$company = new Company($companyInfo);
		$company->save();

		flash(t("Your company has been created successfully"))->success();

		// Save the Company's Logo
		if ($request->hasFile('company.logo')) {
			$company->logo = $request->file('company.logo');
			$company->save();
		}

		// Redirection
		return redirect(lurl(trans('routes.account-companies')));
		// return redirect(config('app.locale') ."/".trans('routes.account-companies'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function show($id) {
		return redirect(config('app.locale') . '/'.trans('routes.account-companies').'/' . $id . '/edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id) { 

		// Get the Company
		$company = Company::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

		$citiess = array();

		if (isset($company->country_code) && !empty($company->country_code)) {
			$citiess = City::select('id', 'name')->where('country_code', $company->country_code)->orderby('name', 'asc')->get()->toArray();
		}

		$data['company'] = $company;
		$data['citiess'] = $citiess;

		// Meta Tags
		MetaTag::set('title', t('Edit the Company - :app_name', ['app_name' => config('app.app_name')]));
		MetaTag::set('description', t('Edit the Company - :app_name', ['app_name' => config('settings.app.name')]));
		CommonHelper::ogMeta();

		view()->share('uriPathPageId', $id);

		return view('account.company.form-company', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param $id
	 * @param CompanyRequest $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function update($id, CompanyRequest $request) {

		$company = Company::where('id', $id)->where('user_id', Auth::user()->id)->firstOrFail();

		if ($company) {

			// Get Company Info
			$companyInfo = $request->input('company');
			if (!isset($companyInfo['user_id']) || empty($companyInfo['user_id'])) {
				$companyInfo += ['user_id' => Auth::user()->id];
			}
			if (!isset($companyInfo['country_code']) || empty($companyInfo['country_code'])) {
				$companyInfo += ['country_code' => config('country.code')];
			}

			// Make an Update
			$company->update($companyInfo);

			flash(t("Your company has been updated successfully"))->success();

			// Save the Company's Logo
			if ($request->hasFile('company.logo')) {
				$company->logo = $request->file('company.logo');
				$company->save();
			}
		} else {
			flash(t("Unknown error, Please try again in a few minutes"))->error();

		}

		// Redirection
		// return redirect(config('app.locale') . '/account/companies');
		return redirect(lurl(trans('routes.account-companies')));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param null $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function destroy($id = null) {

		// Get Entries ID
		$ids = [];
		if (RequestFacade::filled('entries')) {
			$ids = RequestFacade::input('entries');
		} else {
			if (!is_numeric($id) && $id <= 0) {
				$ids = [];
			} else {
				$ids[] = $id;
			}
		}

		// Delete
		// $nb = 0;

		$companies = Company::whereIn('id', $ids)->where('user_id', Auth::user()->id)->get();
		
		$is_company_jobs = false;
		$companies_names = array();
		$completed_count = 0;

		if( isset($companies) && count($companies) > 0 ){
			foreach ($companies as $key => $company) {

				//If company have any jobs then do not delete it
				if( isset($company->posts) && $company->posts->count() > 0 ){
					$is_company_jobs = true;
					$companies_names[] = $company->name;
				} else {
					$completed_count++;
					$company->deleted_at = \Carbon\Carbon::now();
					$company->save();
				}
			}
		}

		if($is_company_jobs == true && count($companies_names) > 0 ){

			$company_str = implode(', ', $companies_names);

			if($completed_count == 1 ){
				flash(t("Your company has been deleted successfully"))->success();
			}else if($completed_count > 1 ){
				flash(t("Your companies have been deleted successfully"))->success();
			}

			flash(t(":companies have one or more jobs! Please remove jobs first", ['companies' => $company_str]))->error();

			return redirect(lurl(trans('routes.account-companies')));
		}

		if($completed_count == 1 ){
			flash(t("Your company has been deleted successfully"))->success();
		}else if($completed_count > 1 ){
			flash(t("Your companies have been deleted successfully"))->success();
		}else{
			flash(t("No deletion is done, Please try again"))->error();
		}

		return redirect(lurl(trans('routes.account-companies')));

		

		/*
		// foreach ($ids as $item) {
		// 	$company = Company::where('id', $item)->where('user_id', Auth::user()->id)->first();
		// 	if (!empty($company)) {
		// 		// Delete Entry
		// 		$nb = $company->delete();
		// 	}
		// }

		// Confirmation
		if ($nb == 0) {
			flash(t("No deletion is done, Please try again"))->error();
		} else {
			$count = count($ids);
			if ($count > 1) {
				flash(t("x :entities has been deleted successfully", ['entities' => t('companies'), 'count' => $count]))->success();
			} else {
				flash(t("1 :entity has been deleted successfully", ['entity' => t('company')]))->success();
			}
		}

		// return redirect(config('app.locale') . '/account/companies');
		return redirect(lurl(trans('routes.account-companies')));
		*/
	}

	public function search(Request $request) {
		 
		 
		$search = $request->get('search');

		if (isset($search) && !empty($search)) {
			$search = trim($search);
			// Get all User's Companies

			$companies = Company::where('user_id', Auth::user()->id)->where(function($query) use ($search){
				$query->where('name', 'LIKE', '%' . $search . '%')->orwhere('description', 'LIKE', '%' . $search . '%');
			});

			$count = $companies->count();
			$companies = $companies->paginate($this->perPage);
			// Meta Tags

			MetaTag::set('title', t('My Companies List'));
			MetaTag::set('description', t('My Companies List - :app_name', ['app_name' => config('settings.app.name')]));

			// return view('account.company.index')->with('companies', $companies);
			return view('account.company.index')->with('companies', $companies)->with('count', $count);
		} else {
			// return redirect(config('app.locale') . '/account/companies');
			return redirect(lurl(trans('routes.account-companies')));
		}

	}

}
