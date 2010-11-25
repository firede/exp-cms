<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 后台Post部分管理权限配置
 *
 * @TODO 删除权限以后作成可在后台启用/关闭的
 */
return array(
	// 创建待审核
	'audit_create' => array(
		// 显示字段（列表表格所显示的列）
		'column' => array(
			'select'    => '选择',
			'title'     => '标题',
			'time'      => '日期',
			'author'    => '作者',
			'category'  => '分类',
		),
		// 操作（行级操作允许的功能）
		'operation'=> array(
			'audit'     => '快速审核',
			'move'      => '移动',
			'delete'    => '删除',
			'preview'   => '预览',
		),
		// 批量操作（批量操作允许的功能）
		'muti_operation' => array(
			'audit'     => '审核',
			'move'      => '移动',
			'delete'    => '删除',
		),
	),
	'audit_modify' => array(
		'column' => array(
			'select'    => '选择',
			'title'     => '标题',
			'flag'      => '标记',
			'click'     => '点击量',
			'time'      => '日期',
			'author'    => '作者',
			'category'  => '分类',
		),
		'operation'=> array(
			'audit'     => '快速审核',
			'move'      => '移动',
			'delete'    => '删除',
			'preview'   => '预览',
			'preview_ol'=> '线上版本预览',
		),
		'muti_operation' => array(
			'audit'     => '审核',
			'move'      => '移动',
			'delete'    => '删除',
		),
	),
	'publish' => array(
		'column' => array(
			'select'    => '选择',
			'title'     => '标题',
			'flag'      => '标记',
			'click'     => '点击量',
			'time'      => '日期',
			'author'    => '作者',
			'category'  => '分类',
		),
		'operation'=> array(
			'move'      => '移动',
			'delete'    => '删除',
			'undo_pub'  => '撤销发布',
			'preview'   => '预览',
		),
		'muti_operation' => array(
			'move'      => '移动',
			'delete'    => '删除',
			'undo_pub'  => '撤销发布',
		),
	),
	'draft' => array(
		'column' => array(
			'select'    => '选择',
			'title'     => '标题',
			'time'      => '日期',
			'author'    => '作者',
			'category'  => '分类',
		),
		'operation'=> array(
			'preview'   => '预览',
		),
		'muti_operation' => array(
		),
	),
	'reject' => array(
		'column' => array(
			'select'    => '选择',
			'title'     => '标题',
			'flag'      => '标记',
			'time'      => '日期',
			'author'    => '作者',
			'category'  => '分类',
			'rej_type'  => '驳回类别',
		),
		'operation'=> array(
			'undo_rej'  => '撤销驳回',
			'preview'   => '预览',
		),
		'muti_operation' => array(
			'undo_rej'  => '撤销驳回',
		),
	),
);

?>
