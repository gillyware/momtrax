<?php

declare(strict_types=1);

namespace App\Packets\Child;

use Carbon\Carbon;
use Gillyware\Postal\Attributes\Field;
use Gillyware\Postal\Attributes\Rule;
use Gillyware\Postal\Packet;
use Illuminate\Support\Facades\Config;

final class PersistSleepingPacket extends Packet
{
    public readonly Carbon $startDateTime;

    public readonly Carbon $endDateTime;

    public function __construct(
        #[Field('start_date_time'), Rule(['required', 'date_format:Y-m-d H:i', 'date'])]
        string $startDateTime,
        #[Field('end_date_time'), Rule(['required', 'date_format:Y-m-d H:i', 'date'])]
        string $endDateTime,
        #[Rule(['nullable', 'string', 'max:255'])]
        public readonly ?string $notes,
    ) {
        $this->startDateTime = Carbon::createFromFormat('Y-m-d H:i', $startDateTime, 'UTC');
        $this->endDateTime = Carbon::createFromFormat('Y-m-d H:i', $endDateTime, 'UTC');
    }

    public function toArray(): array
    {
        return [
            'start_date_time' => $this->startDateTime->timezone(Config::get('app.timezone')),
            'end_date_time' => $this->endDateTime->timezone(Config::get('app.timezone')),
            'notes' => $this->notes,
        ];
    }
}
