<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserDressSizeUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_dress_size_options')
        ->insert([
        	[
	            'standard_unit' => 'XXXS',
	            'us_unit' => '0',
	            'uk_unit' => '4',
	            'at_unit' => '30'
        	],
        	[
	            'standard_unit' => 'XXS',
	            'us_unit' => '2',
	            'uk_unit' => '6',
	            'at_unit' => '32'
        	],
        	[
	            'standard_unit' => 'XS',
	            'us_unit' => '4',
	            'uk_unit' => '8',
	            'at_unit' => '34'
        	],
        	[
	            'standard_unit' => 'S',
	            'us_unit' => '6',
	            'uk_unit' => '10',
	            'at_unit' => '36'
        	],
        	[
	            'standard_unit' => 'M',
	            'us_unit' => '8',
	            'uk_unit' => '12',
	            'at_unit' => '38'
        	],
        	[
	            'standard_unit' => 'L',
	            'us_unit' => '10',
	            'uk_unit' => '14',
	            'at_unit' => '40'
        	],
        	[
	            'standard_unit' => 'XL',
	            'us_unit' => '12',
	            'uk_unit' => '16',
	            'at_unit' => '42'
        	],
        	[
	            'standard_unit' => 'XXL',
	            'us_unit' => '14',
	            'uk_unit' => '18',
	            'at_unit' => '44'
        	],
        	[
	            'standard_unit' => 'XXXL',
	            'us_unit' => '16',
	            'uk_unit' => '20',
	            'at_unit' => '46'
        	]
        ]);
    }
}
