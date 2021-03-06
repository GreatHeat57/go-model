<?php

use Illuminate\Database\Seeder;

class UserShoesUnitsOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('user_shoes_units_options')->delete();

        DB::table('user_shoes_units_options')
        ->insert([
            [
                'standard_unit' => 15,
                'uk_unit_kids' => 0,
                'us_unit_kids' => 0,
                'at_unit_kids' => 15,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '3.25"',
                'cm_units' => 8.3
            ],
            [
                'standard_unit' => 16,
                'uk_unit_kids' => 0.5,
                'us_unit_kids' => 1,
                'at_unit_kids' => 16,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '3.5"',
                'cm_units' => 8.9
            ],
            [
                'standard_unit' => 17,
                'uk_unit_kids' => 1,
                'us_unit_kids' => 2,
                'at_unit_kids' => 17,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '3.625"',
                'cm_units' => 9.2
            ],
            [
                'standard_unit' => 18,
                'uk_unit_kids' => 2,
                'us_unit_kids' => 3,
                'at_unit_kids' => 18,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '4.125"',
                'cm_units' => 10.5
            ],
            [
                'standard_unit' => 19,
                'uk_unit_kids' => 3,
                'us_unit_kids' => 4,
                'at_unit_kids' => 19,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '4.5"',
                'cm_units' => 11.4
            ],
            [
                'standard_unit' => 20,
                'uk_unit_kids' => 4,
                'us_unit_kids' => 5,
                'at_unit_kids' => 20,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '4.75"',
                'cm_units' => 12.1
            ],
            [
                'standard_unit' => 21,
                'uk_unit_kids' => 4.5,
                'us_unit_kids' => 5.5,
                'at_unit_kids' => 21,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '5"',
                'cm_units' => 12.7
            ],
            [
                'standard_unit' => 22,
                'uk_unit_kids' => 5,
                'us_unit_kids' => 6,
                'at_unit_kids' => 22,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '5.125"',
                'cm_units' => 13
            ],
            [
                'standard_unit' => 23,
                'uk_unit_kids' => 6,
                'us_unit_kids' => 7,
                'at_unit_kids' => 23,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '5.5"',
                'cm_units' => 14
            ],
            [
                'standard_unit' => 24,
                'uk_unit_kids' => 7,
                'us_unit_kids' => 8,
                'at_unit_kids' => 24,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '5.75"',
                'cm_units' => 14.6
            ],
            [
                'standard_unit' => 25,
                'uk_unit_kids' => 8,
                'us_unit_kids' => 9,
                'at_unit_kids' => 25,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '6.125"',
                'cm_units' => 15.6
            ],
            [
                'standard_unit' => 26,
                'uk_unit_kids' => 8.5,
                'us_unit_kids' => 9.5,
                'at_unit_kids' => 26,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '6.25"',
                'cm_units' => 15.9
            ],
            [
                'standard_unit' => 27,
                'uk_unit_kids' => 9,
                'us_unit_kids' => 10,
                'at_unit_kids' => 27,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '6.5"',
                'cm_units' => 16.5
            ],
            [
                'standard_unit' => 28,
                'uk_unit_kids' => 10,
                'us_unit_kids' => 11,
                'at_unit_kids' => 28,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '6.75"',
                'cm_units' => 17.1
            ],
            [
                'standard_unit' => 29,
                'uk_unit_kids' => 10.5,
                'us_unit_kids' => 11.5,
                'at_unit_kids' => 29,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '7"',
                'cm_units' => 17.8
            ],
            [
                'standard_unit' => 30,
                'uk_unit_kids' => 11,
                'us_unit_kids' => 12,
                'at_unit_kids' => 30,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '7.125"',
                'cm_units' => 18.1
            ],
            [
                'standard_unit' => 31,
                'uk_unit_kids' => 12,
                'us_unit_kids' => 13,
                'at_unit_kids' => 31,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '7.5"',
                'cm_units' => 19.1
            ],
            [
                'standard_unit' => 32,
                'uk_unit_kids' => 13,
                'us_unit_kids' => 1,
                'at_unit_kids' => 32,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '7.75"',
                'cm_units' => 19.7
            ],
            [
                'standard_unit' => 33,
                'uk_unit_kids' => 14,
                'us_unit_kids' => 2,
                'at_unit_kids' => 33,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '8"',
                'cm_units' => 20.3
            ],
            [
                'standard_unit' => 34,
                'uk_unit_kids' => 1.5,
                'us_unit_kids' => 3,
                'at_unit_kids' => 34,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => 1,
                'us_unit_women' => 3.5,
                'at_unit_women' => 34,
                'inch_units' => '8.25"',
                'cm_units' => 21
            ],
            [
                'standard_unit' => 34.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => 1.5,
                'us_unit_women' => 4,
                'at_unit_women' => 34.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 35,
                'uk_unit_kids' => 2.5,
                'us_unit_kids' => 3.5,
                'at_unit_kids' => 35,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => 2,
                'us_unit_women' => 4.5,
                'at_unit_women' => 35,
                'inch_units' => '8.625"',
                'cm_units' => 21.9
            ],
            [
                'standard_unit' => 35.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => 2.5,
                'us_unit_women' => 5,
                'at_unit_women' => 35.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 36,
                'uk_unit_kids' => 3,
                'us_unit_kids' => 4,
                'at_unit_kids' => 36,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => 3,
                'us_unit_women' => 5.5,
                'at_unit_women' => 36,
                'inch_units' => '8.75"',
                'cm_units' => 22.2
            ],
            [
                'standard_unit' => 36.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => 3.5,
                'us_unit_women' => 6,
                'at_unit_women' => 36.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 37,
                'uk_unit_kids' => 4,
                'us_unit_kids' => 5,
                'at_unit_kids' => 37,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => 4,
                'us_unit_women' => 6.5,
                'at_unit_women' => 37,
                'inch_units' => '9.125"',
                'cm_units' => 23.2
            ],
            [
                'standard_unit' => 37.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => NULL,
                'us_unit_men' => NULL,
                'at_unit_men' => NULL,
                'uk_unit_women' => 4.5,
                'us_unit_women' => 7,
                'at_unit_women' => 37.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 38,
                'uk_unit_kids' => 5,
                'us_unit_kids' => 6,
                'at_unit_kids' => 38,
                'uk_unit_men' => 4,
                'us_unit_men' => 5,
                'at_unit_men' => 38,
                'uk_unit_women' => 5,
                'us_unit_women' => 7.5,
                'at_unit_women' => 38,
                'inch_units' => '9.5"',
                'cm_units' => 24.1
            ],
            [
                'standard_unit' => 38.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 4.5,
                'us_unit_men' => 5.5,
                'at_unit_men' => 38.5,
                'uk_unit_women' => 5.5,
                'us_unit_women' => 8,
                'at_unit_women' => 38.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 39,
                'uk_unit_kids' => 6,
                'us_unit_kids' => 7,
                'at_unit_kids' => 39,
                'uk_unit_men' => 5,
                'us_unit_men' => 6,
                'at_unit_men' => 39,
                'uk_unit_women' => 6,
                'us_unit_women' => 8.5,
                'at_unit_women' => 39,
                'inch_units' => '9.75"',
                'cm_units' => 24.8
            ],
            [
                'standard_unit' => 39.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 5.5,
                'us_unit_men' => 6.5,
                'at_unit_men' => 39.5,
                'uk_unit_women' => 6.5,
                'us_unit_women' => 9,
                'at_unit_women' => 39.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 40,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 6,
                'us_unit_men' => 7,
                'at_unit_men' => 40,
                'uk_unit_women' => 7,
                'us_unit_women' => 9.5,
                'at_unit_women' => 40,
                'inch_units' => '9.625"',
                'cm_units' => 24.4
            ],
            [
                'standard_unit' => 40.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 6.5,
                'us_unit_men' => 7.5,
                'at_unit_men' => 40.5,
                'uk_unit_women' => 7.5,
                'us_unit_women' => 10,
                'at_unit_women' => 40.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 41,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 7,
                'us_unit_men' => 8,
                'at_unit_men' => 41,
                'uk_unit_women' => 8,
                'us_unit_women' => 10.5,
                'at_unit_women' => 41,
                'inch_units' => '9.9375"',
                'cm_units' => 25.4
            ],
            [
                'standard_unit' => 41.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 7.5,
                'us_unit_men' => 8.5,
                'at_unit_men' => 41.5,
                'uk_unit_women' => 8.5,
                'us_unit_women' => 11,
                'at_unit_women' => 41.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 42,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 8,
                'us_unit_men' => 9,
                'at_unit_men' => 42,
                'uk_unit_women' => 9,
                'us_unit_women' => 11.5,
                'at_unit_women' => 42,
                'inch_units' => '10.25"',
                'cm_units' => 26
            ],
            [
                'standard_unit' => 42.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 8.5,
                'us_unit_men' => 9.5,
                'at_unit_men' => 42.5,
                'uk_unit_women' => 9.5,
                'us_unit_women' => 12,
                'at_unit_women' => 42.5,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 43,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 9,
                'us_unit_men' => 10,
                'at_unit_men' => 43,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '10.5625"',
                'cm_units' => 27
            ],
            [
                'standard_unit' => 43.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 9.5,
                'us_unit_men' => 10.5,
                'at_unit_men' => 43.5,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 44,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 10,
                'us_unit_men' => 11,
                'at_unit_men' => 44,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '10.9375"',
                'cm_units' => 27.9
            ],
            [
                'standard_unit' => 44.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 10.5,
                'us_unit_men' => 11.5,
                'at_unit_men' => 44.5,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 45,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 11,
                'us_unit_men' => 12,
                'at_unit_men' => 45,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '11.25"',
                'cm_units' => 28.6
            ],
            [
                'standard_unit' => 45.5,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 11.5,
                'us_unit_men' => 12.5,
                'at_unit_men' => 45.5,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 46,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 12,
                'us_unit_men' => 13,
                'at_unit_men' => 46,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '11.5625"',
                'cm_units' => 29.4
            ],
            [
                'standard_unit' => 47,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 13.5,
                'us_unit_men' => 14,
                'at_unit_men' => 47,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '11.875"',
                'cm_units' => 30.2
            ],
            [
                'standard_unit' => 48,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 14.5,
                'us_unit_men' => 15,
                'at_unit_men' => 48,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '12.1875"',
                'cm_units' => 31
            ],
            [
                'standard_unit' => 49,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 15.5,
                'us_unit_men' => 16,
                'at_unit_men' => 49,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => '12.5"',
                'cm_units' => 31.8
            ],
            [
                'standard_unit' => 50,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 16.5,
                'us_unit_men' => 17,
                'at_unit_men' => 50,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 51,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 17.5,
                'us_unit_men' => 18,
                'at_unit_men' => 51,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => NULL,
                'cm_units' => NULL
            ],
            [
                'standard_unit' => 52,
                'uk_unit_kids' => NULL,
                'us_unit_kids' => NULL,
                'at_unit_kids' => NULL,
                'uk_unit_men' => 18.5,
                'us_unit_men' => 19,
                'at_unit_men' => 52,
                'uk_unit_women' => NULL,
                'us_unit_women' => NULL,
                'at_unit_women' => NULL,
                'inch_units' => NULL,
                'cm_units' => NULL
            ]
        ]);
    }
}
