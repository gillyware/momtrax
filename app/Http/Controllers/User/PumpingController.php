<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Contracts\User\PumpingServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Pumping;
use App\Packets\User\PersistPumpingPacket;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class PumpingController extends Controller
{
    public function __construct(private readonly PumpingServiceInterface $pumpingService) {}

    /**
     * Pumping index.
     */
    public function index(): Response
    {
        return Inertia::render('users/pumpings/index');
    }

    /**
     * Add a pumping entry.
     */
    public function create(): Response
    {
        return Inertia::render('users/pumpings/create');
    }

    /**
     * Store a pumping entry.
     */
    public function store(PersistPumpingPacket $persistPumpingPacket): RedirectResponse
    {
        $this->pumpingService->create(user(), $persistPumpingPacket);

        return to_route('pumpings.index');
    }

    /**
     * Show a pumping entry.
     */
    public function edit(Pumping $pumping): Response
    {
        return Inertia::render('users/pumpings/edit');
    }

    /**
     * Update a pumping entry.
     */
    public function update(Pumping $pumping, PersistPumpingPacket $persistPumpingPacket): RedirectResponse
    {
        $this->pumpingService->update($pumping, $persistPumpingPacket);

        return to_route('pumpings.index');
    }

    /**
     * Destroy a pumping entry.
     */
    public function destroy(Pumping $pumping): RedirectResponse
    {
        $this->pumpingService->destroy($pumping);

        return to_route('pumpings.index');
    }
}
