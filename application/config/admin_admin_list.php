<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 后台用户列表配置
 */
return array(
	// 主键，用于行级操作的数据来源
	'primary' => 'id',
	// 显示字段（列表表格所显示的列）
	'column' => array(
		'id' => array(
			'label'     => 'ID',
			'width'     => '30',
			'template'  => 'text',
			'data'      => 'id',
		),
		'username'		    => array(
			'label'     => '管理员用户名',
			'width'     => '450',
			'template'  => 'link',
			'prefix'    => array('admin/admin/modify/'),
			'data'      => 'id,username',
			'order_by'  => 'username',
		),
		'role' => array(
			'label'     => '管理员级别',
			'width'     => '200',
			'template'  => 'link',
			'prefix'    => array('admin/admin/list?role='),
			'data'      => 'role,role_name',
			'order_by'  => 'role',
		),
	),
	// 操作（行级操作允许的功能）
	'operation'=> array(
		'user-modify'    => array(
			'title'     => '修改',
			'action'    => 'admin/admin/edit',
		),
		'user-del'       => array(
			'title'     => '删除',
			'action'    => 'admin/admin/del',
		),
	),
);

?>
