<?php

use Illuminate\Database\Seeder;

class PostTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('post_types')->delete();
        
        \DB::table('post_types')->insert(array (
            0 => 
            array (
                'id' => '1',
                'translation_lang' => 'en',
                'translation_of' => '1',
                'name' => 'Full-time',
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
                'name' => 'Part-time',
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
                'name' => 'Temporary',
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
                'name' => 'Contract',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'translation_lang' => 'en',
                'translation_of' => '5',
                'name' => 'Internship',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            5 => 
            array (
                'id' => '6',
                'translation_lang' => 'en',
                'translation_of' => '6',
                'name' => 'Permanent',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            6 => 
            array (
                'id' => '7',
                'translation_lang' => 'en',
                'translation_of' => '7',
                'name' => 'Optional',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            7 => 
            array (
                'id' => '8',
                'translation_lang' => 'fr',
                'translation_of' => '1',
                'name' => 'Plein temps',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            8 => 
            array (
                'id' => '9',
                'translation_lang' => 'fr',
                'translation_of' => '2',
                'name' => 'Temps partiel',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            9 => 
            array (
                'id' => '10',
                'translation_lang' => 'fr',
                'translation_of' => '3',
                'name' => 'Temporaire',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            10 => 
            array (
                'id' => '11',
                'translation_lang' => 'fr',
                'translation_of' => '4',
                'name' => 'Contract',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            11 => 
            array (
                'id' => '12',
                'translation_lang' => 'fr',
                'translation_of' => '5',
                'name' => 'Intérimaire',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            12 => 
            array (
                'id' => '13',
                'translation_lang' => 'fr',
                'translation_of' => '6',
                'name' => 'Permanent',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            13 => 
            array (
                'id' => '14',
                'translation_lang' => 'fr',
                'translation_of' => '7',
                'name' => 'Optional',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            14 => 
            array (
                'id' => '15',
                'translation_lang' => 'es',
                'translation_of' => '1',
                'name' => 'Full-time',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            15 => 
            array (
                'id' => '16',
                'translation_lang' => 'es',
                'translation_of' => '2',
                'name' => 'Part-time',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            16 => 
            array (
                'id' => '17',
                'translation_lang' => 'es',
                'translation_of' => '3',
                'name' => 'Temporary',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            17 => 
            array (
                'id' => '18',
                'translation_lang' => 'es',
                'translation_of' => '4',
                'name' => 'Contract',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            18 => 
            array (
                'id' => '19',
                'translation_lang' => 'es',
                'translation_of' => '5',
                'name' => 'Internship',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            19 => 
            array (
                'id' => '20',
                'translation_lang' => 'es',
                'translation_of' => '6',
                'name' => 'Permanent',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            20 => 
            array (
                'id' => '21',
                'translation_lang' => 'es',
                'translation_of' => '7',
                'name' => 'Optional',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            21 => 
            array (
                'id' => '22',
                'translation_lang' => 'ar',
                'translation_of' => '1',
                'name' => 'وقت كامل',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            22 => 
            array (
                'id' => '23',
                'translation_lang' => 'ar',
                'translation_of' => '2',
                'name' => 'دوام جزئى',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            23 => 
            array (
                'id' => '24',
                'translation_lang' => 'ar',
                'translation_of' => '3',
                'name' => 'مؤقت',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            24 => 
            array (
                'id' => '25',
                'translation_lang' => 'ar',
                'translation_of' => '4',
                'name' => 'عقد',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            25 => 
            array (
                'id' => '26',
                'translation_lang' => 'ar',
                'translation_of' => '5',
                'name' => 'فترة تدريب',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            26 => 
            array (
                'id' => '27',
                'translation_lang' => 'ar',
                'translation_of' => '6',
                'name' => 'دائم',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            27 => 
            array (
                'id' => '28',
                'translation_lang' => 'ar',
                'translation_of' => '7',
                'name' => 'اختياري',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            28 => 
            array (
                'id' => '29',
                'translation_lang' => 'de',
                'translation_of' => '1',
                'name' => 'Full-time',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            29 => 
            array (
                'id' => '30',
                'translation_lang' => 'de',
                'translation_of' => '2',
                'name' => 'Part-time',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            30 => 
            array (
                'id' => '31',
                'translation_lang' => 'de',
                'translation_of' => '3',
                'name' => 'Temporary',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            31 => 
            array (
                'id' => '32',
                'translation_lang' => 'de',
                'translation_of' => '4',
                'name' => 'Contract',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            32 => 
            array (
                'id' => '33',
                'translation_lang' => 'de',
                'translation_of' => '5',
                'name' => 'Internship',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            33 => 
            array (
                'id' => '34',
                'translation_lang' => 'de',
                'translation_of' => '6',
                'name' => 'Permanent',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
            34 => 
            array (
                'id' => '35',
                'translation_lang' => 'de',
                'translation_of' => '7',
                'name' => 'Optional',
                'lft' => NULL,
                'rgt' => NULL,
                'depth' => NULL,
                'active' => '1',
            ),
        ));
        
        
    }
}