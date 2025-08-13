<?php

declare(strict_types=1);

use App\Enums\MomTraxUserFeature;
use App\Models\Pumping;
use App\Models\User;
use App\Models\UserSetting;
use App\Packets\Users\StoreUserPacket;
use App\Packets\Users\UpdateUserFeaturePacket;
use App\Packets\Users\UpdateUserProfilePacket;
use App\Services\UserService;
use Gillyware\Gatekeeper\Facades\Gatekeeper;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\assertModelExists;

beforeEach(function () {
    $this->userService = resolve(UserService::class);
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
        'timezone' => $timezone = fake()->timezone(),
    ]);

    $user = $this->userService->create($packet);

    $packetData = collect($packet->toArray());

    assertModelExists($user);

    assertDatabaseHas((new User)->getTable(), $packetData->except(['password', 'timezone'])->toArray());

    expect(Hash::check($password, $user->password))->toBeTrue();

    expect($user->uuid)->toBeUuid();

    assertDatabaseHas((new UserSetting)->getTable(), [
        'user_id' => $user->id,
        'timezone' => $timezone,
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

    $updatedUser = $this->userService->updateProfile($user, $updatePacket);

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

test('updateFeature() toggles the feature', function () {
    $user = User::factory()->create();

    Gatekeeper::setActor($user);

    $updatePacket = UpdateUserFeaturePacket::from([
        'feature_name' => $featureName = MomTraxUserFeature::random()->value,
        'enabled' => $enabled = fake()->boolean(),
    ]);

    $updatedUser = $this->userService->updateFeature($user, $updatePacket);

    expect($updatedUser->hasFeature($featureName))->toBe($enabled);
});

test('destroy() deletes user, settings, and pumpings', function () {
    $user = User::factory()->create();
    $pumpings = Pumping::factory()->forUser($user)->count(10)->create();

    $result = $this->userService->destroy($user);

    expect($result)->toBeTrue();

    assertDatabaseMissing((new User)->getTable(), ['id' => $user->id]);

    assertDatabaseMissing((new UserSetting)->getTable(), ['user_id' => $user->id]);

    assertDatabaseMissing((new Pumping)->getTable(), ['user_id' => $user->id]);
});

test('destroy() called twice returns false on second attempt', function () {
    $user = User::factory()->create();

    expect($this->userService->destroy($user))->toBeTrue();
    expect($this->userService->destroy($user))->toBeFalse();
});
