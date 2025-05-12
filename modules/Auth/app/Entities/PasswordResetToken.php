<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Entities\BaseModel;

class PasswordResetToken extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['email', 'token', 'appId', 'createdAt'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'token',
    ];
}
