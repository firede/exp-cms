<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of auth
 *
 * @author Administrator
 */
class Controller_Admin_Auth extends Controller_Base {

    /**     *
     * 跳转至管理员登录页面
     */
    public function action_login() {
        $form = Kohana::config('adminauth_login_form');
        $page_path=$_GET["page_path"];
        $view = View::factory('smarty:admin/auth/login', array(
                    'form' => $form,
                    'page_path'=>$page_path,
                ));
        $this->template = AppCache::app_cache('adminauth_login', $view);
    }

    /*     * **
     * 管理员登录
     */

    public function action_login_post() {
        $m_admin = new Model_Admin();
        $validate_result = $m_admin->auth_validate($_POST);
        if (isset($validate_result["success"])) {

            $view = View::factory('smarty:admin/auth/login?page_path=' . $_GET["page_path"], array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('adminauth_login', $view);
            return;
        } else {
            Session::instance()->set('admin_data', $validate_result["result"][0]);
            if ($_GET["page_path"] == "") {
                $this->request->redirect("admin/post/list");
            } else {
                $this->request->redirect($_GET["page_path"]);
            }
        }
    }

    /*     * **
     * 注销
     */

    public function action_login_out() {
        Session::instance()->delete('admin_data');
        $this->request->redirect('');
    }

}

?>
