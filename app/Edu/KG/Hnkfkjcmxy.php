<?php

namespace App\Edu\KG;

use App\Edu\EduParserInterface;
use App\Edu\EduProvider;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

class Hnkfkjcmxy extends EduProvider implements EduParserInterface
{
    /**
     * 相关网络地址
     *
     * @var array
     */
    protected static $url = [
        'base'        => 'http://msjw.humc.edu.cn',   //根域名
        'home'        => '/home.aspx',                //首页，获取Cookie
        'code'        => '/sys/ValidateCode.aspx',    //验证码
        'login'       => '/_data/login_home.aspx',    //登录
        'main'        => '/MAINFRM.aspx',             //登录后的主页
        'menu'        => '/frame/menu.aspx',          //侧边菜单
        'persos_get'  => '/xsxj/Stu_MyInfo.aspx',     //个人信息
        'persos_post' => '/xsxj/Stu_MyInfo_RPT.aspx', //获取个人信息
        'scores_get'  => '/xscj/Stu_cjfb.aspx',       //成绩
        'scores_post' => '/xscj/Stu_cjfb_rpt.aspx',   //获取成绩
        'scores_img'  => '/xscj/',                    //成绩图片根路径
        'tables_get'  => '/znpk/Pri_StuSel.aspx',     //课表
        'tables_post' => '/znpk/Pri_StuSel_rpt.aspx', //获取课表
        'tables_img'  => '/znpk/',                    //课表图片根路径
    ];

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
                'Referer'    => self::$url['login'],
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
                'Referer'    => self::$url['login'],
            ],
            'form_params' => [
                '__VIEWSTATE'              => $hidden['__VIEWSTATE'],
                '__VIEWSTATEGENERATOR'     => $hidden['__VIEWSTATEGENERATOR'],
                'pcInfo'                   => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36undefined5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/84.0.4147.135 Safari/537.36 SN:NULL',
                'txt_mm_expression'        => $hidden['txt_mm_expression'],
                'txt_mm_length'            => $hidden['txt_mm_length'],
                'txt_mm_userzh'            => $hidden['txt_mm_userzh'],
                'typeName'                 => urlencode(iconv('UTF-8', 'gb2312', '学生')),
                'dsdsdsdsdxcxdfgfg'        => self::generateEncryptValue($password, $studentNo),
                'fgfggfdgtyuuyyuuckjg'     => self::generateEncryptValue(strtoupper($captcha)),
                'Sel_Type'                 => 'STU',
                'txt_asmcdefsddsd'         => $studentNo,
                'txt_pewerwedsdfsdff'      => '',
                'txt_psasas'               => urlencode(iconv('UTF-8', 'gb2312', '请输入密码')),
                'txt_sdertfgsadscxcadsads' => '',
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

        if (preg_match('/您在别处的登录已下线/', $html)) {
            return ['code' => 0, 'msg' => '登录成功！'];
        } else if (preg_match('/MAINFRM/', $html)) {
            return ['code' => 0, 'msg' => '登录成功！'];
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
     * 获取登录隐藏值
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
                'Referer'    => self::$url['base'],
            ],
        ];

        $response = $this->client->request('GET', self::$url['login'], $options);
        $result   = $response->getBody();

        return $this->parserLoginHiddenValue($result);
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
            '__VIEWSTATEGENERATOR' => $crawler->filterXPath('//input[@name="__VIEWSTATEGENERATOR"]')->attr('value'),
            'txt_mm_expression'    => $crawler->filterXPath('//input[@name="txt_mm_expression"]')->attr('value'),
            'txt_mm_length'        => $crawler->filterXPath('//input[@name="txt_mm_length"]')->attr('value'),
            'txt_mm_userzh'        => $crawler->filterXPath('//input[@name="txt_mm_userzh"]')->attr('value'),
            'dsdsdsdsdxcxdfgfg'    => $crawler->filterXPath('//input[@name="dsdsdsdsdxcxdfgfg"]')->attr('value'),
            'fgfggfdgtyuuyyuuckjg' => $crawler->filterXPath('//input[@name="fgfggfdgtyuuyyuuckjg"]')->attr('value'),
        ];

        return $value;
    }

    /**
     * 获取学生个人信息
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
                'Referer'    => self::$url['persos_get'],
            ],
        ];

        $response = $this->client->request('GET', self::$url['persos_post'], $options);
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
                'student_no'   => $htmlCrawler->filterXPath('//table/tr[2]/td[2]')->text(''),  //学号
                'student_name' => $htmlCrawler->filterXPath('//table/tr[2]/td[4]')->text(''),  //姓名
                'identity_no'  => $htmlCrawler->filterXPath('//table/tr[4]/td[4]')->text(''),  //身份证
                'birth_date'   => $htmlCrawler->filterXPath('//table/tr[5]/td[2]')->text(''),  //出生日期                                                                                        //出生日期
                'gender'       => $htmlCrawler->filterXPath('//table/tr[4]/td[2]')->text(''),  //性别
                'nation'       => $htmlCrawler->filterXPath('//table/tr[5]/td[4]')->text(''),  //民族
                'education'    => $htmlCrawler->filterXPath('//table/tr[21]/td[6]')->text(''), //学历                                                                                               //学历
                'college'      => $htmlCrawler->filterXPath('//table/tr[24]/td[2]')->text(''), //学院
                'major'        => $htmlCrawler->filterXPath('//table/tr[24]/td[4]')->text(''), //专业
                'class'        => $htmlCrawler->filterXPath('//table/tr[24]/td[6]')->text(''), //班级
                'period'       => $htmlCrawler->filterXPath('//table/tr[19]/td[6]')->text(''), //学制
                'grade'        => $htmlCrawler->filterXPath('//table/tr[20]/td[2]')->text(''), //年级
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
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['scores_get'],
            ],
            'form_params' => [
                'SelXNXQ' => 0,
                'submit'  => urlencode(iconv('UTF-8', 'gb2312', '检索')),
            ],
        ];

        $response = $this->client->request('POST', self::$url['scores_post'], $options);
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
            $tempTerm   = [];
            $tempCourse = [];
            $scores     = [];
            // $html        = iconv('gb2312', 'UTF-8', $html);
            $htmlCrawler = new Crawler((string) $html);
            $table       = $htmlCrawler->filterXPath('//table[@id="ID_Table"]')->children();
            $tableCount  = count($table);

            foreach ($table as $tableIndex => $tableNode) {
                if ($tableIndex >= $tableCount - 2) {
                    break;
                }

                $trCrawler = new Crawler($tableNode);

                $tdText1 = $trCrawler->filterXPath('//td[1]')->text('');

                if (preg_match('/(^\d{4}-\d{4})[^%]*(一|二)[^%]*/', $tdText1, $termMatches)) {
                    $tempTerm = [
                        'annual' => $termMatches[1],
                        'term'   => $termMatches[2] == '一' ? 1 : 2,
                    ];
                }

                $tdText2 = $trCrawler->filterXPath('//td[2]')->text('');
                if (preg_match('/^\[(\d*)\]([^%]*)/', $tdText2, $courseMatches)) {
                    $tempCourse = [
                        'course_no'   => $courseMatches[1],
                        'course_name' => $courseMatches[2],
                    ];
                }

                $scores[] = [
                    'annual'      => isset($tempTerm['annual']) ? $tempTerm['annual'] : '',               // 学年
                    'term'        => isset($tempTerm['term']) ? $tempTerm['term'] : '',                   // 学期
                    'course_no'   => isset($tempCourse['course_no']) ? $tempCourse['course_no'] : '',     // 课号
                    'course_name' => isset($tempCourse['course_name']) ? $tempCourse['course_name'] : '', // 课名
                    'course_type' => $trCrawler->filterXPath('//td[4]')->text(''),                        // 课型
                    'score'       => $trCrawler->filterXPath('//td[12]')->text(''),                       // 成绩
                    'credit'      => $trCrawler->filterXPath('//td[3]')->text(''),                        // 学分
                    'gpa'         => 0,
                ];
            }

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
        $data   = [];
        $values = $this->getTablesHiddenValue($studentNo);

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
            $result   = $response->getBody();

            $info = $this->parserTablesInfo($result);
            if (!empty($info)) {
                $data[] = $info;
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

        try {
            $crawler = new Crawler((string) $html);

            $url = $crawler->filterXPath('//img')->attr('src');
            return $this->getTablesImages($url);
        } catch (Exception $e) {
            return '';
        }
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
     * @param  string  $studentNo 学号
     * @return array
     */
    public function getTablesHiddenValue($studentNo)
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
                $hidsjyzm = strtoupper(md5('13501' . $xn . $randostr));

                $value[] = [
                    'hidyzm'   => $hyzm,
                    'xnxq'     => $xn,
                    'randostr' => $randostr,
                    'hidsjyzm' => $hidsjyzm,
                ];
            }
        } else {
            $randostr = $this->randomStr();
            $hidsjyzm = strtoupper(md5('13501' . $xnxq . $randostr));

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
     * 解析获取隐藏的__VIEWSTATE
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

    /**
     * 生成加密的参数
     *
     * @param string $plaintext 明文参数
     * @param string $assist    辅助参数
     */
    public static function generateEncryptValue($plaintext, $assist = '')
    {
        return strtoupper(substr(md5($assist . strtoupper(substr(md5($plaintext), 0, 30)) . '13501'), 0, 30));
    }

    /**
     * 数据字符串
     *
     * @param  integer  $number 需要的长度
     * @return string
     */
    public static function randomStr($number = 15)
    {
        $strs = 'QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm';

        return substr(str_shuffle($strs), mt_rand(0, strlen($strs) - $number - 1), $number);
    }
}
