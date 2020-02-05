<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGruposRepositoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos_repositorios', function (Blueprint $table) {
            $table->unsignedBigInteger('idGrupo');
            $table->unsignedBigInteger('idRepositorio');
            $table->enum('papel', ['Editor', 'Visitante']);	
            
            $table->foreign('idGrupo')->references('id')->on('grupos');
            $table->foreign('idRepositorio')->references('id')->on('repositorios');
            
            $table->primary(['idGrupo', 'idRepositorio']);
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
        Schema::dropIfExists('grupos_repositorios');
    }
}
