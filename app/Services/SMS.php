<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Log;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Sms\V20190711\Models\SendSmsRequest;
use TencentCloud\Sms\V20190711\SmsClient;

class SMS
{
    /**
     * 短信客户端
     *
     * @var SmsClient
     */
    private $client = null;

    /**
     * 短信peizhi
     *
     * @var array
     */
    private $config = [];

    /**
     * 构造函数
     *
     * @return void
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 短信发送
     *
     * @param  mixed   $phone
     * @param  mixed   $content
     * @param  mixed   $templateid
     * @param  mixed   $sdkappid
     * @return array
     */
    public function send($to, $message)
    {
        try {
            $request  = $this->getSendRequest($to, $message);
            $response = $this->getClient()->SendSms($request);

            if ($response->SendStatusSet[0]->Code != 'Ok') {
                return ['code' => false, 'msg' => $response->SendStatusSet[0]->Message];
            }

            return ['code' => true, 'msg' => '发送成功'];
        } catch (Exception $e) {
            Log::channel('sms')->info($e);
            return ['code' => false, 'msg' => '发送失败'];
        }
    }

    /**
     *
     *
     * @param  string           $to
     * @param  array            $message
     * @return SendSmsRequest
     */
    public function getSendRequest($to, $message)
    {
        $request = new SendSmsRequest();

        $request->PhoneNumberSet   = $this->formatPhoneNumber($to, '+86');
        $request->TemplateID       = $message['template'];
        $request->TemplateParamSet = $message['data'];
        $request->Sign             = $this->config['tencent']['sign_name'];
        $request->SmsSdkAppid      = $this->config['tencent']['sdk_app_id'];

        return $request;
    }

    /**
     * 获取短信客户端
     *
     * @return SmsClient
     */
    public function getClient()
    {
        if ($this->client) {
            return $this->client;
        }

        try {
            $credential  = new Credential($this->config['tencent']['secret_id'], $this->config['tencent']['secret_key']);
            $httpProfile = new HttpProfile();
            $httpProfile->setEndpoint($this->config['tencent']['endpoint']);

            $clientProfile = new ClientProfile();
            $clientProfile->setHttpProfile($httpProfile);

            $this->client = new SmsClient($credential, '', $clientProfile);
        } catch (Exception $e) {
            Log::channel('sms')->info($e);
        }
    }

    /**
     * 格式化电话号码
     *
     * @param  string   $phoneNumber
     * @param  string   $prefixed
     * @return string
     */
    public function formatPhoneNumber($phoneNumber, $prefixed)
    {
        return strpos($phoneNumber, $prefixed) === false ? $prefixed . $phoneNumber : $phoneNumber;
    }
}
