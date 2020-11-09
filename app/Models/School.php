<?php

namespace App\Models;

use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
