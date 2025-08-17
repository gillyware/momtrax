<?php

declare(strict_types=1);

namespace App\Packets\User;

use Gillyware\Postal\Attributes\Field;
use Gillyware\Postal\Attributes\Rule;
use Gillyware\Postal\Packet;

final class UpdateUserProfilePacket extends Packet
{
    public function __construct(
        #[Field('first_name'), Rule(['required', 'string', 'max:255'])]
        public readonly string $firstName,
        #[Field('last_name'), Rule(['required', 'string', 'max:255'])]
        public readonly string $lastName,
        #[Field('nickname'), Rule(['required', 'string', 'max:255'])]
        public readonly string $nickname,
        #[Rule(['required', 'string', 'lowercase', 'email', 'max:255'])]
        public readonly string $email,
    ) {}

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'nickname' => $this->nickname,
            'email' => $this->email,
        ];
    }
}
