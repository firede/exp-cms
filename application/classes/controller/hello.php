<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Hello extends Controller {

	// 不用Controller_Template而直接继承Controller的例子
	public function action_index()
	{
		$view = View::factory('smarty:welcome/index');
		$view->hello = '另一个Hello World!';

		$this->request->response = $view->render();
	}

	// 输出JSON的例子
	public function action_json()
	{
		$view = View::factory('json:');
		$view->content = array(
			'success' => TRUE,
			'message' => '成功啦！',
			'result' => array(
				array(
					'title'   => 'Hello',
					'date'    => date('Y-m-d H:i:s'),
					'content' => 'some Text<b style="color:red">hehe</b>',
				),
				array(
					'title'   => 'Hello',
					'date'    => date('Y-m-d H:i:s'),
					'content' => '搞定，中文自动Unicode',
				),
			),
		);

		$this->request->response = $view->render();
	}

} // End Welcome
