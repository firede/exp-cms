<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template {

	public $template = 'admin/base/layout';
	
	public function action_index()
	{
		$pagination = new Pagination(array(
			'current_page'      => array('source' => 'query_string', 'key' => 'page'), // source: "query_string" or "route"
			'total_items'       => 1234,
			'items_per_page'    => 20,
			'view'              => 'pagination/floating',
			'auto_hide'         => TRUE,
			'first_page_in_url' => FALSE,
		));

		// 用来测试admin views的代码
		$this->template->title = '大犀牛体验版CMS - 后台管理';

		$this->template->layout_main = View::factory('admin/post/list', array(
			'pagination' => $pagination,
		));
	}

}