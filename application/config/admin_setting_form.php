<?php

/**
 * 表单配置
 */
return array(
    // 网站设置
    'site' => array(
        'webname' => array(
            'label' => '网站名称',
            'type' => 'text', // text,password,textarea,option,checkbox
            'name' => 'webname', // 表单的name，提交时用的字段
            'desc' => '将用于整站范围内需要显示网站名称的位置', // 表单的附加说明，部分表单会有此项
        ),
        'basehost' => array(
            'label' => '网站根地址',
            'type' => 'text',
            'name' => 'basehost',
        ),
        'indexurl' => array(
            'label' => '首页地址',
            'type' => 'text',
            'name' => 'indexurl',
        ),
		'default_style' => array(
			'label' => '默认风格',
			'type' => 'text',
			'name' => 'default_style',
			'desc' => '为空时使用系统默认模板',
		),
		'powerby' => array(
			'label' => '版权声明',
			'type' => 'text',
			'name' => 'powerby',
		),
        'keywords' => array(
            'label' => '关键词',
            'type' => 'text',
            'name' => 'keywords',
            'desc' => '将会用于meta keyword标签中，供搜索引擎索引',
            'value' => '',
            'message' => '',
            'min_len' => 0,
            'max_len' => 100,
        ),
        'description' => array(
            'label' => '网站说明',
            'type' => 'textarea',
            'name' => 'description',
            'desc' => '将会用于meta description标签中，供搜索引擎索引',
            'value' => '',
            'message' => '',
            'min_len' => 0,
            'max_len' => 200,
        ),
		'beian' => array(
			'label' => '备案号',
			'type' => 'text',
			'name' => 'beian',
			'desc' => '没有则不填',
		),
    ),
);
?>
