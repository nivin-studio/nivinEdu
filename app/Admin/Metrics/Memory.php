<?php

namespace App\Admin\Metrics;

use App\Utils\System;
use Exception;
use Throwable;

class Memory extends GradientRound
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

        $this->title('内存信息');
        $this->contentWidth(0, 12);
    }

    /**
     * 装载数据
     *
     * @return void
     */
    public function fill()
    {
        if ($memory = System::memory()) {
            $used = $memory['MemTotal'] - $memory['MemFree'] - $memory['Cached'] - $memory['Buffers'];
            $data = [
                'used'    => System::conv($used),
                'total'   => System::conv($memory['MemTotal']),
                'percent' => round($used / $memory['MemTotal'] * 100, 1),
            ];
        } else {
            $data = [
                'used'    => 0,
                'total'   => 0,
                'percent' => 0,
            ];
        }

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
