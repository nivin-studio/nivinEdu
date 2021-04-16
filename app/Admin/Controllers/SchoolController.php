<?php

namespace App\Admin\Controllers;

use App\Models\School;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Events\Fetching;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class SchoolController extends AdminController
{

    /**
     * 学校
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('学校')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(School::with(['admin']), function (Grid $grid) {
            $grid->disableRowSelector();
            $grid->disableFilterButton();

            $grid->column('id');
            $grid->column('admin.username', '管理员');
            $grid->column('name', '校名');
            $grid->column('icon', '校徽')
                ->image('', 80, 80);

            $grid->column('type', '教务类型')
                ->using(School::TYPE_MAP);

            $grid->column('edu_url', '教务地址');
            $grid->column('edu_xh', '测试账号')
                ->display(function ($text) {
                    return Admin::user()->isRole('administrator') ? $text : substr_replace($text, '****', -4);
                });

            $grid->column('edu_mm', '测试密码')
                ->display(function ($text) {
                    return Admin::user()->isRole('administrator') ? $text : substr_replace($text, '****', -4);
                });

            $grid->column('state', '状态')
                ->using(School::STATE_MAP)
                ->dot(School::STATE_COLOR_MAP);

            $grid->column('created_at', '创建时间');
            $grid->column('updated_at', '更新时间');

            $grid->model()->orderBy('created_at', 'desc');

            // 查询过滤器
            $grid->filter(function (Filter $filter) {
                $filter->panel();
                $filter->expand();
                $filter->equal('name', '校名')->width(2);
            });
            // 查询事件
            $grid->listen(Fetching::class, function ($grid) {
                // 如果管理员用户是普通用户，只看获取自己创建的学校
                if (Admin::user()->isRole('general')) {
                    $grid->model()->where('admin_id', Admin::user()->id);
                }
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param  mixed  $id
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, School::with(['admin']), function (Show $show) {
            $show->field('id');
            $show->field('admin.username', '管理员');
            $show->field('name', '校名');
            $show->field('icon', '校徽');
            $show->field('type', '教务类型')
                ->using(School::TYPE_MAP);

            $show->field('edu_url', '教务地址');
            $show->field('edu_xh', '测试账号');
            $show->field('edu_mm', '测试密码');
            $show->field('state', '状态')
                ->using(School::STATE_MAP)
                ->dot(School::STATE_COLOR_MAP);

            $show->field('created_at', '创建时间');
            $show->field('updated_at', '更新时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(School::with(['admin']), function (Form $form) {
            $form->display('id');
            $form->display('admin.username', '管理员');
            $form->hidden('admin_id');
            $form->text('name', '校名');
            $form->text('icon', '校徽');
            $form->select('type', '教务类型')
                ->options(School::TYPE_MAP);

            $form->text('edu_url', '教务地址');
            $form->text('edu_xh', '测试账号');
            $form->text('edu_mm', '测试密码');
            $form->select('state', '状态')
                ->options(School::STATE_MAP);

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');

            // 如果是新建保存
            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    // 管理员用户是当前登录用户
                    $form->admin_id = Admin::user()->id;
                }
            });
        });
    }
}
