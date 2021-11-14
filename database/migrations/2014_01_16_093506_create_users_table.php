<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('date_naissance')->nullable();
            $table->string('sexe')->nullable();
            $table->string('type')->default('utilisateur');
            $table->string('email')->unique();
            $table->string('password');
            $table->foreignId('type_sang_id')->nullable()->constrained('type_sangs');
            $table->foreignId('ville_id')->nullable()->constrained('villes');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
