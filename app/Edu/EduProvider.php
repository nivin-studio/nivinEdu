<?php

namespace App\Edu;

abstract class EduProvider
{
    /**
     * 用户代理
     *
     * @var string
     */
    protected static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36';

    /**
     * 网络请求客户端
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * 全局交互cookie
     *
     * @var GuzzleHttp\Cookie\CookieJar
     */
    protected $cookie;

    /**
     * 获取初始化cookie
     *
     * @return GuzzleHttp\Cookie\CookieJar
     */
    abstract public function getCookie();

    /**
     * 设置cookie
     *
     * @param GuzzleHttp\Cookie\CookieJar $cookie
     */
    abstract public function setCookie($cookie);

    /**
     * 获取验证码
     *
     * @return string 验证码Base64字符串
     */
    abstract public function getCaptcha();

    /**
     * 获取登录信息
     *
     * @param  string  $xh 学号
     * @param  string  $mm 密码
     * @param  string  $vm 验证码
     * @return array
     */
    abstract public function getLoginInfo($xh, $mm, $vc);

    /**
     * 获取学生个人信息
     *
     * @param  string  $xh 学号
     * @return array
     */
    abstract public function getPersosInfo($xh);

    /**
     * 获取学生成绩
     *
     * @param  string  $xh 学号
     * @return array
     */
    abstract public function getScoresInfo($xh);

    /**
     * 获取学生课表
     *
     * @param  string   $xh 学号
     * @return string
     */
    abstract public function getTablesInfo($xh);
}
