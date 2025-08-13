<?php

declare(strict_types=1);

namespace App\Packets\Child;

use App\Enums\Gender;
use Carbon\Carbon;
use Gillyware\Postal\Attributes\Field;
use Gillyware\Postal\Attributes\Rule;
use Gillyware\Postal\Packet;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule as ValidationRule;

final class StoreChildPacket extends Packet
{
    public readonly Carbon $birthDate;

    public readonly Gender $gender;

    public function __construct(
        #[Rule(['required', 'string', 'max:255'])]
        public readonly string $name,
        #[Field('birth_date'), Rule(['required', 'date_format:Y-m-d H:i', 'date'])]
        string $birthDate,
        #[Rule(['required', 'string'])]
        string $gender,
    ) {
        $this->birthDate = Carbon::createFromFormat('Y-m-d H:i', $birthDate, 'UTC');
        $this->gender = Gender::from($gender);
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'birth_date' => $this->birthDate->timezone(Config::get('app.timezone')),
            'gender' => $this->gender->value,
        ];
    }

    protected static function explicitRules(): array
    {
        return [
            'gender' => [ValidationRule::in(Gender::values())],
        ];
    }
}
