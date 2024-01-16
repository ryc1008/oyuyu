<template>
    <div class="board-content">
        <div class="board-header"  v-if="form">
            <el-form :model="form" class="board-form" ref="form"  label-width="120px">
                <el-tabs v-model="active" type="card">
                    <el-tab-pane label="基本设置" name="first">
                        <div class="board-form-item">
                            <el-form-item label="在线时间：" prop="online_time">
                                <el-input  v-model="form.online_time" placeholder="管理员登录持续时间，过时需要重新登录" size="medium"> <template slot="append">分</template></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> 管理员登录持续时间，过时需要重新登录
                                </div>
                            </el-form-item>
                            <el-form-item label="后台分页：" prop="page_limit">
                                <el-input  v-model="form.page_limit" placeholder="后台内容分页数据数量" size="medium"> <template slot="append">条</template></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> 后台内容分页数据数量
                                </div>
                            </el-form-item>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="鱼雷控制" name="second">
                        <div class="board-form-item">

                            <el-form-item label="投放数量：" prop="throw_torpedo">
                                <el-input  v-model="form.throw_torpedo" placeholder="弹头投放数量" size="medium"> <template slot="append">个</template></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> 弹头投放数量
                                </div>
                            </el-form-item>
                            <el-form-item label="鱼类掉率：" prop="fish_drop">
                                <el-input  v-model="form.fish_drop" placeholder="普通鱼类掉落弹头率" size="medium"> <template slot="append">%</template></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> 普通鱼类掉落弹头率
                                </div>
                            </el-form-item>
                            <el-form-item label="BUFF保底：" prop="buff_end">
                                <el-input  v-model="form.buff_end" placeholder="BUFF保底值，防止裸奔" size="medium"></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> BUFF保底值，防止裸奔
                                </div>
                            </el-form-item>
                            <el-form-item label="最高倍率：" prop="height_multiple">
                                <el-input  v-model="form.height_multiple" placeholder="最高倍率：用户兑换一个鱼雷最多能掉几个" size="medium"> <template slot="append">倍</template></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> 最高倍率：用户兑换1个鱼雷最多能掉几个
                                </div>
                            </el-form-item>
                            <el-form-item label="中奖概率：" prop="win_probability">
                                <el-input  v-model="form.win_probability" placeholder="中奖概率" size="medium"><template slot="append">%</template></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> 中奖概率，最大概率固定，这个值越大，平台收益越小
                                </div>
                            </el-form-item>
                            <el-form-item label="影响系数：" prop="effect_factor">
                                <el-input  v-model="form.effect_factor" placeholder="影响系数" size="medium"><template slot="append">%</template></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> 影响系数：其他因素（RIO，总奖池）影响中奖概率的上下波浮
                                </div>
                            </el-form-item>
                            <el-form-item label="幸运上限：" prop="lucky_number">
                                <el-input  v-model="form.lucky_number" placeholder="幸运值上限，当幸运值达到上限值时掉落剩余所有BUFF值" size="medium"></el-input>
                                <div class="board-form_tip">
                                    <i class="fa fa-exclamation-circle"></i> 幸运值上限，当幸运值达到上限值时掉落剩余所有BUFF值
                                </div>
                            </el-form-item>
                        </div>
                    </el-tab-pane>
                    <el-tab-pane label="兑换设置" name="three">
                        <el-form-item label="黄金鱼雷兑换：" prop="gold_torpedo_scale">
                            <el-input  v-model="form.gold_torpedo_scale" placeholder="黄金鱼雷兑换白银鱼雷比例" size="medium"></el-input>
                            <div class="board-form_tip">
                                <i class="fa fa-exclamation-circle"></i> 1个黄金鱼雷兑换白银鱼雷比例
                            </div>
                        </el-form-item>
                        <el-form-item label="钻石鱼雷兑换：" prop="diamond_torpedo_scale">
                            <el-input  v-model="form.diamond_torpedo_scale" placeholder="钻石鱼雷兑换白银鱼雷比例" size="medium"></el-input>
                            <div class="board-form_tip">
                                <i class="fa fa-exclamation-circle"></i> 1个钻石鱼雷兑换白银鱼雷比例
                            </div>
                        </el-form-item>
                        <el-form-item label="金币兑换：" prop="gold_scale">
                            <el-input  v-model="form.gold_scale" placeholder="白银鱼雷兑换金币比例" size="medium"></el-input>
                            <div class="board-form_tip">
                                <i class="fa fa-exclamation-circle"></i> 1个白银鱼雷兑换金币比例
                            </div>
                        </el-form-item>
                        <el-form-item label="钻石兑换：" prop="diamond_scale">
                            <el-input  v-model="form.diamond_scale" placeholder="白银鱼雷兑换钻石比例" size="medium"></el-input>
                            <div class="board-form_tip">
                                <i class="fa fa-exclamation-circle"></i> 1个白银鱼雷兑换钻石比例
                            </div>
                        </el-form-item>
                        <el-form-item label="VIP兑换：" prop="vip_experience">
                            <el-input  v-model="form.vip_experience" placeholder="白银鱼雷兑换VIP经验值比例" size="medium"></el-input>
                            <div class="board-form_tip">
                                <i class="fa fa-exclamation-circle"></i> 1个白银鱼雷兑换VIP经验值比例
                            </div>
                        </el-form-item>
                    </el-tab-pane>
                </el-tabs>
                <el-form-item class="board-form-button">
                    <el-button type="primary" :loading="button.loading" :disabled="button.disable"
                               @click="update">{{ button.text }}</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>
<script>
import {mapState} from "vuex";
import {ConfigList, ConfigUpdate} from '../../utils/request';

export default {
    computed: {
        ...mapState({
            title: state => state.title,
            upload: state => state.upload,
        }),
    },
    data(){
        return {
            loading: false,
            button: {loading: false, disable: false, text: '提 交'},
            form: null,
            active: 'first'
        }
    },
    activated(){
        this.config();
    },
    methods: {
        async config() {
            await this.$func.verify('config.list');
            this.loading = true;
            ConfigList().then((res) => {
                if (res.status) {
                    this.$func.error(res.message);
                } else {
                    this.form = res.data;
                }
                this.loading = false;
            }).catch((e) => {
                this.loading = false;
            });
        },
        async update() {
            await this.$func.verify('config.update');
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    this.button.disabled = true;
                    this.button.loading = true;
                    this.button.text = '提交中...';
                    ConfigUpdate(this.form).then((res) => {
                        if (res.status) {
                            this.$func.error(res.message);
                        } else {
                            this.$func.success(res.message);
                        }
                        this.button.disabled = false;
                        this.button.loading = false;
                        this.button.text = '提 交';
                    }).catch((e) => {
                        this.button.disabled = false;
                        this.button.loading = false;
                        this.button.text = '提 交';
                    });
                }
            });
        },
        uploadSuccess(res, file, name) {
            this.uploadLoading.close();
            if (res.status) {
                this.$func.error(res.message);
            } else {
                this.form[name] = res.data;
            }
        },
        uploadBefore(file) {
            const isLt2M = file.size / 1024 / 1024 < 2;
            if (!isLt2M) {
                this.$func.error('上传的图片不能大于2M');
                return false;
            }
            this.uploadLoading = this.$loading({
                lock: true,
                spinner: 'el-icon-loading',
                text: '上传中...',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            return true;
        },
    }
}
</script>
<style scoped>
.web_logo{
    width: 120px;height: 80px;line-height: 80px;
}
.web_ico{
    width: 80px;height: 80px;line-height: 80px;
}
.web_wechat{
    width: 100px;height: 100px;line-height: 100px;
}
.applet_share{
    width: 100px;height: 175px;line-height: 175px;
}
.board-form-item{
    padding:15px 15vh 0 10vh;
}
</style>
