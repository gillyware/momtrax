<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\MomTraxChildFeature;
use App\Enums\MomTraxUserFeature;
use Gillyware\Gatekeeper\Facades\Gatekeeper;
use Illuminate\Database\Seeder;

final class MomTraxFeaturesSeeder extends Seeder
{
    public function run()
    {
        $features = array_merge(
            MomTraxUserFeature::all(),
            MomTraxChildFeature::all(),
        );

        Gatekeeper::systemActor();

        foreach ($features as $feature) {
            Gatekeeper::createFeature($feature);
            Gatekeeper::grantFeatureByDefault($feature);
        }
    }
}
