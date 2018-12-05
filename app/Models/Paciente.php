<?php

namespace App\Models;

use App\Models\TipoSanguineo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{

    use Notifiable;

    protected $table = 'paciente';
    protected $fillable = [
        'name',
        'numero_paciente',
        'email',
        'password',
        'data_nascimento',
        'cpf',
        'rg',
        'nacionalidade',
        'sexo_id',
        'tipo_sanguineo_id',
        'nome_pai',
        'nome_mae',
        'celular',
        'telefone',
        'endereco',
        'uf_id',
        'cidade',
        'bairro',
        'numero',
        'referencia',
        'observacao',
        ];

    public function rules() {
        return [
            'name'                => 'required|max:100',
            'numero_paciente'     => 'required',
            'email'               => 'required',
            'password'            => 'required',
            'repeat-password'     => 'required',
            'cpf'                 => 'max:14|unique:paciente,cpf'.(($this->id) ? ', ' . $this->id : ''),
            'data_nascimento'     => 'required',
            'rg'                  => 'required',
            'nacionalidade'       => 'max:40',
            'sexo_id'             => 'required|not_in:0',
            'tipo_sanguineo_id'   => 'not_in:0',
            'nome_pai'            => 'max:100',
            'nome_mae'            => 'max:100',
            'celular'             => 'max:11',
            'telefone'            => 'max:10',
            'numero'              => 'max:10',
            'endereco'            => 'max:120',
            'uf_id'               => 'not_in:0',
            'bairro'              => 'max:100',
            'observacao'          => 'max:120',
            'referencia'          => 'max:120'
        ];
    }

    public $mensages = [
        'name.max'                  => 'O Nome do Paciente deve ter no maximo 50 caracteres.',
        'name.required'             => 'O Nome deve ser informado.',
        'numero_paciente.max'       => 'O Número do Paciente deve ter no máximo 14 dígitos.',
        'password.required'         => 'A senha deve ser informada',
        'repeat-password.required'  => 'Confirmar senha deve ser informada.',
        'email.required'            => 'O Email deve ser informado',
        'cpf.max'                   => 'O CPF deve ter no máximo 14 caracteres.',
        'cpf.unique'                => 'O CPF já cadastrado no banco.',
        'cpf.required'              => 'O CPF deve ser informado.',
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
        'sexo_id.not_in'            => 'O Sexo deve ser selecionado.',
        'tipo_sanguineo_id.not_in'  => 'O Tipo Sanguíneo deve ser selecionado.',
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

    public function existePaciente($request, $id)
    {
        $existePaciente =  $this::where('numero_paciente', $request->input('numero_paciente'));

        if($id) {
            $existePaciente = $existePaciente->where('id', '<>', $id);
        }

        return $existePaciente->count('paciente.id');
    }

    public static function getPacienteQuery($id = null){
        $pacientes = Paciente::join('sexo', 'sexo.id', '=', 'paciente.sexo_id')
                              ->join('uf_estado', 'uf_estado.id', '=', 'paciente.uf_id')
                              ->join('tipo_sanguineo', 'tipo_sanguineo.id', '=', 'paciente.tipo_sanguineo_id')
                              ->select('paciente.*',
                                  'tipo_sanguineo.descricao as tipo_sanguineo',
                                  'uf_estado.estado as estado',
                                  'sexo.descricao as sexo')
                              ->orderBy('paciente.name', 'ASC');

        return $pacientes;
    }

    public static function filterAdvanced($request){

        $numero_paciente = $request->input('numero_paciente');
        $email = $request->input('email');
        $telefone = $request->input('telefone');
        $data_nascimento = $request->input('data_nascimento');
        $cidade = $request->input('cidade');
        $data_cadastro = $request->input('data_cadastro');

        $telefone = preg_replace("/[^0-9]/", "", $request->input('telefone'));

        $pacientes = Paciente::getPacienteQuery();

        if($numero_paciente){
            $pacientes = $pacientes->where('paciente.numero_paciente', 'ILIKE', "%$numero_paciente%");
        }

        if($email){
            $pacientes = $pacientes->where('paciente.email', 'ILIKE', "%$email%");
        }

        if($telefone){
            $pacientes = $pacientes->where('paciente.telefone', 'ILIKE', "%$telefone%");
        }

        if($data_nascimento){
            $pacientes = $pacientes->whereRaw("to_char(paciente.data_nascimento, 'YYYY-mm-dd') = ?", $data_nascimento);
        }

        if($cidade){
            $pacientes = $pacientes->where('paciente.cidade', 'ILIKE', "%$cidade%");
        }

        if($data_cadastro){
            $pacientes = $pacientes->whereRaw("to_char(paciente.created_at, 'YYYY-mm-dd') = ?", $data_cadastro);
        }

        return $pacientes;
    }

    public function validatePaciente($request, $validate){
        $id                 = $request->input('id');
        $nome               = $request->input('name');
        $email              = $request->input('email');
        $password           = $request->input('password');
        $repeat_password    = $request->input('repeat-password');
        $numero_paciente    = $request->input('numero_paciente');
        $numero             = $request->input('numero');
        $sexo               = $request->input('sexo_id');
        $tipoSanguineo      = $request->input('tipo_sanguineo_id');
        $uf                 = $request->input('uf_id');
        $data_nascimento    = $request->input('data_nascimento');
        $telefone           = preg_replace("/[^0-9]/", "", $request->input('telefone'));
        $celular            = preg_replace("/[^0-9]/", "", $request->input('celular'));
        $cpf                = preg_replace("/[^0-9]/", "", $request->input('cpf'));

        if(empty($numero_paciente)){
            $validate->errors()->add("numero_paciente", "O Numero do Paciente é obrigatório.");
        }

        if(empty($password)){
            $validate->errors()->add("password", "A Senha é obrigatório.");
        }

        if(empty($repeat_password)){
            $validate->errors()->add("repeat-password", "A Confirmação de Senha é obrigatório.");
        }

        if(empty($email)){
            $validate->errors()->add("email", "O Email é obrigatório.");
        }

        if(empty($nome)){
            $validate->errors()->add("name", "O Nome é obrigatório.");
        }

        if(empty($data_nascimento)){
            $validate->errors()->add("data_nascimento", "A Data de Nascimento é obrigatório.");
        }

        if(empty($cpf)){
            $validate->errors()->add("cpf", "O CPF é obrigatório.");
        }

        if($tipoSanguineo == 0){
            $validate->errors()->add("tipo_sanguineo_id", "O Tipo Sanguíneo deve ser selecionado.");
        }

        if($sexo == 0){
            $validate->errors()->add("sexo_id", "O Sexo deve ser selecionado.");
        }

        if($uf == 0){
            $validate->errors()->add("uf_id", "O Estado deve ser selecionado.");
        }

        if($password != $repeat_password){
            $validate->errors()->add("password", "As senhas não coincidem.");
        }

        if(!onlyLetters($nome)){
            $validate->errors()->add("nome", "Nome do Paciente deve conter apenas letras.");
        }

        if(!onlyNumbers($numero_paciente)){
            $validate->errors()->add("numero_paciente", "Nº Paciente deve conter apenas números.");
        }

        if(!onlyNumbers($numero)){
            $validate->errors()->add("numero", "Nº deve conter apenas números.");
        }

        if($cpf != ""){
            $cpfvalido = validateCpf($cpf);
            if($cpfvalido != "")
                $validate->errors()->add("cpf", $cpfvalido);
        }

        if($sexo == 0){
            $validate->errors()->add("sexo", "O Sexo deve ser selecionado.");
        }

        if($telefone != null && strlen($telefone) < 10){
            $validate->errors()->add("telefone", "Telefone deve conter no mínimo 10 dígitos.");
        }

        if($celular != null && strlen($celular) < 10){
            $validate->errors()->add("celular", "Celular deve conter no mínimo 10 dígitos.");
        }

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
