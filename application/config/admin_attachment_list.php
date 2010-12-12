<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 后台附件权限配置
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
		'url'		    => array(
			'label'     => '地址',
			'width'     => '300',
			'template'  => 'link',
			'prefix'    => array('admin/attachment/view?id='),
			'data'      => 'id,url',
			'order_by'  => 'url',
		),
		'file_size'     => array(
			'label'     => '文件大小',
			'width'     => '100',
			'template'  => 'text',
			'data'      => 'file_size',
			'order_by'  => 'file_size',
		),
		'use_type'      => array(
			'label'     => '使用类型',
			'width'     => '100',
			'template'  => 'text',
			'data'      => 'use_type',
			'order_by'  => 'use_type',
		),
		'status'      => array(
			'label'     => '状态',
			'width'     => '80',
			'template'  => 'text',
			'data'      => 'status',
			'order_by'  => 'status',
		),
		'file_type'      => array(
			'label'     => '文件类型',
			'width'     => '80',
			'template'  => 'text',
			'data'      => 'file_type',
			'order_by'  => 'file_type',
		),
	),
	// 操作（行级操作允许的功能）
	'operation'=> array(
		'modify'    => array(
			'title'     => '修改',
			'action'    => 'admin/attachment/modify',
		),
		'del'       => array(
			'title'     => '删除',
			'action'    => 'admin/attachment/del',
		),
	),
	// 批量操作（批量操作允许的功能）
	'muti_operation' => array(
		'select'    => array('title' => '全选'),
		'inverse'   => array('title' => '反选'),
		'cate-del'       => array(
			'title'     => '删除',
			'action'    => 'admin/attachment/m_del',
		),
	),
);

?>
