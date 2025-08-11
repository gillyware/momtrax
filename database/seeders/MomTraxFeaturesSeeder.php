<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MomTraxFeature;
use Gillyware\Gatekeeper\Facades\Gatekeeper;
use Illuminate\Database\Seeder;

final class MomTraxFeaturesSeeder extends Seeder
{
    public function run()
    {
        $features = MomTraxFeature::all();

        Gatekeeper::systemActor();

        foreach ($features as $feature) {
            Gatekeeper::createFeature($feature);
            Gatekeeper::grantFeatureByDefault($feature);
        }
    }
}
