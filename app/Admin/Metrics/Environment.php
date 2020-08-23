<?php

namespace App\Admin\Metrics;

use Dcat\Admin\Widgets\Metrics\Card;
use Illuminate\Support\Arr;

class Environment extends Card
{

    /**
     * 初始化
     *
     * @throws Exception
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->title('系统环境');
    }

    /**
     * 渲染
     *
     * @throws Throwable
     * @return string
     */
    public function render()
    {
        $data = [
            ['name' => 'PHP版本', 'value' => PHP_VERSION],
            ['name' => 'Laravel版本', 'value' => app()->version()],
            ['name' => '服务器系统', 'value' => php_uname('s') . '/' . php_uname('r')],
            ['name' => '服务器版本', 'value' => Arr::get($_SERVER, 'SERVER_SOFTWARE')],
            ['name' => '缓存驱动', 'value' => config('cache.default')],
            ['name' => '会话驱动', 'value' => config('session.driver')],
            ['name' => '时区', 'value' => config('app.timezone')],
            ['name' => '语言', 'value' => config('app.locale')],
        ];

        $this->renderTable($data);

        return parent::render();
    }

    /**
     * 渲染卡片内容
     *
     * @return string
     */
    public function renderTable($data)
    {

        $content = '';
        foreach ($data as $val) {
            $name  = $val['name'];
            $value = $val['value'];

            $content .= <<<HTML
<tr>
    <td width="120px" class="bold text-80">{$name}</td>
    <td>{$value}</td>
</tr>
HTML;
        }

        $table = <<<HTML
<table class="table">
{$content}
</table>
HTML;

        $this->content($table);

    }

}
