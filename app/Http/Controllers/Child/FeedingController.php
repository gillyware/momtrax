<?php

declare(strict_types=1);

namespace App\Http\Controllers\Child;

use App\Contracts\Child\FeedingServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

final class FeedingController extends Controller
{
    public function __construct(private readonly FeedingServiceInterface $feedingService) {}

    /**
     * Feedings index.
     */
    public function index(): Response
    {
        return Inertia::render('feedings/index');
    }

    /**
     * Add a feeding entry.
     */
    public function create(): Response
    {
        return Inertia::render('feedings/create');
    }

    public function store(): RedirectResponse
    {
        $this->feedingService->create(user());

        return redirect()->to('/feedings');
    }
}
