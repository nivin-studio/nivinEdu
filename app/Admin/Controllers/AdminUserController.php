<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Grid\Displayers\DialogTree;
use Dcat\Admin\Http\Auth\Permission;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Show;
use Dcat\Admin\Support\Helper;
use Dcat\Admin\Widgets\Tree;
use Illuminate\Http\Response;

class AdminUserController extends AdminController
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
            ->header('管理员')
            ->body($this->grid());
    }

    /**
     * 构建列表
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(Administrator::with(['roles']), function (Grid $grid) {
            $grid->column('id', 'ID');
            $grid->column('email', '邮箱');
            $grid->column('name', '昵称');

            if (config('admin.permission.enable')) {
                $grid->column('roles', '角色')->pluck('name')->label('primary', 3);

                $permissionModel = config('admin.database.permissions_model');
                $roleModel       = config('admin.database.roles_model');
                $nodes           = (new $permissionModel())->allNodes();

                $grid->column('permissions', '权限')
                    ->if(function () {
                        return !$this->roles->isEmpty();
                    })
                    ->showTreeInDialog(function (DialogTree $tree) use (&$nodes, $roleModel) {
                        $tree->nodes($nodes);

                        foreach (array_column($this->roles->toArray(), 'slug') as $slug) {
                            if ($roleModel::isAdministrator($slug)) {
                                $tree->checkAll();
                            }
                        }
                    })
                    ->else()
                    ->display('');
            }

            $grid->column('created_at', '创建时间');
            $grid->column('updated_at', '更新时间');

            $grid->quickSearch(['id', 'name', 'email']);

            $grid->showQuickEditButton();
            $grid->enableDialogCreate();
            $grid->showColumnSelector();
            // 工具操作
            $grid->actions(function (Actions $actions) {
                if ($actions->getKey() == Administrator::DEFAULT_ID) {
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
        return Show::make($id, Administrator::with(['roles']), function (Show $show) {
            $show->field('id', 'ID');
            $show->field('email', '邮箱');
            $show->field('name', '昵称');

            $show->field('avatar', '头像')->image();

            if (config('admin.permission.enable')) {
                $show->field('roles', '角色')->as(function ($roles) {
                    if (!$roles) {
                        return;
                    }
                    return collect($roles)->pluck('name');
                })->label();

                $show->field('permissions', '权限')->unescape()->as(function () {
                    $roles = $this->roles->toArray();

                    $permissionModel = config('admin.database.permissions_model');
                    $roleModel       = config('admin.database.roles_model');
                    $permissionModel = new $permissionModel();
                    $nodes           = $permissionModel->allNodes();

                    $tree = Tree::make($nodes);

                    $isAdministrator = false;
                    foreach (array_column($roles, 'slug') as $slug) {
                        if ($roleModel::isAdministrator($slug)) {
                            $tree->checkAll();
                            $isAdministrator = true;
                        }
                    }

                    if (!$isAdministrator) {
                        $keyName = $permissionModel->getKeyName();
                        $tree->check(
                            $roleModel::getPermissionId(array_column($roles, $keyName))->flatten()
                        );
                    }

                    return $tree->render();
                });
            }

            $show->field('created_at', '创建时间');
            $show->field('updated_at', '更新时间');
        });
    }

    /**
     * 构建表单
     *
     * @return Form
     */
    public function form()
    {
        return Form::make(Administrator::with(['roles']), function (Form $form) {
            $userTable  = config('admin.database.users_table');
            $connection = config('admin.database.connection');

            $id = $form->getKey();

            $form->display('id', 'ID');

            $form->text('email', '邮箱')
                ->required()
                ->creationRules(['required', "unique:{$connection}.{$userTable}"])
                ->updateRules(['required', "unique:{$connection}.{$userTable},email,$id"]);

            $form->text('name', '昵称')->required();
            $form->image('avatar', '头像')->autoUpload();

            if ($id) {
                $form->password('password', '密码')
                    ->minLength(6)
                    ->maxLength(20)
                    ->customFormat(function () {
                        return '';
                    });
            } else {
                $form->password('password', '密码')
                    ->required()
                    ->minLength(6)
                    ->maxLength(20);
            }

            $form->password('password_confirmation', '确认密码')->same('password');

            $form->ignore(['password_confirmation']);

            if (config('admin.permission.enable')) {
                $form->multipleSelect('roles', '角色')
                    ->options(function () {
                        $roleModel = config('admin.database.roles_model');

                        return $roleModel::all()->pluck('name', 'id');
                    })
                    ->customFormat(function ($v) {
                        return array_column($v, 'id');
                    });
            }

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');

            if ($id == Administrator::DEFAULT_ID) {
                $form->disableDeleteButton();
            }
        })->saving(function (Form $form) {
            if ($form->password && $form->model()->get('password') != $form->password) {
                $form->password = bcrypt($form->password);
            }

            if (!$form->password) {
                $form->deleteInput('password');
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
        if (in_array(Administrator::DEFAULT_ID, Helper::array($id))) {
            Permission::error();
        }

        return parent::destroy($id);
    }
}
