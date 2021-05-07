<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover" name="viewport">
    <title>拟物校园</title>
    <link href="{{ URL::asset('vendor/mobile/weui/css/weui.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('vendor/mobile/css/main.css') }}" rel="stylesheet" />
</head>

<body>
    <div class="page">
        <form action="{{ Route('mobile.login') }}" class="weui-form" method="POST">
            {{ csrf_field() }}
            <div class="weui-form__text-area">
                <h2 class="weui-form__title">登 录</h2>
                <div class="weui-form__desc">{{ $application->school->name }}</div>
            </div>
            <div class="weui-form__control-area nivin">
                <div class="weui-cells__group weui-cells__group_form">
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">学　号</label></div>
                            <div class="weui-cell__bd nivin-inset">
                                <input class="weui-input" name="studentNo" placeholder="填写学号" />
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">密　码</label></div>
                            <div class="weui-cell__bd nivin-inset">
                                <input class="weui-input" name="studentPwd" placeholder="填写密码" />
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                            <div class="weui-cell__bd nivin-inset">
                                <input class="weui-input" name="captcha" placeholder="填写验证码" />
                            </div>
                            <img class="vcode" src="{{ $captcha }}">
                        </div>
                        <input name="appid" type="hidden" value="{{ $application->hashid() }}" />
                    </div>
                </div>
            </div>
            <div class="weui-form__opr-area">
                <input class="weui-btn nivin-a" type="submit" value="确定" />
            </div>
            <div class="weui-form__extra-area">
                <div class="weui-footer">
                    <p class="weui-footer__text">Copyright © 2016-2020 nivin.cn</p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
