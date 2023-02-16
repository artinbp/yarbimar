<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case SUPER_ADMIN = 'role_super_admin';
    case ADMIN = 'role_admin';
    case CUSTOMER = 'role_customer';

    public function isSuperAdmin(): bool
    {
        return $this === static::SUPER_ADMIN;
    }

    public function isAdmin(): bool
    {
        return $this === static::ADMIN;
    }

    public function isCustomer(): bool
    {
        return $this === static::CUSTOMER;
    }
}
