<?php

declare(strict_types=1);

namespace App\Packets\User;

use Carbon\Carbon;
use Gillyware\Postal\Attributes\Field;
use Gillyware\Postal\Attributes\Rule;
use Gillyware\Postal\Packet;
use Illuminate\Support\Facades\Config;

final class PersistPumpingPacket extends Packet
{
    public readonly Carbon $dateTime;

    public function __construct(
        #[Field('left_breast_amount'), Rule(['nullable', 'numeric', 'gte:0', 'required_with:right_breast_amount'])]
        public readonly int|float|null $leftBreastAmount,
        #[Field('right_breast_amount'), Rule(['nullable', 'numeric', 'gte:0', 'required_with:left_breast_amount'])]
        public readonly ?int $rightBreastAmount,
        #[Field('total_amount'), Rule(['required', 'integer', 'gte:0'])]
        public readonly int|float $totalAmount,
        #[Field('duration_in_minutes'), Rule(['required', 'integer', 'gte:0'])]
        public readonly int|float $durationInMinutes,
        #[Rule(['nullable', 'string', 'max:255'])]
        public readonly ?string $notes,
        #[Field('date_time'), Rule(['required', 'date_format:Y-m-d H:i', 'date'])]
        string $dateTime,
    ) {
        $this->dateTime = Carbon::createFromFormat('Y-m-d H:i', $dateTime, 'UTC');
    }

    public function toArray(): array
    {
        return [
            'left_breast_amount' => $this->leftBreastAmount,
            'right_breast_amount' => $this->rightBreastAmount,
            'total_amount' => $this->totalAmount,
            'duration_in_minutes' => $this->durationInMinutes,
            'notes' => $this->notes,
            'date_time' => $this->dateTime->timezone(Config::get('app.timezone')),
        ];
    }
}
