<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Packets\UserSettings\UpdateLocalizationPacket;
use App\Services\UserSettingService;
use Gillyware\Atlas\Facades\Atlas;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class LocalizationController extends Controller
{
    public function __construct(private readonly UserSettingService $userSettingService) {}

    /**
     * Show the user's localization settings page.
     */
    public function edit(): Response
    {
        /** @phpstan-ignore-next-line */
        $timezoneNames = Atlas::timezones()->all()->keys();

        return Inertia::render('settings/localization', [
            'timezoneNames' => $timezoneNames,
        ]);
    }

    /**
     * Update the user's localization.
     */
    public function update(UpdateLocalizationPacket $updateLocalizationPacket): RedirectResponse
    {
        $this->userSettingService->update(user()->settings, $updateLocalizationPacket);

        return to_route('localization.edit');
    }
}
