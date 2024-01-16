<template>
    <div class="board-content">
        <div class="board-body">
            <div class="board-main">
                <img class="error-img" src="../../../img/404.png" alt="">
                <div class="error-message">抱歉，您访问的页面不在地球上了。</div>
                <el-button @click="$router.back()" class="back"><i class="fa fa-reply"></i> 返回</el-button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                path: ''
            }
        },
        beforeRouteEnter(to, from, next) {
            next((vm) => {
                vm.path = from.path;
            });
        },
        activated(){
            this.$store.dispatch('setState', {active: this.path});
        },
        methods: {

        }
    }
</script>

<style scoped>
    .board-main{
        text-align: center;
    }
    .error-img{
        height: 300px;margin-top: 35px;
    }
    .error-message{
        margin-bottom: 25px;
    }
</style>
