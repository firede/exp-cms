<?php

/**
 * 表单配置
 */
return array(
    'db_type' => array(
        'label' => '数据库类型',
        'type' => 'select',
        'name' => 'db_type',
        'desc' => '',
        'value' => array(
            "select" => "0",
            "data" => array(
            ),
        ),
        'message' => '',
    ),
    'host_name' => array(
        'label' => '主机地址',
        'type' => 'text',
        'name' => 'host_name',
        'desc' => '请填写你数据库所在主机的ip地址或域名',
        'value' => '127.0.0.1',
        'message' => '',
        'min_len' => 6,
        'max_len' => 22,
    ),
    'db_name' => array(
        'label' => '数据库名',
        'type' => 'text',
        'name' => 'db_name',
        'desc' => '如果已有同名数据库则不重新创建直接使用',
        'value' => 'daxiniu',
        'message' => '',
        'min_len' => 3,
        'max_len' => 40,
    ),
    'user' => array(
        'label' => '数据库帐号',
        'type' => 'text',
        'name' => 'user',
        'desc' => '请填数据库帐号',
        'value' => '',
        'message' => '',
        'min_len' => 0,
        'max_len' => 30,
    ),
    'pwd' => array(
        'label' => '数据库密码',
        'type' => 'password',
        'name' => 'pwd',
        'desc' => '请输入数据库密码',
        'value' => '',
        'message' => '',
        'min_len' => 0,
        'max_len' => 30,
    ), 'table_prefix' => array(
        'label' => '数据表前缀',
        'type' => 'text',
        'name' => 'table_prefix',
        'desc' => '表的格式会改变为"前缀＋原表名"',
        'value' => 'dxn_',
        'message' => '',
        'min_len' => 0,
        'max_len' => 10,
    ),
);
?>
