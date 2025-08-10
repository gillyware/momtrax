<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Packets\Users\StoreUserPacket;
use App\Packets\Users\UpdateUserProfilePacket;
use Illuminate\Container\Attributes\Singleton;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

#[Singleton]
final class UserRepository
{
    public function __construct(private readonly UserSettingRepository $userSettingRepository) {}

    public function create(StoreUserPacket $storeUserPacket): User
    {
        return DB::transaction(function () use ($storeUserPacket) {
            $user = User::create(array_merge($storeUserPacket->toArray(), [
                'uuid' => uuidv4(),
                'password' => Hash::make($storeUserPacket->password),
            ]));

            $this->userSettingRepository->createForUser($user);

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
