<?php

namespace App\Edu\SW;

use App\Edu\EduParserInterface;
use App\Edu\EduProvider;
use Exception;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

class Ahsfdx extends EduProvider implements EduParserInterface
{
    /**
     * 相关网络地址
     *
     * @var array
     */
    protected static $url = [
        'base'            => 'http://jw.ahnu.edu.cn',                                                         //根域名
        'cookie'          => '/student/login',                                                                //获取Cookie
        'captcha'         => '',                                                                              //获取验证码
        'login'           => '/student/login',                                                                //获取登录信息
        'login_salt'      => '/student/login-salt',                                                           //获取登录密钥
        'persos'          => '/student/my/profile',                                                           //获取学生信息
        'student_id'      => '/student/for-std/grade/sheet',                                                  //获取学生ID
        'scores'          => '/student/for-std/grade/sheet/info/',                                            //获取学生成绩
        'tables_semester' => '/student/for-std/course-table',                                                 //获取课表学期
        'tables'          => '/student/for-std/course-table/semester/#semester#/print?semesterId=#semester#', //获取课表信息

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
        return false;
    }

    /**
     * 解析验证码
     *
     * @param  string   $html
     * @return string
     */
    public function parserCaptchaImages($html)
    {
        return '';
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
        $salt = $this->getLoginSaltValue($studentNo);

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'Content-Type' => 'application/json',
                'User-Agent'   => self::$userAgent,
            ],
            'json'    => [
                'captcha'  => '',
                'username' => $studentNo,
                'password' => sha1($salt . '-' . $password),
                'terminal' => 'student',
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
        $result = json_decode($html, true);

        if (isset($result['result']) && $result['result']) {
            return ['code' => 0, 'message' => '登录成功！'];
        } else {
            return ['code' => -1, 'message' => $result['message']];
        }
    }

    /**
     * 获取登录密钥
     *
     * @param  string   $studentNo
     * @return string
     */
    public function getLoginSaltValue($studentNo)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
                'Referer'    => self::$url['login'],
            ],
        ];

        $response = $this->client->request('GET', self::$url['login_salt'], $options);
        $result   = $response->getBody();

        return $result;
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
                'student_no'   => '',                                                                                           //学号
                'student_name' => $htmlCrawler->filterXPath('//div[@class="container-fluid"]/div/div/li[3]/span[2]')->text(''), //姓名
                'identity_no'  => $htmlCrawler->filterXPath('//div[@class="container-fluid"]/div/div/li[6]/span[2]')->text(''), //身份证
                'birth_date'   => $htmlCrawler->filterXPath('//div[@class="container-fluid"]/div/div/li[7]/span[2]')->text(''), //出生日期                                                                                        //出生日期
                'gender'       => $htmlCrawler->filterXPath('//div[@class="container-fluid"]/div/div/li[4]/span[2]')->text(''), //性别
                'nation'       => '',                                                                                           //民族
                'education'    => '',                                                                                           //学历                                                                                               //学历
                'college'      => '',                                                                                           //学院
                'major'        => '',                                                                                           //专业
                'class'        => '',                                                                                           //班级
                'period'       => '',                                                                                           //学制
                'grade'        => '',                                                                                           //年级
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
        $hidden = $this->getStudentIdValue($studentNo, $password);

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['scores'] . '/' . $hidden, $options);

        $result = $response->getBody();

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
        $result = json_decode($html, true);
        $scores = [];

        if (isset($result['semesterId2studentGrades']) && $result['semesterId2studentGrades']) {
            $studentTerm = $result['semesterId2studentGrades'];
            foreach ($studentTerm as $term) {
                foreach ($term as $score) {
                    $scores[] = [
                        'annual'      => $score['semester']['schoolYear'],                 // 学年
                        'term'        => $score['semester']['season'] == 'AUTUMN' ? 1 : 2, // 学期
                        'course_no'   => $score['course']['code'],                         // 课号
                        'course_name' => $score['course']['nameZh'],                       // 课名
                        'course_type' => '',                                               // 课型
                        'score'       => $score['gaGrade'],                                // 成绩
                        'credit'      => $score['course']['credits'],                      // 学分
                        'gpa'         => $score['gp'],                                     // 绩点
                    ];
                }
            }

            return $scores;
        } else {
            return [];
        }
    }

    /**
     * 获取学生ID
     *
     * @param  string   $studentNo
     * @param  string   $password
     * @return string
     */
    public function getStudentIdValue($studentNo, $password)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['student_id'], $options);

        $result = $response->getBody();

        return $this->parserStudentIdValue($result);
    }

    /**
     * 解析学生ID
     *
     * @param  string   $html
     * @return string
     */
    public function parserStudentIdValue($html)
    {
        try {
            $htmlCrawler = new Crawler((string) $html);

            return $htmlCrawler->filterXPath('//input[@id="studentId"]')->attr('value');
        } catch (Exception $e) {
            return '';
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
        $semester = $this->getTablesSemesterValue($studentNo, $password);

        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', str_replace('#semester#', $semester, self::$url['tables']), $options);

        $result = $response->getBody();

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
        $tables = [];
        if (preg_match('/studentTableVms[ ]?=[ ]?(.*);/', $html, $matches)) {
            $josn = str_replace("'", '"', $matches[1]);
            $data = json_decode($josn, true);

            $activities = $data[0]['activities'] ?? [];
            $timeperiod = $data[0]['courseTablePrintConfigs'] ?? [];
            if (empty($activities) || empty($timeperiod)) {
                return $tables;
            }

            $periodFormat = function () use ($timeperiod) {
                $period = [];
                foreach ($timeperiod as $item) {
                    foreach ($item['unitGroup'] as $unitGroup) {
                        foreach ($unitGroup as $unit) {
                            $period[$unit] = $item['nameZh'];
                        }
                    }
                }

                return $period;
            };

            $tempPeriod = $periodFormat();

            foreach ($activities as $item) {
                $lenght = $item['endUnit'] - $item['startUnit'];
                $lenght = $lenght >= 0 ? $lenght : 0;

                for ($i = 0; $i <= $lenght; $i++) {
                    $tables[] = [
                        'period'      => $tempPeriod[$item['startUnit']] ?? '', // 时段
                        'week'        => $item['weekday'],                      // 星期
                        'section'     => $item['startUnit'] + $i,               // 节次
                        'time'        => '',                                    // 时间
                        'course_name' => $item['courseName'],                   // 课名
                        'course_type' => $item['courseType']['nameZh'],         // 课型
                        'week_period' => $item['weeksStr'],                     // 周段
                        'teacher'     => implode(',', $item['teachers']),       // 老师
                        'location'    => $item['campus'] . ':' . $item['room'], // 地点
                    ];
                }
            }
        }

        return $tables;
    }

    /**
     * 获取课表学期
     *
     * @param  string   $studentNo
     * @param  string   $password
     * @return string
     */
    public function getTablesSemesterValue($studentNo, $password)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['tables_semester'], $options);

        $result = $response->getBody();

        return $this->parserTablesSemesterValue($result);
    }

    /**
     * 解析课表学期
     *
     * @param  string   $html
     * @return string
     */
    public function parserTablesSemesterValue($html)
    {
        try {
            $htmlCrawler = new Crawler((string) $html);

            return $htmlCrawler->filterXPath('//option[@selected="selected"]')->attr('value');
        } catch (Exception $e) {
            return '';
        }
    }

}
