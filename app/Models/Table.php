<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Table
 *
 * @property int $id
 * @property int $school_id 学校
 * @property string $student_no 学号
 * @property string $period 时段 上午-下午-晚上
 * @property string $week 星期
 * @property string $section 节次
 * @property string $time 时间
 * @property string $course_name 课名
 * @property string $course_type 课型
 * @property string $week_period 周段
 * @property string $teacher 老师
 * @property string $location 地点
 * @property int $state 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Table newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Table query()
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereCourseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereStudentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereTeacher($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Table whereWeekPeriod($value)
 * @mixin \Eloquent
 */
class Table extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'tables';

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
        'period',
        'week',
        'section',
        'time',
        'course_name',
        'course_type',
        'week_period',
        'teacher',
        'location',
        'state',
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
     * 管理学校
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
