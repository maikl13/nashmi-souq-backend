<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait UserInfo {

    // Get User Role Name
    public function role()
    {
        switch ($this->role_id) {
            case Self::ROLE_USER: return 'user'; break;
            case Self::ROLE_SUPERADMIN: return 'superadmin'; break;
            case Self::ROLE_ADMIN: return 'admin'; break;
        }
        return false;
    }

    public function status()
    {
        return $this->is_active() ? 'نشط' : 'غير مفعل';
    }

    // check user role
    public function is_user(){
        return $this->role_id == Self::ROLE_USER;
    }
    public function is_admin(){
        return $this->role_id == Self::ROLE_ADMIN;
    }
    public function is_superadmin(){
        return $this->role_id == Self::ROLE_SUPERADMIN;
    }

    //check if user is active
    public function is_active(){
        return $this->active;
    }

}