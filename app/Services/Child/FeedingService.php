<?php

declare(strict_types=1);

namespace App\Services\Child;

use App\Contracts\Child\FeedingServiceInterface;
use App\Models\User;

final class FeedingService implements FeedingServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(User $user): bool
    {
        return true;
    }
}
