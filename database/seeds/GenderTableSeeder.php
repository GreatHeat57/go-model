<?php

use Illuminate\Database\Seeder;

class GenderTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('gender')->delete();
        
        \DB::table('gender')->insert(array (
            0 => 
            array (
                'id' => '1',
                'translation_lang' => 'en',
                'translation_of' => '1',
                'name' => 'Mr',
            ),
            1 => 
            array (
                'id' => '2',
                'translation_lang' => 'en',
                'translation_of' => '2',
                'name' => 'Mrs',
            ),
            2 => 
            array (
                'id' => '3',
                'translation_lang' => 'fr',
                'translation_of' => '1',
                'name' => 'Monsieur',
            ),
            3 => 
            array (
                'id' => '4',
                'translation_lang' => 'fr',
                'translation_of' => '2',
                'name' => 'Madame',
            ),
            4 => 
            array (
                'id' => '5',
                'translation_lang' => 'es',
                'translation_of' => '1',
                'name' => 'Señor',
            ),
            5 => 
            array (
                'id' => '6',
                'translation_lang' => 'es',
                'translation_of' => '2',
                'name' => 'Señora',
            ),
            6 => 
            array (
                'id' => '7',
                'translation_lang' => 'ar',
                'translation_of' => '1',
                'name' => 'السيد',
            ),
            7 => 
            array (
                'id' => '8',
                'translation_lang' => 'ar',
                'translation_of' => '2',
                'name' => 'السيدة',
            ),
            8 => 
            array (
                'id' => '9',
                'translation_lang' => 'de',
                'translation_of' => '1',
                'name' => 'Mr',
            ),
            9 => 
            array (
                'id' => '10',
                'translation_lang' => 'de',
                'translation_of' => '2',
                'name' => 'Mrs',
            ),
        ));
        
        
    }
}