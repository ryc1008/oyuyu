<template>
    <header id="header" class="header">
        <div class="header-logo">
            捕鱼<span>游戏</span>
        </div>
        <div class="header-breadcrumb">
            <el-breadcrumb separator="/">
                <el-breadcrumb-item :to="{ name: 'main' }">系统首页</el-breadcrumb-item>
                <el-breadcrumb-item v-for="(crumb, cindex) in breadcrumb" :key="this">
                    <span :class="breadcrumb.length == (cindex + 1) ? 'header-title current' : 'header-title'">{{crumb.title}}</span>
                </el-breadcrumb-item>
            </el-breadcrumb>
        </div>
<!--        <div><span>钱，能治愈一切自卑</span> <span>忙，能治愈一切矫情</span></div>-->
        <div class="header-user" v-if="user">
            <div style="padding-right: 30px;color: #2461EF">{{ datetime }}</div>
            <div class="avatar"><img :src="'/image/admin/' + user.avatar + '.jpg'" alt=""></div>
            <div class="nickname">{{ user.nickname }}</div>
            <div @click="logout()" class="logout"><i class="fa fa-power-off"></i> 退出</div>
        </div>
    </header>
</template>

<script>
import {mapState} from "vuex";

export default {
    computed: {
        ...mapState({
            breadcrumb: state => state.breadcrumb
        }),
    },
    data: function () {
        return {
            user: null,
            datetime: null,
            timer: null,
        }
    },
    created() {
        this.user = JSON.parse(this.$cookie.get('user'));
        this.clock();
        this.timer = setInterval(this.clock,1000);
    },
    beforeDestroy() {
        clearInterval();
    },
    methods: {
        logout() {
            this.$store.dispatch('userLogout').then(() => {
                this.$func.success('正在退出登录......').then(() => {
                    this.$router.push({name: 'login'});
                });
            });
        },
        clock(){
            let date = new Date().toLocaleString('zh', {year: 'numeric', month: 'numeric', day: 'numeric'});
            let hour = new Date().toLocaleString('zh', {hour: 'numeric', minute: 'numeric', second: 'numeric'});
            let [year, month, day] = date.split('/');
            this.datetime = `${year}年${month.padStart(2, '0')}月${day.padStart(2, '0')}日 ${hour}`;
        }
    }
}
</script>
