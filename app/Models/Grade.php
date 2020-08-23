<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grade extends Model
{
    use SoftDeletes;

    protected $table = 'grades';

    protected $fillable = [
        'school_id',
        'xh',
        'xn',
        'xq',
        'kh',
        'km',
        'kx',
        'cj',
        'xf',
        'jd',
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
