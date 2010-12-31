<?php

/**
 * 表单配置
 */
return array(
	'default' => array(
		'id' => array(
			'type' => 'hidden',
			'name' => 'id',
		),
		'name' => array(
			'label' => '分类名称',
			'type' => 'text',
			'name' => 'name',
			'min_len' => 3,
			'max_len' => 16,
		),
		'short_name' => array(
			'label' => '短名称',
			'type' => 'text',
			'name' => 'short_name',
			'min_len' => 6,
			'max_len' => 22,
		),
		'parent_id' => array(
			'label' => '父级分类',
			'type' => 'cate',
			'name' => 'parent_id',
			'desc' => '请选择此分类的父级分类',
		),
		'sort' => array(
			'label' => '优先级别',
			'type' => 'text',
			'name' => 'sort',
			'desc' => '相同级别的分类根据优先级别排序，数字小的在前面',
			'value' => '50',
		),
	),
	'function_config' => array(
		'default' => array(
			'create' => array(
				'display' => 'name,short_name,parent_id,sort',
				'readonly'=> '',
			),
			'modify' => array(
				'display' => 'id,name,short_name,parent_id,sort',
				'readonly'=> '',
			),
		),
	),
);
?>
