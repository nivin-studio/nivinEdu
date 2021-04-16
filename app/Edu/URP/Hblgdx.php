<?php

namespace App\Edu\URP;

use App\Edu\EduParserInterface;
use App\Edu\EduProvider;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

class Hblgdx extends EduProvider implements EduParserInterface
{
    /**
     * 相关网络地址
     *
     * @var array
     */
    private static $url = [
        'base'        => 'http://xjw1.ncst.edu.cn', //根域名
        'home'        => '/logout.do',              //首页，获取Cookie
        'code'        => '/validateCodeAction.do',  //验证码
        'login'       => '/loginAction.do',         //登录
        'persos_get'  => '/xjInfoAction.do',        //个人信息
        'persos_post' => '/xjInfoAction.do',        //获取个人信息
        'scores_get'  => '/gradeLnAllAction.do',    //成绩
        'scores_post' => '/gradeLnAllAction.do',    //获取成绩
        'tables_get'  => '/xkAction.do',            //课表
        'tables_post' => '/xkAction.do',            //获取课表
    ];

    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => self::$url['base'],
            ]
        );
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

        $response = $this->client->request('GET', self::$url['home'], $options);

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
                'Referer'    => self::$url['home'],
            ],
            'query'   => [
                'random' => lcg_value(),
            ],
        ];

        $response = $this->client->request('GET', self::$url['code'], $options);
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
     * @param  string  $xh 学号
     * @param  string  $mm 密码
     * @param  string  $vm 验证码
     * @return array
     */
    public function getLoginInfo($xh, $mm, $vc)
    {
        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['home'],
            ],
            'form_params' => [
                'zjh1'   => '',
                'tips'   => '',
                'lx'     => '',
                'evalue' => '',
                'eflag'  => '',
                'fs'     => '',
                'dzslh'  => '',
                'zjh'    => $xh,
                'mm'     => $mm,
                'v_yzm'  => $vc,
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
            return ['code' => 0, 'msg' => '登录成功！'];
        } else if (preg_match('/数据库忙请稍候再试/', $html)) {
            return ['code' => -1, 'msg' => '数据库忙,请稍候再试!'];
        } else if (preg_match('/验证码不正确/', $html)) {
            return ['code' => -1, 'msg' => '验证码不正确！'];
        } else if (preg_match('/密码错误/', $html)) {
            return ['code' => -1, 'msg' => '密码错误！'];
        } else if (preg_match('/用户名不存在/', $html)) {
            return ['code' => -1, 'msg' => '用户名不存在！'];
        } else if (preg_match('/您的密码安全性较低/', $html)) {
            return ['code' => -1, 'msg' => '密码安全性低,登录官方教务修改！'];
        } else {
            return ['code' => -1, 'msg' => '登录错误,请稍后再试！'];
        }
    }

    /**
     * 获取学生个人信息
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getPersosInfo($xh)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['persos_get'],
            ],
            'query'   => [
                'oper' => 'xjxx',
            ],
        ];

        $response = $this->client->request('GET', self::$url['persos_get'], $options);
        $result   = $response->getBody();

        return $this->parserPersosInfo($result);
    }

    /**
     * 解析学生个人信息
     *
     * @param  string  $html
     * @return array
     */
    public function parserPersosInfo($html)
    {
        try {
            $htmlCrawler = new Crawler((string) $html);

            $persos = [
                'student_no'   => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[1]/td[2]')->text(''), //学号
                'student_name' => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[1]/td[4]')->text(''), //姓名
                'identity_no'  => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[3]/td[4]')->text(''), //身份证
                'birth_date'   => '',                                                                                                      //出生日期
                'gender'       => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[4]/td[2]')->text(''), //性别
                'nation'       => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[6]/td[2]')->text(''), //民族
                'education'    => '',                                                                                                      //学历
                'college'      => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[1]/td[4]')->text(''), //学院
                'major'        => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[2]/td[2]')->text(''), //专业
                'class'        => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[3]/td[4]')->text(''), //班级
                'period'       => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[9]/td[2]')->text(''), //学制
                'grade'        => $htmlCrawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[8]/td[4]')->text(''), //年级
            ];

            return $persos;
        } catch (Exception $e) {
            return [];
        }
    }

    /**
     * 获取学生成绩
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getScoresInfo($xh)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['scores_get'],
            ],
            'query'   => [
                'type'   => 'ln',
                'oper'   => 'qbinfo',
                'lnxndm' => '',
            ],
        ];

        $response = $this->client->request('GET', self::$url['scores_get'], $options);
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

                $isMatched = preg_match('/(\d{4}-\d{4})学年(秋|春)/', $str, $matches);
                if ($isMatched) {
                    $term[$tableIndex] = [
                        'annual' => $matches[1],
                        'term'   => $matches[2] == '秋' ? 1 : 2,
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
     * @param  string   $xh 学号
     * @return string
     */
    public function getTablesInfo($xh)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['tables_get'],
            ],
            'query'   => [
                'actionType' => 6,
            ],
        ];

        $response = $this->client->request('GET', self::$url['tables_get'], $options);
        $result   = $response->getBody();

        return $this->parserTablesInfo($result);
    }

    /**
     * 解析获取学生课表
     *
     * @param  string   $html
     * @return string
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
