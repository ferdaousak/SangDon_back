<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRdvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('rdvs');

        Schema::create('rdvs', function (Blueprint $table) {
            $table->id();

            $table->dateTime('date_rdv');

            $table->foreignId('centre_id')->constrained();
            $table->foreignId('don_id')->constrained()->nullable();
            $table->foreignId('demande_id')->constrained()->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('rdvs');
        Schema::enableForeignKeyConstraints();
    }
}
