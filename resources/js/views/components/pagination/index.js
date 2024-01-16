import Pagination from './pagination.vue';

const pagination = {
    install:function (Vue) {
        Vue.component('pagination', Pagination)
    }
};

// 导出组件
export default pagination

