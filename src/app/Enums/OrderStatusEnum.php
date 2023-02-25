<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function isPending(): bool
    {
        return $this === static::PENDING;
    }

    public function isProcessing(): bool
    {
        return $this === static::PROCESSING;
    }

    public function isCompleted(): bool
    {
        return $this === static::COMPLETED;
    }

    public function isCancelled(): bool
    {
        return $this === static::CANCELLED;
    }
}
