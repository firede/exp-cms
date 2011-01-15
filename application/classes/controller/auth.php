<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of auth
 *
 * @author Administrator
 */
class Controller_Auth extends Controller_Base {

    /**
     * 跳转至用户登陆页面
     */
    public function action_login() {
        $form = Kohana::config('userauth_login_form');
        $data["form"] = $form;
        if (isset($_GET["page_path"])) {
            $data["page_path"] = $_GET["page_path"];
        }

        $view = View::factory('smarty:auth/login', $data);
        $this->template = AppCache::app_cache('userauth_login', $view);
    }

    /** **
     * 用户登录
     */

    public function action_login_post() {
        $m_admin = new Model_Admin();
        $validate_result = $m_admin->auth_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:/auth/login', array(
                        'form' => $validate_reauthsult["data"],
                        'page_path' => $_GET["page_path"],
                    ));
            $this->template = AppCache::app_cache('userauth_login', $view);
            return;
        } else {
            Session::instance()->set('user_data', $validate_result["result"][0]);
            if ($_GET["page_path"] == "") {
                $this->request->redirect("/center");
            } else {
                $this->request->redirect($_GET["page_path"]);
            }
        }
    }

    /*     * **
     * 注销
     */

    public function action_login_out() {
        Session::instance()->delete('user_data');
        $this->request->redirect('');
    }

}

?>
