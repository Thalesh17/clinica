<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
{
    public function index(){

        $especialidades = Especialidade::orderBy('descricao')->get();

        return view('pages.especialidade.index', compact('especialidades'));
    }

    public function create(){
        return view('pages.especialidade.form');
    }

    public function store(Request $request){

        $id = $request->input('id');
        $descricao = $request->input('descricao');

        $especialidade = Especialidade::find($id);

        if(!$especialidade){
            $especialidade = new Especialidade();
        }

        $especialidade->fill($request->all());

        $validate = validator($request->all(), $especialidade->rules(), $especialidade->mensagens);

        if($validate->fails()){
            return response()->json(['success' => false, 'msg'=> validateErros($validate->errors())]);
        }

        $save = $especialidade->save();

        if($save){
            return response()->json(['success' => true, 'msg' => 'Especialidade salva com sucesso']);
        }else{
            return response()->json(['success' => true, 'msg' => 'Erro ao salvar a Especialidade']);
        }
    }

    public function edit(Especialidade $especialidade){
        return view('pages.especialidade.form', compact('especialidade'));
    }

    public function delete(Request $request){

        try{
            $id = $request->input('id');

            $delete = \DB::table('especialidade')->where('id', $id)->delete();

            if ($delete){
                return response()->json(['success' => true, 'msg'=> 'Especialidade excluída com sucesso.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir a Especialidade.']);
            }

        }catch(\Exception $e){
            if ($e->getCode() == 23503){
                return response()->json(['success' => false, 'msg' => 'Não é permitida à exclusão de Especialidade em uso.']);
            }else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir Especialidade.']);
            }
        }
    }
}
