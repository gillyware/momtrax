<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;
use App\Models\UserSetting;
use App\Packets\UserSettings\StoreUserSettingPacket;
use App\Packets\UserSettings\UpdateUserSettingPacket;

interface UserSettingServiceInterface
{
    public function createForUser(User $user, StoreUserSettingPacket $storeUserSettingPacket): UserSetting;

    public function update(UserSetting $settings, UpdateUserSettingPacket $updateSettingsPacket): UserSetting;
}
