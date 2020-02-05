<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepositoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositorios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->unsignedBigInteger('idEmpresa');
            $table->unsignedBigInteger('idRepositorio')->nullable();
            
            $table->foreign('idRepositorio')->references('id')->on('repositorios');
            $table->foreign('idEmpresa')->references('id')->on('empresas');
            
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
        Schema::dropIfExists('repositorios');
    }
}
