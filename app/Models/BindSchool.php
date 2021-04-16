<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

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
class BindSchool extends Authenticatable implements JWTSubject
{

    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'bind_schools';

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
        'admin_id',
        'school_id',
        'name',
        'icon',
        'api_no',
        'api_key',
        'state',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return ['role' => 'bind_school'];
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->api_key;
    }
}
