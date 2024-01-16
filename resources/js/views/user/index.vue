<template>
    <div class="board-content">
        <div class="board-header">
            <div class="board-search">
                <div class="search-item" style="width: 250px">
                    <el-input v-model="params.kwd" placeholder="请输入ACC / 玩家ID" size="small" clearable>
                    </el-input>
                </div>
                <div class="search-item">
                    <el-button type="primary" @click="search()" size="small" icon="el-icon-search">搜索</el-button>
                </div>
            </div>
            <div class="board-handle">
                <el-button type="warning" icon="fa fa-refresh" @click="list()" size="small"> 刷新</el-button>
            </div>
        </div>
        <div class="board-main">
            <el-table v-if="datas"  element-loading-text="努力加载中..."
                      element-loading-spinner="el-icon-loading"
                      ref="multipleHandle" stripe
                      tooltip-effect="dark" :height="tableHeight"
                      v-loading="loading"
                      :data="datas.data" border>
                <el-table-column prop="id" label="编号" width="90" align="center">
                    <template slot-scope="scope">
                        <span :style="scope.row.identity > 1 ? 'color:#ff6c60' : ''">{{ scope.row.id}}</span>
                    </template>
                </el-table-column>
                <el-table-column prop="identity_text" label="状态" width="80" align="center">
                    <template slot-scope="scope">
                        <el-tag :type="$func.formatTag(scope.row.identity)">{{ scope.row.identity_text }}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="acc" label="玩家账户" width="100" align="center"></el-table-column>
                <el-table-column prop="player_id" label="玩家ID" width="100" align="center"></el-table-column>
                <el-table-column prop="nickname" label="昵称" width="100"></el-table-column>
                <el-table-column prop="torpedo_silver" label="白银鱼雷" width="80" align="center"></el-table-column>
                <el-table-column prop="torpedo_gold" label="黄金鱼雷" width="80" align="center"></el-table-column>
                <el-table-column prop="torpedo_diamond" label="钻石鱼雷" width="80" align="center"></el-table-column>
                <el-table-column prop="silver_number" label="鱼雷价值" width="80" align="center"></el-table-column>
                <el-table-column prop="buff_num" label="BUFF值" width="100" align="center"></el-table-column>
                <el-table-column label="ROI" width="100" align="center">
                    <template slot-scope="scope">{{ scope.row.convert_total > 0 ? (scope.row.buff_total / scope.row.convert_total).toFixed(2) : 0}}</template>
                </el-table-column>
                <el-table-column prop="ticket" label="话费余额" width="100" align="center">
                    <template slot-scope="scope">
                        <span class="ticket" @click="ticket(scope.row)" title="点我刷新" alt="点我刷新">{{ scope.row.ticket }}</span>
                    </template>
                </el-table-column>
                <el-table-column label="操作" fixed="right" min-width="200">
                    <template slot-scope="scope">
                        <el-button type="primary" icon="fa fa-edit" size="mini" plain @click="edit(scope.row)"> 编辑
                        </el-button>
                        <el-button type="warning" icon="fa fa-plus" @click="airdrop(scope.row)" size="mini" plain> 空投</el-button>
                        <el-button type="success" icon="fa fa-yen" @click="recharge(scope.row)" size="mini" plain> 充值</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <pagination :datas="datas" @page="page"></pagination>
        <el-dialog class="board-dialog" :close-on-click-modal="false"
                   :close-on-press-escape="false"
                   :title="dialogTicket.title"
                   :visible.sync="dialogTicket.show" center>
            <el-form v-if="formTicket" :model="formTicket" :rules="rulesTicket" ref="formTicket" class="board-form" label-width="120px">
                <div class="item-title">基本信息<div class="title-note"><span>* </span>为必填项</div></div>
                <div class="form-item">
                    <el-form-item label="昵 称：" prop="nickname">
                        <el-input v-model="formTicket.nickname" placeholder="玩家昵称" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="玩 家：" prop="player_id">
                        <el-input v-model="formTicket.player_id" placeholder="玩家ID" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="账 户：" prop="acc">
                        <el-input v-model="formTicket.acc" placeholder="玩家账户" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="金 额：" prop="number" required>
                        <el-input v-model="formTicket.number" placeholder="请填写充值金额" size="medium" clearable></el-input>
                    </el-form-item>
                </div>
            </el-form>
            <span slot="footer" class="dialog-footer">
                    <el-button type="primary" :loading="button.loading" :disabled="button.disable"
                               @click="ticketRecharge">{{ button.text }}</el-button>
                    <el-button @click="dialogTicket.show = false">关 闭</el-button>
                </span>
        </el-dialog>
        <el-dialog class="board-dialog" :close-on-click-modal="false"
                   :close-on-press-escape="false"
                   :title="dialog.title"
                   :visible.sync="dialog.show" center>
            <el-form v-if="form" :model="form" :rules="rules" ref="form" class="board-form" label-width="120px">
                <div class="item-title">基本信息<div class="title-note"><span>* </span>为必填项</div></div>
                <div class="form-item">
                    <el-form-item label="昵 称：" prop="nickname">
                        <el-input v-model="form.nickname" placeholder="玩家昵称" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="玩 家：" prop="player_id">
                        <el-input v-model="form.player_id" placeholder="玩家ID" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="账 户：" prop="acc">
                        <el-input v-model="form.acc" placeholder="玩家账户" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="鱼 雷：" prop="item" required>
                        <el-radio-group v-model="form.item" size="medium">
                            <el-radio v-for="(item,index) in configs.item"
                                      :key="index"
                                      :label="Number(index)" border>{{ item }}
                            </el-radio>
                        </el-radio-group>
                    </el-form-item>
                    <el-form-item label="数 量：" prop="number" required>
                        <el-input v-model="form.number" placeholder="请填写鱼雷数量" size="medium" clearable></el-input>
                    </el-form-item>
                </div>
            </el-form>
            <span slot="footer" class="dialog-footer">
                    <el-button type="primary" :loading="button.loading" :disabled="button.disable"
                               @click="updateAirdrop">{{ button.text }}</el-button>
                    <el-button @click="dialog.show = false">关 闭</el-button>
                </span>
        </el-dialog>
        <el-dialog class="board-dialog" :close-on-click-modal="false"
                   :close-on-press-escape="false" fullscreen
                   :title="dialogTorpedo.title"
                   :visible.sync="dialogTorpedo.show" center>
            <el-form v-if="formTorpedo" :model="formTorpedo" :rules="ruleTorpedo" ref="formTorpedo" class="board-form" label-width="120px">
                <div class="item-title">基本信息<div class="title-note"><span>* </span>为必填项</div></div>
                <div class="form-item">
                    <el-form-item label="昵 称：" prop="nickname">
                        <el-input v-model="formTorpedo.nickname" placeholder="玩家昵称" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="玩 家：" prop="player_id">
                        <el-input v-model="formTorpedo.player_id" placeholder="玩家ID" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="账 户：" prop="acc">
                        <el-input v-model="formTorpedo.acc" placeholder="玩家账户" size="medium" readonly></el-input>
                    </el-form-item>
                    <el-form-item label="中奖概率：" prop="win_probability">
                        <el-input v-model="formTorpedo.win_probability" placeholder="BUFF基础中奖概率，总概率受到其他因素影响" size="medium" clearable></el-input>
                    </el-form-item>
                    <el-form-item label="幸运上限：" prop="lucky_number">
                        <el-input v-model="formTorpedo.lucky_number" placeholder="幸运上限值，当幸运值达到上限值时掉落剩余所有BUFF值" size="medium" clearable></el-input>
                    </el-form-item>
                    <el-form-item label="BUFF值：" prop="buff_num">
                        <el-input v-model="formTorpedo.buff_num" placeholder="BUFF值额度" size="medium" clearable></el-input>
                    </el-form-item>
                    <el-form-item label="BUFF保底：" prop="buff_end">
                        <el-input v-model="formTorpedo.buff_end" placeholder="BUFF保底值" size="medium" clearable><template slot="append">%</template></el-input>
                    </el-form-item>
                    <el-form-item label="鱼类掉率：" prop="fish_drop">
                        <el-input v-model="formTorpedo.fish_drop" placeholder="鱼类掉率" size="medium" clearable><template slot="append">%</template></el-input>
                    </el-form-item>
                </div>
            </el-form>
            <span slot="footer" class="dialog-footer">
                    <el-button type="primary" :loading="button.loading" :disabled="button.disable"
                               @click="update">{{ button.text }}</el-button>
                    <el-button @click="dialogTorpedo.show = false">关 闭</el-button>
                </span>
        </el-dialog>
    </div>
</template>

<script>
import {mapState} from "vuex";
import {UserList, UserConfig, UserUpdate, UserAirdrop, UserTorpedo, UserTicket, UserRecharge} from '../../utils/request';

export default {
    computed: {
        ...mapState({
            tableHeight: state => state.tableHeight,
        }),
    },
    data: function () {
        return {
            loading: false,
            agents: null,
            datas: null,
            torpedos: null,
            configs: null,
            detail: null,
            params: {page: 1, kwd: '', aid: 0},
            button: {loading: false, disable: false, text: '提 交'},
            dialog: {title: '', show: false},
            dialogTorpedo: {title: '', show: false},
            dialogTicket: {title: '', show: false},
            formTicket: null,
            formTorpedo: null,
            form: null,
            rules: {
                item: [{required: true, message: '请选择鱼雷类型', trigger: 'change'}],
                number: [{required: true, message: '请填写鱼雷数量', trigger: 'blur'}],
            },
            rulesTicket: {
                number: [{required: true, message: '请填写充值金额', trigger: 'blur'}],
            },
            ruleTorpedo:{},
        }
    },
    activated() {
        this.config();
        this.list();
    },
    methods: {
        config() {
            UserConfig().then((res) => {
                if (res.status) {
                    this.$func.error(res.message);
                } else {
                    this.configs = res.data;
                }
            });
        },
        async list() {
            await this.$func.verify('user.list');
            UserList(this.params).then((res) => {
                if (res.status) {
                    this.$func.error(res.message);
                } else {
                    this.datas = res.data;
                }
                this.loading = false;
            }).catch((e) => {
                this.loading = false;
            });
        },
        async torpedo(detail) {
            await this.$func.verify('user.torpedo');
            this.dialogTorpedo.title = '鱼雷管理';
            this.dialogTorpedo.show = true;
            UserTorpedo({id: detail.id}).then((res) => {
                if (res.status) {
                    this.$func.error(res.message);
                } else {
                    this.torpedos = res.data.items;
                }
            }).catch((e) => {});
        },
        async ticket(detail) {
            await this.$func.verify('user.ticket');
            UserTicket({id: detail.id}).then((res) => {
                if (res.status) {
                    this.$func.error(res.message);
                } else {
                    this.list();
                }
            }).catch((e) => {});
        },
        async recharge(detail) {
            await this.$func.verify('user.recharge');
            this.formTicket = {
                id: detail.id,
                nickname: detail.nickname,
                player_id: detail.player_id,
                acc: detail.acc,
            };
            this.dialogTicket.title = '话费充值';
            this.dialogTicket.show = true;
            this.$nextTick(() => {
                this.$refs['formTicket'].clearValidate();
            });
        },
        async airdrop(detail) {
            await this.$func.verify('user.airdrop');
            this.form = {
                id: detail.id,
                item: 25,
                nickname: detail.nickname,
                player_id: detail.player_id,
                acc: detail.acc,
            };
            this.dialog.title = '鱼雷充值';
            this.dialog.show = true;
            this.$nextTick(() => {
                this.$refs['form'].clearValidate();
            });
        },
        async edit(detail) {
            await this.$func.verify('user.edit');
            this.formTorpedo = {
                id: detail.id,
                nickname: detail.nickname,
                acc: detail.acc,
                player_id: detail.player_id,
                fish_drop: detail.fish_drop,
                buff_num: detail.buff_num,
                buff_end: detail.buff_end,
                win_probability: detail.win_probability,
                lucky_number: detail.lucky_number,
            };
            this.dialogTorpedo.title = '用户编辑';
            this.dialogTorpedo.show = true;
            this.$nextTick(() => {
                this.$refs['formTorpedo'].clearValidate();
            });
        },
        updateAirdrop() {
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    this.button.disabled = true;
                    this.button.loading = true;
                    this.button.text = '提交中...';
                    UserAirdrop(this.form).then((res) => {
                        if (res.status) {
                            this.$func.error(res.message);
                        } else {
                            this.$func.success(res.message).then(() => {
                                this.dialog.show = false;
                                this.list();
                            })
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
        ticketRecharge(){
            this.$refs['formTicket'].validate((valid) => {
                if (valid) {
                    this.button.disabled = true;
                    this.button.loading = true;
                    this.button.text = '提交中...';
                    UserRecharge(this.formTicket).then((res) => {
                        if (res.status) {
                            this.$func.error(res.message);
                        } else {
                            this.$func.success(res.message).then(() => {
                                this.dialogTicket.show = false;
                                this.list();
                            })
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
        update(){
            this.$refs['formTorpedo'].validate((valid) => {
                if (valid) {
                    this.button.disabled = true;
                    this.button.loading = true;
                    this.button.text = '提交中...';
                    UserUpdate(this.formTorpedo).then((res) => {
                        if (res.status) {
                            this.$func.error(res.message);
                        } else {
                            this.$func.success(res.message).then(() => {
                                this.dialogTorpedo.show = false;
                                this.list();
                            })
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
        search() {
            this.params.page = 1;
            this.list();
        },
        page(val) {
            this.params.page = val;
            this.list();
        },
    }
}
</script>
<style scoped>
    .board-table-image{
        height: 35px;width: 35px;border-radius: 50%;
    }
    .ticket{
        color: #2461ef;
        cursor: pointer;
        padding: 10px 20px;
    }
</style>
