<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\TipoSanguineo;
use App\Models\Especialidade;
use App\Models\Sexo;
use App\Models\Estados;
use App\Models\Paciente;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $filter = $request->input('filter');
        $usuarios = User::orderBy('name');

        if($filter)
        {
            $usuarios->where("name", "ilike", "%$filter%")
                ->orWhere("email", "ilike", "%$filter%");
        }

        $usuarios = $usuarios->paginate(10)->appends('filter', request('filter'));

        return view('pages.usuario.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $funcoes = arrayToSelect(Role::select('id', 'description')->get()->toArray(), 'id', 'description');

        return view('pages.usuario.form', compact('funcoes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $result = \DB::transaction(function () use ($request) {


                $id = $request->input('id');

                $password = trim($request->input('password'));
                $repeat_password = $request->input('repeat-password');

                $usuario = User::where('id', $id)->first();

                if (!$usuario){
                    $usuario = new User();
                }

                $usuario->fill($request->all());

                $validate = validator($request->all(), $usuario->rules(), $usuario->mensages);

                if($validate->fails())
                {
                    return response()->json(['success' => false, 'msg' => arrayToValidator($validate->errors())]);
                }

                if(empty($id)){

                    if (empty($password)) {
                        return response()->json(['success' => false, 'msg'=> 'A senha é Obrigatória.']);
                    } elseif ($password === $repeat_password) {
                        $usuario->password = bcrypt($password);
                    } else {
                        return response()->json(['success' => false, 'msg'=> 'A confirmação da senha não corresponde.']);
                    }

                } elseif($password != null) {

                    if ($password === $repeat_password) {
                        $usuario->password = bcrypt($password);
                    } else {
                        return response()->json(['success' => false, 'msg'=> 'A confirmação da senha não corresponde.']);
                    }

                }

                $save = $usuario->save();

                if($save) {

                    $funcoes = $request->input('funcoes');

                    if($funcoes)
                    {
                        $funcoes = json_decode($funcoes);
                        foreach($funcoes as $funcao)
                        {
                            if($funcao->deletar == 'true' && $funcao->id > 0)
                            {
                                \DB::table('role_user')->where('id', $funcao->funcao)->where('user_id', $usuario->id)->delete();
                            }
                            if($funcao->id == 0) {
                                $userRole = new RoleUser();
                                $userRole->role_id = $funcao->funcao;
                                $userRole->user_id = $usuario->id;
                                $userRole->save();
                            }
                        }
                    }

                    return response()->json(['success' => true, 'msg' => 'Usuário salvo com sucesso.']);
                }else{
                    return response()->json(['success' => false, 'msg' => 'Erro ao salvar Usuário.']);
                }

            });

            return $result;
        }catch(\Exception $exc){
            return response()->json(['success' => false, 'msg' => 'Erro ao salvar Usuário.']);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $usuario)
    {
        $funcoes = arrayToSelect(Role::select('id', 'description')->get()->toArray(), 'id', 'description');

        return view('pages.usuario.form', compact('funcoes', 'usuario'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');

        \DB::table('role_user')->where('id', $id)->delete();

        $delete = \DB::table('users')->where('id', $id)->delete();

        if($delete)
        {
            return response()->json(['success' => true, 'msg'=> 'Usuário excluído com sucesso.']);
        } else {
            return response()->json(['success' => false, 'msg' => 'Erro ao excluir Usuário.']);
        }
    }

    public function getFuncoes($user)
    {
        return \DB::table('role_user')
            ->join('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('role_user.id', 'role_user.id', 'roles.description')
            ->where('role_user.user_id', $user)
            ->get();
    }

    public function profile(Request $request){
        $user = $request->user();
        $sexo = arrayToSelect(Sexo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $tipoSanguineo = arrayToSelect(TipoSanguineo::select('id','descricao')->get()->toArray(), 'id', 'descricao');
        $estados = arrayToSelect(Estados::select('id','estado')->get()->toArray(), 'id', 'estado');


        if(validateLogin(['PACIENTE'])){
            $paciente = Paciente::where('user_id', $user->id)->first();

            return view('pages.usuario.profile', compact('user','sexo', 'tipoSanguineo', 'estados', 'paciente'));
        }else{
            $medico = Medico::where('user_id', $user->id)->first();
            $especialidade = arrayToSelect(Especialidade::select('id','descricao')->get()->toArray(), 'id', 'descricao');

            return view('pages.usuario.profile-medico', compact('user','sexo', 'tipoSanguineo', 'estados', 'medico', 'especialidade'));
        }
    }

    public function changeProfile(Request $request){
        $usuario = $request->user();
        $newName = $request->input('nome');
        $newPassword = $request->input('nova-senha');
        $repeatNewPassrword = $request->input('repetir-senha');

        if($newName == $usuario->name && $newPassword == null && $repeatNewPassrword == null){
            return response()->json(['success' => false, 'msg'=> 'Nenhuma informação atualizada']);
        }

        if($newName != null && $newName != $usuario->name){
            $usuario->name = $newName;
        }

        if($newPassword != null){
            if($newPassword === $repeatNewPassrword){
                $usuario->password = bcrypt($newPassword);
                $usuario->password_mobile = hash('sha1', $newPassword);
            }else{
                return response()->json(['success' => false, 'msg'=> 'Atenção, as senhas divergem. Tente Novamente']);
            }
        }
        $save = $usuario->save();
        if($save){
            return response()->json(['success' => true, 'msg'=> 'Informações Atualizadas com Sucesso']);
        }else{
            return response()->json(['success' => false, 'msg'=> 'Ocorreu uma falha ao atualizar as informações']);
        }
    }
}
