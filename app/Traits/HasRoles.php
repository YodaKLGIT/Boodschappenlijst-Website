<?php

namespace App\Traits;

trait HasRoles
{
    public function hasRole($role)
    {
        return $this->role === $role;
    }

    // You can add more role-related methods here as needed
}