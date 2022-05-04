<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('act_logs', function (Blueprint $table) {
            $table->id();
            $table->string('act_id');
            $table->string('user_name');
            $table->string('action_name');
            $table->string('act_number');
            $table->date('act_date');
            $table->string('invoice_number');
            $table->date('protocol_date');
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
        Schema::dropIfExists('act_logs');
    }
}
