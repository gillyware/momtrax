<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\FeedingType;
use App\Models\Child;
use App\Models\Feeding;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Feeding>
 */
final class FeedingFactory extends Factory
{
    public function definition(): array
    {
        $total = fake()->numberBetween(0, 400);
        $duration = fake()->numberBetween(0, 60);
        [$startDateTime, $endDateTime] = [now()->subMinutes($duration), now()];

        return [
            'feeding_type' => FeedingType::random(),
            'total_amount' => $total,
            'duration_in_minutes' => $duration,
            'notes' => fake()->text(),
            'start_date_time' => $startDateTime,
            'end_date_time' => $endDateTime,
        ];
    }

    public function forChild(Child $child): self
    {
        $user = $child->user;

        return $this->state([
            'child_id' => $child->id,
            'unit' => $user->settings->milk_unit,
        ]);
    }
}
