<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'uuid' => fake()->unique()->uuid(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'nickname' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => self::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'timezone' => fake()->timezone(),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (User $user) {
            UserSetting::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }

    public function withoutSettings(): self
    {
        return $this->afterCreating(function (User $user) {
            $user->settings()->delete();
        });
    }
}
