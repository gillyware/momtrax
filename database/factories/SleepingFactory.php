<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Child;
use App\Models\Sleeping;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sleeping>
 */
final class SleepingFactory extends Factory
{
    public function definition(): array
    {
        $duration = fake()->numberBetween(0, 60);
        [$startDateTime, $endDateTime] = [now()->subMinutes($duration), now()];

        return [
            'start_date_time' => $startDateTime,
            'end_date_time' => $endDateTime,
            'notes' => fake()->text(),
        ];
    }

    public function forChild(Child $child): self
    {
        return $this->state([
            'child_id' => $child->id,
        ]);
    }
}
