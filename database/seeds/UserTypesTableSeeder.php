<?php

use Illuminate\Database\Seeder;

class UserTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_types')->delete();
        
        \DB::table('user_types')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'Admin',
                'active' => '0',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'Partner',
                'active' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'name' => 'Model',
                'active' => '1',
            ),
            3 => 
            array (
                'id' => '4',
                'name' => 'Translator',
                'active' => '1',
            ),
        ));
        
        
    }
}