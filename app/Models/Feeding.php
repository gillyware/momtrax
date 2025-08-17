<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\FeedingType;
use Carbon\Carbon;
use Database\Factories\FeedingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id // PK
 * @property int $child_id
 * @property FeedingType $feeding_type
 * @property float|int $total_amount
 * @property string $unit
 * @property int|null $duration_in_minutes
 * @property string|null $notes
 * @property Carbon $start_date_time
 * @property Carbon $end_date_time
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Child|null $child
 */
final class Feeding extends Model
{
    /** @use HasFactory<FeedingFactory> */
    use HasFactory;

    protected $table = 'feedings';

    protected $fillable = [
        'child_id',
        'feeding_type',
        'total_amount',
        'unit',
        'duration_in_minutes',
        'notes',
        'start_date_time',
        'end_date_time',
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
    }

    protected function casts(): array
    {
        return [
            'feeding_type' => FeedingType::class,
            'start_date_time' => 'datetime',
            'end_date_time' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
