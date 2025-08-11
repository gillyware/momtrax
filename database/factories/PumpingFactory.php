<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Pumping;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pumping>
 */
final class PumpingFactory extends Factory
{
    public function definition(): array
    {
        [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

        $duration = fake()->numberBetween(0, 60);
        [$startDateTime, $endDateTime] = [now()->subMinutes($duration), now()];

        return [
            'left_breast_amount' => $left,
            'right_breast_amount' => $right,
            'total_amount' => $left + $right,
            'duration_in_minutes' => $duration,
            'notes' => fake()->text(),
            'start_date_time' => $startDateTime,
            'end_date_time' => $endDateTime,
        ];
    }

    public function forUser(User $user): self
    {
        return $this->state([
            'user_id' => $user->id,
            'unit' => $user->settings->milk_unit,
        ]);
    }
}
