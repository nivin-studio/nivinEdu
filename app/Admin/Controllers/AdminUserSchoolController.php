<?php

namespace App\Admin\Controllers;

use App\Models\AdminUserSchool;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Http\Controllers\AdminController;

class AdminUserSchoolController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new AdminUserSchool(), function (Grid $grid) {
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
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new AdminUserSchool(), function (Show $show) {
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
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new AdminUserSchool(), function (Form $form) {
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
