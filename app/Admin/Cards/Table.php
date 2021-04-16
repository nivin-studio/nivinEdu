<?php

namespace App\Admin\Cards;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Metrics\Card;

class Table extends Card
{

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
    protected $fontColor = '#4d5969';

    /**
     * 背景颜色
     *
     * @var string
     */
    protected $backgroundColor = '#ffffff';

    /**
     * 数据
     *
     * @var array
     */
    protected $data = [];

    /**
     * 初始化
     *
     * @throws Exception
     * @return void
     */
    public function init()
    {
        parent::init();
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
     * 数据
     *
     * @param  mixed   $data
     * @return $this
     */
    public function data($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function render()
    {
        Admin::style(
            <<<CSS
                .card-title {
                    color: {$this->titleColor};
                }
            CSS
        );

        $this->setHtmlAttribute('style', "background: {$this->backgroundColor}; color: {$this->fontColor};");

        $content = '';

        if (!is_null($this->data) && is_array($this->data)) {
            foreach ($this->data as $valone) {
                $item = '';
                foreach ($valone as $valtwo) {
                    $item .= <<<HTML
                    <td>{$valtwo}</td>
                HTML;
                }
                $content .= <<<HTML
                <tr>
                   {$item}
                </tr>
            HTML;
            }
        }

        $table = <<<HTML
            <table class="table">
            {$content}
            </table>
        HTML;

        $this->content($table);

        return parent::render();
    }
}
