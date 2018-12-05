<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Role extends Model
{

    protected $table = 'roles';
    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function rules() {
        return [
            'name'          => ['required', Rule::unique('roles')->ignore($this->id, 'id')],
            'description'   => ['required', Rule::unique('roles')->ignore($this->id, 'id')]
        ];
    }

    public $mensages = [
        'name.required'         => 'Nome não informado.',
        'name.unique'           => 'Nome já cadastrado.',
        'description.required'  => 'Descrição não informada.',
        'description.unique'    => 'Descrição já cadastrada.'
    ];

    public static function createRolePaciente($idUser){
        $rolePaciente = 3;
        $createRole = new RoleUser();

        $createRole->user_id = $idUser;
        $createRole->role_id = $rolePaciente;

        $save = $createRole->save();

        return $save;

    }

    public static function createRoleMedico($idUser){
        $roleMedico = 4;
        $createRole = new RoleUser();

        $createRole->user_id = $idUser;
        $createRole->role_id = $roleMedico;

        $save = $createRole->save();

        return $save;

    }
}
