<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\PumpingServiceInterface;
use App\Enums\MomTraxUserFeature;
use App\Models\Pumping;
use App\Models\User;
use App\Packets\Pumping\PersistPumpingPacket;

final class PumpingService implements PumpingServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(User $user, PersistPumpingPacket $persistPumpingPacket): Pumping
    {
        $pumpingData = $this->transformPacketDataForPersisting($user, $persistPumpingPacket);

        return Pumping::create($pumpingData);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Pumping $pumping, PersistPumpingPacket $persistPumpingPacket): Pumping
    {
        $user = $pumping->user;

        $pumpingData = $this->transformPacketDataForPersisting($user, $persistPumpingPacket);

        $pumping->update($pumpingData);

        return $pumping->refresh();
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(Pumping $pumping): bool
    {
        return (bool) $pumping->delete();
    }

    /**
     * Mutate persistence packet into an array to persist into the database.
     */
    private function transformPacketDataForPersisting(User $user, PersistPumpingPacket $persistPumpingPacket): array
    {
        $pumpingData = $persistPumpingPacket->toArray();
        $preferStartTime = $user->hasFeature(MomTraxUserFeature::PumpingPreferStartTime);

        $startDateTime = $preferStartTime
            ? $persistPumpingPacket->dateTime
            : $persistPumpingPacket->dateTime->copy()->subMinutes($persistPumpingPacket->durationInMinutes);

        $endDateTime = $preferStartTime
            ? $persistPumpingPacket->dateTime->copy()->addMinutes($persistPumpingPacket->durationInMinutes)
            : $persistPumpingPacket->dateTime;

        unset($pumpingData['date_time']);

        return array_merge($pumpingData, [
            'user_id' => $user->id,
            'start_date_time' => $startDateTime,
            'end_date_time' => $endDateTime,
            'unit' => $user->settings->milk_unit,
        ]);
    }
}
