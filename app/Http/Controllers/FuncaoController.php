<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\PermissionRole;
use App\Models\Role;
use Illuminate\Http\Request;

class FuncaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(validateRoles(['ADMINISTRADOR', 'GERENTE'])) {
            $filtro = $request->input('filtro');
//            $funcoes = Role::where('name', '<>', 'ADMINISTRADOR')->where('name', '<>', 'GERENTE')->orderBy('name', 'ASC');
            $funcoes = Role::orderBy('name', 'ASC');

            if ($filtro) {
                $funcoes->where("name", "ilike", "%$filtro%")
                    ->orWhere("description", "ilike", "%$filtro%");
            }

            $funcoes = $funcoes->paginate('10')->setPath('')->appends($request->query());

            return view('pages.funcao.index', compact('funcoes'));
        }else{
            return view('errors.401');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(validateRoles(['ADMINISTRADOR', 'GERENTE'])) {
            $permissoes = arrayToSelect(Permission::orderBy('description', 'ASC')->get()->toArray(), 'id', 'description');
            return view('pages.funcao.form', compact('permissoes'));
        }else{
            return view('errors.401');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $result = \DB::transaction(function () use ($request){
            try{
                if(validateRoles(['ADMINISTRADOR', 'GERENTE'])) {
                    $id = $request->input('id');

                    $request['name'] = mb_strtoupper(mb_strtolower($request->input('name')));

                    $funcao = Role::find($id);

                    if(!$funcao)
                    {
                        $funcao = new Role();
                    }

                    $funcao->fill($request->all());

                    $validate = validator($request->all(), $funcao->rules(), $funcao->mensages);

                    if($validate->fails())
                    {
                        return response()->json(['success' => false, 'msg' => validateErros($validate->errors())]);
                    }

                    $funcoes = Role::orderBy('id')->get()->toArray();



                    $permissoes = json_decode($request->input('permissoes'));

                    $salvarPermissao = false;

                    if($permissoes != null){
                        foreach ($permissoes as $permissao) {
                            if($permissao->deletar == false){
                                $salvarPermissao = true;
                            }
                        }
                    }

                    if($salvarPermissao == false)
                    {
                        return response()->json(['success' => false, 'msg' => ['pemissao' => 'Nenhuma permissão foi adicionado a lista.']]);
                    }

                    $save = $funcao->save();

                    if($save)
                    {
                        if($salvarPermissao)
                        {
                            foreach($permissoes as $permissao)
                            {
                                if($permissao->id != "")
                                {
                                    \DB::table('permission_role')->where('id', $permissao->id)->delete();
                                }
                                if($permissao->id === 0 && !$permissao->deletar || $permissao->id != "" && !$permissao->deletar) {

                                    \DB::table('permission_role')->insert(
                                        ['permission_id' => $permissao->permissao, 'role_id' => $funcao->id , 'created_at' => date('Y-m-d H:i:s')]
                                    );
                                }
                            }
                        }

                        return response()->json(['success' => true, 'msg' => 'Função salva com sucesso!']);
                    }
                    else{
                        return response()->json(['success' => false, 'msg' => 'Erro ao salvar Função!']);
                    }
                }else{
                    return view('errors.401');
                }
            }catch(\Exception $exc)
            {
                return response()->json(['success' => false, 'msg' => 'Erro ao salvar Função. '.$exc->getMessage()]);
            }
        });

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $funcao)
    {
        if(validateRoles(['ADMINISTRADOR', 'GERENTE'])) {
            $permissoes = arrayToSelect(Permission::orderBy('description', 'ASC')->get()->toArray(), 'id', 'description');

            return view('pages.funcao.form', compact('permissoes', 'funcao'));
        }else{
            return view('errors.401');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try{
            $result = \DB::transaction(function () use ($request) {

                if(validateRoles(['ADMINISTRADOR', 'GERENTE'])) {
                    $id = $request->input('id');
                    if($id)
                    {
                        \DB::table('permission_role')->where('role_id', $id)->delete();
                        \DB::table('users_regional_role')->where('role_id', $id)->delete();
                        \DB::table('roles')->where('id', $id)->delete();

                        return response()->json(['success' => true, 'msg' => 'Função excluída com sucesso.' ]);
                    }else{
                        return response()->json(['success' => false, 'msg' => 'Código da Função inválida.' ]);
                    }
                }else{
                    return view('errors.401');
                }
            });

            return $result;
        } catch(\Exception $exc) {
            return response()->json(['success' => false, 'msg' => 'Erro ao excluír Função.' ]);
        }
    }

    public function getPermissoes($funcao)
    {
        return \DB::table('permission_role')
            ->join('permissions', 'permission_role.permission_id', '=', 'permissions.id')
            ->select('permission_role.id', 'permission_role.permission_id', 'permissions.description')
            ->where('permission_role.role_id', $funcao)
            ->get();
    }
}
