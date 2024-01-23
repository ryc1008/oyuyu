<template>
    <div class="page">
        <div class="container">
            <div class="circle-container" v-for="index of 100" :key="index">
                <div class="circle"></div>
            </div>
        </div>
        <div class="login">
            <div class="login-bg"></div>
            <div class="form">
                <div class="title"><span>登 录</span> | <span class="py">Login</span></div>
                <el-form ref="form" :rules="rules" :model="form" status-icon>
                    <el-form-item prop="username">
                        <el-input v-model="form.username" placeholder="请填写管理员账号" autocomplete="off"
                                  prefix-icon="fa fa-user"></el-input>
                    </el-form-item>
                    <el-form-item prop="password">
                        <el-input v-model="form.password" placeholder="请填写管理员密码" autocomplete="new-password"
                                  prefix-icon="fa fa-lock"
                                  type="password"></el-input>
                    </el-form-item>
                    <el-form-item prop="captcha">
                        <el-input v-model.number="form.captcha" placeholder="请填写验证码" prefix-icon="fa fa-image"
                                  class="code"></el-input>
                        <img @click="captcha" class="captcha" :src="captchaImg" alt="">
                    </el-form-item>
                    <div class="refresh"><i class="fa fa-question-circle-o"></i> 看不清，点击验证码换一张</div>
                    <el-form-item>
                        <el-button type="primary" class="submit" :loading="button.loading" :disabled="button.disabled"
                                   @click="submit">{{ button.text }}
                        </el-button>
                    </el-form-item>
                </el-form>
            </div>
        </div>
        <div class="copyright">
            Copyright © Powered By Admin System {{ year }}
        </div>
    </div>
</template>

<script>
import '@/static/css/grain.css';
import {LoginCaptcha, LoginSubmit} from '../../utils/request';

export default {
    data() {
        return {
            captchaImg: '',
            button: {loading: false, disable: false, text: '登 录'},
            year: new Date().getFullYear(),
            form: {
                username: '',
                password: '',
                captcha: '',
                captchaKey: ''
            },
            rules: {
                username: [{required: true, message: '请填写管理员账号', trigger: 'blur'}],
                password: [{required: true, message: '请填写管理员密码', trigger: 'blur'}],
                captcha: [{required: true, message: '请填写验证码', trigger: 'blur'}],
            }
        }
    },
    created() {
        this.captcha();
        this.form = {username: '', password: '', captcha: '', captchaKey: ''};
        this.keyupSubmit();
    },
    methods: {
        captcha() {
            LoginCaptcha().then((res) => {
                if (res.status === 0) {
                    this.captchaImg = res.data.img;
                    this.form.captchaKey = res.data.key;
                }
            })
        },
        keyupSubmit() {
            document.onkeydown = (e) => {
                if (e.keyCode === 13) {
                    this.submit();
                }
            }
        },
        submit() {
            this.$refs['form'].validate((valid) => {
                if (valid) {
                    this.button.disabled = true;
                    this.button.loading = true;
                    this.button.text = '登录中...';
                    LoginSubmit(this.form).then((res) => {
                        this.button.disabled = false;
                        this.button.loading = false;
                        this.button.text = '登 录';
                        if (res.status) {
                            this.captcha();
                            this.form.captcha = '';
                            this.$func.error(res.message);
                        } else {
                            this.$store.dispatch('userLogin', res.data).then(() => {
                                this.$func.success(res.message).then(() => {
                                    this.$router.push({name: 'main'});
                                });
                            });
                        }
                    }).catch((e) => {
                        this.button.disabled = false;
                        this.button.loading = false;
                        this.button.text = '登 录';
                    });
                }
            });
        },
    }
}
</script>

<style scoped>

.page {
    width: calc(100vw);
    height: calc(100vh);
    background-image: url("/image/admin/login.jpeg");
    background-repeat: no-repeat;
    background-size: 100% 100%;
    background-clip: content-box;
}

.login {
    /*width: 1200px;*/
    margin: auto;
    /*height: 560px;*/
    position: absolute;
    left: calc(40vw);
    top: 100px;
}

.login .form {
    width: 400px;
    height: 480px;
    /*background-color: #F2FBFF;*/
    padding: 40px 40px;
    border-radius: 3px;
}

.login .form .title {
    line-height: 35px;
    text-align: left;
    margin-bottom: 35px;
    font-size: 28px;
    color: #C744EC;
}

.login .form .title span {
    position: relative;
    top: 3px;
    font-size: 34px;
}

.login .form .title span.py {
    font-size: 20px;
    top: 5px;
    color: #C744EC
}


.login .form .code {
    width: 200px;
}

.login .form .captcha {
    height: 40px;
    float: right;
    cursor: pointer;
    border-radius: 4px;
}

.login .form .refresh {
    margin-bottom: 15px;
    text-align: right;
    color: #FFF;
    font-size: 12px;
}


.login .form .submit {
    width: 100%;
    font-size: 14px;
    background: linear-gradient(to right, #C53EEE, #45CFEC);
    border: none;
}

.login .form .copyright {
    margin-top: 15px;
    font-size: 12px;
    text-align: center;
    color: #FFF;
}

.pass-input {
    text-security: disc !important;
}

.login-qiu {
    position: absolute;
    left: calc(10vw);
    top: -50px
}

.login-qiu img {
    width: 600px;
    height: auto;
}
.copyright{
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    text-align: center;
    line-height: 45px;
    font-size: 12px;
    color: #fff;
}
</style>
