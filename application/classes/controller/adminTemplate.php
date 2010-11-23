<?php

defined('SYSPATH') or die('No direct script access.');
/********
 * 管理员后台视图模板
 */
class Controller_AdminTemplate extends Controller {

	public $template = 'admin/layout';

	public $auto_render = TRUE;

	public function before() {
		if ($this->auto_render === TRUE)
		{
			// Load the template
			$this->template = View::factory($this->template);

			$this->template->layout_aside = View::factory('admin/base/aside');
		}

		parent::before();
	}

	public function after() {
		if ($this->auto_render === TRUE)
		{
			$this->request->response = $this->template;
		}

		return parent::after();
	}

}

?>