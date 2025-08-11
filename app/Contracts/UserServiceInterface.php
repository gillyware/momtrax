<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;
use App\Packets\Users\StoreUserPacket;
use App\Packets\Users\UpdateUserProfilePacket;

interface UserServiceInterface
{
    /**
     * @return array{
     *     pumping: array{
     *         enabled: bool,
     *         prefer_start_time: bool,
     *         count_from_start: bool
     *     },
     *     children: array{
     *         enabled: bool
     *     }
     * }
     */
    public function getFeatures(User $user): array;

    public function create(StoreUserPacket $storeUserPacket): User;

    public function updateProfile(User $user, UpdateUserProfilePacket $updateUserProfilePacket): User;

    public function destroy(User $user): bool;
}
