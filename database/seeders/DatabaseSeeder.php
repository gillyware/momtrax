<?php

declare(strict_types=1);

namespace Database\Seeders;

use Gillyware\Gatekeeper\Database\Seeders\GatekeeperPermissionsSeeder;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(GatekeeperPermissionsSeeder::class);
        $this->call(MomTraxFeaturesSeeder::class);
    }
}
