<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('languages')->delete();
        
        \DB::table('languages')->insert(array (
            0 => 
            array (
                'id' => '1',
                'abbr' => 'en',
                'locale' => 'en_US',
                'name' => 'English',
                'native' => 'English',
                'flag' => NULL,
                'app_name' => 'english',
                'script' => 'Latn',
                'direction' => 'ltr',
                'russian_pluralization' => '0',
                'active' => '1',
                'default' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => '2',
                'abbr' => 'fr',
                'locale' => 'fr_FR',
                'name' => 'French',
                'native' => 'Français',
                'flag' => NULL,
                'app_name' => 'french',
                'script' => 'Latn',
                'direction' => 'ltr',
                'russian_pluralization' => '0',
                'active' => '1',
                'default' => '0',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => '3',
                'abbr' => 'es',
                'locale' => 'es_ES',
                'name' => 'Spanish',
                'native' => 'Español',
                'flag' => '',
                'app_name' => 'spanish',
                'script' => 'Latn',
                'direction' => 'ltr',
                'russian_pluralization' => '0',
                'active' => '1',
                'default' => '0',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => '4',
                'abbr' => 'ar',
                'locale' => 'ar_AR',
                'name' => 'Arabic',
                'native' => 'العربية',
                'flag' => NULL,
                'app_name' => 'arabic',
                'script' => 'Arab',
                'direction' => 'rtl',
                'russian_pluralization' => '0',
                'active' => '0',
                'default' => '0',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => '5',
                'abbr' => 'de',
                'locale' => 'de_AT',
                'name' => 'German',
                'native' => 'Deutsch',
                'flag' => NULL,
                'app_name' => 'german',
                'script' => NULL,
                'direction' => 'ltr',
                'russian_pluralization' => '0',
                'active' => '1',
                'default' => '0',
                'created_at' => NULL,
                'updated_at' => NULL,
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}