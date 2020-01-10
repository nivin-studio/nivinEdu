<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width,initial-scale=1,user-scalable=0,viewport-fit=cover" name="viewport">
    <title>拟物校园</title>
    <link href="/css/weui.css" rel="stylesheet" />
    <style type="text/css">
        .page, body {
            background-color: #ededed;
        }
        .page.flex .placeholder {
            margin: 5px;
            padding: 0 10px;
            background-color: #f7f7f7;
            height: 2.3em;
            line-height: 2.3em;
            text-align: center;
            color: rgba(0,0,0,.3);
        }
    </style>
</head>


<body>
    <div class="page flex js_show">

        <div class="page__hd">
            <h1 class="page__title">基本信息</h1>
        </div>

        <div class="page__bd">
            <div class="weui-flex">
                <div class="weui-flex__item"><div class="placeholder">{{ person['xm'] }}</div></div>
            </div>
            <div class="weui-flex">
                <div class="weui-flex__item"><div class="placeholder">学号:{{ person['xh'] }}</div></div>
                <div class="weui-flex__item"><div class="placeholder">性别:{{ person['xb'] }}</div></div>
            </div>
            <div class="weui-flex">
                <div class="weui-flex__item"><div class="placeholder">生日:{{ person['sr'] }}</div></div>
                <div class="weui-flex__item"><div class="placeholder">民族:{{ person['mz'] }}</div></div>
            </div>
            <div class="weui-flex">
                <div class="weui-flex__item"><div class="placeholder">学历:{{ person['xl'] }}</div></div>
                <div class="weui-flex__item"><div class="placeholder">学院:{{ person['xy'] }}</div></div>
            </div>
            <div class="weui-flex">
                <div class="weui-flex__item"><div class="placeholder">专业:{{ person['zy'] }}</div></div>
                <div class="weui-flex__item"><div class="placeholder">班级:{{ person['bj'] }}</div></div>
            </div>
        </div>

        <div class="page__hd">
            <h1 class="page__title">成绩</h1>
        </div>

        <div class="page__bd">
                <div class="weui-flex">
                    <div class="weui-flex__item"><div class="placeholder">课程</div></div>
                    <div class="weui-flex__item"><div class="placeholder">成绩</div></div>
                    <div class="weui-flex__item"><div class="placeholder">绩点</div></div>
                    <div class="weui-flex__item"><div class="placeholder">学分</div></div>
                </div>
            {% for grade in grades %}
                <div class="weui-flex">
                    <div class="weui-flex__item"><div class="placeholder">{{ grade['km'] }}</div></div>
                    <div class="weui-flex__item"><div class="placeholder">{{ grade['cj'] }}</div></div>
                    <div class="weui-flex__item"><div class="placeholder">{{ grade['jd'] }}</div></div>
                    <div class="weui-flex__item"><div class="placeholder">{{ grade['xf'] }}</div></div>
                </div>
            {% endfor %}
        </div>
        
        <div class="page__hd">
            <h1 class="page__title">课表</h1>
        </div>

        <div class="page__bd">
            <div style="background-color: #f7f7f7;">
               {{ tables }} 
            </div>
        </div>
    </div>
</body>

</html>