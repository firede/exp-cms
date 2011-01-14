<?php

/**
 * 表单配置
 */
return array(
    'default' => array(
        'id' => array(
            'type' => 'hidden',
            'name' => 'id',
        ),
        'username' => array(
            'label' => '管理员用户名',
            'type' => 'text',
            'name' => 'username',
            'desc' => '将使用此名称登录后台',
            'value' => '',
            'message' => '',
            'min_len' => 3,
            'max_len' => 16,
            'validate' => array(
                'not_empty' => array('error_msg' => '用户名不能为空'),
                //'is_numeric',
                //'is_integer',
                //'is_decimal',
                //'range'=>array('min'=>4,'max'=>100,'error_msg'=>'大小必须在4到100之间'),
                'str_len' => array('min' => 3, 'max' => 20,),
                //'email',
                //'datatime',
                //'filed_exp'=>array("filed1"=>"username","opertor"=>"==","filed2"=>"password"),
                //'reg'=>array(),
                //'url',
                //'dir',
                'call_function' => array('function' => 'Database_admin.check_exist', 'params' => 'username', 'error_msg' => '用户名已存在'),
            )
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
            'validate' => array(
                'not_empty',
                'str_len' => array('min' => 3, 'max' => 20,),
            )
        ),
        're_password' => array(
            'label' => '重复密码',
            'type' => 'password',
            'name' => 're_password',
            'desc' => '请重复输入密码',
            'value' => '',
            'message' => '',
            'validate' => array(
                'not_empty',
                'str_len' => array('min' => 3, 'max' => 20,),
                'filed_exp'=>array("filed1"=>"password","opertor"=>"==","filed2"=>"re_password","error_msg"=>"重复密码与密码不匹配"),
            )
        ),
        'role' => array(
            'label' => '类型',
            'type' => 'select',
            'name' => 'role',
            'desc' => '选择管理员拥有的权限',
            'value' => array(
                "select" => "0",
                "data" => array(
                    '0' => '编辑',
                    '1' => '超级管理员',
                ),
            ),
            'message' => '',
        ),
    ),
    'function_config' => array(
        'default' => array(
            'create' => array(
                'display' => 'username,password,re_password,role',
                'readonly' => '',
            ),
            'modify' => array(
                'display' => 'id,username,password,re_password,role',
                'readonly' => 'username',
            ),
        ),
    ),
);
?>
