<style>
    .login-box {
        margin-top: -10rem;
        padding: 5px;
    }

    .login-card-body {
        padding: 1.5rem 1.8rem 1.6rem;
    }

    .card,
    .card-body {
        border-radius: .25rem
    }

    .login-btn {
        padding-left: 2rem !important;
        ;
        padding-right: 1.5rem !important;
    }

    .content {
        overflow-x: hidden;
    }

    .form-group .control-label {
        text-align: left;
    }

</style>

<div class="login-page bg-40">
    <div class="login-box">
        <div class="login-logo mb-2">
            拟物校园
        </div>
        <div class="card">
            <div class="card-body login-card-body shadow-100">
                <p class="login-box-msg mt-1 mb-1">感谢信任，请注册您的账号。</p>

                <form id="login-form" method="POST" action="{{ admin_url('auth/register') }}">

                    <input id="token" type="hidden" name="_token" value="{{ csrf_token() }}" />

                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input id="email" type="email"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email"
                            placeholder="请输入邮箱" required autofocus>

                        <div class="form-control-position">
                            <i class="feather icon-mail"></i>
                        </div>

                        <div class="help-block with-errors"></div>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback text-danger" role="alert">
                                @foreach ($errors->get('email') as $message)
                                    <span class="control-label" for="inputError">
                                        <i class="feather icon-x-circle"></i>
                                        {{ $message }}
                                    </span>
                                    <br>
                                @endforeach
                            </span>
                        @endif
                    </fieldset>

                    <fieldset class="form-label-group form-group position-relative has-icon-left">

                        <div class="row">
                            <div class="col-md-8">
                                <input id="captcha" type="text" minlength="6" maxlength="6"
                                    class="form-control {{ $errors->has('captcha') ? 'is-invalid' : '' }}"
                                    name="captcha" placeholder="请输入验证码" required autofocus>

                                <div class="form-control-position">
                                    <i class="feather icon-message-circle"></i>
                                </div>

                                <div class="help-block with-errors"></div>
                                @if ($errors->has('captcha'))
                                    <span class="invalid-feedback text-danger" role="alert">
                                        @foreach ($errors->get('captcha') as $message)
                                            <span class="control-label" for="inputError">
                                                <i class="feather icon-x-circle"></i>
                                                {{ $message }}
                                            </span>
                                            <br>
                                        @endforeach
                                    </span>
                                @endif
                            </div>

                            <div class="col-md-4" style="padding-left: 0;">
                                <button type="button" class="btn btn-primary float-right captcha-btn"
                                    style="padding: .5rem .6rem!important;">
                                    获取验证码
                                </button>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input minlength="6" maxlength="20" id="password" type="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
                            placeholder="请输入密码" required autocomplete="current-password">

                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>

                        <div class="help-block with-errors"></div>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback text-danger" role="alert">
                                @foreach ($errors->get('password') as $message)
                                    <span class="control-label" for="inputError">
                                        <i class="feather icon-x-circle"></i>
                                        {{ $message }}
                                    </span>
                                    <br>
                                @endforeach
                            </span>
                        @endif

                    </fieldset>

                    <button type="submit" class="btn btn-primary float-right login-btn">
                        注册
                        &nbsp;
                        <i class="feather icon-arrow-right"></i>
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    Dcat.ready(function() {
        // ajax表单提交
        $('#login-form').form({
            validate: true,
        });

        captchaTimer();

        $('.captcha-btn').click(function() {
            $.ajax({
                type: "POST",
                url: "{{ admin_url('auth/captcha') }}",
                data: {
                    _token: $("#token").val(),
                    email: $("#email").val()
                },
                dataType: "json",
                success: function(res) {
                    if (res.code == 0) {
                        var finalTime = (Date.parse(new Date()) / 1000) + 60;
                        captchaTimer(finalTime);
                    } else {
                        Dcat.error(res.message);
                    }
                },
                error: function(res) {
                    Dcat.error('服务器出现未知错误');
                }
            });
        });

        function captchaTimer(finalTime) {
            if (finalTime) {
                window.localStorage.setItem('captchaFinalTime', finalTime);
            } else {
                finalTime = window.localStorage.getItem('captchaFinalTime');
            }

            if (!finalTime) {
                return;
            }

            var currTime = Date.parse(new Date()) / 1000;
            var diffTime = finalTime - currTime;

            var timer = setInterval(() => {
                if (diffTime <= 0) {
                    clearInterval(timer);
                    window.localStorage.removeItem('captchaFinalTime');
                    $('.captcha-btn').attr('disabled', false);
                    $('.captcha-btn').html('获取验证码');
                } else {
                    $('.captcha-btn').attr('disabled', true);
                    $('.captcha-btn').html(diffTime + '秒后重试');
                    diffTime--;
                }
            }, 1000);
        };

    });

</script>
