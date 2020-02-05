<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cnpj', 14)->unique();
            $table->string('razaoSocial')->unique();
            $table->string('nomeFantasia');
            $table->enum('status', ['Ativo', 'Inativo', 'Suspenso']);
            $table->date('dataSuspensao')->nullable();
            $table->unsignedBigInteger('idResponsavel');
            $table->unsignedBigInteger('idEndereco');

            $table->foreign('idResponsavel')->references('id')->on('users');
            $table->foreign('idEndereco')->references('id')->on('enderecos');

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
        Schema::dropIfExists('empresas');
    }
}
