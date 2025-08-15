<?php

declare(strict_types=1);

use App\Enums\Gender;
use App\Models\Child;
use App\Models\User;
use App\Packets\Child\PersistChildPacket;
use App\Services\ChildService;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertModelExists;

beforeEach(function () {
    $this->childService = resolve(ChildService::class);
});

test('create() persists child', function () {
    $user = User::factory()->create();
    $birthDate = now()
        ->subDays(fake()->numberBetween(0, 20))
        ->subMinutes(fake()->numberBetween(0, 20))
        ->setSecond(0);

    $packet = PersistChildPacket::from([
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
        'birth_date' => $birthDate->toDateTimeString(),
        'gender' => $gender,
    ]);
});

test('updateProfile() updates child profile', function () {
    $user = User::factory()->create();
    $child = Child::factory()->forUser($user)->create();

    $birthDate = now()
        ->subDays(fake()->numberBetween(0, 20))
        ->subMinutes(fake()->numberBetween(0, 20))
        ->setSecond(0);

    $packet = PersistChildPacket::from([
        'name' => $name = fake()->name(),
        'birth_date' => $birthDate->format('Y-m-d H:i'),
        'gender' => $gender = Gender::random()->value,
    ]);

    /** @var Child $child */
    $child = $this->childService->updateProfile($child, $packet);

    expect($child->user->id)->toBe($user->id)
        ->and($child->name)->toBe($name)
        ->and($child->birth_date->toDateTimeString())->toBe($birthDate->toDateTimeString())
        ->and($child->gender->value)->toBe($gender);
});

test('destroy() deletes child', function () {
    $user = User::factory()->create();
    $child = Child::factory()->forUser($user)->create();

    expect($this->childService->destroy($child))->toBeTrue();

    assertDatabaseMissing((new Child)->getTable(), ['id' => $child->id]);
});

test('destroy() called twice returns false on second attempt', function () {
    $user = User::factory()->create();
    $child = Child::factory()->forUser($user)->create();

    expect($this->childService->destroy($child))->toBeTrue();
    expect($this->childService->destroy($child))->toBeFalse();
});
