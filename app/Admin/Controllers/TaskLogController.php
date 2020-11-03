<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\TaskLog;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class TaskLogController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('日志')
            ->body($this->grid());
    }
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new TaskLog(), function (Grid $grid) {

            $grid->disableCreateButton();

            $grid->column('id')->sortable();
            $grid->column('task_id', '任务ID');
            $grid->column('duration', '耗时')->append('ms');
            $grid->column('content', '内容');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('task_id', '任务ID')->width(1);
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
        return Show::make($id, new TaskLog(), function (Show $show) {
            $show->field('id');
            $show->field('task_id', '任务ID');
            $show->field('duration', '耗时');
            $show->field('content', '内容');
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
        return Form::make(new TaskLog(), function (Form $form) {
            $form->display('id');
            $form->text('task_id', '任务ID');
            $form->text('duration', '耗时');
            $form->text('content', '内容');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
