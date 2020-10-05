<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('messages')->delete();
        
        \DB::table('messages')->insert(array (
            0 => 
            array (
                'id' => '1',
                'post_id' => '4',
                'parent_id' => '0',
                'from_user_id' => '7',
                'from_name' => 'katharinamodel',
                'from_email' => 'kathimodel@beta.go-models.com',
                'from_phone' => '+436506476812',
                'to_user_id' => '6',
                'to_name' => 'Katharinapartner',
                'to_email' => 'kathipartner@beta.go-models.com',
                'to_phone' => '',
                'subject' => 'photo shooting',
                'message' => 'Hallo! 
Ich würde mich sehr über diesen Job freuen!<br><br>Related to the ad: <a href="https://2.go-models.com/photo-shooting/4.html">Click here to see</a>',
                'filename' => 'resumes/at/7/8f73b39711ce6c2d4a503073813e4206.JPG',
                'is_read' => '0',
                'deleted_by' => NULL,
                'created_at' => '2018-03-21 22:40:31',
                'updated_at' => '2018-03-21 22:44:24',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => '2',
                'post_id' => '4',
                'parent_id' => '1',
                'from_user_id' => '6',
                'from_name' => 'Katharinapartner',
                'from_email' => 'kathipartner@beta.go-models.com',
                'from_phone' => '',
                'to_user_id' => '7',
                'to_name' => 'katharinamodel',
                'to_email' => 'kathimodel@beta.go-models.com',
                'to_phone' => '+436506476812',
                'subject' => 'RE: photo shooting',
                'message' => 'Hallo! Hast du denn schon model erfahrungen?<br><br>Related to the ad: <a href="https://2.go-models.com/photo-shooting/4.html">Click here to see</a>',
                'filename' => NULL,
                'is_read' => '0',
                'deleted_by' => NULL,
                'created_at' => '2018-03-21 22:44:24',
                'updated_at' => '2018-03-21 22:44:24',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}