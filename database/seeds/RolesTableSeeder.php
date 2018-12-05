<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addRole(1,'ADMINISTRADOR','Administrador do Sistema');
        $this->addRole(2,'GERENTE','Gerente');
        $this->addRole(3,'PACIENTE','Paciente');
        $this->addRole(4,'MEDICO','Médico');
    }

    private function addRole($id, $name, $description)
    {
        $role = new Role();
        $role->id = $id;
        $role->name = $name;
        $role->description = $description;
        $role->save();
    }
}
