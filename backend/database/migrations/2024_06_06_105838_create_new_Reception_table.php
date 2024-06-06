<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receptions', function (Blueprint $table) {
            $table->id();
            $table->string('numero_reception');
            $table->timestamp('date_reception');
            $table->unsignedBigInteger('commande_id'); // Assuming id_commande is a foreign key
            $table->unsignedBigInteger('exercice_id'); // Assuming exercice_id is a foreign key
            $table->unsignedBigInteger('magasin_id'); // Assuming magasin_id is a foreign key
            
            $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade'); // Assuming the table name is 'commandes'
            $table->foreign('exercice_id')->references('id')->on('exercices')->onDelete('cascade'); // Assuming the table name is 'exercices'
            $table->foreign('magasin_id')->references('id')->on('magasins')->onDelete('cascade'); // Assuming the table name is 'magasins'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('receptions');
    }
};