<?php

namespace App\Admin\Forms;

use App\Models\School;
use Dcat\Admin\Admin;
use Dcat\Admin\Contracts\LazyRenderable;
use Dcat\Admin\Traits\LazyWidget;
use Dcat\Admin\Widgets\Form;

class CreateSchool extends Form implements LazyRenderable
{
    use LazyWidget;
    /**
     * Handle the form request.
     *
     *
     * @param  array   $input
     * @return mixed
     */
    public function handle(array $input)
    {
        $name   = $input['name'] ?? '';
        $icon   = $input['icon'] ?? '';
        $type   = $input['type'] ?? '';
        $eduUrl = $input['edu_url'] ?? '';
        $eduXh  = $input['edu_xh'] ?? '';
        $eduMm  = $input['edu_mm'] ?? '';

        $schoolInfo = School::whereName($name)->first();
        if ($schoolInfo) {
            return $this->response()->error('学校已存在');
        }

        $cuurTime = time();
        $isCreate = School::create([
            'admin_id' => Admin::user()->id,
            'name'     => $name,
            'icon'     => $icon,
            'type'     => $type,
            'edu_url'  => $eduUrl,
            'edu_xh'   => $eduXh,
            'edu_mm'   => $eduMm,
            'state'    => School::STATE_UNDEVELOPED,
        ]);
        if (!$isCreate) {
            return $this->response()->error('创建失败');
        }

        return $this->response()->success('创建成功')->refresh();
    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->text('name', '校名')
            ->required();

        $this->text('icon', '校徽')
            ->required();

        $this->select('type', '教务类型')
            ->options(School::TYPE_MAP)
            ->required();

        $this->url('edu_url', '教务地址')
            ->required();

        $this->text('edu_xh', '测试账号')
            ->required();

        $this->text('edu_mm', '测试密码')
            ->required();

    }

    /**
     * 提交按钮文本.
     *
     * @return string
     */
    protected function getSubmitButtonLabel()
    {
        return '创建';
    }

    /**
     * 渲染
     *
     * @return string
     */
    public function render()
    {
        return '<div class="card">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="line-height:30px">添加学校</h3>
                        <div class="pull-right"></div>
                    </div>
                    <div class="box-body">
                ' . parent::render() .
            '</div></div>';
    }
}
