<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class StaticController extends Controller
{
    public function welcome(): InertiaResponse
    {
        return Inertia::render('welcome');
    }

    public function termsOfService(): InertiaResponse
    {
        return Inertia::render('legal/terms');
    }

    public function privacyPolicy(): InertiaResponse
    {
        return Inertia::render('legal/privacy');
    }
}

