<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Template {

	// 测试Smarty模板
	public $template = 'welcome/index';

	public function action_index()
	{
		if (isset ($_GET) AND isset ($_GET['id'])) {
			$id = (int) $_GET['id'];
		} else {
			$id = NULL;
		}
		$this->template->hello = ($id) ? '你GET的ID是'.$id : 'hello, world!';
	}

} // End Welcome
