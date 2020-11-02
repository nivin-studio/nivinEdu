<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Task;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class TaskController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('定时任务')
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Task(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('command', '命令');
            $grid->column('description', '描述');
            $grid->column('parameters', '参数');
            $grid->column('expression', '时间表达式');
            $grid->column('state', '状态');
            $grid->column('dont_overlap', '避免重复');
            $grid->column('run_in_maintenance', '维护模式');
            $grid->column('notification_email_address', '通知邮件地址');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new Task(), function (Show $show) {
            $show->field('id');
            $show->column('command', '命令');
            $show->column('description', '描述');
            $show->column('parameters', '参数');
            $show->column('expression', '时间表达式');
            $show->column('state', '状态');
            $show->column('dont_overlap', '避免重复执行');
            $show->column('run_in_maintenance', '维护也需执行');
            $show->column('notification_email_address', '通知邮件地址');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Task(), function (Form $form) {
            $form->display('id');
            $form->text('command', '命令');
            $form->text('description', '描述');
            $form->text('parameters', '参数');
            $form->text('expression', '时间表达式');
            $form->switch('state', '状态');
            $form->switch('dont_overlap', '避免重复执行');
            $form->switch('run_in_maintenance', '维护也需执行');
            $form->text('notification_email_address', '通知邮件地址');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
