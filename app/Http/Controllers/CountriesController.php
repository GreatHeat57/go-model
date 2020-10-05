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

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Torann\LaravelMetaTags\Facades\MetaTag;

class CountriesController extends FrontController
{
    /**
     * CountriesController constructor.
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

        // From Laravel 5.3.4 or above
        $this->middleware(function ($request, $next) {
            // get terms and conditions for country code wise
            $this->getTermsConditions();

            return $next($request);
        });
    }

    /**
     * @return View
     */
    public function index()
    {
        $data = [];
        
        // Meta Tags
        // MetaTag::set('title', getMetaTag('title', 'countries'));
        // MetaTag::set('description', strip_tags(getMetaTag('description', 'countries')));
        // MetaTag::set('keywords', getMetaTag('keywords', 'countries'));

        $tags = getAllMetaTagsForPage('countries');
        $title = isset($tags['title']) ? $tags['title'] : '';
        $description = isset($tags['description']) ? $tags['description'] : '';
        $keywords = isset($tags['keywords']) ? $tags['keywords'] : '';

        // Meta Tags
        MetaTag::set('title', $title);
        MetaTag::set('description', strip_tags($description));
        MetaTag::set('keywords', $keywords);

        return view('countries', $data);
    }
}
