<?php

use Illuminate\Database\Seeder;

class SavedPostsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('saved_posts')->delete();
        
        \DB::table('saved_posts')->insert(array (
            0 => 
            array (
                'id' => '1',
                'user_id' => '7',
                'post_id' => '4',
                'created_at' => '2018-03-21 22:33:31',
                'updated_at' => '2018-03-21 22:33:31',
            ),
        ));
        
        
    }
}