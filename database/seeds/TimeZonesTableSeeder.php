<?php

use Illuminate\Database\Seeder;

class TimeZonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('time_zones')->delete();
        
        \DB::table('time_zones')->insert(array (
            0 => 
            array (
                'id' => '1',
                'country_code' => 'CI',
                'time_zone_id' => 'Africa/Abidjan',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            1 => 
            array (
                'id' => '2',
                'country_code' => 'GH',
                'time_zone_id' => 'Africa/Accra',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            2 => 
            array (
                'id' => '3',
                'country_code' => 'ET',
                'time_zone_id' => 'Africa/Addis_Ababa',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            3 => 
            array (
                'id' => '4',
                'country_code' => 'DZ',
                'time_zone_id' => 'Africa/Algiers',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'country_code' => 'ER',
                'time_zone_id' => 'Africa/Asmara',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            5 => 
            array (
                'id' => '6',
                'country_code' => 'ML',
                'time_zone_id' => 'Africa/Bamako',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            6 => 
            array (
                'id' => '7',
                'country_code' => 'CF',
                'time_zone_id' => 'Africa/Bangui',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            7 => 
            array (
                'id' => '8',
                'country_code' => 'GM',
                'time_zone_id' => 'Africa/Banjul',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            8 => 
            array (
                'id' => '9',
                'country_code' => 'GW',
                'time_zone_id' => 'Africa/Bissau',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            9 => 
            array (
                'id' => '10',
                'country_code' => 'MW',
                'time_zone_id' => 'Africa/Blantyre',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            10 => 
            array (
                'id' => '11',
                'country_code' => 'CG',
                'time_zone_id' => 'Africa/Brazzaville',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            11 => 
            array (
                'id' => '12',
                'country_code' => 'BI',
                'time_zone_id' => 'Africa/Bujumbura',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            12 => 
            array (
                'id' => '13',
                'country_code' => 'EG',
                'time_zone_id' => 'Africa/Cairo',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            13 => 
            array (
                'id' => '14',
                'country_code' => 'MA',
                'time_zone_id' => 'Africa/Casablanca',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            14 => 
            array (
                'id' => '15',
                'country_code' => 'ES',
                'time_zone_id' => 'Africa/Ceuta',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            15 => 
            array (
                'id' => '16',
                'country_code' => 'GN',
                'time_zone_id' => 'Africa/Conakry',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            16 => 
            array (
                'id' => '17',
                'country_code' => 'SN',
                'time_zone_id' => 'Africa/Dakar',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            17 => 
            array (
                'id' => '18',
                'country_code' => 'TZ',
                'time_zone_id' => 'Africa/Dar_es_Salaam',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            18 => 
            array (
                'id' => '19',
                'country_code' => 'DJ',
                'time_zone_id' => 'Africa/Djibouti',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            19 => 
            array (
                'id' => '20',
                'country_code' => 'CM',
                'time_zone_id' => 'Africa/Douala',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            20 => 
            array (
                'id' => '21',
                'country_code' => 'EH',
                'time_zone_id' => 'Africa/El_Aaiun',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            21 => 
            array (
                'id' => '22',
                'country_code' => 'SL',
                'time_zone_id' => 'Africa/Freetown',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            22 => 
            array (
                'id' => '23',
                'country_code' => 'BW',
                'time_zone_id' => 'Africa/Gaborone',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            23 => 
            array (
                'id' => '24',
                'country_code' => 'ZW',
                'time_zone_id' => 'Africa/Harare',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            24 => 
            array (
                'id' => '25',
                'country_code' => 'ZA',
                'time_zone_id' => 'Africa/Johannesburg',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            25 => 
            array (
                'id' => '26',
                'country_code' => 'SS',
                'time_zone_id' => 'Africa/Juba',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            26 => 
            array (
                'id' => '27',
                'country_code' => 'UG',
                'time_zone_id' => 'Africa/Kampala',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            27 => 
            array (
                'id' => '28',
                'country_code' => 'SD',
                'time_zone_id' => 'Africa/Khartoum',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            28 => 
            array (
                'id' => '29',
                'country_code' => 'RW',
                'time_zone_id' => 'Africa/Kigali',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            29 => 
            array (
                'id' => '30',
                'country_code' => 'CD',
                'time_zone_id' => 'Africa/Kinshasa',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            30 => 
            array (
                'id' => '31',
                'country_code' => 'NG',
                'time_zone_id' => 'Africa/Lagos',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            31 => 
            array (
                'id' => '32',
                'country_code' => 'GA',
                'time_zone_id' => 'Africa/Libreville',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            32 => 
            array (
                'id' => '33',
                'country_code' => 'TG',
                'time_zone_id' => 'Africa/Lome',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            33 => 
            array (
                'id' => '34',
                'country_code' => 'AO',
                'time_zone_id' => 'Africa/Luanda',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            34 => 
            array (
                'id' => '35',
                'country_code' => 'CD',
                'time_zone_id' => 'Africa/Lubumbashi',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            35 => 
            array (
                'id' => '36',
                'country_code' => 'ZM',
                'time_zone_id' => 'Africa/Lusaka',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            36 => 
            array (
                'id' => '37',
                'country_code' => 'GQ',
                'time_zone_id' => 'Africa/Malabo',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            37 => 
            array (
                'id' => '38',
                'country_code' => 'MZ',
                'time_zone_id' => 'Africa/Maputo',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            38 => 
            array (
                'id' => '39',
                'country_code' => 'LS',
                'time_zone_id' => 'Africa/Maseru',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            39 => 
            array (
                'id' => '40',
                'country_code' => 'SZ',
                'time_zone_id' => 'Africa/Mbabane',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            40 => 
            array (
                'id' => '41',
                'country_code' => 'SO',
                'time_zone_id' => 'Africa/Mogadishu',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            41 => 
            array (
                'id' => '42',
                'country_code' => 'LR',
                'time_zone_id' => 'Africa/Monrovia',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            42 => 
            array (
                'id' => '43',
                'country_code' => 'KE',
                'time_zone_id' => 'Africa/Nairobi',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            43 => 
            array (
                'id' => '44',
                'country_code' => 'TD',
                'time_zone_id' => 'Africa/Ndjamena',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            44 => 
            array (
                'id' => '45',
                'country_code' => 'NE',
                'time_zone_id' => 'Africa/Niamey',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            45 => 
            array (
                'id' => '46',
                'country_code' => 'MR',
                'time_zone_id' => 'Africa/Nouakchott',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            46 => 
            array (
                'id' => '47',
                'country_code' => 'BF',
                'time_zone_id' => 'Africa/Ouagadougou',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            47 => 
            array (
                'id' => '48',
                'country_code' => 'BJ',
                'time_zone_id' => 'Africa/Porto-Novo',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            48 => 
            array (
                'id' => '49',
                'country_code' => 'ST',
                'time_zone_id' => 'Africa/Sao_Tome',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            49 => 
            array (
                'id' => '50',
                'country_code' => 'LY',
                'time_zone_id' => 'Africa/Tripoli',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            50 => 
            array (
                'id' => '51',
                'country_code' => 'TN',
                'time_zone_id' => 'Africa/Tunis',
                'gmt' => '1',
                'dst' => '1',
                'raw' => '1',
            ),
            51 => 
            array (
                'id' => '52',
                'country_code' => 'NA',
                'time_zone_id' => 'Africa/Windhoek',
                'gmt' => '2',
                'dst' => '1',
                'raw' => '1',
            ),
            52 => 
            array (
                'id' => '53',
                'country_code' => 'US',
                'time_zone_id' => 'America/Adak',
                'gmt' => '-10',
                'dst' => '-9',
                'raw' => '-10',
            ),
            53 => 
            array (
                'id' => '54',
                'country_code' => 'US',
                'time_zone_id' => 'America/Anchorage',
                'gmt' => '-9',
                'dst' => '-8',
                'raw' => '-9',
            ),
            54 => 
            array (
                'id' => '55',
                'country_code' => 'AI',
                'time_zone_id' => 'America/Anguilla',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            55 => 
            array (
                'id' => '56',
                'country_code' => 'AG',
                'time_zone_id' => 'America/Antigua',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            56 => 
            array (
                'id' => '57',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Araguaina',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            57 => 
            array (
                'id' => '58',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Buenos_Aires',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            58 => 
            array (
                'id' => '59',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Catamarca',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            59 => 
            array (
                'id' => '60',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Cordoba',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            60 => 
            array (
                'id' => '61',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Jujuy',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            61 => 
            array (
                'id' => '62',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/La_Rioja',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            62 => 
            array (
                'id' => '63',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Mendoza',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            63 => 
            array (
                'id' => '64',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Rio_Gallegos',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            64 => 
            array (
                'id' => '65',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Salta',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            65 => 
            array (
                'id' => '66',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/San_Juan',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            66 => 
            array (
                'id' => '67',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/San_Luis',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            67 => 
            array (
                'id' => '68',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Tucuman',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            68 => 
            array (
                'id' => '69',
                'country_code' => 'AR',
                'time_zone_id' => 'America/Argentina/Ushuaia',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            69 => 
            array (
                'id' => '70',
                'country_code' => 'AW',
                'time_zone_id' => 'America/Aruba',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            70 => 
            array (
                'id' => '71',
                'country_code' => 'PY',
                'time_zone_id' => 'America/Asuncion',
                'gmt' => '-3',
                'dst' => '-4',
                'raw' => '-4',
            ),
            71 => 
            array (
                'id' => '72',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Atikokan',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            72 => 
            array (
                'id' => '73',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Bahia',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            73 => 
            array (
                'id' => '74',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Bahia_Banderas',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            74 => 
            array (
                'id' => '75',
                'country_code' => 'BB',
                'time_zone_id' => 'America/Barbados',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            75 => 
            array (
                'id' => '76',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Belem',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            76 => 
            array (
                'id' => '77',
                'country_code' => 'BZ',
                'time_zone_id' => 'America/Belize',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            77 => 
            array (
                'id' => '78',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Blanc-Sablon',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            78 => 
            array (
                'id' => '79',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Boa_Vista',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            79 => 
            array (
                'id' => '80',
                'country_code' => 'CO',
                'time_zone_id' => 'America/Bogota',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            80 => 
            array (
                'id' => '81',
                'country_code' => 'US',
                'time_zone_id' => 'America/Boise',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            81 => 
            array (
                'id' => '82',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Cambridge_Bay',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            82 => 
            array (
                'id' => '83',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Campo_Grande',
                'gmt' => '-3',
                'dst' => '-4',
                'raw' => '-4',
            ),
            83 => 
            array (
                'id' => '84',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Cancun',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            84 => 
            array (
                'id' => '85',
                'country_code' => 'VE',
                'time_zone_id' => 'America/Caracas',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            85 => 
            array (
                'id' => '86',
                'country_code' => 'GF',
                'time_zone_id' => 'America/Cayenne',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            86 => 
            array (
                'id' => '87',
                'country_code' => 'KY',
                'time_zone_id' => 'America/Cayman',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            87 => 
            array (
                'id' => '88',
                'country_code' => 'US',
                'time_zone_id' => 'America/Chicago',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            88 => 
            array (
                'id' => '89',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Chihuahua',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            89 => 
            array (
                'id' => '90',
                'country_code' => 'CR',
                'time_zone_id' => 'America/Costa_Rica',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            90 => 
            array (
                'id' => '91',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Creston',
                'gmt' => '-7',
                'dst' => '-7',
                'raw' => '-7',
            ),
            91 => 
            array (
                'id' => '92',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Cuiaba',
                'gmt' => '-3',
                'dst' => '-4',
                'raw' => '-4',
            ),
            92 => 
            array (
                'id' => '93',
                'country_code' => 'CW',
                'time_zone_id' => 'America/Curacao',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            93 => 
            array (
                'id' => '94',
                'country_code' => 'GL',
                'time_zone_id' => 'America/Danmarkshavn',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            94 => 
            array (
                'id' => '95',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Dawson',
                'gmt' => '-8',
                'dst' => '-7',
                'raw' => '-8',
            ),
            95 => 
            array (
                'id' => '96',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Dawson_Creek',
                'gmt' => '-7',
                'dst' => '-7',
                'raw' => '-7',
            ),
            96 => 
            array (
                'id' => '97',
                'country_code' => 'US',
                'time_zone_id' => 'America/Denver',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            97 => 
            array (
                'id' => '98',
                'country_code' => 'US',
                'time_zone_id' => 'America/Detroit',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            98 => 
            array (
                'id' => '99',
                'country_code' => 'DM',
                'time_zone_id' => 'America/Dominica',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            99 => 
            array (
                'id' => '100',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Edmonton',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            100 => 
            array (
                'id' => '101',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Eirunepe',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            101 => 
            array (
                'id' => '102',
                'country_code' => 'SV',
                'time_zone_id' => 'America/El_Salvador',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            102 => 
            array (
                'id' => '103',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Fort_Nelson',
                'gmt' => '-7',
                'dst' => '-7',
                'raw' => '-7',
            ),
            103 => 
            array (
                'id' => '104',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Fortaleza',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            104 => 
            array (
                'id' => '105',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Glace_Bay',
                'gmt' => '-4',
                'dst' => '-3',
                'raw' => '-4',
            ),
            105 => 
            array (
                'id' => '106',
                'country_code' => 'GL',
                'time_zone_id' => 'America/Godthab',
                'gmt' => '-3',
                'dst' => '-2',
                'raw' => '-3',
            ),
            106 => 
            array (
                'id' => '107',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Goose_Bay',
                'gmt' => '-4',
                'dst' => '-3',
                'raw' => '-4',
            ),
            107 => 
            array (
                'id' => '108',
                'country_code' => 'TC',
                'time_zone_id' => 'America/Grand_Turk',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            108 => 
            array (
                'id' => '109',
                'country_code' => 'GD',
                'time_zone_id' => 'America/Grenada',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            109 => 
            array (
                'id' => '110',
                'country_code' => 'GP',
                'time_zone_id' => 'America/Guadeloupe',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            110 => 
            array (
                'id' => '111',
                'country_code' => 'GT',
                'time_zone_id' => 'America/Guatemala',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            111 => 
            array (
                'id' => '112',
                'country_code' => 'EC',
                'time_zone_id' => 'America/Guayaquil',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            112 => 
            array (
                'id' => '113',
                'country_code' => 'GY',
                'time_zone_id' => 'America/Guyana',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            113 => 
            array (
                'id' => '114',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Halifax',
                'gmt' => '-4',
                'dst' => '-3',
                'raw' => '-4',
            ),
            114 => 
            array (
                'id' => '115',
                'country_code' => 'CU',
                'time_zone_id' => 'America/Havana',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            115 => 
            array (
                'id' => '116',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Hermosillo',
                'gmt' => '-7',
                'dst' => '-7',
                'raw' => '-7',
            ),
            116 => 
            array (
                'id' => '117',
                'country_code' => 'US',
                'time_zone_id' => 'America/Indiana/Indianapolis',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            117 => 
            array (
                'id' => '118',
                'country_code' => 'US',
                'time_zone_id' => 'America/Indiana/Knox',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            118 => 
            array (
                'id' => '119',
                'country_code' => 'US',
                'time_zone_id' => 'America/Indiana/Marengo',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            119 => 
            array (
                'id' => '120',
                'country_code' => 'US',
                'time_zone_id' => 'America/Indiana/Petersburg',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            120 => 
            array (
                'id' => '121',
                'country_code' => 'US',
                'time_zone_id' => 'America/Indiana/Tell_City',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            121 => 
            array (
                'id' => '122',
                'country_code' => 'US',
                'time_zone_id' => 'America/Indiana/Vevay',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            122 => 
            array (
                'id' => '123',
                'country_code' => 'US',
                'time_zone_id' => 'America/Indiana/Vincennes',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            123 => 
            array (
                'id' => '124',
                'country_code' => 'US',
                'time_zone_id' => 'America/Indiana/Winamac',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            124 => 
            array (
                'id' => '125',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Inuvik',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            125 => 
            array (
                'id' => '126',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Iqaluit',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            126 => 
            array (
                'id' => '127',
                'country_code' => 'JM',
                'time_zone_id' => 'America/Jamaica',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            127 => 
            array (
                'id' => '128',
                'country_code' => 'US',
                'time_zone_id' => 'America/Juneau',
                'gmt' => '-9',
                'dst' => '-8',
                'raw' => '-9',
            ),
            128 => 
            array (
                'id' => '129',
                'country_code' => 'US',
                'time_zone_id' => 'America/Kentucky/Louisville',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            129 => 
            array (
                'id' => '130',
                'country_code' => 'US',
                'time_zone_id' => 'America/Kentucky/Monticello',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            130 => 
            array (
                'id' => '131',
                'country_code' => 'BQ',
                'time_zone_id' => 'America/Kralendijk',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            131 => 
            array (
                'id' => '132',
                'country_code' => 'BO',
                'time_zone_id' => 'America/La_Paz',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            132 => 
            array (
                'id' => '133',
                'country_code' => 'PE',
                'time_zone_id' => 'America/Lima',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            133 => 
            array (
                'id' => '134',
                'country_code' => 'US',
                'time_zone_id' => 'America/Los_Angeles',
                'gmt' => '-8',
                'dst' => '-7',
                'raw' => '-8',
            ),
            134 => 
            array (
                'id' => '135',
                'country_code' => 'SX',
                'time_zone_id' => 'America/Lower_Princes',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            135 => 
            array (
                'id' => '136',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Maceio',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            136 => 
            array (
                'id' => '137',
                'country_code' => 'NI',
                'time_zone_id' => 'America/Managua',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            137 => 
            array (
                'id' => '138',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Manaus',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            138 => 
            array (
                'id' => '139',
                'country_code' => 'MF',
                'time_zone_id' => 'America/Marigot',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            139 => 
            array (
                'id' => '140',
                'country_code' => 'MQ',
                'time_zone_id' => 'America/Martinique',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            140 => 
            array (
                'id' => '141',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Matamoros',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            141 => 
            array (
                'id' => '142',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Mazatlan',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            142 => 
            array (
                'id' => '143',
                'country_code' => 'US',
                'time_zone_id' => 'America/Menominee',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            143 => 
            array (
                'id' => '144',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Merida',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            144 => 
            array (
                'id' => '145',
                'country_code' => 'US',
                'time_zone_id' => 'America/Metlakatla',
                'gmt' => '-9',
                'dst' => '-8',
                'raw' => '-9',
            ),
            145 => 
            array (
                'id' => '146',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Mexico_City',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            146 => 
            array (
                'id' => '147',
                'country_code' => 'PM',
                'time_zone_id' => 'America/Miquelon',
                'gmt' => '-3',
                'dst' => '-2',
                'raw' => '-3',
            ),
            147 => 
            array (
                'id' => '148',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Moncton',
                'gmt' => '-4',
                'dst' => '-3',
                'raw' => '-4',
            ),
            148 => 
            array (
                'id' => '149',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Monterrey',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            149 => 
            array (
                'id' => '150',
                'country_code' => 'UY',
                'time_zone_id' => 'America/Montevideo',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            150 => 
            array (
                'id' => '151',
                'country_code' => 'MS',
                'time_zone_id' => 'America/Montserrat',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            151 => 
            array (
                'id' => '152',
                'country_code' => 'BS',
                'time_zone_id' => 'America/Nassau',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            152 => 
            array (
                'id' => '153',
                'country_code' => 'US',
                'time_zone_id' => 'America/New_York',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            153 => 
            array (
                'id' => '154',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Nipigon',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            154 => 
            array (
                'id' => '155',
                'country_code' => 'US',
                'time_zone_id' => 'America/Nome',
                'gmt' => '-9',
                'dst' => '-8',
                'raw' => '-9',
            ),
            155 => 
            array (
                'id' => '156',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Noronha',
                'gmt' => '-2',
                'dst' => '-2',
                'raw' => '-2',
            ),
            156 => 
            array (
                'id' => '157',
                'country_code' => 'US',
                'time_zone_id' => 'America/North_Dakota/Beulah',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            157 => 
            array (
                'id' => '158',
                'country_code' => 'US',
                'time_zone_id' => 'America/North_Dakota/Center',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            158 => 
            array (
                'id' => '159',
                'country_code' => 'US',
                'time_zone_id' => 'America/North_Dakota/New_Salem',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            159 => 
            array (
                'id' => '160',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Ojinaga',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            160 => 
            array (
                'id' => '161',
                'country_code' => 'PA',
                'time_zone_id' => 'America/Panama',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            161 => 
            array (
                'id' => '162',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Pangnirtung',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            162 => 
            array (
                'id' => '163',
                'country_code' => 'SR',
                'time_zone_id' => 'America/Paramaribo',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            163 => 
            array (
                'id' => '164',
                'country_code' => 'US',
                'time_zone_id' => 'America/Phoenix',
                'gmt' => '-7',
                'dst' => '-7',
                'raw' => '-7',
            ),
            164 => 
            array (
                'id' => '165',
                'country_code' => 'HT',
                'time_zone_id' => 'America/Port-au-Prince',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            165 => 
            array (
                'id' => '166',
                'country_code' => 'TT',
                'time_zone_id' => 'America/Port_of_Spain',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            166 => 
            array (
                'id' => '167',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Porto_Velho',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            167 => 
            array (
                'id' => '168',
                'country_code' => 'PR',
                'time_zone_id' => 'America/Puerto_Rico',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            168 => 
            array (
                'id' => '169',
                'country_code' => 'CL',
                'time_zone_id' => 'America/Punta_Arenas',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            169 => 
            array (
                'id' => '170',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Rainy_River',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            170 => 
            array (
                'id' => '171',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Rankin_Inlet',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            171 => 
            array (
                'id' => '172',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Recife',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            172 => 
            array (
                'id' => '173',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Regina',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            173 => 
            array (
                'id' => '174',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Resolute',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            174 => 
            array (
                'id' => '175',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Rio_Branco',
                'gmt' => '-5',
                'dst' => '-5',
                'raw' => '-5',
            ),
            175 => 
            array (
                'id' => '176',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Santarem',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            176 => 
            array (
                'id' => '177',
                'country_code' => 'CL',
                'time_zone_id' => 'America/Santiago',
                'gmt' => '-3',
                'dst' => '-4',
                'raw' => '-4',
            ),
            177 => 
            array (
                'id' => '178',
                'country_code' => 'DO',
                'time_zone_id' => 'America/Santo_Domingo',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            178 => 
            array (
                'id' => '179',
                'country_code' => 'BR',
                'time_zone_id' => 'America/Sao_Paulo',
                'gmt' => '-2',
                'dst' => '-3',
                'raw' => '-3',
            ),
            179 => 
            array (
                'id' => '180',
                'country_code' => 'GL',
                'time_zone_id' => 'America/Scoresbysund',
                'gmt' => '-1',
                'dst' => '0',
                'raw' => '-1',
            ),
            180 => 
            array (
                'id' => '181',
                'country_code' => 'US',
                'time_zone_id' => 'America/Sitka',
                'gmt' => '-9',
                'dst' => '-8',
                'raw' => '-9',
            ),
            181 => 
            array (
                'id' => '182',
                'country_code' => 'BL',
                'time_zone_id' => 'America/St_Barthelemy',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            182 => 
            array (
                'id' => '183',
                'country_code' => 'CA',
                'time_zone_id' => 'America/St_Johns',
                'gmt' => '-3.5',
                'dst' => '-2.5',
                'raw' => '-3.5',
            ),
            183 => 
            array (
                'id' => '184',
                'country_code' => 'KN',
                'time_zone_id' => 'America/St_Kitts',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            184 => 
            array (
                'id' => '185',
                'country_code' => 'LC',
                'time_zone_id' => 'America/St_Lucia',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            185 => 
            array (
                'id' => '186',
                'country_code' => 'VI',
                'time_zone_id' => 'America/St_Thomas',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            186 => 
            array (
                'id' => '187',
                'country_code' => 'VC',
                'time_zone_id' => 'America/St_Vincent',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            187 => 
            array (
                'id' => '188',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Swift_Current',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            188 => 
            array (
                'id' => '189',
                'country_code' => 'HN',
                'time_zone_id' => 'America/Tegucigalpa',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            189 => 
            array (
                'id' => '190',
                'country_code' => 'GL',
                'time_zone_id' => 'America/Thule',
                'gmt' => '-4',
                'dst' => '-3',
                'raw' => '-4',
            ),
            190 => 
            array (
                'id' => '191',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Thunder_Bay',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            191 => 
            array (
                'id' => '192',
                'country_code' => 'MX',
                'time_zone_id' => 'America/Tijuana',
                'gmt' => '-8',
                'dst' => '-7',
                'raw' => '-8',
            ),
            192 => 
            array (
                'id' => '193',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Toronto',
                'gmt' => '-5',
                'dst' => '-4',
                'raw' => '-5',
            ),
            193 => 
            array (
                'id' => '194',
                'country_code' => 'VG',
                'time_zone_id' => 'America/Tortola',
                'gmt' => '-4',
                'dst' => '-4',
                'raw' => '-4',
            ),
            194 => 
            array (
                'id' => '195',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Vancouver',
                'gmt' => '-8',
                'dst' => '-7',
                'raw' => '-8',
            ),
            195 => 
            array (
                'id' => '196',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Whitehorse',
                'gmt' => '-8',
                'dst' => '-7',
                'raw' => '-8',
            ),
            196 => 
            array (
                'id' => '197',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Winnipeg',
                'gmt' => '-6',
                'dst' => '-5',
                'raw' => '-6',
            ),
            197 => 
            array (
                'id' => '198',
                'country_code' => 'US',
                'time_zone_id' => 'America/Yakutat',
                'gmt' => '-9',
                'dst' => '-8',
                'raw' => '-9',
            ),
            198 => 
            array (
                'id' => '199',
                'country_code' => 'CA',
                'time_zone_id' => 'America/Yellowknife',
                'gmt' => '-7',
                'dst' => '-6',
                'raw' => '-7',
            ),
            199 => 
            array (
                'id' => '200',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/Casey',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            200 => 
            array (
                'id' => '201',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/Davis',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            201 => 
            array (
                'id' => '202',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/DumontDUrville',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            202 => 
            array (
                'id' => '203',
                'country_code' => 'AU',
                'time_zone_id' => 'Antarctica/Macquarie',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            203 => 
            array (
                'id' => '204',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/Mawson',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            204 => 
            array (
                'id' => '205',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/McMurdo',
                'gmt' => '13',
                'dst' => '12',
                'raw' => '12',
            ),
            205 => 
            array (
                'id' => '206',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/Palmer',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            206 => 
            array (
                'id' => '207',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/Rothera',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            207 => 
            array (
                'id' => '208',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/Syowa',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            208 => 
            array (
                'id' => '209',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/Troll',
                'gmt' => '0',
                'dst' => '2',
                'raw' => '0',
            ),
            209 => 
            array (
                'id' => '210',
                'country_code' => 'AQ',
                'time_zone_id' => 'Antarctica/Vostok',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            210 => 
            array (
                'id' => '211',
                'country_code' => 'SJ',
                'time_zone_id' => 'Arctic/Longyearbyen',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            211 => 
            array (
                'id' => '212',
                'country_code' => 'YE',
                'time_zone_id' => 'Asia/Aden',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            212 => 
            array (
                'id' => '213',
                'country_code' => 'KZ',
                'time_zone_id' => 'Asia/Almaty',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            213 => 
            array (
                'id' => '214',
                'country_code' => 'JO',
                'time_zone_id' => 'Asia/Amman',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            214 => 
            array (
                'id' => '215',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Anadyr',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
            215 => 
            array (
                'id' => '216',
                'country_code' => 'KZ',
                'time_zone_id' => 'Asia/Aqtau',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            216 => 
            array (
                'id' => '217',
                'country_code' => 'KZ',
                'time_zone_id' => 'Asia/Aqtobe',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            217 => 
            array (
                'id' => '218',
                'country_code' => 'TM',
                'time_zone_id' => 'Asia/Ashgabat',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            218 => 
            array (
                'id' => '219',
                'country_code' => 'KZ',
                'time_zone_id' => 'Asia/Atyrau',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            219 => 
            array (
                'id' => '220',
                'country_code' => 'IQ',
                'time_zone_id' => 'Asia/Baghdad',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            220 => 
            array (
                'id' => '221',
                'country_code' => 'BH',
                'time_zone_id' => 'Asia/Bahrain',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            221 => 
            array (
                'id' => '222',
                'country_code' => 'AZ',
                'time_zone_id' => 'Asia/Baku',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            222 => 
            array (
                'id' => '223',
                'country_code' => 'TH',
                'time_zone_id' => 'Asia/Bangkok',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            223 => 
            array (
                'id' => '224',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Barnaul',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            224 => 
            array (
                'id' => '225',
                'country_code' => 'LB',
                'time_zone_id' => 'Asia/Beirut',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            225 => 
            array (
                'id' => '226',
                'country_code' => 'KG',
                'time_zone_id' => 'Asia/Bishkek',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            226 => 
            array (
                'id' => '227',
                'country_code' => 'BN',
                'time_zone_id' => 'Asia/Brunei',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            227 => 
            array (
                'id' => '228',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Chita',
                'gmt' => '9',
                'dst' => '9',
                'raw' => '9',
            ),
            228 => 
            array (
                'id' => '229',
                'country_code' => 'MN',
                'time_zone_id' => 'Asia/Choibalsan',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            229 => 
            array (
                'id' => '230',
                'country_code' => 'LK',
                'time_zone_id' => 'Asia/Colombo',
                'gmt' => '5.5',
                'dst' => '5.5',
                'raw' => '5.5',
            ),
            230 => 
            array (
                'id' => '231',
                'country_code' => 'SY',
                'time_zone_id' => 'Asia/Damascus',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            231 => 
            array (
                'id' => '232',
                'country_code' => 'BD',
                'time_zone_id' => 'Asia/Dhaka',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            232 => 
            array (
                'id' => '233',
                'country_code' => 'TL',
                'time_zone_id' => 'Asia/Dili',
                'gmt' => '9',
                'dst' => '9',
                'raw' => '9',
            ),
            233 => 
            array (
                'id' => '234',
                'country_code' => 'AE',
                'time_zone_id' => 'Asia/Dubai',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            234 => 
            array (
                'id' => '235',
                'country_code' => 'TJ',
                'time_zone_id' => 'Asia/Dushanbe',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            235 => 
            array (
                'id' => '236',
                'country_code' => 'CY',
                'time_zone_id' => 'Asia/Famagusta',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            236 => 
            array (
                'id' => '237',
                'country_code' => 'PS',
                'time_zone_id' => 'Asia/Gaza',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            237 => 
            array (
                'id' => '238',
                'country_code' => 'PS',
                'time_zone_id' => 'Asia/Hebron',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            238 => 
            array (
                'id' => '239',
                'country_code' => 'VN',
                'time_zone_id' => 'Asia/Ho_Chi_Minh',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            239 => 
            array (
                'id' => '240',
                'country_code' => 'HK',
                'time_zone_id' => 'Asia/Hong_Kong',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            240 => 
            array (
                'id' => '241',
                'country_code' => 'MN',
                'time_zone_id' => 'Asia/Hovd',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            241 => 
            array (
                'id' => '242',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Irkutsk',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            242 => 
            array (
                'id' => '243',
                'country_code' => 'ID',
                'time_zone_id' => 'Asia/Jakarta',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            243 => 
            array (
                'id' => '244',
                'country_code' => 'ID',
                'time_zone_id' => 'Asia/Jayapura',
                'gmt' => '9',
                'dst' => '9',
                'raw' => '9',
            ),
            244 => 
            array (
                'id' => '245',
                'country_code' => 'IL',
                'time_zone_id' => 'Asia/Jerusalem',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            245 => 
            array (
                'id' => '246',
                'country_code' => 'AF',
                'time_zone_id' => 'Asia/Kabul',
                'gmt' => '4.5',
                'dst' => '4.5',
                'raw' => '4.5',
            ),
            246 => 
            array (
                'id' => '247',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Kamchatka',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
            247 => 
            array (
                'id' => '248',
                'country_code' => 'PK',
                'time_zone_id' => 'Asia/Karachi',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            248 => 
            array (
                'id' => '249',
                'country_code' => 'NP',
                'time_zone_id' => 'Asia/Kathmandu',
                'gmt' => '5.75',
                'dst' => '5.75',
                'raw' => '5.75',
            ),
            249 => 
            array (
                'id' => '250',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Khandyga',
                'gmt' => '9',
                'dst' => '9',
                'raw' => '9',
            ),
            250 => 
            array (
                'id' => '251',
                'country_code' => 'IN',
                'time_zone_id' => 'Asia/Kolkata',
                'gmt' => '5.5',
                'dst' => '5.5',
                'raw' => '5.5',
            ),
            251 => 
            array (
                'id' => '252',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Krasnoyarsk',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            252 => 
            array (
                'id' => '253',
                'country_code' => 'MY',
                'time_zone_id' => 'Asia/Kuala_Lumpur',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            253 => 
            array (
                'id' => '254',
                'country_code' => 'MY',
                'time_zone_id' => 'Asia/Kuching',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            254 => 
            array (
                'id' => '255',
                'country_code' => 'KW',
                'time_zone_id' => 'Asia/Kuwait',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            255 => 
            array (
                'id' => '256',
                'country_code' => 'MO',
                'time_zone_id' => 'Asia/Macau',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            256 => 
            array (
                'id' => '257',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Magadan',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            257 => 
            array (
                'id' => '258',
                'country_code' => 'ID',
                'time_zone_id' => 'Asia/Makassar',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            258 => 
            array (
                'id' => '259',
                'country_code' => 'PH',
                'time_zone_id' => 'Asia/Manila',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            259 => 
            array (
                'id' => '260',
                'country_code' => 'OM',
                'time_zone_id' => 'Asia/Muscat',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            260 => 
            array (
                'id' => '261',
                'country_code' => 'CY',
                'time_zone_id' => 'Asia/Nicosia',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            261 => 
            array (
                'id' => '262',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Novokuznetsk',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            262 => 
            array (
                'id' => '263',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Novosibirsk',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            263 => 
            array (
                'id' => '264',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Omsk',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            264 => 
            array (
                'id' => '265',
                'country_code' => 'KZ',
                'time_zone_id' => 'Asia/Oral',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            265 => 
            array (
                'id' => '266',
                'country_code' => 'KH',
                'time_zone_id' => 'Asia/Phnom_Penh',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            266 => 
            array (
                'id' => '267',
                'country_code' => 'ID',
                'time_zone_id' => 'Asia/Pontianak',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            267 => 
            array (
                'id' => '268',
                'country_code' => 'KP',
                'time_zone_id' => 'Asia/Pyongyang',
                'gmt' => '8.5',
                'dst' => '8.5',
                'raw' => '8.5',
            ),
            268 => 
            array (
                'id' => '269',
                'country_code' => 'QA',
                'time_zone_id' => 'Asia/Qatar',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            269 => 
            array (
                'id' => '270',
                'country_code' => 'KZ',
                'time_zone_id' => 'Asia/Qyzylorda',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            270 => 
            array (
                'id' => '271',
                'country_code' => 'SA',
                'time_zone_id' => 'Asia/Riyadh',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            271 => 
            array (
                'id' => '272',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Sakhalin',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            272 => 
            array (
                'id' => '273',
                'country_code' => 'UZ',
                'time_zone_id' => 'Asia/Samarkand',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            273 => 
            array (
                'id' => '274',
                'country_code' => 'KR',
                'time_zone_id' => 'Asia/Seoul',
                'gmt' => '9',
                'dst' => '9',
                'raw' => '9',
            ),
            274 => 
            array (
                'id' => '275',
                'country_code' => 'CN',
                'time_zone_id' => 'Asia/Shanghai',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            275 => 
            array (
                'id' => '276',
                'country_code' => 'SG',
                'time_zone_id' => 'Asia/Singapore',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            276 => 
            array (
                'id' => '277',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Srednekolymsk',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            277 => 
            array (
                'id' => '278',
                'country_code' => 'TW',
                'time_zone_id' => 'Asia/Taipei',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            278 => 
            array (
                'id' => '279',
                'country_code' => 'UZ',
                'time_zone_id' => 'Asia/Tashkent',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            279 => 
            array (
                'id' => '280',
                'country_code' => 'GE',
                'time_zone_id' => 'Asia/Tbilisi',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            280 => 
            array (
                'id' => '281',
                'country_code' => 'IR',
                'time_zone_id' => 'Asia/Tehran',
                'gmt' => '3.5',
                'dst' => '4.5',
                'raw' => '3.5',
            ),
            281 => 
            array (
                'id' => '282',
                'country_code' => 'BT',
                'time_zone_id' => 'Asia/Thimphu',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            282 => 
            array (
                'id' => '283',
                'country_code' => 'JP',
                'time_zone_id' => 'Asia/Tokyo',
                'gmt' => '9',
                'dst' => '9',
                'raw' => '9',
            ),
            283 => 
            array (
                'id' => '284',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Tomsk',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            284 => 
            array (
                'id' => '285',
                'country_code' => 'MN',
                'time_zone_id' => 'Asia/Ulaanbaatar',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            285 => 
            array (
                'id' => '286',
                'country_code' => 'CN',
                'time_zone_id' => 'Asia/Urumqi',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            286 => 
            array (
                'id' => '287',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Ust-Nera',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            287 => 
            array (
                'id' => '288',
                'country_code' => 'LA',
                'time_zone_id' => 'Asia/Vientiane',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            288 => 
            array (
                'id' => '289',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Vladivostok',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            289 => 
            array (
                'id' => '290',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Yakutsk',
                'gmt' => '9',
                'dst' => '9',
                'raw' => '9',
            ),
            290 => 
            array (
                'id' => '291',
                'country_code' => 'MM',
                'time_zone_id' => 'Asia/Yangon',
                'gmt' => '6.5',
                'dst' => '6.5',
                'raw' => '6.5',
            ),
            291 => 
            array (
                'id' => '292',
                'country_code' => 'RU',
                'time_zone_id' => 'Asia/Yekaterinburg',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            292 => 
            array (
                'id' => '293',
                'country_code' => 'AM',
                'time_zone_id' => 'Asia/Yerevan',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            293 => 
            array (
                'id' => '294',
                'country_code' => 'PT',
                'time_zone_id' => 'Atlantic/Azores',
                'gmt' => '-1',
                'dst' => '0',
                'raw' => '-1',
            ),
            294 => 
            array (
                'id' => '295',
                'country_code' => 'BM',
                'time_zone_id' => 'Atlantic/Bermuda',
                'gmt' => '-4',
                'dst' => '-3',
                'raw' => '-4',
            ),
            295 => 
            array (
                'id' => '296',
                'country_code' => 'ES',
                'time_zone_id' => 'Atlantic/Canary',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            296 => 
            array (
                'id' => '297',
                'country_code' => 'CV',
                'time_zone_id' => 'Atlantic/Cape_Verde',
                'gmt' => '-1',
                'dst' => '-1',
                'raw' => '-1',
            ),
            297 => 
            array (
                'id' => '298',
                'country_code' => 'FO',
                'time_zone_id' => 'Atlantic/Faroe',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            298 => 
            array (
                'id' => '299',
                'country_code' => 'PT',
                'time_zone_id' => 'Atlantic/Madeira',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            299 => 
            array (
                'id' => '300',
                'country_code' => 'IS',
                'time_zone_id' => 'Atlantic/Reykjavik',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            300 => 
            array (
                'id' => '301',
                'country_code' => 'GS',
                'time_zone_id' => 'Atlantic/South_Georgia',
                'gmt' => '-2',
                'dst' => '-2',
                'raw' => '-2',
            ),
            301 => 
            array (
                'id' => '302',
                'country_code' => 'SH',
                'time_zone_id' => 'Atlantic/St_Helena',
                'gmt' => '0',
                'dst' => '0',
                'raw' => '0',
            ),
            302 => 
            array (
                'id' => '303',
                'country_code' => 'FK',
                'time_zone_id' => 'Atlantic/Stanley',
                'gmt' => '-3',
                'dst' => '-3',
                'raw' => '-3',
            ),
            303 => 
            array (
                'id' => '304',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Adelaide',
                'gmt' => '10.5',
                'dst' => '9.5',
                'raw' => '9.5',
            ),
            304 => 
            array (
                'id' => '305',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Brisbane',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            305 => 
            array (
                'id' => '306',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Broken_Hill',
                'gmt' => '10.5',
                'dst' => '9.5',
                'raw' => '9.5',
            ),
            306 => 
            array (
                'id' => '307',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Currie',
                'gmt' => '11',
                'dst' => '10',
                'raw' => '10',
            ),
            307 => 
            array (
                'id' => '308',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Darwin',
                'gmt' => '9.5',
                'dst' => '9.5',
                'raw' => '9.5',
            ),
            308 => 
            array (
                'id' => '309',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Eucla',
                'gmt' => '8.75',
                'dst' => '8.75',
                'raw' => '8.75',
            ),
            309 => 
            array (
                'id' => '310',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Hobart',
                'gmt' => '11',
                'dst' => '10',
                'raw' => '10',
            ),
            310 => 
            array (
                'id' => '311',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Lindeman',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            311 => 
            array (
                'id' => '312',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Lord_Howe',
                'gmt' => '11',
                'dst' => '10.5',
                'raw' => '10.5',
            ),
            312 => 
            array (
                'id' => '313',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Melbourne',
                'gmt' => '11',
                'dst' => '10',
                'raw' => '10',
            ),
            313 => 
            array (
                'id' => '314',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Perth',
                'gmt' => '8',
                'dst' => '8',
                'raw' => '8',
            ),
            314 => 
            array (
                'id' => '315',
                'country_code' => 'AU',
                'time_zone_id' => 'Australia/Sydney',
                'gmt' => '11',
                'dst' => '10',
                'raw' => '10',
            ),
            315 => 
            array (
                'id' => '316',
                'country_code' => 'NL',
                'time_zone_id' => 'Europe/Amsterdam',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            316 => 
            array (
                'id' => '317',
                'country_code' => 'AD',
                'time_zone_id' => 'Europe/Andorra',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            317 => 
            array (
                'id' => '318',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Astrakhan',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            318 => 
            array (
                'id' => '319',
                'country_code' => 'GR',
                'time_zone_id' => 'Europe/Athens',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            319 => 
            array (
                'id' => '320',
                'country_code' => 'RS',
                'time_zone_id' => 'Europe/Belgrade',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            320 => 
            array (
                'id' => '321',
                'country_code' => 'DE',
                'time_zone_id' => 'Europe/Berlin',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            321 => 
            array (
                'id' => '322',
                'country_code' => 'SK',
                'time_zone_id' => 'Europe/Bratislava',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            322 => 
            array (
                'id' => '323',
                'country_code' => 'BE',
                'time_zone_id' => 'Europe/Brussels',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            323 => 
            array (
                'id' => '324',
                'country_code' => 'RO',
                'time_zone_id' => 'Europe/Bucharest',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            324 => 
            array (
                'id' => '325',
                'country_code' => 'HU',
                'time_zone_id' => 'Europe/Budapest',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            325 => 
            array (
                'id' => '326',
                'country_code' => 'DE',
                'time_zone_id' => 'Europe/Busingen',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            326 => 
            array (
                'id' => '327',
                'country_code' => 'MD',
                'time_zone_id' => 'Europe/Chisinau',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            327 => 
            array (
                'id' => '328',
                'country_code' => 'DK',
                'time_zone_id' => 'Europe/Copenhagen',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            328 => 
            array (
                'id' => '329',
                'country_code' => 'IE',
                'time_zone_id' => 'Europe/Dublin',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            329 => 
            array (
                'id' => '330',
                'country_code' => 'GI',
                'time_zone_id' => 'Europe/Gibraltar',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            330 => 
            array (
                'id' => '331',
                'country_code' => 'GG',
                'time_zone_id' => 'Europe/Guernsey',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            331 => 
            array (
                'id' => '332',
                'country_code' => 'FI',
                'time_zone_id' => 'Europe/Helsinki',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            332 => 
            array (
                'id' => '333',
                'country_code' => 'IM',
                'time_zone_id' => 'Europe/Isle_of_Man',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            333 => 
            array (
                'id' => '334',
                'country_code' => 'TR',
                'time_zone_id' => 'Europe/Istanbul',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            334 => 
            array (
                'id' => '335',
                'country_code' => 'JE',
                'time_zone_id' => 'Europe/Jersey',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            335 => 
            array (
                'id' => '336',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Kaliningrad',
                'gmt' => '2',
                'dst' => '2',
                'raw' => '2',
            ),
            336 => 
            array (
                'id' => '337',
                'country_code' => 'UA',
                'time_zone_id' => 'Europe/Kiev',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            337 => 
            array (
                'id' => '338',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Kirov',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            338 => 
            array (
                'id' => '339',
                'country_code' => 'PT',
                'time_zone_id' => 'Europe/Lisbon',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            339 => 
            array (
                'id' => '340',
                'country_code' => 'SI',
                'time_zone_id' => 'Europe/Ljubljana',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            340 => 
            array (
                'id' => '341',
                'country_code' => 'UK',
                'time_zone_id' => 'Europe/London',
                'gmt' => '0',
                'dst' => '1',
                'raw' => '0',
            ),
            341 => 
            array (
                'id' => '342',
                'country_code' => 'LU',
                'time_zone_id' => 'Europe/Luxembourg',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            342 => 
            array (
                'id' => '343',
                'country_code' => 'ES',
                'time_zone_id' => 'Europe/Madrid',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            343 => 
            array (
                'id' => '344',
                'country_code' => 'MT',
                'time_zone_id' => 'Europe/Malta',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            344 => 
            array (
                'id' => '345',
                'country_code' => 'AX',
                'time_zone_id' => 'Europe/Mariehamn',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            345 => 
            array (
                'id' => '346',
                'country_code' => 'BY',
                'time_zone_id' => 'Europe/Minsk',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            346 => 
            array (
                'id' => '347',
                'country_code' => 'MC',
                'time_zone_id' => 'Europe/Monaco',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            347 => 
            array (
                'id' => '348',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Moscow',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            348 => 
            array (
                'id' => '349',
                'country_code' => 'NO',
                'time_zone_id' => 'Europe/Oslo',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            349 => 
            array (
                'id' => '350',
                'country_code' => 'FR',
                'time_zone_id' => 'Europe/Paris',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            350 => 
            array (
                'id' => '351',
                'country_code' => 'ME',
                'time_zone_id' => 'Europe/Podgorica',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            351 => 
            array (
                'id' => '352',
                'country_code' => 'CZ',
                'time_zone_id' => 'Europe/Prague',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            352 => 
            array (
                'id' => '353',
                'country_code' => 'LV',
                'time_zone_id' => 'Europe/Riga',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            353 => 
            array (
                'id' => '354',
                'country_code' => 'IT',
                'time_zone_id' => 'Europe/Rome',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            354 => 
            array (
                'id' => '355',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Samara',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            355 => 
            array (
                'id' => '356',
                'country_code' => 'SM',
                'time_zone_id' => 'Europe/San_Marino',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            356 => 
            array (
                'id' => '357',
                'country_code' => 'BA',
                'time_zone_id' => 'Europe/Sarajevo',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            357 => 
            array (
                'id' => '358',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Saratov',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            358 => 
            array (
                'id' => '359',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Simferopol',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            359 => 
            array (
                'id' => '360',
                'country_code' => 'MK',
                'time_zone_id' => 'Europe/Skopje',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            360 => 
            array (
                'id' => '361',
                'country_code' => 'BG',
                'time_zone_id' => 'Europe/Sofia',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            361 => 
            array (
                'id' => '362',
                'country_code' => 'SE',
                'time_zone_id' => 'Europe/Stockholm',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            362 => 
            array (
                'id' => '363',
                'country_code' => 'EE',
                'time_zone_id' => 'Europe/Tallinn',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            363 => 
            array (
                'id' => '364',
                'country_code' => 'AL',
                'time_zone_id' => 'Europe/Tirane',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            364 => 
            array (
                'id' => '365',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Ulyanovsk',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            365 => 
            array (
                'id' => '366',
                'country_code' => 'UA',
                'time_zone_id' => 'Europe/Uzhgorod',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            366 => 
            array (
                'id' => '367',
                'country_code' => 'LI',
                'time_zone_id' => 'Europe/Vaduz',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            367 => 
            array (
                'id' => '368',
                'country_code' => 'VA',
                'time_zone_id' => 'Europe/Vatican',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            368 => 
            array (
                'id' => '369',
                'country_code' => 'AT',
                'time_zone_id' => 'Europe/Vienna',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            369 => 
            array (
                'id' => '370',
                'country_code' => 'LT',
                'time_zone_id' => 'Europe/Vilnius',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            370 => 
            array (
                'id' => '371',
                'country_code' => 'RU',
                'time_zone_id' => 'Europe/Volgograd',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            371 => 
            array (
                'id' => '372',
                'country_code' => 'PL',
                'time_zone_id' => 'Europe/Warsaw',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            372 => 
            array (
                'id' => '373',
                'country_code' => 'HR',
                'time_zone_id' => 'Europe/Zagreb',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            373 => 
            array (
                'id' => '374',
                'country_code' => 'UA',
                'time_zone_id' => 'Europe/Zaporozhye',
                'gmt' => '2',
                'dst' => '3',
                'raw' => '2',
            ),
            374 => 
            array (
                'id' => '375',
                'country_code' => 'CH',
                'time_zone_id' => 'Europe/Zurich',
                'gmt' => '1',
                'dst' => '2',
                'raw' => '1',
            ),
            375 => 
            array (
                'id' => '376',
                'country_code' => 'MG',
                'time_zone_id' => 'Indian/Antananarivo',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            376 => 
            array (
                'id' => '377',
                'country_code' => 'IO',
                'time_zone_id' => 'Indian/Chagos',
                'gmt' => '6',
                'dst' => '6',
                'raw' => '6',
            ),
            377 => 
            array (
                'id' => '378',
                'country_code' => 'CX',
                'time_zone_id' => 'Indian/Christmas',
                'gmt' => '7',
                'dst' => '7',
                'raw' => '7',
            ),
            378 => 
            array (
                'id' => '379',
                'country_code' => 'CC',
                'time_zone_id' => 'Indian/Cocos',
                'gmt' => '6.5',
                'dst' => '6.5',
                'raw' => '6.5',
            ),
            379 => 
            array (
                'id' => '380',
                'country_code' => 'KM',
                'time_zone_id' => 'Indian/Comoro',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            380 => 
            array (
                'id' => '381',
                'country_code' => 'TF',
                'time_zone_id' => 'Indian/Kerguelen',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            381 => 
            array (
                'id' => '382',
                'country_code' => 'SC',
                'time_zone_id' => 'Indian/Mahe',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            382 => 
            array (
                'id' => '383',
                'country_code' => 'MV',
                'time_zone_id' => 'Indian/Maldives',
                'gmt' => '5',
                'dst' => '5',
                'raw' => '5',
            ),
            383 => 
            array (
                'id' => '384',
                'country_code' => 'MU',
                'time_zone_id' => 'Indian/Mauritius',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            384 => 
            array (
                'id' => '385',
                'country_code' => 'YT',
                'time_zone_id' => 'Indian/Mayotte',
                'gmt' => '3',
                'dst' => '3',
                'raw' => '3',
            ),
            385 => 
            array (
                'id' => '386',
                'country_code' => 'RE',
                'time_zone_id' => 'Indian/Reunion',
                'gmt' => '4',
                'dst' => '4',
                'raw' => '4',
            ),
            386 => 
            array (
                'id' => '387',
                'country_code' => 'WS',
                'time_zone_id' => 'Pacific/Apia',
                'gmt' => '14',
                'dst' => '13',
                'raw' => '13',
            ),
            387 => 
            array (
                'id' => '388',
                'country_code' => 'NZ',
                'time_zone_id' => 'Pacific/Auckland',
                'gmt' => '13',
                'dst' => '12',
                'raw' => '12',
            ),
            388 => 
            array (
                'id' => '389',
                'country_code' => 'PG',
                'time_zone_id' => 'Pacific/Bougainville',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            389 => 
            array (
                'id' => '390',
                'country_code' => 'NZ',
                'time_zone_id' => 'Pacific/Chatham',
                'gmt' => '13.75',
                'dst' => '12.75',
                'raw' => '12.75',
            ),
            390 => 
            array (
                'id' => '391',
                'country_code' => 'FM',
                'time_zone_id' => 'Pacific/Chuuk',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            391 => 
            array (
                'id' => '392',
                'country_code' => 'CL',
                'time_zone_id' => 'Pacific/Easter',
                'gmt' => '-5',
                'dst' => '-6',
                'raw' => '-6',
            ),
            392 => 
            array (
                'id' => '393',
                'country_code' => 'VU',
                'time_zone_id' => 'Pacific/Efate',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            393 => 
            array (
                'id' => '394',
                'country_code' => 'KI',
                'time_zone_id' => 'Pacific/Enderbury',
                'gmt' => '13',
                'dst' => '13',
                'raw' => '13',
            ),
            394 => 
            array (
                'id' => '395',
                'country_code' => 'TK',
                'time_zone_id' => 'Pacific/Fakaofo',
                'gmt' => '13',
                'dst' => '13',
                'raw' => '13',
            ),
            395 => 
            array (
                'id' => '396',
                'country_code' => 'FJ',
                'time_zone_id' => 'Pacific/Fiji',
                'gmt' => '13',
                'dst' => '12',
                'raw' => '12',
            ),
            396 => 
            array (
                'id' => '397',
                'country_code' => 'TV',
                'time_zone_id' => 'Pacific/Funafuti',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
            397 => 
            array (
                'id' => '398',
                'country_code' => 'EC',
                'time_zone_id' => 'Pacific/Galapagos',
                'gmt' => '-6',
                'dst' => '-6',
                'raw' => '-6',
            ),
            398 => 
            array (
                'id' => '399',
                'country_code' => 'PF',
                'time_zone_id' => 'Pacific/Gambier',
                'gmt' => '-9',
                'dst' => '-9',
                'raw' => '-9',
            ),
            399 => 
            array (
                'id' => '400',
                'country_code' => 'SB',
                'time_zone_id' => 'Pacific/Guadalcanal',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            400 => 
            array (
                'id' => '401',
                'country_code' => 'GU',
                'time_zone_id' => 'Pacific/Guam',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            401 => 
            array (
                'id' => '402',
                'country_code' => 'US',
                'time_zone_id' => 'Pacific/Honolulu',
                'gmt' => '-10',
                'dst' => '-10',
                'raw' => '-10',
            ),
            402 => 
            array (
                'id' => '403',
                'country_code' => 'KI',
                'time_zone_id' => 'Pacific/Kiritimati',
                'gmt' => '14',
                'dst' => '14',
                'raw' => '14',
            ),
            403 => 
            array (
                'id' => '404',
                'country_code' => 'FM',
                'time_zone_id' => 'Pacific/Kosrae',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            404 => 
            array (
                'id' => '405',
                'country_code' => 'MH',
                'time_zone_id' => 'Pacific/Kwajalein',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
            405 => 
            array (
                'id' => '406',
                'country_code' => 'MH',
                'time_zone_id' => 'Pacific/Majuro',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
            406 => 
            array (
                'id' => '407',
                'country_code' => 'PF',
                'time_zone_id' => 'Pacific/Marquesas',
                'gmt' => '-9.5',
                'dst' => '-9.5',
                'raw' => '-9.5',
            ),
            407 => 
            array (
                'id' => '408',
                'country_code' => 'UM',
                'time_zone_id' => 'Pacific/Midway',
                'gmt' => '-11',
                'dst' => '-11',
                'raw' => '-11',
            ),
            408 => 
            array (
                'id' => '409',
                'country_code' => 'NR',
                'time_zone_id' => 'Pacific/Nauru',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
            409 => 
            array (
                'id' => '410',
                'country_code' => 'NU',
                'time_zone_id' => 'Pacific/Niue',
                'gmt' => '-11',
                'dst' => '-11',
                'raw' => '-11',
            ),
            410 => 
            array (
                'id' => '411',
                'country_code' => 'NF',
                'time_zone_id' => 'Pacific/Norfolk',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            411 => 
            array (
                'id' => '412',
                'country_code' => 'NC',
                'time_zone_id' => 'Pacific/Noumea',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            412 => 
            array (
                'id' => '413',
                'country_code' => 'AS',
                'time_zone_id' => 'Pacific/Pago_Pago',
                'gmt' => '-11',
                'dst' => '-11',
                'raw' => '-11',
            ),
            413 => 
            array (
                'id' => '414',
                'country_code' => 'PW',
                'time_zone_id' => 'Pacific/Palau',
                'gmt' => '9',
                'dst' => '9',
                'raw' => '9',
            ),
            414 => 
            array (
                'id' => '415',
                'country_code' => 'PN',
                'time_zone_id' => 'Pacific/Pitcairn',
                'gmt' => '-8',
                'dst' => '-8',
                'raw' => '-8',
            ),
            415 => 
            array (
                'id' => '416',
                'country_code' => 'FM',
                'time_zone_id' => 'Pacific/Pohnpei',
                'gmt' => '11',
                'dst' => '11',
                'raw' => '11',
            ),
            416 => 
            array (
                'id' => '417',
                'country_code' => 'PG',
                'time_zone_id' => 'Pacific/Port_Moresby',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            417 => 
            array (
                'id' => '418',
                'country_code' => 'CK',
                'time_zone_id' => 'Pacific/Rarotonga',
                'gmt' => '-10',
                'dst' => '-10',
                'raw' => '-10',
            ),
            418 => 
            array (
                'id' => '419',
                'country_code' => 'MP',
                'time_zone_id' => 'Pacific/Saipan',
                'gmt' => '10',
                'dst' => '10',
                'raw' => '10',
            ),
            419 => 
            array (
                'id' => '420',
                'country_code' => 'PF',
                'time_zone_id' => 'Pacific/Tahiti',
                'gmt' => '-10',
                'dst' => '-10',
                'raw' => '-10',
            ),
            420 => 
            array (
                'id' => '421',
                'country_code' => 'KI',
                'time_zone_id' => 'Pacific/Tarawa',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
            421 => 
            array (
                'id' => '422',
                'country_code' => 'TO',
                'time_zone_id' => 'Pacific/Tongatapu',
                'gmt' => '14',
                'dst' => '13',
                'raw' => '13',
            ),
            422 => 
            array (
                'id' => '423',
                'country_code' => 'UM',
                'time_zone_id' => 'Pacific/Wake',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
            423 => 
            array (
                'id' => '424',
                'country_code' => 'WF',
                'time_zone_id' => 'Pacific/Wallis',
                'gmt' => '12',
                'dst' => '12',
                'raw' => '12',
            ),
        ));
        
        
    }
}