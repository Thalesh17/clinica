<?php

use Illuminate\Database\Seeder;
use App\Models\RoleUser;

class RoleUserTableSeeder extends Seeder
{

    public function run()
    {
        $this->addRoleUser(1, 1, 1);

    }

    public function addRoleUser($id, $user, $role)
    {
        $userRole = new RoleUser();
        $userRole->id = $id;
        $userRole->user_id = $user;
        $userRole->role_id = $role;
    }
}
