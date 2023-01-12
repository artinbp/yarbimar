<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    public const STATUS_UNPAID = "unpaid";
    public const STATUS_PAID = "paid";
    public const STATUS_PROCESSED = "unprocessed";
    public const STATUS_PROCESSING = "processing";
    public const STATUS_SHIPPED = "shipped";
    public const STATUS_CANCELLED = "cancelled";

    public static $statuses = [
        self::STATUS_UNPAID,
        self::STATUS_PAID,
        self::STATUS_PROCESSED,
        self::STATUS_PROCESSING,
        self::STATUS_SHIPPED,
        self::STATUS_CANCELLED,
    ];

    protected $guarded = [];

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
}
