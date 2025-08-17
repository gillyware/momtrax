<?php

declare(strict_types=1);

use App\Contracts\Child\FeedingServiceInterface;
use App\Enums\FeedingType;
use App\Enums\MomTraxChildFeature;
use App\Models\Child;
use App\Models\Feeding;
use App\Models\User;
use App\Packets\Child\PersistFeedingPacket;
use Gillyware\Gatekeeper\Facades\Gatekeeper;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertModelExists;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->child = Child::factory()->forUser($this->user)->create();

    $this->feedingService = resolve(FeedingServiceInterface::class);
});

test('create() persists feeding while preferring start time', function () {
    $feedingType = FeedingType::random();
    $total = fake()->numberBetween(0, 400);
    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $packet = PersistFeedingPacket::from([
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ]);

    /** @var Feeding $feeding */
    $feeding = $this->feedingService->create($this->child, $packet);

    assertModelExists($feeding);

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

test('create() persists feeding while preferring end time', function () {
    Gatekeeper::systemActor()->denyFeatureFromModel($this->child, MomTraxChildFeature::FeedingPreferStartTime);

    $feedingType = FeedingType::random();
    $total = fake()->numberBetween(0, 400);
    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $packet = PersistFeedingPacket::from([
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ]);

    /** @var Feeding $feeding */
    $feeding = $this->feedingService->create($this->child, $packet);

    assertModelExists($feeding);

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

test('update() updates feeding while preferring start time', function () {
    $feeding = Feeding::factory()->forChild($this->child)->create();

    $feedingType = FeedingType::random();
    $total = fake()->numberBetween(0, 400);
    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $packet = PersistFeedingPacket::from([
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ]);

    $this->feedingService->update($feeding, $packet);

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

test('update() updates feeding while preferring end time', function () {
    $feeding = Feeding::factory()->forChild($this->child)->create();

    Gatekeeper::systemActor()->denyFeatureFromModel($this->child, MomTraxChildFeature::FeedingPreferStartTime);

    $feedingType = FeedingType::random();
    $total = fake()->numberBetween(0, 400);
    $duration = fake()->numberBetween(0, 60);
    $dateTime = now()->addMinutes(fake()->numberBetween(0, 20))->setSecond(0);

    $packet = PersistFeedingPacket::from([
        'feeding_type' => $feedingType->value,
        'total_amount' => $total,
        'duration_in_minutes' => $duration,
        'notes' => $notes = fake()->text(),
        'date_time' => $dateTime->format('Y-m-d H:i'),
    ]);

    $feeding = $this->feedingService->update($feeding, $packet);

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

test('destroy() deletes feeding', function () {
    $feeding = Feeding::factory()->forChild($this->child)->create();

    expect($this->feedingService->destroy($feeding))->toBeTrue();

    assertDatabaseMissing((new Feeding)->getTable(), ['id' => $feeding->id]);
});

test('destroy() called twice returns false on second attempt', function () {
    $feeding = Feeding::factory()->forChild($this->child)->create();

    expect($this->feedingService->destroy($feeding))->toBeTrue();
    expect($this->feedingService->destroy($feeding))->toBeFalse();
});
