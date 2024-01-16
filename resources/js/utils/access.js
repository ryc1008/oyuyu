const authens = [
    {title: '系统管理', child: [
        {
            title: '系统设置', node: [
                {name: '配置', access: 'config.list'},
                {name: '更新', access: 'config.update'},
            ]
        },
        {
            title: '用户管理', node: [
                {name: '列表', access: 'user.list'},
                {name: '空投', access: 'user.airdrop'},
                {name: '话费', access: 'user.ticket'},
                {name: '编辑', access: 'user.edit'},
                {name: '鱼雷', access: 'user.torpedo'},
                {name: '充值', access: 'user.recharge'},
            ]
        },
    ]},
    {title: '权限管理', child: [
        {
            title: '管理人员', node: [
                {name: '列表', access: 'manager.list'},
                {name: '新增', access: 'manager.create'},
                {name: '编辑', access: 'manager.edit'},
                {name: '启用', access: 'manager.active'},
                {name: '锁定', access: 'manager.lock'},
                {name: '删除', access: 'manager.destroy'},
            ]
        },
        {
            title: '角色管理', node: [
                {name: '列表', access: 'role.list'},
                {name: '新增', access: 'role.create'},
                {name: '编辑', access: 'role.edit'},
                {name: '授权', access: 'role.access'},
                {name: '删除', access: 'role.destroy'},
            ]
        },
        {
            title: '登录日志', node: [
                {name: '列表', access: 'login.list'},
                {name: '查询', access: 'login.check'},
                {name: '删除', access: 'login.destroy'},
            ]
        },
    ]},
];
export default authens;
