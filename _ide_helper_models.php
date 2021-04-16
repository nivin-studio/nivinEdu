<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BindSchool
 *
 * @property int $id
 * @property int $admin_id 管理员用户
 * @property int $school_id 学校
 * @property string $name 学校名称
 * @property string $icon 学校图标
 * @property string $api_no API账号
 * @property string $api_key API密钥
 * @property int $state 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereApiNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdminUserSchool whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class BindSchool extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * App\Models\School
 *
 * @property int $id
 * @property int $admin_id 管理员用户
 * @property string $name 学校名称
 * @property string $icon 学校图标
 * @property int $type 教务平台
 * @property string $edu_url 教务地址
 * @property string $edu_xh 测试学号
 * @property string $edu_mm 测试密码
 * @property int $state 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Administrator $admin
 * @method static \Illuminate\Database\Eloquent\Builder|School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|School newQuery()
 * @method static \Illuminate\Database\Query\Builder|School onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|School query()
 * @method static \Illuminate\Database\Eloquent\Builder|School whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEduMm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEduUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereEduXh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|School withTrashed()
 * @method static \Illuminate\Database\Query\Builder|School withoutTrashed()
 * @mixin \Eloquent
 */
	class School extends \Eloquent {}
}

namespace App\Models{
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
	class Score extends \Eloquent {}
}

namespace App\Models{
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
	class Table extends \Eloquent {}
}

namespace App\Models{
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
	class User extends \Eloquent {}
}

