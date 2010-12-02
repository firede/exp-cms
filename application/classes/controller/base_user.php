<?php

defined('SYSPATH') or die('No direct script access.');
/* * ******
 * 前台控制器的父类
 */

class Controller_Base_User extends Controller_Base {
    public function before() {
        parent::before();
    }

    public function after() {
        return parent::after();
    }

}

?>