<?php

use Illuminate\Database\Seeder;

class ReportTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('report_types')->delete();
        
        \DB::table('report_types')->insert(array (
            0 => 
            array (
                'id' => '1',
                'translation_lang' => 'en',
                'translation_of' => '1',
                'name' => 'Fraud',
            ),
            1 => 
            array (
                'id' => '2',
                'translation_lang' => 'en',
                'translation_of' => '2',
                'name' => 'Duplicate',
            ),
            2 => 
            array (
                'id' => '3',
                'translation_lang' => 'en',
                'translation_of' => '3',
                'name' => 'Spam',
            ),
            3 => 
            array (
                'id' => '4',
                'translation_lang' => 'en',
                'translation_of' => '4',
                'name' => 'Wrong category',
            ),
            4 => 
            array (
                'id' => '5',
                'translation_lang' => 'en',
                'translation_of' => '5',
                'name' => 'Other',
            ),
            5 => 
            array (
                'id' => '6',
                'translation_lang' => 'fr',
                'translation_of' => '1',
                'name' => 'Fraude',
            ),
            6 => 
            array (
                'id' => '7',
                'translation_lang' => 'fr',
                'translation_of' => '2',
                'name' => 'Dupliquée',
            ),
            7 => 
            array (
                'id' => '8',
                'translation_lang' => 'fr',
                'translation_of' => '3',
                'name' => 'Indésirable',
            ),
            8 => 
            array (
                'id' => '9',
                'translation_lang' => 'fr',
                'translation_of' => '4',
                'name' => 'Mauvaise categorie',
            ),
            9 => 
            array (
                'id' => '10',
                'translation_lang' => 'fr',
                'translation_of' => '5',
                'name' => 'Autre',
            ),
            10 => 
            array (
                'id' => '11',
                'translation_lang' => 'es',
                'translation_of' => '1',
                'name' => 'Fraude',
            ),
            11 => 
            array (
                'id' => '12',
                'translation_lang' => 'es',
                'translation_of' => '2',
                'name' => 'Duplicar',
            ),
            12 => 
            array (
                'id' => '13',
                'translation_lang' => 'es',
                'translation_of' => '3',
                'name' => 'indeseable',
            ),
            13 => 
            array (
                'id' => '14',
                'translation_lang' => 'es',
                'translation_of' => '4',
                'name' => 'Categoría incorrecta',
            ),
            14 => 
            array (
                'id' => '15',
                'translation_lang' => 'es',
                'translation_of' => '5',
                'name' => 'Otro',
            ),
            15 => 
            array (
                'id' => '16',
                'translation_lang' => 'ar',
                'translation_of' => '1',
                'name' => 'تزوير',
            ),
            16 => 
            array (
                'id' => '17',
                'translation_lang' => 'ar',
                'translation_of' => '2',
                'name' => 'مكرر',
            ),
            17 => 
            array (
                'id' => '18',
                'translation_lang' => 'ar',
                'translation_of' => '3',
                'name' => 'بريد مؤذي',
            ),
            18 => 
            array (
                'id' => '19',
                'translation_lang' => 'ar',
                'translation_of' => '4',
                'name' => 'فئة خاطئة',
            ),
            19 => 
            array (
                'id' => '20',
                'translation_lang' => 'ar',
                'translation_of' => '5',
                'name' => 'آخر',
            ),
            20 => 
            array (
                'id' => '21',
                'translation_lang' => 'de',
                'translation_of' => '1',
                'name' => 'Fraud',
            ),
            21 => 
            array (
                'id' => '22',
                'translation_lang' => 'de',
                'translation_of' => '2',
                'name' => 'Duplicate',
            ),
            22 => 
            array (
                'id' => '23',
                'translation_lang' => 'de',
                'translation_of' => '3',
                'name' => 'Spam',
            ),
            23 => 
            array (
                'id' => '24',
                'translation_lang' => 'de',
                'translation_of' => '4',
                'name' => 'Wrong category',
            ),
            24 => 
            array (
                'id' => '25',
                'translation_lang' => 'de',
                'translation_of' => '5',
                'name' => 'Other',
            ),
        ));
        
        
    }
}