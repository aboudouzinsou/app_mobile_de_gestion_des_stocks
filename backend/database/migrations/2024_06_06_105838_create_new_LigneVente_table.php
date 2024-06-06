<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ligne_ventes', function (Blueprint $table) {
            $table->id();
            $table->integer('quantite_vendu');
            $table->unsignedBigInteger('vente_id'); // Assuming vente_id is a foreign key
            $table->unsignedBigInteger('produit_id'); // Assuming produit_id is a foreign key
            
            $table->foreign('vente_id')->references('id')->on('ventes')->onDelete('cascade'); // Assuming the table name is 'ventes'
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade'); // Assuming the table name is 'produits'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_ventes');
    }
};