<?php

namespace App;

use App\Models\Permission;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Uuid;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'image'/*, 'password'*/
    ];

    public function roles()
    {
        return $this->belongsToMany('\App\Models\Role::class');
    }

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function friendsOfMine() {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }

    public function friendsOf() {
        return $this->belongsToMany('App\User', 'friends', 'friend_id', 'user_id');
    }

    public function friends() {
        return $this->friendsOfMine->merge($this->friendsOf);
    }

    public function authorizePermissionView($permission)
    {
        if ($this->hasPermissions('ADMIN') || $this->hasPermissions('DIRETOR') || $this->hasPermissions('GERENTE')) {
            return true;
        }

        if ($this->hasAnyPermissions($permission)) {
            return true;
        }
    }

    //Validar por permissão
    public function authorizePermission($permission)
    {
        if( $this->hasPermissions('ADM'))
        {
            return true;
        }

        if($this->hasAnyPermissions($permission))
        {
            return true;
        }

        abort(401, 'Ação não autorizada.');

    }

    public function hasAnyPermissions($permissions)
    {
        if(is_array($permissions))
        {
            foreach ($permissions as $permission)
            {
                if($this->hasPermissions($permission))
                {
                    return true;
                }
            }
        }elseif (is_object($permissions)){
            foreach ($permissions as $permission)
            {
                if($this->hasPermissions($permission->name))
                {
                    return true;
                }
            }
        } else{
            if($this->hasPermissions($permissions))
            {
                return true;
            }
        }

        return false;
    }

    public function hasPermissions($permission)
    {
        $user = \DB::table('role_user')->join('permission_role', 'role_user.role_uuid', '=', 'permission_role.role_uuid')
            ->join('permissions', 'permission_role.permission_uuid', '=', 'permissions.uuid')
            ->where('role_user.user_uuid', $this->uuid)
            ->where('permissions.name', $permission)
            ->first();
        if($user){
            return true;
        }

        return false;
    }

    public function rules(){
        return $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email'. (($this->id) ? ', ' . $this->id : ''),
        ];
    }

    public $mensages = [
        'name.required' => 'O Nome é obrigatório.',
        'name.max' => 'O tamanho máximo do nome é de 255 caracteres',
        'email.required' => 'O E-mail é obrigatório.',
        'email.max' => 'O tamanho máximo do e-mail é de 255 caracteres',
        'email.email' => 'E-mail em um formato inválido',
        'email.unique' => 'E-mail já cadastrado para outro Usuário.'
    ];


}
