<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Setting extends Controller_Admin_BaseAdmin {


	public function action_system() {
		$form = array(
			array(
				'label'    => '站点标题',
				'type'     => 'text',           // text,password,textarea,option,checkbox
				'name'     => 'siteTitle',      // 表单的name，提交时用的字段
				'desc'     => '将用于整站范围内需要显示网站标题的地方',   // 表单的附加说明，部分表单会有此项
				'value'    => '',               // 表单的默认值/回填值
				'message'  => '站点标题不能为空',  // 表单反馈的错误信息
			),
			array(
				'label'    => '站点地址',
				'type'     => 'text',
				'name'     => 'siteUrl',
				'desc'     => '',
				'value'    => '',
				'message'  => '',
			),
			array(
				'label'    => '站点描述',
				'type'     => 'textarea',
				'name'     => 'siteDesc',
				'desc'     => '将会用于meta description标签中，供搜索引擎索引',
				'value'    => '',
				'message'  => '',
			),
			array(
				'label'    => '关键词',
				'type'     => 'text',
				'name'     => 'siteKeyword',
				'desc'     => '将会用于meta keyword标签中，供搜索引擎索引',
				'value'    => '',
				'message'  => '',
			),
			array(
				'label'    => '注册开关',
				'type'     => 'select',
				'name'     => 'siteRegAble',
				'desc'     => '是否开放注册',
				'value'    => array(
					'0' => '关闭',
					'1' => '开放'
				),
				'message'  => '',
			),
		);

		$view = View::factory('smarty:admin/setting/system', array(
			'form' => $form,
		));

		$this->template = AppCache::app_cache("setting_system", $view);
	}


	public function action_query_list() {

      
    }

  
    public function action_test() {
        $arr=Kohana::config("cache");
     
        Arr::as_config_file($arr, APPPATH."config/test.php");
    }
    public function action_delete() {

    }

    public function action_mulit_delete() {
        
    }

}