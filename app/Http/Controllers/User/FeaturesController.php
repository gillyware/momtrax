<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Contracts\User\UserServiceInterface;
use App\Http\Controllers\Controller;
use App\Packets\User\UpdateUserFeaturePacket;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class FeaturesController extends Controller
{
    public function __construct(private readonly UserServiceInterface $userService) {}

    /**
     * Show the user's feature settings page.
     */
    public function edit(): Response
    {
        return Inertia::render('users/settings/features');
    }

    /**
     * Update the user's feature settings.
     */
    public function update(UpdateUserFeaturePacket $updateUserFeaturePacket): RedirectResponse
    {
        $this->userService->updateFeature(user(), $updateUserFeaturePacket);

        return to_route('settings.features.edit');
    }
}
