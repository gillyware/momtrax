<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

final class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::middleware('web')->group(function () {
            $this->requireRoutesIn(base_path('routes/web'));
        });

        Route::prefix('api')->middleware('api')->group(function () {
            $this->requireRoutesIn(base_path('routes/api'));
        });
    }

    protected function requireRoutesIn(string $dir): void
    {
        if (! is_dir($dir)) {
            return;
        }

        $files = glob($dir.'/*.php') ?: [];
        sort($files);

        foreach ($files as $file) {
            require $file;
        }
    }
}
