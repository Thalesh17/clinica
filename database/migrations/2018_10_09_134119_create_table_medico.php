<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableMedico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('data_nascimento')->nullable();
            $table->string('rg')->nullable();
            $table->string('crm')->nullable();
            $table->string('nacionalidade')->nullable();
            $table->string('celular', 11)->nullable();
            $table->string('telefone', 10)->nullable();
            $table->string('endereco', 100)->nullable();
            $table->string('cidade')->nullable();
            $table->string('bairro', 100)->nullable();
            $table->string('numero', 20)->nullable();
            $table->string('referencia')->nullable();
            $table->string('observacao')->nullable();
            $table->integer('uf_id')->unsigned();
            $table->integer('sexo_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->time('horario_inicio');
            $table->time('horario_termino');
            $table->integer('tipo_sanguineo_id')->unsigned();
            $table->integer('especialidade_id')->unsigned();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('sexo_id')->references('id')->on('sexo');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('especialidade_id')->references('id')->on('especialidade');
            $table->foreign('tipo_sanguineo_id')->references('id')->on('tipo_sanguineo');
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
        Schema::dropIfExists('medico');
    }
}
