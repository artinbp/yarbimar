<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public const STATUS_UNPAID    = "unpaid";
    public const STATUS_PAID      = "paid";
    public const STATUS_PROCESSED  = "unprocessed";
    public const STATUS_PROCESSING = "processing";
    public const STATUS_SHIPPED    = "shipped";
    public const STATUS_CANCELLED  = "cancelled";

    public static $statuses = [
        self::STATUS_UNPAID,
        self::STATUS_PAID,
        self::STATUS_PROCESSED,
        self::STATUS_PROCESSING,
        self::STATUS_SHIPPED,
        self::STATUS_CANCELLED,
    ];

    protected $guarded = [];

    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }
}
