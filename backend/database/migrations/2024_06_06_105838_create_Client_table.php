<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Client', function (Blueprint $table) {
            $table->id();
            $table->string('nom_client');
            $table->string('prenom_client');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Client');
    }
};