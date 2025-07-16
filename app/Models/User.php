<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasRoles, HasFactory, Notifiable, LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logExcept(['password', 'updated_at'])
            ->logOnlyDirty()
            ->useLogName('user');
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $actor = auth()->user()?->username ?? 'System';

        return match ($eventName) {
            'created' => "[{$actor}] created user \"{$this->username}\"",
            'updated' => "[{$actor}] updated user \"{$this->username}\"",
            'deleted' => "[{$actor}] deleted user \"{$this->username}\"",
            default => ucfirst($eventName)." user \"{$this->username}\"",
        };
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_picture',
        'id_number',
        'phone_number',
        'first_name',
        'surname',
        'date_of_birth',
        'place_of_birth',
        'education',
        'institution',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_token',
        'provider_refresh_token'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Blog::class);
    }
}
