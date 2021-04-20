<?php

namespace App\Admin\Controllers;

use App\Models\BindSchool;
use App\Models\Table;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Grid\Events\Fetching;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class TableController extends AdminController
{
    /**
     * 课表
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('课表')
            ->body($this->grid());
    }

    /**
     * 构建列表
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Table::with(['school']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('school.name', '学校');
            $grid->column('student_no', '学号');
            $grid->column('period', '时段');
            $grid->column('week', '星期');
            $grid->column('section', '节次');
            $grid->column('time', '时间');
            $grid->column('course_name', '课名');
            $grid->column('course_type', '课型');
            $grid->column('week_period', '周段');
            $grid->column('teacher', '老师');
            $grid->column('location', '地点');
            $grid->column('state', '状态')
                ->using(Table::STATE_MAP)
                ->dot(Table::STATE_COLOR_MAP);
            $grid->column('created_at', '创建时间');
            $grid->column('updated_at', '更新时间');

            $grid->model()->orderBy('created_at', 'desc');

            $grid->disableRowSelector();
            $grid->disableFilterButton();
            $grid->disableCreateButton();

            // 查询过滤
            $grid->filter(function (Filter $filter) {
                $filter->panel();
                $filter->expand();
                $filter->equal('student_no', '学号')->width(2);
            });
            // 查询事件
            $grid->listen(Fetching::class, function ($grid) {
                // 如果管理员用户是普通用户，只看获取自己创建的学校的学生课表
                if (Admin::user()->isRole('general')) {
                    $bindSchool = BindSchool::where('admin_id', Admin::user()->id)->pluck('school_id');
                    $grid->model()->whereIn('school_id', $bindSchool);
                }
            });
            // 工具操作
            $grid->actions(function (Actions $actions) {
                if (Admin::user()->isRole('general')) {
                    $actions->disableDelete();
                    $actions->disableEdit();
                }
            });
        });
    }

    /**
     * 构建显示
     *
     * @param  mixed  $id
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, Table::with(['school']), function (Show $show) {
            $show->field('id');
            $show->field('school.name', '学校');
            $show->field('student_no', '学号');
            $show->field('period', '时段');
            $show->field('week', '星期');
            $show->field('section', '节次');
            $show->field('time', '时间');
            $show->field('course_name', '课名');
            $show->field('course_type', '课型');
            $show->field('week_period', '周段');
            $show->field('teacher', '老师');
            $show->field('location', '地点');
            $show->field('state', '状态')
                ->using(Table::STATE_MAP)
                ->dot(Table::STATE_COLOR_MAP);
            $show->field('created_at', '创建时间');
            $show->field('updated_at', '更新时间');
        });
    }

    /**
     * 构建表单
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(Table::with(['school']), function (Form $form) {
            $form->display('id');
            $form->text('school_id', '校号');
            $form->text('student_no', '学号');
            $form->text('period', '时段');
            $form->text('week', '星期');
            $form->text('section', '节次');
            $form->text('time', '时间');
            $form->text('course_name', '课名');
            $form->text('course_type', '课型');
            $form->text('week_period', '周段');
            $form->text('teacher', '老师');
            $form->text('location', '地点');
            $form->select('state', '状态')
                ->options(Table::STATE_MAP);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
