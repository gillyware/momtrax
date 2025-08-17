<?php

declare(strict_types=1);

use App\Enums\FeedingType;
use App\Enums\MomTraxChildFeature;
use App\Models\Child;
use App\Models\Feeding;
use App\Models\User;
use Gillyware\Gatekeeper\Facades\Gatekeeper;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->child = Child::factory()->forUser($this->user)->create();
    $this->actingAs($this->user);
});

// test('index feeding screen can be rendered', function () {
//     $this->get(route('children.feedings.index', [
//         'child' => $this->child->uuid,
//     ]))->assertStatus(200);
// });

// test('create feeding screen can be rendered', function () {
//     $this->get(route('children.feedings.create', [
//         'child' => $this->child->uuid,
//     ]))->assertStatus(200);
// });

test('feedings can be stored while preferring start time', function () {
    $feedingType = FeedingType::random();
    $total = fake()->numberBetween(0, 400);
    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $this->post(route('children.feedings.store', [
        'child' => $this->child->uuid,
    ]), [
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ])->assertRedirect(route('children.feedings.index', [
        'child' => $this->child->uuid,
    ]));

    assertDatabaseHas((new Feeding)->getTable(), [
        'child_id' => $this->child->id,
        'unit' => $this->user->settings->milk_unit,
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->toDateTimeString(),
        'end_date_time' => $dateTime->copy()->addMinutes($duration)->toDateTimeString(),
    ]);
});

test('feedings can be stored while preferring end time', function () {
    Gatekeeper::systemActor()->denyFeatureFromModel($this->child, MomTraxChildFeature::FeedingPreferStartTime);

    $feedingType = FeedingType::random();
    $total = fake()->numberBetween(0, 400);
    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $this->post(route('children.feedings.store', [
        'child' => $this->child->uuid,
    ]), [
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ])->assertRedirect(route('children.feedings.index', [
        'child' => $this->child->uuid,
    ]));

    assertDatabaseHas((new Feeding)->getTable(), [
        'child_id' => $this->child->id,
        'unit' => $this->user->settings->milk_unit,
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->copy()->subMinutes($duration)->toDateTimeString(),
        'end_date_time' => $dateTime->toDateTimeString(),
    ]);
});

test('feedings can be updated while preferring start time', function () {
    $feeding = Feeding::factory()->forChild($this->child)->create();

    $feedingType = FeedingType::random();
    $total = fake()->numberBetween(0, 400);
    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $this->put(route('children.feedings.update', [
        'child' => $this->child->uuid,
        'feeding' => $feeding->id,
    ]), [
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ])->assertRedirect(route('children.feedings.index', [
        'child' => $this->child->uuid,
    ]));

    assertDatabaseHas((new Feeding)->getTable(), [
        'child_id' => $this->child->id,
        'unit' => $this->user->settings->milk_unit,
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->toDateTimeString(),
        'end_date_time' => $dateTime->copy()->addMinutes($duration)->toDateTimeString(),
    ]);
});

test('feedings can be updated while preferring end time', function () {
    $feeding = Feeding::factory()->forChild($this->child)->create();

    Gatekeeper::systemActor()->denyFeatureFromModel($this->child, MomTraxChildFeature::FeedingPreferStartTime);

    $feedingType = FeedingType::random();
    $total = fake()->numberBetween(0, 400);
    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $this->put(route('children.feedings.update', [
        'child' => $this->child->uuid,
        'feeding' => $feeding->id,
    ]), [
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ])->assertRedirect(route('children.feedings.index', [
        'child' => $this->child->uuid,
    ]));

    assertDatabaseHas((new Feeding)->getTable(), [
        'child_id' => $this->child->id,
        'unit' => $this->user->settings->milk_unit,
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->copy()->subMinutes($duration)->toDateTimeString(),
        'end_date_time' => $dateTime->toDateTimeString(),
    ]);
});

test('feedings can be deleted', function () {
    $feeding = Feeding::factory()->forChild($this->child)->create();

    $this->delete(route('children.feedings.destroy', [
        'child' => $this->child->uuid,
        'feeding' => $feeding->id,
    ]))->assertRedirect(route('children.feedings.index', [
        'child' => $this->child->uuid,
    ]));

    assertDatabaseMissing((new Feeding)->getTable(), [
        'id' => $feeding->id,
    ]);
});
