<?php

declare(strict_types=1);

namespace App\Contracts\Child;

use App\Models\Child;
use App\Models\Feeding;
use App\Packets\Child\PersistFeedingPacket;
use App\Services\Child\FeedingService;
use Illuminate\Container\Attributes\Bind;

#[Bind(FeedingService::class)]
interface FeedingServiceInterface
{
    public function create(Child $child, PersistFeedingPacket $persistFeedingPacket): Feeding;

    public function update(Feeding $feeding, PersistFeedingPacket $persistFeedingPacket): Feeding;

    public function destroy(Feeding $feeding): bool;
}
