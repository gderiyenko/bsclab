<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPdvToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->decimal('pdv', 14, 2)->after('amount_text');
            $table->string('pdv_text')->after('pdv');
            $table->decimal('pdv_minus', 14, 2)->after('pdv_text');
            $table->string('pdv_minus_text')->after('pdv_minus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('pdv', 'pdv_text', 'pdv_minus', 'pdv_minus_text');
        });
    }
}
