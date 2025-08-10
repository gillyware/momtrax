<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Models\UserSetting;
use App\Packets\UserSettings\StoreUserSettingPacket;
use App\Packets\UserSettings\UpdateUserSettingPacket;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
final class UserSettingRepository
{
    public function createForUser(User $user, StoreUserSettingPacket $storeUserSettingPacket): UserSetting
    {
        $settings = UserSetting::create(array_merge($storeUserSettingPacket->toArray(), [
            'user_id' => $user->id,
        ]));

        return $settings->refresh();
    }

    public function update(UserSetting $settings, UpdateUserSettingPacket $updateSettingsPacket): UserSetting
    {
        $settings->update($updateSettingsPacket->toArray());

        return $settings->refresh();
    }
}
