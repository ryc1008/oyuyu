<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    //配置项
    public function list()
    {
        try {
            //TODO 根据fd 统计在线人数；计算奖池真实输赢情况； 计算单个用户的ROI和所有用户的ROI
            $setting = config('setting');
            return $this->returnJson(0, $setting);
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    //更新
    public function update(Request $request)
    {
        try {
            $data = $request->all();
            $setting = $this->setting();
            $str = '';
            foreach ($setting as $key => $val) {
                if (isset($data[$key])) {
                    $value = is_numeric($data[$key]) ? $data[$key] : "'" . $data[$key] . "'";
                    $str .= "    '" . $key . "' => " . $value . ",  //" . $val . "    \r\n\r\n";
                }
            }
            $str = <<<END
<?php

return [
$str
];
END;
            $res = file_put_contents(config_path() . '/setting.php', $str);
            return $this->returnJson(0, $res, '更新设置信息成功');
        } catch (\Throwable $e) {
            return $this->returnJson(1, null, $e->getMessage());
        }
    }

    protected function setting()
    {
        return [
            //网站设置
            'gold_torpedo_scale' => '黄金鱼雷兑换白银鱼雷比例',
            'diamond_torpedo_scale' => '钻石鱼雷兑换白银鱼雷比例',
            'gold_scale' => '金币兑换白银鱼雷比例',
            'vip_experience' => '1个白银鱼雷兑换的VIP经验值',
            'height_multiple' => '最高倍率：用户兑换1个鱼雷最多能掉几个',
            'diamond_scale' => '钻石兑换白银鱼雷比例',
            'throw_torpedo' => '弹头投放数量',
            'fish_drop' => '普通鱼类掉落弹头率',
            'buff_end' => 'BUFF保底值，防止裸奔',
            'effect_factor' => '影响系数：其他因素（RIO，总奖池）影响中奖概率的上下波浮',
            'win_probability' => '最差中奖概率，最大概率固定，这个值越大，平台收益越大',
            'lucky_number' => '幸运值上限，当幸运值达到上限值时掉落剩余所有BUFF值',
            'online_time' => '管理员登录持续时间，单位分',
            'page_limit' => '后台数据分页'
        ];
    }
}
