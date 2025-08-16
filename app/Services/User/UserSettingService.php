<?php

declare(strict_types=1);

namespace App\Services\User;

use App\Contracts\User\UserSettingServiceInterface;
use App\Models\User;
use App\Models\UserSetting;
use App\Packets\UserSettings\StoreUserSettingPacket;
use App\Packets\UserSettings\UpdateUserSettingPacket;

final class UserSettingService implements UserSettingServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function createForUser(User $user, StoreUserSettingPacket $storeUserSettingPacket): UserSetting
    {
        return UserSetting::create(array_merge($storeUserSettingPacket->toArray(), [
            'user_id' => $user->id,
        ]));
    }

    /**
     * {@inheritDoc}
     */
    public function update(UserSetting $settings, UpdateUserSettingPacket $updateSettingsPacket): UserSetting
    {
        $settings->update($updateSettingsPacket->toArray());

        return $settings->refresh();
    }
}
