<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTelefoneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_telefones', function (Blueprint $table) {
            $table->unsignedBigInteger('idEmpresa');
            $table->unsignedBigInteger('idTelefone');
            
            $table->foreign('idEmpresa')->references('id')->on('empresas');
            $table->foreign('idTelefone')->references('id')->on('telefones');
            
            $table->primary(['idEmpresa', 'idTelefone']);	
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
        Schema::dropIfExists('empresas_telefones');

    }
}
