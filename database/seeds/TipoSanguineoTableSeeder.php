<?php

use Illuminate\Database\Seeder;
use App\Models\TipoSanguineo;

class TipoSanguineoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addNewTipo('A+');
        $this->addNewTipo('A-');
        $this->addNewTipo('O+');
        $this->addNewTipo('O-');
        $this->addNewTipo('AB+');
        $this->addNewTipo('AB-');
        $this->addNewTipo('B+');
        $this->addNewTipo('B-');
    }

    private function addNewTipo($descricao)
    {
        $tipoSanguineo = new TipoSanguineo();
        $tipoSanguineo->descricao = $descricao;
        $tipoSanguineo->save();
    }
}
