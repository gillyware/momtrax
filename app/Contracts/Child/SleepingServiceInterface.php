<?php

declare(strict_types=1);

namespace App\Contracts\Child;

use App\Models\Child;
use App\Models\Sleeping;
use App\Packets\Child\PersistSleepingPacket;
use App\Services\Child\SleepingService;
use Illuminate\Container\Attributes\Bind;

#[Bind(SleepingService::class)]
interface SleepingServiceInterface
{
    public function create(Child $child, PersistSleepingPacket $persistSleepingPacket): Sleeping;

    public function update(Sleeping $sleeping, PersistSleepingPacket $persistSleepingPacket): Sleeping;

    public function destroy(Sleeping $sleeping): bool;
}
