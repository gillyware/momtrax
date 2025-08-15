<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\ChildServiceInterface;
use App\Models\Child;
use App\Models\User;
use App\Packets\Child\PersistChildPacket;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
final class ChildService implements ChildServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(User $user, PersistChildPacket $persistChildPacket): Child
    {
        $childData = array_merge($persistChildPacket->toArray(), [
            'uuid' => uuidv4(),
            'user_id' => $user->id,
        ]);

        return Child::create($childData);
    }

    /**
     * {@inheritDoc}
     */
    public function updateProfile(Child $child, PersistChildPacket $persistChildPacket): Child
    {
        $child->update($persistChildPacket->toArray());

        return $child->refresh();
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(Child $child): bool
    {
        return (bool) $child->delete();
    }
}
