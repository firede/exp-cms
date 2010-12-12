<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 后台用户列表配置
 */
return array(
	// 主键，用于行级操作的数据来源
	'primary' => 'id',
	// 显示字段（列表表格所显示的列）
	'column' => array(
		'select'	    => array(
			'label'     => '选择',
			'width'     => '30',
			'template'  => 'checkbox',
			'data'      => 'id',
		),
		'username'		    => array(
			'label'     => '用户名',
			'width'     => '180',
			'template'  => 'link',
			'prefix'    => array('admin/user/edit?id='),
			'data'      => 'id,username',
			'order_by'  => 'username',
		),
		'email'          => array(
			'label'     => '电子邮件',
			'width'     => '130',
			'template'  => 'text',
			'data'      => 'email',
			'order_by'  => 'email',
		),
		'type'        => array(
			'label'     => '用户类型',
			'width'     => '80',
			'template'  => 'text',
			'data'      => 'user_type',
			'order_by'  => 'user_type',
		),
		'status'      => array(
			'label'     => '用户状态',
			'width'     => '80',
			'template'  => 'text',
			'data'      => 'status',
			'order_by'  => 'status',
		),
		'reg_time'      => array(
			'label'     => '注册时间',
			'width'     => '80',
			'template'  => 'date',
			'data'      => 'reg_time',
			'order_by'  => 'reg_time',
		),
		'last_time'      => array(
			'label'     => '最后登录',
			'width'     => '80',
			'template'  => 'date',
			'data'      => 'last_time',
			'order_by'  => 'last_time',
		),
	),
	// 操作（行级操作允许的功能）
	'operation'=> array(
		'user-modify'    => array(
			'title'     => '修改',
			'action'    => 'admin/user/modify',
		),
		'user-del'       => array(
			'title'     => '删除',
			'action'    => 'admin/user/del',
		),
	),
	// 批量操作（批量操作允许的功能）
	'muti_operation' => array(
		'select'    => array('title' => '全选'),
		'inverse'   => array('title' => '反选'),
		'user-del'       => array(
			'title'     => '删除',
			'action'    => 'admin/user/m_del',
		),
	),
);

?>
