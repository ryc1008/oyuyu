import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

//解决router版本过高 重复点击路由控制台报错问题
const originalPush = VueRouter.prototype.push;
VueRouter.prototype.push = function (location) {
    return originalPush.call(this, location).catch(err => err);
};

const Login = () => import('@/views/login/index.vue');
const Layout = () => import('@/views/layout/layout.vue');
const Main = () => import('@/views/main/index.vue');
const Error = () => import('@/views/page/404.vue');
const Manager = () => import('@/views/auth/manager.vue');
const Role = () => import('@/views/auth/role.vue');
const Log = () => import('@/views/auth/log.vue');
const Access = () => import('@/views/auth/access.vue');
const Config = () => import('@/views/system/config.vue');
const User = () => import('@/views/user/index.vue');


export const constantRouterMap = [
    {path: '/', name: 'login', component: Login, meta: {title: '登录注册', login: true}},
    {path: '/main', component: Layout, children: [
        {path: '/main', name: 'main', component: Main, meta: {title: '系统首页', show: true, 'icon': 'fa fa-home'}},
        {path: '/error', name: 'error', component: Error, meta: {title: '错误异常', show: false}},
    ]}
];

export const asyncRouterMap = [
    {path: '/config', component: Layout, meta: {title: '系统管理', icon: 'fa fa-cog'}, children: [
        {path: '/config', name: 'config', component: Config, meta: {title: '系统设置', show: true, auth: 'config.list'}},
        {path: '/user', name: 'user', component: User, meta: {title: '用户管理', show: true, auth: 'user.list'}},
    ]},
    {path: '/manager', component: Layout, meta: {title: '权限管理', icon: 'fa fa-gavel'}, children: [
        {path: '/manager', name: 'manager', component: Manager, meta: {title: '管理人员', show: true, auth: 'manager.list'}},
        {path: '/role', name: 'role', component: Role, meta: {title: '角色管理', show: true, auth: 'role.list'}},
        {path: '/access', name: 'access', component: Access, meta: {title: '角色权限', show: false, auth: 'role.access'}},
        {path: '/log', name: 'log', component: Log, meta: {title: '登录日志', show: true, auth: 'login.list'}}
    ]},
    {path: '*', redirect: '/error'}
];

const router = new VueRouter({
    mode: 'history', base: '/manage', routes: constantRouterMap
});

export default router;
