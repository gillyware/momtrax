<?php

declare(strict_types=1);

namespace App\Models;

use Gillyware\Gatekeeper\Traits\HasFeatures;
use Gillyware\Gatekeeper\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Database\Factories\UserFactory;

final class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasFeatures;
    use HasPermissions;
    use Notifiable;

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

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
