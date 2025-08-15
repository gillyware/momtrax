<?php

declare(strict_types=1);

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use App\Models\Child;
use App\Packets\Child\PersistChildPacket;
use App\Services\ChildService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class ChildController extends Controller
{
    public function __construct(private readonly ChildService $childService) {}

    /**
     * Children index.
     */
    public function index(): Response
    {
        return Inertia::render('children/index');
    }

    /**
     * Add a child entry.
     */
    public function create(): Response
    {
        return Inertia::render('children/create');
    }

    /**
     * Store a child entry.
     */
    public function store(PersistChildPacket $persistChildPacket): RedirectResponse
    {
        $this->childService->create(user(), $persistChildPacket);

        return to_route('children.index');
    }

    /**
     * Show a child entry.
     */
    public function edit(Child $child): Response
    {
        return Inertia::render('children/edit');
    }

    /**
     * Update a child profile.
     */
    public function update(Child $child, PersistChildPacket $persistChildPacket): RedirectResponse
    {
        $this->childService->updateProfile($child, $persistChildPacket);

        return to_route('children.index');
    }

    /**
     * Destroy a child entry.
     */
    public function destroy(Child $child): RedirectResponse
    {
        $this->childService->destroy($child);

        return to_route('children.index');
    }
}
