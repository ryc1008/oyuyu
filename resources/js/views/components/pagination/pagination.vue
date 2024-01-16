<template>
    <div class="board-pagination" v-if="datas">
        <div class="board-record">总共 <em> {{ datas ? datas.total : 0 }} </em> 条记录</div>
        <el-pagination :total="datas.total"
                       :page-size="datas.per_page"
                       layout="prev, pager, next, jumper"
                       prev-text="上一页"
                       next-text="下一页"
                       background
                       :current-page="datas.current_page"
                       @current-change="page">
        </el-pagination>
    </div>
</template>
<script>
export default {
    name: "pagination",
    props: {
        datas: {
            type: Object,
            value: null
        },
    },
    created() {

    },
    methods:{
        page(p){
            this.$emit('page',p);
        }
    }
}
</script>
