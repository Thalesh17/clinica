<?php

use Illuminate\Database\Seeder;
use App\Models\Sexo;

class SexoTableSeeder extends Seeder
{
    public function run()
    {
        $this->addNewSexo("Masculino");
        $this->addNewSexo("Feminino");
        $this->addNewSexo("Indefinido");
    }

    private function addNewSexo($descricao)
    {
        $sexo = new Sexo();
        $sexo->descricao = $descricao;
        $sexo->save();
    }
}
