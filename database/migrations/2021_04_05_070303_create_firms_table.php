<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firms', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('firm_name')->unique();
            $table->string('firm_name_short')->nullable();
            $table->string('boss_position')->nullable();
            $table->string('boss_pib')->nullable();
            $table->string('addr_obl_ur')->nullable();
            $table->string('addr_city_ur')->nullable();
            $table->string('addr_street_ur')->nullable();
            $table->string('addr_house_ur')->nullable();
            $table->string('addr_obl_fact')->nullable();
            $table->string('addr_city_fact')->nullable();
            $table->string('addr_street_fact')->nullable();
            $table->string('addr_house_fact')->nullable();
            $table->string('edrpou')->unique()->nullable();
            $table->string('ipn')->unique()->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_mfo')->nullable();
            $table->string('phone_shared')->nullable();
            $table->string('email_shared')->nullable();
            $table->string('phone_acc')->nullable();
            $table->string('email_acc')->nullable();
            $table->string('phone_work')->nullable();
            $table->string('email_work')->nullable();
            $table->string('carr_name')->nullable();
            $table->string('carr_city')->nullable();
            $table->string('carr_dep')->nullable();
            $table->string('carr_pib')->nullable();
            $table->string('carr_phone')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->primary('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firms');
    }
}
