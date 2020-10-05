<?php

use Illuminate\Database\Seeder;

class HomeSectionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('home_sections')->delete();
        
        \DB::table('home_sections')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'Search Form Area',
                'method' => 'getSearchForm',
                'options' => NULL,
                'view' => 'home.inc.search',
                'parent_id' => '0',
                'lft' => '0',
                'rgt' => '0',
                'depth' => '1',
                'active' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'Sponsored Ads',
                'method' => 'getSponsoredPosts',
                'options' => NULL,
                'view' => 'home.inc.featured',
                'parent_id' => '0',
                'lft' => '2',
                'rgt' => '3',
                'depth' => '1',
                'active' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'name' => 'Latest Ads',
                'method' => 'getLatestPosts',
                'options' => NULL,
                'view' => 'home.inc.latest',
                'parent_id' => '0',
                'lft' => '4',
                'rgt' => '5',
                'depth' => '1',
                'active' => '1',
            ),
            3 => 
            array (
                'id' => '4',
                'name' => 'Categories',
                'method' => 'getCategories',
                'options' => NULL,
                'view' => 'home.inc.categories',
                'parent_id' => '0',
                'lft' => '6',
                'rgt' => '7',
                'depth' => '1',
                'active' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'name' => 'Locations & Country Map',
                'method' => 'getLocations',
                'options' => NULL,
                'view' => 'home.inc.locations',
                'parent_id' => '0',
                'lft' => '8',
                'rgt' => '9',
                'depth' => '1',
                'active' => '1',
            ),
            5 => 
            array (
                'id' => '6',
                'name' => 'Companies',
                'method' => 'getFeaturedPostsCompanies',
                'options' => NULL,
                'view' => 'home.inc.companies',
                'parent_id' => '0',
                'lft' => '10',
                'rgt' => '11',
                'depth' => '1',
                'active' => '1',
            ),
            6 => 
            array (
                'id' => '7',
                'name' => 'Mini Stats',
                'method' => 'getStats',
                'options' => NULL,
                'view' => 'home.inc.stats',
                'parent_id' => '0',
                'lft' => '12',
                'rgt' => '13',
                'depth' => '1',
                'active' => '1',
            ),
            7 => 
            array (
                'id' => '8',
                'name' => 'Advertising #1',
                'method' => 'getTopAdvertising',
                'options' => NULL,
                'view' => 'layouts.inc.advertising.top',
                'parent_id' => '0',
                'lft' => '14',
                'rgt' => '15',
                'depth' => '1',
                'active' => '0',
            ),
            8 => 
            array (
                'id' => '9',
                'name' => 'Advertising #2',
                'method' => 'getBottomAdvertising',
                'options' => NULL,
                'view' => 'layouts.inc.advertising.bottom',
                'parent_id' => '0',
                'lft' => '16',
                'rgt' => '17',
                'depth' => '1',
                'active' => '0',
            ),
        ));
        
        
    }
}