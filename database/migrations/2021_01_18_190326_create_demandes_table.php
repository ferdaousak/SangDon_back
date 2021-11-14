<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('demandes', function (Blueprint $table) {
            $table->id();

            $table->boolean('stat')->default(true);
            $table->foreignId('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('id_ville')->references('id')->on('villes')->onDelete('cascade');
            $table->foreignId('id_centre')->references('id')->on('centres')->onDelete('cascade');
            $table->foreignId('id_type_sang')->references('id')->on('type_sangs')->onDelete('cascade');
            $table->foreignId('id_rdv')->nullable()->references('id')->on('type_sangs')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demandes');
    }
}
