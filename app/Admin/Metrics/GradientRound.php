<?php

namespace App\Admin\Metrics;

use Dcat\Admin\Widgets\Metrics\Round;

/**
 * 渐变形图卡片.
 *
 * Class SingleRound
 */
class GradientRound extends Round
{
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
    protected $chartLabelColor = '#b9c3cd';

    /**
     * 图表渐变开始色
     *
     * @var string
     */
    protected $chartGradientStartColor = '#00b5b5';

    /**
     * 图表渐变结尾色
     *
     * @var string
     */
    protected $chartGradientEndColor = '#21b978';

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
}
