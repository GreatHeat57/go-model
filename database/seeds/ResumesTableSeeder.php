<?php

use Illuminate\Database\Seeder;

class ResumesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('resumes')->delete();
        
        \DB::table('resumes')->insert(array (
            0 => 
            array (
                'id' => '1',
                'country_code' => 'AT',
                'user_id' => '7',
                'name' => NULL,
                'filename' => 'resumes/at/7/8f73b39711ce6c2d4a503073813e4206.JPG',
                'active' => '1',
                'created_at' => '2018-03-21 22:40:31',
                'updated_at' => '2018-03-21 22:40:31',
            ),
            1 => 
            array (
                'id' => '2',
                'country_code' => 'AT',
                'user_id' => '1',
                'name' => NULL,
                'filename' => 'resumes/at/1/86470fb9993d9857575c4284032cfae4.jpg',
                'active' => '1',
                'created_at' => '2018-03-23 06:04:42',
                'updated_at' => '2018-03-23 06:04:42',
            ),
            2 => 
            array (
                'id' => '3',
                'country_code' => 'AT',
                'user_id' => '1',
                'name' => NULL,
                'filename' => 'resumes/at/1/2a9deab1ff4158c163d390e1aa39d95c.jpeg',
                'active' => '1',
                'created_at' => '2018-03-23 06:04:55',
                'updated_at' => '2018-03-23 06:04:55',
            ),
            3 => 
            array (
                'id' => '4',
                'country_code' => 'AT',
                'user_id' => '1',
                'name' => NULL,
                'filename' => 'resumes/at/1/ae162b6ab491d4d77b094b3f9570098d.jpg',
                'active' => '1',
                'created_at' => '2018-03-25 10:10:10',
                'updated_at' => '2018-03-25 10:10:10',
            ),
        ));
        
        
    }
}