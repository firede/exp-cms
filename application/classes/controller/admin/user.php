<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_User extends Controller_Admin_BaseAdmin {
    /*     * ***
     * 获得user 列表
     */

    public function action_list() {

        // 分页
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
        $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $users = $userDb->query_list($user, $pageparam, $sort, $keyword);
        $users = Action::sucess_status($users);
        if (isset($posts["total_items_count"])) {
            $pagination->__set('total_items', $users["total_items_count"]);
        }
        $conf = Kohana::config('admin_user_list');

        $view = View::factory('smarty:admin/user/list', array(
                    'pagination' => $pagination,
                    'view_data' => $users,
                    'conf' => $conf,
                ));

        $this->template = AppCache::app_cache("user_list", $view);
    }

    public function action_create() {
        $form = Kohana::config('admin_user_form.default');
        $function_config = Kohana::config('admin_user_form.function_config.default.create');
        $form = Action::form_decorate($form, $function_config);

        $view = View::factory('smarty:admin/user/create', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache('user_create', $view);
    }

    public function action_modify($id) {
        $form = Kohana::config('admin_user_form.default');
        $function_config = Kohana::config('admin_user_form.function_config.default.modify');
        $form = Action::form_decorate($form, $function_config);
        $userDb = new Database_User();
        $data_arr = $userDb->get_user($id);
        $form = Action::build_form_data($form, $data_arr["result"][0]);
        $form = Action::set_next_redirect_url($form);
        $view = View::factory('smarty:admin/user/modify', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache('user_modify', $view);
    }

    public function action_modify_post() {
        $m_user = new Model_User();
        $form = Kohana::config('admin_user_form.default');
        $function_config = Kohana::config('admin_user_form.function_config.default.modify');
        $legal_fileds = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER);
        $form = Action::form_decorate($form, $function_config);
        $validate_result = $m_user->post_validate($_POST, $form, $legal_fileds);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/user/modify', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('user_modify', $view);
            return;
        }
        $userDb = new Database_User();
        $arr_element_names = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER, array("re_password"));

        $user = Arr::filter_Array($_GET, $arr_element_names);
        $user["last_time"] = date("Y-m-d H:i:s");
        $view_data = $userDb->modify($user);
        $view_data = Action::sucess_status($view_data);

         $view = View::factory('smarty:');
        if ($view_data["success"]) {
            $view->next_page = $_POST["DXN_NEXT_REDIRECT_URL"];
        } else {
            $view->next_page = "admin/user/modify?id=" . $_POST["id"];
        }
        $view->data = $view_data;
        $this->request->response = AppCache::app_cache("user_modify_post", $view)->render();
    }

    /*     * **
     * 新增一个用户
     * 测试链接
     * http://daxiniu.com/admin/user/create_post?username=dcc&password=dcc&email=dc2002007z@123.coml&user_type=1&status=0&avatar=&reg_time=&last_time=&admin_id=admin
     */

    public function action_create_post() {
        $m_user = new Model_User();
        $form = Kohana::config('admin_user_form.default');

        $function_config = Kohana::config('admin_user_form.function_config.default.create');
        $legal_fileds = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER);
        $form = Action::form_decorate($form, $function_config);

        $validate_result = $m_user->post_validate($_POST, $form, $legal_fileds);

        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/user/create', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('user_create_post', $view);
            return;
        }
        $_POST["avatar"] = isset($_POST["avatar"]) ? $_POST["avatar"] : "";
        $userDb = new Database_User();
        $arr_element_names = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER, array("re_password"));
        $user = Arr::filter_Array($_POST, $arr_element_names);

        $user["reg_time"] = date("Y-m-d H:i:s");
        $user["last_time"] = date("Y-m-d H:i:s");

        $view_data = $userDb->create($user);
        $view_data = Action::sucess_status($view_data);

        $view = View::factory('smarty:');
        if ($view_data["success"]) {
            $view->next_page = "admin/user";
        } else {
            $view->next_page = "admin/user/create";
        }
        $view->users = $view_data;
        $this->request->response = AppCache::app_cache("user_create", $view)->render();
    }

    /*     * **
     * 通过id获取单个user信息
     */

    public function action_getuser() {
        $id = isset($_POST["id"]) ? $_POST["id"] : $_GET["id"];
        $userDb = new Database_User();
        $users = $userDb->get_user($id);
        $users = Action::sucess_status($users);
        $view = View::factory('smarty:');
        $view->users = $users;
        $this->request->response = AppCache::app_cache("user_getuser", $view)->render();
    }

    /**
     * 删除用户(GET)
     */
    public function action_del() {
        $view = View::factory('smarty:admin/user/del');
        $this->template = AppCache::app_cache("user_del", $view);
    }

    /*     * ***
     * 通过id删除 指定用户
     */

    public function action_del_post() {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $userDb = new Database_User();
        $view_data = $userDb->delete($id);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * **
     * 批量删除用户 多个用户用id=1,2,3表示
     */

    public function action_m_del_post() {

        $userDb = new Database_User();
        $view_data = $userDb->delete($_POST["id"]);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * **
     * 批量修改用户 多个用户用id=1,2,3表示
     */

    public function action_update_post() {
        $m_user = new Model_User();
        $validate_result = $m_user->post_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/user/create', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('user_create_post', $view);
            return;
        }
        $userDb = new Database_User();
        $arr_element_names =
                array('id', 'username', 'email', 'user_type', 'status',
                    'avatar', 'reg_time', 'last_time', 'admin_id',);
        $user = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $userDb->modify($user);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * **
     * 批量修改用户 多个用户用id=1,2,3表示
     */

    public function action_m_update_post() {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $userDb = new Database_User();
        $arr_element_names =
                array('id', 'username', 'email', 'user_type', 'status',
                    'avatar', 'reg_time', 'last_time', 'admin_id',);
        $user = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $userDb->mulit_modify($user);
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
        $user = Arr::filter_Array($_POST, $arr_element_names);
        $conf = Kohana::config("applicationconfig");
        $user["avatar"] = $conf["user"]["default_avatar"];
        $view_data = $userDb->mulit_modify($user);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /**     * *****
     * 上传头像
     */
    public function action_up_avatar() {
        $view_data = array();
        $file = $_FILES["file"];
        $m_upload = new Model_Upload();
        $conf = Kohana::config("applicationconfig");
        $conf = $conf["user"]["up_avatar"];
        $success = $m_upload->_up_img($file, $conf);
        $attachement = array();
        if ($success["success"]) {
            try {
                $attachment_db = new Database_Attachment();
                $attachement["file_type"] = $success["type"];
                $attachement["file_size"] = $success["size"];
                $attachement["url"] = $success["relative_url"];
                $attachement["use_type"] = "1";
                $attachement["user_id"] = Session::instance()->get("admin_name");
                $view_data = $attachment_db->insert($attachement);
                $view_data = Action::sucess_status($view_data);
                //这里 返回成功信息
                $this->template = View::factory('json:');
                $this->template->_data = $view_data;
            } catch (Exception $e) {
                //如果插入记录失败则直接删掉已经上传的文件 几率几乎为0
                if (isset($attachement["url"])) {
                    if (file_exists($success["relative_url"])) {
                        unlink(APPPATH . $attachement["url"]);
                    }
                }
                ErrorExceptionReport::_errors_report($e);
            }
        } else {
            //上传失败
            $view_data["success"] = "error";
            $view_data = Action::sucess_status($view_data);
            $this->template = View::factory('json:');
            $this->template->_data = $view_data;
        }
    }

}