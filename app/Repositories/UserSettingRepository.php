<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Models\UserSetting;
use App\Packets\UserSettings\UpdateUnitPreferencesPacket;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
final class UserSettingRepository
{
    public function createForUser(User $user): UserSetting
    {
        $settings = UserSetting::create([
            'user_id' => $user->id,
        ]);

        return $settings->refresh();
    }

    public function updateUnitPreferences(UserSetting $settings, UpdateUnitPreferencesPacket $updateUnitPreferencesPacket): UserSetting
    {
        $settings->update($updateUnitPreferencesPacket->toArray());

        return $settings->refresh();
    }
}
