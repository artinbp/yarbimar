<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = "pending";
    public const STATUS_PROCESSING = "processing";
    public const STATUS_COMPLETED = "completed";
    public const STATUS_CANCELLED = "cancelled";

    public static $statuses = [
        self::STATUS_PENDING,
        self::STATUS_PROCESSING,
        self::STATUS_COMPLETED,
        self::STATUS_CANCELLED,
    ];

    protected $fillable = [
        'total',
        'status'
    ];

    protected $with = ['products', 'payment'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $builder, Request $request)
    {
        if ($request->has('status')) {
            $builder->where('status', '=', $request->input('status'));
        }

        return $builder;
    }
}
