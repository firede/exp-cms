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
				'readonly'=> '',
			),
			'modify' => array(
				'display' => 'id,username,password,re_password,role',
				'readonly'=> 'username',
			),
		),
	),
);
?>
