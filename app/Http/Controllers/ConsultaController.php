<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Especialidade;
use App\Models\Paciente;
use App\Enum\MesesEnum;
use App\Models\Medico;
use App\Notifications\ConsultaEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Libary\Excel;
use Illuminate\Support\Facades\Mail;


class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        if(validateMasterAccess()) {
            $filtro = $request->input('filtro');

            $consultas = Consulta::filterAdvanced($request)->orderBy('consulta.data_consulta');

            if ($filtro) {
                $consultas = $consultas->where('paciente.name', 'ilike', '%' . $filtro . '%');
            }

            $consultas = $consultas->paginate('10')->setPath('')->appends($request->query());

            $especialidade = arrayToSelect(Especialidade::select('id', 'descricao')->get()->toArray(), 'id', 'descricao');
        }else{
            abort('404');
        }

        return view('pages.consulta.index', compact('consultas', 'especialidade'));
    }

    public function historicoMedico(Request $request)
    {

        $filtro = $request->input('filtro');

        $consultas = Consulta::join('medico', 'medico.id', '=', 'consulta.medico_id')
                              ->join('especialidade', 'especialidade.id', '=', 'medico.especialidade_id')
                              ->join('paciente', 'paciente.id', '=', 'consulta.paciente_id')
                              ->join('users', 'users.id', '=', 'medico.user_id')
                              ->where('users.id', Auth::user()->id)
                              ->select('consulta.*','especialidade.descricao as especialidade',
                                  'medico.name as medico',
                                  'paciente.name as paciente');

        $consultas = $consultas->paginate('10')->setPath('')->appends($request->query());

         if ($filtro){
             $consultas = $consultas->where('paciente.name','ilike', '%'.$filtro.'%');
         }

        return view('pages.consulta.historico-medico', compact('consultas') );
    }


    public function consultasPaciente(Request $request)
    {

        $filtro = $request->input('filtro');

        $consultas = Consulta::filterAdvanced($request);

        if ($filtro){
            $consultas = $consultas->where('medico.name','ilike', '%'.$filtro.'%');
        }

        $consultas = $consultas->paginate('10')->setPath('')->appends($request->query());

        $especialidade = arrayToSelect(Especialidade::select('id', 'descricao')->get()->toArray(), 'id', 'descricao');

        return view('pages.consulta.consulta-logado', compact('consultas', 'especialidade'));
    }

    public function create(){
        $especialidade = arrayToSelect(Especialidade::select('id', 'descricao')->get()->toArray(), 'id', 'descricao');
        $paciente = arrayToSelect(Paciente::select('id', 'name')->get()->toArray(), 'id', 'name');

        return view('pages.consulta.form', compact('medico', 'especialidade', 'paciente'));
    }

    public function store(Request $request){

        $id = $request->input('id');

        $consulta = Consulta::find($id);
        $data = date('Y-m-d');

        if(!$consulta){
            $consulta = new Consulta();
        }

        if(!empty($request['data_consulta'])){
            $request['data_consulta'] = $request->input('data_consulta'). " ".date("H:i", strtotime($request['horario_consulta']));
        }

        if(validateLogin(['PACIENTE'])){
            $paciente = Paciente::where('user_id', Auth::user()->id)->select('id')->first();
            $request['paciente_id'] = $paciente->id;
        }

        $consulta->fill($request->all());

        $validate = validator($request->all(), $consulta->rules(), $consulta->mensagens);

        $existeConsulta = Consulta::where('data_consulta', $request['data_consulta'])->where('medico_id', $request['medico_id'])->first();

        if(isset($existeConsulta)){
            $validate->errors()->add("data_consulta", "Data ja marcada.");

            return response()->json(['success' => false, 'msg'=> validateErros($validate->errors())]);
        }

        if(!empty($consulta->data_consulta) && $consulta->data_consulta < date('Y-m-d')){
            $validate->errors()->add("data_consulta", "Data da Consulta não pode ser menor que a Data Atual.");
        }

        $error_add = $validate->errors()->messages();

        if($validate->fails()){
            return response()->json(['success' => false, 'msg'=> validateErros($validate->errors())]);
        }

        $save = $consulta->save();

        if($save){
            return response()->json(['success' => true, 'msg' => 'Consulta salva com sucesso']);
        }else{
            return response()->json(['success' => true, 'msg' => 'Erro ao salvar a Consulta']);
        }
    }

    public function edit(Consulta $consulta)
    {
        $medico = arrayToSelect(Medico::join('consulta', 'consulta.medico_id', '=', 'medico.id')
                                    ->where('consulta.id', $consulta->id)
                                    ->select('medico.id','medico.name')
                                    ->get()->toArray(), 'id', 'name');

        $especialidade = arrayToSelect(Especialidade::select('id', 'descricao')->get()->toArray(), 'id', 'descricao');
        $paciente = arrayToSelect(Paciente::select('id', 'name')->get()->toArray(), 'id', 'name');

        return view('pages.consulta.form', compact('consulta', 'medico', 'especialidade', 'paciente'));
    }

    public function delete(Request $request){

        try{
            $id = $request->input('id');

            $delete = \DB::table('consulta')->where('id', $id)->delete();

            if ($delete){
                return response()->json(['success' => true, 'msg'=> 'Consulta excluída com sucesso.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir a Consulta.']);
            }

        }catch(\Exception $e){
            if ($e->getCode() == 23503){
                return response()->json(['success' => false, 'msg' => 'Não é permitida à exclusão de Consulta proxima.']);
            }else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir Consulta.']);
            }
        }
    }

    public function getMedico(Request $request)
    {
        $id = $request->input('id');

        $result = Medico::join('especialidade', 'especialidade.id', '=', 'medico.especialidade_id')
                            ->where('especialidade.id', $id)->select('medico.id', 'medico.name')->get();

        if(count($result) > 0){
            return response()->json(['success' => true, 'result' => $result]);
        }else{
            return response()->json(['success' => false, 'result' => $result]);
        }

    }

    public function informativoIndex(Request $request)
    {

        $anos = rangeCustomYear(2000, date('Y'));
        $meses = arrayToSelect(MesesEnum::all(), 'id', 'descricao');

        if(validateMasterAccess()){
            $totalPacientes = Paciente::all()->count();
            $totalMedicos = Medico::all()->count();

            return view('pages.consulta.informativo-atendente', compact('totalPacientes', 'totalMedicos'));
        }

        if(validateLogin(['PACIENTE'])){
            $totalConsultas = Consulta::leftJoin('paciente', 'consulta.paciente_id', '=', 'paciente.id')
                                        ->leftJoin('users', 'users.id', '=', 'paciente.user_id')
                                        ->where('users.id', Auth::user()->id)
                                        ->get();
        }else{
            $totalConsultas = Consulta::leftJoin('medico', 'consulta.medico_id', '=', 'medico.id')
                ->leftJoin('users', 'users.id', '=', 'medico.user_id')
                ->where('users.id', Auth::user()->id)
                ->get();
        }

        $totalConsultas = count($totalConsultas);

        if($totalConsultas < 10){
            $totalConsultas = "0".$totalConsultas;
        }

        return view('pages.consulta.informativo-logado', compact('totalConsultas', 'meses', 'anos'));
    }

    public function informativoAtendente(Request $request)
    {
        $user = Auth::user()->id;

        $totalUsers = Paciente::all();
        $totalMedicos = Medico::all();

        return response()->json($query);
    }

    public function informativo(Request $request)
    {
        $user = Auth::user()->id;

        $query = Consulta::join('medico', 'medico.id', '=', 'consulta.medico_id')
            ->join('paciente', 'paciente.id', '=', 'consulta.paciente_id')
            ->join('especialidade', 'especialidade.id', '=', 'medico.especialidade_id')
            ->leftjoin('users as user_paciente', 'user_paciente.id', '=', 'paciente.user_id')
            ->leftjoin('users as user_medico', 'user_medico.id', '=', 'medico.user_id');

        if(validateLogin(['PACIENTE'])){
            $query = $query->where('user_paciente.id', $user)->select(\DB::raw("count(*) as count"), 'medico.name as user')->groupBy('medico.id')->get()->toArray();
        }else{
            $query = $query->where('user_medico.id', $user)->select(\DB::raw("count(*) as count"), 'paciente.name as user')->groupBy('paciente.id')->get()->toArray();
        }

        return response()->json($query);
    }

    public function getDate(Medico $medico)
    {
        $resulthours = [];

        $datasIndisponiveis = Consulta::join('medico', 'medico.id', '=', 'consulta.medico_id')
                                        ->where('medico.id', $medico->id)
                                        ->select(\DB::raw("to_char(consulta.data_consulta, 'dd-mm-YYYY') as data_consulta"),
                                                 \DB::raw("to_char(consulta.horario_consulta, 'HH24:mm') as horario"))->get();

        $horarios = listaHorarios($medico->horario_inicio, $medico->horario_termino);

        $datas = [];
        $resultDate = [];

        foreach($datasIndisponiveis as $data){
            $dataInDay = $data->data_consulta;
            if(isset($datas[$dataInDay])){
                array_push($datas[$dataInDay], $data->horario);
            }else{
                $datas[$data->data_consulta] = [$data->horario];
            }
            $dataInDay = null;
        }

        foreach($datas as $key => $date){
            if(count($date) == count($horarios)){
                array_push($resultDate, $key);
            }
        }

        $medico = Medico::where('id', $medico->id)->first();


//        foreach ($datasIndisponiveis as $d){
//            array_push($resulthours, $d->horario);
//        }
//

//        $horariosDisponiveis = array_diff($horarios, $resulthours);
//        $resulthours = $horariosDisponiveis;

        return response()->json($resultDate);
    }

    public function getHorario($data, Medico $medico)
    {
        $resulthours = [];

        $medico = Medico::where('id', $medico->id)->first();
        $datasIndisponiveis = Consulta::join('medico', 'medico.id', '=', 'consulta.medico_id')
            ->where('consulta.medico_id', $medico->id)
            ->whereRaw("to_char(consulta.data_consulta, 'dd-mm-YYYY') = ? ", $data)
            ->select( \DB::raw("to_char(consulta.horario_consulta, 'HH24:MM') as horario"))->get();


        foreach ($datasIndisponiveis as $d){
            array_push($resulthours, $d->horario);
        }

        $horarios = listaHorarios($medico->horario_inicio, $medico->horario_termino);

        $horariosDisponiveis = array_diff($horarios, $resulthours);
        $resulthours = array_values($horariosDisponiveis);

        return response()->json($resulthours);
    }

    public function atendimento(Request $request){

        $data = date('d-m-Y');

        $filtro = $request->input('filtro');

        $consultas = Consulta::join('medico', 'medico.id', '=', 'consulta.medico_id')
            ->join('especialidade', 'especialidade.id', '=', 'consulta.especialidade_id')
            ->join('paciente', 'paciente.id', '=', 'consulta.paciente_id')
            ->whereRaw("to_char(consulta.data_consulta, 'dd-mm-YYYY') = ?", $data)
            ->select('consulta.*','especialidade.descricao as especialidade',
                'medico.name as medico',
                'paciente.name as paciente')->orderByRaw('consulta.data_consulta, consulta.horario_consulta');

        if ($filtro){
            $consultas = $consultas->where('paciente.name','ilike', '%'.$filtro.'%');
        }

        $consultas = $consultas->paginate('10')->setPath('')->appends($request->query());

        return view('pages.consulta.atendimento', compact('consultas'));
    }
    public function compareceu(Request $request)
    {
        $user = Paciente::join('users', 'users.id', '=', 'paciente.user_id')->where('paciente.id', $request->input('paciente_id'))->select('users.id', 'paciente.name', 'users.email')->first();
        $consulta = Consulta::find($request->input('id_consulta'));

        if($consulta){
            $consulta->compareceu = true;
            $save = $consulta->save();
        }

        if($save){
            return response()->json(['success' => true, 'msg'=> 'Paciente compareceu! Esperar a vez para chama-lo.']);
        }
    }

    public function sendEmailConsulta(Request $request){

        $user = Paciente::join('users', 'users.id', '=', 'paciente.user_id')->where('paciente.id', $request->input('paciente_id'))->select('users.id', 'paciente.name', 'users.email')->first();
        $consulta = Consulta::find($request->input('id_consulta'));

        $user->notify(new ConsultaEmail($consulta, $user));

        return response()->json(['success' => true, 'msg'=> 'Envio de Mensagem enviado para o Usuario! Consulta finalizada']);
//        $delete = \DB::table('consulta')->where('id', $request->input('id_consulta'))->delete();
//
//        if($delete){
//
//        }

//        if($delete){
//            return response()->json(['success' => true, 'msg'=> 'Envio de Mensagem enviado para o Usuario! Consulta finalizada']);
//        }




//        Mail::send('pages.consulta.send-email-delete',$data , function ($m) use ($user) {
//
//            //de quem está enviando
//            $m->from('thaalesheenrique@gmail.com', 'Thales');
//
//            $m->to('clinicjpad@gmail.com', 'SSS')->subject('Desativacao de Consulta');
//        });
//

    }


    public function exportarExcel(Request $request)
    {
        $modelo = \File::glob(public_path() . '/modelos/modelo.xlsx', GLOB_MARK)[0];
        $consultas = Consulta::filterAdvanced($request)->orderBy("consulta.data_consulta")->get();

        /*
         * Configurações para poder exportar o xlsx
         */

        $configs = [
            "title" => "Lista de Consultas",
            "merge" => 2,
            "columns" => ["A" => "PACIENTE", "B" => "MEDICO", "C" => "ESPECIALIDADE", "D" => "DATA CONSULTA", "E" => "HORÁRIO", "F" => "SINTOMA", "G" => "OBSERVAÇÃO"],
            "filter" => true,
            "width" => 20,
            "height" => 20
        ];

        $document = Excel::export($modelo, $configs);

        if (!$document["success"]) {
            return response()->json(["success" => false, "message" => $document["message"]]);
        }

        $activeSheet = $document["document"]->getActiveSheet(0)->toArray();

        $styleColumns = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
        ];

        $styleColumnsChildrens = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'fill' =>
                [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'color' => ['rgb' => 'c5d9f1'],
                ],
        ];

        if (count($activeSheet) > 0) {
            $line = 3;
            foreach ($consultas as $key => $t) {
                $line += 1;
                $document = $this->buildExcelLine($document, $line, $t, $styleColumns);

            }
        }

        Excel::download($document["document"], "export_consultas");

    }

    private function buildExcelLine($document,$line,$t,$styleColumns){

        $date1 = new \DateTime($t->data_nascimento);
        $date2 = new \DateTime(date('d-m-Y'));
        $interval = $date1->diff($date2);

        $document["document"]->getActiveSheet(0)->setCellValue('A' . $line, $t->paciente);
        $document["document"]->getActiveSheet(0)->setCellValue('B' . $line, $t->medico);
        $document["document"]->getActiveSheet(0)->setCellValue('C' . $line, $t->especialidade);
        $document["document"]->getActiveSheet(0)->setCellValue('D' . $line, dateToView($t->data_consulta));
        $document["document"]->getActiveSheet(0)->setCellValue('E' . $line, $t->horario_consulta);
        $document["document"]->getActiveSheet(0)->setCellValue('F' . $line, $t->sintoma);
        $document["document"]->getActiveSheet(0)->setCellValue('G' . $line, $t->observacao);
        $document["document"]->getActiveSheet(0)->getStyle('A' . $line . ':P' . $line)->applyFromArray($styleColumns);

        return $document;
    }

}
