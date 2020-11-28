<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_passes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('service_id');
            $table->string('name')->unique();
            $table->integer('repetitions')->default(0);
            $table->integer('expiry_days')->default(0);
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
        Schema::dropIfExists('service_passes');
    }
}
