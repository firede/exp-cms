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
			'label'     => '管理员用户名',
			'width'     => '450',
			'template'  => 'link',
			'prefix'    => array('admin/user/edit?id='),
			'data'      => 'id,username',
			'order_by'  => 'username',
		),
		'role' => array(
			'label'     => '管理员级别',
			'width'     => '180',
			'template'  => 'link',
			'data'      => 'role,role_name',
			'order_by'  => 'role_name',
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
