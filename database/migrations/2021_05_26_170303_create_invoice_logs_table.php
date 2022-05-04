<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_logs', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->string('user_name');
            $table->string('action_name');
            $table->string('invoice_number');
            $table->date('invoice_date');
            $table->string('contract_number');
            $table->string('payment_type');
            $table->decimal('amount', 14, 2);
            $table->decimal('pdv', 14, 2);
            $table->decimal('pdv_minus', 14, 2);
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
        Schema::dropIfExists('invoice_logs');
    }
}
