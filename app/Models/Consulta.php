<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    protected $table = 'consulta';
    protected $fillable = ['paciente_id', 'medico_id', 'data_consulta', 'especialidade_id', 'observacao', 'sintoma', 'horario_consulta'];

    public function rules(){
        return [
            'paciente_id'          => 'required|not_in:0',
            'medico_id'            => 'required|not_in:0',
            'especialidade_id'     => 'required|not_in:0',
            'data_consulta'        => 'required',
            'sintoma'              => 'required',
            'horario_consulta'     => 'required',
        ];
    }

    public $mensagens = [
        'paciente_id.required'             => 'O Paciente deve ser selecionado',
        'paciente_id.not_in'               => 'O Paciente deve ser selecionado',
        'observacao.required'              => 'A Observação deve ser selecionado',
        'horario_consulta.required'        => 'O Horário da Consulta deve ser selecionado',
        'medico_id.required'               => 'O Médico deve ser selecionado',
        'medico_id.not_in'                 => 'O Médico deve ser selecionado',
        'especialidade_id.not_in'          => 'Selecione uma especialidade',
        'data_consulta.required'           => 'Selecione uma data',
        'sintoma.required'                 => 'Selecione um sintoma',
    ];

    public static function getConsultaQuery($id = null){

        $consultas = Consulta::join('paciente', 'paciente.id', '=','consulta.paciente_id')
            ->join('medico', 'medico.id', '=', 'consulta.medico_id')
            ->join('especialidade', 'especialidade.id', '=', 'medico.especialidade_id')
            ->select('consulta.id','consulta.observacao', 'paciente.name as paciente', 'consulta.data_consulta','consulta.sintoma', 'consulta.horario_consulta',
                'medico.name as medico', 'especialidade.descricao as especialidade');

        if(validateLogin(['PACIENTE'])){
            $consultas = $consultas->where('paciente.user_id', \Auth::user()->id);
        }elseif(validateLogin(['MEDICO'])){
            $consultas = $consultas->where('medico.user_id', \Auth::user()->id);
        }

        return $consultas;
    }

    public static function filterAdvanced($request)
    {
        $paciente = $request->input('paciente');
        $medico = $request->input('medico');
        $especialidade = $request->input('especialidade');
        $sintoma = $request->input('sintoma');
        $data_consulta = $request->input('data_consulta');
        $horario = $request->input('horario');

        $consultas = Consulta::getConsultaQuery()->orderBy('data_consulta', 'DESC');

        if($paciente){
            $consultas = $consultas->where('paciente.name', 'ILIKE', "%$paciente%");
        }

        if($medico){
            $consultas = $consultas->where('medico.name', 'ILIKE', "%$medico%");
        }

        if($especialidade){
            $consultas = $consultas->where('especialidade.id', $especialidade);
        }

        if($sintoma){
            $consultas = $consultas->where('consulta.sintoma', 'ILIKE', "%$sintoma%");
        }
        if($data_consulta){
            $consultas = $consultas->whereRaw("to_char(consulta.data_consulta, 'YYYY-mm-dd') = ? ", $data_consulta);
        }
        if($horario){
            $consultas = $consultas->whereRaw("to_char(consulta.horario_consulta, 'HH24:mm') = ? ", $horario);

        }

        return $consultas;
    }

    public function validateConsulta($request, $validate){
        $id         = $request->input('id');
        $paciente   = $request->input('paciente_id');
        $medico     = $request->input('medico_id');
        $data_consulta = $request->input('data_consulta');

        if(empty($data_consulta)){
            $validate->errors()->add("data_consulta", "Data da Consulta não pode ser maior que a Data Atual.");
        }

        if(!empty($data_consulta) && validateData($data_consulta)){
            $validate->errors()->add("data_consulta", "Data da Consulta não pode ser maior que a Data Atual.");
        }

        return $validate;
    }

}
