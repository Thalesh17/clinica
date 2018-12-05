<?php

use Illuminate\Database\Seeder;
use App\Models\Especialidade;

class EspecialidadeTableSeeder extends Seeder
{
    public function run()
    {
        $this->addNewEspecialidade("Cardiologista");
        $this->addNewEspecialidade("Neurologista");
        $this->addNewEspecialidade("Otorrinolaringolostica");
    }

    private function addNewEspecialidade($descricao)
    {
        $especialidade = new Especialidade();
        $especialidade->descricao = $descricao;
        $especialidade->save();
    }
}
