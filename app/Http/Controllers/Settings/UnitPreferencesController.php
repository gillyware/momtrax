<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Packets\UserSettings\UpdateUnitPreferencesPacket;
use App\Services\UserSettingService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class UnitPreferencesController extends Controller
{
    public function __construct(private readonly UserSettingService $userSettingService) {}

    /**
     * Show the user's unit preferences settings page.
     */
    public function edit(): Response
    {
        return Inertia::render('settings/units');
    }

    /**
     * Update the user's unit preferences.
     */
    public function update(UpdateUnitPreferencesPacket $updateUnitPreferencesPacket): RedirectResponse
    {
        $this->userSettingService->updateUnitPreferences(user()->settings, $updateUnitPreferencesPacket);

        return to_route('units.edit');
    }
}
