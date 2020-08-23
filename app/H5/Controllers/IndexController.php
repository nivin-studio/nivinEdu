<?php

namespace App\H5\Controllers;

use App\Edu\Edu;
use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    /**
     * 主页
     *
     * @return void
     */
    public function index()
    {
        $schools = School::all();
        return view('h5.index', ['schools' => $schools]);
    }

    /**
     * 学校
     *
     * @param  Request $request
     * @return void
     */
    public function school(Request $request)
    {
        $xx = $request->input('xx');

        $school = School::where('name', $xx)->first();
        if (!$school) {
            return redirect()->route('h5.index');
        }

        $edu = new Edu($school->name);
        // 获取cookie
        $cookie = $edu->getCookie();
        // 获取验证码
        $vccode = $edu->getVcCode();
        // 序列化cookie对象
        $cookieObj = serialize($cookie);
        // 存储了cookie对象
        Session::put('cookieObj', $cookieObj);

        return view('h5.login', ['school' => $school, 'vccode' => $vccode]);
    }

    /**
     * 登录页面
     *
     * @param  Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $xh = $request->input('xh');
        $mm = $request->input('mm');
        $vm = $request->input('vm');
        $xx = $request->input('xx');

        $school = School::where('name', $xx)->first();
        if (!$school) {
            return redirect()->route('h5.index');
        }

        $edu = new Edu($school->name);
        // 获取cookie对象
        $cookieObj = Session::get('cookieObj');
        // 反序列化cookie对象
        $cookieObj = unserialize($cookieObj);
        // 用存储的cookie对象
        $edu->setCookie($cookieObj);
        // 获取登录信息
        $res = $edu->getLoginInfo($xh, $mm, $vm);

        if ($res['code'] != 0) {
            Session::remove('cookieObj');
            return redirect()->route('h5.index');
        }

        // 获取学生信息
        $persos       = $edu->getPersosInfo($xh);
        $persos['mm'] = $mm;
        // 获取成绩信息
        $grades = $edu->getGradesInfo($xh);
        // 获取课表信息
        // $tables = $edu->getTablesInfo($xh);

        Redis::setex('edu:persos:' . $school->id . ':' . $xh, 7 * 86400, json_encode($persos));
        Redis::setex('edu:grades:' . $school->id . ':' . $xh, 7 * 86400, json_encode($grades));

        $this->savePersos($xh, $school, $persos);
        $this->saveGrades($xh, $school, $grades);

        return redirect()->route('h5.show', ['xx' => $school->name, 'xh' => $xh]);
    }

    /**
     * 显示
     *
     * @param  Request $request
     * @return void
     */
    public function show(Request $request)
    {
        $xh = $request->input('xh');
        $xx = $request->input('xx');

        $school = School::where('name', $xx)->first();
        if (!$school) {
            return redirect()->route('h5.index');
        }

        $persos = json_decode(Redis::get('edu:persos:' . $school->id . ':' . $xh), true);
        $grades = json_decode(Redis::get('edu:grades:' . $school->id . ':' . $xh), true);

        return view('h5.show', ['school' => $school, 'persos' => $persos, 'grades' => $grades]);
    }

    /**
     * 保存学生个人信息
     *
     * @param  mixed  $school
     * @param  mixed  $persos
     * @return void
     */
    public function savePersos($xh, $school, $persos)
    {
        try {
            $persos['school_id'] = $school->id;
            $persos['xb']        = $persos['xb'] == '男' ? 1 : 2;

            return User::firstOrCreate(
                [
                    'school_id' => $persos['school_id'],
                    'xh'        => $persos['xh'],
                ], $persos
            );
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    /**
     * 保存学生个人成绩
     *
     * @param  mixed  $school
     * @param  mixed  $grades
     * @return void
     */
    public function saveGrades($xh, $school, $grades)
    {
        try {
            DB::transaction(function () use ($xh, $school, $grades) {
                foreach ($grades as $grade) {
                    Grade::firstOrCreate(
                        [
                            'school_id' => $school->id,
                            'xh'        => $xh,
                            'kh'        => $grade['kh'],
                        ], $grade
                    );
                }
            });
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }
}
