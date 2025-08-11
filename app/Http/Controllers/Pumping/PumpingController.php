<?php

declare(strict_types=1);

namespace App\Http\Controllers\Pumping;

use App\Http\Controllers\Controller;
use App\Models\Pumping;
use App\Packets\Pumping\PersistPumpingPacket;
use App\Services\PumpingService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class PumpingController extends Controller
{
    public function __construct(private readonly PumpingService $pumpingService) {}

    /**
     * Pumping index.
     */
    public function index(): Response
    {
        return Inertia::render('pumpings/index');
    }

    /**
     * Add a pumping entry.
     */
    public function create(): Response
    {
        return Inertia::render('pumpings/create');
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
        return Inertia::render('pumpings/edit');
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
