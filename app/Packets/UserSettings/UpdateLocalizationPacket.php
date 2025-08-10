<?php

declare(strict_types=1);

namespace App\Packets\UserSettings;

use Gillyware\Postal\Attributes\Rule;

final class UpdateLocalizationPacket extends UpdateUserSettingPacket
{
    public function __construct(
        #[Rule(['required', 'timezone'])]
        public readonly string $timezone
    ) {}
}
