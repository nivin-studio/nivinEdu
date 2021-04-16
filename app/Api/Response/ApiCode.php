<?php

namespace App\Api\Response;

class ApiCode
{
    //------默认成功------
    const CODE_OK = [
        'code'    => 0,
        'message' => 'ok',
    ];

    //------业务错误相关------
    const CODE_1000 = [
        'code'    => 1000,
        'message' => '登录失败',
    ];

    const CODE_1001 = [
        'code'    => 1001,
        'message' => '验证码已失效，请更重新获取验证码',
    ];

    const CODE_1002 = [
        'code'    => 1002,
        'message' => '获取学生个人信息失败',
    ];

    const CODE_1003 = [
        'code'    => 1003,
        'message' => '获取学生个人成绩失败',
    ];

    const CODE_1004 = [
        'code'    => 1004,
        'message' => '获取学生个人课表失败',
    ];

    //------参数错误相关------
    const CODE_2000 = [
        'code'    => 2000,
        'message' => '',
    ];

    //------认证错误相关------
    const CODE_3000 = [
        'code'    => 3000,
        'message' => '非法请求',
    ];

    const CODE_3001 = [
        'code'    => 3001,
        'message' => 'token无权限',
    ];

    const CODE_3002 = [
        'code'    => 3002,
        'message' => 'apiNo或者apiKey错误',
    ];

    const CODE_3003 = [
        'code'    => 3003,
        'message' => 'token已过期',
    ];

    const CODE_3004 = [
        'code'    => 3004,
        'message' => 'token无效',
    ];

    /**
     * code
     *
     * @var int
     */
    public $code = 0;

    /**
     * message
     *
     * @var string
     */
    public $message = '';

    /**
     * 构造函数
     *
     * @param  array       $code
     * @param  string|null $message
     * @return void
     */
    public function __construct($code, $message = null)
    {
        $this->code    = $code['code'];
        $this->message = $message ? $message : $code['message'];
    }

    /**
     * 构建
     *
     * @param  array       $code
     * @param  string|null $message
     * @return ApiCode
     */
    public static function make($code, $message = null)
    {
        return new self($code, $message);
    }
}
