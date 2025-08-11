<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Pumping;
use App\Models\User;
use App\Packets\Pumping\PersistPumpingPacket;

interface PumpingServiceInterface
{
    public function create(User $user, PersistPumpingPacket $persistPumpingPacket): Pumping;

    public function update(Pumping $pumping, PersistPumpingPacket $persistPumpingPacket): Pumping;

    public function destroy(Pumping $pumping): bool;
}
