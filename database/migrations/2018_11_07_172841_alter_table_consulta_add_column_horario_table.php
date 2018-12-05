<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableConsultaAddColumnHorarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consulta', function (Blueprint $table){
            $table->time('horario_consulta')->nullable();
        });
    }


    public function down()
    {
        Schema::table('consulta', function (Blueprint $table){
            $table->dropColumn('horario_consulta');
        });
    }
}
