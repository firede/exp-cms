<?php

defined('SYSPATH') or die('No direct script access.');
/********
 * 管理员后台视图模板
 */
class Controller_AdminTemplate extends Controller {

	public $template = 'template';

	public $auto_render = TRUE;

	public function before() {
		if ($this->auto_render === TRUE)
		{
			$this->template = View::factory($this->template);
		}

		parent::before();
	}

	public function after() {
		if ($this->auto_render === TRUE)
		{
			// 输出视图前定义变量
			$this->template->BASE_URL = URL::base();

			$this->request->response = $this->template;
		}

		return parent::after();
	}

}

?>