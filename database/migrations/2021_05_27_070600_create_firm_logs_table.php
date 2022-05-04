<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFirmLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firm_logs', function (Blueprint $table) {
            $table->id();
            $table->string('firm_id');
            $table->string('user_name');
            $table->string('action_name');
            $table->string('firm_name');
            $table->string('firm_name_short')->nullable();
            $table->string('boss_position')->nullable();
            $table->string('boss_pib')->nullable();
            $table->string('work_position')->nullable();
            $table->string('work_pib')->nullable();
            $table->string('addr_zip_ur')->nullable();
            $table->string('addr_obl_ur')->nullable();
            $table->string('addr_city_ur')->nullable();
            $table->string('addr_street_ur')->nullable();
            $table->string('addr_house_ur')->nullable();
            $table->string('addr_zip_fact')->nullable();
            $table->string('addr_obl_fact')->nullable();
            $table->string('addr_city_fact')->nullable();
            $table->string('addr_street_fact')->nullable();
            $table->string('addr_house_fact')->nullable();
            $table->string('edrpou')->nullable();
            $table->string('ipn')->nullable();
            $table->string('tax')->nullable();
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
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('firm_logs');
    }
}
