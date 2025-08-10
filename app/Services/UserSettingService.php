<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\UserSetting;
use App\Packets\UserSettings\UpdateUnitPreferencesPacket;
use App\Repositories\UserSettingRepository;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
final class UserSettingService
{
    public function __construct(private readonly UserSettingRepository $userSettingRepository) {}

    public function updateUnitPreferences(UserSetting $user, UpdateUnitPreferencesPacket $updateUnitPreferencesPacket): UserSetting
    {
        return $this->userSettingRepository->updateUnitPreferences($user, $updateUnitPreferencesPacket);
    }
}
