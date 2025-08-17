<?php

declare(strict_types=1);

use App\Contracts\Child\SleepingServiceInterface;
use App\Models\Child;
use App\Models\Sleeping;
use App\Models\User;
use App\Packets\Child\PersistSleepingPacket;
use Carbon\Carbon;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertModelExists;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->child = Child::factory()->forUser($this->user)->create();

    $this->sleepingService = resolve(SleepingServiceInterface::class);
});

test('create() persists sleeping', function () {
    $duration = fake()->numberBetween(0, 60);
    $startDateTime = Carbon::parse(fake()->dateTime())->setSecond(0);
    $endDateTime = $startDateTime->copy()->addMinutes($duration);

    $packet = PersistSleepingPacket::from([
        'start_date_time' => $startDateTime->format('Y-m-d H:i'),
        'end_date_time' => $endDateTime->format('Y-m-d H:i'),
        'notes' => $notes = fake()->text(),
    ]);

    /** @var Sleeping $sleeping */
    $sleeping = $this->sleepingService->create($this->child, $packet);

    assertModelExists($sleeping);

    assertDatabaseHas((new Sleeping)->getTable(), [
        'child_id' => $this->child->id,
        'start_date_time' => $startDateTime->toDateTimeString(),
        'end_date_time' => $endDateTime->toDateTimeString(),
        'notes' => $notes,
    ]);
});

test('update() updates sleeping', function () {
    $sleeping = Sleeping::factory()->forChild($this->child)->create();

    $duration = fake()->numberBetween(0, 60);
    $startDateTime = Carbon::parse(fake()->dateTime())->setSecond(0);
    $endDateTime = $startDateTime->copy()->addMinutes($duration);

    $packet = PersistSleepingPacket::from([
        'start_date_time' => $startDateTime->format('Y-m-d H:i'),
        'end_date_time' => $endDateTime->format('Y-m-d H:i'),
        'notes' => $notes = fake()->text(),
    ]);

    $this->sleepingService->update($sleeping, $packet);

    assertDatabaseHas((new Sleeping)->getTable(), [
        'child_id' => $this->child->id,
        'start_date_time' => $startDateTime->toDateTimeString(),
        'end_date_time' => $endDateTime->toDateTimeString(),
        'notes' => $notes,
    ]);
});

test('destroy() deletes sleeping', function () {
    $sleeping = Sleeping::factory()->forChild($this->child)->create();

    expect($this->sleepingService->destroy($sleeping))->toBeTrue();

    assertDatabaseMissing((new Sleeping)->getTable(), ['id' => $sleeping->id]);
});

test('destroy() called twice returns false on second attempt', function () {
    $sleeping = Sleeping::factory()->forChild($this->child)->create();

    expect($this->sleepingService->destroy($sleeping))->toBeTrue();
    expect($this->sleepingService->destroy($sleeping))->toBeFalse();
});
