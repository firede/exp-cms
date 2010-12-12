<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 后台分类部分权限配置
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
		'title'		    => array(
			'label'     => '分类名称',
			'width'     => '340',
			'template'  => 'link',
			'prefix'    => array('admin/post/list?category='),
			'data'      => 'id,name',
			'order_by'  => 'name',
		),
		'time'          => array(
			'label'     => '短名称',
			'width'     => '130',
			'template'  => 'text',
			'data'      => 'short_name',
			'order_by'  => 'short_name',
		),
		'author'        => array(
			'label'     => '父级分类',
			'width'     => '130',
			'template'  => 'link',
			'prefix'    => array('admin/category/list?category='),
			'data'      => 'parent_id,parent_name',
			'order_by'  => 'parent_name',
		),
		'category'      => array(
			'label'     => '级别',
			'width'     => '80',
			'template'  => 'text',
			'data'      => 'sort',
			'order_by'  => 'sort',
		),
	),
	// 操作（行级操作允许的功能）
	'operation'=> array(
		'cate-modify'    => array(
			'title'     => '修改',
			'action'    => 'admin/category/modify',
		),
		'cate-del'       => array(
			'title'     => '删除',
			'action'    => 'admin/category/del',
		),
	),
	// 批量操作（批量操作允许的功能）
	'muti_operation' => array(
		'select'    => array('title' => '全选'),
		'inverse'   => array('title' => '反选'),
		'cate-del'       => array(
			'title'     => '删除',
			'action'    => 'admin/category/m_del',
		),
	),
);

?>
