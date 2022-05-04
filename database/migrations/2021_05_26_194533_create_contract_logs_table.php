<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract_logs', function (Blueprint $table) {
            $table->id();
            $table->string('contract_id');
            $table->string('user_name');
            $table->string('action_name');
            $table->string('number');
            $table->date('date_contract');
            $table->date('date_end');
            $table->decimal('amount', 14, 2)->nullable();
            $table->string('note')->nullable();
            $table->tinyInteger('category')->nullable();
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
        Schema::dropIfExists('contract_logs');
    }
}
