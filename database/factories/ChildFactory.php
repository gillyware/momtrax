<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\Child;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Config;

/**
 * @extends Factory<Child>
 */
final class ChildFactory extends Factory
{
    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'name' => fake()->firstName(),
            'birth_date' => fake()->dateTime(timezone: Config::get('app.timezone')),
            'gender' => Gender::random(),
            'pfp_extension' => null,
        ];
    }

    public function forUser(User $user): self
    {
        return $this->state([
            'user_id' => $user->id,
        ]);
    }
}
