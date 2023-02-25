<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carousel extends Model
{
    use HasFactory;

    protected $table = 'carousel';

    protected $fillable = [
        'title',
        'title',
        'description',
        'url'
    ];

    protected $with = ['media'];

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class);
    }
}
