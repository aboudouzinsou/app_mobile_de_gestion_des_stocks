<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('libelle');
            $table->decimal('prix', 10, 2); // Corrected the decimal definition
            $table->unsignedBigInteger('categorie_id'); // Assuming id_categorie is a foreign key
            
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade'); // Assuming the table name is 'categories'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produits');
    }
};