<?php

namespace App\Http\Controllers;

use App\Models\TipoSanguineo;
use Illuminate\Http\Request;

class TipoSanguineoController extends Controller
{
    public function index(Request $request){

        $tipoSanguineo = TipoSanguineo::orderBy('descricao')->get();

        return view('pages.tipo_sanguineo.index', compact('tipoSanguineo'));
    }

    public function create(){
        return view('pages.tipo_sanguineo.form');
    }

    public function store(Request $request){

        $id = $request->input('id');
        $descricao = $request->input('descricao');

        $tipoSanguineo = TipoSanguineo::find($id);

        if(!$tipoSanguineo){
            $tipoSanguineo = new TipoSanguineo();
        }

        $request['descricao'] = strtoupper($request['descricao']);

        $tipoSanguineo->fill($request->all());

        $validate = validator($request->all(), $tipoSanguineo->rules(), $tipoSanguineo->mensagens);

        if($validate->fails()){
            return response()->json(['success' => false, 'msg'=> validateErros($validate->errors())]);
        }

        $save = $tipoSanguineo->save();

        if($save){
            return response()->json(['success' => true, 'msg' => 'Tipo Sanguíneo salvo com sucesso']);
        }else{
            return response()->json(['success' => true, 'msg' => 'Erro ao salvar o Tipo Sanguíneo']);
        }
    }

    public function edit(TipoSanguineo $tipoSanguineo){
        return view('pages.tipo_sanguineo.form', compact('tipoSanguineo'));
    }

    public function delete(Request $request){

        try{
            $id = $request->input('id');

            $delete = \DB::table('tipo_sanguineo')->where('id', $id)->delete();

            if ($delete){
                return response()->json(['success' => true, 'msg'=> 'Tipo Sanguíneo excluído com sucesso.']);
            } else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir o Tipo Sanguíneo.']);
            }

        }catch(\Exception $e){
            if ($e->getCode() == 23503){
                return response()->json(['success' => false, 'msg' => 'Não é permitida à exclusão de Tipo Sanguíneo em uso.']);
            }else {
                return response()->json(['success' => false, 'msg' => 'Erro ao excluir Tipo Sanguíneo.']);
            }
        }

    }
}
