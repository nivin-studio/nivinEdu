<?php

namespace App\Admin\Cards;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Card;

class Num extends Card
{

    /**
     * 数字
     *
     * @var string
     */
    protected $num = '';

    /**
     * 图标
     *
     * @var string
     */
    protected $icon = 'icon-activity';

    /**
     * 数字颜色
     *
     * @var string
     */
    protected $numColor = '#13c2c2';

    /**
     * 标题颜色
     *
     * @var string
     */
    protected $titleColor = '#344050';

    /**
     * 图标颜色
     *
     * @var string
     */
    protected $iconColor = '#ffffff66';

    /**
     * 背景颜色
     *
     * @var string
     */
    protected $backgroundColor = '#ffffff';

    /**
     * 数字
     *
     * @param  string  $num
     * @return $this
     */
    public function num($num)
    {
        $this->num = $num ? $num : 0;

        return $this;
    }

    /**
     * 图标
     *
     * @param  string  $icon
     * @return $this
     */
    public function icon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * 图标颜色
     *
     * @param  string  $label
     * @return $this
     */
    public function iconColor($iconColor)
    {
        $this->iconColor = $iconColor;

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
     * 数字颜色
     *
     * @param  string  $color
     * @return $this
     */
    public function numColor($numColor)
    {
        $this->numColor = $numColor;

        return $this;
    }

    /**
     * 颜色
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
     * @return string
     */
    public function render()
    {
        Admin::style(
            <<<CSS
                .card-box-title {
                    color: {$this->titleColor};
                }
            CSS
        );

        $this->setHtmlAttribute('style', "background: {$this->backgroundColor};");

        $this->content(
            <<<HTML
                <div class="small-box" style="margin-bottom: 0; border-radius: .25rem">
                    <div class="inner">
                        <h3 style="color: {$this->numColor}; text-align: center;">{$this->num}</h3>
                    </div>
                    <div class="icon">
                        <i class="feather {$this->icon}" style="color: {$this->iconColor};font-size: 45px; top:30px"></i>
                    </div>
                </div>
            HTML
        );

        return parent::render();
    }
}
