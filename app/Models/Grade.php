<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Grade
 *
 * @property int $id
 * @property int $school_id 学校
 * @property string $xh 学号
 * @property string $xn 学年
 * @property int $xq 学期
 * @property string $kh 课号
 * @property string $km 课名
 * @property string $kx 课型
 * @property string $cj 成绩
 * @property string $xf 学分
 * @property string $jd 绩点
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \App\Models\School $school
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grade onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereCj($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereJd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereKh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereKm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereKx($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereXf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereXh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereXn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Grade whereXq($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grade withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Grade withoutTrashed()
 * @mixin \Eloquent
 */
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
