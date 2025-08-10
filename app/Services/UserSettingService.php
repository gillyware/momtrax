<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\UserSetting;
use App\Packets\UserSettings\UpdateUserSettingPacket;
use App\Repositories\UserSettingRepository;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
final class UserSettingService
{
    public function __construct(private readonly UserSettingRepository $userSettingRepository) {}

    public function update(UserSetting $settings, UpdateUserSettingPacket $updateSettingsPacket): UserSetting
    {
        return $this->userSettingRepository->update($settings, $updateSettingsPacket);
    }
}
