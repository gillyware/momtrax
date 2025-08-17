<?php

declare(strict_types=1);

namespace App\Packets\User;

use App\Enums\MomTraxUserFeature;
use Gillyware\Postal\Attributes\Field;
use Gillyware\Postal\Attributes\Rule;
use Gillyware\Postal\Packet;
use Illuminate\Validation\Rule as ValidationRule;

final class UpdateUserFeaturePacket extends Packet
{
    public readonly MomTraxUserFeature $featureName;

    public function __construct(
        #[Field('feature_name'), Rule(['required', 'string'])]
        string $featureName,
        #[Rule(['required', 'boolean'])]
        public readonly bool $enabled,
    ) {
        $this->featureName = MomTraxUserFeature::from($featureName);
    }

    protected static function explicitRules(): array
    {
        return [
            'feature_name' => [ValidationRule::in(MomTraxUserFeature::values())],
        ];
    }
}
