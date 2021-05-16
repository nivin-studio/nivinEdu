<?php

namespace App\Edu\ZF;

use App\Edu\EduParserInterface;
use App\Edu\EduProvider;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

class Czxy extends EduProvider implements EduParserInterface
{
    /**
     * 相关网络地址
     *
     * @var array
     */
    protected static $url = [
        'base'    => 'http://211.86.193.14',                     //根域名
        'cookie'  => 'http://211.86.193.14',                     //获取Cookie
        'captcha' => 'http://211.86.193.14/CheckCode.aspx',      //获取验证码
        'login'   => 'http://211.86.193.14/default2.aspx',       //获取登录信息
        'persos'  => 'http://211.86.193.14/xsgrxx.aspx?xh=#xh#', //获取学生信息
        'scores'  => 'http://211.86.193.14/xscjcx.aspx?xh=#xh#', //获取学生成绩
        'tables'  => 'http://211.86.193.14/tjkbcx.aspx?xh=#xh#', //获取学生课表
    ];

    /**
     * 是否需要验证码
     *
     * @return bool
     */
    public function isNeedCaptcha()
    {
        return true;
    }

    /**
     * 获取初始化cookie
     *
     * @return GuzzleHttp\Cookie\CookieJar
     */
    public function getCookie()
    {
        $this->cookie = new CookieJar;

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['cookie'], $options);

        return $this->cookie;
    }

    /**
     * 设置cookie
     *
     * @param GuzzleHttp\Cookie\CookieJar $cookie
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * 获取验证码
     *
     * @return string 验证码Base64字符串
     */
    public function getCaptcha()
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['captcha'], $options);
        $result   = $response->getBody();

        return $this->parserCaptchaImages($result);
    }

    /**
     * 解析验证码
     *
     * @param  string   $html
     * @return string
     */
    public function parserCaptchaImages($html)
    {
        $imageType   = getimagesizefromstring($html)['mime'];
        $imageBase64 = 'data:' . $imageType . ';base64,' . (base64_encode($html));

        return $imageBase64;
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
        $hidden = $this->getLoginHiddenValue($studentNo);

        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
            ],
            'form_params' => [
                '__VIEWSTATE'      => $hidden,
                'txtUserName'      => $studentNo,
                'TextBox2'         => $password,
                'txtSecretCode'    => $captcha,
                'RadioButtonList1' => '%D1%A7%C9%FA',
                'Button1'          => '',
                'lbLanguage'       => '',
                'hidPdrs'          => '',
                'hidsc'            => '',
            ],
        ];

        $response = $this->client->request('POST', self::$url['login'], $options);
        $result   = $response->getBody();

        return $this->parserLoginInfo($result);
    }

    /**
     * 解析登录信息
     *
     * @param  string           $html
     * @return (int|string)[]
     */
    public function parserLoginInfo($html)
    {
        $html = (string) iconv('gb2312', 'UTF-8', $html);

        if (preg_match('/欢迎您/', $html)) {
            return ['code' => 0, 'message' => '登录成功！'];
        } else if (preg_match('/验证码不正确/', $html)) {
            return ['code' => -1, 'message' => '验证码不正确！'];
        } else if (preg_match('/密码错误/', $html)) {
            return ['code' => -1, 'message' => '密码错误！'];
        } else if (preg_match('/用户名不存在/', $html)) {
            return ['code' => -1, 'message' => '用户名不存在！'];
        } else if (preg_match('/您的密码安全性较低/', $html)) {
            return ['code' => -1, 'message' => '密码安全性低,登录官方教务修改！'];
        } else {
            return ['code' => -1, 'message' => '登录错误,请稍后再试！'];
        }
    }

    /**
     * 获取登录隐藏信息
     *
     * @param  string  $studentNo 学号
     * @return array
     */
    public function getLoginHiddenValue($studentNo)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['login'], $options);
        $result   = $response->getBody();

        return $this->parserViewState($result);
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
        $url = str_replace('#xh#', $studentNo, self::$url['persos']);

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => $url,
            ],
        ];

        $response = $this->client->request('GET', $url, $options);
        $result   = $response->getBody();

        return $this->parserPersosInfo($result);
    }

    /**
     * 解析学生信息
     *
     * @param  string  $html
     * @return array
     */
    public function parserPersosInfo($html)
    {
        try {
            $htmlCrawler = new Crawler((string) $html);

            $persos = [
                'student_no'   => $htmlCrawler->filterXPath('//span[@id="xh"]')->text(''),        //学号
                'student_name' => $htmlCrawler->filterXPath('//span[@id="xm"]')->text(''),        //姓名
                'identity_no'  => $htmlCrawler->filterXPath('//span[@id="lbl_sfzh"]')->text(''),  //身份证
                'birth_date'   => $htmlCrawler->filterXPath('//span[@id="lbl_csrq"]')->text(''),  //出生日期                                                                                        //出生日期
                'gender'       => $htmlCrawler->filterXPath('//span[@id="lbl_xb"]')->text(''),    //性别
                'nation'       => $htmlCrawler->filterXPath('//span[@id="lbl_mz"]')->text(''),    //民族
                'education'    => $htmlCrawler->filterXPath('//span[@id="lbl_CC"]')->text(''),    //学历                                                                                               //学历
                'college'      => $htmlCrawler->filterXPath('//span[@id="lbl_xy"]')->text(''),    //学院
                'major'        => $htmlCrawler->filterXPath('//span[@id="lbl_zymc"]')->text(''),  //专业
                'class'        => $htmlCrawler->filterXPath('//span[@id="lbl_xzb"]')->text(''),   //班级
                'period'       => $htmlCrawler->filterXPath('//span[@id="lbl_xz"]')->text(''),    //学制
                'grade'        => $htmlCrawler->filterXPath('//span[@id="lbl_dqszj"]')->text(''), //年级
            ];

            return $persos;
        } catch (Exception $e) {
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
        $url    = str_replace('#xh#', $studentNo, self::$url['scores']);
        $hidden = $this->getScoresHiddenValue($studentNo);

        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
                'Referer'    => $url,
            ],
            'form_params' => [
                '__VIEWSTATE' => $hidden,
                'hidLanguage' => '',
                'ddlXN'       => '',
                'ddlXQ'       => '',
                'ddl_kcxz'    => '',
                'btn_zcj'     => iconv('utf-8', 'gb2312', '历年成绩'),
            ],
        ];

        $response = $this->client->request('POST', $url, $options);
        $result   = $response->getBody();

        return $this->parserScoresInfo($result);
    }

    /**
     * 解析学生成绩
     *
     * @param  string  $html
     * @return array
     */
    public function parserScoresInfo($html)
    {
        try {
            $scores      = [];
            $htmlCrawler = new Crawler((string) $html);
            $table       = $htmlCrawler->filterXPath('//table[@id="Datagrid1"]')->children();

            foreach ($table as $tableIndex => $tableNode) {
                if ($tableIndex != 0) {
                    $trCrawler = new Crawler($tableNode);
                    $scores[]  = [
                        'annual'      => $trCrawler->filterXPath('//td[1]')->text(''), // 学年
                        'term'        => $trCrawler->filterXPath('//td[2]')->text(''), // 学期
                        'course_no'   => $trCrawler->filterXPath('//td[3]')->text(''), // 课号
                        'course_name' => $trCrawler->filterXPath('//td[4]')->text(''), // 课名
                        'course_type' => $trCrawler->filterXPath('//td[5]')->text(''), // 课型
                        'score'       => $trCrawler->filterXPath('//td[9]')->text(''), // 成绩
                        'credit'      => $trCrawler->filterXPath('//td[7]')->text(''), // 学费
                        'gpa'         => $trCrawler->filterXPath('//td[8]')->text(''), // 绩点
                    ];
                }
            }

            return $scores;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * 获取成绩隐藏信息
     *
     * @param  string   $studentNo 学号
     * @return string
     */
    public function getScoresHiddenValue($studentNo)
    {
        $url = str_replace('#xh#', $studentNo, self::$url['scores']);

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => $url,
            ],
        ];

        $response = $this->client->request('GET', $url, $options);
        $result   = $response->getBody();

        return $this->parserViewState($result);
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
        $url = str_replace('#xh#', $studentNo, self::$url['tables']);

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => $url,
            ],
        ];

        $response = $this->client->request('GET', $url, $options);
        $result   = $response->getBody();

        return $this->parserTablesInfo($result);
    }

    /**
     * 解析学生课表
     *
     * @param  string  $html
     * @return array
     */
    public function parserTablesInfo($html)
    {
        try {
            $tables      = [];
            $tempSection = [];
            $tempPeriod  = 0;
            $tempWeek    = 0;
            $htmlCrawler = new Crawler((string) $html);
            $trArr       = $htmlCrawler->filterXPath('//table[@id="Table6"]')->children();

            foreach ($trArr as $trIndex => $trNode) {
                if ($trIndex <= 1) {
                    continue;
                }
                $tdArr = (new Crawler($trNode))->children();

                foreach ($tdArr as $trIndex => $tdNode) {
                    $tempWeek++;
                    $tdCrawler = new Crawler($tdNode);
                    $tdText    = $tdCrawler->html('');
                    // 解析时段
                    if (preg_match('/(上午|下午|晚上)/', $tdText, $periodMatches)) {
                        $tempPeriod = $periodMatches[1];
                        continue;
                    }
                    // 解析节次 和 时间
                    if (preg_match('/^第(\d{1,2})节/', $tdText, $sectionMatches)) {
                        $tempSection['section'] = intval($sectionMatches[1]);
                        $tempWeek               = 0;
                        continue;
                    }
                    // 解析课程相关信息
                    if (preg_match('/([^%]*)<br>([^%]*)<br>([^%]*)<br>([^%]*)<br>([^%]*)/', $tdText, $courseMatches)) {
                        $rowspan = $tdCrawler->attr('rowspan') ?: 1;
                        for ($i = 0; $i < intval($rowspan); $i++) {
                            $tables[] = [
                                'period'      => $tempPeriod,                  // 时段
                                'week'        => $tempWeek,                    // 星期
                                'section'     => $tempSection['section'] + $i, // 节次
                                'time'        => '',                           // 时间
                                'course_name' => $courseMatches[1],            // 课名
                                'course_type' => $courseMatches[2],            // 课型
                                'week_period' => $courseMatches[3],            // 周段
                                'teacher'     => $courseMatches[4],            // 老师
                                'location'    => $courseMatches[5],            // 地点
                            ];
                        }
                    }
                }
            }

            return $tables;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * 解析隐藏信息
     *
     * @param  string   $html
     * @return string
     */
    public function parserViewState($html)
    {
        try {
            $htmlCrawler = new Crawler((string) $html);

            return $htmlCrawler->filterXPath('//input[@name="__VIEWSTATE"]')->attr('value');
        } catch (Exception $e) {
            return '';
        }
    }
}
