<?php

namespace App\Admin\Controllers;

use App\Models\BindSchool;
use App\Models\User;
use Dcat\Admin\Admin;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Grid\Events\Fetching;
use Dcat\Admin\Grid\Filter;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class UserController extends AdminController
{
    /**
     * 学生
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('学生')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(User::with(['school']), function (Grid $grid) {
            $grid->disableRowSelector();
            $grid->disableFilterButton();
            $grid->disableCreateButton();

            $grid->column('id');
            $grid->column('school.name', '学校');
            $grid->column('student_no', '学号');
            $grid->column('student_password', '密码')
                ->display(function ($text) {
                    return Admin::user()->isRole('administrator') ? $text : substr_replace($text, '****', -4);
                });

            $grid->column('student_name', '姓名');
            $grid->column('identity_no', '身份证')
                ->display(function ($text) {
                    return Admin::user()->isRole('administrator') ? $text : substr_replace($text, '****', -4, 4);
                });

            $grid->column('birth_date', '出生日期');
            $grid->column('gender', '性别')
                ->using(User::GENDER_MAP)
                ->badge(User::GENDER_COLOR_MAP);

            $grid->column('nation', '民族');
            $grid->column('education', '学历');
            $grid->column('college', '学院');
            $grid->column('major', '专业');
            $grid->column('class', '班级');
            $grid->column('period', '学制');
            $grid->column('grade', '年级');
            $grid->column('state', '状态')
                ->using(User::STATE_MAP)
                ->dot(User::STATE_COLOR_MAP);

            $grid->column('created_at', '创建时间');
            $grid->column('updated_at', '更新时间');

            $grid->model()->orderBy('created_at', 'desc');

            // 查询过滤
            $grid->filter(function (Filter $filter) {
                $filter->panel();
                $filter->expand();
                $filter->equal('student_no', '学号')->width(2);
            });
            // 查询事件
            $grid->listen(Fetching::class, function ($grid) {
                // 如果管理员用户是普通用户，只看获取自己创建的学校的学生用户
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
     * Make a show builder.
     *
     * @param  mixed  $id
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, User::with(['school']), function (Show $show) {
            $show->field('id');
            $show->field('school.name', '学校');
            $show->field('student_no', '学号');
            $show->field('student_password', '密码');
            $show->field('student_name', '姓名');
            $show->field('identity_no', '身份证');
            $show->field('birth_date', '出生日期');
            $show->field('gender', '性别')
                ->using(User::GENDER_MAP)
                ->dot(User::GENDER_COLOR_MAP);
            $show->field('nation', '民族');
            $show->field('education', '学历');
            $show->field('college', '学院');
            $show->field('major', '专业');
            $show->field('class', '班级');
            $show->field('period', '学制');
            $show->field('grade', '年级');
            $show->field('state', '状态')
                ->using(User::STATE_MAP)
                ->dot(User::STATE_COLOR_MAP);
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
        return Form::make(User::with(['school']), function (Form $form) {
            $form->display('id');
            $form->display('school.name', '学校');
            $form->hidden('school_id');
            $form->text('student_no', '学号');
            $form->text('student_password', '密码');
            $form->text('student_name', '姓名');
            $form->text('identity_no', '身份证');
            $form->text('birth_date', '出生日期');
            $form->select('gender', '性别')
                ->options(User::GENDER_MAP);
            $form->text('nation', '民族');
            $form->text('education', '学历');
            $form->text('college', '学院');
            $form->text('major', '专业');
            $form->text('class', '班级');
            $form->text('period', '学制');
            $form->text('grade', '年级');
            $form->select('state', '状态')
                ->options(User::STATE_MAP);
            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        });
    }
}
