<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('Fournisseur', function (Blueprint $table) {
            $table->id();
            $table->string('code_fournisseur');
            $table->string('nom_fournisseur');
            $table->string('adresse_fournisseur');
            $table->string('telephone_fournisseur');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('Fournisseur');
    }
};
