<?php

namespace App\Enums;

enum TransactionStatusEnum: string
{
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';

    public function isPending(): bool
    {
        return $this === static::PENDING;
    }

    public function isPaid(): bool
    {
        return $this === static::PAID;
    }

    public function isFailed(): bool
    {
        return $this === static::FAILED;
    }
}
