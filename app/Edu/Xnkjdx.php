<?php

namespace App\Edu;

use App\Edu\EduInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

class Xnkjdx implements EduInterface
{
    /**
     * 相关网络地址
     *
     * @var array
     */
    private static $url = [
        'base'        => 'http://jwgl.ccswust.edu.cn', //根域名
        'home'        => '/home.aspx',                 //首页，获取Cookie
        'code'        => '/sys/ValidateCode.aspx',     //验证码
        'login'       => '/_data/login_home.aspx',     //登录
        'main'        => '/MAINFRM.aspx',              //登录后的主页
        'menu'        => '/SYS/menu.aspx',             //侧边菜单
        'persos_get'  => '/xsxj/Stu_MyInfo.aspx',      //个人信息
        'persos_post' => '/xsxj/Stu_MyInfo_RPT.aspx',  //获取个人信息
        'grades_get'  => '/xscj/Stu_MyScore.aspx',     //成绩
        'grades_post' => '/xscj/Stu_MyScore_rpt.aspx', //获取成绩
        'grades_img'  => '/xscj/',                     //成绩图片根路径
        'tables_get'  => '/znpk/Pri_StuSel.aspx',      //课表
        'tables_post' => '/znpk/Pri_StuSel_rpt.aspx',  //获取课表
        'tables_img'  => '/znpk/',                     //课表图片根路径
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
                'Referer'    => self::$url['login'],
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
        $value = $this->getLoginHiddenValue($xh);

        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['login'],
            ],
            'form_params' => [
                '__VIEWSTATE'              => $value['__VIEWSTATE'],
                '__EVENTVALIDATION'        => $value['__EVENTVALIDATION'],
                'pcInfo'                   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36undefined5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36 SN:NULL',
                'txt_mm_expression'        => $value['txt_mm_expression'],
                'txt_mm_length'            => $value['txt_mm_length'],
                'txt_mm_userzh'            => $value['txt_mm_userzh'],
                'typeName'                 => urlencode(iconv('UTF-8', 'gb2312', '学生')),
                'dsdsdsdsdxcxdfgfg'        => $this->generateEncryptValue($mm, $xh),
                'fgfggfdgtyuuyyuuckjg'     => $this->generateEncryptValue(strtoupper($vc)),
                'Sel_Type'                 => 'STU',
                'txt_asmcdefsddsd'         => $xh,
                'txt_pewerwedsdfsdff'      => '',
                'txt_psasas'               => urlencode(iconv('UTF-8', 'gb2312', '请输入密码')),
                'txt_sdertfgsadscxcadsads' => '',
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
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['grades_get'],
            ],
            'form_params' => [
                'SJ'             => '0',
                'btn_search'     => urlencode(iconv('UTF-8', 'gb2312', '检索')),
                'SelXNXQ'        => '0',
                'zfx_flag'       => '0',
                'shownocomputjd' => '1',
                'zxf'            => '0',
                'hidparam_xh'    => '',
            ],
        ];

        $response = $this->client->request('POST', self::$url['grades_post'], $options);

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
     * 获取学生课表
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getTablesInfo($xh)
    {
        $values = $this->getTablesHiddenValue($xh);
        $data   = [];

        foreach ($values as $value) {
            $options = [
                'cookies'     => $this->cookie,
                'headers'     => [
                    'User-Agent' => self::$userAgent,
                    'Referer'    => self::$url['tables_get'],
                ],
                'form_params' => [
                    'Sel_XNXQ' => $value['xnxq'],
                    'rad'      => 0,
                    'px'       => 0,
                    'hidyzm'   => $value['hidyzm'],
                    'hidsjyzm' => $value['hidsjyzm'],
                    'txt_yzm'  => '',
                ],
            ];

            $response = $this->client->request('POST', self::$url['tables_post'] . '?m=' . $value['randostr'], $options);

            $info = $this->parserTablesInfo($response->getBody());
            if (!empty($info)) {
                $data[] = $info;
            }
        }

        return $data;
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
     * 获取课表查询隐藏值
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getTablesHiddenValue($xh)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['menu'],
            ],
        ];

        $response = $this->client->request('GET', self::$url['tables_get'], $options);

        return $this->parserTablesHiddenValue($response->getBody());
    }

    /**
     * 解析登录信息
     *
     * @param  string           $html
     * @return (int|string)[]
     */
    public function parserLoginInfo($html)
    {

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
            'xh' => $crawler->filterXPath('//table/tr[2]/td[2]')->text(),  //学号
            'xm' => $crawler->filterXPath('//table/tr[2]/td[4]')->text(),  //姓名
            'xb' => $crawler->filterXPath('//table/tr[4]/td[2]')->text(),  //性别
            'sr' => $crawler->filterXPath('//table/tr[5]/td[2]')->text(),  //出生日期
            'mz' => $crawler->filterXPath('//table/tr[5]/td[4]')->text(),  //民族
            'xl' => $crawler->filterXPath('//table/tr[22]/td[6]')->text(), //学历
            'xy' => $crawler->filterXPath('//table/tr[25]/td[2]')->text(), //学院
            'zy' => $crawler->filterXPath('//table/tr[25]/td[4]')->text(), //专业
            'bj' => $crawler->filterXPath('//table/tr[25]/td[6]')->text(), //班级
            'xz' => $crawler->filterXPath('//table/tr[20]/td[6]')->text(), //学制
            'nj' => $crawler->filterXPath('//table/tr[21]/td[2]')->text(), //年级
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

        return $crawler->filterXPath('//img')->each(function (Crawler $nodeCrawler, $i) {
            return $this->getGradesImages($nodeCrawler->attr('src'));
        });
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
            'txt_mm_expression'    => $crawler->filterXPath('//input[@name="txt_mm_expression"]')->attr('value'),
            'txt_mm_length'        => $crawler->filterXPath('//input[@name="txt_mm_length"]')->attr('value'),
            'txt_mm_userzh'        => $crawler->filterXPath('//input[@name="txt_mm_userzh"]')->attr('value'),
            'dsdsdsdsdxcxdfgfg'    => $crawler->filterXPath('//input[@name="dsdsdsdsdxcxdfgfg"]')->attr('value'),
            'fgfggfdgtyuuyyuuckjg' => $crawler->filterXPath('//input[@name="fgfggfdgtyuuyyuuckjg"]')->attr('value'),
        ];

        return $value;
    }

    /**
     * 解析课表查询隐藏值
     *
     * @param  string  $html
     * @return array
     */
    public function parserTablesHiddenValue($html)
    {
        $crawler = new Crawler((string) $html);

        $hyzm = $crawler->filterXPath('//input[@name="hidyzm"]')->attr('value');
        $xnxq = $crawler->filterXPath('//select[@name="Sel_XNXQ"]/option')->each(function (Crawler $nodeCrawler, $i) {
            return $nodeCrawler->attr('value');
        });

        $value = [];

        if (is_array($xnxq)) {
            foreach ($xnxq as $xn) {
                $randostr = $this->randomStr();
                $hidsjyzm = strtoupper(md5('14045' . $xn . $randostr));

                $value[] = [
                    'hidyzm'   => $hyzm,
                    'xnxq'     => $xn,
                    'randostr' => $randostr,
                    'hidsjyzm' => $hidsjyzm,
                ];
            }
        } else {
            $randostr = $this->randomStr();
            $hidsjyzm = strtoupper(md5('14045' . $xnxq . $randostr));

            $value[] = [
                'hidyzm'   => $hyzm,
                'xnxq'     => $xnxq,
                'randostr' => $randostr,
                'hidsjyzm' => $hidsjyzm,
            ];
        }

        return $value;
    }

    /**
     * 生成加密的参数
     *
     * @param string $plaintext 明文参数
     * @param string $assist    辅助参数
     */
    public function generateEncryptValue($plaintext, $assist = '')
    {
        return strtoupper(substr(md5($assist . strtoupper(substr(md5($plaintext), 0, 30)) . '14045'), 0, 30));
    }

    /**
     * 数据字符串
     *
     * @param  integer  $number 需要的长度
     * @return string
     */
    public function randomStr($number = 15)
    {
        $strs = "QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";

        return substr(str_shuffle($strs), mt_rand(0, strlen($strs) - $number - 1), $number);
    }
}
