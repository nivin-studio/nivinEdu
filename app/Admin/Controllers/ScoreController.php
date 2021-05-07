<?php

namespace App\Admin\Controllers;

use App\Models\Application;
use App\Models\Score;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Grid\Events\Fetching;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class ScoreController extends AdminController
{
    /**
     * 成绩
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('成绩')
            ->body($this->grid());
    }

    /**
     * 构建列表
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Score::with(['school']), function (Grid $grid) {
            $grid->column('id');
            $grid->column('school.name', '学校');
            $grid->column('student_no', '学号');
            $grid->column('annual', '学年');
            $grid->column('term', '学期');
            $grid->column('course_no', '课号');
            $grid->column('course_name', '课名');
            $grid->column('course_type', '课型');
            $grid->column('score', '成绩');
            $grid->column('credit', '学分');
            $grid->column('gpa', '绩点');
            $grid->column('state', '状态')
                ->using(Score::STATE_MAP)
                ->dot(Score::STATE_COLOR_MAP);
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
                // 如果管理员用户是普通用户，只看获取自己创建的学校的学生成绩
                if (Admin::user()->isRole('general')) {
                    $application = Application::whereAdminId(Admin::user()->id)->first();
                    $grid->model()->where('application_id', $application ? $application->id : 0);
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
        return Show::make($id, Score::with(['school']), function (Show $show) {
            $show->field('id');
            $show->field('school.name', '学校');
            $show->field('student_no', '学号');
            $show->field('annual', '学年');
            $show->field('term', '学期');
            $show->field('course_no', '课号');
            $show->field('course_name', '课名');
            $show->field('course_type', '课型');
            $show->field('score', '成绩');
            $show->field('credit', '学分');
            $show->field('gpa', '绩点');
            $show->field('state', '状态')
                ->using(Score::STATE_MAP)
                ->dot(Score::STATE_COLOR_MAP);
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
        return Form::make(Score::with(['school']), function (Form $form) {
            $form->display('id');
            $form->text('school_id', '校号');
            $form->text('student_no', '学号');
            $form->text('annual', '学年');
            $form->text('term', '学期');
            $form->text('course_no', '课号');
            $form->text('course_name', '课名');
            $form->text('course_type', '课型');
            $form->text('score', '成绩');
            $form->text('credit', '学分');
            $form->text('gpa', '绩点');
            $form->select('state', '状态')
                ->options(Score::STATE_MAP);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
