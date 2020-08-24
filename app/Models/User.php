<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int $school_id 学校
 * @property string $xh 学号
 * @property string $mm 密码
 * @property string $xm 姓名
 * @property string $sf 身份证
 * @property int $xb 性别 0:未知,1:男生,2:女生
 * @property string $sr 出生日期
 * @property string $mz 民族
 * @property string $xl 学历
 * @property string $xy 学院
 * @property string $zy 专业
 * @property string $bj 班级
 * @property string $xz 学制
 * @property string $nj 年级
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereMz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereSr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereXb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereXh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereXl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereXm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereXy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereXz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereZy($value)
 * @mixin \Eloquent
 */
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
