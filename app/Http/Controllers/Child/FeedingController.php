<?php

declare(strict_types=1);

namespace App\Http\Controllers\Child;

use App\Contracts\Child\FeedingServiceInterface;
use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Models\Feeding;
use App\Packets\Child\PersistFeedingPacket;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class FeedingController extends Controller
{
    public function __construct(private readonly FeedingServiceInterface $feedingService) {}

    /**
     * Feeding index.
     */
    public function index(): Response
    {
        return Inertia::render('children/feedings/index');
    }

    /**
     * Add a feeding entry.
     */
    public function create(): Response
    {
        return Inertia::render('children/feedings/create');
    }

    /**
     * Store a feeding entry.
     */
    public function store(Child $child, PersistFeedingPacket $persistFeedingPacket): RedirectResponse
    {
        $this->feedingService->create($child, $persistFeedingPacket);

        return to_route('children.feedings.index', ['child' => $child->uuid]);
    }

    /**
     * Show a feeding entry.
     */
    public function edit(Feeding $feeding): Response
    {
        return Inertia::render('children/feedings/edit');
    }

    /**
     * Update a feeding entry.
     */
    public function update(Child $child, Feeding $feeding, PersistFeedingPacket $persistFeedingPacket): RedirectResponse
    {
        $this->feedingService->update($feeding, $persistFeedingPacket);

        return to_route('children.feedings.index', ['child' => $child->uuid]);
    }

    /**
     * Destroy a feeding entry.
     */
    public function destroy(Child $child, Feeding $feeding): RedirectResponse
    {
        $this->feedingService->destroy($feeding);

        return to_route('children.feedings.index', ['child' => $child->uuid]);
    }
}
