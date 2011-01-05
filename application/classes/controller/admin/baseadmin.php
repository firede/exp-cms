<?php

defined('SYSPATH') or die('No direct script access.');
/* * ******
 * admin控制器的父类
 */

class Controller_Admin_BaseAdmin extends Controller_Base {

    public function before() {

        parent::before();

        if (Session::instance()->get('admin_data') == NULL) {
            $referer = $_SERVER['REQUEST_URI'] . "/";
            if (isset($_GET["page_path"])) {
                $this->request->redirect("/admin/auth/login?page_path=" . $_GET["page_path"]);
            } else {
                if (!empty($referer)) {
                    $this->request->redirect("/admin/auth/login?page_path=" . $referer);
                }
            }
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