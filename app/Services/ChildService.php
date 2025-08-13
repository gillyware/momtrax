<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ChildServiceInterface;
use App\Models\Child;
use App\Models\User;
use App\Packets\Child\StoreChildPacket;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
final class ChildService implements ChildServiceInterface
{
    public function create(User $user, StoreChildPacket $storeChildPacket): Child
    {
        $childData = array_merge($storeChildPacket->toArray(), [
            'uuid' => uuidv4(),
            'user_id' => $user->id,
        ]);

        return Child::create($childData);
    }
}
