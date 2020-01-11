<?php

namespace xnkjdx;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Edu
{
    private static $url = [
        'base_url'      => 'http://jwgl.ccswust.edu.cn/home.aspx',
        'login_url'     => 'http://jwgl.ccswust.edu.cn/_data/login_home.aspx',
        'vccode_url'    => 'http://jwgl.ccswust.edu.cn/sys/ValidateCode.aspx',
        'main_url'      => 'http://jwgl.ccswust.edu.cn/MAINFRM.aspx',
        'info_main_url' => 'http://jwgl.ccswust.edu.cn/xsxj/Stu_MyInfo.aspx',
        'info_url'      => 'http://jwgl.ccswust.edu.cn/xsxj/Stu_MyInfo_RPT.aspx',
        'table_url'     => 'http://211.86.193.14/tjkbcx.aspx',
        'grade_url'     => 'http://211.86.193.14/xscjcx.aspx',
    ];

    private static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36';

    private $client;

    private $cookie;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * 获取初始化cookie
     *
     * @return \GuzzleHttp\Cookie\CookieJar
     */
    public function getCookie()
    {
        $this->cookie = new \GuzzleHttp\Cookie\CookieJar;

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['base_url'], $options);

        return $this->cookie;
    }

    /**
     * 设置cookie
     *
     * @param \GuzzleHttp\Cookie\CookieJar $cookie
     */
    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * 获取验证码
     *
     * @return
     */
    public function getVcCode()
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'Referer'    => self::$url['login_url'],
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['vccode_url'], $options);
        $result   = $response->getBody();

        $imageType   = getimagesizefromstring($result)['mime'];
        $imageBase64 = 'data:' . $imageType . ';base64,' . (base64_encode($result));

        return $imageBase64;
    }

    /**
     * 登录
     *
     * @param  string $xh 学号
     * @param  string $mm 密码
     * @param  string $vm 验证码
     *
     * @return array
     */
    public function login($xh, $mm, $vm)
    {
        $value = $this->loginHiddenValue();

        $options = [
            'form_params' => [
                '__VIEWSTATE'              => $value['__VIEWSTATE'],
                '__EVENTVALIDATION'        => $value['__EVENTVALIDATION'],
                'pcInfo'                   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36undefined5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36 SN:NULL',
                'txt_mm_expression'        => $value['txt_mm_expression'],
                'txt_mm_length'            => $value['txt_mm_length'],
                'txt_mm_userzh'            => $value['txt_mm_userzh'],
                'typeName'                 => urlencode(iconv("UTF-8", "gb2312", '学生')),
                'dsdsdsdsdxcxdfgfg'        => $this->GenerateEncryptValue($mm, $xh),
                'fgfggfdgtyuuyyuuckjg'     => $this->GenerateEncryptValue(strtoupper($vm)),
                'Sel_Type'                 => 'STU',
                'txt_asmcdefsddsd'         => $xh,
                'txt_pewerwedsdfsdff'      => '',
                'txt_psasas'               => urlencode(iconv("UTF-8", "gb2312", '请输入密码')),
                'txt_sdertfgsadscxcadsads' => '',
            ],
            'headers'     => [
                'Referer'    => self::$url['login_url'],
                'User-Agent' => self::$userAgent,
            ],
            'cookies'     => $this->cookie,

        ];

        $response = $this->client->request('POST', self::$url['login_url'], $options);
        return iconv('gb2312', 'UTF-8', $response->getBody());
    }

    /**
     * 生成加密的参数
     *
     * @param string $plaintext 明文参数
     * @param string $assist    辅助参数
     */
    public function GenerateEncryptValue($plaintext, $assist = '')
    {
        return strtoupper(substr(md5($assist . strtoupper(substr(md5($plaintext), 0, 30)) . '14045'), 0, 30));
    }

    /**
     * 获取登录隐藏值
     *
     * @return string
     */
    public function loginHiddenValue()
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'Referer'    => self::$url['base_url'],
                'User-Agent' => self::$userAgent,
            ],
        ];
        $response = $this->client->request('GET', self::$url['login_url'], $options);

        return $this->parserLoginHiddenValue($response->getBody());
    }

    /**
     * 获取学生个人信息
     *
     * @param  string $xh 学号
     *
     * @return array
     */
    public function getStudentInfo($xh)
    {
        $options = [
            'headers' => [
                'Referer'    => self::$url['info_main_url'],
                'User-Agent' => self::$userAgent,
            ],
            'cookies' => $this->cookie,

        ];

        $response = $this->client->request('GET', self::$url['info_url'], $options);

        return $this->parserStudentInfo($response->getBody());
    }

    /**
     * 获取学生成绩
     *
     * @param  string $xh 学号
     *
     * @return array
     */
    public function getGradesList($xh)
    {
        $url       = self::$url['grade_url'] . '?xh=' . $xh;
        $viewstate = $this->gradesHiddenValue($xh);

        $options = [
            'form_params' => [
                '__VIEWSTATE' => $viewstate,
                'hidLanguage' => "",
                'ddlXN'       => "",
                'ddlXQ'       => "",
                'ddl_kcxz'    => "",
                'btn_zcj'     => iconv('utf-8', 'gb2312', '历年成绩'),
            ],
            'headers'     => [
                'Referer'    => $url,
                'User-Agent' => self::$userAgent,
            ],
            'cookies'     => $this->cookie,

        ];

        $response = $this->client->request('POST', $url, $options);

        return $this->parserGradesList($response->getBody());
    }

    /**
     * 获取学生课表
     *
     * @param  string $xh 学号
     *
     * @return array
     */
    public function getTimetable($xh)
    {
        $url     = self::$url['table_url'] . '?xh=' . $xh;
        $options = [
            'headers' => [
                'Referer'    => $url,
                'User-Agent' => self::$userAgent,
            ],
            'cookies' => $this->cookie,

        ];

        $response = $this->client->request('GET', $url, $options);

        return $this->parserTimetable($response->getBody());
    }

    /**
     * 获取成绩隐藏值
     *
     * @param  string $xh 学号
     *
     * @return string
     */
    public function gradesHiddenValue($xh)
    {
        $url     = self::$url['grade_url'] . '?xh=' . $xh;
        $options = [
            'headers' => [
                'Referer'    => $url,
                'User-Agent' => self::$userAgent,
            ],
            'cookies' => $this->cookie,

        ];

        $response = $this->client->request('GET', $url, $options);

        return $this->parserViewState($response->getBody());
    }

    /**
     * 解析登录的隐藏参数
     *
     * @param  string $html
     *
     * @return string
     */
    public function parserLoginHiddenValue($html)
    {
        $crawler = new Crawler((string) $html);

        $params = [
            '__VIEWSTATE'          => $crawler->filterXPath('//input[@name="__VIEWSTATE"]')->attr('value'),
            '__EVENTVALIDATION'    => $crawler->filterXPath('//input[@name="__EVENTVALIDATION"]')->attr('value'),
            'txt_mm_expression'    => $crawler->filterXPath('//input[@name="txt_mm_expression"]')->attr('value'),
            'txt_mm_length'        => $crawler->filterXPath('//input[@name="txt_mm_length"]')->attr('value'),
            'txt_mm_userzh'        => $crawler->filterXPath('//input[@name="txt_mm_userzh"]')->attr('value'),
            'dsdsdsdsdxcxdfgfg'    => $crawler->filterXPath('//input[@name="dsdsdsdsdxcxdfgfg"]')->attr('value'),
            'fgfggfdgtyuuyyuuckjg' => $crawler->filterXPath('//input[@name="fgfggfdgtyuuyyuuckjg"]')->attr('value'),
        ];

        return $params;
    }

    /**
     * 解析获取隐藏的__VIEWSTATE
     *
     * @param  string $html
     *
     * @return string
     */
    public function parserViewState($html)
    {
        $crawler = new Crawler((string) $html);
        return $crawler->filterXPath('//input[@name="__VIEWSTATE"]')->attr('value');
    }

    /**
     * 解析获取学生信息
     *
     * @param  string $html
     *
     * @return string
     */
    public function parserStudentInfo($html)
    {
        $crawler = new Crawler((string) $html);

        $info = [
            'xh' => $crawler->filterXPath('//table/tbody/tr[2]/td[2]')->html(),  //学号
            'xm' => $crawler->filterXPath('//table/tbody/tr[2]/td[4]')->html(),  //姓名
            'xb' => $crawler->filterXPath('//table/tbody/tr[4]/td[2]')->html(),  //性别
            'sr' => $crawler->filterXPath('//table/tbody/tr[5]/td[2]')->html(),  //出生日期
            'mz' => $crawler->filterXPath('//table/tbody/tr[5]/td[4]')->html(),  //民族
            'xl' => $crawler->filterXPath('//table/tbody/tr[22]/td[6]')->html(), //学历
            'xy' => $crawler->filterXPath('//table/tbody/tr[25]/td[2]')->html(), //学院
            'zy' => $crawler->filterXPath('//table/tbody/tr[25]/td[4]')->html(), //专业
            'bj' => $crawler->filterXPath('//table/tbody/tr[25]/td[6]')->html(), //班级
            'xz' => $crawler->filterXPath('//table/tbody/tr[20]/td[6]')->html(), //学制
            'nj' => $crawler->filterXPath('//table/tbody/tr[21]/td[2]')->html(), //年级
        ];

        return $info;
    }

    /**
     * 解析获取学生成绩
     *
     * @param  string $html
     *
     * @return string
     */
    public function parserGradesList($html)
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
     * @param  string $html
     *
     * @return string
     */
    public function parserTimetable($html)
    {
        $crawler = new Crawler((string) $html);
        $table   = $crawler->filterXPath('//table[@id="Table6"]')->html();

        $result = '<table rules="all" border="1">' . $table . '</table>';

        return $result;
    }
}
