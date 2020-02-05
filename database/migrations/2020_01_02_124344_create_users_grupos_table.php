<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_grupos', function (Blueprint $table) {
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idGrupo');
            
            $table->foreign('idUser')->references('id')->on('users');
            $table->foreign('idGrupo')->references('id')->on('grupos');
            
            $table->primary(['idUser', 'idGrupo']);	
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
        Schema::dropIfExists('users_grupos');

    }
}
