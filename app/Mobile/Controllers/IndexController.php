<?php

namespace App\Mobile\Controllers;

use App\Edu\Edu;
use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Score;
use App\Models\Table;
use App\Models\User;
use Exception;
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
        $xx = $request->input('xx');

        $school = School::where('name', $xx)->first();
        if (!$school) {
            return redirect()->route('mobile.index');
        }

        $edu = new Edu($school->name);
        // 获取cookie
        $cookie = $edu->getCookie();
        // 获取验证码
        $captcha = $edu->getCaptcha();
        // 序列化cookie对象
        $cookieObj = serialize($cookie);
        // 存储了cookie对象
        Session::put('cookieObj', $cookieObj);

        return view('mobile.login', ['school' => $school, 'captcha' => $captcha]);
    }

    /**
     * 登录页面
     *
     * @param  Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $xh = $request->input('xh'); // 学号
        $mm = $request->input('mm'); // 密码
        $vm = $request->input('vm'); // 验证码
        $xx = $request->input('xx'); // 学校

        $school = School::where('name', $xx)->first();
        if (!$school) {
            return redirect()->route('mobile.index');
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
            return redirect()->route('mobile.index');
        }

        // 获取学生信息
        $persos = $edu->getPersosInfo($xh);
        // 获取成绩信息
        $scores = $edu->getScoresInfo($xh);
        // 获取课表信息
        $tables = $edu->getTablesInfo($xh);

        $persos['student_password'] = $mm;

        Redis::setex('edu:persos:' . $school->id . ':' . $xh, 7 * 86400, json_encode($persos));
        Redis::setex('edu:scores:' . $school->id . ':' . $xh, 7 * 86400, json_encode($scores));
        Redis::setex('edu:tables:' . $school->id . ':' . $xh, 7 * 86400, json_encode($tables));

        $this->savePersos($xh, $school, $persos);
        $this->saveScores($xh, $school, $scores);
        $this->saveTables($xh, $school, $tables);

        return redirect()->route('mobile.show', ['xx' => $school->name, 'xh' => $xh]);
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
            return redirect()->route('mobile.index');
        }

        $persos = json_decode(Redis::get('edu:persos:' . $school->id . ':' . $xh), true);
        $scores = json_decode(Redis::get('edu:scores:' . $school->id . ':' . $xh), true);
        $tables = json_decode(Redis::get('edu:tables:' . $school->id . ':' . $xh), true);

        return view('mobile.show', ['school' => $school, 'persos' => $persos, 'scores' => $scores, 'tables' => $tables]);
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
            $persos['gender']    = $persos['gender'] == '男' ? 1 : 2;

            return User::firstOrCreate(
                [
                    'school_id'  => $persos['school_id'],
                    'student_no' => $persos['student_no'],
                ], $persos
            );
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    /**
     * 保存学生个人成绩
     *
     * @param  mixed  $school
     * @param  mixed  $scores
     * @return void
     */
    public function saveScores($xh, $school, $scores)
    {
        try {
            DB::transaction(function () use ($xh, $school, $scores) {
                foreach ($scores as $score) {
                    Score::firstOrCreate(
                        [
                            'school_id'  => $school->id,
                            'student_no' => $xh,
                            'course_no'  => $score['course_no'],
                        ], $score
                    );
                }
            });
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }

    /**
     * 保存学生个人课表
     *
     * @param  mixed  $school
     * @param  mixed  $tables
     * @return void
     */
    public function saveTables($xh, $school, $tables)
    {
        try {
            DB::transaction(function () use ($xh, $school, $tables) {
                foreach ($tables as $table) {
                    Table::firstOrCreate(
                        [
                            'school_id'   => $school->id,
                            'student_no'  => $xh,
                            'week'        => $table['week'],
                            'section'     => $table['section'],
                            'course_name' => $table['course_name'],
                        ], $table
                    );
                }
            });
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return false;
        }
    }
}
