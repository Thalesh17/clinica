<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Configuracao extends Model
{
    //para deixar uuid como PK
    public $incrementing = false;
    
    protected $table    = "configuracao";
    protected $fillable = [
                            'id',
                            'cnpj', 
                            'razao_social', 
                            'nome_fantasia', 
                            'insc_estadual', 
                            'email', 
                            'cep', 
                            'logradouro', 
                            'numero', 
                            'complemento', 
                            'bairro', 
                            'cidade', 
                            'uf_id' ,
                            'telefone', 
                            'celular',
                            'logo',
                            'sigla',
                            'skin'
                        ];


    public function uf()
    {
      return $this->belongsTo('App\Model\Estados', 'uf_id', 'id');
    }

    public function maskTelefone($telefone)
    {
      return "(".substr($telefone,0,2).") ".substr($telefone,2,4)."-".substr($telefone,6,4);
    }

    public function rules() { 

        return [ 
            'cnpj'           => ['required', Rule::unique('configuracao')->ignore($this->id, 'id')],
            'razao_social'   => 'required',
            'sigla'          => 'required',
        ];
    }
    
    public $msgRules = [
        'cnpj.required'         => 'CNPJ não preenchido.',
        'cnpj.unique'           => 'CNPJ já existe.',
        'razao_social.required' => 'Razão Social não preenchida.',
        'sigla.required'        => 'Sigla não preenchida.'
    ];

}