<?php

namespace App\Edu;

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
        // URP教务
        'hblgdx'     => \App\Edu\URP\Hblgdx::class,
    ];

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
    public function __construct($school)
    {
        $this->eduObject = new self::$driver[pinyin_abbr($school)];
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
     * @param  string  $xh 学号
     * @param  string  $mm 密码
     * @param  string  $vm 验证码
     * @return array
     */
    public function getLoginInfo($xh, $mm, $vc)
    {
        return $this->eduObject->getLoginInfo($xh, $mm, $vc);
    }

    /**
     * 获取学生个人信息
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getPersosInfo($xh)
    {
        return $this->eduObject->getPersosInfo($xh);
    }

    /**
     * 获取学生成绩
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getScoresInfo($xh)
    {
        return $this->eduObject->getScoresInfo($xh);
    }

    /**
     * 获取学生课表
     *
     * @param  string   $xh 学号
     * @return string
     */
    public function getTablesInfo($xh)
    {
        return $this->eduObject->getTablesInfo($xh);
    }
}
