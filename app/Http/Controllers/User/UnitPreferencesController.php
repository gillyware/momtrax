<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Contracts\User\UserSettingServiceInterface;
use App\Http\Controllers\Controller;
use App\Packets\UserSettings\UpdateUnitPreferencesPacket;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class UnitPreferencesController extends Controller
{
    public function __construct(private readonly UserSettingServiceInterface $userSettingService) {}

    /**
     * Show the user's unit preferences settings page.
     */
    public function edit(): Response
    {
        return Inertia::render('users/settings/units');
    }

    /**
     * Update the user's unit preferences.
     */
    public function update(UpdateUnitPreferencesPacket $updateUnitPreferencesPacket): RedirectResponse
    {
        $this->userSettingService->update(user()->settings, $updateUnitPreferencesPacket);

        return to_route('settings.units.edit');
    }
}
