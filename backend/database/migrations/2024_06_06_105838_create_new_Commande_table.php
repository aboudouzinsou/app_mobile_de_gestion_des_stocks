<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('numero_commande')->unique(); // Assuming numero_commande should be unique
            $table->timestamp('date_emission');
            $table->timestamp('date_limite_boncommande');
            $table->timestamp('date_livraison');
            $table->string('statut_commande');
            $table->boolean('livree');
            $table->unsignedBigInteger('fournisseur_id'); // Assuming fournisseur_id is a foreign key
            $table->unsignedBigInteger('exercice_id'); // Assuming exercice_id is a foreign key
            
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('cascade'); // Assuming the table name is 'fournisseurs'
            $table->foreign('exercice_id')->references('id')->on('exercices')->onDelete('cascade'); // Assuming the table name is 'exercices'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commandes');
    }
};