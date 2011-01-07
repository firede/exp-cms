<?php

defined('SYSPATH') or die('No direct script access.');
/* * ******
 * 前台控制器的父类
 */

class Controller_BaseUser extends Controller_Base {

    public function before() {
        $this->_enable_themes = TRUE;
        parent::before();
    }

    public function after() {
		$this->template->SITE = Kohana::config('applicationconfig.site');
        return parent::after();
    }

}

?>