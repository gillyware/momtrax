<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\Child;
use App\Models\User;
use App\Packets\Child\StoreChildPacket;

interface ChildServiceInterface
{
    public function create(User $user, StoreChildPacket $storeChildPacket): Child;
}
