import Editor from './editor.vue';

const editor = {
    install:function (Vue) {
        Vue.component('editor', Editor)
    }
};

// 导出组件
export default editor

