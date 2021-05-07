<?php

namespace App\Models;

use App\Utils\Hashids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * App\Models\Application
 *
 * @property int $id
 * @property int $admin_id 管理员用户
 * @property int $school_id 学校
 * @property string $api_no API账号
 * @property string $api_key API密钥
 * @property int $state 状态
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\School $school
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApiKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApiNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSchoolId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Application extends Authenticatable implements JWTSubject
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'applications';

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
        'api_no',
        'api_key',
        'state',
    ];

    /**
     * 获取格式化ID
     *
     * @return string
     */
    public function hashid()
    {
        return Hashids::encode($this->id);
    }

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
        return ['role' => 'application'];
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
