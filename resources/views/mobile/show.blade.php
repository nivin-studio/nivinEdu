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
    <div class="page flex js_show">

        <div class="page__hd">
            <h1 class="page__title">基本信息</h1>
        </div>
        <div class="page__bd">
            <div class="weui-form-preview weui-form-show nivin">
                <div class="weui-form-preview__hd">
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">{{ $persos['student_name'] }}</label>
                        <em class="weui-form-preview__value">{{ $persos['student_no'] }}</em>
                    </div>
                </div>
                <div class="weui-form-preview__bd">
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">性别</label>
                        <span class="weui-form-preview__value">{{ $persos['gender'] }}</span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">出生日期</label>
                        <span class="weui-form-preview__value">{{ $persos['birth_date'] }}</span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">民族</label>
                        <span class="weui-form-preview__value">{{ $persos['nation'] }}</span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">学历</label>
                        <span class="weui-form-preview__value">{{ $persos['education'] }}</span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">学院</label>
                        <span class="weui-form-preview__value">{{ $persos['college'] }}</span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">专业</label>
                        <span class="weui-form-preview__value">{{ $persos['major'] }}</span>
                    </div>
                    <div class="weui-form-preview__item">
                        <label class="weui-form-preview__label">班级</label>
                        <span class="weui-form-preview__value">{{ $persos['class'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        @if ($scores)

            <div class="page__hd">
                <h1 class="page__title">成绩</h1>
            </div>

            <div class="page__bd">
                <div class="weui-form-preview weui-form-show nivin">
                    <div class="weui-form-preview__bd">
                        @foreach ($scores as $score)
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{{ $score['course_name'] }}</label>
                                <span
                                    class="weui-form-preview__value">{{ $score['score'] }}-{{ $score['credit'] }}-{{ $score['gpa'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        @endif

        @if ($tables)

            <div class="page__hd">
                <h1 class="page__title">课表</h1>
            </div>

            <div class="page__bd">
                <div class="weui-form-preview weui-form-show nivin">
                    <div class="weui-form-preview__bd">
                        @foreach ($tables as $table)
                            <div class="weui-form-preview__item">
                                <label class="weui-form-preview__label">{{ $table['course_name'] }}</label>
                                <span
                                    class="weui-form-preview__value">{{ $table['period'] }}-{{ $table['week'] }}-{{ $table['section'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        @endif

    </div>
</body>

</html>
