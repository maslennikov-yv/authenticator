<?php

namespace Maslennikov\Authorizator\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User;

class Role extends Model
{
    use HasFactory;

    protected $casts = [
        'children' => 'array',
        'permissions' => 'array',
    ];

    protected $fillable = [
        'slug',
        'name',
        'children',
        'permissions',
    ];

    /**
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
