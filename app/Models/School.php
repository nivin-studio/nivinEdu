<?php

namespace App\Models;

use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property string|null $deleted_at
 * @property-read \Dcat\Admin\Models\Administrator $admin
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\School onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereAdminId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereEduMm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereEduUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereEduXh($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\School whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\School withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\School withoutTrashed()
 * @mixin \Eloquent
 */
class School extends Model
{

    use SoftDeletes;

    protected $table = 'school';

    /**
     * 管理员用户
     * @return BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(Administrator::class, 'admin_id');
    }
}
