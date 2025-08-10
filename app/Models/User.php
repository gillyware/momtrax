<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Gillyware\Gatekeeper\Traits\HasFeatures;
use Gillyware\Gatekeeper\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property int $id // PK
 * @property string $uuid
 * @property string $first_name
 * @property string $last_name
 * @property string $nickname
 * @property string $email
 * @property string $password
 * @property string $timezone
 * @property string|null $pfp_extension
 * @property string|null $remember_token
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property UserSetting $settings
 */
final class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasFeatures;
    use HasPermissions;
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'uuid',
        'first_name',
        'last_name',
        'nickname',
        'email',
        'password',
        'timezone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function settings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
