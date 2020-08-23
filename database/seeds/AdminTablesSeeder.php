<?php

use Dcat\Admin\Models\Administrator;
use Dcat\Admin\Models\Menu;
use Dcat\Admin\Models\Permission;
use Dcat\Admin\Models\Role;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createdAt = date('Y-m-d H:i:s');

        // create a user.
        Administrator::truncate();
        Administrator::create([
            'username'   => 'admin',
            'password'   => bcrypt('admin'),
            'name'       => '超级管理员',
            'created_at' => $createdAt,
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name'       => '超级管理员',
            'slug'       => Role::ADMINISTRATOR,
            'created_at' => $createdAt,
        ], [
            'name'       => '学校管理员',
            'slug'       => 'general',
            'created_at' => $createdAt,
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        //create a permission
        Permission::truncate();
        Permission::insert([
            [
                'id'          => 1,
                'name'        => '授权管理',
                'slug'        => 'auth-management',
                'http_method' => '',
                'http_path'   => '',
                'parent_id'   => 0,
                'order'       => 1,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 2,
                'name'        => '管理用户',
                'slug'        => 'users',
                'http_method' => '',
                'http_path'   => '/auth/users*',
                'parent_id'   => 1,
                'order'       => 2,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 3,
                'name'        => '角色',
                'slug'        => 'roles',
                'http_method' => '',
                'http_path'   => '/auth/roles*',
                'parent_id'   => 1,
                'order'       => 3,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 4,
                'name'        => '权限',
                'slug'        => 'permissions',
                'http_method' => '',
                'http_path'   => '/auth/permissions*',
                'parent_id'   => 1,
                'order'       => 4,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 5,
                'name'        => '菜单',
                'slug'        => 'menu',
                'http_method' => '',
                'http_path'   => '/auth/menu*',
                'parent_id'   => 1,
                'order'       => 5,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 6,
                'name'        => '操作日志',
                'slug'        => 'operation-log',
                'http_method' => '',
                'http_path'   => '/auth/logs*',
                'parent_id'   => 1,
                'order'       => 6,
                'created_at'  => $createdAt,
            ],

        ]);

//        Role::first()->permissions()->save(Permission::first());

        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id'  => 0,
                'order'      => 1,
                'title'      => '主页',
                'icon'       => 'feather icon-bar-chart-2',
                'uri'        => '/',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 0,
                'order'      => 2,
                'title'      => '学校',
                'icon'       => 'feather icon-home',
                'uri'        => '/schcool',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 0,
                'order'      => 3,
                'title'      => '学生',
                'icon'       => 'feather icon-users',
                'uri'        => '/user',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 0,
                'order'      => 4,
                'title'      => '成绩',
                'icon'       => 'feather icon-slack',
                'uri'        => '/grade',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 0,
                'order'      => 5,
                'title'      => '系统',
                'icon'       => 'feather icon-settings',
                'uri'        => '',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 5,
                'order'      => 6,
                'title'      => '信息',
                'icon'       => '',
                'uri'        => '/system/info',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 5,
                'order'      => 7,
                'title'      => '管理员用户',
                'icon'       => '',
                'uri'        => 'auth/users',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 5,
                'order'      => 8,
                'title'      => '角色',
                'icon'       => '',
                'uri'        => 'auth/roles',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 5,
                'order'      => 9,
                'title'      => '权限',
                'icon'       => '',
                'uri'        => 'auth/permissions',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 5,
                'order'      => 10,
                'title'      => '菜单',
                'icon'       => '',
                'uri'        => 'auth/menu',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 5,
                'order'      => 11,
                'title'      => '操作日志',
                'icon'       => '',
                'uri'        => 'auth/logs',
                'created_at' => $createdAt,
            ],
        ]);

        (new Menu())->flushCache();
    }
}
