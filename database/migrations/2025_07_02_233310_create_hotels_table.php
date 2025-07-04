<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('destination_id');
            $table->string('name');
            $table->string('address')->nullable();
            $table->json('amenities')->nullable();
            $table->json('photos')->nullable();
            $table->timestamps();

            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('hotels');
    }
};
