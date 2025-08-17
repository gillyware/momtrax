<?php

declare(strict_types=1);

use App\Models\Child;
use App\Models\Sleeping;
use App\Models\User;
use Carbon\Carbon;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->child = Child::factory()->forUser($this->user)->create();
    $this->actingAs($this->user);
});

// test('index sleeping screen can be rendered', function () {
//     $this->get(route('children.sleepings.index', [
//         'child' => $this->child->uuid,
//     ]))->assertStatus(200);
// });

// test('create sleeping screen can be rendered', function () {
//     $this->get(route('children.sleepings.create', [
//         'child' => $this->child->uuid,
//     ]))->assertStatus(200);
// });

test('sleepings can be stored', function () {
    $duration = fake()->numberBetween(0, 60);
    $startDateTime = Carbon::parse(fake()->dateTime())->setSecond(0);
    $endDateTime = $startDateTime->copy()->addMinutes($duration);

    $this->post(route('children.sleepings.store', [
        'child' => $this->child->uuid,
    ]), [
        'start_date_time' => $startDateTime->format('Y-m-d H:i'),
        'end_date_time' => $endDateTime->format('Y-m-d H:i'),
        'notes' => $notes = fake()->text(),
    ])->assertRedirect(route('children.sleepings.index', [
        'child' => $this->child->uuid,
    ]));

    assertDatabaseHas((new Sleeping)->getTable(), [
        'child_id' => $this->child->id,
        'start_date_time' => $startDateTime->toDateTimeString(),
        'end_date_time' => $endDateTime->toDateTimeString(),
        'notes' => $notes,
    ]);
});

test('sleepings can be updated while preferring start time', function () {
    $sleeping = Sleeping::factory()->forChild($this->child)->create();

    $duration = fake()->numberBetween(0, 60);
    $startDateTime = Carbon::parse(fake()->dateTime())->setSecond(0);
    $endDateTime = $startDateTime->copy()->addMinutes($duration);

    $this->put(route('children.sleepings.update', [
        'child' => $this->child->uuid,
        'sleeping' => $sleeping->id,
    ]), [
        'start_date_time' => $startDateTime->format('Y-m-d H:i'),
        'end_date_time' => $endDateTime->format('Y-m-d H:i'),
        'notes' => $notes = fake()->text(),
    ])->assertRedirect(route('children.sleepings.index', [
        'child' => $this->child->uuid,
    ]));

    assertDatabaseHas((new Sleeping)->getTable(), [
        'child_id' => $this->child->id,
        'start_date_time' => $startDateTime->toDateTimeString(),
        'end_date_time' => $endDateTime->toDateTimeString(),
        'notes' => $notes,
    ]);
});

test('sleepings can be deleted', function () {
    $sleeping = Sleeping::factory()->forChild($this->child)->create();

    $this->delete(route('children.sleepings.destroy', [
        'child' => $this->child->uuid,
        'sleeping' => $sleeping->id,
    ]))->assertRedirect(route('children.sleepings.index', [
        'child' => $this->child->uuid,
    ]));

    assertDatabaseMissing((new Sleeping)->getTable(), [
        'id' => $sleeping->id,
    ]);
});
