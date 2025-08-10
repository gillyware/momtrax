<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

if (! function_exists('user')) {
    function user(): ?User
    {
        return Auth::user();
    }
}

if (! function_exists('uuidv4')) {
    function uuidv4(): string
    {
        return Str::uuid()->toString();
    }
}
