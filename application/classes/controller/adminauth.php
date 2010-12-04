<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of auth
 *
 * @author Administrator
 */
class Controller_adminAuth extends Controller_Base {
    /****
     * 登录
     */
    public function action_login() {
        if(!isset($_GET["username"])){
            echo "账号不能为空";
        }
        if(!isset($_GET["password"])){
            echo "密码不能为空";
        }
        $arr_element_names =
                array("username", "password", "role");
        $admin = Arr::filter_Array($_GET, $arr_element_names);
      
        $adminDb = new Database_admin();
        $admins = $adminDb->check_login($admin);
         echo Kohana::debug( Session::instance());
        if($admin=="none"){
            echo "用户不存在或者密码不正确";
        }else{
              Session::instance()->set('admin_name', $admin);
        }
      
    }
    /****
     * 注销
     */
     public function action_login_out() {
              Session::instance()->delete('admin_name');
    }

}

?>
