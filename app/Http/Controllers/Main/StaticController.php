<?php

declare(strict_types=1);

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

final class StaticController extends Controller
{
    public function welcome(): InertiaResponse
    {
        return Inertia::render('main/welcome');
    }

    public function termsOfService(): InertiaResponse
    {
        return Inertia::render('main/legal/terms');
    }

    public function privacyPolicy(): InertiaResponse
    {
        return Inertia::render('main/legal/privacy');
    }
}
