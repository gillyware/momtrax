<?php

declare(strict_types=1);

use App\Enums\Gender;
use App\Models\Child;
use App\Models\User;
use App\Packets\Child\StoreChildPacket;
use App\Services\ChildService;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertModelExists;

beforeEach(function () {
    $this->childService = resolve(ChildService::class);
});

test('create() persists child', function () {
    $user = User::factory()->create();
    $birthDate = now()
        ->subDays(fake()->numberBetween(0, 20))
        ->subMinutes(fake()->numberBetween(0, 20));

    $packet = StoreChildPacket::from([
        'name' => $name = fake()->name(),
        'birth_date' => $birthDate->format('Y-m-d H:i'),
        'gender' => $gender = Gender::random()->value,
    ]);

    /** @var Child $child */
    $child = $this->childService->create($user, $packet);

    assertModelExists($child);

    expect($child->uuid)->toBeUuid();

    assertDatabaseHas((new Child)->getTable(), [
        'user_id' => $user->id,
        'name' => $name,
        'birth_date' => $birthDate->setSecond(0)->toDateTimeString(),
        'gender' => $gender,
    ]);
});
