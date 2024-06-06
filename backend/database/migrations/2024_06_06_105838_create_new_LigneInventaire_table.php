<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ligne_inventaires', function (Blueprint $table) {
            $table->id();
            $table->integer('qte_produit_inv');
            $table->unsignedBigInteger('inventaire_id'); // Assuming inventaire_id is a foreign key
            $table->unsignedBigInteger('produit_id'); // Assuming produit_id is a foreign key
            
            $table->foreign('inventaire_id')->references('id')->on('inventaires')->onDelete('cascade'); // Assuming the table name is 'inventaires'
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade'); // Assuming the table name is 'produits'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ligne_inventaires');
    }
};