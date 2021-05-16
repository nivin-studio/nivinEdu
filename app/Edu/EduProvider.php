<?php

namespace App\Edu;

use App\Models\Application;
use App\Models\SpiderLog;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Promise;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

abstract class EduProvider
{
    /**
     * 用户代理
     *
     * @var string
     */
    protected static $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.132 Safari/537.36';

    /**
     * 全局交互cookie
     *
     * @var GuzzleHttp\Cookie\CookieJar
     */
    protected static $url;

    /**
     * 网络请求客户端
     *
     * @var GuzzleHttp\Client
     */
    protected $client;

    /**
     * 全局交互cookie
     *
     * @var GuzzleHttp\Cookie\CookieJar
     */
    protected $cookie;

    /**
     * 构造函数
     *
     * @param  Application $application
     * @return void
     */
    public function __construct(Application $application)
    {
        $stack = HandlerStack::create();
        $stack->push(self::recorder($application));

        $this->client = new Client(
            [
                'base_uri' => static::$url['base'],
                'handler'  => $stack,
            ]
        );
    }

    /**
     * 请求记录
     *
     * @param  Application $application
     * @return callable
     */
    public static function recorder(Application $application): callable
    {
        return static function (callable $handler) use ($application): callable {
            return static function (RequestInterface $request, array $options = []) use ($handler, $application) {
                return $handler($request, $options)->then(
                    static function ($response) use ($request, $application): ResponseInterface {
                        $data['application_id'] = $application->id;
                        $data['school_id']      = $application->school->id;
                        $data['request_url']    = $request->getUri();
                        $data['request_type']   = $request->getMethod();
                        $data['request_body']   = base64_encode($request->getBody());
                        $data['response_body']  = base64_encode($response->getBody());

                        SpiderLog::create($data);

                        return $response;
                    },
                    static function ($reason) use ($request): PromiseInterface {
                        $response = $reason instanceof RequestException ? $reason->getResponse() : null;

                        return Promise\Create::rejectionFor($reason);
                    }
                );
            };
        };
    }

    /**
     * 获取初始化cookie
     *
     * @return GuzzleHttp\Cookie\CookieJar
     */
    abstract public function getCookie();

    /**
     * 设置cookie
     *
     * @param GuzzleHttp\Cookie\CookieJar $cookie
     */
    abstract public function setCookie($cookie);

    /**
     * 是否需要验证码
     *
     * @return bool
     */
    abstract public function isNeedCaptcha();

    /**
     * 获取验证码
     *
     * @return string 验证码Base64字符串
     */
    abstract public function getCaptcha();

    /**
     * 获取登录信息
     *
     * @param  string  $studentNo 学号
     * @param  string  $password  密码
     * @param  string  $captcha   验证码
     * @return array
     */
    abstract public function getLoginInfo($studentNo, $password, $captcha);

    /**
     * 获取学生信息
     *
     * @param  string  $studentNo 学号
     * @param  string  $password  密码
     * @return array
     */
    abstract public function getPersosInfo($studentNo, $password);

    /**
     * 获取学生成绩
     *
     * @param  string  $studentNo 学号
     * @param  string  $password  密码
     * @return array
     */
    abstract public function getScoresInfo($studentNo, $password);

    /**
     * 获取学生课表
     *
     * @param  string   $studentNo 学号
     * @param  string   $password  密码
     * @return string
     */
    abstract public function getTablesInfo($studentNo, $password);
}
