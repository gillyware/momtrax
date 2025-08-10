<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Packets\Users\StoreUserPacket;
use App\Packets\Users\UpdateUserProfilePacket;
use App\Repositories\UserRepository;
use Illuminate\Container\Attributes\Singleton;

#[Singleton]
final class UserService
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function create(StoreUserPacket $storeUserPacket): User
    {
        return $this->userRepository->create($storeUserPacket);
    }

    public function updateProfile(User $user, UpdateUserProfilePacket $updateUserProfilePacket): User
    {
        return $this->userRepository->updateProfile($user, $updateUserProfilePacket);
    }

    public function destroy(User $user): bool
    {
        return $this->userRepository->destroy($user);
    }
}
