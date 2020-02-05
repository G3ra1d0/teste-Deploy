<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTelefoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_telefones', function (Blueprint $table) {
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idTelefone');
            
            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idTelefone')->references('id')->on('telefones');
            
            $table->primary(['idUser', 'idTelefone']);	
            // $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_telefones');

    }
}
