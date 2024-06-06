<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new  class extends Migration
{
    public function up()
    {
        Schema::create('ligne_commandes', function (Blueprint $table) {
            $table->id();
            $table->integer('quantite_produit_commande');
            $table->integer('qte_livre');
            $table->integer('qte_restate');
            $table->decimal('TVA', 10, 2);
            $table->decimal('TTC', 10, 2);
            $table->unsignedBigInteger('commande_id'); // Assuming commande_id is a foreign key
            $table->unsignedBigInteger('produit_id'); // Assuming produit_id is a foreign key
            
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade'); // Assuming the table name is 'commandes'
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade'); // Assuming the table name is 'produits'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_commandes');
    }
};