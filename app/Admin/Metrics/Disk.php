<?php

namespace App\Admin\Metrics;

use App\Utils\System;
use Exception;
use Throwable;

class Disk extends GradientRound
{
    /**
     * 图表高度.
     *
     * @var int
     */
    protected $chartHeight = 195;

    /**
     * 初始化
     *
     * @throws Exception
     * @return void
     */
    public function init()
    {
        parent::init();

        $this->title('磁盘空间');
        $this->contentWidth(0, 12);
    }

    /**
     * 装载数据
     *
     * @return void
     */
    public function fill()
    {
        $disk = System::disk();
        $data = [
            'used'    => System::conv($disk['used']),
            'total'   => System::conv($disk['total']),
            'percent' => round($disk['used'] / $disk['total'] * 100, 1),
        ];

        $this->withChart($data['percent']);
        $this->withFooter($data['total'], $data['used']);
    }

    /**
     * 渲染
     *
     * @throws Throwable
     * @return string
     */
    public function render()
    {
        $this->fill();

        return parent::render();
    }

    /**
     * 图表
     *
     * @param  mixed   $percent
     * @return $this
     */
    public function withChart($percent)
    {
        return $this->chart([
            'series' => [$percent],
        ]);
    }

    /**
     * 底部
     *
     * @param  mixed   $total
     * @param  mixed   $used
     * @return $this
     */
    public function withFooter($total, $used)
    {
        return $this->footer(
            <<<HTML
<div class="row text-center mx-0" style="width: 100%">
  <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
      <p class="mb-50">总共</p>
      <p class="font-sm-3 text-bold-700 mb-50">{$total}</p>
  </div>
  <div class="col-6 border-top d-flex align-items-between flex-column py-1">
      <p class="mb-50">使用</p>
      <p class="font-sm-3 text-bold-700 mb-50">{$used}</p>
  </div>
</div>
HTML
        );
    }
}
