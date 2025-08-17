<?php

declare(strict_types=1);

namespace App\Services\Child;

use App\Contracts\Child\SleepingServiceInterface;
use App\Models\Child;
use App\Models\Sleeping;
use App\Packets\Child\PersistSleepingPacket;

final class SleepingService implements SleepingServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(Child $child, PersistSleepingPacket $persistSleepingPacket): Sleeping
    {
        $sleepingData = array_merge($persistSleepingPacket->toArray(), [
            'child_id' => $child->id,
        ]);

        return Sleeping::create($sleepingData);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Sleeping $sleeping, PersistSleepingPacket $persistSleepingPacket): Sleeping
    {
        $sleeping->update($persistSleepingPacket->toArray());

        return $sleeping->refresh();
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(Sleeping $sleeping): bool
    {
        return (bool) $sleeping->delete();
    }
}
