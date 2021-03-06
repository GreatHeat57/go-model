<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('posts')->delete();
        
        \DB::table('posts')->insert(array (
            0 => 
            array (
                'id' => '1',
                'country_code' => 'AT',
                'user_id' => '1',
                'company_id' => '1',
                'category_id' => '1',
                'post_type_id' => '1',
                'company_name' => 'gomodels',
                'company_description' => 'go-models.com',
                'logo' => 'app/default/picture.jpg',
                'ismodel' => '1',
                'title' => 'Bikini',
                'description' => '<p>Looking for sweetable model for bikini.</p>',
                'tags' => NULL,
                'salary_min' => '100.00',
                'salary_max' => '140.00',
                'salary_type_id' => '2',
                'negotiable' => '1',
                'start_date' => '2018-05-27',
                'end_date' => '2018-05-31',
                'model_category_id' => '9',
                'partner_category_id' => '0',
                'experience_type_id' => '0',
                'gender_type_id' => '0',
                'tfp' => '0',
                'height_from' => '129',
                'height_to' => '145',
                'weight_from' => '248',
                'weight_to' => '273',
                'age_from' => '22',
                'age_to' => '32',
                'dressSize_from' => '327',
                'dressSize_to' => '327',
                'chest_from' => '102',
                'chest_to' => '105',
                'waist_from' => '103',
                'waist_to' => '116',
                'hips_from' => '66',
                'hips_to' => '79',
                'shoeSize_from' => '377',
                'shoeSize_to' => '386',
                'eyeColor' => '403',
                'hairColor' => '408',
                'skinColor' => NULL,
                'application_url' => NULL,
                'end_application' => '2018-05-24',
                'contact_name' => 'mm',
                'email' => 'goldbright00000@gmail.com',
                'phone' => '+4312345678',
                'phone_hidden' => NULL,
                'address' => NULL,
                'city_id' => '2782302',
                'lon' => '48.2194',
                'lat' => '14.4178',
                'ip_addr' => '127.0.0.1',
                'visits' => '3',
                'email_token' => NULL,
                'phone_token' => NULL,
                'tmp_token' => NULL,
                'code_token' => NULL,
                'verified_email' => '1',
                'verified_phone' => '1',
                'ismade' => '0',
                'reviewed' => '0',
                'featured' => '0',
                'archived' => '0',
                'partner' => NULL,
                'created_at' => '2018-05-20 15:17:29',
                'updated_at' => '2018-05-29 15:46:12',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => '2',
                'country_code' => 'AT',
                'user_id' => '13',
                'company_id' => '0',
                'category_id' => '0',
                'post_type_id' => NULL,
                'company_name' => NULL,
                'company_description' => NULL,
                'logo' => NULL,
                'ismodel' => '1',
                'title' => '',
                'description' => '',
                'tags' => NULL,
                'salary_min' => NULL,
                'salary_max' => NULL,
                'salary_type_id' => '1',
                'negotiable' => '0',
                'start_date' => NULL,
                'end_date' => NULL,
                'model_category_id' => '0',
                'partner_category_id' => '0',
                'experience_type_id' => '0',
                'gender_type_id' => '0',
                'tfp' => '0',
                'height_from' => '0',
                'height_to' => '0',
                'weight_from' => '0',
                'weight_to' => '0',
                'age_from' => '0',
                'age_to' => '0',
                'dressSize_from' => '0',
                'dressSize_to' => '0',
                'chest_from' => '0',
                'chest_to' => '0',
                'waist_from' => '0',
                'waist_to' => '0',
                'hips_from' => '0',
                'hips_to' => '0',
                'shoeSize_from' => '0',
                'shoeSize_to' => '0',
                'eyeColor' => NULL,
                'hairColor' => NULL,
                'skinColor' => NULL,
                'application_url' => NULL,
                'end_application' => NULL,
                'contact_name' => '',
                'email' => 'redbanan199066@gmail.com',
                'phone' => NULL,
                'phone_hidden' => '0',
                'address' => NULL,
                'city_id' => '0',
                'lon' => NULL,
                'lat' => NULL,
                'ip_addr' => NULL,
                'visits' => '0',
                'email_token' => NULL,
                'phone_token' => NULL,
                'tmp_token' => 'f081a52ffc0bf622c9811dd4ad8161dd',
                'code_token' => NULL,
                'verified_email' => '1',
                'verified_phone' => '1',
                'ismade' => '0',
                'reviewed' => '0',
                'featured' => '0',
                'archived' => '0',
                'partner' => NULL,
                'created_at' => '2018-05-21 09:41:08',
                'updated_at' => '2018-05-21 09:41:08',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => '3',
                'country_code' => 'AT',
                'user_id' => '13',
                'company_id' => '0',
                'category_id' => '0',
                'post_type_id' => NULL,
                'company_name' => NULL,
                'company_description' => NULL,
                'logo' => NULL,
                'ismodel' => '1',
                'title' => '',
                'description' => '',
                'tags' => NULL,
                'salary_min' => NULL,
                'salary_max' => NULL,
                'salary_type_id' => '1',
                'negotiable' => '0',
                'start_date' => NULL,
                'end_date' => NULL,
                'model_category_id' => '0',
                'partner_category_id' => '0',
                'experience_type_id' => '0',
                'gender_type_id' => '0',
                'tfp' => '0',
                'height_from' => '0',
                'height_to' => '0',
                'weight_from' => '0',
                'weight_to' => '0',
                'age_from' => '0',
                'age_to' => '0',
                'dressSize_from' => '0',
                'dressSize_to' => '0',
                'chest_from' => '0',
                'chest_to' => '0',
                'waist_from' => '0',
                'waist_to' => '0',
                'hips_from' => '0',
                'hips_to' => '0',
                'shoeSize_from' => '0',
                'shoeSize_to' => '0',
                'eyeColor' => NULL,
                'hairColor' => NULL,
                'skinColor' => NULL,
                'application_url' => NULL,
                'end_application' => NULL,
                'contact_name' => '',
                'email' => 'redbanan199066@gmail.com',
                'phone' => NULL,
                'phone_hidden' => '0',
                'address' => NULL,
                'city_id' => '0',
                'lon' => NULL,
                'lat' => NULL,
                'ip_addr' => NULL,
                'visits' => '0',
                'email_token' => NULL,
                'phone_token' => NULL,
                'tmp_token' => '1a1a557b17c078ac753eff20ed009d5f',
                'code_token' => NULL,
                'verified_email' => '1',
                'verified_phone' => '1',
                'ismade' => '0',
                'reviewed' => '1',
                'featured' => '1',
                'archived' => '0',
                'partner' => NULL,
                'created_at' => '2018-05-21 09:46:28',
                'updated_at' => '2018-05-21 09:46:57',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => '4',
                'country_code' => 'AT',
                'user_id' => '1',
                'company_id' => '1',
                'category_id' => '1',
                'post_type_id' => '2',
                'company_name' => 'gomodels',
                'company_description' => 'go-models.com',
                'logo' => 'app/default/picture.jpg',
                'ismodel' => '1',
                'title' => 'Swimming',
                'description' => '<p>Looking for fitness model.</p>',
                'tags' => NULL,
                'salary_min' => '100.00',
                'salary_max' => '140.00',
                'salary_type_id' => '2',
                'negotiable' => '1',
                'start_date' => '2018-05-21',
                'end_date' => NULL,
                'model_category_id' => '9',
                'partner_category_id' => '0',
                'experience_type_id' => '0',
                'gender_type_id' => '0',
                'tfp' => '0',
                'height_from' => '0',
                'height_to' => '0',
                'weight_from' => '0',
                'weight_to' => '0',
                'age_from' => '0',
                'age_to' => '0',
                'dressSize_from' => '0',
                'dressSize_to' => '0',
                'chest_from' => '0',
                'chest_to' => '0',
                'waist_from' => '0',
                'waist_to' => '0',
                'hips_from' => '0',
                'hips_to' => '0',
                'shoeSize_from' => '0',
                'shoeSize_to' => '0',
                'eyeColor' => NULL,
                'hairColor' => NULL,
                'skinColor' => NULL,
                'application_url' => NULL,
                'end_application' => NULL,
                'contact_name' => 'mm',
                'email' => 'goldbright00000@gmail.com',
                'phone' => '+4312345678',
                'phone_hidden' => NULL,
                'address' => NULL,
                'city_id' => '2782302',
                'lon' => '48.2194',
                'lat' => '14.4178',
                'ip_addr' => '127.0.0.1',
                'visits' => '4',
                'email_token' => NULL,
                'phone_token' => NULL,
                'tmp_token' => NULL,
                'code_token' => NULL,
                'verified_email' => '1',
                'verified_phone' => '1',
                'ismade' => '0',
                'reviewed' => '0',
                'featured' => '0',
                'archived' => '0',
                'partner' => NULL,
                'created_at' => '2018-05-21 14:42:26',
                'updated_at' => '2018-05-24 17:52:03',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => '5',
                'country_code' => 'AT',
                'user_id' => '1',
                'company_id' => '1',
                'category_id' => '1',
                'post_type_id' => '1',
                'company_name' => 'gomodels',
                'company_description' => 'go-models.com',
                'logo' => 'app/default/picture.jpg',
                'ismodel' => '1',
                'title' => 'Tight',
                'description' => '<p>Looking for a good sweet tight model.</p>',
                'tags' => NULL,
                'salary_min' => '100.00',
                'salary_max' => '140.00',
                'salary_type_id' => '2',
                'negotiable' => '1',
                'start_date' => '2018-05-21',
                'end_date' => '2018-10-10',
                'model_category_id' => '9',
                'partner_category_id' => '0',
                'experience_type_id' => '3',
                'gender_type_id' => '1',
                'tfp' => '1',
                'height_from' => '0',
                'height_to' => '0',
                'weight_from' => '0',
                'weight_to' => '0',
                'age_from' => '0',
                'age_to' => '0',
                'dressSize_from' => '0',
                'dressSize_to' => '0',
                'chest_from' => '0',
                'chest_to' => '0',
                'waist_from' => '0',
                'waist_to' => '0',
                'hips_from' => '0',
                'hips_to' => '0',
                'shoeSize_from' => '0',
                'shoeSize_to' => '0',
                'eyeColor' => NULL,
                'hairColor' => NULL,
                'skinColor' => NULL,
                'application_url' => NULL,
                'end_application' => '2018-10-20',
                'contact_name' => 'mm',
                'email' => 'goldbright00000@gmail.com',
                'phone' => '+4312345678',
                'phone_hidden' => NULL,
                'address' => NULL,
                'city_id' => '2782302',
                'lon' => '48.2194',
                'lat' => '14.4178',
                'ip_addr' => '127.0.0.1',
                'visits' => '17',
                'email_token' => NULL,
                'phone_token' => NULL,
                'tmp_token' => NULL,
                'code_token' => NULL,
                'verified_email' => '1',
                'verified_phone' => '1',
                'ismade' => '0',
                'reviewed' => '0',
                'featured' => '0',
                'archived' => '0',
                'partner' => NULL,
                'created_at' => '2018-05-21 14:49:27',
                'updated_at' => '2018-05-24 17:50:48',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => '6',
                'country_code' => 'AT',
                'user_id' => '13',
                'company_id' => '0',
                'category_id' => '0',
                'post_type_id' => NULL,
                'company_name' => NULL,
                'company_description' => NULL,
                'logo' => NULL,
                'ismodel' => '1',
                'title' => '',
                'description' => '',
                'tags' => NULL,
                'salary_min' => NULL,
                'salary_max' => NULL,
                'salary_type_id' => '1',
                'negotiable' => '0',
                'start_date' => NULL,
                'end_date' => NULL,
                'model_category_id' => '0',
                'partner_category_id' => '0',
                'experience_type_id' => '0',
                'gender_type_id' => '0',
                'tfp' => '0',
                'height_from' => '0',
                'height_to' => '0',
                'weight_from' => '0',
                'weight_to' => '0',
                'age_from' => '0',
                'age_to' => '0',
                'dressSize_from' => '0',
                'dressSize_to' => '0',
                'chest_from' => '0',
                'chest_to' => '0',
                'waist_from' => '0',
                'waist_to' => '0',
                'hips_from' => '0',
                'hips_to' => '0',
                'shoeSize_from' => '0',
                'shoeSize_to' => '0',
                'eyeColor' => NULL,
                'hairColor' => NULL,
                'skinColor' => NULL,
                'application_url' => NULL,
                'end_application' => NULL,
                'contact_name' => '',
                'email' => 'redbanan199066@gmail.com',
                'phone' => NULL,
                'phone_hidden' => '0',
                'address' => NULL,
                'city_id' => '0',
                'lon' => NULL,
                'lat' => NULL,
                'ip_addr' => NULL,
                'visits' => '0',
                'email_token' => NULL,
                'phone_token' => NULL,
                'tmp_token' => '34e6d225a6b616bd387be4c7df76e43c',
                'code_token' => '2b709f924d5f96dd12a51b0e623bcacf',
                'verified_email' => '1',
                'verified_phone' => '1',
                'ismade' => '1',
                'reviewed' => '1',
                'featured' => '1',
                'archived' => '0',
                'partner' => NULL,
                'created_at' => '2018-05-23 07:03:32',
                'updated_at' => '2018-05-23 07:04:02',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => '10',
                'country_code' => 'AT',
                'user_id' => '1',
                'company_id' => '1',
                'category_id' => '1',
                'post_type_id' => '1',
                'company_name' => 'gomodels',
                'company_description' => 'go-models.com',
                'logo' => 'app/default/picture.jpg',
                'ismodel' => '1',
                'title' => 'Bikini',
                'description' => '<p>asdfsafadsfasdfasdfasdfasdfasdfasdfa</p>',
                'tags' => NULL,
                'salary_min' => '100.00',
                'salary_max' => '140.00',
                'salary_type_id' => '1',
                'negotiable' => NULL,
                'start_date' => '2018-05-25',
                'end_date' => '2018-05-25',
                'model_category_id' => '9',
                'partner_category_id' => '0',
                'experience_type_id' => '1',
                'gender_type_id' => '0',
                'tfp' => '0',
                'height_from' => '0',
                'height_to' => '0',
                'weight_from' => '0',
                'weight_to' => '0',
                'age_from' => '0',
                'age_to' => '0',
                'dressSize_from' => '0',
                'dressSize_to' => '0',
                'chest_from' => '0',
                'chest_to' => '0',
                'waist_from' => '0',
                'waist_to' => '0',
                'hips_from' => '0',
                'hips_to' => '0',
                'shoeSize_from' => '0',
                'shoeSize_to' => '0',
                'eyeColor' => NULL,
                'hairColor' => NULL,
                'skinColor' => NULL,
                'application_url' => NULL,
                'end_application' => '2018-05-25',
                'contact_name' => 'mm',
                'email' => 'goldbright00000@gmail.com',
                'phone' => '+4312345678',
                'phone_hidden' => NULL,
                'address' => NULL,
                'city_id' => '3218464',
                'lon' => '46.579',
                'lat' => '13.935',
                'ip_addr' => '127.0.0.1',
                'visits' => '0',
                'email_token' => NULL,
                'phone_token' => NULL,
                'tmp_token' => NULL,
                'code_token' => NULL,
                'verified_email' => '1',
                'verified_phone' => '1',
                'ismade' => '0',
                'reviewed' => '0',
                'featured' => '0',
                'archived' => '0',
                'partner' => NULL,
                'created_at' => '2018-05-25 16:29:46',
                'updated_at' => '2018-05-25 16:29:50',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => '11',
                'country_code' => 'AT',
                'user_id' => '1',
                'company_id' => '1',
                'category_id' => '1',
                'post_type_id' => '1',
                'company_name' => 'gomodels',
                'company_description' => 'go-models.com',
                'logo' => 'app/default/picture.jpg',
                'ismodel' => '1',
                'title' => 'Swimming',
                'description' => '<p>sadffffffffffffffffffffffffsssssadsfasdfsad</p>',
                'tags' => NULL,
                'salary_min' => '100.00',
                'salary_max' => '140.00',
                'salary_type_id' => '1',
                'negotiable' => '1',
                'start_date' => '2018-05-25',
                'end_date' => '2018-09-13',
                'model_category_id' => '13',
                'partner_category_id' => '0',
                'experience_type_id' => '2',
                'gender_type_id' => '0',
                'tfp' => '1',
                'height_from' => '0',
                'height_to' => '0',
                'weight_from' => '0',
                'weight_to' => '0',
                'age_from' => '0',
                'age_to' => '0',
                'dressSize_from' => '0',
                'dressSize_to' => '0',
                'chest_from' => '0',
                'chest_to' => '0',
                'waist_from' => '0',
                'waist_to' => '0',
                'hips_from' => '0',
                'hips_to' => '0',
                'shoeSize_from' => '0',
                'shoeSize_to' => '0',
                'eyeColor' => '397',
                'hairColor' => '408',
                'skinColor' => '417',
                'application_url' => NULL,
                'end_application' => '2018-10-08',
                'contact_name' => 'mm',
                'email' => 'goldbright00000@gmail.com',
                'phone' => '+4312345678',
                'phone_hidden' => NULL,
                'address' => NULL,
                'city_id' => '2782302',
                'lon' => '48.2194',
                'lat' => '14.4178',
                'ip_addr' => '127.0.0.1',
                'visits' => '1',
                'email_token' => NULL,
                'phone_token' => NULL,
                'tmp_token' => NULL,
                'code_token' => NULL,
                'verified_email' => '1',
                'verified_phone' => '1',
                'ismade' => '0',
                'reviewed' => '0',
                'featured' => '0',
                'archived' => '0',
                'partner' => NULL,
                'created_at' => '2018-05-25 16:33:22',
                'updated_at' => '2018-05-29 14:35:03',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}