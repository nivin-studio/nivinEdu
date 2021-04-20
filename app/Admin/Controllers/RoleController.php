<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Http\Auth\Permission;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Repositories\Role;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Role as RoleModel;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Widgets\Tree;
use Illuminate\Http\Response;

class RoleController extends AdminController
{
    /**
     * 管理员
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('角色')
            ->body($this->grid());
    }

    /**
     * 构建列表
     *
     * @return Grid
     */
    protected function grid()
    {
        return new Grid(new Role(), function (Grid $grid) {
            $grid->column('id', 'ID');
            $grid->column('slug', '标识')->label('primary');
            $grid->column('name', '名称');

            $grid->column('created_at', '创建时间');
            $grid->column('updated_at', '更新时间');

            $grid->disableEditButton();
            $grid->showQuickEditButton();
            $grid->quickSearch(['id', 'name', 'slug']);
            $grid->enableDialogCreate();

            $grid->actions(function (Actions $actions) {
                $roleModel = config('admin.database.roles_model');
                if ($roleModel::isAdministrator($actions->row->slug)) {
                    $actions->disableDelete();
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
        return Show::make($id, new Role('permissions'), function (Show $show) {
            $show->field('id', 'ID');
            $show->field('slug', '标识');
            $show->field('name', '名称');

            $show->field('permissions', '权限')->unescape()->as(function ($permission) {
                $permissionModel = config('admin.database.permissions_model');
                $permissionModel = new $permissionModel();
                $nodes           = $permissionModel->allNodes();

                $tree = Tree::make($nodes);

                $keyName = $permissionModel->getKeyName();
                $tree->check(
                    array_column(Helper::array($permission), $keyName)
                );

                return $tree->render();
            });

            $show->field('created_at', '创建时间');
            $show->field('updated_at', '更新时间');

            if ($show->getKey() == RoleModel::ADMINISTRATOR_ID) {
                $show->disableDeleteButton();
            }
        });
    }

    /**
     * 构建表单
     *
     * @return Form
     */
    public function form()
    {
        return Form::make(Role::with(['permissions']), function (Form $form) {
            $roleTable  = config('admin.database.roles_table');
            $connection = config('admin.database.connection');

            $id = $form->getKey();

            $form->display('id', 'ID');

            $form->text('slug', '标识')
                ->required()
                ->creationRules(['required', "unique:{$connection}.{$roleTable}"])
                ->updateRules(['required', "unique:{$connection}.{$roleTable},slug,$id"]);

            $form->text('name', '名称')->required();

            $form->tree('permissions', '权限')
                ->nodes(function () {
                    $permissionModel = config('admin.database.permissions_model');
                    $permissionModel = new $permissionModel();

                    return $permissionModel->allNodes();
                })
                ->customFormat(function ($v) {
                    if (!$v) {
                        return [];
                    }
                    return array_column($v, 'id');
                });

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');

            if ($id == RoleModel::ADMINISTRATOR_ID) {
                $form->disableDeleteButton();
            }
        });
    }

    /**
     * 删除
     *
     * @param  int        $id
     * @return Response
     */
    public function destroy($id)
    {
        if (in_array(RoleModel::ADMINISTRATOR_ID, Helper::array($id))) {
            Permission::error();
        }

        return parent::destroy($id);
    }
}
