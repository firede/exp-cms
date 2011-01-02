<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Category extends Controller_Admin_BaseAdmin {

    /**     * *
     * 获得 分类列表
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
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }

        $pageparam = array("page" => $_GET['page'], "items_per_page" => $pagination->__get("items_per_page"));
        $categoryDb = new Database_Category();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id', "name", "short_name", "parent_id", "sort");
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
        $categorys = $categoryDb->query_list($category, $sort, $pageparam, $keyword);
        $categorys = Action::sucess_status($categorys);
        $conf = Kohana::config('admin_category_list');
        $view = View::factory('smarty:admin/category/list', array(
                    'view_data' => $categorys,
                    'conf' => $conf,
                    'pagination' => $pagination,
                ));

        $this->template = AppCache::app_cache("category_list", $view);

        //$this->request->response = AppCache::app_cache("category_list", $view)->render();
    }

    /**     * ****
     * 获得树形结构的数组
     */
    public function action_tree() {
        $categoryDb = new Database_Category();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id', "name", "short_name", "parent_id", "sort");
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $categorys = $categoryDb->query_tree_array($category, $sort);
        $categorys = Action::sucess_status($categorys);
        $this->template = View::factory('json:');
        $this->template->_data = $categorys;
    }

    /**     *
     * 将数据加载至文件缓存中
     */
    public function action_set_category() {
        $categoryDb = new Database_Category();
        $categorys = $categoryDb->set_config(array(), array());
    }

    /**     *
     * 将数据加载至文件缓存中
     */
    public function action_crumb() {
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $categoryDb = new Database_Category();
        $categorys = $categoryDb->crumb($id);
    }

    /**
     * 删除分类(GET)
     */
    public function action_del() {
        $view = View::factory('smarty:admin/category/del');
        $this->template = AppCache::app_cache("category_del", $view);
    }

    /**     *
     * 删除单个分类
     */
    public function action_del_post() {
        $arr_element_names = array('id');
        $category = Arr::filter_Array($_POST, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->del($category);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /**     * ***
     * 批量删除分类
     */
    public function action_m_del_post() {
        $arr_element_names = array('id');
        $category = Arr::filter_Array($_POST, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->del($category);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        /*
          $this->template->_data = $view_data;
          $view = View::factory('smarty:');
          $view->posts = $posts;
          $this->request->response = AppCache::app_cache("category_user_m_del", $view)->render();
         * */
    }
/**
     * 新增分类(GET)
     */
    public function action_modify($id) {
        $form = Kohana::config('admin_category_form.default');
        $function_config = Kohana::config('admin_category_form.function_config.default.modify');
        $form = Action::form_decorate($form, $function_config);
        $categoryDb = new Database_Category();
        $data_arr = $categoryDb->get_category($id);
        $form = Action::build_form_data($form, $data_arr["result"][0]);
        $view = View::factory('smarty:admin/category/modify', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache('category_modify', $view);
    }
    /**     * ****
     * 修改分类
     */
    public function action_modify_post() {
        $m_category = new Model_Category();
        $form = Kohana::config('admin_category_form.default');
        $function_config = Kohana::config('admin_category_form.function_config.default.modify');
        $legal_fileds = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER);
        $form = Action::form_decorate($form, $function_config);
        $validate_result = $m_category->post_validate($_POST, $form, $legal_fileds);
      
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/category/update', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('category_create_post', $view);
            return;
        }
    //    $userDb = new Database_User();
        $arr_element_names = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER);

        $m_category = new Model_Category();

        $category = Arr::filter_Array($_POST, $arr_element_names);
      
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->modify($category);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->content=$view_data;
    }

    /**     * ***
     * 批量修改分类
     */
    public function action_m_update_post() {
        $arr_element_names = array('id', "name", "short_name", "parent_id", "sort");
        $category = Arr::filter_Array($_POST, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->modify($category);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
    }

    /**
     * 新增分类(GET)
     */
    public function action_create() {
        $form = Kohana::config('admin_category_form.default');
        $function_config = Kohana::config('admin_category_form.function_config.default.create');
        $form = Action::form_decorate($form, $function_config);

        $view = View::factory('smarty:admin/category/create', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache('category_create', $view);
    }

    /**     *
     * 新增
     */
    public function action_create_post() {
        $m_category = new Model_Category();
        $form = Kohana::config('admin_category_form.default');
        $function_config = Kohana::config('admin_category_form.function_config.default.create');
        $legal_fileds = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER);
        $form = Action::form_decorate($form, $function_config);

        $validate_result = $m_category->post_validate($_POST, $form, $legal_fileds);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/category/create', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('category_create_post', $view);
            return;
        }
        $arr_element_names = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER, array("re_password"));
        $category = Arr::filter_Array($_POST, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->create($category);
        $view_data = Action::sucess_status($view_data);
        $this->template->_data = $view_data;
        $view = View::factory('smarty:');
        $view->categorys = $view_data;
        $this->request->response = AppCache::app_cache("category_save", $view)->render();
    }

    /**     * ***
     * 清空子分类相关的信息
     */
    public function action_clear_child_post() {
        $arr_element_names = array('id');
        $category = Arr::filter_Array($_POST, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->del_clear_child($category);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
    }

    /**     * ***
     * 清空自身以及子分类相关的信息
     */
    public function action_del_clear_child_post() {
        $arr_element_names = array('id');
        $category = Arr::filter_Array($_POST, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->del_clear_child($category, TRUE);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
    }

}