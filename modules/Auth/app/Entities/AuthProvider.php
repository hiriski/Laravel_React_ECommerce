<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Common\Entities\BaseModel;
use Modules\User\Entities\User;

class AuthProvider extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'userId',
        'providerAccountId',
        'providerAccountName',
        'providerPhotoUrl',
        'providerName',
    ];

    /**
     * Relationship between SocialAccount and User
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
