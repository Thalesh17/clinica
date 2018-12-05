<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;

class Medico extends Model
{
    protected $table = 'medico';

    protected $fillable = [
        'name',
        'data_nascimento',
        'crm',
        'rg',
        'nacionalidade',
        'sexo_id',
        'tipo_sanguineo_id',
        'celular',
        'telefone',
        'endereco',
        'uf_id',
        'especialidade_id',
        'cidade',
        'bairro',
        'numero',
        'referencia',
        'observacao',
        'horario_inicio',
        'horario_termino',
    ];

    public function rules() {
        return [
            'name'                => 'required|max:100',
//            'email'               => 'required',
//            'password'            => 'required',
//            'repeat-password'     => 'required',
            'data_nascimento'     => 'required',
            'rg'                  => 'required',
            'nacionalidade'       => 'max:40',
            'sexo_id'             => 'required|not_in:0',
            'especialidade_id'    => 'required|not_in:0',
            'uf_id'               => 'required|not_in:0',
            'tipo_sanguineo_id'   => 'not_in:0',
            'celular'             => 'max:11',
            'crm'                 => 'unique:medico,crm'.(($this->id) ? ', ' . $this->id : ''),
            'telefone'            => 'max:10',
            'numero'              => 'max:10',
            'endereco'            => 'max:120',
            'bairro'              => 'max:100',
            'observacao'          => 'max:120',
            'referencia'          => 'max:120',
            'horario_inicio'      => 'required',
            'horario_termino'     => 'required',
        ];
    }

    public $mensages = [
        'name.max'                  => 'O Nome do Médico deve ter no maximo 50 caracteres.',
        'name.required'             => 'O Nome deve ser informado.',
//        'password.required'         => 'A senha deve ser informada',
//        'repeat-password.required'  => 'Confirmar senha deve ser informada.',
        'crm.max'                   => 'O CRM deve ter no máximo 14 caracteres.',
        'crm.required'              => 'O CRM deve ser informado.',
        'crm.unique'                => 'O CRM informado ja existe',
        'rg.max'                    => 'O RG deve ter no minimo 15 caracteres.',
        'rg.required'               => 'O RG deve ser informado.',
        'nacionalidade.max'         => 'A Nacionalidade deve ter no maximo 40 dígitos',
        'data_nascimento.required'  => 'A Data de Nascimento deve ser informada',
        'uc.max'                    => 'A UC deve ter no máximo 45 caracteres.',
        'celular.max'               => 'O Celular deve ter no maximo 11 digitos',
        'telefone.max'              => 'O Telefone deve ter no maximo 10 digitos',
        'numero.max'                => 'O Número deve ter no máximo 10 caracteres.',
        'endereco.max'              => 'O Endereço deve ter no máximo 120 caracteres.',
        'referencia.max'            => 'A Referência deve ter no máximo 120 caracteres.',
        'bairro.max'                => 'O Bairro deve ter no máximo 100 caracteres.',
        'uf_id.not_in'              => 'O Estado deve ser selecionado.',
        'uf_id.required'            => 'O Estado deve ser obrigatório.',
        'especialidade_id.not_in'   => 'A Especalidade deve ser selecionada.',
        'especialidade_id.required' => 'A Especialidade deve ser obrigatório.',
        'sexo_id.not_in'            => 'O Sexo deve ser selecionado.',
        'tipo_sanguineo_id.not_in'  => 'O Tipo Sanguíneo deve ser selecionado.',
        'horario_inicio.required'   => 'O Horario de Inicio deve ser informado',
        'horario_termino.required'   => 'O Horario de Término deve ser informado',
    ];



    public function sexo() {
        return $this->hasOne(Sexo::class, 'sexo_id', 'id');
    }

    public function tipoSanguineo() {
        return $this->hasOne(TipoSanguineo::class, 'tipo_sanguineo_id', 'id');
    }

    public function estados() {
        return $this->hasOne(Estados::class, 'estado_id', 'id');
    }

    public function existeMedico($request, $id)
    {
        $existeMedico =  $this::where('crm', $request->input('crm'));

        if($id) {
            $existeMedico = $existeMedico->where('id', '<>', $id);
        }

        return $existeMedico->count('medico.id');
    }

    public static function getMedicoQuery($id = null){
        $query =  Medico::join('tipo_sanguineo', 'tipo_sanguineo.id', '=', 'medico.tipo_sanguineo_id')
            ->join('especialidade', 'especialidade.id', '=', 'medico.especialidade_id')
            ->join('sexo', 'sexo.id', '=', 'medico.sexo_id')
            ->join('users', 'users.id', '=', 'medico.user_id')
            ->join('uf_estado', 'uf_estado.id', '=', 'medico.uf_id')
            ->distinct('medico.id')
            ->select('medico.*',
                'tipo_sanguineo.descricao as tipo_sanguineo',
                'especialidade.descricao as especialidade',
                'sexo.descricao as sexo',
                'users.email',
                'uf_estado.estado as estado')
            ->orderBy('name')->groupBy('medico.id',
                'tipo_sanguineo.descricao',
                'sexo.descricao',
                'users.email',
                'especialidade.descricao',
                'uf_estado.estado');

        if($id){
            $query = $query->where('medico.id', $id);
        }

        return $query;
    }

    public static function filterAdvanced($request){
        $email = $request->input('email');
        $telefone = $request->input('telefone');
        $data_nascimento = $request->input('data_nascimento');
        $cidade = $request->input('cidade');
        $data_cadastro = $request->input('data_cadastro');
        $telefone           = preg_replace("/[^0-9]/", "", $request->input('telefone'));

        $medicos = Medico::getMedicoQuery();

        if($email){
            $medicos = $medicos->where('users.email', 'ILIKE', "%$email%");
        }

        if($telefone){
            $medicos = $medicos->where('medico.telefone', 'ILIKE', "%$telefone%");
        }

        if($data_nascimento){
            $medicos = $medicos->whereRaw("to_char(medico.data_nascimento, 'YYYY-mm-dd') = ?", $data_nascimento);
        }

        if($cidade){
            $medicos = $medicos->where('medico.cidade', 'ILIKE', "%$cidade%");
        }

        if($data_cadastro){
            $medicos = $medicos->whereRaw("to_char(medico.created_at, 'YYYY-mm-dd') = ?", $data_cadastro);
        }

        return $medicos;
    }

    public function validateMedico($request, $validate){
        $id                 = $request->input('id');
        $nome               = $request->input('name');
        $email              = $request->input('email');
//        $password           = $request->input('password');
//        $repeat_password    = $request->input('repeat-password');
        $numero             = $request->input('numero');
        $sexo               = $request->input('sexo_id');
        $especialidade      = $request->input('especialidade_id');
        $tipoSanguineo      = $request->input('tipo_sanguineo_id');
        $uf                 = $request->input('uf_id');
        $data_nascimento    = $request->input('data_nascimento');
        $telefone           = preg_replace("/[^0-9]/", "", $request->input('telefone'));
        $celular            = preg_replace("/[^0-9]/", "", $request->input('celular'));

        if(empty($especialidade)){
            $validate->errors()->add("especialidade-select", "Selecione uma especialidade.");
        }

//        if(empty($password)){
//            $validate->errors()->add("password", "A Senha é obrigatório.");
//        }

//        if(empty($numero_paciente)){
//            $validate->errors()->add("repeat-password", "A Confirmação de Senha é obrigatório.");
//        }

        if(empty($email)){
            $validate->errors()->add("email", "O Email é obrigatório.");
        }

        if(empty($nome)){
            $validate->errors()->add("name", "O Nome é obrigatório.");
        }

        if(empty($data_nascimento)){
            $validate->errors()->add("data_nascimento", "A Data de Nascimento é obrigatório.");
        }

//        if(empty($cpf)){
//            $validate->errors()->add("cpf", "O CPF é obrigatório.");
//        }

        if($tipoSanguineo == 0){
            $validate->errors()->add("tipo_sanguineo_id", "O Tipo Sanguíneo deve ser selecionado.");
        }

        if($sexo == 0){
            $validate->errors()->add("sexo_id", "O Sexo deve ser selecionado.");
        }

        if($uf == 0){
            $validate->errors()->add("uf_id", "O Estado deve ser selecionado.");
        }

//        if($password != $repeat_password){
//            $validate->errors()->add("password", "As senhas não coincidem.");
//        }

        if(!onlyLetters($nome)){
            $validate->errors()->add("nome", "Nome do Médico deve conter apenas letras.");
        }

        if(!onlyNumbers($numero)){
            $validate->errors()->add("numero", "Nº deve conter apenas números.");
        }

        if($sexo == 0){
            $validate->errors()->add("sexo", "O Sexo deve ser selecionado.");
        }

//        if($telefone != null && strlen($telefone) < 10){
//            $validate->errors()->add("telefone", "Telefone deve conter no mínimo 10 dígitos.");
//        }
//
//        if($celular != null && strlen($celular) < 10){
//            $validate->errors()->add("celular", "Celular deve conter no mínimo 10 dígitos.");
//        }

        if(!onlyNumbers($telefone)){
            $validate->errors()->add("telefone", "Telefone deve conter apenas números.");
        }

        if(!onlyNumbers($celular)){
            $validate->errors()->add("celular", "Celular deve conter apenas números.");
        }

        if(validateData($data_nascimento)){
            $validate->errors()->add("data_nascimento", "A Data de Nascimento não pode ser maior que a Data Atual.");
        }

        return $validate;
    }

}
