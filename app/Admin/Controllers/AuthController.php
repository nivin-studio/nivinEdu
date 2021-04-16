<?php

namespace App\Admin\Controllers;

use App\Admin\Forms\UserSetting;
use App\Admin\Requests\CaptchaRequest;
use App\Admin\Requests\LoginRequest;
use App\Admin\Requests\RegisterRequest;
use App\Mail\MailBase;
use App\Models\Administrator;
use Dcat\Admin\Admin;
use Dcat\Admin\Layout\Content;
use Dcat\Admin\Models\Role;
use Dcat\Admin\Traits\HasFormResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

class AuthController extends Controller
{
    use HasFormResponse;

    /**
     * 显示注册页面
     *
     * @param  Content   $content
     * @return Content
     */
    public function getRegister(Content $content)
    {
        return $content->full()->body(view('admin.register'));
    }

    /**
     *
     * @return void
     */
    public function postRegister(RegisterRequest $request)
    {
        $email    = $request->input('email');
        $captcha  = $request->input('captcha');
        $password = $request->input('password');

        $captchaRedis = Redis::get('edu:register:captcha:' . $email);
        if (!$captchaRedis || $captchaRedis != $captcha) {
            return $this->response()
                ->withValidation([
                    'captcha' => '验证码错误',
                ])
                ->send();
        }

        $isCreate = Administrator::create([
            'email'    => $email,
            'password' => bcrypt($password),
            'name'     => '',
        ]);

        Administrator::where(['email' => $email])->first()->roles()->save(Role::where(['slug' => 'general'])->first());

        if ($isCreate) {
            Redis::del('edu:register:captcha:' . $email);

            return $this->response()
                ->success('注册成功 !')
                ->locationToIntended(admin_url('/'))
                ->send();
        } else {
            return $this->response()
                ->withValidation([
                    'email' => '用户注册失败',
                ])
                ->send();
        }
    }

    /**
     * 发送邮箱验证码
     *
     * @param  CaptchaRequest $request
     * @return JsonResponse
     */
    public function postCaptcha(CaptchaRequest $request)
    {
        $email = $request->input('email');

        $captcha = Redis::get('edu:register:captcha:' . $email);
        if (!$captcha) {
            $captcha = mt_rand(100000, 999999);
            Redis::setex('edu:register:captcha:' . $email, 600, $captcha);
        }

        $mailBase = new MailBase();
        $mailBase->subject('拟物校园注册验证码');
        $mailBase->line('您的注册验证码：' . $captcha . ' 有效期10分钟，请尽快完成注册！');

        Mail::to($email)->send($mailBase);

        return response()->json([
            'code'    => 0,
            'message' => '验证码发送成功',
        ]);
    }

    /**
     * 显示登录页面
     *
     * @param  Content                               $content
     * @return Redirector|RedirectResponse|Content
     */
    public function getLogin(Content $content)
    {
        if (Admin::guard()->check()) {
            return redirect(admin_url('/'));
        }

        return $content->full()->body(view('admin.login'));
    }

    /**
     * 登录请求
     *
     * @param  LoginRequest $request
     * @return mixed
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only(['email', 'password']);
        $remember    = (bool) $request->input('remember', false);

        if (Admin::guard()->attempt($credentials, $remember)) {
            $request->session()->regenerate();

            return $this->response()
                ->success('登录成功 !')
                ->locationToIntended(admin_url('/'))
                ->send();
        }

        return $this->response()
            ->withValidation([
                'email' => '账号或密码错误',
            ])
            ->send();
    }

    /**
     * 登出请求
     *
     * @return Redirect|string
     */
    public function getLogout(Request $request)
    {
        Admin::guard()->logout();

        $request->session()->invalidate();

        $path = admin_url('auth/login');
        if ($request->pjax()) {
            return "<script>location.href = '$path';</script>";
        }

        return redirect($path);
    }

    /**
     * 显示用户设置
     *
     * @param  Content   $content
     * @return Content
     */
    public function getSetting(Content $content)
    {
        $userSetting = new UserSetting();

        return $content
            ->title('用户设置')
            ->body($userSetting);
    }
}
