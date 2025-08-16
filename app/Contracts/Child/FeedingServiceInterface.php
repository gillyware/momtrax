<?php

declare(strict_types=1);

namespace App\Contracts\Child;

use App\Models\User;
use App\Services\Child\FeedingService;
use Illuminate\Container\Attributes\Bind;

#[Bind(FeedingService::class)]
interface FeedingServiceInterface
{
    public function create(User $user): bool;
}
