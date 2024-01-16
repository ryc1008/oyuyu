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
            .airdrop{
                border-radius: 8px;
            }
        </style>
    </head>
    <body>
        <div class="app">
{{--            http://111.230.11.24:85/h5GameNew {{ route('web.iframe') }}   --}}
            <iframe src="http://111.230.11.24:85/h5GameNew" scrolling="no" width="100%" height="100%" frameborder="0"   marginwidth="0" marginheight="0" class="myiframe" id="game_if ">

            </iframe>
        </div>
    </body>

    <script>
        window.addEventListener('message',function(e){
            let data = e.data;
            console.log(data);
            switch (data.event){
                case 'airdrop':

                    break;
                case 'change_zhuanshi':
                        console.log(123123123)
                    break;
                case 'change_jinbi':
                    layer.open({
                        type: 2,
                        title: '',
                        closeBtn: 1,
                        shadeClose: false,
                        shade: 0.7,
                        area: ['90%', '90%'],
                        content: "{{ route('airdrop.iframe')}}?acc=" + data.account
                    });
                    break;
                case 'login':
                    $.post("{{ route('user.register') }}",
                        {acc: data.account, '_token': "{{csrf_token()}}"},
                        function (res){
                            console.log(res);
                        }, 'json');
                    break;
                default:
                    layer.open({
                        type: 2,
                        title: '',
                        closeBtn: 1,
                        shadeClose: false,
                        shade: 0.7,
                        area: ['90%', '90%'],
                        content: "{{ route('airdrop.iframe')}}?acc=" + data.account
                    });
                    break;
            }
        },false);
    </script>
</html>
