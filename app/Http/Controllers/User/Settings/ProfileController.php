<?php

declare(strict_types=1);

namespace App\Http\Controllers\User\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ProfileUpdateRequest;
use App\Packets\Users\UpdateUserProfilePacket;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

final class ProfileController extends Controller
{
    public function __construct(private readonly UserService $userService) {}

    /**
     * Show the user's profile settings page.
     */
    public function edit(): Response
    {
        return Inertia::render('settings/profile');
    }

    /**
     * Update the user's profile settings.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $this->userService->updateProfile(user(), UpdateUserProfilePacket::from($request));

        return to_route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = user();

        Auth::logout();

        if (! $this->userService->destroy($user)) {
            return back();
        }

        session()->invalidate();
        session()->regenerateToken();

        return to_route('home');
    }
}
