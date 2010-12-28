<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Admin extends Controller_Admin_BaseAdmin {
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

        $adminDb = new Database_Admin();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id', 'username', 'role');
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }

        $pageparam = array("page" => $_GET['page'], "items_per_page" => $pagination->__get("items_per_page"));
        $admin = Arr::filter_Array($_GET, $arr_element_names);
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $admins = $adminDb->query_list($admin, $pageparam, $sort);
        $admins = Action::sucess_status($admins);
        if (isset($posts["total_items_count"])) {
            $pagination->__set('total_items', $admins["total_items_count"]);
        }
        $conf = Kohana::config('admin_admin_list');
        $view = View::factory('smarty:admin/admin/list', array(
                    'pagination' => $pagination,
                    'view_data' => $admins,
                    'conf' => $conf,
                ));

        $this->template = AppCache::app_cache("admin_list", $view);
    }

    /**
     * 新建管理员（展示视图）
     */
    public function action_create() {

        $form = Kohana::config('admin_admin_form');
        $view = View::factory('smarty:admin/admin/create', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache('admin_create', $view);
    }

	/*     * **
     * 新增一个用户
     * 测试链接
     */

    public function action_create_post() {
        $m_admin = new Model_Admin();
        $validate_result = $m_admin->post_validate($_POST);
        if (isset($validate_result["success"])) {

            $view = View::factory('smarty:admin/admin/create', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('admin_create', $view);
            return;
        }
        $adminDb = new Database_Admin();
        $arr_element_names = array('username', 'password', 'role');

        $admin = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $adminDb->create($admin);
        $view_data = Action::sucess_status($view_data);
        $view = View::factory('smarty:');
        $view->admins = $view_data;
        $this->request->response = AppCache::app_cache("admin_create", $view)->render();
    }
	
	/**
	 * 修改管理员（展示视图）
	 */
	public function action_modify() {
		$form = Kohana::config('admin_admin_form');
		$view = View::factory('smarty:admin/admin/modify', array(
			'form' => $form,
		));

		$this->template = AppCache::app_cache('admin_modify', $view);
	}

	/**
	 * 修改管理员（POST）
	 */
	public function action_modify_post() {
	 echo Kohana::debug($_POST);
	}


	/*     * **
     * 通过id获取单个user信息
     */

    public function action_getAdmin() {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $adminDb = new Database_Admin();
        $admins = $adminDb->get_user($id);
        $admins = Action::sucess_status($admins);
        $view = View::factory('smarty:');
        $view->admins = $admins;
        $this->request->response = AppCache::app_cache("admin_getAdmin", $view)->render();
    }

    /*     * ***
     * 通过id删除 指定用户
     */

    public function action_del_post() {
        $id = isset($_POST["id"]) ? $_POST["id"] : "";
        $adminDb = new Database_Admin();
        $view_data = $adminDb->delete($id);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

}