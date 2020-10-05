<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use DB;

class CahngePackageUidToPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        DB::statement("ALTER TABLE `packages` CHANGE `package_uid` `package_uid` ENUM('_access','_access_free','_access_partner') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT '_access_free';");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }

     
}
