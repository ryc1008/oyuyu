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
    <style>
        html,
        body{
            -ms-touch-action: none;
            padding: 0;
            border: 0;
            margin: 0;
            height: 100%;
            max-width: 100%;
            /*splash.jpg*/
            background-image: url("{{asset('image/web/splash.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            overflow: hidden;
            font-size: 14px;
        }
        ul, li{
            list-style: none;
            font-size: 22px;
            font-weight: 700;
            padding-inline-start: 0;
            /*padding-left: 55px;*/
            color: #0B475E;
            text-shadow: 1px 1px 0 #71D9E5;
        }
        li{
            height: 55px;
            line-height: 45px;
            background-image: url("{{asset('image/web/tab.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            width: 120px;
            margin-bottom: 25px;
        }
        li span{
            padding-left: 35px;
        }
        li.active{
            background-image: url("{{asset('image/web/active.png') }}");
            text-shadow: 1px 1px 0 #E6AD07;
            width: 135px;
        }
        .airdrop{
            display: flex;
            padding: 35px 35px 35px 25px;
            height: 85%;
        }
        .air-title{
            margin-right: 15px;
        }
        .air-content{
            flex: 1;
            background: rgba(23, 56, 70, 0.3);
            border-radius: 10px;
            padding: 25px;
        }
        .airdrop-form-btn{
            background-image: url("{{asset('image/web/btn_s.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            width: 10rem;height: 4rem;
            text-align: center;line-height: 3rem;
            margin: 5rem auto 0;
            color: #fff;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .airdrop-dui .airdrop-form-btn{
            margin-top: 0;
        }
        .cate-box, .cate-box .cate, .form-item, .number-box{
            display: flex;align-items: center;
            align-content: space-between;
            flex-wrap: wrap;
        }
        .form-item{
            margin-bottom: 25px;
        }
        .cate-box .cate{
            margin-right: 0.5rem;
            background-image: url("{{asset('image/web/btn_d.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            overflow: hidden;
            color: #0050ff;
            font-weight: 700;
            font-size: 1rem;
        }
        .form-item-title{
            font-size: 1rem;
            color: #022d3b;
            text-shadow: 1px 1px 0 #336be5;
            width: 5rem;
        }
        .cate-box .cate.active{
            background-image: url("{{asset('image/web/btn.png') }}");
            color: #FFF;
        }
        .cate-box img{
            width: 1.2rem;margin-right: 5px;
        }
        .number-box img{
            width: 2rem;
        }
        .number, .dui-box .code{
            background: #7FD4FB;
            border: none;
            border-radius: 10px;
            height: 1.8rem;
            text-align: center;
            color: #0050ff;margin: 0 5px;
            width: 6rem;
        }
        .dui-box{
            display: flex;align-content: center;
            align-items: center;
        }
        .dui-box .code{
            width: 15rem;height: 2.5rem;
            margin: 3rem auto;
        }
        .number::placeholder, .dui-box .code::placeholder {
            color: #0050ff;
            opacity: 0.5;
        }
        .number:active, .number:focus,
        .dui-box .code:active, .dui-box .code:focus{
            border: none;
            outline: none;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.3);
        }
        .c-tab{
            display: none;
        }
        .copy-btn{
            background-image: url("{{asset('image/web/copy.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            text-align: center;
            width: 3rem;height: 1.5rem;line-height: 1.5rem;
            color: #1203b0;
            font-size: 0.8rem;
        }
        .record-title, .record-item{
            display: flex;align-items: center;
            align-content: space-between;
            width: 100%;margin-bottom: 1.5rem;
        }
        .record-title{
            font-size: 1.3rem;font-weight: 700;
            color: #0050ff;
            text-shadow: 1px 1px 0 #7FD4FB;
        }
        .record-item{
            margin-top: 1rem;
        }
        .w-35{
            width: 35%;text-align: center;

        }
        .w-30{
            width: 30%;
        }
        .record-item  .w-35{
            color: #FFF;
        }
        .record-item  .w-35.code{
            color: #f34c05;font-weight: 700;
        }
        .record-box{
            height: calc(60vh);
            overflow-y: auto;
            overflow-x: hidden;
        }
    </style>
</head>
<body>
<div class="airdrop">
    <div class="air-title">
        <ul>
            <li class="form active"><span>空 投</span></li>
            <li class="record"><span>记 录</span></li>
            <li class="dui"><span>兑 换</span></li>
        </ul>
    </div>
    <div class="air-content">
        <div class="c-tab airdrop-form">
            <div class="form-item">
                <div class="cate-box">
                    <div class="cate active" data-type="25"><img src="{{ asset('image/web/yu1.png') }}" alt=""> <div>白银鱼雷({{ $torpedo['torpedo_silver'] }})</div></div>
                    <div class="cate" data-type="26"><img src="{{ asset('image/web/yu2.png') }}" alt=""> <div>黄金鱼雷({{ $torpedo['torpedo_gold'] }})</div></div>
                    <div class="cate" data-type="27"><img src="{{ asset('image/web/yu3.png') }}" alt=""> <div>钻石鱼雷({{ $torpedo['torpedo_diamond'] }})</div></div>
                </div>
            </div>
            <div class="form-item">
                <div class="form-item-title">空投数量： </div>
                <div class="number-box">
                    <img class="dec-number" src="{{ asset('image/web/dec.png') }}" alt="">
                    <input type="number"  name="number" class='number airdrop-number' value="0" placeholder="空投数量">
                    <img class="add-number" src="{{ asset('image/web/add.png') }}" alt="">
                </div>
            </div>
            <div class="airdrop-form-btn form-submit">确 定</div>
        </div>
        <div class="c-tab airdrop-record">
            <div class="record-table">
                <div class="record-title"><div class="w-35">鱼雷名称&数量</div><div class="w-35">兑换码</div><div class="w-30">操 作</div></div>
                <div class="record-box">

                </div>
            </div>
        </div>
        <div class="c-tab airdrop-dui">
            <div class="dui-box">
                <input type="text"  id="dui-code" name="code" class='code' value="" placeholder="兑换码">
            </div>
            <div class="airdrop-form-btn dui-submit">提 交</div>
        </div>
    </div>
</div>
</body>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('js/layer.js') }}"></script>

<script>
    $(function (){
        let acc = "{{ $acc }}";
        let disabled = true;
        $('.airdrop-form').show();
        $('.form-submit').on('click' ,function (){
            if(acc){
                let type = $('.form-item .cate.active').attr('data-type');
                let number = $('.form-item .number').val();
                if(!disabled){
                    return false;
                }
                disabled = false;
                if(number < 1){
                    layer.msg('请填写空投鱼雷数量');
                    return false;
                }
                $.post("{{ route('airdrop.update') }}",
                    {acc: acc, type: type, number: number, '_token': "{{csrf_token()}}"},
                    function (res){
                        if(res.status){
                            disabled = true;
                            layer.msg(res.message)
                        }else{
                            layer.msg(res.message, {time: 2000}, ()=>{
                                window.location.reload();
                            })
                        }
                    }, 'json');
            }
        })
        $('.airdrop ul li').on('click', function (){
            $(".c-tab").hide();
            if($(this).hasClass('form')){
                window.location.reload();
                // $(".cate-box .cate:first").addClass('active').siblings().removeClass('active');
                // $('.airdrop-form').show();
            }
            if($(this).hasClass('record')){
                $('.airdrop-record').show();
                if(acc){
                    $.get("{{ route('airdrop.record') }}", {acc: acc},
                        function (res){
                            if(res.status){
                                layer.msg(res.message)
                            }else{
                                let html = '';
                                $.each(res.data, (index, item)=>{
                                    html += "<div class='record-item'><div class='w-35'>" + item.name + " x " + item.number + "</div><div class='w-35 code'>" + item.redeem_code + "</div><div class='w-30'><div class='copy-btn' data-clipboard-action='copy'  data-code='"+ item.redeem_code +"'>复制</div></div></div>";
                                });
                                $('.record-box').html(html);
                            }
                        }, 'json');
                }
            }
            if($(this).hasClass('dui')){
                $('.airdrop-dui').show();
            }
            $(this).addClass('active').siblings().removeClass('active');
        });
        $('.cate-box .cate').on('click', function (){
            $(this).addClass('active').siblings().removeClass('active');
            $(".number").val(0);
        })
        $('.add-number').on('click', function (){
            if(!disabled){
                return false;
            }
            let number = parseInt($(".form-item .number").val());
            let type = $('.form-item .cate.active').attr('data-type');
            let pan = 0;
            let torpedoSilver = "{{ $torpedo['torpedo_silver'] }}";
            let torpedoGold = "{{ $torpedo['torpedo_gold'] }}";
            let torpedoDiamond = "{{ $torpedo['torpedo_diamond'] }}";
            number++;
            pan = torpedoSilver;
            if(type == 26){
                pan = torpedoGold;
            }
            if(type == 27){
                pan = torpedoDiamond;
            }
            if(number > pan){
                layer.msg('鱼雷数量不足');
                return false;
            }
            $(".form-item .number").val(number);
        })
        $.changeAirdropNumber = function (){
            if(!disabled){
                return false;
            }
            let number = parseInt($(".form-item .number").val());
            let type = $('.form-item .cate.active').attr('data-type');
            let pan = 0;
            let torpedoSilver = "{{ $torpedo['torpedo_silver'] }}";
            let torpedoGold = "{{ $torpedo['torpedo_gold'] }}";
            let torpedoDiamond = "{{ $torpedo['torpedo_diamond'] }}";
            if(number < 0 || number.toString().includes('.') || !/^\d+$/.test(number) || number.toString().includes('-')){
                number = 0;
            }
            pan = torpedoSilver;
            if(type == 26){
                pan = torpedoGold;
            }
            if(type == 27){
                pan = torpedoDiamond;
            }
            if(number > pan){
                layer.msg('鱼雷数量不足');
                return false;
            }
            $(".form-item .number").val(number);
        }
        $('.form-item .airdrop-number').on('change', function (){
            $.changeAirdropNumber();
        })
        $('.dui-submit').on('click' ,function (){
            if(acc){
                let code = $('.airdrop-dui .code').val();
                $.post("{{ route('airdrop.redeem') }}", {acc: acc, code: code, '_token': "{{csrf_token()}}"},
                    function (res){
                        if(res.status){
                            $('.airdrop-dui .code').val('');
                            layer.msg(res.message)
                        }else{
                            $('.airdrop-dui .code').val('');
                            layer.msg(res.message)
                        }
                    }, 'json');
            }
        })
        $('.airdrop-record').on('click', '.copy-btn', function (){
            let content = $(this).attr('data-code');
            let clipboard = new ClipboardJS('.copy-btn', {
                text: function() {
                    return content;
                }
            });
            clipboard.on('success', e => {
                layer.msg('复制成功')
                // 释放内存
                clipboard.destroy()
            })
            clipboard.on('error', function(e) {
                layer.msg('复制失败')
                // 释放内存
                clipboard.destroy()
            });
        })
        $('.form-item .dec-number').on('click', function (){
            if(!disabled){
                return false;
            }
            let number = parseInt($(".form-item .number").val());
            number--;
            if(number < 0){
                return false;
            }
            $(".form-item .number").val(number);
        })
    })
</script>
</html>
