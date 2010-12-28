<?php

/**
 * 表单配置
 */
return array(
    'set_db' => array(
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
            'desc' => '数据库所在主机的ip地址或域名，本机为127.0.0.1或localhost',
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
         'add_test_data' => array(
            'label' => '添加测试数据',
            'type' => 'select',
            'name' => 'add_test_data',
            'desc' => '默认为添加',
            'value' => array(
                "select" => 0,
                "data" => array(
                    0=>'添加',
                    1=>'不添加',
                ),
                ),
            'message' => '',
            'min_len' => 0,
            'max_len' => 10,
        ),
    ),
    'set_cache' => array(
        'driver' => array(
            'label' => '数据库类型',
            'type' => 'select',
            'name' => 'driver',
            'desc' => '',
            'value' => array(
                "select" => "0",
                "data" => array(
                ),
            ),
            'message' => '',
        ),
        'is_open' => array(
            'label' => '启用缓存状态',
            'type' => 'select',
            'name' => 'is_open',
            'desc' => '默认为启用',
            'value' => array(
                "select" => 1,
                "data" => array(
                    1=>'启用',
                    0=>'禁用',
                ),
                ),
            'message' => '',
            'min_len' => 0,
            'max_len' => 10,
        ),
    ),
);
?>
