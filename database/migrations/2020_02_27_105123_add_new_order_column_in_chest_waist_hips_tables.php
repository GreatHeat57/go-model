<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewOrderColumnInChestWaistHipsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('user_waist_units_options', function ($table) {
            $table->integer('order')->after('at_unit')->default(0);
        });

        Schema::table('user_hips_units_options', function ($table) {
            $table->integer('order')->after('at_unit')->default(0);
        });

        Schema::table('user_chest_units_options', function ($table) {
            $table->integer('order')->after('at_unit')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_waist_units_options', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        Schema::table('user_hips_units_options', function (Blueprint $table) {
            $table->dropColumn('order');
        });

        Schema::table('user_chest_units_options', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }


    /*
    * Insert query to store new child records
    */

    /* INSERT INTO `user_waist_units_options` (`us_unit`, `uk_unit`, `at_unit`, `order`) VALUES ("11.8 in","11.8 in", "30 cm", 1),("12.2 in","12.2 in", "31 cm", 2),("12.6 in","12.6 in", "32 cm", 3),("13.0 in","13.0 in", "33 cm", 4),("13.4 in","13.4 in", "34 cm", 5),("13.8 in","13.8 in", "35 cm", 6),("14.2 in","14.2 in", "36 cm", 7),("14.6 in","14.6 in", "37 cm", 8),("15.0 in","15.0 in", "38 cm", 9),("15.4 in","15.4 in", "39 cm", 10),("15.7 in","15.7 in", "40 cm", 11),("16.1 in","16.1 in", "41 cm", 12),("16.5 in","16.5 in", "42 cm", 13),("16.9 in","16.9 in", "43 cm", 14),("17.3 in","17.3 in", "44 cm", 15),("17.7 in","17.7 in", "45 cm", 16),("18.1 in","18.1 in", "46 cm", 17),("18.5 in","18.5 in", "47 cm", 18),("18.9 in","18.9 in", "48 cm", 19),("19.3 in","19.3 in", "49 cm", 20),("19.7 in","19.7 in", "50 cm", 21),("20.1 in","20.1 in", "51 cm", 22),("20.5 in","20.5 in", "52 cm", 23),("20.9 in","20.9 in", "53 cm", 24),("21.3 in","21.3 in", "54 cm", 25),("21.7 in","21.7 in", "55 cm", 26),("22.0 in","22.0 in", "56 cm", 27),("22.4 in","22.4 in", "57 cm", 28),("22.8 in","22.8 in", "58 cm", 29),("23.2 in","23.2 in", "59 cm", 30); */

    /*
    INSERT INTO `user_hips_units_options` (`us_unit`, `uk_unit`, `at_unit`, `order`) VALUES ("11.8 in","11.8 in", "30 cm", 1),("12.2 in","12.2 in", "31 cm", 2),("12.6 in","12.6 in", "32 cm", 3),("13.0 in","13.0 in", "33 cm", 4),("13.4 in","13.4 in", "34 cm", 5),("13.8 in","13.8 in", "35 cm", 6),("14.2 in","14.2 in", "36 cm", 7),("14.6 in","14.6 in", "37 cm", 8),("15.0 in","15.0 in", "38 cm", 9),("15.4 in","15.4 in", "39 cm", 10),("15.7 in","15.7 in", "40 cm", 11),("16.1 in","16.1 in", "41 cm", 12),("16.5 in","16.5 in", "42 cm", 13),("16.9 in","16.9 in", "43 cm", 14),("17.3 in","17.3 in", "44 cm", 15),("17.7 in","17.7 in", "45 cm", 16),("18.1 in","18.1 in", "46 cm", 17),("18.5 in","18.5 in", "47 cm", 18),("18.9 in","18.9 in", "48 cm", 19),("19.3 in","19.3 in", "49 cm", 20),("19.7 in","19.7 in", "50 cm", 21),("20.1 in","20.1 in", "51 cm", 22),("20.5 in","20.5 in", "52 cm", 23),("20.9 in","20.9 in", "53 cm", 24),("21.3 in","21.3 in", "54 cm", 25),("21.7 in","21.7 in", "55 cm", 26),("22.0 in","22.0 in", "56 cm", 27),("22.4 in","22.4 in", "57 cm", 28),("22.8 in","22.8 in", "58 cm", 29),("23.2 in","23.2 in", "59 cm", 30);
    */

    /*
    INSERT INTO `user_chest_units_options` (`us_unit`, `uk_unit`, `at_unit`, `order`) VALUES ("11.8 in","11.8 in", "30 cm", 1),("12.2 in","12.2 in", "31 cm", 2),("12.6 in","12.6 in", "32 cm", 3),("13.0 in","13.0 in", "33 cm", 4),("13.4 in","13.4 in", "34 cm", 5),("13.8 in","13.8 in", "35 cm", 6),("14.2 in","14.2 in", "36 cm", 7),("14.6 in","14.6 in", "37 cm", 8),("15.0 in","15.0 in", "38 cm", 9),("15.4 in","15.4 in", "39 cm", 10),("15.7 in","15.7 in", "40 cm", 11),("16.1 in","16.1 in", "41 cm", 12),("16.5 in","16.5 in", "42 cm", 13),("16.9 in","16.9 in", "43 cm", 14),("17.3 in","17.3 in", "44 cm", 15),("17.7 in","17.7 in", "45 cm", 16),("18.1 in","18.1 in", "46 cm", 17),("18.5 in","18.5 in", "47 cm", 18),("18.9 in","18.9 in", "48 cm", 19),("19.3 in","19.3 in", "49 cm", 20),("19.7 in","19.7 in", "50 cm", 21),("20.1 in","20.1 in", "51 cm", 22),("20.5 in","20.5 in", "52 cm", 23),("20.9 in","20.9 in", "53 cm", 24),("21.3 in","21.3 in", "54 cm", 25),("21.7 in","21.7 in", "55 cm", 26),("22.0 in","22.0 in", "56 cm", 27),("22.4 in","22.4 in", "57 cm", 28),("22.8 in","22.8 in", "58 cm", 29),("23.2 in","23.2 in", "59 cm", 30);
    */

    /*
    * update order column query
    */

    /*
    
    // update `user_waist_units_options`
    SET @ordering = 30;

    UPDATE `user_waist_units_options` SET `order` = (@ordering := @ordering + 1) WHERE `order` = 0
    ORDER BY `id` ASC;
    
    // update `user_hips_units_options`
    SET @ordering = 30;

    UPDATE `user_hips_units_options` SET `order` = (@ordering := @ordering + 1) WHERE `order` = 0 ORDER BY `id` ASC;

    // update `user_chest_units_options`
    SET @ordering = 30;

    UPDATE `user_chest_units_options` SET `order` = (@ordering := @ordering + 1) WHERE `order` = 0 ORDER BY   `id` ASC;

    */
}
