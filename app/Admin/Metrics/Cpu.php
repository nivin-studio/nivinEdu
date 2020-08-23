<?php

namespace App\Admin\Metrics;

use App\Utils\System;
use Exception;
use Throwable;

class Cpu extends GradientRound
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

        $this->title('CPU使用率');
        $this->contentWidth(0, 12);
    }

    /**
     * 装载数据
     *
     * @return void
     */
    public function fill()
    {
        if ($cpu = System::cpu()) {
            $data = [
                'core'    => $cpu['core'],
                'total'   => $cpu['total'],
                'percent' => $cpu['percent'],
            ];
        } else {
            $data = [
                'core'    => 0,
                'total'   => 0,
                'percent' => 0,
            ];
        }

        $this->withChart($data['percent']);
        $this->withFooter($data['core']);
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
     * @param  mixed   $core
     * @param  mixed   $used
     * @return $this
     */
    public function withFooter($core)
    {
        return $this->footer(
            <<<HTML
<div class="row text-center mx-0" style="width: 100%">
  <div class="col-12 border-top border-right d-flex align-items-between flex-column py-1">
      <p class="mb-50">核心数</p>
      <p class="font-sm-3 text-bold-700 mb-50">{$core}</p>
  </div>
</div>
HTML
        );
    }
}
