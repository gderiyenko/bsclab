<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acts', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('number')->unique();
            $table->date('date');
            $table->string('firm_id');
            $table->string('invoice_id');
            $table->date('protocol_date');
            $table->timestamps();

            $table->index('firm_id');
            $table->index('invoice_id');
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
        Schema::dropIfExists('acts');
    }
}
