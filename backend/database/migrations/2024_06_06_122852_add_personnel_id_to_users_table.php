<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('personnel_id'); // Assuming personnel_id is a foreign key



            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade'); // Assuming the table name is 'personnels'
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['personnel_id']); // Supprime la clé étrangère
            $table->dropColumn('personnel_id');    // Supprime la colonne personnel_id
        });
    }
};