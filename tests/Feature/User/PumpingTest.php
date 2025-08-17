<?php

declare(strict_types=1);

use App\Enums\MomTraxUserFeature;
use App\Models\Pumping;
use App\Models\User;
use Gillyware\Gatekeeper\Facades\Gatekeeper;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->actingAs($this->user);
});

test('index pumping screen can be rendered', function () {
    $this->get(route('pumpings.index'))->assertStatus(200);
});

test('create pumping screen can be rendered', function () {
    $this->get(route('pumpings.create'))->assertStatus(200);
});

test('pumpings can be stored while preferring start time', function () {
    [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $this->post(route('pumpings.store'), [
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ])->assertRedirect(route('pumpings.index'));

    assertDatabaseHas((new Pumping)->getTable(), [
        'user_id' => $this->user->id,
        'unit' => $this->user->settings->milk_unit,
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->toDateTimeString(),
        'end_date_time' => $dateTime->copy()->addMinutes($duration)->toDateTimeString(),
    ]);
});

test('pumpings can be stored while preferring end time', function () {
    Gatekeeper::systemActor()->denyFeatureFromModel($this->user, MomTraxUserFeature::PumpingPreferStartTime);

    [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $this->post(route('pumpings.store'), [
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ])->assertRedirect(route('pumpings.index'));

    assertDatabaseHas((new Pumping)->getTable(), [
        'user_id' => $this->user->id,
        'unit' => $this->user->settings->milk_unit,
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->copy()->subMinutes($duration)->toDateTimeString(),
        'end_date_time' => $dateTime->toDateTimeString(),
    ]);
});

test('pumpings can be updated while preferring start time', function () {
    $pumping = Pumping::factory()->forUser($this->user)->create();

    [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $this->put(route('pumpings.update', [
        'pumping' => $pumping->id,
    ]), [
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ])->assertRedirect(route('pumpings.index'));

    assertDatabaseHas((new Pumping)->getTable(), [
        'user_id' => $this->user->id,
        'unit' => $this->user->settings->milk_unit,
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->toDateTimeString(),
        'end_date_time' => $dateTime->copy()->addMinutes($duration)->toDateTimeString(),
    ]);
});

test('pumpings can be updated while preferring end time', function () {
    $pumping = Pumping::factory()->forUser($this->user)->create();

    Gatekeeper::systemActor()->denyFeatureFromModel($this->user, MomTraxUserFeature::PumpingPreferStartTime);

    [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $this->put(route('pumpings.update', [
        'pumping' => $pumping->id,
    ]), [
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ])->assertRedirect(route('pumpings.index'));

    assertDatabaseHas((new Pumping)->getTable(), [
        'user_id' => $this->user->id,
        'unit' => $this->user->settings->milk_unit,
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->copy()->subMinutes($duration)->toDateTimeString(),
        'end_date_time' => $dateTime->toDateTimeString(),
    ]);
});

test('pumpings can be deleted', function () {
    $pumping = Pumping::factory()->forUser($this->user)->create();

    $this->delete(route('pumpings.destroy', [
        'pumping' => $pumping->id,
    ]))->assertRedirect(route('pumpings.index'));

    assertDatabaseMissing((new Pumping)->getTable(), [
        'id' => $pumping->id,
    ]);
});
