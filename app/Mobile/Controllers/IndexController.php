<?php

namespace App\Mobile\Controllers;

use App\Edu\Edu;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\School;
use App\Utils\Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    /**
     * 主页
     *
     * @return view
     */
    public function index()
    {
        $schools = School::where('state', School::STATE_SUPPORTED)->get();
        return view('mobile.index', ['schools' => $schools]);
    }

    /**
     * 学校
     *
     * @param  Request $request
     * @return view
     */
    public function school(Request $request)
    {
        $appid = Hashids::decode($request->input('appid'));

        $application = Application::whereId($appid)->first();
        if (!$application) {
            return redirect()->route('mobile.index');
        }

        $edu = new Edu($application);
        // 获取cookie
        $cookie = $edu->getCookie();
        // 获取验证码
        $captcha = $edu->getCaptcha();
        // 序列化cookie对象
        $cookieObj = serialize($cookie);
        // 存储了cookie对象
        Session::put('cookieObj', $cookieObj);

        return view('mobile.login', ['application' => $application, 'captcha' => $captcha]);
    }

    /**
     * 登录页面
     *
     * @param  Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $studentNo  = $request->input('studentNo');              // 学号
        $studentPwd = $request->input('studentPwd');             // 密码
        $captcha    = $request->input('captcha');                // 验证码
        $appid      = Hashids::decode($request->input('appid')); // 学校

        $application = Application::whereId($appid)->first();
        if (!$application) {
            return redirect()->route('mobile.index');
        }

        $edu = new Edu($application);
        // 获取cookie对象
        $cookieObj = Session::get('cookieObj');
        // 反序列化cookie对象
        $cookieObj = unserialize($cookieObj);
        // 用存储的cookie对象
        $edu->setCookie($cookieObj);
        // 获取登录信息
        $res = $edu->getLoginInfo($studentNo, $studentPwd, $captcha);

        if ($res['code'] != 0) {
            Session::remove('cookieObj');
            return redirect()->route('mobile.index');
        }

        // 获取学生信息
        $persos = $edu->getPersosInfo($studentNo, $studentPwd);
        // 获取成绩信息
        $scores = $edu->getScoresInfo($studentNo, $studentPwd);
        // 获取课表信息
        $tables = $edu->getTablesInfo($studentNo, $studentPwd);

        Redis::setex('edu:persos:' . $application->hashid() . ':' . $studentNo, 7 * 86400, json_encode($persos));
        Redis::setex('edu:scores:' . $application->hashid() . ':' . $studentNo, 7 * 86400, json_encode($scores));
        Redis::setex('edu:tables:' . $application->hashid() . ':' . $studentNo, 7 * 86400, json_encode($tables));

        return redirect()->route('mobile.show', ['appid' => $application->hashid(), 'studentNo' => $studentNo]);
    }

    /**
     * 显示
     *
     * @param  Request $request
     * @return void
     */
    public function show(Request $request)
    {
        $studentNo = $request->input('studentNo');
        $appid     = Hashids::decode($request->input('appid')); // 学校

        $application = Application::whereId($appid)->first();
        if (!$application) {
            return redirect()->route('mobile.index');
        }

        $persos = json_decode(Redis::get('edu:persos:' . $application->hashid() . ':' . $studentNo), true);
        $scores = json_decode(Redis::get('edu:scores:' . $application->hashid() . ':' . $studentNo), true);
        $tables = json_decode(Redis::get('edu:tables:' . $application->hashid() . ':' . $studentNo), true);

        return view('mobile.show', ['application' => $application, 'persos' => $persos, 'scores' => $scores, 'tables' => $tables]);
    }
}
