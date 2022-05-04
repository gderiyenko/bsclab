<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('number')->unique();
            $table->date('date_contract');
            $table->string('firm_id');
            $table->date('date_signature')->nullable();
            $table->date('date_end')->nullable();
            $table->string('note')->nullable();
            $table->timestamps();

            $table->index('firm_id');
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
        Schema::dropIfExists('contracts');
    }
}
