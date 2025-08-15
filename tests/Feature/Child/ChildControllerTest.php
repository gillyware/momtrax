<?php

declare(strict_types=1);

use App\Enums\Gender;
use App\Models\Child;
use App\Models\User;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

// test('index children screen can be rendered', function () {
//     $this->get(route('children.index'))->assertStatus(200);
// });

// test('create child screen can be rendered', function () {
//     $this->get(route('children.create'))->assertStatus(200);
// });

test('children can be stored', function () {
    $birthDate = now()
        ->subDays(fake()->numberBetween(0, 20))
        ->subMinutes(fake()->numberBetween(0, 20));

    $this->post(route('children.store'), [
        'name' => $name = fake()->name(),
        'birth_date' => $birthDate->format('Y-m-d H:i'),
        'gender' => $gender = Gender::random()->value,
    ])->assertRedirect(route('children.index'));

    $child = Child::latest()->first();

    expect($child->uuid)->toBeUuid();

    assertDatabaseHas((new Child)->getTable(), [
        'user_id' => $this->user->id,
        'name' => $name,
        'birth_date' => $birthDate->setSecond(0)->toDateTimeString(),
        'gender' => $gender,
    ]);
});

test('children profiles can be updated', function () {
    $user = User::factory()->create();
    $child = Child::factory()->forUser($user)->create();

    $birthDate = now()
        ->subDays(fake()->numberBetween(0, 20))
        ->subMinutes(fake()->numberBetween(0, 20))
        ->setSecond(0);

    $this->put(route('children.update', ['child' => $child->uuid]), [
        'name' => $name = fake()->name(),
        'birth_date' => $birthDate->format('Y-m-d H:i'),
        'gender' => $gender = Gender::random()->value,
    ])->assertRedirect(route('children.index'));

    $child = Child::latest()->first();

    expect($child->user->id)->toBe($user->id)
        ->and($child->name)->toBe($name)
        ->and($child->birth_date->toDateTimeString())->toBe($birthDate->toDateTimeString())
        ->and($child->gender->value)->toBe($gender);
});

test('children can be deleted', function () {
    $child = Child::factory()->forUser($this->user)->create();

    $this->delete(route('children.destroy', [
        'child' => $child->uuid,
    ]))->assertRedirect(route('children.index'));

    assertDatabaseMissing((new Child)->getTable(), [
        'id' => $child->id,
    ]);
});
