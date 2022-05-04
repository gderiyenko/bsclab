<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_services', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('invoice_id');
            $table->string('service_id');
            $table->integer('service_quantity');
            $table->decimal('service_price', $precision = 14, $scale = 2);
            $table->timestamps();

            $table->index('invoice_id');
            $table->index('service_id');
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
        Schema::dropIfExists('invoice_services');
    }
}
