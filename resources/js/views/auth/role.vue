<template>
    <div class="board-content">
        <div class="board-header">
            <div class="board-search">
                <div class="search-item">
                    <el-input v-model="params.kwd" placeholder="请输入名称" size="small" clearable></el-input>
                </div>
                <div class="search-item">
                    <el-button type="primary" @click="search()" size="small" icon="el-icon-search">搜索</el-button>
                </div>
            </div>
            <div class="board-handle">
                <el-button type="warning" icon="fa fa-refresh" @click="list()" size="small"> 刷新</el-button>
                <el-button type="primary" icon="fa fa-plus" @click="create()" size="small"> 新增</el-button>
                <el-button type="info" icon="fa fa-trash" @click="del()" size="small"> 删除</el-button>
            </div>
        </div>
        <div class="board-main">
            <el-table v-if="datas" element-loading-text="努力加载中..."
                      element-loading-spinner="el-icon-loading"
                      ref="multipleHandle" stripe
                      tooltip-effect="dark" :height="tableHeight"
                      v-loading="loading"
                      :data="datas.data" border @selection-change="multiple">
                <el-table-column type="selection" width="45" align="center"></el-table-column>
                <el-table-column prop="id" label="编号" width="65" align="center"></el-table-column>
                <el-table-column prop="title" label="名称" width="140"></el-table-column>
                <el-table-column prop="brief" label="描述" width="250"></el-table-column>
                <el-table-column prop="created_at" label="创建时间" width="160">
                    <template slot-scope="scope">
                        {{ $moment(scope.row.created_at).format('YYYY-MM-DD HH:mm:ss') }}
                    </template>
                </el-table-column>
                <el-table-column label="操作" fixed="right" min-width="270">
                    <template slot-scope="scope">
                        <el-button type="primary" icon="fa fa-edit" size="mini" plain @click="edit(scope.row)"> 编辑
                        </el-button>
                        <el-button v-if="scope.row.id > 1" type="warning" icon="fa fa-gavel" size="mini" plain
                                   @click="access(scope.row.id)">
                            授权
                        </el-button>
                        <el-button v-if="scope.row.id > 1" type="info" icon="fa fa-trash" size="mini" plain @click="destroy(scope.row.id)">
                            删除
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
        <pagination :datas="datas" @page="page"></pagination>
        <el-dialog class="board-dialog"  :close-on-click-modal="false"
                   :close-on-press-escape="false"
                   :title="dialog.title"
                   :visible.sync="dialog.show" center>
            <el-form v-if="form" :model="form" :rules="rules" ref="form" class="board-form" label-width="120px">
                <div class="item-title">基本信息<div class="title-note"><span>* </span>为必填项</div></div>
                <div class="form-item">
                    <el-form-item label="名 称：" prop="title">
                        <el-input v-model="form.title" placeholder="请填写角色名称" size="medium" clearable></el-input>
                    </el-form-item>
                    <el-form-item label="描 述：" prop="brief">
                        <el-input v-model="form.brief" placeholder="请填写角色描述" size="medium" clearable></el-input>
                    </el-form-item>
                </div>
            </el-form>
            <span slot="footer" class="dialog-footer">
                    <el-button type="primary" :loading="button.loading" :disabled="button.disable"
                               @click="update">{{ button.text }}</el-button>
                    <el-button class="close-btn" @click="dialog.show = false">关 闭</el-button>
                </span>
        </el-dialog>
    </div>
</template>

<script>
import {mapState} from "vuex";
import {RoleList, RoleUpdate, RoleDestroy} from '../../utils/request.js';

export default {
    computed: {
        ...mapState({
            tableHeight: state => state.tableHeight,
        }),
    },
    data: function () {
        return {
            loading: false,
            datas: null,
            params: {page: 1, kwd: ''},
            button: {loading: false, disable: false, text: '提 交'},
            dialog: {title: '', show: false},
            form: null,
            slection: [],
            rules: {
                title: [{required: true, message: '请填写角色名称', trigger: 'blur'}],
                brief: [{required: true, message: '请填写角色描述', trigger: 'blur'}],
            }
        }
    },
    activated() {
        this.list();
    },
    methods: {
        async list() {
            await this.$func.verify('role.list');
            this.loading = true;
            RoleList(this.params).then((res) => {
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
        async create() {
            await this.$func.verify('role.create');
            this.form = {
                title: '',
                brief: '',
            };
            this.dialog.title = '新增角色';
            this.dialog.show = true;
            this.$nextTick(() => {
                this.$refs['form'].clearValidate();
            });
        },
        async edit(detail) {
            await this.$func.verify('role.edit');
            this.form = {
                id: detail.id,
                title: detail.title,
                brief: detail.brief,
            };
            this.dialog.title = '编辑角色';
            this.dialog.show = true;
            this.$nextTick(() => {
                this.$refs['form'].clearValidate();
            });
        },
        update() {
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
        multiple(e){
            this.slection = [];
            if(e.length){
                e.forEach((item) =>{
                    this.slection.push(item.id)
                })
            }
        },
        del(){
            if(!this.slection.length){
                this.$func.error('请选择你要操作的数据'); return false;
            }
            this.destroy(this.slection);
        },
        async destroy(id) {
            await this.$func.verify('role.destroy');
            this.$confirm('您确定要删除选中的该条信息吗？', '提示', {
                type: 'warning',
                confirmButtonText: '确 定',
                cancelButtonText: '取 消'
            }).then(() => {
                RoleDestroy({id: id}).then((res) => {
                    if (res.status) {
                        this.$func.error(res.message);
                    } else {
                        this.list();
                    }
                });
            }).catch(() => {
            });
        },
        async access(id) {
            await this.$func.verify('role.access');
            this.$router.push({name: 'access', query: {id: id}});
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
