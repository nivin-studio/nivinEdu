<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Score
 *
 * @property int $id
 * @property int $school_id 学校
 * @property string $student_no 学号
 * @property string $annual 学年
 * @property string $term 学期
 * @property string $course_no 课号
 * @property string $course_name 课名
 * @property string $course_type 课型
 * @property string $score 成绩
 * @property string $credit 学分
 * @property string $gpa 绩点
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Score newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Score newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Score query()
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereAnnual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereCourseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereCourseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereGpa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereStudentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereTerm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $state 状态
 * @method static \Illuminate\Database\Eloquent\Builder|Score whereState($value)
 */
class Score extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'scores';

    /**
     * 状态常量
     */
    const STATE_NORMAL = 1;
    const STATE_DELETE = 2;

    /**
     * 状态注释映射
     */
    const STATE_MAP = [
        self::STATE_NORMAL => '正常',
        self::STATE_DELETE => '删除',

    ];

    /**
     * 状态颜色映射
     */
    const STATE_COLOR_MAP = [
        self::STATE_NORMAL => '#1890ff',
        self::STATE_DELETE => '#bfbfbf',
    ];

    /**
     * 可以批量插入字段
     *
     * @var string[]
     */
    protected $fillable = [
        'application_id',
        'school_id',
        'student_no',
        'annual',
        'term',
        'course_no',
        'course_name',
        'course_type',
        'score',
        'credit',
        'gpa',
    ];

    /**
     * 关联应用
     *
     * @return BelongsTo
     */
    public function application()
    {
        return $this->belongsTo(Application::class, 'application_id');
    }

    /**
     * 关联学校
     *
     * @return BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    /**
     * 关联学生
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'student_no', 'student_no');
    }
}
