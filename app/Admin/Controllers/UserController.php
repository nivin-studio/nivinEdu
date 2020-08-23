<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\User;
use App\Models\School;
use Dcat\Admin\Admin;
use Dcat\Admin\Controllers\AdminController;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Show;

class UserController extends AdminController
{
    public function index(Content $content)
    {
        return $content
            ->header('学生列表')
            ->body($this->grid());
    }

    /**
     * 表格构建
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new User(['school']), function (Grid $grid) {
            $grid->disableCreateButton();
            $grid->disableRowSelector();
            // 字段显示处理
            $grid->id->sortable();
            $grid->column('school.name', '学校');
            $grid->xh;
            $grid->mm;
            $grid->xm;
            $grid->sf;
            $grid->xb->using([
                1 => '男',
                2 => '女',
            ], '未知')->badge([
                'default' => 'gray',
                1         => 'primary',
                2         => 'danger',
            ]);
            $grid->sr;
            $grid->mz;
            $grid->xl;
            $grid->xy;
            $grid->zy;
            $grid->bj;
            $grid->xz;
            $grid->nj;
            $grid->created_at;
            $grid->updated_at->sortable();

            // 查询过滤
            $grid->filter(function (Grid\Filter $filter) {
                $filter->panel();
                $filter->equal('xh')->width(2);
            });

            // 查询事件
            $grid->fetching(function (Grid $grid) {
                // 如果管理员用户是普通用户，只看获取自己创建的学校的学生用户
                if (Admin::user()->isRole('general')) {
                    $school = School::where('admin_id', Admin::user()->id)->pluck('id');
                    $grid->model()->whereIn('school_id', $school);
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
        return Show::make($id, new User(['school']), function (Show $show) {
            // 字段显示处理
            $show->id;
            $show->field('school.name', '学校');
            $show->xh;
            $show->mm;
            $show->xm;
            $show->sf;
            $show->xb->using([
                1 => '男',
                2 => '女',
            ], '未知');
            $show->sr;
            $show->mz;
            $show->xl;
            $show->xy;
            $show->zy;
            $show->bj;
            $show->xz;
            $show->nj;
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
        return Form::make(new User(['school']), function (Form $form) {
            // 字段显示处理
            $form->display('id');
            $form->display('school.name', '学校');
            $form->text('xh');
            $form->text('mm');
            $form->text('xm');
            $form->text('sf');
            $form->select('xb')->options([
                1 => '男',
                2 => '女',
                0 => '未知',
            ]);
            $form->text('sr');
            $form->text('mz');
            $form->text('xl');
            $form->text('xy');
            $form->text('zy');
            $form->text('bj');
            $form->text('xz');
            $form->text('nj');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
