<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpiderLog extends Model
{
    /**
     * 表名
     *
     * @var string
     */
    protected $table = 'spider_log';

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
        'request_url',
        'request_type',
        'request_body',
        'response_body',
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

}
