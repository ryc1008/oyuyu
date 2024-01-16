<template>
    <div class="board-content info">
        <div class="board-main board-card">
            <div class="board-item">权限管理</div>
            <el-form ref="form" v-loading="loading" :model="form" class="board-form" label-width="110px">
                <div class="board-form-item">
                    <div v-for="(authen,index) in authens" :key="index">
                        <div class="access-title">{{ authen.title}}</div>
                        <el-form-item v-for="(auth,index) in authen.child" :key="index" class="access-item">
                            <template slot="label"><span class="access-all" @click="all(auth.node)" title="点击我选择全部">{{ auth.title + '：' }}</span></template>
                            <el-checkbox-group v-model="form.rules" class="access-checkbox-group">
                                <el-checkbox class="access-checkbox" v-for="(node,i) in auth.node" :label="node.access" :key="i">{{node.name}}</el-checkbox>
                            </el-checkbox-group>
                        </el-form-item>
                    </div>
                </div>
                <el-form-item class="form-button">
                    <el-button type="primary" :loading="button.loading" :disabled="button.disable"
                               @click="update">{{ button.text }}</el-button>
                    <el-button @click="$router.back()" class="back">返 回</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>
<script>
import {mapState} from "vuex";
import {RoleAccess, RoleUpdate} from '../../utils/request.js';

export default {
    computed: {
        ...mapState({
            title: state => state.title,
            authens: state => state.authen,
        }),
    },
    data(){
        return {
            loading: false,
            button: {loading: false, disable: false, text: '提 交'},
            form: {id: 0, rules: []},
        }
    },
    activated(){
        let rid = this.$route.query.id;
        this.form.id = rid;
        this.$store.dispatch('setState', {active: '/role'});
        this.rule(rid);
        this.$nextTick(()=>{
            this.$refs['form'].clearValidate();
        });
    },
    methods: {
        rule(id) {
            this.loading = true;
            RoleAccess({id: id}).then((res) => {
                if (res.status) {
                    this.$func.error(res.message);
                } else {
                    this.form.rules = res.data;
                }
                this.loading = false;
            }).catch((e) => {
                this.loading = false;
            });
        },
        async update() {
            await this.$func.verify('role.access');
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    this.button.disabled = true;
                    this.button.loading = true;
                    this.button.text = '提交中...';
                    RoleUpdate(this.form).then((res) => {
                        if (res.status) {
                            this.$func.error(res.message);
                        } else {
                            this.$func.success(res.message).then(() => {
                                this.$router.back();
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
        all(node){
            node.filter((n)=>{
                if(this.form.rules.includes(n.access)){
                    this.form.rules = this.form.rules.filter((val)=>{
                        return val !== n.access;
                    });
                }else{
                    this.form.rules.push(n.access);
                }
            });
        },
    }
}
</script>
<style scoped>
    .board-form .access-title{
        font-size: 15px;font-weight: 700;line-height: 35px;
    }
    .board-form .access-item {
        margin-bottom: 0;
    }
    .board-form .access-all{
        cursor: pointer;
    }
    .board-form .access-checkbox{
        margin-right: 15px;
    }
    .board-form-item{
        margin-left: 50px;padding-top: 0;
    }
</style>
