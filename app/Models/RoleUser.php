<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';
    protected $fillable = ['role_id', 'user_id'];

    public function role()
    {
        return $this->belongsTo(\App\Model\Role::class, 'role_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id', 'id');
    }

}
