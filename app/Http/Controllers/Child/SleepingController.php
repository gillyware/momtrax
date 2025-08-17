<?php

declare(strict_types=1);

namespace App\Http\Controllers\Child;

use App\Contracts\Child\SleepingServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Sleeping;
use App\Packets\Child\PersistSleepingPacket;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class SleepingController extends Controller
{
    public function __construct(private readonly SleepingServiceInterface $sleepingService) {}

    /**
     * Sleeping index.
     */
    public function index(): Response
    {
        return Inertia::render('children/sleepings/index');
    }

    /**
     * Add a sleeping entry.
     */
    public function create(): Response
    {
        return Inertia::render('children/sleepings/create');
    }

    /**
     * Store a sleeping entry.
     */
    public function store(Child $child, PersistSleepingPacket $persistSleepingPacket): RedirectResponse
    {
        $this->sleepingService->create($child, $persistSleepingPacket);

        return to_route('children.sleepings.index', ['child' => $child->uuid]);
    }

    /**
     * Show a sleeping entry.
     */
    public function edit(Sleeping $sleeping): Response
    {
        return Inertia::render('children/sleepings/edit');
    }

    /**
     * Update a sleeping entry.
     */
    public function update(Child $child, Sleeping $sleeping, PersistSleepingPacket $persistSleepingPacket): RedirectResponse
    {
        $this->sleepingService->update($sleeping, $persistSleepingPacket);

        return to_route('children.sleepings.index', ['child' => $child->uuid]);
    }

    /**
     * Destroy a sleeping entry.
     */
    public function destroy(Child $child, Sleeping $sleeping): RedirectResponse
    {
        $this->sleepingService->destroy($sleeping);

        return to_route('children.sleepings.index', ['child' => $child->uuid]);
    }
}
