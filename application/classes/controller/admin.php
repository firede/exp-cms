<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_AdminTemplate {

	public $template = 'admin/base/layout';
	
	public function action_index()
	{
		// 测试分页
		$pagination = new Pagination(array(
			'current_page'      => array('source' => 'query_string', 'key' => 'page'),
			'total_items'       => 1234,
			'items_per_page'    => 20,
			'view'              => 'pagination/admin',
			'auto_hide'         => TRUE,
			'first_page_in_url' => FALSE,
		));

		// 用来测试admin views的代码
		//$this->template->title = '后台管理';

		$this->template->layout_main = View::factory('admin/post/list', array(
			'pagination' => $pagination,
		));
	}

}