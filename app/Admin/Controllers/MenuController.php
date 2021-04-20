<?php

namespace App\Admin\Controllers;

use Dcat\Admin\Form;
use Dcat\Admin\Http\Actions\Menu\Show;
use Dcat\Admin\Http\Controllers\AdminController;
use Dcat\Admin\Http\Repositories\Menu;
use Dcat\Admin\Layout\Column;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Layout\Row;
use Dcat\Admin\Tree;
use Dcat\Admin\Tree\Actions;
use Dcat\Admin\Widgets\Box;
use Dcat\Admin\Widgets\Form as WidgetForm;

class MenuController extends AdminController
{
    /**
     * 菜单
     *
     * @param  Content   $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->title('菜单')
            ->body(function (Row $row) {
                $row->column(7, $this->treeView()->render());

                $row->column(5, function (Column $column) {
                    $form = new WidgetForm();
                    $form->action(admin_url('auth/menu'));

                    $menuModel       = config('admin.database.menu_model');
                    $permissionModel = config('admin.database.permissions_model');
                    $roleModel       = config('admin.database.roles_model');

                    $form->select('parent_id', '父级')->options($menuModel::selectOptions());
                    $form->text('title', '标题')->required();
                    $form->icon('icon', '图标')->help($this->iconHelp());
                    $form->text('uri', '路径');

                    if ($menuModel::withRole()) {
                        $form->multipleSelect('roles', '角色')->options($roleModel::all()->pluck('name', 'id'));
                    }
                    if ($menuModel::withPermission()) {
                        $form->tree('permissions', '权限')
                            ->expand(false)
                            ->nodes((new $permissionModel())->allNodes());
                    }
                    $form->hidden('_token')->default(csrf_token());

                    $form->width(9, 2);

                    $column->append(Box::make('新增', $form));
                });
            });
    }

    /**
     * 模型树
     *
     * @return Tree
     */
    protected function treeView()
    {
        $menuModel = config('admin.database.menu_model');

        return new Tree(new $menuModel(), function (Tree $tree) {
            $tree->disableCreateButton();
            $tree->disableQuickCreateButton();
            $tree->disableEditButton();
            $tree->maxDepth(3);

            $tree->actions(function (Actions $actions) {
                if ($actions->getRow()->extension) {
                    $actions->disableDelete();
                }

                $actions->prepend(new Show());
            });

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

                if (!isset($branch['children'])) {
                    if (app('url')->isValidUrl($branch['uri'])) {
                        $uri = $branch['uri'];
                    } else {
                        $uri = admin_base_path($branch['uri']);
                    }

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * 构建表单
     *
     * @return Form
     */
    public function form()
    {
        $menuModel = config('admin.database.menu_model');

        $relations = $menuModel::withPermission() ? ['permissions', 'roles'] : 'roles';

        return Form::make(Menu::with($relations), function (Form $form) use ($menuModel) {
            $form->tools(function (Form\Tools $tools) {
                $tools->disableView();
            });

            $form->display('id', 'ID');

            $form->select('parent_id', '父级')->options(function () use ($menuModel) {
                return $menuModel::selectOptions();
            })->saving(function ($v) {
                return (int) $v;
            });
            $form->text('title', '标题')->required();
            $form->icon('icon', '图标')->help($this->iconHelp());
            $form->text('uri', '路径');
            $form->switch('show', '显示');

            if ($menuModel::withRole()) {
                $form->multipleSelect('roles', '角色')
                    ->options(function () {
                        $roleModel = config('admin.database.roles_model');

                        return $roleModel::all()->pluck('name', 'id');
                    })
                    ->customFormat(function ($v) {
                        return array_column($v, 'id');
                    });
            }
            if ($menuModel::withPermission()) {
                $form->tree('permissions', '权限')
                    ->nodes(function () {
                        $permissionModel = config('admin.database.permissions_model');

                        return (new $permissionModel())->allNodes();
                    })
                    ->customFormat(function ($v) {
                        if (!$v) {
                            return [];
                        }
                        return array_column($v, 'id');
                    });
            }

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '更新时间');
        })->saved(function (Form $form, $result) {
            $response = $form->response()->location('auth/menu');

            if ($result) {
                return $response->success('保存成功');
            }

            return $response->info('没有任何数据被更改');
        });
    }

    /**
     * 获取图片帮助提示语
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
