<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_vente');
            $table->unsignedBigInteger('caisse_id'); // Assuming caisse_id is a foreign key
            $table->unsignedBigInteger('client_id'); // Assuming client_id is a foreign key
            $table->unsignedBigInteger('exercice_id'); // Assuming exercice_id is a foreign key
            
            $table->foreign('caisse_id')->references('id')->on('caisses')->onDelete('cascade'); // Assuming the table name is 'caisses'
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade'); // Assuming the table name is 'clients'
            $table->foreign('exercice_id')->references('id')->on('exercices')->onDelete('cascade'); // Assuming the table name is 'exercices'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ventes');
    }
};