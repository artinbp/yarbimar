<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'delivery_methods';

    protected $fillable = [
        'name',
        'description',
        'fee',
        'disabled',
    ];

    protected $casts = [
        'disabled' => 'boolean',
    ];
}
