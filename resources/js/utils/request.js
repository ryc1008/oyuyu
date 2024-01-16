import Vue from 'vue'
import axios from 'axios';
import VueAxios from 'vue-axios';
import Qs from 'qs';
import VueCookie from "vue-cookie";
import {Notification} from 'element-ui';
import router from '../router';
import store from '../store';

Vue.use(VueAxios, axios);

axios.interceptors.request.use(function (config) {
    config.headers['Accept'] = 'application/json';
    const token = JSON.parse(VueCookie.get('token'));
    if(token){
        config.headers['Authorization'] = 'Bearer ' + token;
    }
    return config;
}, function (error) {
    return Promise.reject(error);
});


axios.interceptors.response.use(function (response) {
    return response.data;
}, function (error) {
    switch(error.response.status){
        case 401:
            store.dispatch('userLogout').then(() => {
                Notification.error({
                    title: '错误',
                    duration: '1500',
                    message: '登录信息已过期，正在退出...',
                    onClose: () => {
                        return router.push({name: 'login'});
                    }
                });
            });
            break;
        default:
            Notification.error({
                title: '错误',
                duration: '1500',
                message: error.response.data.message + '，网络状态：' + error.response.status,
            });
            break;
    }
});


let interfaceApi = '/api';
let interfaceAdmin = '/admin';


export const LoginCaptcha = params => { return axios.get(`${interfaceApi}/captcha`, {params:params}).then(res => res)};
export const UploadImage = params => { return axios.post(`${interfaceApi}/upload/image`, params).then(res => res)};//上传图片
export const LoginSubmit = params => { return axios.post(`${interfaceAdmin}/login`, Qs.stringify(params)).then(res => res)};

//主页统计
export const Main = params => { return axios.get(`${base}/main`, params).then(res => res)};
export const MainMonthAssay = params => { return axios.get(`${interfaceAdmin}/main/month`, {params:params}).then(res => res)};
export const MainUserAssay = params => { return axios.get(`${interfaceAdmin}/main/user`, {params:params}).then(res => res)};
export const MainCountAssay = params => { return axios.get(`${interfaceAdmin}/main/count`, {params:params}).then(res => res)};
//系统设置
export const ConfigList = params => { return axios.get(`${interfaceAdmin}/config`, {params:params}).then(res => res)};
export const ConfigUpdate = params => { return axios.post(`${interfaceAdmin}/config/update`, Qs.stringify(params)).then(res => res)};
//管理人员
export const ManagerList = params => { return axios.get(`${interfaceAdmin}/manager`, {params:params}).then(res => res)};
export const ManagerConfig = params => { return axios.get(`${interfaceAdmin}/manager/config`, {params:params}).then(res => res)};
export const ManagerUser = params => { return axios.get(`${interfaceAdmin}/manager/user`, {params:params}).then(res => res)};
export const ManagerUpdate = params => { return axios.post(`${interfaceAdmin}/manager/update`, Qs.stringify(params)).then(res => res)};
export const ManagerLock = params => { return axios.post(`${interfaceAdmin}/manager/lock`, Qs.stringify(params)).then(res => res)};
export const ManagerActive = params => { return axios.post(`${interfaceAdmin}/manager/active`, Qs.stringify(params)).then(res => res)};
export const ManagerDestroy = params => { return axios.post(`${interfaceAdmin}/manager/destroy`, Qs.stringify(params)).then(res => res)};
//角色管理
export const RoleList = params => { return axios.get(`${interfaceAdmin}/role`, {params:params}).then(res => res)};
export const RoleTree = params => { return axios.get(`${interfaceAdmin}/role/tree`, {params:params}).then(res => res)};
export const RoleAccess = params => { return axios.get(`${interfaceAdmin}/role/access`, {params:params}).then(res => res)};
export const RoleUpdate = params => { return axios.post(`${interfaceAdmin}/role/update`, Qs.stringify(params)).then(res => res)};
export const RoleDestroy = params => { return axios.post(`${interfaceAdmin}/role/destroy`, Qs.stringify(params)).then(res => res)};
//登录日志
export const LogList = params => { return axios.get(`${interfaceAdmin}/log`, {params:params}).then(res => res)};
export const LogConfig = params => { return axios.get(`${interfaceAdmin}/log/config`, {params:params}).then(res => res)};
export const LogCheck = params => { return axios.post(`${interfaceAdmin}/log/check`, Qs.stringify(params)).then(res => res)};
export const LogDestroy = params => { return axios.post(`${interfaceAdmin}/log/destroy`, Qs.stringify(params)).then(res => res)};

//用户管理
export const UserList = params => { return axios.get(`${interfaceAdmin}/user`, {params:params}).then(res => res)};
export const UserConfig = params => { return axios.get(`${interfaceAdmin}/user/config`, {params:params}).then(res => res)};
export const UserTorpedo = params => { return axios.get(`${interfaceAdmin}/user/torpedo`, {params:params}).then(res => res)};
export const UserTicket = params => { return axios.get(`${interfaceAdmin}/user/ticket`, {params:params}).then(res => res)};
export const UserRecharge = params => { return axios.post(`${interfaceAdmin}/user/recharge`, Qs.stringify(params)).then(res => res)};
export const UserUpdate = params => { return axios.post(`${interfaceAdmin}/user/update`, Qs.stringify(params)).then(res => res)};
export const UserAirdrop = params => { return axios.post(`${interfaceAdmin}/user/airdrop`, Qs.stringify(params)).then(res => res)};




















































