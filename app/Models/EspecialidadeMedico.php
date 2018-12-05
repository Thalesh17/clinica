<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspecialidadeMedico extends Model
{
    protected $table = 'especialidade_medico';
    protected $fillable = ['medico_id', 'especialidade_id'];

    public function medico()
    {
        return $this->belongsTo(\App\Medico::class, 'medico_id', 'id');
    }

    public function especialidade()
    {
        return $this->belongsTo(\App\Models\Especialidade::class, 'especialidade_id', 'id');
    }
}
