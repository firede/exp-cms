<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 后台Post部分管理权限配置
 *
 * @TODO 删除权限以后作成可在后台启用/关闭的
 */
return array(
	
	// 创建待审核
	'status_0' => array(
		// 显示字段（列表表格所显示的列）
		'column' => array(
			'select'	    => array(
				'label'     => '选择',
				'template'  => 'checkbox',
				'data'      => 'id',
				'sortable'  => FALSE,
			),
			'title'		    => array(
				'label'     => '标题',
				'template'  => 'link',
				'prefix'    => array('admin/post/view/', '.html'),
				'data'      => 'id,title',
				'sortable'  => TRUE,
			),
			'time'          => array(
				'label'     => '日期',
				'template'  => 'date',
				'data'      => 'pub_time',
				'sortable'  => TRUE,
			),
			'author'        => array(
				'label'     => '作者',
				'template'  => 'link',
				'data'      => 'user_id,user_name',
				'sortable'  => TRUE,
			),
			'category'      => array(
				'label'     => '分类',
				'template'  => 'link',
				'data'      => 'cate_id,cate_name',
				'sortable'  => TRUE,
			),
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
	
	// 修改待审核
	'status_2' => array(
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
	
	// 已发布
	'status_1' => array(
		'column' => array(
			'select'	    => array(
				'label'     => '选择',
				'template'  => 'checkbox',
				'data'      => 'id',
				'sortable'  => FALSE,
			),
			'title'		    => array(
				'label'     => '标题',
				'template'  => 'link',
				'prefix'    => array('admin/post/view/', '.html'),
				'data'      => 'id,title',
				'sortable'  => TRUE,
			),
			'flag'		    => array(
				'label'     => '标记',
				'template'  => 'text',
				'data'      => 'flag',
				'sortable'  => TRUE,
			),
			'click'         => array(
				'label'     => '点击量',
				'template'  => 'text',
				'data'      => 'read_count',
				'sortable'  => TRUE,
			),
			'time'          => array(
				'label'     => '日期',
				'template'  => 'date',
				'data'      => 'pub_time',
				'sortable'  => TRUE,
			),
			'author'        => array(
				'label'     => '作者',
				'template'  => 'link',
				'data'      => 'user_id,user_name',
				'sortable'  => TRUE,
			),
			'category'      => array(
				'label'     => '分类',
				'template'  => 'link',
				'data'      => 'cate_id,cate_name',
				'sortable'  => TRUE,
			),
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
	
	// 草稿
	'status_5' => array(
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
	
	// 驳回
	'status_3' => array(
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


