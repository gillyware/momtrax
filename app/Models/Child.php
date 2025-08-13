<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Gender;
use Carbon\Carbon;
use Database\Factories\ChildFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id // PK
 * @property string $uuid
 * @property int $user_id
 * @property string $name
 * @property Gender $gender
 * @property string|null $pfp_extension
 * @property Carbon $birth_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property User|null $user
 */
final class Child extends Model
{
    /** @use HasFactory<ChildFactory> */
    use HasFactory;

    protected $table = 'children';

    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'birth_date',
        'gender',
        'pfp_extension',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'birth_date' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
