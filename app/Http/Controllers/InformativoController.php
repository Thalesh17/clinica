<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InformativoController extends Controller
{
    public function getDayConsultas(Request $request){
        $dataInicial = date("Y")."-".date("m")."-01";
        $dataFinal=  date("Y")."-".date("m-").cal_days_in_month(CAL_GREGORIAN,date('m'),date('Y'));

        $consultas = Consulta::whereBetween('data_consulta', [$dataInicial, $dataFinal])
                                ->join('paciente', 'paciente.id', '=', 'consulta.paciente_id')
                                ->join('medico', 'medico.id', '=', 'consulta.medico_id')
                                ->join('especialidade', 'especialidade.id', '=', 'medico.especialidade_id');

        if(validateLogin(['PACIENTE'])){
            $consultas = $consultas->leftJoin('users as user_paciente', 'user_paciente.id', '=', 'paciente.user_id')
                ->where('user_paciente.id', Auth::user()->id)
                ->select(\DB::raw(" especialidade.descricao as especialidade, count(*) as consultas, to_char(data_consulta, 'DD') as dia"))
                ->groupBy('dia', 'especialidade.descricao');
        }elseif(validateLogin(['MEDICO'])){
            $consultas = $consultas->leftJoin('users as user_medico', 'user_medico.id', '=', 'medico.user_id')
                ->where('user_medico.id', Auth::user()->id)
                ->select(\DB::raw("paciente.name as especialidade, count(*) as consultas, to_char(data_consulta, 'DD') as dia"))
                ->groupBy('dia', 'paciente.name');
        }else{
            $consultas = $consultas->leftJoin('users as user_paciente', 'user_paciente.id', '=', 'paciente.user_id')
                ->select(\DB::raw("paciente.name as especialidade, count(*) as consultas, to_char(data_consulta, 'DD') as dia"))
                ->groupBy('dia', 'paciente.name');
        }


        $consultas = $consultas->get()->toArray();

        $especialidades = array_unique(array_column($consultas, 'especialidade'));

        $result = [];
        foreach ($especialidades as $especialidade){
            $especInfo = [$especialidade,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0];
            foreach ($consultas as $consulta){
                if ($especialidade == $consulta['especialidade']){
                    $especInfo[intval($consulta['dia'])] = $consulta['consultas'];
                }
            }
            array_push($result,$especInfo);
        }

        return response()->json($result);
    }

    public function getYearConsultas(Request $request){
        $anoFilter = $request->input('ano_entregue') ? $request->input('ano_entregue') : date('Y');

        $anoInicialFilter = ($anoFilter)."-01-01";
        $anoFinalFilter   =  ($anoFilter)."-12-31";

        $dataInicial = date('Y')."-01-01";
        $dataFinal = date("Y-m-d");

        $consultas = Consulta::join('paciente', 'paciente.id', '=', 'consulta.paciente_id')
            ->join('medico', 'medico.id', '=', 'consulta.medico_id')
            ->join('especialidade', 'especialidade.id', '=', 'medico.especialidade_id')
            ->leftJoin('users as user_paciente', 'user_paciente.id', '=', 'paciente.user_id')
            ->leftJoin('users as user_medico', 'user_medico.id', '=', 'medico.user_id')
            ->select(\DB::raw(" especialidade.descricao as especialidade, count(*) as consultas, to_char(data_consulta, 'MM') as mes, to_char(data_consulta, 'YYYY') as ano"))
            ->groupBy('mes', 'descricao', 'ano');


        if(validateLogin(['PACIENTE'])){
            $consultas = $consultas->where('user_paciente.id', Auth::user()->id)
                ->select(\DB::raw(" especialidade.descricao as especialidade, count(*) as consultas, to_char(data_consulta, 'MM') as mes, to_char(data_consulta, 'YYYY') as ano"))
                ->groupBy('mes', 'descricao', 'ano');
        }elseif(validateLogin(['MEDICO'])){
            $consultas = $consultas->where('user_medico.id', Auth::user()->id)
                ->select(\DB::raw(" paciente.name as especialidade, count(*) as consultas, to_char(data_consulta, 'MM') as mes, to_char(data_consulta, 'YYYY') as ano"))
                ->groupBy('mes', 'paciente.name', 'ano');
        }

        if(!$anoFilter){
            $consultas = $consultas->whereBetween('consulta.data_consulta', [$dataInicial, $dataFinal]);
        }

        if($anoFilter && $anoFilter != 0){
            $consultas = $consultas->whereRaw("to_char(consulta.data_consulta, 'YYYY') = ? ", $anoFilter);
        }

        $consultas = $consultas->get()->toArray();

        $especialidades = array_unique(array_column($consultas, 'especialidade'));
        $result = [];

        foreach ($especialidades as $especialidade){
            $especInfo = [$especialidade,0,0,0,0,0,0,0,0,0,0,0,0];
            foreach ($consultas as $consulta){
                if ($especialidade == $consulta['especialidade']){
                    $especInfo[intval($consulta['mes'])] = $consulta['consultas'];
                }
            }
            array_push($result,$especInfo);
        }
        return response()->json($result);
    }
}
