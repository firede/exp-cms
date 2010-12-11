<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 后台Post部分管理权限配置
 *
 * @TODO 删除权限以后作成可在后台启用/关闭的
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
			'label'     => '标题',
			'width'     => '340',
			'template'  => 'link',
			'prefix'    => array('admin/post/view/', '.html'),
			'data'      => 'id,title',
			'order_by'  => 'title',      // 配置此字段则本列启用排序
		),
		'time'          => array(
			'label'     => '更新日期',
			'width'     => '100',
			'template'  => 'date',
			'data'      => 'update_time,pub_time',
			'order_by'  => 'update_time',
		),
		'author'        => array(
			'label'     => '作者',
			'width'     => '100',
			'template'  => 'text',
			'prefix'    => array('作者：'),
			'data'      => 'user_name',
			'order_by'  => 'user_name',
		),
		'category'      => array(
			'label'     => '分类',
			'width'     => '100',
			'template'  => 'text',
			'prefix'    => array('分类：'),
			'data'      => 'cate_name',
			'order_by'  => 'cate_name',
		),
	),
	// 操作（行级操作允许的功能）
	'operation'=> array(
		'audit'     => array(
			'title'     => '快速审核',
			'action'    => 'admin/post/audit',
		),
		'move'      => array(
			'title'     => '移动',
			'action'    => 'admin/post/move',
		),
		'del'       => array(
			'title'     => '删除',
			'action'    => 'admin/post/del',
		),
		'preview'   => array(
			'title'     => '预览',
			'action'    => 'admin/post/preview',
			'size_x'	=> '600',
		),
	),
	// 批量操作（批量操作允许的功能）
	'muti_operation' => array(
		'select'    => array('title' => '全选'),
		'inverse'   => array('title' => '反选'),
		'audit'     => array(
			'title'     => '审核',
			'action'    => 'admin/post/m_audit',
		),
		'move'      => array(
			'title'     => '移动',
			'action'    => 'admin/post/m_move',
		),
		'del'       => array(
			'title'     => '删除',
			'action'    => 'admin/post/m_del',
		),
	),
);

?>
