<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class  extends Migration
{
    public function up()
    {
        Schema::create('inventaires', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_inventaire');
            $table->unsignedBigInteger('exercice_id'); // Assuming exercice_id is a foreign key
            $table->unsignedBigInteger('magasin_id'); // Assuming magasin_id is a foreign key
            
            $table->foreign('exercice_id')->references('id')->on('exercices')->onDelete('cascade'); // Assuming the table name is 'exercices'
            $table->foreign('magasin_id')->references('id')->on('magasins')->onDelete('cascade'); // Assuming the table name is 'magasins'
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventaires');
    }
};