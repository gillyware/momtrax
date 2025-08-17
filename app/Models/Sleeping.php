<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\SleepingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id // PK
 * @property int $child_id
 * @property Carbon $start_date_time
 * @property Carbon $end_date_time
 * @property string|null $notes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Child|null $child
 */
final class Sleeping extends Model
{
    /** @use HasFactory<SleepingFactory> */
    use HasFactory;

    protected $table = 'sleepings';

    protected $fillable = [
        'child_id',
        'start_date_time',
        'end_date_time',
        'notes',
    ];

    public function child(): BelongsTo
    {
        return $this->belongsTo(Child::class);
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
