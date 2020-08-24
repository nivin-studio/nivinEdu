<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\School;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class SchoolController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('学校列表')
            ->body($this->grid());
    }

    /**
     * 表格构建
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new School(['admin']), function (Grid $grid) {
            $grid->disableRowSelector();
            // 字段显示处理
            $grid->id->sortable();
            $grid->column('admin.username', '管理员');
            $grid->name;
            $grid->icon()->image('', 80, 80);
            $grid->type()->using([
                1 => '正方',
                2 => '青果',
            ]);
            $grid->edu_url;
            $grid->edu_xh;
            $grid->column('edu_mm')->display(function ($text) {
                return '******';
            });
            $grid->state->using([
                1 => '未开发',
                2 => '开发中',
                3 => '开发完',
            ])->dot([
                1 => 'primary',
                2 => 'danger',
                3 => 'success',
            ]);
            $grid->created_at;
            $grid->updated_at->sortable();

            // 查询过滤
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('name')->width(2);
            });

            // 查询事件
            $grid->fetching(function (Grid $grid) {
                // 如果管理员用户是普通用户，只看获取自己创建的学校
                if (Admin::user()->isRole('general')) {
                    $grid->model()->where('admin_id', Admin::user()->id);
                }
            });
        });
    }

    /**
     * 显示构建
     *
     * @param  mixed  $id
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new School(['admin']), function (Show $show) {
            // 字段显示处理
            $show->id;
            $show->field('admin.username', '管理员');
            $show->name;
            $show->icon;
            $show->type()->using([
                1 => '正方',
                2 => '青果',
            ]);
            $show->edu_url;
            $show->edu_xh;
            $show->edu_mm;
            $show->state->using([
                1 => '未开发',
                2 => '开发中',
                3 => '开发完',
            ])->dot([
                1 => 'primary',
                2 => 'danger',
                3 => 'success',
            ]);
            $show->created_at;
            $show->updated_at;
        });
    }

    /**
     * 表单构建
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new School(['admin']), function (Form $form) {
            // 字段显示处理
            $form->display('id');
            $form->display('admin.username', '管理员');
            $form->hidden('admin_id');
            $form->text('name');
            $form->text('icon');
            $form->select('type')->options([
                1 => '正方',
                2 => '青果',
            ]);
            $form->text('edu_url');
            $form->text('edu_xh');
            $form->text('edu_mm');
            $form->select('state')->options([
                1 => '未开发',
                2 => '开发中',
                3 => '开发完',
            ]);
            $form->display('created_at');
            $form->display('updated_at');

            // 如果是新建的保存事件
            $form->saving(function (Form $form) {
                if ($form->isCreating()) {
                    // 管理员用户是当前登录用户
                    $form->admin_id = Admin::user()->id;
                }
            });

        });
    }
}
