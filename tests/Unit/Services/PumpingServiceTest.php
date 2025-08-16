<?php

declare(strict_types=1);

use App\Contracts\PumpingServiceInterface;
use App\Enums\MomTraxUserFeature;
use App\Models\Pumping;
use App\Models\User;
use App\Packets\Pumping\PersistPumpingPacket;
use Gillyware\Gatekeeper\Facades\Gatekeeper;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertModelExists;

beforeEach(function () {
    $this->pumpingService = resolve(PumpingServiceInterface::class);
});

test('create() persists pumping while preferring start time', function () {
    $user = User::factory()->create();

    [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()
        ->addMinutes(fake()->numberBetween(0, 20))
        ->setSecond(0);

    $packet = PersistPumpingPacket::from([
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ]);

    /** @var Pumping $pumping */
    $pumping = $this->pumpingService->create($user, $packet);

    assertModelExists($pumping);

    assertDatabaseHas((new Pumping)->getTable(), [
        'user_id' => $user->id,
        'unit' => $user->settings->milk_unit,
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->toDateTimeString(),
        'end_date_time' => $dateTime->copy()->addMinutes($duration)->toDateTimeString(),
    ]);
});

test('create() persists pumping while preferring end time', function () {
    $user = User::factory()->create();

    Gatekeeper::systemActor()->denyFeatureFromModel($user, MomTraxUserFeature::PumpingPreferStartTime);

    [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()
        ->addMinutes(fake()->numberBetween(0, 20))
        ->setSecond(0);

    $packet = PersistPumpingPacket::from([
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ]);

    /** @var Pumping $pumping */
    $pumping = $this->pumpingService->create($user, $packet);

    assertModelExists($pumping);

    assertDatabaseHas((new Pumping)->getTable(), [
        'user_id' => $user->id,
        'unit' => $user->settings->milk_unit,
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->copy()->subMinutes($duration)->toDateTimeString(),
        'end_date_time' => $dateTime->toDateTimeString(),
    ]);
});

test('update() updates pumping while preferring start time', function () {
    $user = User::factory()->create();
    $pumping = Pumping::factory()->forUser($user)->create();

    [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()
        ->addMinutes(fake()->numberBetween(0, 20))
        ->setSecond(0);

    $packet = PersistPumpingPacket::from([
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ]);

    $this->pumpingService->update($pumping, $packet);

    assertDatabaseHas((new Pumping)->getTable(), [
        'user_id' => $user->id,
        'unit' => $user->settings->milk_unit,
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->toDateTimeString(),
        'end_date_time' => $dateTime->copy()->addMinutes($duration)->toDateTimeString(),
    ]);
});

test('update() updates pumping while preferring end time', function () {
    $user = User::factory()->create();
    $pumping = Pumping::factory()->forUser($user)->create();

    Gatekeeper::systemActor()->denyFeatureFromModel($user, MomTraxUserFeature::PumpingPreferStartTime);

    [$left, $right] = [fake()->numberBetween(0, 200), fake()->numberBetween(0, 200)];

    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()
        ->addMinutes(fake()->numberBetween(0, 20))
        ->setSecond(0);

    $packet = PersistPumpingPacket::from([
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ]);

    $pumping = $this->pumpingService->update($pumping, $packet);

    assertDatabaseHas((new Pumping)->getTable(), [
        'user_id' => $user->id,
        'unit' => $user->settings->milk_unit,
        'left_breast_amount' => $left,
        'right_breast_amount' => $right,
        'total_amount' => $left + $right,
        'duration_in_minutes' => $duration,
        'notes' => $notes,
        'start_date_time' => $dateTime->copy()->subMinutes($duration)->toDateTimeString(),
        'end_date_time' => $dateTime->toDateTimeString(),
    ]);
});

test('destroy() deletes pumping', function () {
    $user = User::factory()->create();
    $pumping = Pumping::factory()->forUser($user)->create();

    expect($this->pumpingService->destroy($pumping))->toBeTrue();

    assertDatabaseMissing((new Pumping)->getTable(), ['id' => $pumping->id]);
});

test('destroy() called twice returns false on second attempt', function () {
    $user = User::factory()->create();
    $pumping = Pumping::factory()->forUser($user)->create();

    expect($this->pumpingService->destroy($pumping))->toBeTrue();
    expect($this->pumpingService->destroy($pumping))->toBeFalse();
});
