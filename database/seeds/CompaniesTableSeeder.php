<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '1',
                'name' => 'gomodels',
                'logo' => NULL,
                'description' => 'go-models.com',
                'country_code' => 'AT',
                'city_id' => '0',
                'address' => NULL,
                'phone' => NULL,
                'fax' => NULL,
                'email' => NULL,
                'website' => NULL,
                'facebook' => NULL,
                'twitter' => NULL,
                'linkedin' => NULL,
                'googleplus' => NULL,
                'pinterest' => NULL,
                'created_at' => '2018-03-19 12:22:44',
                'updated_at' => '2018-03-19 12:22:44',
            ),
            1 => 
            array (
                'id' => '3',
                'user_id' => '6',
                'name' => 'picturesbykathy',
                'logo' => NULL,
                'description' => 'Hello! I am a photographer from Austria!',
                'country_code' => 'AT',
                'city_id' => '0',
                'address' => NULL,
                'phone' => NULL,
                'fax' => NULL,
                'email' => NULL,
                'website' => NULL,
                'facebook' => NULL,
                'twitter' => NULL,
                'linkedin' => NULL,
                'googleplus' => NULL,
                'pinterest' => NULL,
                'created_at' => '2018-03-21 20:18:01',
                'updated_at' => '2018-03-21 20:18:01',
            ),
        ));
        
        
    }
}