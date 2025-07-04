<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tier_bookings', function (Blueprint $table) {

            $table->string('transaction_id')->nullable();
        });
    }

    public function down()
    {
        Schema::table('tier_bookings', function (Blueprint $table) {
            $table->dropColumn('transaction_id');
        });
    }
};
