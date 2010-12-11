<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Admin_BaseAdmin {
    /*     * ***
     * 获得user 列表
     */

    public function action_list() {

        // 测试分页
        $pagination = new Pagination(array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => 0,
                    'items_per_page' => 20,
                    'view' => 'pagination/admin',
                    'auto_hide' => TRUE,
                    'first_page_in_url' => FALSE,
                ));

        $userDb = new Database_User();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id', 'username', 'email', 'user_type', 'status',
                    'avatar', 'reg_time', 'last_time', 'admin_id',);
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }

        $pageparam = array("page" => $_GET['page'], "items_per_page" => $pagination->__get("items_per_page"));
        $user = Arr::filter_Array($_GET, $arr_element_names);
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $users = $userDb->query_list($user, $pageparam, $sort);
        $users = Action::sucess_status($users);
        if (isset($posts["total_items_count"])) {
            $pagination->__set('total_items', $users["total_items_count"]);
        }
        $view = View::factory('admin/user/list', array(
                    'pagination' => $pagination,
                    'view_data' => $users,
                ));

        $this->template->layout_main = AppCache::app_cache("user_list", $view);
    }

    /*     * **
     * 通过id获取单个user信息
     */

    public function action_getuser() {
         $id = isset($_POST["id"]) ? $_POST["id"] :  $_GET["id"];
        $userDb = new Database_User();
        $users = $userDb->get_user($id);
        $users = Action::sucess_status($users);
        $view = View::factory('smarty:');
        $view->posts = $posts;
        $this->request->response = AppCache::app_cache("user_getuser", $view)->render();
    }

    /*     * ***
     * 通过id删除 指定用户
     */

    public function action_del_post() {
         $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $userDb = new Database_User();
       $view_data= $userDb->delete($id);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * **
     * 批量删除用户 多个用户用id=1,2,3表示
     */

    public function action_m_del_post() {
         $id = isset($_POST["id"]) ? $_POST["id"] :  $_GET["id"];
        $userDb = new Database_User();
        $view_data=$userDb->delete($id);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * **
     * 批量修改用户 多个用户用id=1,2,3表示
     */

    public function action_update_post() {
       $id = isset($_POST["id"]) ? $_POST["id"] :  $_GET["id"];
        $userDb = new Database_User();
        $arr_element_names =
                array('id', 'username', 'email', 'user_type', 'status',
                    'avatar', 'reg_time', 'last_time', 'admin_id',);
        $user = Arr::filter_Array($_GET, $arr_element_names);
        $view_data=$userDb->modify($user);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * **
     * 批量修改用户 多个用户用id=1,2,3表示
     */

    public function action_m_update_post() {
        $id = isset($_POST["id"]) ? $_POST["id"] : $_GET["id"];
        $userDb = new Database_User();
        $arr_element_names =
                array('id', 'username', 'email', 'user_type', 'status',
                    'avatar', 'reg_time', 'last_time', 'admin_id',);
        $user = Arr::filter_Array($_GET, $arr_element_names);
        $view_data=$userDb->mulit_modify($user);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * **
     * 清空指定的 用户头像
     */

    public function action_clear_avtar_post() {
        $id = isset($_POST["id"]) ? $_POST["id"] : $_GET["id"];
        $userDb = new Database_User();
        $arr_element_names =
                array('id',);
        $user = Arr::filter_Array($_GET, $arr_element_names);
        $conf = Kohana::config("applicationconfig");
        $user["avatar"] = $conf["user"]["default_avatar"];
        $view_data=$userDb->mulit_modify($user);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

}