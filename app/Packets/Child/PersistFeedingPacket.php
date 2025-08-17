<?php

declare(strict_types=1);

namespace App\Packets\Child;

use App\Enums\FeedingType;
use Carbon\Carbon;
use Gillyware\Postal\Attributes\Field;
use Gillyware\Postal\Attributes\Rule;
use Gillyware\Postal\Packet;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\Rule as ValidationRule;

final class PersistFeedingPacket extends Packet
{
    public readonly FeedingType $feedingType;

    public readonly Carbon $dateTime;

    public function __construct(
        #[Field('feeding_type'), Rule(['required', 'integer'])]
        int $feedingType,
        #[Field('total_amount'), Rule(['required', 'numeric', 'gte:0'])]
        public readonly int|float $totalAmount,
        #[Field('duration_in_minutes'), Rule(['required', 'integer', 'gte:0'])]
        public readonly int|float $durationInMinutes,
        #[Rule(['nullable', 'string', 'max:255'])]
        public readonly ?string $notes,
        #[Field('date_time'), Rule(['required', 'date_format:Y-m-d H:i', 'date'])]
        string $dateTime,
    ) {
        $this->feedingType = FeedingType::from($feedingType);
        $this->dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTime, 'UTC');
    }

    public function toArray(): array
    {
        return [
            'feeding_type' => $this->feedingType->value,
            'total_amount' => $this->totalAmount,
            'duration_in_minutes' => $this->durationInMinutes,
            'notes' => $this->notes,
            'date_time' => $this->dateTime->timezone(Config::get('app.timezone')),
        ];
    }

    protected static function explicitRules(): array
    {
        return [
            'feeding_type' => [ValidationRule::in(FeedingType::values())],
        ];
    }
}
