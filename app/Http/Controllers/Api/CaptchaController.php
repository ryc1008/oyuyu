<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Mews\Captcha\Facades\Captcha;

class CaptchaController extends Controller {

    public function index(){
        try {
            $captcha = Captcha::create('default', true);
            return $this->returnJson(0, $captcha);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }
}
