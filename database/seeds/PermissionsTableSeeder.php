<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //CONSULTA
        $this->addPermissions(1, 'AGENDAR_CONSULTA', 'AGENDA AS CONSULTAS');
        $this->addPermissions(2, 'EDITAR_CONSULTA', 'EDITA AS CONSULTAS');
        $this->addPermissions(3, 'EXCLUIR_CONSULTA', 'EXCLUIR CONSULTAS');
        $this->addPermissions(4, 'VISUALIZAR_CONSULTA', 'VISUALIZAR CONSULTA');
        //PACIENTES
        $this->addPermissions(5,'VISUALIZAR_HISTORICO_PACIENTE', 'VISUALIZA O HISTORICO DO PACIENTE');
        $this->addPermissions(6,'CADASTRAR_PACIENTE','CADASTRAR O PACIENTE');
        $this->addPermissions(7,'EDITAR_PACIENTE','EDITAR O PACIENTE');
        $this->addPermissions(8,'EXCLUIR_PACIENTE','EXCLUIR O PACIENTE');
        $this->addPermissions(9,'VISUALIZAR_PACIENTE','VISUALIZA O PACIENTE');
        //MEDICO
        $this->addPermissions(10,'VISUALIZAR_HISTORICO_MEDICO', 'VISUALIZA O HISTORICO DO MEDICO');
        $this->addPermissions(11,'CADASTRAR_MEDICO','CADASTRAR O MEDICO');
        $this->addPermissions(12,'EDITAR_MEDICO','EDITAR O MEDICO');
        $this->addPermissions(13,'EXCLUIR_MEDICO','EXCLUIR O MEDICO');
        $this->addPermissions(14,'VISUALIZAR_MEDICO','VISUALIZA O MEDICO');
        //TABELAS-SISTEMA
        $this->addPermissions(15, 'CONSULTAR_TABELAS_SISTEMA', 'VISUALIZAR REGISTROS CONTIDOS NAS TABELAS DO SISTEMA');
        $this->addPermissions(16, 'CADASTRAR_TABELAS_SISTEMA', 'CADASTRAR REGISTROS CONTIDOS NAS TABELAS DO SISTEMA');
        $this->addPermissions(17, 'EXCLUIR_TABELAS_SISTEMA', 'EXCLUIR REGISTROS CONTIDOS NAS TABELAS DO SISTEMA');
        //USUÁRIOS
        $this->addPermissions(18, 'AGENDAR_CONSULTA_PACIENTE', 'AGENDAR CONSULTA PACIENTE LOGADO');
        $this->addPermissions(19, 'AGENDAR_CONSULTA_MEDICO', 'AGENDAR CONSULTA MEDICO LOGADO');
        $this->addPermissions(20, 'AGENDAR_CONSULTA_ATENDENTE', 'AGENDAR CONSULTA');

        $this->addPermissions(21, 'INFORMATIVO_PACIENTE', 'INFORMATIVO PACIENTE LOGADO');
        $this->addPermissions(22, 'INFORMATIVO_MEDICO', 'INFORMATIVO MEDICO LOGADO');

        $this->addPermissions(23, 'CONSULTAS_MEDICO', 'CONSULTAS DO MEDICO LOGADO');
        $this->addPermissions(24, 'CONSULTAS_PACIENTE', 'CONSULTAS DO PACIENTE LOGADO');
        $this->addPermissions(25, 'CONSULTAS_ATENDENTE', 'CONSULTAS DO ATENDENTE LOGADO');

        $this->addPermissions(26, 'CALENDARIO_MEDICO', 'CALENDÁRIO MÉDICO');
        $this->addPermissions(27, 'VISUALIZAR_ATENDIMENTO', 'VISUALIZAR O ATENDIMENTO');
    }



    private function addPermissions($id, $name, $description)
    {
        $permission = Permission::where('id', $id)->first();
        if(!isset($permission)){
            $permission = new Permission();
            $permission->id = $id;
            $permission->name = $name;
            $permission->description = $description;
            $permission->save();
        }
    }
}
