<?php

/**
 * 表单配置
 */
return array(
    'username' => array(
        'label' => '管理员用户名',
        'type' => 'text',
        'name' => 'username',
        'desc' => '将使用此名称登录后台',
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
);
?>
