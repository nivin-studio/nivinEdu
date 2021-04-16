<?php

use App\Models\Administrator;
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
            'email'      => 'admin@nivin.cn',
            'password'   => bcrypt('123456'),
            'name'       => '超级管理员',
            'created_at' => $createdAt,
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name'       => '超级管理员',
            'slug'       => 'administrator',
            'created_at' => $createdAt,
        ]);

        Role::create([
            'name'       => '普通管理员',
            'slug'       => 'general',
            'created_at' => $createdAt,
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::where(['slug' => 'administrator'])->first());

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
            [
                'id'          => 7,
                'name'        => '学生',
                'slug'        => 'user',
                'http_method' => '',
                'http_path'   => '/user*',
                'parent_id'   => 0,
                'order'       => 7,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 8,
                'name'        => '学校',
                'slug'        => 'school',
                'http_method' => '',
                'http_path'   => '/school*',
                'parent_id'   => 0,
                'order'       => 8,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 9,
                'name'        => '成绩',
                'slug'        => 'score',
                'http_method' => '',
                'http_path'   => '/score*',
                'parent_id'   => 0,
                'order'       => 9,
                'created_at'  => $createdAt,
            ],
            [
                'id'          => 10,
                'name'        => '课表',
                'slug'        => 'table',
                'http_method' => '',
                'http_path'   => '/table*',
                'parent_id'   => 0,
                'order'       => 10,
                'created_at'  => $createdAt,
            ],
        ]);

        Role::where(['slug' => 'general'])->first()->permissions()->save(Permission::where(['slug' => 'user'])->first());
        Role::where(['slug' => 'general'])->first()->permissions()->save(Permission::where(['slug' => 'school'])->first());
        Role::where(['slug' => 'general'])->first()->permissions()->save(Permission::where(['slug' => 'score'])->first());
        Role::where(['slug' => 'general'])->first()->permissions()->save(Permission::where(['slug' => 'table'])->first());

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
                'uri'        => '/school',
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
                'uri'        => '/score',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 0,
                'order'      => 5,
                'title'      => '课表',
                'icon'       => 'feather icon-layout',
                'uri'        => '/table',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 0,
                'order'      => 6,
                'title'      => '系统',
                'icon'       => 'feather icon-settings',
                'uri'        => '',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 6,
                'order'      => 7,
                'title'      => '管理员用户',
                'icon'       => '',
                'uri'        => 'auth/users',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 6,
                'order'      => 8,
                'title'      => '角色',
                'icon'       => '',
                'uri'        => 'auth/roles',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 6,
                'order'      => 9,
                'title'      => '权限',
                'icon'       => '',
                'uri'        => 'auth/permissions',
                'created_at' => $createdAt,
            ],
            [
                'parent_id'  => 6,
                'order'      => 10,
                'title'      => '菜单',
                'icon'       => '',
                'uri'        => 'auth/menu',
                'created_at' => $createdAt,
            ],
        ]);

        Menu::where(['title' => '系统'])->first()->roles()->save(Role::where(['slug' => 'administrator'])->first());

        (new Menu())->flushCache();
    }
}
