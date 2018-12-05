<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\EspecialidadeMedico;
use App\Models\Medico;
use App\Models\Consulta;
use App\Models\Role;
use App\Models\Sexo;
use App\User;
use Libary\Excel;
use App\Models\TipoSanguineo;
use App\Models\Estados;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class MedicoController extends Controller
{
    public function index(Request $request)
    {
        $filtro  = $request->input('filtro');

        $medicos = Medico::filterAdvanced($request)->orderBy('medico.name', 'ASC');

        if ($filtro){
            $medicos = $medicos->where('medico.name','ilike', '%'.$filtro.'%');
        }

        $medicos = $medicos->paginate('10')->setPath('')->appends($request->query());

        return view('pages.medico.index', compact('medicos'));
    }

    public function showCalendario(){
        return view('pages.calendario.calendario-medico');
    }

    public function getCalendario(){
        $events = Consulta::join('medico', 'medico.id', 'consulta.medico_id')
                    ->join('paciente', 'paciente.id', '=', 'consulta.paciente_id')
                    ->join('users', 'users.id', '=', 'medico.user_id')
                    ->where('users.id', \Auth::user()->id)->select('paciente.name as title', 'consulta.data_consulta as start')->get()->toArray();

        return response()->json($events);
    }

    public function create()
    {
        $sexo = arrayToSelect(Sexo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $especialidade = arrayToSelect(Especialidade::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $tipoSanguineo = arrayToSelect(TipoSanguineo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $estados = arrayToSelect(Estados::select('id','estado')->get()->toArray(), 'id', 'estado');

        return view('pages.medico.form', compact('sexo', 'especialidade', 'estados','tipoSanguineo'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');

        $nameUser  = $request->input('name');
        $emailUser = $request->input('email');
        $password  = $request->input('password');
        $image     = $request->file('image-perfil');

        $data      = $request->all();

        $medico = Medico::find($id);

        if(!$medico){
            $medico = new Medico();
        }

        if($request->input('cpf')){
            $request->merge(['cpf' => preg_replace("/[^0-9]/", "", $request->input('cpf'))]);
        }

        if($request->input('telefone')){
            $request->merge(['telefone' => preg_replace("/[^0-9]/", "", $request->input('telefone'))]);
        }

        if($request->input('celular')){
            $request->merge(['celular' => preg_replace("/[^0-9]/", "", $request->input('celular'))]);
        }

        $medico->fill($request->all());

        $validate = validator($request->all(), $medico->rules(), $medico->mensages);
        $validate  = $medico->validateMedico($request, $validate);

        $error_add = $validate->errors()->messages();

        if($validate->fails() || sizeof($error_add) > 0){
            return redirect()->back()->with(['type' => 'ERROR', 'error' => $error_add])->withInput();
        }

        //CRIAR USUARIO//
        $user = User::where('email', $emailUser)->first();

        if(!$user){
            $user = new User();

            $user->name = $nameUser;
            $user->email = $emailUser;
            $user->password = bcrypt($password);
        }

        //verificar se existe imagem
        if($request->hasFile('image-perfil') && $request->file('image-perfil')->isValid()){
            if($user->image)
                $name = $user->image;
            else
                $name = $user->id.kebab_case($user->name);

            $extension = $request->file('image-perfil')->extension();

            $nameFile = "{$name}.{$extension}";

            $data['image-perfil'] = $nameFile;

            $upload = $request->file('image-perfil')->storeAs('users', $nameFile);

            if(!$upload){
                return redirect()->back()->with('error', 'Falha ao realizar upload');
            }
        $user->image = $nameFile;
        }
        $user->save();

        $medico->user_id = $user->id;
        $save = $medico->save();

        if($save && urlEspecificBack('profile')){
            return redirect()->action('UsuarioController@profile')->with(['message' => 'Perfil Atualizado com sucesso.', 'type' => 'SUCCESS']);
        }

        if($save){

            $roleUser = Role::createRoleMedico($user->id);
            if($roleUser) {
                return redirect()->action('MedicoController@index')->with(['message' => 'Médico cadastrado com sucesso.', 'type' => 'SUCCESS']);
            }
        }
        else{
            return redirect()->back()->with(['type' => 'ERROR', 'error' => 'Erro Ao salvar O medico'])->withInput();
        }

    }

    public function edit(Medico $medico){

        $user = User::where('id', $medico->user_id)->first();
        $sexo = arrayToSelect(Sexo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $tipoSanguineo = arrayToSelect(TipoSanguineo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $estados = arrayToSelect(Estados::select('id','estado')->get()->toArray(), 'id', 'estado');
        $especialidade = arrayToSelect(Especialidade::select('id','descricao')->get()->toArray(), 'id', 'descricao');

        $folderConfig = public_path() . '/storage/imagens/configuracao/';

        if(!\Storage::directories($folderConfig))
        {
            \Storage::makeDirectory('public/imagens/configuracao/');
        }

        $perfil = \File::glob(public_path().'/storage/imagens/users/'.$medico->id.'/'.'users');
        $perfil = ($perfil != null) ? 'storage/imagens/configuracao/'.basename($perfil[0]) : null;

        return view('pages.medico.form', compact('medico', 'estados', 'tipoSanguineo', 'sexo', 'user','perfil', 'especialidade'));
    }

    public function show($id){
        $medico = Medico::join('tipo_sanguineo', 'tipo_sanguineo.id', '=', 'medico.tipo_sanguineo_id')
            ->join('sexo', 'sexo.id', '=', 'medico.sexo_id')
            ->join('especialidade', 'especialidade.id', '=', 'medico.especialidade_id')
            ->join('uf_estado', 'uf_estado.id', '=', 'medico.uf_id')
            ->where('medico.id', $id)
            ->select(
                'medico.*',
                'sexo.descricao As sexo',
                'uf_estado.estado As estado',
                'especialidade.descricao AS especialidade',
                'tipo_sanguineo.descricao as tipo_sanguineo'
            )->first();


        $user = User::where('id', $medico->user_id)->first();

        return view('pages.medico.show', compact('medico', 'user'));
    }

    public function delete(Request $request){
        try{
            $id = $request->input('id');

            $delete = \DB::table('medico')->where('id', $id)->delete();

            if ($delete){
                return response()->json(['success' => true, 'msg'=> 'Médico excluído com sucesso.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir o Médico.']);
            }

        }catch(\Exception $e){
            if ($e->getCode() == 23503){
                return response()->json(['success' => false, 'msg' => 'Não é permitida à exclusão de Médico em uso.']);
            }else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir Médico.']);
            }
        }

    }

    public function saveImage($request,$image, $id, $type, $size, $nameOriginal, $file)
    {

        if(!is_null($image))
        {

            $destinationPath = public_path('images/'.$type.'/'.$id.'/'.$nameOriginal);

            if($destinationPath) {
                \File::delete($destinationPath);
            }

            $files = $request->file($file);

            if(!\Storage::directories($destinationPath))
            {
                \Storage::makeDirectory('public/images/'.$type.'/'.$id);
            }


            saveImage($nameOriginal, $files, $destinationPath);

        }
    }

    public function exportarExcel(Request $request)
    {
        $modelo = \File::glob(public_path() . '/modelos/modelo.xlsx', GLOB_MARK)[0];
        $medico = Medico::filterAdvanced($request)->orderBy("medico.name", "ASC")->get();

        /*
         * Configurações para poder exportar o xlsx
         */

        $configs = [
            "title" => "Lista de Médicos",
            "merge" => 2,
            "columns" => ["A" => "CRM", "B" => "NOME", "C" => "ESPECIALIDADE", "D" => "HORARIO INICIO", "E" => "HORARIO TERMINO", "F" => "TIPO SANGUINEO", "G" => "DATA NASCIMENTO", "H" => "ENDERECO", "I" => "BAIRRO", "J" => "CIDADE", "K" => "ESTADO", "L" => "TELEFONE", "M" => "CELULAR", "N" => 'SEXO', "O" => 'DATA CADASTRO'],
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
            foreach ($medico as $key => $t) {
                $line += 1;
                $document = $this->buildExcelLine($document, $line, $t, $styleColumns);

            }
        }

        Excel::download($document["document"], "export_medicos");

    }

    private function buildExcelLine($document,$line,$t,$styleColumns){

        $date1 = new \DateTime($t->data_nascimento);
        $date2 = new \DateTime(date('d-m-Y'));
        $interval = $date1->diff($date2);

        $document["document"]->getActiveSheet(0)->setCellValue('A' . $line, $t->crm);
        $document["document"]->getActiveSheet(0)->setCellValue('B' . $line, $t->name);
        $document["document"]->getActiveSheet(0)->setCellValue('C' . $line, $t->especialidade);
        $document["document"]->getActiveSheet(0)->setCellValue('D' . $line, $t->horario_inicio);
        $document["document"]->getActiveSheet(0)->setCellValue('E' . $line, $t->horario_termino);
        $document["document"]->getActiveSheet(0)->setCellValue('F' . $line, $t->tipo_sanguineo);
        $document["document"]->getActiveSheet(0)->setCellValue('G' . $line, dateToView($t->data_nascimento));
        $document["document"]->getActiveSheet(0)->setCellValue('H' . $line, $t->endereco);
        $document["document"]->getActiveSheet(0)->setCellValue('I' . $line, $t->bairro);
        $document["document"]->getActiveSheet(0)->setCellValue('J' . $line, $t->cidade);
        $document["document"]->getActiveSheet(0)->setCellValue('K' . $line, $t->estado);
        $document["document"]->getActiveSheet(0)->setCellValue('L' . $line, $t->telefone );
        $document["document"]->getActiveSheet(0)->setCellValue('M' . $line, $t->celular);
        $document["document"]->getActiveSheet(0)->setCellValue('N' . $line, $t->sexo);
        $document["document"]->getActiveSheet(0)->setCellValue('O' . $line, dateToView($t->created_at));
        $document["document"]->getActiveSheet(0)->getStyle('A' . $line . ':P' . $line)->applyFromArray($styleColumns);

        return $document;
    }
}
