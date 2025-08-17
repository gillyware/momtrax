<?php

declare(strict_types=1);

namespace App\Contracts\User;

use App\Models\User;
use App\Models\UserSetting;
use App\Packets\User\StoreUserSettingPacket;
use App\Packets\User\UpdateUserSettingPacket;
use App\Services\User\UserSettingService;
use Illuminate\Container\Attributes\Bind;

#[Bind(UserSettingService::class)]
interface UserSettingServiceInterface
{
    public function createForUser(User $user, StoreUserSettingPacket $storeUserSettingPacket): UserSetting;

    public function update(UserSetting $settings, UpdateUserSettingPacket $updateSettingsPacket): UserSetting;
}
