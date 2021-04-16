<?php

namespace App\Admin\Cards;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Card;

class QuickSearch extends Card
{

    /**
     * 标题颜色
     *
     * @var string
     */
    protected $titleColor = '#344050';

    /**
     * 背景颜色
     *
     * @var string
     */
    protected $backgroundColor = '#ffffff';

    /**
     * 动作URL
     *
     * @var string
     */
    protected $actionUrl = '';

    /**
     * 输入框name
     *
     * @var string
     */
    protected $inputName = '';

    /**
     * 输入框预期值的提示信息
     *
     * @var string
     */
    protected $inputPlaceholder = '';

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
     * 动作URL
     *
     * @param  string  $actionUrl
     * @return $this
     */
    public function actionUrl($actionUrl)
    {
        $this->actionUrl = $actionUrl;

        return $this;
    }

    /**
     * 输入框name
     *
     * @param  string  $actionUrl
     * @return $this
     */
    public function inputName($inputName)
    {
        $this->inputName = $inputName;

        return $this;
    }

    /**
     * 输入框预期值的提示信息
     *
     * @param  string  $actionUrl
     * @return $this
     */
    public function inputPlaceholder($inputPlaceholder)
    {
        $this->inputPlaceholder = $inputPlaceholder;

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
                .table-filter label:after {
                    font-size: 1.8rem;
                }
            CSS
        );

        $this->setHtmlAttribute('style', "background: {$this->backgroundColor};");

        $this->content(
            <<<HTML
                <div class="small-box" style="margin-bottom: 0; border-radius: .25rem">
                    <div class="inner">
                    <form action="{$this->actionUrl}" class="input-no-border d-md-inline-block" pjax-container style="width: 100%;height:3.5rem;">
                        <div class="table-filter">
                            <label style="width: 100%;">
                                <input
                                    style="padding: 1.25rem 1rem 1.25rem 2.8rem!important;font-size: 1.25rem!important;"
                                    type="search"
                                    class="form-control form-control-lg quick-search-input"
                                    name="{$this->inputName}"
                                    placeholder="{$this->inputPlaceholder}"
                                >
                            </label>
                        </div>
                    </form>
                    </div>
                </div>
            HTML
        );

        return parent::render();
    }
}
