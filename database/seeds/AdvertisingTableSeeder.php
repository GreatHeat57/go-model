<?php

use Illuminate\Database\Seeder;

class AdvertisingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('advertising')->delete();
        
        \DB::table('advertising')->insert(array (
            0 => 
            array (
                'id' => '1',
                'slug' => 'top',
                'provider_name' => 'Google AdSense',
                'tracking_code_large' => '',
                'tracking_code_medium' => '',
                'tracking_code_small' => '',
                'active' => '0',
            ),
            1 => 
            array (
                'id' => '2',
                'slug' => 'bottom',
                'provider_name' => 'Google AdSense',
                'tracking_code_large' => '',
                'tracking_code_medium' => '',
                'tracking_code_small' => '',
                'active' => '0',
            ),
        ));
        
        
    }
}