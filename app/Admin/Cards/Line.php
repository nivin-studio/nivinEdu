<?php

namespace App\Admin\Cards;

use Dcat\Admin\Widgets\Metrics\Card;

/**
 * 折/曲线图卡片.
 *
 * Class Line
 */
class Line extends Card
{
    /**
     * 图表默认高度.
     *
     * @var int
     */
    protected $chartHeight = 200;

    /**
     * 标签
     *
     * @var string
     */
    protected $label = '';

    /**
     * 数字
     *
     * @var string
     */
    protected $num = '';

    /**
     * 图表默认配置.
     *
     * @var array
     */
    protected $chartOptions = [
        'chart'      => [
            'type'      => 'area',
            'toolbar'   => [
                'show' => false,
            ],
            'sparkline' => [
                'enabled' => true,
            ],
            'grid'      => [
                'show'    => false,
                'padding' => [
                    'left'  => 0,
                    'right' => 0,
                ],
            ],
        ],
        'tooltip'    => [
            'followCursor' => true,
            'x'            => [
                'show' => true,
            ],
        ],
        'xaxis'      => [
            'labels'     => [
                'show' => false,
            ],
            'axisBorder' => [
                'show' => false,
            ],
        ],
        'yaxis'      => [
            'y'       => 0,
            'offsetX' => 0,
            'offsetY' => 0,
            'padding' => ['left' => 0, 'right' => 0],
        ],
        'dataLabels' => [
            'enabled' => false,
        ],
        'stroke'     => [
            'width' => 2.5,
            'curve' => 'smooth',
        ],
        'fill'       => [
            'opacity' => 0.1,
            'type'    => 'solid',
        ],
    ];

    /**
     * 初始化.
     */
    protected function init()
    {
        parent::init();

        // 使用图表
        $this->useChart();
    }

    /**
     * 标签
     *
     * @param  string  $label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * 数字
     *
     * @param  string  $num
     * @return $this
     */
    public function num($num)
    {
        $this->num = $num;

        return $this;
    }

    /**
     * 数据
     *
     * @param  array   $data
     * @return $this
     */
    public function data(array $data)
    {
        return $this->chart([
            'series' => [
                [
                    'name' => $this->label,
                    'data' => $data,
                ],
            ],
        ]);
    }

    /**
     * 渲染内容
     *
     * @return string
     */
    public function withContent()
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px">
    <h2 class="ml-1 font-lg-1">{$this->num}</h2>
    <span class="mb-0 mr-1 text-80">{$this->label}</span>
</div>
HTML
        );
    }

    /**
     * 设置线条为直线.
     *
     * @return $this
     */
    public function chartCategories(array $data)
    {
        return $this->chartOption('xaxis.categories', $data);
    }

    /**
     * 设置线条为直线.
     *
     * @return $this
     */
    public function chartStraight()
    {
        return $this->chartOption('stroke.curve', 'straight');
    }

    /**
     * 设置线条为曲线.
     *
     * @return $this
     */
    public function chartSmooth()
    {
        return $this->chartOption('stroke.curve', 'smooth');
    }

    /**
     * 渲染内容，加上图表.
     *
     * @return string
     */
    public function renderContent()
    {
        $content = parent::renderContent();

        return <<<HTML
{$content}
<div class="card-content" style="overflow-x:hidden;overflow-y:hidden">
    {$this->renderChart()}
</div>
HTML;
    }
}
