<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Medico;
use App\Models\Estados;
use App\Models\Role;
use App\User;
use App\Models\Sexo;
use App\Models\TipoSanguineo;
use Libary\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function index(Request $request){
        $permissions = getPermissionsPage();

        $filtro = $request->input('filtro');

        $pacientes = Paciente::filterAdvanced($request)->orderBy('paciente.name', 'ASC');

        if ($filtro){
            $pacientes = $pacientes->where('paciente.name','ilike', '%'.$filtro.'%');
        }

        $pacientes = $pacientes->paginate('10')->setPath('')->appends($request->query());

        return view('pages.paciente.index', compact('pacientes'));
    }

    public function create(){

        $sexo = arrayToSelect(Sexo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $tipoSanguineo = arrayToSelect(TipoSanguineo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $estados = arrayToSelect(Estados::select('id','estado')->get()->toArray(), 'id', 'estado');

        return view('pages.paciente.form', compact('sexo', 'especialidade', 'estados','tipoSanguineo'));
    }

    public function store(Request $request)
    {
        $id = $request->input('id');
        $password = $request->input('password');
        $emailUser = $request->input('email');
        $nameUser = $request->input('name');
        $userId = $request->input('user_id');

        $numero_paciente = $request->input('numero_paciente');

        $paciente = Paciente::find($id);

        if(!$paciente){
            $paciente = new Paciente();
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

        $paciente->fill($request->all());

        $validate  = validator($request->all(), $paciente->rules(), $paciente->mensages);
        $validate  = $paciente->validatePaciente($request, $validate);
        $error_add = $validate->errors()->messages();

        if($validate->fails() || sizeof($error_add) > 0){
            return redirect()->back()->with(['type' => 'ERROR', 'error' => $error_add])->withInput();
        }

        if($paciente->existePaciente($request, $id)){
            return redirect()->back()->with(['type' => 'ERROR', 'error' => 'Numero do Paciente já cadastrado no Sistema'])->withInput();
//            return response()->json(['success' => false, 'msg'=> ['numero_paciente' => 'Numero do Paciente já cadastrado no sistema.']]);
        }

        if(urlEspecificBack('profile')){
            $user = User::find($userId);

            $user->fill($request->all());
        }else{
            //CRIAR USUARIO//
            $user = User::where('email', $paciente->email)->first();

            if(!$user){
                $user = new User();

                $user->name = $nameUser;
                $user->email = $emailUser;
                $user->password = bcrypt($password);
            }
        }

        //verificar se existe imagem
        if($request->hasFile('image-banner') && $request->file('image-banner')->isValid()){
            if($user->image)
                $name = $user->image;
            else
                $name = $user->id.kebab_case($user->name);

            $extension = $request->file('image-banner')->extension();

            $nameFile = "{$name}.{$extension}";

            $data['image-banner'] = $nameFile;

            $upload = $request->file('image-banner')->storeAs('users', $nameFile);

            if(!$upload){
                return redirect()->back()->with('error', 'Falha ao realizar upload');
            }
            $user->image = $nameFile;
        }

        $user->save();
        $paciente->user_id = $user->id;
        $save = $paciente->save();

        $save = $paciente->save();

        if($save && urlEspecificBack('profile')){
            return redirect()->action('UsuarioController@profile')->with(['message' => 'Perfil Atualizado com sucesso.', 'type' => 'SUCCESS']);
        }

        if($save){

            $roleUser = Role::createRolePaciente($user->id);

            if($roleUser){
                return redirect()->action('PacienteController@index')->with(['message' => 'Paciente cadastrado com sucesso.', 'type' => 'SUCCESS']);
            }
        }else{
            return redirect()->back()->with('Erro ao salvar o Paciente');
        }

    }

    public function storeUserPaciente(Request $request){
        $id = $request->input('id');
        $password = $request->input('password');
        $emailUser = $request->input('email');
        $nameUser = $request->input('name');

        $numero_paciente = $request->input('numero_paciente');

        $paciente = Paciente::find($id);

        if(!$paciente){
            $paciente = new Paciente();
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

        $paciente->fill($request->all());

        $validate  = validator($request->all(), $paciente->rules(), $paciente->mensages);
        $validate  = $paciente->validatePaciente($request, $validate);
        $error_add = $validate->errors()->messages();

        if($validate->fails() || sizeof($error_add) > 0){
            return redirect()->back()->with(['type' => 'ERROR', 'error' => $error_add])->withInput();
        }

        if($paciente->existePaciente($request, $id)){
            return redirect()->back()->with(['type' => 'ERROR', 'error' => 'Numero do Paciente já cadastrado no Sistema'])->withInput();
//            return response()->json(['success' => false, 'msg'=> ['numero_paciente' => 'Numero do Paciente já cadastrado no sistema.']]);
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
        if($request->hasFile('image-banner') && $request->file('image-banner')->isValid()){
            if($user->image)
                $name = $user->image;
            else
                $name = $user->id.kebab_case($user->name);

            $extension = $request->file('image-banner')->extension();

            $nameFile = "{$name}.{$extension}";

            $data['image-banner'] = $nameFile;

            $upload = $request->file('image-banner')->storeAs('users', $nameFile);

            if(!$upload){
                return redirect()->back()->with('error', 'Falha ao realizar upload');
            }
            $user->image = $nameFile;
        }

        $user->save();
        $paciente->user_id = $user->id;
        $save = $paciente->save();

        $save = $paciente->save();

        if($save){

            $roleUser = Role::createRolePaciente($user->id);

            if($roleUser){
                return redirect()->route('login')->with(['message' => 'Cadastro realizado com sucesso.', 'type' => 'SUCCESS']);
            }
        }else{
            return redirect()->back()->with('Erro ao salvar o Paciente');
        }
    }

    public function historicoPaciente(Request $request){

        $consultas = Consulta::join('medico', 'medico.id', '=', 'consulta.medico_id')
            ->join('especialidade', 'especialidade.id', '=', 'consulta.especialidade_id')
            ->join('paciente', 'paciente.id', '=', 'consulta.paciente_id')
            ->join('users', 'users.id', '=', 'paciente.user_id')
            ->where('users.id', Auth::user()->id)
            ->select('consulta.*','especialidade.descricao as especialidade',
                'medico.name as medico',
                'paciente.name as paciente')->get();



        return view('pages.paciente.historico', compact('consultas'));
    }

    public function edit(Paciente $paciente){

        $sexo = arrayToSelect(Sexo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $user = User::where('id', $paciente->user_id)->first();
        $tipoSanguineo = arrayToSelect(TipoSanguineo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $estados = arrayToSelect(Estados::select('id','estado')->get()->toArray(), 'id', 'estado');

        return view('pages.paciente.form', compact('paciente', 'estados', 'tipoSanguineo', 'sexo', 'user'));
    }

    public function show($id){
        $paciente = Paciente::join('tipo_sanguineo', 'tipo_sanguineo.id', '=', 'paciente.tipo_sanguineo_id')
                              ->join('sexo', 'sexo.id', '=', 'paciente.sexo_id')
                              ->join('uf_estado', 'uf_estado.id', '=', 'paciente.uf_id')
                              ->where('paciente.id', $id)
                              ->select(
                                  'paciente.*',
                                  'sexo.descricao As sexo',
                                  'uf_estado.estado As estado',
                                  'tipo_sanguineo.descricao as tipo_sanguineo'
                              )->first();

        return view('pages.paciente.show', compact('paciente'));
    }

    public function delete(Request $request){
        try{
            $id = $request->input('id');

            $delete = \DB::table('paciente')->where('id', $id)->delete();

            if ($delete){
                return response()->json(['success' => true, 'msg'=> 'Paciente excluído com sucesso.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir o Paciente.']);
            }

        }catch(\Exception $e){
            if ($e->getCode() == 23503){
                return response()->json(['success' => false, 'msg' => 'Não é permitida à exclusão de Paciente em uso.']);
            }else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir Paciente.']);
            }
        }

    }

    public function storeImage($request, $file, $nameOriginal)
    {

        if($request->hasFile($file))
        {
            $folderConfig = public_path() . '/storage/imagens/configuracao';

            $nameExist = \File::glob(public_path().'/storage/imagens/configuracao/'.$nameOriginal.'_*', GLOB_MARK);

            if($nameExist) {
                \File::delete($nameExist);
            }

            $files = $request->file($file);

            if(!\Storage::directories($folderConfig))
            {
                \Storage::makeDirectory('public/imagens/configuracao');
            }


            saveImages($nameOriginal, $files, $folderConfig);

        }
    }

    public function cadastrarPaciente(){

        $sexo = arrayToSelect(Sexo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $tipoSanguineo = arrayToSelect(TipoSanguineo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $estados = arrayToSelect(Estados::select('id','estado')->get()->toArray(), 'id', 'estado');

        return view('pages.paciente.form-create-user', compact('sexo', 'tipoSanguineo', 'estados'));
    }

    public function exportarExcel(Request $request)
    {
        $modelo = \File::glob(public_path() . '/modelos/modelo.xlsx', GLOB_MARK)[0];
        $paciente = Paciente::filterAdvanced($request)->orderBy("paciente.name", "ASC")->get();

        /*
         * Configurações para poder exportar o xlsx
         */

        $configs = [
            "title" => "Lista de Pacientes",
            "merge" => 2,
            "columns" => ["A" => "NUMERO PACIENTE", "B" => "NOME", "C" => "TIPO SANGUÍNEO", "D" => "EMAIL", "E" => "DATA NASCIMENTO", "F" => "ENDEREÇO", "G" => "BAIRRO", "H" => "CIDADE", "I" => "ESTADO", "J" => "TELEFONE", "K" => "CELULAR", "L" => "NACIONALIDADE", "M" => "DATA CADASTRO", "N" => 'NOME DA MAE', "O" => "NOME DO PAI"],
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
            foreach ($paciente as $key => $t) {
                $line += 1;
                $document = $this->buildExcelLine($document, $line, $t, $styleColumns);

            }
        }

        Excel::download($document["document"], "export_pacientes");

    }

    private function buildExcelLine($document,$line,$t,$styleColumns){

        $date1 = new \DateTime($t->data_nascimento);
        $date2 = new \DateTime(date('d-m-Y'));
        $interval = $date1->diff($date2);

        $document["document"]->getActiveSheet(0)->setCellValue('A' . $line, $t->numero_paciente);
        $document["document"]->getActiveSheet(0)->setCellValue('B' . $line, $t->name);
        $document["document"]->getActiveSheet(0)->setCellValue('C' . $line, $t->tipo_sanguineo);
        $document["document"]->getActiveSheet(0)->setCellValue('D' . $line, $t->email);
        $document["document"]->getActiveSheet(0)->setCellValue('E' . $line, dateToView($t->data_nascimento));
        $document["document"]->getActiveSheet(0)->setCellValue('F' . $line, $t->endereco);
        $document["document"]->getActiveSheet(0)->setCellValue('G' . $line, $t->bairro);
        $document["document"]->getActiveSheet(0)->setCellValue('H' . $line, $t->cidade);
        $document["document"]->getActiveSheet(0)->setCellValue('I' . $line, $t->estado);
        $document["document"]->getActiveSheet(0)->setCellValue('J' . $line, $t->telefone);
        $document["document"]->getActiveSheet(0)->setCellValue('K' . $line, $t->celular);
        $document["document"]->getActiveSheet(0)->setCellValue('L' . $line, $t->nacionalidade );
        $document["document"]->getActiveSheet(0)->setCellValue('M' . $line, $t->created_at);
        $document["document"]->getActiveSheet(0)->setCellValue('N' . $line, $t->nome_mae);
        $document["document"]->getActiveSheet(0)->setCellValue('O' . $line, $t->nome_pai);
        $document["document"]->getActiveSheet(0)->getStyle('A' . $line . ':P' . $line)->applyFromArray($styleColumns);

        return $document;
    }
}
