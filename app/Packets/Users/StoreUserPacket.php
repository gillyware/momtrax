<?php

declare(strict_types=1);

namespace App\Packets\Users;

use App\Models\User;
use Gillyware\Postal\Attributes\Field;
use Gillyware\Postal\Attributes\Rule;
use Gillyware\Postal\Packet;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\Rules\Password;

final class StoreUserPacket extends Packet
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
        #[Rule(['required', 'confirmed'])]
        public readonly string $password,
        #[Rule(['required', 'timezone'])]
        public readonly string $timezone,
    ) {}

    public function toArray(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'nickname' => $this->nickname,
            'email' => $this->email,
            'password' => $this->password,
            'timezone' => $this->timezone,
        ];
    }

    protected static function explicitRules(): array
    {
        return [
            'email' => [ValidationRule::unique(User::class)],
            'password' => [Password::defaults()],
        ];
    }
}
