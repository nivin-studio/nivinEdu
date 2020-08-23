<?php

namespace App\Edu;

interface EduInterface
{
    /**
     * 获取初始化cookie
     *
     * @return GuzzleHttp\Cookie\CookieJar
     */
    public function getCookie();

    /**
     * 设置cookie
     *
     * @param GuzzleHttp\Cookie\CookieJar $cookie
     */
    public function setCookie($cookie);

    /**
     * 获取验证码
     *
     * @return string 验证码Base64字符串
     */
    public function getVcCode();

    /**
     * 获取登录信息
     *
     * @param  string  $xh 学号
     * @param  string  $mm 密码
     * @param  string  $vm 验证码
     * @return array
     */
    public function getLoginInfo($xh, $mm, $vc);

    /**
     * 获取学生个人信息
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getPersosInfo($xh);

    /**
     * 获取学生成绩
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getGradesInfo($xh);

    /**
     * 获取学生课表
     *
     * @param  string   $xh 学号
     * @return string
     */
    public function getTablesInfo($xh);

    /**
     * 解析登录信息
     *
     * @param  string           $html
     * @return (int|string)[]
     */
    public function parserLoginInfo($html);

    /**
     * 解析学生个人信息
     *
     * @param  string  $html
     * @return array
     */
    public function parserPersosInfo($html);

    /**
     * 解析学生成绩
     *
     * @param  string  $html
     * @return array
     */
    public function parserGradesInfo($html);

    /**
     * 解析获取学生课表
     *
     * @param  string   $html
     * @return string
     */
    public function parserTablesInfo($html);
}
