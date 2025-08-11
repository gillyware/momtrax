<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\PumpingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id // PK
 * @property int $user_id
 * @property int|float|null $left_breast_amount
 * @property int|float|null $right_breast_amount
 * @property float|int $total_amount
 * @property string $unit
 * @property int|null $duration_in_minutes
 * @property string|null $notes
 * @property Carbon $start_date_time
 * @property Carbon $end_date_time
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User|null $user
 */
final class Pumping extends Model
{
    /** @use HasFactory<PumpingFactory> */
    use HasFactory;

    protected $table = 'pumpings';

    protected $fillable = [
        'user_id',
        'left_breast_amount',
        'right_breast_amount',
        'total_amount',
        'unit',
        'duration_in_minutes',
        'notes',
        'start_date_time',
        'end_date_time',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'start_date_time' => 'datetime',
            'end_date_time' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
