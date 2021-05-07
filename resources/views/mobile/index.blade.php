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
        <div class="page__hd">
            <h1 class="page__title nivin-no-radius">拟物校园</h1>
        </div>
        <div class="page__bd">
            <div class="weui-cells">
                @if ($schools)
                    @foreach ($schools as $school)

                        <div class="weui-cell weui-cell_access nivin-a">
                            <div class="weui-cell__hd">
                                <img src="{{ $school->icon }}" alt="">
                            </div>
                            <div class="weui-cell__bd">
                                <p>{{ $school->name }}</p>
                            </div>
                            <div class="weui-cell__ft"></div>
                        </div>

                    @endforeach
                @endif
            </div>
        </div>
        <div class="page__ft">
            <div class="weui-footer">
                <p class="weui-footer__text">Copyright © 2016-2020 nivin.cn</p>
            </div>
        </div>
    </div>
</body>

</html>
