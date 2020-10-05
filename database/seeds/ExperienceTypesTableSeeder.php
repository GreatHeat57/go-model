<?php

use Illuminate\Database\Seeder;

class ExperienceTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('experience_types')->delete();
        
        \DB::table('experience_types')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'Beginner',
                'active' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'Already experience',
                'active' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'name' => 'Professional',
                'active' => '1',
            ),
        ));
        
        
    }
}