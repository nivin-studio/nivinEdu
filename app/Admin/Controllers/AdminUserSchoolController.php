<?php

namespace App\Admin\Controllers;

use App\Models\BindSchool;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Show;

class AdminUserSchoolController extends AdminController
{
    /**
     * 构建列表
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new BindSchool(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('admin_id');
            $grid->column('school_id');
            $grid->column('name');
            $grid->column('icon');
            $grid->column('api_no');
            $grid->column('api_key');
            $grid->column('state');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');

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
        return Show::make($id, new BindSchool(), function (Show $show) {
            $show->field('id');
            $show->field('admin_id');
            $show->field('school_id');
            $show->field('name');
            $show->field('icon');
            $show->field('api_no');
            $show->field('api_key');
            $show->field('state');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * 构建表单
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new BindSchool(), function (Form $form) {
            $form->display('id');
            $form->text('admin_id');
            $form->text('school_id');
            $form->text('name');
            $form->text('icon');
            $form->text('api_no');
            $form->text('api_key');
            $form->text('state');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
