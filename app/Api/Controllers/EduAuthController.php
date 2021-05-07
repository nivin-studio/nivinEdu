<?php

namespace App\Api\Controllers;

use App\Api\Response\ApiCode;
use App\Api\Response\Facades\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EduAuthController extends Controller
{
    /**
     * 获取token
     *
     * @param  Request        $request
     * @return JsonResponse
     */
    public function token(Request $request)
    {
        $params = [
            'api_no'  => $request->input('apiNo'),
            'api_key' => $request->input('apiKey'),
        ];

        // 使用 Auth 登录用户，如果登录成功，则返回 201 的 code 和 token，如果登录失败则返回
        if ($token = Auth::guard('application')->attempt($params)) {
            return Api::success(['token' => 'bearer ' . $token]);
        } else {
            return Api::error(ApiCode::make(ApiCode::CODE_3002));
        }
    }

    /**
     * 退出
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::guard('application')->logout();

        return Api::ok(ApiCode::make(ApiCode::CODE_OK, '退出成功'));
    }
}
