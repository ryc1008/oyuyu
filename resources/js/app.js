import '@/bootstrap';
import Vue from 'vue';
import App from '@/App.vue';
import router from '@/router';
import Store from '@/store';
import NProgress from 'nprogress';
import Bus from '@/utils/bus';
import Func from "@/utils/function";
import VueCookie from 'vue-cookie';
import ElementUI from 'element-ui';
import Moment from 'moment';
import 'element-ui/lib/theme-chalk/index.css';
import 'font-awesome/css/font-awesome.css';
import '@/static/theme/index.css';
import '@/static/css/manage.css';
import 'nprogress/nprogress.css';
import Pagination from '@/views/components/pagination';
import Editor from '@/views/components/editor';
import mavonEditor from 'mavon-editor';
import 'mavon-editor/dist/css/index.css';


Vue.use(mavonEditor)
Vue.use(ElementUI);
Vue.use(VueCookie);
Vue.use(Pagination);
Vue.use(Editor);

Vue.prototype.$store = Store;
Vue.prototype.$moment = Moment;
Vue.prototype.$bus = Bus;
Vue.prototype.$func = Func;

router.beforeEach((to, from, next) => {
    NProgress.start();//开启进度条
    if (to.meta.title){
        document.title = to.meta.title + '-管理系统';//动态化每个页面的标题
    }
    //组装面包屑
    const breadcrumbBox = [];
    to.matched.forEach((item) =>{
        item.meta.title && breadcrumbBox.push({title: item.meta.title});
    })
    Store.dispatch('setState', {active: to.path, title: to.meta.title, breadcrumb: breadcrumbBox});
    const whiteList = ['login'];
    const token = VueCookie.get('token');
    if (token) {
        //访问登录界面则跳转到后台主页
        if (whiteList.includes(to.name)) {
            next({name: 'main'});
        } else {
            //动态路由挂载
            if (Store.state.routers.length) {
                next();
            } else {
                Store.dispatch('generateRoutes').then(() => {
                    // 动态添加可访问路由表
                    Store.state.routers.forEach((r)=>{
                        router.addRoute(r);
                    });
                    //hack方法 确保addRoute已完成
                    next({...to});
                });
            }
        }
    } else {
        if (whiteList.includes(to.name)) {
            next();
        } else {
            // token不存在，全部重定向到登录页
            next({name: 'login'});
        }
    }
});

//取消右上角的进度环
NProgress.configure({ showSpinner: false });

//关闭进度条
router.afterEach((transition) => {
    NProgress.done();
});

new Vue({
    router,
    Store,
    render: h => h(App)
}).$mount('#app');
