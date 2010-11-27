<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_AdminUser extends Controller_AdminTemplate {

    public $template = 'admin/base/layout';

    public function action_index() {

    }

    public function action_query_list() {

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
        echo Kohana::debug($user);
        $users = $userDb->query_list($user, $pageparam);
        $users = Action::sucess_status($users);

        echo Kohana::debug($users);
        if (isset($posts["total_items_count"])) {
            $pagination->__set('total_items', $users["total_items_count"]);
        }

        $this->template->layout_main = View::factory('admin/user/list', array(
                    'pagination' => $pagination,
                    'view_data' => $users,
                ));
    }

    public function action_get_user($id) {
        $userDb = new Database_User();
        $users = $userDb->get_user($id);
        $users = Action::sucess_status($users);
        echo Kohana::debug($users);
        $view = View::factory('smarty:');
        $view->posts = $posts;
        $this->request->response = $view->render();
    }

    public function action_delete() {

    }

    public function action_mulit_delete() {
        
    }

}