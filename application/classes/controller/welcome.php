<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Template {

	// 测试Smarty模板
	public $template = 'smarty:welcome/index';

	public function action_index()
	{
		$this->template->hello = 'hello, world!';
	}

} // End Welcome
