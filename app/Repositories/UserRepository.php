<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Packets\Users\StoreUserPacket;
use App\Packets\Users\UpdateUserProfilePacket;
use App\Packets\UserSettings\StoreUserSettingPacket;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

#[Singleton]
final class UserRepository
{
    public function __construct(private readonly UserSettingRepository $userSettingRepository) {}

    public function create(StoreUserPacket $storeUserPacket): User
    {
        return DB::transaction(function () use ($storeUserPacket) {
            $userData = $storeUserPacket->toArray();
            $timezone = Arr::pull($userData, 'timezone');

            $user = User::create(array_merge($userData, [
                'uuid' => uuidv4(),
                'password' => Hash::make($storeUserPacket->password),
            ]));

            $this->userSettingRepository->createForUser($user, StoreUserSettingPacket::from([
                'timezone' => $timezone,
            ]));

            return $user->refresh();
        });
    }

    public function updateProfile(User $user, UpdateUserProfilePacket $updateUserProfilePacket): User
    {
        return DB::transaction(function () use ($user, $updateUserProfilePacket) {
            $user->update($updateUserProfilePacket->toArray());

            return $user->refresh();
        });
    }

    public function destroy(User $user): bool
    {
        return (bool) $user->delete();
    }
}
