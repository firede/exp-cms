<?php

defined('SYSPATH') or die('No direct script access.');
/* * ******
 * admin控制器的父类
 */

class Controller_Admin_BaseAdmin extends Controller_Base {

    public function before() {

        parent::before();
  
        if (Session::instance()->get('admin_data') == NULL) {
            $this->request->redirect("admin/auth/login?page_path=". $_SERVER['HTTP_REFERER']);
        }
    }

    public function after() {
        if (Session::instance()->get('admin_data') != NULL) {
            $this->template->ADMIN_DATA = Session::instance()->get('admin_data');
        }
        return parent::after();
    }

}

?>