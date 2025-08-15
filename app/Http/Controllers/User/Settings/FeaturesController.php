<?php

declare(strict_types=1);

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use App\Packets\Users\UpdateUserFeaturePacket;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class FeaturesController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * Show the user's feature settings page.
     */
    public function edit(): Response
    {
        return Inertia::render('settings/features');
    }

    /**
     * Update the user's feature settings.
     */
    public function update(UpdateUserFeaturePacket $updateUserFeaturePacket): RedirectResponse
    {
        $this->userService->updateFeature(user(), $updateUserFeaturePacket);

        return to_route('features.edit');
    }
}
