<?php

use Illuminate\Database\Seeder;

class Subadmin1TableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subadmin1')->delete();
        
        \DB::table('subadmin1')->insert(array (
            0 => 
            array (
                'id' => '141',
                'code' => 'AT.09',
                'country_code' => 'AT',
                'name' => 'Vienna',
                'asciiname' => 'Vienna',
                'active' => '1',
            ),
            1 => 
            array (
                'id' => '142',
                'code' => 'AT.08',
                'country_code' => 'AT',
                'name' => 'Vorarlberg',
                'asciiname' => 'Vorarlberg',
                'active' => '1',
            ),
            2 => 
            array (
                'id' => '143',
                'code' => 'AT.07',
                'country_code' => 'AT',
                'name' => 'Tyrol',
                'asciiname' => 'Tyrol',
                'active' => '1',
            ),
            3 => 
            array (
                'id' => '144',
                'code' => 'AT.06',
                'country_code' => 'AT',
                'name' => 'Styria',
                'asciiname' => 'Styria',
                'active' => '1',
            ),
            4 => 
            array (
                'id' => '145',
                'code' => 'AT.05',
                'country_code' => 'AT',
                'name' => 'Salzburg',
                'asciiname' => 'Salzburg',
                'active' => '1',
            ),
            5 => 
            array (
                'id' => '146',
                'code' => 'AT.04',
                'country_code' => 'AT',
                'name' => 'Upper Austria',
                'asciiname' => 'Upper Austria',
                'active' => '1',
            ),
            6 => 
            array (
                'id' => '147',
                'code' => 'AT.03',
                'country_code' => 'AT',
                'name' => 'Lower Austria',
                'asciiname' => 'Lower Austria',
                'active' => '1',
            ),
            7 => 
            array (
                'id' => '148',
                'code' => 'AT.02',
                'country_code' => 'AT',
                'name' => 'Carinthia',
                'asciiname' => 'Carinthia',
                'active' => '1',
            ),
            8 => 
            array (
                'id' => '149',
                'code' => 'AT.01',
                'country_code' => 'AT',
                'name' => 'Burgenland',
                'asciiname' => 'Burgenland',
                'active' => '1',
            ),
            9 => 
            array (
                'id' => '535',
                'code' => 'CH.ZH',
                'country_code' => 'CH',
                'name' => 'Zurich',
                'asciiname' => 'Zurich',
                'active' => '1',
            ),
            10 => 
            array (
                'id' => '536',
                'code' => 'CH.ZG',
                'country_code' => 'CH',
                'name' => 'Zug',
                'asciiname' => 'Zug',
                'active' => '1',
            ),
            11 => 
            array (
                'id' => '537',
                'code' => 'CH.VD',
                'country_code' => 'CH',
                'name' => 'Vaud',
                'asciiname' => 'Vaud',
                'active' => '1',
            ),
            12 => 
            array (
                'id' => '538',
                'code' => 'CH.VS',
                'country_code' => 'CH',
                'name' => 'Valais',
                'asciiname' => 'Valais',
                'active' => '1',
            ),
            13 => 
            array (
                'id' => '539',
                'code' => 'CH.UR',
                'country_code' => 'CH',
                'name' => 'Uri',
                'asciiname' => 'Uri',
                'active' => '1',
            ),
            14 => 
            array (
                'id' => '540',
                'code' => 'CH.TI',
                'country_code' => 'CH',
                'name' => 'Ticino',
                'asciiname' => 'Ticino',
                'active' => '1',
            ),
            15 => 
            array (
                'id' => '541',
                'code' => 'CH.TG',
                'country_code' => 'CH',
                'name' => 'Thurgau',
                'asciiname' => 'Thurgau',
                'active' => '1',
            ),
            16 => 
            array (
                'id' => '542',
                'code' => 'CH.SO',
                'country_code' => 'CH',
                'name' => 'Solothurn',
                'asciiname' => 'Solothurn',
                'active' => '1',
            ),
            17 => 
            array (
                'id' => '543',
                'code' => 'CH.SZ',
                'country_code' => 'CH',
                'name' => 'Schwyz',
                'asciiname' => 'Schwyz',
                'active' => '1',
            ),
            18 => 
            array (
                'id' => '544',
                'code' => 'CH.SH',
                'country_code' => 'CH',
                'name' => 'Schaffhausen',
                'asciiname' => 'Schaffhausen',
                'active' => '1',
            ),
            19 => 
            array (
                'id' => '545',
                'code' => 'CH.SG',
                'country_code' => 'CH',
                'name' => 'Saint Gallen',
                'asciiname' => 'Saint Gallen',
                'active' => '1',
            ),
            20 => 
            array (
                'id' => '546',
                'code' => 'CH.OW',
                'country_code' => 'CH',
                'name' => 'Obwalden',
                'asciiname' => 'Obwalden',
                'active' => '1',
            ),
            21 => 
            array (
                'id' => '547',
                'code' => 'CH.NW',
                'country_code' => 'CH',
                'name' => 'Nidwalden',
                'asciiname' => 'Nidwalden',
                'active' => '1',
            ),
            22 => 
            array (
                'id' => '548',
                'code' => 'CH.NE',
                'country_code' => 'CH',
                'name' => 'Neuchâtel',
                'asciiname' => 'Neuchatel',
                'active' => '1',
            ),
            23 => 
            array (
                'id' => '549',
                'code' => 'CH.LU',
                'country_code' => 'CH',
                'name' => 'Lucerne',
                'asciiname' => 'Lucerne',
                'active' => '1',
            ),
            24 => 
            array (
                'id' => '550',
                'code' => 'CH.JU',
                'country_code' => 'CH',
                'name' => 'Jura',
                'asciiname' => 'Jura',
                'active' => '1',
            ),
            25 => 
            array (
                'id' => '551',
                'code' => 'CH.GR',
                'country_code' => 'CH',
                'name' => 'Grisons',
                'asciiname' => 'Grisons',
                'active' => '1',
            ),
            26 => 
            array (
                'id' => '552',
                'code' => 'CH.GL',
                'country_code' => 'CH',
                'name' => 'Glarus',
                'asciiname' => 'Glarus',
                'active' => '1',
            ),
            27 => 
            array (
                'id' => '553',
                'code' => 'CH.GE',
                'country_code' => 'CH',
                'name' => 'Geneva',
                'asciiname' => 'Geneva',
                'active' => '1',
            ),
            28 => 
            array (
                'id' => '554',
                'code' => 'CH.FR',
                'country_code' => 'CH',
                'name' => 'Fribourg',
                'asciiname' => 'Fribourg',
                'active' => '1',
            ),
            29 => 
            array (
                'id' => '555',
                'code' => 'CH.BE',
                'country_code' => 'CH',
                'name' => 'Bern',
                'asciiname' => 'Bern',
                'active' => '1',
            ),
            30 => 
            array (
                'id' => '556',
                'code' => 'CH.BS',
                'country_code' => 'CH',
                'name' => 'Basel-City',
                'asciiname' => 'Basel-City',
                'active' => '1',
            ),
            31 => 
            array (
                'id' => '557',
                'code' => 'CH.BL',
                'country_code' => 'CH',
                'name' => 'Basel-Landschaft',
                'asciiname' => 'Basel-Landschaft',
                'active' => '1',
            ),
            32 => 
            array (
                'id' => '558',
                'code' => 'CH.AR',
                'country_code' => 'CH',
                'name' => 'Appenzell Ausserrhoden',
                'asciiname' => 'Appenzell Ausserrhoden',
                'active' => '1',
            ),
            33 => 
            array (
                'id' => '559',
                'code' => 'CH.AI',
                'country_code' => 'CH',
                'name' => 'Appenzell Innerrhoden',
                'asciiname' => 'Appenzell Innerrhoden',
                'active' => '1',
            ),
            34 => 
            array (
                'id' => '560',
                'code' => 'CH.AG',
                'country_code' => 'CH',
                'name' => 'Aargau',
                'asciiname' => 'Aargau',
                'active' => '1',
            ),
            35 => 
            array (
                'id' => '740',
                'code' => 'DE.15',
                'country_code' => 'DE',
                'name' => 'Thuringia',
                'asciiname' => 'Thuringia',
                'active' => '1',
            ),
            36 => 
            array (
                'id' => '741',
                'code' => 'DE.10',
                'country_code' => 'DE',
                'name' => 'Schleswig-Holstein',
                'asciiname' => 'Schleswig-Holstein',
                'active' => '1',
            ),
            37 => 
            array (
                'id' => '742',
                'code' => 'DE.14',
                'country_code' => 'DE',
                'name' => 'Saxony-Anhalt',
                'asciiname' => 'Saxony-Anhalt',
                'active' => '1',
            ),
            38 => 
            array (
                'id' => '743',
                'code' => 'DE.13',
                'country_code' => 'DE',
                'name' => 'Saxony',
                'asciiname' => 'Saxony',
                'active' => '1',
            ),
            39 => 
            array (
                'id' => '744',
                'code' => 'DE.09',
                'country_code' => 'DE',
                'name' => 'Saarland',
                'asciiname' => 'Saarland',
                'active' => '1',
            ),
            40 => 
            array (
                'id' => '745',
                'code' => 'DE.08',
                'country_code' => 'DE',
                'name' => 'Rheinland-Pfalz',
                'asciiname' => 'Rheinland-Pfalz',
                'active' => '1',
            ),
            41 => 
            array (
                'id' => '746',
                'code' => 'DE.07',
                'country_code' => 'DE',
                'name' => 'North Rhine-Westphalia',
                'asciiname' => 'North Rhine-Westphalia',
                'active' => '1',
            ),
            42 => 
            array (
                'id' => '747',
                'code' => 'DE.06',
                'country_code' => 'DE',
                'name' => 'Lower Saxony',
                'asciiname' => 'Lower Saxony',
                'active' => '1',
            ),
            43 => 
            array (
                'id' => '748',
                'code' => 'DE.12',
                'country_code' => 'DE',
                'name' => 'Mecklenburg-Vorpommern',
                'asciiname' => 'Mecklenburg-Vorpommern',
                'active' => '1',
            ),
            44 => 
            array (
                'id' => '749',
                'code' => 'DE.05',
                'country_code' => 'DE',
                'name' => 'Hesse',
                'asciiname' => 'Hesse',
                'active' => '1',
            ),
            45 => 
            array (
                'id' => '750',
                'code' => 'DE.04',
                'country_code' => 'DE',
                'name' => 'Hamburg',
                'asciiname' => 'Hamburg',
                'active' => '1',
            ),
            46 => 
            array (
                'id' => '751',
                'code' => 'DE.03',
                'country_code' => 'DE',
                'name' => 'Bremen',
                'asciiname' => 'Bremen',
                'active' => '1',
            ),
            47 => 
            array (
                'id' => '752',
                'code' => 'DE.11',
                'country_code' => 'DE',
                'name' => 'Brandenburg',
                'asciiname' => 'Brandenburg',
                'active' => '1',
            ),
            48 => 
            array (
                'id' => '753',
                'code' => 'DE.16',
                'country_code' => 'DE',
                'name' => 'Berlin',
                'asciiname' => 'Berlin',
                'active' => '1',
            ),
            49 => 
            array (
                'id' => '754',
                'code' => 'DE.02',
                'country_code' => 'DE',
                'name' => 'Bavaria',
                'asciiname' => 'Bavaria',
                'active' => '1',
            ),
            50 => 
            array (
                'id' => '755',
                'code' => 'DE.01',
                'country_code' => 'DE',
                'name' => 'Baden-Württemberg',
                'asciiname' => 'Baden-Wuerttemberg',
                'active' => '1',
            ),
            51 => 
            array (
                'id' => '1706',
                'code' => 'LI.11',
                'country_code' => 'LI',
                'name' => 'Vaduz',
                'asciiname' => 'Vaduz',
                'active' => '1',
            ),
            52 => 
            array (
                'id' => '1707',
                'code' => 'LI.10',
                'country_code' => 'LI',
                'name' => 'Triesenberg',
                'asciiname' => 'Triesenberg',
                'active' => '1',
            ),
            53 => 
            array (
                'id' => '1708',
                'code' => 'LI.09',
                'country_code' => 'LI',
                'name' => 'Triesen',
                'asciiname' => 'Triesen',
                'active' => '1',
            ),
            54 => 
            array (
                'id' => '1709',
                'code' => 'LI.08',
                'country_code' => 'LI',
                'name' => 'Schellenberg',
                'asciiname' => 'Schellenberg',
                'active' => '1',
            ),
            55 => 
            array (
                'id' => '1710',
                'code' => 'LI.07',
                'country_code' => 'LI',
                'name' => 'Schaan',
                'asciiname' => 'Schaan',
                'active' => '1',
            ),
            56 => 
            array (
                'id' => '1711',
                'code' => 'LI.06',
                'country_code' => 'LI',
                'name' => 'Ruggell',
                'asciiname' => 'Ruggell',
                'active' => '1',
            ),
            57 => 
            array (
                'id' => '1712',
                'code' => 'LI.05',
                'country_code' => 'LI',
                'name' => 'Planken',
                'asciiname' => 'Planken',
                'active' => '1',
            ),
            58 => 
            array (
                'id' => '1713',
                'code' => 'LI.04',
                'country_code' => 'LI',
                'name' => 'Mauren',
                'asciiname' => 'Mauren',
                'active' => '1',
            ),
            59 => 
            array (
                'id' => '1714',
                'code' => 'LI.03',
                'country_code' => 'LI',
                'name' => 'Gamprin',
                'asciiname' => 'Gamprin',
                'active' => '1',
            ),
            60 => 
            array (
                'id' => '1715',
                'code' => 'LI.02',
                'country_code' => 'LI',
                'name' => 'Eschen',
                'asciiname' => 'Eschen',
                'active' => '1',
            ),
            61 => 
            array (
                'id' => '1716',
                'code' => 'LI.01',
                'country_code' => 'LI',
                'name' => 'Balzers',
                'asciiname' => 'Balzers',
                'active' => '1',
            ),
        ));
        
        
    }
}