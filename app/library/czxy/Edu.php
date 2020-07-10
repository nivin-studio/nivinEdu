<?php

namespace czxy;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;
use \GuzzleHttp\Cookie\CookieJar;

class Edu
{
    /**
     * 相关网络地址
     *
     * @var array
     */
    private static $url = [
        'base'        => 'http://211.86.193.14',                //根域名
        'code'        => 'http://211.86.193.14/CheckCode.aspx', //验证码
        'login'       => 'http://211.86.193.14/default2.aspx',  //登录
        'main'        => 'http://211.86.193.14/xs_main.aspx',   //登录后的主页
        'persos_get'  => 'http://211.86.193.14/xsgrxx.aspx',    //个人信息
        'persos_post' => 'http://211.86.193.14/xsgrxx.aspx',    //获取个人信息
        'grades_get'  => 'http://211.86.193.14/xscjcx.aspx',    //成绩
        'grades_post' => 'http://211.86.193.14/xscjcx.aspx',    //获取成绩
        'tables_get'  => 'http://211.86.193.14/tjkbcx.aspx',    //课表
        'tables_post' => 'http://211.86.193.14/tjkbcx.aspx',    //获取课表
    ];

    /**
     * 用户代理
     *
     * @var string
     */
    private static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36';

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

        $response = $this->client->request('GET', self::$url['base'], $options);

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
     * @param  string  $vm 验证码
     * @return array
     */
    public function login($xh, $mm, $vm)
    {
        $viewstate = $this->getLoginHiddenValue($xh);

        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
            ],
            'form_params' => [
                '__VIEWSTATE'      => $viewstate,
                'txtUserName'      => $xh,
                'TextBox2'         => $mm,
                'txtSecretCode'    => $vm,
                'RadioButtonList1' => "%D1%A7%C9%FA",
                'Button1'          => "",
                'lbLanguage'       => "",
                'hidPdrs'          => "",
                'hidsc'            => "",
            ],
        ];

        $response = $this->client->request('POST', self::$url['login'], $options);

        return iconv('gb2312', 'UTF-8', $response->getBody());
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
            ],
        ];

        $response = $this->client->request('GET', self::$url['login'], $options);

        return $this->parserViewState($response->getBody());
    }

    /**
     * 获取学生个人信息
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getPersosInfo($xh)
    {
        $url = self::$url['persos_get'] . '?xh=' . $xh;

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => $url,
            ],

        ];

        $response = $this->client->request('GET', $url, $options);

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
        $url       = self::$url['grades_post'] . '?xh=' . $xh;
        $viewstate = $this->getGradesHiddenValue($xh);

        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
                'Referer'    => $url,
            ],
            'form_params' => [
                '__VIEWSTATE' => $viewstate,
                'hidLanguage' => "",
                'ddlXN'       => "",
                'ddlXQ'       => "",
                'ddl_kcxz'    => "",
                'btn_zcj'     => iconv('utf-8', 'gb2312', '历年成绩'),
            ],
        ];

        $response = $this->client->request('POST', $url, $options);

        return $this->parserGradesInfo($response->getBody());
    }

    /**
     * 获取成绩隐藏值
     *
     * @param  string   $xh 学号
     * @return string
     */
    public function getGradesHiddenValue($xh)
    {
        $url = self::$url['grades_get'] . '?xh=' . $xh;

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => $url,
            ],
        ];

        $response = $this->client->request('GET', $url, $options);

        return $this->parserViewState($response->getBody());
    }

    /**
     * 获取学生课表
     *
     * @param  string   $xh 学号
     * @return string
     */
    public function getTablesInfo($xh)
    {
        $url = self::$url['tables_get'] . '?xh=' . $xh;

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => $url,
            ],
        ];

        $response = $this->client->request('GET', $url, $options);

        return $this->parserTablesInfo($response->getBody());
    }

    /**
     * 解析获取隐藏的__VIEWSTATE
     *
     * @param  string   $html
     * @return string
     */
    public function parserViewState($html)
    {
        $crawler = new Crawler((string) $html);
        return $crawler->filterXPath('//input[@name="__VIEWSTATE"]')->attr('value');
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
            'xh' => $crawler->filterXPath('//span[@id="xh"]')->html(),        //学号
            'xm' => $crawler->filterXPath('//span[@id="xm"]')->html(),        //姓名
            'xb' => $crawler->filterXPath('//span[@id="lbl_xb"]')->html(),    //性别
            'sr' => $crawler->filterXPath('//span[@id="lbl_csrq"]')->html(),  //出生日期
            'mz' => $crawler->filterXPath('//span[@id="lbl_mz"]')->html(),    //民族
            'xl' => $crawler->filterXPath('//span[@id="lbl_CC"]')->html(),    //学历
            'xy' => $crawler->filterXPath('//span[@id="lbl_xy"]')->html(),    //学院
            'zy' => $crawler->filterXPath('//span[@id="lbl_zymc"]')->html(),  //专业
            'bj' => $crawler->filterXPath('//span[@id="lbl_xzb"]')->html(),   //班级
            'xz' => $crawler->filterXPath('//span[@id="lbl_xz"]')->html(),    //学制
            'nj' => $crawler->filterXPath('//span[@id="lbl_dqszj"]')->html(), //年级
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
        $crawler = new Crawler((string) $html);
        $table   = $crawler->filterXPath('//table[@id="Datagrid1"]');
        $nodes   = $table->children();
        $data    = [];

        foreach ($nodes as $i => $node) {
            if ($i != 0) {
                $node   = new Crawler($node);
                $data[] = [
                    'xn' => $node->filterXPath('//td[1]')->html(),
                    'xq' => $node->filterXPath('//td[2]')->html(),
                    'kc' => $node->filterXPath('//td[3]')->html(),
                    'km' => $node->filterXPath('//td[4]')->html(),
                    'kx' => $node->filterXPath('//td[5]')->html(),
                    'xf' => $node->filterXPath('//td[7]')->html(),
                    'jd' => $node->filterXPath('//td[8]')->html(),
                    'cj' => $node->filterXPath('//td[9]')->html(),
                ];
            }
        }

        return $data;
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
        $table   = $crawler->filterXPath('//table[@id="Table6"]')->html();

        $result = '<table rules="all" border="1">' . $table . '</table>';

        return $result;
    }
}
