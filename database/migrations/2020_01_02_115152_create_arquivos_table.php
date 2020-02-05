<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome');
            $table->string('descricao')->nullable();
            $table->string('path');
            $table->string('extensao');
            $table->unsignedBigInteger('modificado')->default(0);
            $table->unsignedBigInteger('size');
            $table->unsignedBigInteger('idAutor');
            $table->unsignedBigInteger('idRepositorio');

            $table->foreign('idRepositorio')->references('id')->on('repositorios');
            $table->foreign('idAutor')->references('id')->on('users');
            
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
        Schema::dropIfExists('arquivos');
    }
}
