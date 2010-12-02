<?php defined('SYSPATH') or die('No direct script access.');

/**
 * 后台Post部分管理权限配置
 *
 * @TODO 删除权限以后作成可在后台启用/关闭的
 */
return array(
	
	// 创建待审核
	'status_0' => array(
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
			'audit'     => '快速审核',
			'move'      => '移动',
			'delete'    => '删除',
			'preview'   => '预览',
		),
		// 批量操作（批量操作允许的功能）
		'muti_operation' => array(
			'select'    => '全选/取消',
			'inverse'   => '反选',
			'audit'     => '审核',
			'move'      => '移动',
			'delete'    => '删除',
		),
	),
	
	// 修改待审核
	'status_2' => array(
		'primary' => 'id',
		'column' => array(
			'select'	    => array(
				'label'     => '选择',
				'width'     => '30',
				'template'  => 'checkbox',
				'data'      => 'id',
			),
			'title'		    => array(
				'label'     => '标题',
				'width'     => '260',
				'template'  => 'link',
				'prefix'    => array('admin/post/view/', '.html'),
				'data'      => 'id,title',
				'order_by'  => 'title',
			),
			'flag'		    => array(
				'label'     => '',             // 标记（在表头不显示标题）
				'width'     => '60',
				'template'  => 'flag',
				'data'      => 'flag',
			),
			'click'         => array(
				'label'     => '点击',
				'width'     => '45',
				'template'  => 'text',
				'data'      => 'read_count',
				'order_by'  => 'read_count',
			),
			'time'          => array(
				'label'     => '更新日期',
				'width'     => '75',
				'template'  => 'date',
				'data'      => 'update_time,pub_time',
				'order_by'  => 'update_time',
			),
			'author'        => array(
				'label'     => '作者',
				'width'     => '80',
				'template'  => 'text',
				'prefix'    => array('作者：'),
				'data'      => 'user_name',
				'order_by'  => 'user_name',
			),
			'category'      => array(
				'label'     => '分类',
				'width'     => '80',
				'template'  => 'text',
				'prefix'    => array('分类：'),
				'data'      => 'cate_name',
				'order_by'  => 'cate_time',
			),
		),
		'operation'=> array(
			'audit'     => '快速审核',
			'move'      => '移动',
			'delete'    => '删除',
			'preview'   => '预览',
			'preview-ol'=> '线上版本预览',
		),
		'muti_operation' => array(
			'select'    => '全选/取消',
			'inverse'   => '反选',
			'audit'     => '审核',
			'move'      => '移动',
			'delete'    => '删除',
		),
	),
	
	// 已发布
	'status_1' => array(
		'primary' => 'id',
		'column' => array(
			'select'	    => array(
				'label'     => '选择',
				'width'     => '30',
				'template'  => 'checkbox',
				'data'      => 'id',
			),
			'title'		    => array(
				'label'     => '标题',
				'width'     => '260',
				'template'  => 'link',
				'prefix'    => array('admin/post/view/', '.html'),
				'data'      => 'id,title',
				'order_by'  => 'title',
			),
			'flag'		    => array(
				'label'     => '',             // 标记（在表头不显示标题）
				'width'     => '60',
				'template'  => 'flag',
				'data'      => 'flag',
			),
			'click'         => array(
				'label'     => '点击',
				'width'     => '45',
				'template'  => 'text',
				'data'      => 'read_count',
				'order_by'  => 'read_count',
			),
			'time'          => array(
				'label'     => '更新日期',
				'width'     => '75',
				'template'  => 'date',
				'data'      => 'update_time,pub_time',
				'order_by'  => 'update_time',
			),
			'author'        => array(
				'label'     => '作者',
				'width'     => '80',
				'template'  => 'text',
				'prefix'    => array('作者：'),
				'data'      => 'user_name',
				'order_by'  => 'user_name',
			),
			'category'      => array(
				'label'     => '分类',
				'width'     => '80',
				'template'  => 'text',
				'prefix'    => array('分类：'),
				'data'      => 'cate_name',
				'order_by'  => 'cate_name',
			)
		),
		'operation'=> array(
			'flag'      => '标记',
			'undo-pub'  => '撤销发布',
			'move'      => '移动',
			'delete'    => '删除',
			'preview'   => '预览',
		),
		'muti_operation' => array(
			'select'    => '全选/取消',
			'inverse'   => '反选',
			'flag'      => '标记',
			'undo-pub'  => '撤销发布',
			'move'      => '移动',
			'delete'    => '删除',
		),
	),
	
	// 草稿
	'status_5' => array(
		'primary' => 'id',
		'column' => array(
			'title'		    => array(
				'label'     => '标题',
				'width'     => '390',
				'template'  => 'link',
				'prefix'    => array('admin/post/view/', '.html'),
				'data'      => 'id,title',
				'order_by'  => 'title',
			),
			'time'          => array(
				'label'     => '更新日期',
				'width'     => '90',
				'template'  => 'date',
				'data'      => 'update_time,pub_time',
				'order_by'  => 'update_time',
			),
			'author'        => array(
				'label'     => '作者',
				'width'     => '120',
				'template'  => 'text',
				'prefix'    => array('作者：'),
				'data'      => 'user_name',
				'order_by'  => 'user_name',
			),
			'category'      => array(
				'label'     => '分类',
				'width'     => '120',
				'template'  => 'text',
				'prefix'    => array('分类：'),
				'data'      => 'cate_name',
				'order_by'  => 'cate_name',
			)
		),
		'operation'=> array(
			'preview'   => '预览',
		),
	),
	
	// 驳回
	'status_3' => array(
		'primary' => 'id',
		'column' => array(
			'select'	    => array(
				'label'     => '选择',
				'width'     => '30',
				'template'  => 'checkbox',
				'data'      => 'id'
			),
			'title'		    => array(
				'label'     => '标题',
				'width'     => '280',
				'template'  => 'link',
				'prefix'    => array('admin/post/view/', '.html'),
				'data'      => 'id,title',
				'order_by'  => 'title',
			),
			'flag'		    => array(
				'label'     => '',             // 标记（在表头不显示标题）
				'width'     => '60',
				'template'  => 'flag',
				'data'      => 'flag'
			),
			'time'          => array(
				'label'     => '更新日期',
				'width'     => '75',
				'template'  => 'date',
				'data'      => 'update_time,pub_time',
				'order_by'  => 'update_time',
			),
			'author'        => array(
				'label'     => '作者',
				'width'     => '90',
				'template'  => 'text',
				'prefix'    => array('作者：'),
				'data'      => 'user_name',
				'order_by'  => 'user_name',
			),
			'category'      => array(
				'label'     => '分类',
				'width'     => '90',
				'template'  => 'text',
				'prefix'    => array('分类：'),
				'data'      => 'cate_name',
				'order_by'  => 'cate_name',
			),
			'rej-type'      => array(
				'label'     => '驳回类别',
				'width'     => '70',
				'template'  => 'rej_type',
				'data'      => 'content',
				'order_by'  => 'content',
			),
		),
		'operation'=> array(
			'undo-rej'  => '撤销驳回',
			'preview'   => '预览',
		),
		'muti_operation' => array(
			'select'    => '全选/取消',
			'inverse'   => '反选',
			'undo-rej'  => '撤销驳回',
		),
	),
);

?>
