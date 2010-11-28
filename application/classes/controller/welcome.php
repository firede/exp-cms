<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Template {

	// 测试Smarty模板
	public $template = 'smarty:welcome/index';

	public function action_index()
	{
		$conf = 'id,title';
		$conf_arr = explode(',',$conf);

		$this->template->conf = $conf;
		$this->template->data = array(
			'id'=> 15,
			'title' => '测试底层模板设计',
		);

		if (isset ($_GET) AND isset ($_GET['id'])) {
			$id = (int) $_GET['id'];
		} else {
			$id = NULL;
		}
		$this->template->hello = ($id) ? '你GET的ID是'.$id : 'hello, world!';
	}

} // End Welcome
