<?php

namespace App\Admin\Forms;

use Dcat\Admin\Admin;
use Dcat\Admin\Widgets\Form;

class UserSetting extends Form
{
    /**
     * Handle the form request.
     *
     * @param  array   $input
     * @return mixed
     */
    public function handle(array $input)
    {
        $name        = $input['name'] ?? '';
        $oldPassword = $input['old_password'] ?? '';
        $newPassword = $input['password'] ?? '';

        $adminUser = Admin::user();

        if (!$oldPassword || !$newPassword || !$name) {
            return $this->response()->error('参数错误');
        }

        $isOldPassword = Admin::guard()
            ->getProvider()
            ->validateCredentials($adminUser, ['password' => $oldPassword]);

        if (!$isOldPassword) {
            return $this->response()->error('请输入正确的旧密码');
        }

        $isUpdated = $adminUser->update(
            [
                'name'     => $name,
                'password' => bcrypt($newPassword),
            ]
        );

        if (!$isUpdated) {
            return $this->response()->error('修改失败');
        } else {
            return $this->response()->success('修改成功')->refresh();
        }

    }

    /**
     * Build a form here.
     */
    public function form()
    {
        $this->display('email', '邮箱')->required();
        $this->text('name', '昵称')->required();
        $this->password('old_password', '旧密码')->required();
        $this->password('password', '新密码')
            ->minLength(5)
            ->maxLength(20)
            ->customFormat(function ($v) {
                if ($v == $this->password) {
                    return;
                }
                return $v;
            });

        $this->password('password_confirmation', '确认密码')->same('password');
    }

    function default() {
        return Admin::user()->toArray();
    }

    /**
     * 渲染
     *
     * @return string
     */
    public function render()
    {
        return '<div class="card">
                    <div class="box-header with-border">
                        <h3 class="box-title" style="line-height:30px">编辑</h3>
                        <div class="pull-right"></div>
                    </div>
                    <div class="box-body">
                ' . parent::render() .
            '</div></div>';
    }
}
