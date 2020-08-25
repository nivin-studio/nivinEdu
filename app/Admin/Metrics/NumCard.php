<?php

namespace App\Admin\Metrics;

use Dcat\Admin\Widgets\Metrics\Card;

class NumCard extends Card
{
    /**
     * 初始化卡片内容
     *
     * @return void
     */
    protected function init()
    {
        parent::init();
    }

    /**
     * 设置卡片内容.
     *
     *
     * @param  string  $content
     * @return $this
     */
    public function setNum($content)
    {
        return $this->content(
            <<<HTML
<div class="d-flex justify-content-between align-items-center mt-1" style="margin-bottom: 2px;">
    <h2 class="ml-1 font-lg-1">{$content}</h2>
</div>
HTML
        );
    }
}
