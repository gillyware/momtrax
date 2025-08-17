<?php

declare(strict_types=1);

namespace App\Packets\User;

use Gillyware\Postal\Attributes\Rule;
use Gillyware\Postal\Packet;

final class StoreUserSettingPacket extends Packet
{
    public function __construct(
        #[Rule(['required', 'timezone'])]
        public readonly string $timezone,
    ) {}
}
