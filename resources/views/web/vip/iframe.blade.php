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
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}"/>
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
            background-image: url("{{asset('image/web/duf2.png') }}");
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
            padding: 5px 35px 35px 25px;
            height: 85%;
            text-align: center;
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
            text-align: center;line-height: 3.2rem;
            margin: 2rem auto 0;
            color: #fff;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .airdrop-dui .airdrop-form-btn{
            margin-top: 0;
        }
        .cate-box, .cate-box .cate, .number-box{
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
            color: #031480;
            /*text-shadow: 1px 1px 0 #F6B21C;*/
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
        .number, .gold{
            background: #7FD4FB;
            border: none;
            border-radius: 10px;
            height: 1.8rem;margin: 0 5px;
            text-align: center;
            color: #0050ff;
            width: 8rem;
        }
        .gold{
            background: #F6B21C;color: #fff;
            width: 12rem;
        }
        .air-title{
            font-size: 1.5rem;
            color: #031480;
            text-shadow: 1px 1px 0 #0420c2;
            display: block;
            margin-bottom: 15px;
        }
        .vip-level{
            color: #fff;
        }
    </style>
</head>
<body>
<div class="airdrop">
    <div class="air-title">购买VIP等级 </div>
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
                <div class="number-box">
                    <div class="form-item-title">兑换数量： </div>
                    <img class="dec-number" src="{{ asset('image/web/dec.png') }}" alt="">
                    <input type="number"  name="number" class='number vip-number' value="0" placeholder="兑换数量" readonly>
                    <img class="add-number" src="{{ asset('image/web/add.png') }}" alt="">
                </div>
            </div>
            <div class="form-item">
                <div class="number-box">
                    <div class="form-item-title">VIP经验： </div>
                    <input type="number" id="airdrop-gold" name="gold" class='gold' value="{{$user['vip_exp']}}" placeholder="获得的VIP经验" readonly>
                    <div class="vip-level"> V<span class="vlevel">{{$level}}</span> </div>
                </div>
            </div>
            <div class="airdrop-form-btn form-submit">确 定</div>
        </div>
    </div>
</div>
</body>
<script src="{{ asset('js/clipboard.min.js') }}"></script>
<script src="{{ asset('js/jquery-3.7.1.js') }}"></script>
<script src="{{ asset('js/layer.js') }}"></script>

<script>
    $(function (){
        let acc = "{{ $user['acc'] }}";
        let disabled = true;
        $('.form-submit').on('click' ,function (){
            if(acc){
                let type = $('.form-item .cate.active').attr('data-type');
                let gold = $('.form-item .gold').val();
                let number = $('.form-item .number').val();
                let torpedoSilver = "{{ $torpedo['torpedo_silver'] }}";
                let torpedoGold = "{{ $torpedo['torpedo_gold'] }}";
                let torpedoDiamond = "{{ $torpedo['torpedo_diamond'] }}";
                let pan = torpedoSilver;
                if(type == 26){
                    pan = torpedoGold;
                }
                if(type == 27){
                    pan = torpedoDiamond;
                }
                if(parseInt(number) > parseInt(pan)){
                    layer.msg('鱼雷数量不足');
                    return false;
                }
                if(number < 1){
                    layer.msg('请输入你要兑换的鱼雷数量');
                    return false;
                }
                if(!disabled){
                    return false;
                }
                disabled = false;
                layer.msg('数据提交中，请稍后...')
                $.post("{{ route('vip.update') }}",
                    {acc: acc, type: type, gold: gold, number: number, '_token': "{{csrf_token()}}"},
                    function (res){
                        if(res.status){
                            disabled = true;
                            layer.msg(res.message)
                        }else{
                            layer.msg(res.message, {time: 2000}, ()=>{
                                window.parent.top.postMessage({event: 'return_update'}, '*');
                            })
                        }
                }, 'json');
            }
        })
        $('.form-item .cate-box').on('click', '.cate', function (){
            if(!disabled){
                return false;
            }
            $(this).addClass('active').siblings().removeClass('active');
            $('.form-item .number').val(0);
            $('.form-item .gold').val({{$user['vip_exp']}});
        })
        $.vipLevel = function (vipExp){
            let exps = [0, 10, 100, 200, 500, 1000, 2000, 5000, 10000, 20000, 50000];
            let records = exps.filter((item)=> {
                return item <= vipExp;
            });
            return records.length - 1;
        }
        $('.form-item .add-number').on('click', function (){
            if(!disabled){
                return false;
            }
            let number = parseInt($(".form-item .number").val());
            let type = $('.form-item .cate.active').attr('data-type');
            let redeemscale = parseInt("{{ $setting['vip_experience'] }}");
            let goldScale = parseInt("{{ $setting['gold_torpedo_scale'] }}");
            let diamondScale = parseInt("{{ $setting['diamond_torpedo_scale'] }}");
            let pan = 0;
            let gold = parseInt("{{$user['vip_exp']}}");
            let torpedoSilver = parseInt("{{ $torpedo['torpedo_silver'] }}");
            let torpedoGold = parseInt("{{ $torpedo['torpedo_gold'] }}");
            let torpedoDiamond = parseInt("{{ $torpedo['torpedo_diamond'] }}");
            number++;
            if(type == 25){
                gold += number * redeemscale;
                pan = torpedoSilver;
            }
            if(type == 26){
                gold += number * redeemscale * goldScale;
                pan = torpedoGold;
            }
            if(type == 27){
                gold += number * redeemscale * diamondScale;
                pan = torpedoDiamond;
            }
            if(parseInt(number) > parseInt(pan)){
                layer.msg('鱼雷数量不足');
                return false;
            }
            console.log(gold)
            if(gold > 50000){
                layer.msg('VIP等级已经为最高等级');
                return false;
            }
            $(".form-item .gold").val(gold);
            $(".form-item .number").val(number);
            let level = $.vipLevel(gold);
            $(".form-item .vip-level .vlevel").html(level);
        })
        $('.form-item .dec-number').on('click', function (){
            if(!disabled){
                return false;
            }
            let number = parseInt($(".form-item .number").val());
            let type = $('.form-item .cate.active').attr('data-type');
            let redeemscale = parseInt("{{ $setting['vip_experience'] }}");
            let goldScale = parseInt("{{ $setting['gold_torpedo_scale'] }}");
            let diamondScale = parseInt("{{ $setting['diamond_torpedo_scale'] }}");
            let gold = $('.form-item .gold').val();
            number--;
            if(type == 25){
                gold -= redeemscale;
            }
            if(type == 26){
                gold -= redeemscale * goldScale;
            }
            if(type == 27){
                gold -= redeemscale * diamondScale;
            }
            if(number < 0){
                return false;
            }
            $(".form-item .gold").val(gold);
            $(".form-item .number").val(number);
            let level = $.vipLevel(gold);
            $(".form-item .vip-level .vlevel").html(level);
        })
    })
</script>
</html>
