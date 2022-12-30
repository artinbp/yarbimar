<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const STATUS_PAID   = "paid";
    public const STATUS_UNPAID = "unpaid";

    protected $guarded = [];
}
