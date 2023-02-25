<?php

namespace App\Models;

use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'status'
    ];

    protected $with = ['products'];

    protected $casts = [
        'status' => OrderStatusEnum::class,
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'price');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function isPaid(): bool
    {
        return $this->invoice->payment()->exists();
    }

    public function scopeFilter(Builder $builder, Request $request)
    {
        if ($request->has('status')) {
            $builder->where('status', '=', $request->input('status'));
        }

        return $builder;
    }
}
