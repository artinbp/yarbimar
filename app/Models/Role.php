<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public const ROLE_SUPER_ADMIN = 'role_super_admin';
    public const ROLE_ADMIN = 'role_admin';
    public const ROLE_CUSTOMER = 'role_customer';

    public static $roles = [
        self::ROLE_SUPER_ADMIN,
        self::ROLE_ADMIN,
        self::ROLE_CUSTOMER,
    ];

    protected $fillable = ['name'];

    public function users() {
        return $this->belongsToMany(User::class);
    }
}
