<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\UserServiceInterface;
use App\Enums\MomTraxFeature;
use App\Models\User;
use App\Packets\Users\StoreUserPacket;
use App\Packets\Users\UpdateUserProfilePacket;
use App\Packets\UserSettings\StoreUserSettingPacket;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

#[Singleton]
final class UserService implements UserServiceInterface
{
    public function __construct(private readonly UserSettingService $userSettingService) {}

    /**
     * {@inheritDoc}
     */
    public function getFeatures(User $user): array
    {
        return [
            'pumping' => [
                'enabled' => $user->hasFeature(MomTraxFeature::PumpingEnabled),
                'prefer_start_time' => $user->hasFeature(MomTraxFeature::PumpingPreferStartTime),
                'count_from_start' => $user->hasFeature(MomTraxFeature::PumpingCountFromStart),
            ],
            'children' => [
                'enabled' => $user->hasFeature(MomTraxFeature::ChildrenEnabled),
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function create(StoreUserPacket $storeUserPacket): User
    {
        return DB::transaction(function () use ($storeUserPacket) {
            $userData = $storeUserPacket->toArray();
            $timezone = Arr::pull($userData, 'timezone');

            $user = User::create(array_merge($userData, [
                'uuid' => uuidv4(),
                'password' => Hash::make($storeUserPacket->password),
            ]));

            $this->userSettingService->createForUser($user, StoreUserSettingPacket::from([
                'timezone' => $timezone,
            ]));

            return $user->refresh();
        });
    }

    /**
     * {@inheritDoc}
     */
    public function updateProfile(User $user, UpdateUserProfilePacket $updateUserProfilePacket): User
    {
        return DB::transaction(function () use ($user, $updateUserProfilePacket) {
            $user->update($updateUserProfilePacket->toArray());

            return $user->refresh();
        });
    }

    /**
     * {@inheritDoc}
     */
    public function destroy(User $user): bool
    {
        return (bool) $user->delete();
    }
}
