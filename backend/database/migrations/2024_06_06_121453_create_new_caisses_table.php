<?php



use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;



return new class extends Migration

{

    public function up()

    {

        Schema::create('caisses', function (Blueprint $table) {

            $table->id();

            $table->string('code')->unique(); // Assuming code should be unique

            $table->string('libelle');

            $table->unsignedBigInteger('personnel_id'); // Assuming personnel_id is a foreign key



            $table->foreign('personnel_id')->references('id')->on('personnels')->onDelete('cascade'); // Assuming the table name is 'personnels'

            $table->timestamps();
        });
    }



    public function down()

    {

        Schema::dropIfExists('caisses');
    }
};
