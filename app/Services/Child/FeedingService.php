<?php

declare(strict_types=1);

namespace App\Services\Child;

use App\Contracts\Child\FeedingServiceInterface;
use App\Enums\MomTraxChildFeature;
use App\Models\Child;
use App\Models\Feeding;
use App\Packets\Child\PersistFeedingPacket;

final class FeedingService implements FeedingServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function create(Child $child, PersistFeedingPacket $persistFeedingPacket): Feeding
    {
        $feedingData = $this->transformPacketDataForPersisting($child, $persistFeedingPacket);

        return Feeding::create($feedingData);
    }

    /**
     * {@inheritDoc}
     */
    public function update(Feeding $feeding, PersistFeedingPacket $persistFeedingPacket): Feeding
    {
        $child = $feeding->child;

        $feedingData = $this->transformPacketDataForPersisting($child, $persistFeedingPacket);

        $feeding->update($feedingData);

        return $feeding->refresh();
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(Feeding $feeding): bool
    {
        return (bool) $feeding->delete();
    }

    /**
     * Mutate persistence packet into an array to persist into the database.
     */
    private function transformPacketDataForPersisting(Child $child, PersistFeedingPacket $persistFeedingPacket): array
    {
        $feedingData = $persistFeedingPacket->toArray();
        $preferStartTime = $child->hasFeature(MomTraxChildFeature::FeedingPreferStartTime);

        $startDateTime = $preferStartTime
            ? $persistFeedingPacket->dateTime
            : $persistFeedingPacket->dateTime->copy()->subMinutes($persistFeedingPacket->durationInMinutes);

        $endDateTime = $preferStartTime
            ? $persistFeedingPacket->dateTime->copy()->addMinutes($persistFeedingPacket->durationInMinutes)
            : $persistFeedingPacket->dateTime;

        unset($feedingData['date_time']);

        return array_merge($feedingData, [
            'child_id' => $child->id,
            'start_date_time' => $startDateTime,
            'end_date_time' => $endDateTime,
            'unit' => $child->user->settings->milk_unit,
        ]);
    }
}
