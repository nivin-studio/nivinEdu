<?php

namespace App\Edu\URP;

use App\Edu\EduParserInterface;
use App\Edu\EduProvider;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

class Zjyesfzkxx extends EduProvider implements EduParserInterface
{
    /**
     * 相关网络地址
     *
     * @var array
     */
    protected static $url = [
        'base'    => 'http://219.129.32.7:9001', //根域名
        'cookie'  => '/logout.do',               //获取Cookie
        'captcha' => '/validateCodeAction.do',   //获取验证码
        'login'   => '/loginAction.do',          //获取登录信息
        'persos'  => '/xjInfoAction.do',         //获取学生信息
        'scores'  => '/gradeLnAllAction.do',     //获取学生成绩
        'tables'  => '/xkAction.do',             //获取学生课表
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
                'Referer'    => self::$url['cookie'],
            ],
            'query'   => [
                'random' => lcg_value(),
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
        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['cookie'],
            ],
            'form_params' => [
                'zjh1'   => '',
                'tips'   => '',
                'lx'     => '',
                'evalue' => '',
                'eflag'  => '',
                'fs'     => '',
                'dzslh'  => '',
                'zjh'    => $studentNo,
                'mm'     => $password,
                'v_yzm'  => $captcha,
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
        if (preg_match('/mainFrame/', $html)) {
            return ['code' => 0, 'message' => '登录成功！'];
        } else if (preg_match('/数据库忙请稍候再试/', $html)) {
            return ['code' => -1, 'message' => '数据库忙,请稍候再试!'];
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
     * 获取学生信息
     *
     * @param  string  $studentNo 学号
     * @param  string  $password  密码
     * @return array
     */
    public function getPersosInfo($studentNo, $password)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['persos'],
            ],
            'query'   => [
                'oper' => 'xjxx',
            ],
        ];

        $response = $this->client->request('GET', self::$url['persos'], $options);
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
                'student_no'   => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[1]/td[2]')->text(''),  //学号
                'student_name' => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[1]/td[4]')->text(''),  //姓名
                'identity_no'  => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[3]/td[4]')->text(''),  //身份证
                'birth_date'   => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[7]/td[4]')->text(''),  //出生日期
                'gender'       => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[4]/td[2]')->text(''),  //性别
                'nation'       => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[6]/td[4]')->text(''),  //民族
                'education'    => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[19]/td[4]')->text(''), //学历
                'college'      => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[13]/td[4]')->text(''), //学院
                'major'        => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[14]/td[2]')->text(''), //专业
                'class'        => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[15]/td[4]')->text(''), //班级
                'period'       => '',                                                                                                       //学制
                'grade'        => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[15]/td[2]')->text(''), //年级
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
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['scores'],
            ],
            'query'   => [
                'type'   => 'ln',
                'oper'   => 'qbinfo',
                'lnxndm' => '',
            ],
        ];

        $response = $this->client->request('GET', self::$url['scores'], $options);
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
            $term        = [];
            $html        = iconv('gbk', 'UTF-8', $html);
            $htmlCrawler = new Crawler((string) $html);

            // 解析学年学期
            $htmlCrawler->filterXPath('//table[@id="tblHead"]')->each(function (Crawler $tableNode, $tableIndex) use (&$term) {

                $str = $tableNode->filterXPath('//td[@valign="middle"]')->text('');

                $isMatched = preg_match('/(\d{4}-\d{4})学年第(一|二)学期/', $str, $matches);
                if ($isMatched) {
                    $term[$tableIndex] = [
                        'annual' => $matches[1],
                        'term'   => $matches[2] == '一' ? 1 : 2,
                    ];
                }
            });

            // 解析成绩相关信息
            $htmlCrawler->filterXPath('//table[@id="user"]')->each(function (Crawler $tableNode, $tableIndex) use (&$scores, $term) {

                $tr = $tableNode->children();
                foreach ($tr as $trIndex => $trNode) {
                    if ($trIndex == 0) {
                        continue;
                    }

                    $trCrawler = new Crawler($trNode);

                    $scores[] = [
                        'annual'      => $term[$tableIndex]['annual'],                 // 学年
                        'term'        => $term[$tableIndex]['term'],                   // 学期
                        'course_no'   => $trCrawler->filterXPath('//td[1]')->text(''), // 课号
                        'course_name' => $trCrawler->filterXPath('//td[3]')->text(''), // 课名
                        'course_type' => $trCrawler->filterXPath('//td[6]')->text(''), // 课型
                        'score'       => $trCrawler->filterXPath('//td[7]')->text(''), // 成绩
                        'credit'      => $trCrawler->filterXPath('//td[5]')->text(''), // 学费
                        'gpa'         => 0,                                            // 绩点
                    ];
                }
            });

            return $scores;
        } catch (Exception $e) {
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
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['tables'],
            ],
            'query'   => [
                'actionType' => 6,
            ],
        ];

        $response = $this->client->request('GET', self::$url['tables'], $options);
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
            $html        = iconv('gbk', 'UTF-8', $html);
            $html        = str_replace('GBK', 'UTF-8', $html);
            $htmlCrawler = new Crawler((string) $html);
            $trArr       = $htmlCrawler->filterXPath('//table[@id="user"]')->children();

            foreach ($trArr as $trIndex => $trNode) {
                if ($trIndex == 0) {
                    continue;
                }
                $tdArr = (new Crawler($trNode))->children();

                foreach ($tdArr as $trIndex => $tdNode) {
                    $tempWeek++;
                    $tdText = (new Crawler($tdNode))->text('');
                    // 解析时段
                    if (preg_match('/(上午|下午|晚上)/', $tdText, $periodMatches)) {
                        $tempPeriod = $periodMatches[1];
                        continue;
                    }
                    // 解析节次 和 时间
                    if (preg_match('/^第(\d{1,2})节\((\d{2}:\d{2}-\d{2}:\d{2})\)/', $tdText, $sectionMatches)) {
                        $tempSection['section'] = $sectionMatches[1];
                        $tempSection['time']    = $sectionMatches[2];
                        $tempWeek               = 0;
                        continue;
                    }
                    // 解析课名 和 上课地点
                    if (preg_match('/(\S*)\((\S*)\)/', $tdText, $courseMatches)) {
                        $tables[] = [
                            'period'      => $tempPeriod,             // 时段
                            'week'        => $tempWeek,               // 星期
                            'section'     => $tempSection['section'], // 节次
                            'time'        => $tempSection['time'],    // 时间
                            'course_name' => $courseMatches[1],       // 课名
                            'location'    => $courseMatches[2],       // 地点
                        ];
                    }
                }
            }

            return $tables;
        } catch (Exception $e) {
            return [];
        }
    }

}
