<?php

namespace App\Http\Controllers;

use App\Models\Sexo;
use Illuminate\Http\Request;

class SexoController extends Controller
{
    public function index(Request $request){

        $sexos = Sexo::orderBy('descricao')->get();

        return view('pages.sexo.index', compact('sexos'));
    }

    public function create(){
        return view('pages.sexo.form');
    }

    public function store(Request $request){

        $id = $request->input('id');
        $descricao = $request->input('descricao');

        $sexo = Sexo::find($id);

        if(!$sexo){
            $sexo = new Sexo();
        }

        $sexo->fill($request->all());

        $validate = validator($request->all(), $sexo->rules(), $sexo->mensagens);

        if($validate->fails()){
            return response()->json(['success' => false, 'msg'=> validateErros($validate->errors())]);
        }

        $save = $sexo->save();

        if($save){
            return response()->json(['success' => true, 'msg' => 'Especialidade salva com sucesso']);
        }else{
            return response()->json(['success' => true, 'msg' => 'Erro ao salvar a Especialidade']);
        }
    }

    public function edit(Sexo $sexo){
        return view('pages.sexo.form', compact('sexo'));
    }

    public function delete(Request $request){

        try{
            $id = $request->input('id');

            $delete = \DB::table('sexo')->where('id', $id)->delete();

            if ($delete){
                return response()->json(['success' => true, 'msg'=> 'Sexo excluído com sucesso.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir o Sexo.']);
            }

        }catch(\Exception $e){
            if ($e->getCode() == 23503){
                return response()->json(['success' => false, 'msg' => 'Não é permitida à exclusão de Sexo em uso.']);
            }else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir Sexo.']);
            }
        }

    }
}
