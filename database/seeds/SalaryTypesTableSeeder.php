<?php

use Illuminate\Database\Seeder;

class SalaryTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('salary_types')->delete();
        
        \DB::table('salary_types')->insert(array (
            0 => 
            array (
                'id' => '1',
                'translation_lang' => 'en',
                'translation_of' => '1',
                'name' => 'hour',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'translation_lang' => 'en',
                'translation_of' => '2',
                'name' => 'day',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'translation_lang' => 'en',
                'translation_of' => '3',
                'name' => 'month',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            3 => 
            array (
                'id' => '4',
                'translation_lang' => 'en',
                'translation_of' => '4',
                'name' => 'year',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'translation_lang' => 'fr',
                'translation_of' => '1',
                'name' => 'heure',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            5 => 
            array (
                'id' => '6',
                'translation_lang' => 'fr',
                'translation_of' => '2',
                'name' => 'jour',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            6 => 
            array (
                'id' => '7',
                'translation_lang' => 'fr',
                'translation_of' => '3',
                'name' => 'mois',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            7 => 
            array (
                'id' => '8',
                'translation_lang' => 'fr',
                'translation_of' => '4',
                'name' => 'année',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            8 => 
            array (
                'id' => '9',
                'translation_lang' => 'es',
                'translation_of' => '1',
                'name' => 'hour',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            9 => 
            array (
                'id' => '10',
                'translation_lang' => 'es',
                'translation_of' => '2',
                'name' => 'day',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            10 => 
            array (
                'id' => '11',
                'translation_lang' => 'es',
                'translation_of' => '3',
                'name' => 'month',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            11 => 
            array (
                'id' => '12',
                'translation_lang' => 'es',
                'translation_of' => '4',
                'name' => 'year',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            12 => 
            array (
                'id' => '13',
                'translation_lang' => 'ar',
                'translation_of' => '1',
                'name' => 'ساعة',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            13 => 
            array (
                'id' => '14',
                'translation_lang' => 'ar',
                'translation_of' => '2',
                'name' => 'يوم',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            14 => 
            array (
                'id' => '15',
                'translation_lang' => 'ar',
                'translation_of' => '3',
                'name' => 'شهر',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            15 => 
            array (
                'id' => '16',
                'translation_lang' => 'ar',
                'translation_of' => '4',
                'name' => 'عام',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            16 => 
            array (
                'id' => '17',
                'translation_lang' => 'de',
                'translation_of' => '1',
                'name' => 'hour',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            17 => 
            array (
                'id' => '18',
                'translation_lang' => 'de',
                'translation_of' => '2',
                'name' => 'day',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            18 => 
            array (
                'id' => '19',
                'translation_lang' => 'de',
                'translation_of' => '3',
                'name' => 'month',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            19 => 
            array (
                'id' => '20',
                'translation_lang' => 'de',
                'translation_of' => '4',
                'name' => 'year',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
        ));
        
        
    }
}