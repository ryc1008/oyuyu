<!--<template>-->
<!--    <div class="board-content">-->
<!--        <div class="board-body">-->
<!--            <div class="board-header">-->
<!--                <div class="board-title">-->
<!--                    {{ title }}-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="board-main">-->
<!--                <div class="board-handle">-->
<!--                    <div class="board-button">-->
<!--                        <el-button type="warning" icon="fa fa-refresh" @click="list()" size="small"> 刷新</el-button>-->
<!--                    </div>-->
<!--                    <div class="board-search">-->
<!--                        <div class="search-item">-->
<!--                            <el-input v-model="params.kwd" placeholder="请输入用户ID" size="medium" clearable-->
<!--                                      @input="search()">-->
<!--                                <el-button slot="append" type="success" @click="search()"-->
<!--                                           icon="el-icon-search"></el-button>-->
<!--                            </el-input>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <el-table element-loading-text="努力加载中..."-->
<!--                          element-loading-spinner="el-icon-loading"-->
<!--                          ref="multipleHandle"-->
<!--                          tooltip-effect="dark"-->
<!--                          v-loading="loading"-->
<!--                          :data="listData.data" border>-->
<!--                    <el-table-column prop="id" label="编号" width="65" align="center"></el-table-column>-->
<!--                    <el-table-column prop="user.avatar" label="头像" width="70" align="center">-->
<!--                        <template slot-scope="scope">-->
<!--                            <el-image class="board-table-image" :src="scope.row.user.avatar" :preview-src-list="[scope.row.user.avatar]"></el-image>-->
<!--                        </template>-->
<!--                    </el-table-column>-->
<!--                    <el-table-column prop="user.nickname" label="用户" width="120"></el-table-column>-->
<!--                    <el-table-column prop="money" label="金额" width="80"></el-table-column>-->
<!--                    <el-table-column prop="name" label="说明" width="100"></el-table-column>-->
<!--                    <el-table-column prop="good.title" label="商品名称" width="250" show-overflow-tooltip></el-table-column>-->
<!--                    <el-table-column prop="status_text" label="状态" width="70" align="center">-->
<!--                        <template slot-scope="scope">-->
<!--                            <div v-html="scope.row.status_text"></div>-->
<!--                        </template>-->
<!--                    </el-table-column>-->
<!--                    <el-table-column prop="created_at" label="时间" >-->
<!--                        <template slot-scope="scope">-->
<!--                            {{ $moment(scope.row.created_at).format('YYYY-MM-DD HH:mm:ss') }}-->
<!--                        </template>-->
<!--                    </el-table-column>-->
<!--                </el-table>-->
<!--                <div class="board-pagination">-->
<!--                    <div class="board-count">总共 <em> {{ listData ? listData.total : 0 }} </em> 条记录</div>-->
<!--                    <el-pagination v-if="listData.last_page > 1"-->
<!--                                   :total="listData.total"-->
<!--                                   :page-size="listData.per_page"-->
<!--                                   layout="prev, pager, next, jumper"-->
<!--                                   prev-text="上一页"-->
<!--                                   next-text="下一页"-->
<!--                                   background-->
<!--                                   :current-page="listData.current_page"-->
<!--                                   @current-change="page">-->
<!--                    </el-pagination>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</template>-->

<!--<script>-->
<!--import {mapState} from "vuex";-->
<!--import {UserCostList} from '../../utils/request';-->

<!--export default {-->
<!--    computed: {-->
<!--        ...mapState({-->
<!--            title: state => state.title,-->
<!--        }),-->
<!--    },-->
<!--    data: function () {-->
<!--        return {-->
<!--            loading: false,-->
<!--            listData: [],-->
<!--            roles: [],-->
<!--            params: {page: 1, kwd: ''},-->
<!--        }-->
<!--    },-->
<!--    activated() {-->
<!--        this.list();-->
<!--    },-->
<!--    methods: {-->
<!--        list() {-->
<!--            this.loading = true;-->
<!--            UserCostList(this.params).then((res) => {-->
<!--                if (res.status) {-->
<!--                    this.$func.error(res.message);-->
<!--                } else {-->
<!--                    this.listData = res.data;-->
<!--                }-->
<!--                this.loading = false;-->
<!--            }).catch((e) => {-->
<!--                this.loading = false;-->
<!--            });-->
<!--        },-->
<!--        search() {-->
<!--            this.params.page = 1;-->
<!--            this.list();-->
<!--        },-->
<!--        page(val) {-->
<!--            this.params.page = val;-->
<!--            this.list();-->
<!--        },-->
<!--    }-->
<!--}-->
<!--</script>-->
<!--<style scoped>-->
<!--    .board-table-image{-->
<!--        height: 35px;width: 35px;border-radius: 50%;-->
<!--    }-->
<!--</style>-->
