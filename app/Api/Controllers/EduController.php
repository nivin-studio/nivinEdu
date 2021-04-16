<?php

namespace App\Api\Controllers;

use App\Api\Response\ApiCode;
use App\Api\Response\Facades\Api;
use App\Edu\Edu;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class EduController extends Controller
{

    /**
     * 获取验证码
     */
    public function captcha()
    {
        $bindSchool = Auth::guard('bind_school')->user();
        if (!$bindSchool) {
            return Api::error(ApiCode::make(ApiCode::CODE_3004));
        }

        $edu = new Edu($bindSchool->name);
        // 获取cookie
        $cookie = $edu->getCookie();
        // 获取验证码
        $captcha = $edu->getCaptcha();
        // 序列化cookie对象
        $cookieObj = serialize($cookie);

        Redis::setex('edu:cookie:' . $bindSchool->api_no, 1800, $cookieObj);

        return Api::success(['captcha' => $captcha]);
    }

    /**
     * 获取登录状态
     *
     * @param  Request        $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $bindSchool = Auth::guard('bind_school')->user();
        if (!$bindSchool) {
            return Api::error(ApiCode::make(ApiCode::CODE_3004));
        }

        $cookieObj = Redis::get('edu:cookie:' . $bindSchool->api_no);
        if (!$cookieObj) {
            return Api::error(ApiCode::make(ApiCode::CODE_1001));
        }

        $studentNo  = $request->input('studentNo');  // 学号
        $studentPwd = $request->input('studentPwd'); // 密码
        $captcha    = $request->input('captcha');    // 验证码

        $edu = new Edu($bindSchool->name);
        // 用存储的cookie对象
        $edu->setCookie(unserialize($cookieObj));
        // 获取登录信息
        $result = $edu->getLoginInfo($studentNo, $studentPwd, $captcha);

        if ($result['code'] != 0) {
            Redis::del('edu:cookie:' . $bindSchool->api_no);
            return Api::error(ApiCode::make(ApiCode::CODE_1000, '登录失败：' . $result['msg']));
        } else {
            return Api::ok(ApiCode::make(ApiCode::CODE_OK, '登录成功'));
        }
    }

    /**
     * 获取学生个人信息
     *
     * @param  Request        $request
     * @return JsonResponse
     */
    public function persos(Request $request)
    {
        $bindSchool = Auth::guard('bind_school')->user();
        if (!$bindSchool) {
            return Api::error(ApiCode::make(ApiCode::CODE_3004));
        }

        $cookieObj = Redis::get('edu:cookie:' . $bindSchool->api_no);
        if (!$cookieObj) {
            return Api::error(ApiCode::make(ApiCode::CODE_1001));
        }

        $studentNo  = $request->input('studentNo');  // 学号
        $studentPwd = $request->input('studentPwd'); // 密码

        $edu = new Edu($bindSchool->name);
        // 用存储的cookie对象
        $edu->setCookie(unserialize($cookieObj));
        // 获取学生个人信息
        $persos = $edu->getPersosInfo($studentNo);

        if (empty($persos)) {
            Redis::del('edu:cookie:' . $bindSchool->api_no);
            return Api::error(ApiCode::make(ApiCode::CODE_1002));
        } else {
            return Api::success($persos);
        }
    }

    /**
     * 获取学生个人成绩
     *
     * @param  Request        $request
     * @return JsonResponse
     */
    public function scores(Request $request)
    {
        $bindSchool = Auth::guard('bind_school')->user();
        if (!$bindSchool) {
            return Api::error(ApiCode::make(ApiCode::CODE_3004));
        }

        $cookieObj = Redis::get('edu:cookie:' . $bindSchool->api_no);
        if (!$cookieObj) {
            return Api::error(ApiCode::make(ApiCode::CODE_1001));
        }

        $studentNo  = $request->input('studentNo');  // 学号
        $studentPwd = $request->input('studentPwd'); // 密码

        $edu = new Edu($bindSchool->name);
        // 用存储的cookie对象
        $edu->setCookie(unserialize($cookieObj));
        // 获取学生个人成绩
        $scores = $edu->getScoresInfo($studentNo);

        if (empty($scores)) {
            Redis::del('edu:cookie:' . $bindSchool->api_no);
            return Api::error(ApiCode::make(ApiCode::CODE_1003));
        } else {
            return Api::success($scores);
        }
    }

    /**
     * 获取学生个人课表
     *
     * @param  Request        $request
     * @return JsonResponse
     */
    public function tables(Request $request)
    {
        $bindSchool = Auth::guard('bind_school')->user();
        if (!$bindSchool) {
            return Api::error(ApiCode::make(ApiCode::CODE_3004));
        }

        $cookieObj = Redis::get('edu:cookie:' . $bindSchool->api_no);
        if (!$cookieObj) {
            return Api::error(ApiCode::make(ApiCode::CODE_1001));
        }

        $studentNo  = $request->input('studentNo');  // 学号
        $studentPwd = $request->input('studentPwd'); // 密码

        $edu = new Edu($bindSchool->name);
        // 用存储的cookie对象
        $edu->setCookie(unserialize($cookieObj));
        // 获取学生个人课表
        $tables = $edu->getTablesInfo($studentNo);

        if (empty($tables)) {
            Redis::del('edu:cookie:' . $bindSchool->api_no);
            return Api::error(ApiCode::make(ApiCode::CODE_1004));
        } else {
            return Api::success($tables);
        }
    }
}
