<?php

namespace App\Admin\Cards;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Round;

/**
 * 渐变形图卡片.
 *
 * Class SingleRound
 */
class GradientRound extends Round
{

    /**
     * 百分比
     *
     * @var int
     */
    protected $percent = 0;

    /**
     * 底部数据[['title' => '', 'value' => ''], ...]
     *
     * @var array
     */
    protected $footerInfo = [];

    /**
     * 图表高度.
     *
     * @var int
     */
    protected $chartHeight = 195;

    /**
     * 图表下间距.
     *
     * @var int
     */
    protected $chartMarginBottom = 5;

    /**
     * 图表轨道颜色
     *
     * @var string
     */
    protected $chartTrackColor = '#b9c3cd';

    /**
     * 图表标签颜色
     *
     * @var string
     */
    protected $chartLabelColor = '#0b1727';

    /**
     * 图表渐变开始色
     *
     * @var string
     */
    protected $chartGradientStartColor = '#13c2c2';

    /**
     * 图表渐变结尾色
     *
     * @var string
     */
    protected $chartGradientEndColor = '#52c41a';

    /**
     * 标题颜色
     *
     * @var string
     */
    protected $titleColor = '#344050';

    /**
     * 字体颜色
     *
     * @var string
     */
    protected $fontColor = '#344050';

    /**
     * 背景颜色
     *
     * @var string
     */
    protected $backgroundColor = '#ffffff';

    /**
     * 初始化
     *
     * @throws Exception
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->contentWidth(0, 12);
    }

    /**
     * 图表默认配置.
     * tart
     * @return array
     */
    protected function defaultChartOptions()
    {
        return [
            'chart'       => [
                'type'       => 'radialBar',
                'sparkline'  => [
                    'enabled' => true,
                ],
                'dropShadow' => [
                    'enabled' => true,
                    'blur'    => 3,
                    'left'    => 1,
                    'top'     => 1,
                    'opacity' => 0.1,
                ],
            ],
            'colors'      => [$this->chartGradientStartColor],
            'plotOptions' => [
                'radialBar' => [
                    'size'       => 70,
                    'startAngle' => -180,
                    'endAngle'   => 179,
                    'hollow'     => [
                        'size' => '74%',
                    ],
                    'track'      => [
                        'background'  => $this->chartTrackColor,
                        'strokeWidth' => '50%',
                    ],
                    'dataLabels' => [
                        'name'  => [
                            'show' => false,
                        ],
                        'value' => [
                            'offsetY'  => 14,
                            'color'    => $this->chartLabelColor,
                            'fontSize' => '2.8rem',
                        ],
                    ],
                ],
            ],
            'fill'        => [
                'type'     => 'gradient',
                'gradient' => [
                    'shade'            => 'dark',
                    'type'             => 'horizontal',
                    'shadeIntensity'   => 0.5,
                    'gradientToColors' => [$this->chartGradientEndColor],
                    'inverseColors'    => true,
                    'opacityFrom'      => 1,
                    'opacityTo'        => 1,
                    'stops'            => [0, 100],
                ],
            ],
            'series'      => [100],
            'stroke'      => [
                'lineCap' => 'round',
            ],
        ];
    }

    /**
     * 设置图表轨道颜色
     *
     *
     * @param  mixed   $size
     * @return $this
     */
    public function chartTrackColor(string $color)
    {
        return $this->chartOption('plotOptions.radialBar.track.background', $color);
    }

    /**
     * 设置图表标签颜色
     *
     *
     * @param  mixed   $size
     * @return $this
     */
    public function chartLabelColor(string $color)
    {
        return $this->chartOption('plotOptions.radialBar.dataLabels.value.color', $color);
    }

    /**
     * 设置图表渐变开始色
     *
     *
     * @param  mixed   $size
     * @return $this
     */
    public function chartGradientStartColor(string $color)
    {
        return $this->chartOption('colors', [$color]);
    }

    /**
     * 设置图表渐变结尾色
     *
     *
     * @param  mixed   $size
     * @return $this
     */
    public function chartGradientEndColor(string $color)
    {
        return $this->chartOption('fill.gradient.gradientToColors', [$color]);
    }

    /**
     * 百分比
     *
     * @param  mixed   $percent
     * @return $this
     */
    public function percent($percent)
    {
        $this->percent = $percent;

        return $this;
    }

    /**
     * 底部数据[['title' => '', 'value' => ''], ...]
     *
     * @param  mixed   $footerInfo
     * @return $this
     */
    public function footerInfo($footerInfo)
    {
        $this->footerInfo = $footerInfo;

        return $this;
    }

    /**
     * 标题颜色
     *
     * @param  string  $color
     * @return $this
     */
    public function titleColor($titleColor)
    {
        $this->titleColor = $titleColor;

        return $this;
    }

    /**
     * 字体颜色
     *
     * @param  string  $color
     * @return $this
     */
    public function fontColor($fontColor)
    {
        $this->fontColor = $fontColor;

        return $this;
    }

    /**
     * 背景颜色
     *
     * @param  string  $color
     * @return $this
     */
    public function backgroundColor($backgroundColor)
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    /**
     * 渲染内容
     *
     * @return $this
     */
    public function render()
    {
        Admin::style(
            <<<CSS
                .card-title {
                    color: {$this->titleColor};
                    font-family: Poppins,-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol";
                }
            CSS
        );

        $this->setHtmlAttribute('style', "background: {$this->backgroundColor}; color: {$this->fontColor};");

        $this->chart([
            'series' => [$this->percent],
        ]);

        $items = null;
        $col   = round(12 / count($this->footerInfo));

        foreach ($this->footerInfo as $val) {
            $items .= <<<HTML
                <div class="col-{$col} border-top border-right d-flex align-items-between flex-column py-1">
                    <p class="mb-50">{$val['title']}</p>
                    <p class="font-sm-3 text-bold-700 mb-50">{$val['value']}</p>
                </div>
            HTML;
        }

        $this->footer(
            <<<HTML
                <div class="row text-center mx-0" style="width: 100%">
                    {$items}
                </div>
            HTML
        );

        return parent::render();
    }
}
