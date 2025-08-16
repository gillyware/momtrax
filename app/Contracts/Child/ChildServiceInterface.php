<?php

declare(strict_types=1);

namespace App\Contracts\Child;

use App\Models\Child;
use App\Models\User;
use App\Packets\Child\PersistChildPacket;
use App\Services\Child\ChildService;
use Illuminate\Container\Attributes\Bind;

#[Bind(ChildService::class)]
interface ChildServiceInterface
{
    public function create(User $user, PersistChildPacket $persistChildPacket): Child;

    public function updateProfile(Child $child, PersistChildPacket $persistChildPacket): Child;

    public function destroy(Child $child): bool;
}
