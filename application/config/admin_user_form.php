<?php

/**
 * 表单配置
 */
return array(
    'default' => array(
        'username' => array(
            'label' => '用户名',
            'type' => 'text',
            'name' => 'username',
            'desc' => '',
            'value' => '',
            'message' => '',
            'min_len' => 3,
            'max_len' => 16,
        ),
        'password' => array(
            'label' => '密码',
            'type' => 'password',
            'name' => 'password',
            'desc' => '',
            'value' => '',
            'message' => '',
            'min_len' => 6,
            'max_len' => 22,
        ),
        're_password' => array(
            'label' => '重复密码',
            'type' => 'password',
            'name' => 're_password',
            'desc' => '请重复输入密码',
            'value' => '',
            'message' => '',
        ),
        'email' => array(
            'label' => '电子邮件',
            'type' => 'text',
            'name' => 'email',
            'desc' => '',
            'value' => '',
            'message' => '',
        ),
        'status' => array(
            'label' => '状态',
            'type' => 'select',
            'name' => 'status',
            'desc' => '',
            'value' => array(
                'select' => '0',
                'data' => array(
                    '0' => '正常',
                    '1' => '锁定',
                    '2' => '屏蔽',
                    '3' => '锁定并屏蔽'
                ),
            ),
        ),
        'user_type' => array(
            'label' => '类型',
            'type' => 'select',
            'name' => 'user_type',
            'desc' => '选择管理员拥有的权限',
            'value' => array(
                'select' => '0',
                'data' => array(
                    '0' => '个人用户',
                    '1' => '团体用户',
                ),
            ),
            'message' => '',
        ),
        'avatar' => array(
            'label' => '头像',
            'type' => 'file',
            'name' => 'avatar',
            'desc' => '',
            'value' => '',
            'message' => '',
        ),
        'admin_id' => array(
            'label' => '关联管理员',
            'type' => 'text',
            'name' => 'admin_id',
            'desc' => '如需绑定管理员账户，请输入管理员ID，否则留空',
            'value' => '',
            'message' => '',
        ),
    ), 'function_config' => array(
        'default' => array(
            'create' => array(
                'display' => 'username,password,re_password,email,status,user_type,avatar,admin_id',
                'readonly' => 'avatar',),
            'modify' => array(
                'display' => 'username,password,re_password,email,status,user_type,avatar,admin_id',
                'readonly' => 'avatar',)
        )
    ),
);
?>
