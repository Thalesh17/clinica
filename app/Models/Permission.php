<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Permission extends Model
{

    protected $table = 'permissions';
    protected $fillable = ['id', 'name', 'description'];

    public function roles()
    {
        return $this->belongsToMany(\App\Models\Role::class);
    }

    public function rules()
    {
    return [
        'name' => ['required', Rule::unique('permissions')->ignore($this->id, 'id')],
        'description' => 'required',
    ];
}

    public $mensages = [
        'name.unique' => 'Nome já cadastrado',
        'name.required' => 'Nome é Obrigatório',
        'description.required' => 'Descrição é obrigatória',
    ];
}
