<?php
/**
 * 表单配置
 */
return array(
	// 系统设置
	'system' => array(
		'siteTitle' => array(
			'label'     => '站点标题',
			'type'      => 'text',           // text,password,textarea,option,checkbox
			'name'      => 'siteTitle',      // 表单的name，提交时用的字段
			'desc'      => '将用于整站范围内需要显示网站标题的地方',   // 表单的附加说明，部分表单会有此项
			'value'     => '',               // 表单的默认值/回填值
			'message'   => '',  // 表单反馈的错误信息
		),
		'siteUrl' => array(
			'label'     => '站点地址',
			'type'      => 'text',
			'name'      => 'siteUrl',
			'desc'      => '',
			'value'     => '',
			'message'   => '',
		),
		'siteDesc' => array(
			'label'     => '站点描述',
			'type'      => 'textarea',
			'name'      => 'siteDesc',
			'desc'      => '将会用于meta description标签中，供搜索引擎索引',
			'value'     => '',
			'message'   => '',
		),
		'siteKeyword' => array(
			'label'     => '关键词',
			'type'      => 'text',
			'name'      => 'siteKeyword',
			'desc'      => '将会用于meta keyword标签中，供搜索引擎索引',
			'value'     => '',
			'message'   => '',
		),
		'siteRegOpen' => array(
			'label'	    => '注册开关',
			'type'      => 'select',
			'name'      => 'siteRegOpen',
			'desc'      => '是否开放注册',
			'value'     => array(
				'0' => '关闭',
				'1' => '开放'
			),
			'message'  => '',
		),
	),
);
?>
