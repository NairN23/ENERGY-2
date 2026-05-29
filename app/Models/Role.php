<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Role extends Model
{
    public const SLUG_ADMIN = 'admin';

    public const SLUG_CLIENTE = 'cliente';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'slug',
    ];

    public static function defaultOptions(): array
    {
        return [
            self::SLUG_ADMIN => 'Administrador',
            self::SLUG_CLIENTE => 'Cliente',
        ];
    }

    public static function options(): array
    {
        if (! Schema::hasTable('roles')) {
            return self::defaultOptions();
        }

        $options = static::query()->orderBy('id')->pluck('nombre', 'slug')->all();

        return $options !== [] ? $options : self::defaultOptions();
    }

    public static function slugIdMap(): array
    {
        if (! Schema::hasTable('roles')) {
            return [];
        }

        return static::query()->pluck('id', 'slug')->all();
    }

    public static function idForSlug(?string $slug): ?int
    {
        if (! $slug || ! Schema::hasTable('roles')) {
            return null;
        }

        return static::query()->where('slug', $slug)->value('id');
    }

    public static function ensureDefaults(): void
    {
        if (! Schema::hasTable('roles')) {
            return;
        }

        foreach (self::defaultOptions() as $slug => $nombre) {
            $role = static::query()->firstOrCreate(
                ['slug' => $slug],
                ['nombre' => $nombre],
            );

            if ($role->nombre !== $nombre) {
                $role->forceFill(['nombre' => $nombre])->save();
            }
        }
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}