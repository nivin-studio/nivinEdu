<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property int $school_id 学校
 * @property string $student_no 学号
 * @property string $student_password 密码
 * @property string $student_name 姓名
 * @property string $identity_no 身份证
 * @property string $birth_date 出生日期
 * @property int $gender 性别 0:未知,1:男生,2:女生
 * @property string $nation 民族
 * @property string $education 学历
 * @property string $college 学院
 * @property string $major 专业
 * @property string $class 班级
 * @property string $period 学制
 * @property string $grade 年级
 * @property int $state 状态
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCollege($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEducation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGrade($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdentityNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMajor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStudentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStudentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStudentPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * 性别常量
     */
    const GENDER_UNKNOWN = 0;
    const GENDER_MAN     = 1;
    const GENDER_WEMAN   = 2;

    /**
     * 性别注释映射
     */
    const GENDER_MAP = [
        self::GENDER_UNKNOWN => '未知',
        self::GENDER_MAN     => '男',
        self::GENDER_WEMAN   => '女',
    ];

    /**
     * 性别颜色映射
     */
    const GENDER_COLOR_MAP = [
        self::GENDER_UNKNOWN => '#bfbfbf',
        self::GENDER_MAN     => '#1890ff',
        self::GENDER_WEMAN   => '#f5222d',
    ];

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'application_id',
        'school_id',
        'student_no',
        'student_password',
        'student_name',
        'identity_no',
        'birth_date',
        'gender',
        'nation',
        'education',
        'college',
        'major',
        'class',
        'period',
        'grade',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'student_password', 'remember_token',
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
}
