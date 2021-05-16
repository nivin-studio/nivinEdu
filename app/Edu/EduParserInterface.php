<?php

namespace App\Edu;

interface EduParserInterface
{
    /**
     * 解析验证码
     *
     * @param  string   $html
     * @return string
     */
    public function parserCaptchaImages($html);

    /**
     * 解析登录信息
     *
     * @param  string           $html
     * @return (int|string)[]
     */
    public function parserLoginInfo($html);

    /**
     * 解析学生信息
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
    public function parserScoresInfo($html);

    /**
     * 解析学生课表
     *
     * @param  string   $html
     * @return string
     */
    public function parserTablesInfo($html);
}
