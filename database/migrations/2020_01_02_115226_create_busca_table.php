<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuscaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buscas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('ocr');
            $table->unsignedInteger('page');
            $table->unsignedBigInteger('idArquivo');
            $table->foreign('idArquivo')->references('id')->on('arquivos');
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
        Schema::dropIfExists('buscas');
    }
}
