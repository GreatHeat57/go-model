<?php

use Illuminate\Database\Seeder;

class UserProfileTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_profile')->delete();
        
        \DB::table('user_profile')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '1',
                'go_code' => NULL,
                'contract_link' => NULL,
                'package' => NULL,
                'first_name' => NULL,
                'last_name' => NULL,
                'fname_parent' => NULL,
                'lname_parent' => NULL,
                'birth_day' => NULL,
                'logo' => NULL,
                'cover' => NULL,
                'about_me' => NULL,
                'company_name' => NULL,
                'category_id' => NULL,
                'phone_number' => '4312345678',
                'ip_address' => NULL,
                'street' => NULL,
                'zip' => NULL,
                'city' => NULL,
                'country' => NULL,
                'piercing' => '0',
                'tattoo' => '0',
                'tfp' => '0',
                'allow_search' => '0',
                'description' => NULL,
                'education' => NULL,
                'experience' => NULL,
                'talent' => NULL,
                'reference' => NULL,
                'status' => 'INACTIVE',
                'height_id' => '0',
                'weight_id' => '0',
                'chest_id' => '0',
                'waist_id' => '0',
                'hips_id' => '0',
                'clothing_size_id' => '0',
                'eye_color_id' => '0',
                'hair_color_id' => '0',
                'size_id' => '0',
                'shoes_size_id' => '0',
                'skin_color_id' => '0',
                'facebook' => NULL,
                'twitter' => NULL,
                'google_plus' => NULL,
                'linkedin' => NULL,
                'instagram' => NULL,
                'pinterest' => NULL,
                'website_url' => NULL,
                'created_at' => NULL,
                'updated_at' => '2018-03-27 13:26:45',
            ),
        ));
        
        
    }
}