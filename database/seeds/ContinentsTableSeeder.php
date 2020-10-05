<?php

use Illuminate\Database\Seeder;

class ContinentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('continents')->delete();
        
        \DB::table('continents')->insert(array (
            0 => 
            array (
                'id' => '1',
                'code' => 'AF',
                'name' => 'Africa',
                'active' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'code' => 'AN',
                'name' => 'Antarctica',
                'active' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'code' => 'AS',
                'name' => 'Asia',
                'active' => '1',
            ),
            3 => 
            array (
                'id' => '4',
                'code' => 'EU',
                'name' => 'Europe',
                'active' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'code' => 'NA',
                'name' => 'North America',
                'active' => '1',
            ),
            5 => 
            array (
                'id' => '6',
                'code' => 'OC',
                'name' => 'Oceania',
                'active' => '1',
            ),
            6 => 
            array (
                'id' => '7',
                'code' => 'SA',
                'name' => 'South America',
                'active' => '1',
            ),
        ));
        
        
    }
}