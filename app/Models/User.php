<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'active',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class)->withTimestamps();
    }

    public function isAdmin()
    {
        return ($this->attributes['role'] & 2) === 2;
    }

    // czy jest opiekunem
    public function isGuardian()
    {
        return ($this->attributes['role'] & 1) === 1;
    }

    public function getRoleAttribute($value): array
    {
        $value = (int) ($value ?? 0);

        $roles = [];
        if (($value & 1) === 1) {
            $roles[] = 1;
        }

        if (($value & 2) === 2) {
            $roles[] = 2;
        }

        return $roles;
    }

    public function setRoleAttribute($value): void
    {
        if (is_array($value)) {
            $value = array_sum(array_map('intval', $value));
        }

        $this->attributes['role'] = (int) $value;
    }

    public function getRoleLabelsAttribute(): array
    {
        $value = (int) ($this->attributes['role'] ?? 0);

        $roles = [];
        if (($value & 1) === 1) {
            $roles[] = __('admin.title.roles.moderator');
        }
        if (($value & 2) === 2) {
            $roles[] = __('admin.title.roles.admin');
        }

        return $roles;
    }

    public function setPasswordAttribute($value): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (password_get_info($value)['algo'] === 0) {
            $value = Hash::make($value);
        }

        $this->attributes['password'] = $value;
    }

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
}
