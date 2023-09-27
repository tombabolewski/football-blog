<?php

namespace App\Models;

use App\Support\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @method static Builder withEmail(string $email)
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use HasPermissions;
    use HasRoles;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Attributes

    public function getRoleAttribute(): Role
    {
        return Role::from($this->roles->first()->name);
    }

    // Authentication

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->id;
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // Scopes

    public function scopeWithEmail(Builder $query, string $email): Builder
    {
        return $query->where('email', $email);
    }

    // Relationships

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class);
    }
}
