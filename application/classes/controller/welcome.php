<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Template {

	public $template = 'welcome/index';

	public function action_index()
	{
		$this->template->hello = 'hello, world!';
	}

} // End Welcome
