<?php

declare(strict_types=1);

namespace App\Contracts\User;

use App\Models\Pumping;
use App\Models\User;
use App\Packets\User\PersistPumpingPacket;
use App\Services\User\PumpingService;
use Illuminate\Container\Attributes\Bind;

#[Bind(PumpingService::class)]
interface PumpingServiceInterface
{
    public function create(User $user, PersistPumpingPacket $persistPumpingPacket): Pumping;

    public function update(Pumping $pumping, PersistPumpingPacket $persistPumpingPacket): Pumping;

    public function destroy(Pumping $pumping): bool;
}
