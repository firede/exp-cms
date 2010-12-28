<?php

defined('SYSPATH') or die('No direct script access.');
/* * ******
 * admin控制器的父类
 */

class Controller_Admin_BaseAdmin extends Controller_Base {
    public function before() {

        parent::before();
        if(Session::instance()->get('admin_name')==NULL){
        $this->request->redirect("admin/auth/login");}
    }

    public function after() {
        return parent::after();
    }

}

?>