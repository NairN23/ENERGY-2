<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    public const ROLE_ADMIN = 'admin';

    public const ROLE_CLIENTE = 'cliente';

    /**
     * @use HasFactory<UserFactory>
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'role_id',
        'deleted_email_original',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public static function roleOptions(): array
    {
        return Role::options();
    }

    public static function resolveRoleId(?string $slug): ?int
    {
        return Role::idForSlug($slug);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function roleRelation(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getRoleAttribute(): ?string
    {
        if (array_key_exists('role', $this->attributes)) {
            return $this->attributes['role'];
        }

        if (! Schema::hasTable('roles')) {
            return null;
        }

        $this->loadMissing('roleRelation');

        return $this->getRelation('roleRelation')?->slug;
    }

    public function setRoleAttribute(?string $value): void
    {
        $this->attributes['role_id'] = static::resolveRoleId($value);
        unset($this->relations['roleRelation']);
    }

    public function getRoleLabelAttribute(): string
    {
        return static::roleOptions()[$this->role] ?? ucfirst((string) $this->role);
    }

    public function scopeForRole(Builder $query, string $roleSlug): Builder
    {
        $roleId = static::resolveRoleId($roleSlug);

        if (! $roleId) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('role_id', $roleId);
    }

    public function preserveEmailForSoftDelete(): void
    {
        if ($this->deleted_email_original) {
            return;
        }

        $this->forceFill([
            'deleted_email_original' => $this->email,
            'email' => $this->buildDeletedEmailAlias(),
        ])->saveQuietly();
    }

    public function buildDeletedEmailAlias(): string
    {
        return sprintf('deleted-user-%d-%s@energy.local', $this->id, now()->format('YmdHis'));
    }

    /**
     * RELACIÓN AGREGADA: Un usuario puede tener muchos registros en la tabla de carritos.
     * Esto conecta al usuario actual con sus productos guardados en MariaDB.
     */
    public function carritos()
    {
        return $this->hasMany(\App\Models\Carrito::class, 'user_id');
    }
}