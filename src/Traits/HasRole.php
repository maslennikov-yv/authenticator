<?php

namespace Maslennikov\Authorizator\Traits;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Maslennikov\Authorizator\Facade\Authorizator;
use Maslennikov\Authorizator\Models\Role;

trait HasRole
{
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class)->withDefault([
            'slug' => 'guest',
        ]);
    }

    public function getRole(): string
    {
        return $this->role?->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function assignRole(string $slug): static
    {
        $role = Role::where([
            'slug' => $slug,
        ])->firstOrFail();
        $this->role()->associate($role);
        return $this;
    }

    /**
     * @return $this
     */
    public function removeRole(): static
    {
        $this->role()->dissociate();
        return $this;
    }

    public function hasPermission(string $permission): bool
    {
        return Authorizator::hasPermission($this->getRole(), $permission);
    }

    public function scopeWithRole(Builder $query): Builder
    {
        return $query->with('role');
    }
}
