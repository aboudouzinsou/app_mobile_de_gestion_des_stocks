<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ligne_ventes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vente_id');
            $table->integer('quantite_vendue');
            $table->timestamps();
            $table->foreign('vente_id')->references('id')->on('ventes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ligne_ventes');
    }
};
