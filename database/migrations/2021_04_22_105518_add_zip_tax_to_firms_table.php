<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddZipTaxToFirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->string('addr_zip_ur')->nullable()->after('boss_pib');
            $table->string('addr_zip_fact')->nullable()->after('addr_house_ur');
            $table->string('tax')->nullable()->after('ipn');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('firms', function (Blueprint $table) {
            $table->dropColumn('addr_zip_ur');
            $table->dropColumn('addr_zip_fact');
            $table->dropColumn('tax');
        });
    }
}
