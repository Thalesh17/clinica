<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableConfiguracao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracao', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cnpj', 14)->unique();
            $table->string('razao_social', 60)->nullable();
            $table->string('nome_fantasia', 50)->nullable();
            $table->string('insc_estadual', 45)->nullable();
            $table->string('email', 45)->nullable();
            $table->string('cep', 8)->nullable();
            $table->string('logradouro', 200)->nullable();
            $table->string('numero', 10)->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 50)->nullable();
            $table->string('cidade', 50)->nullable();
            $table->integer('uf_id')->nullable();
            $table->string('telefone', 10)->nullable();
            $table->string('celular', 11)->nullable();
            $table->string("sigla", 3);
            $table->string("skin", 20);
            $table->timestamps();

            $table->foreign('uf_id')->references('id')->on('uf_estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuracao');
    }
}
