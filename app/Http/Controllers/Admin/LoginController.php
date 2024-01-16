<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Login;
use App\Tools\XdbSearcher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mews\Captcha\Facades\Captcha;

class LoginController extends Controller
{

    //登录
    public function index(Request $request)
    {
        try {
            $data = $request->all();
            $check = Captcha::check_api($data['captcha'], $data['captchaKey']);
            if (!$check) {
                return $this->returnJson(1, null, '验证码错误或者已失效');
            }
            $login = [
                'username' => $data['username'],
                'password' => $data['password'],
            ];
            $token = auth('admin')->attempt($login);
            $ip = $request->getClientIp();
            $searcher = new XdbSearcher();
            $address = $searcher->search($ip);
            if ($token) {
                $user = auth('admin')->user();
                $log = [
                    'username' => $data['username'],
                    'password' => $data['password'],
                    'status' => Login::STATUS_1,
                    'address' => $address,
                    'ip' => $ip,
                    'login_at' => Carbon::now(),
                ];
                Login::create($log);
                $return = [
                    'user' => ['nickname' => $user['nickname'], 'avatar' => $user['avatar']],
                    'access_token' => $token,
                    'expires_in' => auth('admin')->factory()->getTTL() * config('setting.online_time')
                ];
                return $this->returnJson(0, $return, '登录成功，页面跳转种...');
            }
            //记录异常日志
            $log = [
                'username' => $data['username'],
                'password' => $data['password'],
                'status' => Login::STATUS_2,
                'address' => $address,
                'ip' => $ip,
                'login_at' => Carbon::now(),
            ];
            Login::create($log);
            return $this->returnJson(1, null, '用户名或者密码错误，请联系管理员');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }


}
