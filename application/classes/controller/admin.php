<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin extends Controller_Template {

	public $template = 'admin/index';

	public function action_index()
	{
		// 用来测试admin views的代码
		$this->template->assets_admin = '/assets/admin/';
		$this->template->assets_common = '/assets/common/';
		$this->template->title = '大犀牛体验版CMS - 后台管理';
	}

}