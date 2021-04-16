<?php

namespace App\Models;

use App\Common\CacheKey;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

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
class School extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'schools';

    /**
     * 学校类型常量
     */
    const ZF  = 1;
    const KG  = 2;
    const URP = 3;

    /**
     * 学校类型注释映射
     */
    const TYPE_MAP = [
        self::ZF  => '正方',
        self::KG  => '青果',
        self::URP => 'URP',
    ];

    /**
     * 学校状态常量
     */
    const STATE_UNDEVELOPED = 1;
    const STATE_DEVELOPING  = 2;
    const STATE_SUPPORTED   = 3;
    const STATE_MAINTENANCE = 4;
    const STATE_NONSUPPORT  = 5;

    /**
     * 学校状态注释映射
     */
    const STATE_MAP = [
        self::STATE_UNDEVELOPED => '未开发',
        self::STATE_DEVELOPING  => '开发中',
        self::STATE_SUPPORTED   => '已支持',
        self::STATE_MAINTENANCE => '修复中',
        self::STATE_NONSUPPORT  => '不支持',
    ];

    /**
     * 学校状态颜色映射
     */
    const STATE_COLOR_MAP = [
        self::STATE_UNDEVELOPED => '#bfbfbf',
        self::STATE_DEVELOPING  => '#1890ff',
        self::STATE_SUPPORTED   => '#13c2c2',
        self::STATE_MAINTENANCE => '#fadb14',
        self::STATE_NONSUPPORT  => '#f5222d',
    ];

    /**
     * 可以批量插入字段
     *
     * @var string[]
     */
    protected $fillable = [
        'admin_id',
        'name',
        'icon',
        'type',
        'edu_url',
        'edu_xh',
        'edu_mm',
        'state',
    ];

    /**
     * 管理员用户
     *
     * @return BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Administrator::class, 'admin_id');
    }

    /**
     * 获取以支持的学校
     *
     * @param  array                 $columns
     * @return Collection|static[]
     */
    public static function active($columns = ['*'])
    {
        return Cache::rememberForever(CacheKey::SCHOOL_ACTIVE_LIST, function () use ($columns) {
            return self::whereState(self::STATE_SUPPORTED)->get($columns);
        });
    }
}
