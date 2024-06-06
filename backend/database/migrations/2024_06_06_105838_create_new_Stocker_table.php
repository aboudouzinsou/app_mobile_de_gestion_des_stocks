<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stockers', function (Blueprint $table) {
            $table->id();
            $table->integer('qte_stocke');
            $table->integer('dump'); // It's unclear what this column represents. Consider renaming it for clarity.
            $table->unsignedBigInteger('magasin_id'); // Assuming magasin_id is a foreign key
            $table->unsignedBigInteger('produit_id'); // Assuming produit_id is a foreign key
            
            $table->foreign('magasin_id')->references('id')->on('magasins')->onDelete('cascade'); // Assuming the table name is 'magasins'
            $table->foreign('produit_id')->references('id')->on('produits')->onDelete('cascade'); // Assuming the table name is 'produits'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('stockers');
    }
};