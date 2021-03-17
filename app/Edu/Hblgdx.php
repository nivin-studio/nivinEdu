<?php

namespace App\Edu;

use App\Edu\EduInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Illuminate\Support\Arr;
use Symfony\Component\DomCrawler\Crawler;

class Hblgdx implements EduInterface
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
        'grades_get'  => '/gradeLnAllAction.do',    //成绩
        'grades_post' => '/gradeLnAllAction.do',    //获取成绩
        'tables_get'  => '/bjKbInfoAction.do',      //课表
        'tables_post' => '/bjKbInfoAction.do',      //获取课表
    ];

    /**
     * 用户代理
     *
     * @var string
     */
    private static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36';

    /**
     * 网络请求客户端
     *
     * @var GuzzleHttp\Client
     */
    private $client;

    /**
     * 全局交互cookie
     *
     * @var GuzzleHttp\Cookie\CookieJar
     */
    private $cookie;

    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'base_uri' => self::$url['base'],
            ]
        );
    }

    public function getTablesInfo($xh)
    {}

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
    public function getVcCode()
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

        $imageType   = getimagesizefromstring($result)['mime'];
        $imageBase64 = 'data:' . $imageType . ';base64,' . (base64_encode($result));

        return $imageBase64;
    }

    /**
     * 登录
     *
     * @param  string  $xh 学号
     * @param  string  $mm 密码
     * @param  string  $vc 验证码
     * @return array
     */
    public function getLoginInfo($xh, $mm, $vc)
    {
        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['login'],
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

        return $this->parserLoginInfo($response->getBody());
    }

    /**
     * 获取登录隐藏值
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getLoginHiddenValue($xh)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['base'],
            ],
        ];

        $response = $this->client->request('GET', self::$url['login'], $options);

        return $this->parserLoginHiddenValue($response->getBody());
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

        $response = $this->client->request('GET', self::$url['persos_post'], $options);

        return $this->parserPersosInfo($response->getBody());
    }

    /**
     * 获取学生成绩
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getGradesInfo($xh)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['grades_get'],
            ],
            'query'   => [
                'type'   => 'ln',
                'oper'   => 'qbinfo',
                'lnxndm' => '',
            ],
        ];

        $response = $this->client->request('GET', self::$url['grades_get'], $options);

        return $this->parserGradesInfo($response->getBody());
    }

    /**
     * 获取学生成绩图片
     *
     * @param  string   $url 图片url
     * @return string
     */
    public function getGradesImages($url)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['grades_post'],
            ],
        ];

        $response = $this->client->request('GET', self::$url['grades_img'] . $url, $options);
        $result   = $response->getBody();

        $imageType   = getimagesizefromstring($result)['mime'];
        $imageBase64 = 'data:' . $imageType . ';base64,' . (base64_encode($result));

        return $imageBase64;
    }

    /**
     * 获取学生课表图片
     *
     * @param  string   $url 图片url
     * @return string
     */
    public function getTablesImages($url)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['tables_post'],
            ],
        ];

        $response = $this->client->request('GET', self::$url['tables_img'] . $url, $options);
        $result   = $response->getBody();

        $imageType   = getimagesizefromstring($result)['mime'];
        $imageBase64 = 'data:' . $imageType . ';base64,' . (base64_encode($result));

        return $imageBase64;
    }

    /**
     * 解析登录信息
     *
     * @param  string           $html
     * @return (int|string)[]
     */
    public function parserLoginInfo($html)
    {
        if (preg_match("/mainFrame/", $html)) {
            return ['code' => 0, 'msg' => '登录成功！'];
        } else if (preg_match("/数据库忙请稍候再试/", $html)) {
            return ['code' => -1, 'msg' => '数据库忙,请稍候再试!'];
        } else if (preg_match("/验证码不正确/", $html)) {
            return ['code' => -1, 'msg' => '验证码不正确！'];
        } else if (preg_match("/密码错误/", $html)) {
            return ['code' => -1, 'msg' => '密码错误！'];
        } else if (preg_match("/用户名不存在/", $html)) {
            return ['code' => -1, 'msg' => '用户名不存在！'];
        } else if (preg_match("/您的密码安全性较低/", $html)) {
            return ['code' => -1, 'msg' => '密码安全性低,登录官方教务修改！'];
        } else {
            return ['code' => -1, 'msg' => '登录错误,请稍后再试！'];
        }
    }

    /**
     * 解析学生个人信息
     *
     * @param  string  $html
     * @return array
     */
    public function parserPersosInfo($html)
    {
        $crawler = new Crawler((string) $html);

        $info = [
            'xh' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[1]/td[2]')->text(),         //学号
            'xm' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[1]/td[4]')->text(),         //姓名
            'xb' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[4]/td[2]')->text(),         //性别
            'sf' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[3]/td[4]')->text(),         //身份证
            'sr' => '1979-01-01',                                                                                                      //出生日期
            'mz' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[1]/tr[2]//table/tr[6]/td[2]')->text() ?: null, //民族
            'xl' => '',                                                                                                      //学历
            'xy' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[1]/td[4]')->text() ?: null, //学院
            'zy' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[2]/td[2]')->text() ?: null, //专业
            'bj' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[3]/td[4]')->text() ?: null, //班级
            'xz' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[9]/td[2]')->text() ?: null, //学制
            'nj' => $crawler->filterXPath('//table[@class="fieldsettop"]//table[2]/tr[2]//table/tr[8]/td[4]')->text() ?: null, //年级
        ];

        return $info;
    }

    /**
     * 解析学生成绩
     *
     * @param  string  $html
     * @return array
     */
    public function parserGradesInfo($html)
    {
        try {
            $crawler = new Crawler((string) iconv('gbk', 'UTF-8', $html));

            $data = [];

            $crawler->filterXPath('//table[@id="user"]')->each(function (Crawler $tableNode, $tableIndex) use (&$data) {
                $tr = $tableNode->children();
                foreach ($tr as $trIndex => $trNode) {
                    if ($trIndex == 0) {
                        continue;
                    }

                    $trCrawler = new Crawler($trNode);

                    $data[] = [
                        'xn' => '',
                        'xq' => 0,
                        'kh' => $trCrawler->filterXPath('//td[1]')->text(),
                        'km' => $trCrawler->filterXPath('//td[3]')->text(),
                        'kx' => $trCrawler->filterXPath('//td[6]')->text(),
                        'xf' => $trCrawler->filterXPath('//td[5]')->text(),
                        'jd' => 0,
                        'cj' => $trCrawler->filterXPath('//td[7]')->text(),
                    ];
                }
            });

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 解析获取学生课表
     *
     * @param  string   $html
     * @return string
     */
    public function parserTablesInfo($html)
    {
        $crawler = new Crawler((string) $html);

        try {
            $url = $crawler->filterXPath('//img')->attr('src');
            return $this->getTablesImages($url);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * 解析登录隐藏值
     *
     * @param  string   $html
     * @return string
     */
    public function parserLoginHiddenValue($html)
    {
        $crawler = new Crawler((string) $html);

        $value = [
            '__VIEWSTATE'          => $crawler->filterXPath('//input[@name="__VIEWSTATE"]')->attr('value'),
            '__EVENTVALIDATION'    => $crawler->filterXPath('//input[@name="__EVENTVALIDATION"]')->attr('value'),
            '__VIEWSTATEGENERATOR' => $crawler->filterXPath('//input[@name="__VIEWSTATEGENERATOR"]')->attr('value'),
            'txt_mm_expression'    => $crawler->filterXPath('//input[@name="txt_mm_expression"]')->attr('value'),
            'txt_mm_length'        => $crawler->filterXPath('//input[@name="txt_mm_length"]')->attr('value'),
            'txt_mm_userzh'        => $crawler->filterXPath('//input[@name="txt_mm_userzh"]')->attr('value'),
            'dsdsdsdsdxcxdfgfg'    => $crawler->filterXPath('//input[@name="dsdsdsdsdxcxdfgfg"]')->attr('value'),
            'fgfggfdgtyuuyyuuckjg' => $crawler->filterXPath('//input[@name="fgfggfdgtyuuyyuuckjg"]')->attr('value'),
        ];

        return $value;
    }

}
