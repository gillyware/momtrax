<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;

if (!function_exists("user")) {
    function user(): ?User
    {
        return Auth::user();
    }
}
