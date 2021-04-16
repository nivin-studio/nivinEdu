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
                <p class="login-box-msg mt-1 mb-1">欢迎回来，请注册您的账号。</p>

                <form id="login-form" method="POST" action="{{ admin_url('auth/login') }}">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

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
                                    <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i>
                                        {{ $message }}</span><br>
                                @endforeach
                            </span>
                        @endif
                    </fieldset>

                    <fieldset class="form-label-group form-group position-relative has-icon-left">
                        <input minlength="5" maxlength="20" id="password" type="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password"
                            placeholder="请输入密码" autocomplete="current-password">

                        <div class="form-control-position">
                            <i class="feather icon-lock"></i>
                        </div>

                        <div class="help-block with-errors"></div>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback text-danger" role="alert">
                                @foreach ($errors->get('password') as $message)
                                    <span class="control-label" for="inputError"><i class="feather icon-x-circle"></i>
                                        {{ $message }}</span><br>
                                @endforeach
                            </span>
                        @endif

                    </fieldset>
                    <div class="form-group d-flex justify-content-between align-items-center">
                        <div class="text-left">
                            @if (config('admin.auth.remember'))
                                <fieldset class="checkbox">
                                    <div class="vs-checkbox-con vs-checkbox-primary">
                                        <input id="remember" name="remember" value="1" type="checkbox"
                                            {{ old('remember') ? 'checked' : '' }}>
                                        <span class="vs-checkbox">
                                            <span class="vs-checkbox--check">
                                                <i class="vs-icon feather icon-check"></i>
                                            </span>
                                        </span>
                                        <span>记住我</span>
                                    </div>
                                </fieldset>
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-right login-btn">
                        登录
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
    });

</script>
