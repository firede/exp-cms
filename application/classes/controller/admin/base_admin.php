<?php

defined('SYSPATH') or die('No direct script access.');
/* * ******
 * admin控制器的父类
 */

class Controller_Base_Admin extends Controller_Base {
    public function before() {
        parent::before();
    }

    public function after() {
        return parent::after();
    }

}

?>