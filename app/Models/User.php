<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'school_id',
        'xh',
        'mm',
        'xm',
        'sf',
        'xb',
        'sr',
        'mz',
        'xl',
        'xy',
        'zy',
        'bj',
        'xz',
        'nj',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 管理员用户
     * @return BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }
}
