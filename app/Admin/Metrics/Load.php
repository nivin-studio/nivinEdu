<?php

namespace App\Admin\Metrics;

use Exception;
use Throwable;

class Load extends GradientRound
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

        $this->title('系统负载');
        $this->contentWidth(0, 12);
    }

    /**
     * 装载数据
     *
     * @return void
     */
    public function fill()
    {
        $data = sys_getloadavg();

        $this->withChart($data[0]);
        $this->withFooter($data[1], $data[2]);
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
     * @param  mixed   $five
     * @param  mixed   $fifteen
     * @return $this
     */
    public function withFooter($five, $fifteen)
    {
        return $this->footer(
            <<<HTML
<div class="row text-center mx-0" style="width: 100%">
  <div class="col-6 border-top border-right d-flex align-items-between flex-column py-1">
      <p class="mb-50">5分钟</p>
      <p class="font-sm-3 text-bold-700 mb-50">{$five}%</p>
  </div>
  <div class="col-6 border-top d-flex align-items-between flex-column py-1">
      <p class="mb-50">15分钟</p>
      <p class="font-sm-3 text-bold-700 mb-50">{$fifteen}%</p>
  </div>
</div>
HTML
        );
    }
}
