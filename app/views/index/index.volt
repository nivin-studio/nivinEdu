<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover" name="viewport">
    <title>拟物校园</title>
    <link href="/css/weui.css" rel="stylesheet" />
</head>

<body>
    <div class="page">
        <form action="{{ loginUrl }}" class="weui-form" method="POST">
            <div class="weui-form__text-area">
                <h2 class="weui-form__title">登  录</h2>
                <div class="weui-form__desc">{{ school }}</div>
            </div>
            <div class="weui-form__control-area">
                <div class="weui-cells__group weui-cells__group_form">
                    <div class="weui-cells weui-cells_form">
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">学号</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" name="xh" placeholder="填写学号" />
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">密码</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" name="mm" placeholder="填写密码" />
                            </div>
                        </div>
                        <div class="weui-cell">
                            <div class="weui-cell__hd"><label class="weui-label">验证码</label></div>
                            <div class="weui-cell__bd">
                                <input class="weui-input" name="vm" placeholder="填写验证码" />
                                <img src="{{ vccode }}">
                            </div>
                        </div>
                        <input name="<?php echo $this->security->getTokenKey() ?>" type="hidden" value="<?php echo $this->security->getToken() ?>" />
                        <input name="uuid" type="hidden" value="{{ uuid }}" />
                    </div>
                </div>
            </div>
            <div class="weui-form__opr-area">
                <input class="weui-btn weui-btn_primary" type="submit" value="确定" />
            </div>
            <div class="weui-form__extra-area">
                <div class="weui-footer">
                    <p class="weui-footer__text">Copyright © 2008-2019 weui.io</p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>