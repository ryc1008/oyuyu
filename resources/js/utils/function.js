import {Notification} from 'element-ui';
import Store from '../store';
import Moment from 'moment';

const Func = {
    error(msg) {
        Notification.error({
            title: '错误',
            duration: '1500',
            message: msg
        });
    },

    success(msg) {
        return new Promise(resolve => {
            Notification({
                title: '成功',
                message: msg,
                type: 'success',
                duration: '1500',
                onClose: () => {
                    resolve();
                }
            });
        });
    },

    verify(code) {
        return new Promise((resolve) => {
            if(Store.state.user.rid == 1 || Store.state.rules.includes(code.toString())){
                // this.error('抱歉，您没有操作权限');
                resolve();
            }else{
                this.error('抱歉，您没有操作权限');
            }
        });
    },

    formatTag(status){
        let type = '';
        switch (status){
            case 1:
                type = 'primary';
                break;
            case 2:
                type = 'danger';
                break;
            case 3:
                type = 'success';
                break;
            case 4:
                type = 'warning';
                break;
            default:
                type = 'info';
                break;
        }
        return type;
    },

    formatNumber(number) {
        let result = 0
        if (number >= 10000) {
            result = (number / 10000) + '万'
        } else {
            result = number
        }
        return result
    },

    formatDateTime(time, format){
        format = format ? format : 'YYYY-MM-DD HH:mm:ss';
        return Moment(time).format(format);
    }


};
export default Func;
