<?php

namespace App\Edu;

use App\Models\Application;
use App\Models\School;
use App\Models\Score;
use App\Models\Table;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Edu extends EduProvider
{
    /**
     * 教务映射
     *
     * @var string[]
     */
    private static $driver = [
        // 正方教务
        'czxy'       => \App\Edu\ZF\Czxy::class,
        'scdxjjxy'   => \App\Edu\ZF\Scdxjjxy::class,
        // 青果教务
        'llxy'       => \App\Edu\KG\Llxy::class,
        'xnkjdxcsxy' => \App\Edu\KG\Xnkjdxcsxy::class,
        'hnkfkjcmxy' => \App\Edu\KG\Hnkfkjcmxy::class,
        'zzjmxy'     => \App\Edu\KG\Zzjmxy::class,
        'ahwdxxgcxy' => \App\Edu\KG\Ahwdxxgcxy::class,
        // URP教务
        'hblgdx'     => \App\Edu\URP\Hblgdx::class,
        'zjyesfzkxx' => \App\Edu\URP\Zjyesfzkxx::class,
        // 树维
        'ahsfdx'     => \App\Edu\SW\Ahsfdx::class,
    ];

    /**
     * 应用
     *
     * @var object
     */
    private $application;

    /**
     * 教务对象
     *
     * @var object
     */
    private $eduObject;

    /**
     * 构造函数
     *
     * @param string $school
     */
    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->eduObject   = new self::$driver[pinyin_abbr($application->school->name)]($application);
    }

    /**
     * 是否需要验证码
     *
     * @return bool
     */
    public function isNeedCaptcha()
    {
        return $this->eduObject->isNeedCaptcha();
    }

    /**
     * 获取初始化cookie
     *
     * @return GuzzleHttp\Cookie\CookieJar
     */
    public function getCookie()
    {
        return $this->eduObject->getCookie();
    }

    /**
     * 设置cookie
     *
     * @param GuzzleHttp\Cookie\CookieJar $cookie
     */
    public function setCookie($cookie)
    {
        return $this->eduObject->setCookie($cookie);
    }

    /**
     * 获取验证码
     *
     * @return string 验证码Base64字符串
     */
    public function getCaptcha()
    {
        return $this->eduObject->getCaptcha();
    }

    /**
     * 获取登录信息
     *
     * @param  string  $studentNo 学号
     * @param  string  $password  密码
     * @param  string  $captcha   验证码
     * @return array
     */
    public function getLoginInfo($studentNo, $password, $captcha)
    {
        return $this->eduObject->getLoginInfo($studentNo, $password, $captcha);
    }

    /**
     * 获取学生信息
     *
     * @param  string  $studentNo 学号
     * @param  string  $password  密码
     * @return array
     */
    public function getPersosInfo($studentNo, $password)
    {
        try {
            $persos                     = $this->eduObject->getPersosInfo($studentNo, $password);
            $persos['gender']           = $persos['gender'] == '男' ? 1 : 2;
            $persos['student_no']       = $studentNo;
            $persos['student_password'] = $password;

            User::firstOrCreate(
                [
                    'application_id' => $this->application->id,
                    'school_id'      => $this->application->school->id,
                    'student_no'     => $persos['student_no'],
                ], $persos
            );

            return $persos;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return [];
        }
    }

    /**
     * 获取学生成绩
     *
     * @param  string  $studentNo 学号
     * @param  string  $password  密码
     * @return array
     */
    public function getScoresInfo($studentNo, $password)
    {
        try {
            $scores      = $this->eduObject->getScoresInfo($studentNo, $password);
            $application = $this->application;

            DB::transaction(function () use ($studentNo, $application, $scores) {
                foreach ($scores as $score) {
                    Score::firstOrCreate(
                        [
                            'application_id' => $application->id,
                            'school_id'      => $application->school->id,
                            'student_no'     => $studentNo,
                            'course_no'      => $score['course_no'],
                        ], $score
                    );
                }
            });

            return $scores;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return [];
        }
    }

    /**
     * 获取学生课表
     *
     * @param  string  $studentNo 学号
     * @param  string  $password  密码
     * @return array
     */
    public function getTablesInfo($studentNo, $password)
    {
        try {
            $tables      = $this->eduObject->getTablesInfo($studentNo, $password);
            $application = $this->application;

            if ($application->school->type != School::KG) {
                DB::transaction(function () use ($studentNo, $application, $tables) {
                    foreach ($tables as $table) {
                        Table::firstOrCreate(
                            [
                                'application_id' => $application->id,
                                'school_id'      => $application->school->id,
                                'student_no'     => $studentNo,
                                'week'           => $table['week'],
                                'section'        => $table['section'],
                                'course_name'    => $table['course_name'],
                            ], $table
                        );
                    }
                });
            }

            return $tables;
        } catch (Exception $e) {
            Log::info($e->getMessage());
            return [];
        }
    }
}
