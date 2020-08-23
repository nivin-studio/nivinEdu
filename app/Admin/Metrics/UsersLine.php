<?php

namespace App\Admin\Metrics;

use Dcat\Admin\Widgets\Metrics\Line;

class UsersLine extends Line
{
    /**
     * @var string
     */
    protected $label = '用户数';

    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();

        $this->title($this->label);

        $generator = function ($len, $min = 10, $max = 300) {
            for ($i = 0; $i <= $len; $i++) {
                yield mt_rand($min, $max);
            }
        };
        // 卡片内容
        $this->withContent(mt_rand(1000, 5000) . 'k');
        // 图表数据
        $this->withChart(collect($generator(30))->toArray());
    }

    /**
     * 设置图表数据.
     *
     *
     * @param  array   $data
     * @return $this
     */
    public function withChart(array $data)
    {
        return $this->chart([
            'series' => [
                [
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 设置卡片内容.
     *
     *
     * @param  string  $content
     * @return $this
     */
    public function withContent($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
</div>
HTML
        );
    }
}
