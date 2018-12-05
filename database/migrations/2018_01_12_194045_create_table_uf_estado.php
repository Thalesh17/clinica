<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class CreateTableUfEstado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uf_estado', function(Blueprint $table){
            $table->increments('id');
            $table->string('uf', 2);
            $table->string('estado',30);
        });

        DB::table('uf_estado')->insert(
            array(
                array('id' => 1,'estado' => 'Acre', 'uf' => 'AC'),
                array('id' => 2, 'estado' => 'Alagoas', 'uf' => 'AL'),
                array('id' => 3, 'estado' => 'Amapá', 'uf' => 'AP'),
                array('id' => 4, 'estado' => 'Amazonas', 'uf' => 'AM'),
                array('id' => 5, 'estado' => 'Bahia', 'uf' => 'BA'),
                array('id' => 6, 'estado' => 'Ceará', 'uf' => 'CE'),
                array('id' => 7, 'estado' => 'Distrito Federal', 'uf' => 'DF'),
                array('id' => 8, 'estado' => 'Espírito Santo', 'uf' => 'ES'),
                array('id' => 9, 'estado' => 'Goiás', 'uf' => 'GO'),
                array('id' => 10, 'estado' => 'Maranhão', 'uf' => 'MA'),
                array('id' => 11, 'estado' => 'Mato Grosso', 'uf' => 'MT'),
                array('id' => 12, 'estado' => 'Mato Grosso do Sul', 'uf' => 'MS'),
                array('id' => 13, 'estado' => 'Minas Gerais', 'uf' => 'MG'),
                array('id' => 14, 'estado' => 'Pará', 'uf' => 'PA'),
                array('id' => 15, 'estado' => 'Paraíba', 'uf' => 'PB'),
                array('id' => 16, 'estado' => 'Paraná', 'uf' => 'PR'),
                array('id' => 17, 'estado' => 'Pernambuco', 'uf' => 'PE'),
                array('id' => 18, 'estado' => 'Piauí', 'uf' => 'PI'),
                array('id' => 19, 'estado' => 'Rio de Janeiro', 'uf' => 'RJ'),
                array('id' => 20, 'estado' => 'Rio Grande do Norte', 'uf' => 'RN'),
                array('id' => 21, 'estado' => 'Rio Grande do Sul', 'uf' => 'RS'),
                array('id' => 22, 'estado' => 'Rondônia', 'uf' => 'RO'),
                array('id' => 23, 'estado' => 'Roraima', 'uf' => 'RR'),
                array('id' => 24, 'estado' => 'Santa Catarina', 'uf' => 'SC'),
                array('id' => 25, 'estado' => 'São Paulo', 'uf' => 'SP'),
                array('id' => 26, 'estado' => 'Sergipe', 'uf' => 'SE'),
                array('id' => 27, 'estado' => 'Tocantins', 'uf' => 'TO'),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uf_estado');
    }
}
