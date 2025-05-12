<?php

namespace Modules\User\Entities;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Auth\Entities\AuthProvider;
use Modules\Common\Enums\StatusEnum;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string> 
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'emailVerifiedAt',
        'password',
        'photoUrl',
        'avatarTextColor',
        'gender',
        'about',
        'dateOfBirthday',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'rememberToken',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'emailVerifiedAt' => 'datetime',
        'password'          => 'hashed',
    ];



    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['authProvider'];

    /**
     * Scope a query to only include user with status "active".
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', StatusEnum::ACTIVE);
    }

    /**
     * Scope a query to only include user with status "inactive".
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('status', StatusEnum::INACTIVE);
    }

    /**
     * Relationship between User and AuthProvider
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function authProvider()
    {
        return $this->hasOne(AuthProvider::class, 'userId', 'id');
    }
}
