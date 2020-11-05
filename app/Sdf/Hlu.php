<?php

namespace App\Sdf;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use Symfony\Component\DomCrawler\Crawler;

class Hlu
{
    /**
     * 相关网络地址
     *
     * @var array
     */
    private static $url = [
        'query' => 'http://chaxun.hlu.edu.cn/sdf/sdf.aspx', //查询
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
        $this->client = new Client();
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

        $response = $this->client->request('GET', self::$url['query'], $options);

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
     * 获取水电费信息
     *
     * @param  string  $room
     * @return array
     */
    public function getSdfInfo($room)
    {
        $hiddenValue = $this->getHiddenValue($room);

        $formParams = [
            'TextBox1' => $room,
            'Button1'  => '%E6%90%9C%E7%B4%A2',
        ];

        $formParams = array_merge($formParams, $hiddenValue);

        $options = [
            'cookies'     => $this->cookie,
            'headers'     => [
                'User-Agent' => self::$userAgent,
            ],
            'form_params' => $formParams,
        ];

        $response = $this->client->request('POST', self::$url['query'], $options);

        return $this->parserSdfInfo($response->getBody());
    }

    /**
     * 解析水电费信息
     *
     * @param  string  $html
     * @return array
     */
    public function parserSdfInfo($html)
    {
        try {
            $crawler = new Crawler((string) $html);
            $table   = $crawler->filterXPath('//table[@id="HuoGridView"]');
            $nodes   = $table->children();
            $data    = [];

            foreach ($nodes as $i => $node) {
                if ($i != 0) {
                    $node   = new Crawler($node);
                    $data[] = [
                        'room_id'             => $node->filterXPath('//td[1]')->text(),
                        'people_num'          => $node->filterXPath('//td[2]')->text(),
                        'date'                => $node->filterXPath('//td[3]')->text(),
                        'cold_water_this_num' => $node->filterXPath('//td[4]')->text(),
                        'cold_water_last_num' => $node->filterXPath('//td[5]')->text(),
                        'cold_water_policy'   => $node->filterXPath('//td[6]')->text(),
                        'cold_water_meter'    => $node->filterXPath('//td[7]')->text(),
                        'cold_water_cost'     => $node->filterXPath('//td[8]')->text(),
                        'hot_water_this_num'  => $node->filterXPath('//td[9]')->text(),
                        'hot_water_last_num'  => $node->filterXPath('//td[10]')->text(),
                        'hot_water_policy'    => $node->filterXPath('//td[11]')->text(),
                        'hot_water_meter'     => $node->filterXPath('//td[12]')->text(),
                        'hot_water_cost'      => $node->filterXPath('//td[13]')->text(),
                        'power_this_num'      => $node->filterXPath('//td[14]')->text(),
                        'power_last_num'      => $node->filterXPath('//td[15]')->text(),
                        'power_policy'        => $node->filterXPath('//td[16]')->text(),
                        'power_meter'         => $node->filterXPath('//td[17]')->text(),
                        'power_cost'          => $node->filterXPath('//td[18]')->text(),
                        'aircn_this_num'      => $node->filterXPath('//td[19]')->text(),
                        'aircn_last_num'      => $node->filterXPath('//td[20]')->text(),
                        'aircn_policy'        => $node->filterXPath('//td[21]')->text(),
                        'aircn_meter'         => $node->filterXPath('//td[22]')->text(),
                        'aircn_cost'          => $node->filterXPath('//td[23]')->text(),
                        'total_cost'          => $node->filterXPath('//td[24]')->text(),
                    ];
                }
            }

            return $data;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * 获取隐藏参数
     *
     * @param  string  $xh 学号
     * @return array
     */
    public function getHiddenValue($room)
    {
        $options = [
            'cookies' => $this->cookie,
            'headers' => [
                'User-Agent' => self::$userAgent,
            ],
        ];

        $response = $this->client->request('GET', self::$url['query'], $options);

        return $this->parserHiddenValue($response->getBody());
    }

    /**
     * 解析隐藏参数
     *
     * @param  string   $html
     * @return string
     */
    public function parserHiddenValue($html)
    {
        try {
            $crawler = new Crawler((string) $html);

            $value = [
                '__EVENTTARGET'        => $crawler->filterXPath('//input[@name="__EVENTTARGET"]')->attr('value'),
                '__EVENTARGUMENT'      => $crawler->filterXPath('//input[@name="__EVENTARGUMENT"]')->attr('value'),
                '__VIEWSTATE'          => $crawler->filterXPath('//input[@name="__VIEWSTATE"]')->attr('value'),
                '__VIEWSTATEGENERATOR' => $crawler->filterXPath('//input[@name="__VIEWSTATEGENERATOR"]')->attr('value'),
                '__EVENTVALIDATION'    => $crawler->filterXPath('//input[@name="__EVENTVALIDATION"]')->attr('value'),
            ];

            return $value;
        } catch (\Exception $e) {
            return false;
        }
    }
}
