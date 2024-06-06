<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Exercice', function (Blueprint $table) {
            $table->id();
            $table->string('code_exercice');
            $table->timestamp('date_debut');
            $table->timestamp('date_fin');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Exercice');
    }
};
