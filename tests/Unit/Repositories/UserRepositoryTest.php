<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\UserSetting;
use App\Packets\Users\StoreUserPacket;
use App\Packets\Users\UpdateUserProfilePacket;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertModelExists;

beforeEach(function () {
    $this->userRepository = resolve(UserRepository::class);
});

test('create() persists user with hashed password and uuid then creates user settings', function () {
    $password = fake()->password(12);

    $packet = StoreUserPacket::from([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'nickname' => fake()->firstName(),
        'email' => fake()->safeEmail(),
        'password' => $password,
        'password_confirmation' => $password,
        'timezone' => fake()->timezone(),
    ]);

    $user = $this->userRepository->create($packet);

    $packetData = collect($packet->toArray());

    assertModelExists($user);

    assertDatabaseHas((new User)->getTable(), $packetData->except(['password', 'timezone'])->toArray());

    expect(Hash::check($password, $user->password))->toBeTrue();

    expect($user->uuid)->toBeUuid();

    assertDatabaseHas((new UserSetting)->getTable(), [
        'user_id' => $user->id,
    ]);
});

test('updateProfile() updates profile fields and keeps password and uuid unchanged', function () {
    $user = User::factory()->create();

    $originalUuid = $user->uuid;
    $originalHash = $user->password;

    $updatePacket = UpdateUserProfilePacket::from([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'nickname' => fake()->firstName(),
        'email' => fake()->safeEmail(),
    ]);

    $updatedUser = $this->userRepository->updateProfile($user, $updatePacket);

    expect($updatedUser->first_name)->toBe($updatePacket->firstName)
        ->and($updatedUser->last_name)->toBe($updatePacket->lastName)
        ->and($updatedUser->nickname)->toBe($updatePacket->nickname)
        ->and($updatedUser->email)->toBe($updatePacket->email);

    expect($updatedUser->uuid)->toBe($originalUuid);
    expect($updatedUser->password)->toBe($originalHash);

    assertDatabaseHas((new User)->getTable(), [
        'id' => $user->id,
        'uuid' => $originalUuid,
        'password' => $originalHash,
        'first_name' => $updatePacket->firstName,
        'last_name' => $updatePacket->lastName,
        'nickname' => $updatePacket->nickname,
        'email' => $updatePacket->email,
    ]);
});

test('destroy() deletes user and settings and returns true', function () {
    $user = User::factory()->create();

    $result = $this->userRepository->destroy($user);

    expect($result)->toBeTrue();

    assertDatabaseMissing((new User)->getTable(), ['id' => $user->id]);

    assertDatabaseMissing((new UserSetting)->getTable(), ['user_id' => $user->id]);
});

test('destroy() called twice returns false on second attempt', function () {
    $user = User::factory()->create();

    expect($this->userRepository->destroy($user))->toBeTrue();
    expect($this->userRepository->destroy($user))->toBeFalse();
});
