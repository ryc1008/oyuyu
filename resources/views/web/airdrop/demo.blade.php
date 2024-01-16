<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="_token" content="{{csrf_token()}}">
        <title>全民捕鱼</title>
        <!-- 防止被缓存-->
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Expires" content="0">
        <!-- 极速模式-->
        <meta name="renderer" content="webkit">
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="full-screen" content="true"/>
        <meta name="screen-orientation" content="portrait"/>
        <meta name="x5-fullscreen" content="true"/>
        <meta name="360-fullscreen" content="true"/>
        <script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
        <script src="{{ asset('js/layer.js') }}"></script>
        <style>
            html,
            body,
            .app {
                -ms-touch-action: none;
                padding: 0;
                border: 0;
                margin: 0;
                height: 100%;
            }
            .layui-layer-setwin .layui-layer-close2 {
                right: -10px;
                top: -10px;
                background-image: url("{{asset('image/web/close.png') }}");
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center center;
            }
            .myiframe{
                border:none;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>
    <body>
    </body>

    <script>

        $(function (){
            window.addEventListener('message',function(e){
                let data = e.data;
                console.log('游戏内收到更新请求', data);

            },false);
        })
    </script>
</html>
