<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ligne_receptions', function (Blueprint $table) {
            $table->id();
            $table->integer('quantite_recu');
            $table->unsignedBigInteger('produit_id'); // Assuming produit_id is a foreign key
            $table->unsignedBigInteger('reception_id'); // Assuming reception_id is a foreign key
            $table->unsignedBigInteger('ligne_commande_id'); // Assuming ligne_commande_id is a foreign key
            
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade'); // Assuming the table name is 'produits'
            $table->foreign('reception_id')->references('id')->on('receptions')->onDelete('cascade'); // Assuming the table name is 'receptions'
            $table->foreign('ligne_commande_id')->references('id')->on('ligne_commandes')->onDelete('cascade'); // Assuming the table name is 'ligne_commandes'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_receptions');
    }
};