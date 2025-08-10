<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Appearance;
use App\Enums\HeightUnit;
use App\Enums\MilkUnit;
use App\Enums\WeightUnit;
use Carbon\Carbon;
use Database\Factories\UserSettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id // PK
 * @property int $user_id
 * @property MilkUnit $milk_unit
 * @property HeightUnit $height_unit
 * @property WeightUnit $weight_unit
 * @property Appearance $appearance
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class UserSetting extends Model
{
    /** @use HasFactory<UserSettingFactory> */
    use HasFactory;

    protected $table = 'user_settings';

    protected $fillable = [
        'user_id',
        'milk_unit',
        'height_unit',
        'weight_unit',
        'appearance',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'milk_unit' => MilkUnit::class,
            'height_unit' => HeightUnit::class,
            'weight_unit' => WeightUnit::class,
            'appearance' => Appearance::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
