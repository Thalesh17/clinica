<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidade extends Model
{
    protected $table = 'especialidade';
    protected $fillable = ['descricao'];

    public function rules() {
        return [
            'descricao' => 'required|max:45|unique:especialidade,descricao'.(($this->id) ? ', ' . $this->id : ''),
        ];
    }

    public $mensagens = [
        'descricao.required' => 'Descrição não informada.',
        'descricao.unique' => 'Descrição já cadastrada.',
        'descricao.max' => 'Descrição deve conter no máximo 45 digitos.',
    ];
}
