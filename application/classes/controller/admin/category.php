<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Category extends Controller_Admin_BaseAdmin {
    /*     * **
     * 获得 分类列表
     */

    public function action_list() {
        $categoryDb = new Database_Category();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id', "name", "short_name", "parent_id", "sort");
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $categorys = $categoryDb->query_list($category, $sort);
		$view_data = array('result' => $categorys);
        $categorys = Action::sucess_status($view_data);
        $conf = Kohana::config('admin_category');
        $view = View::factory('smarty:admin/category/list');
        $view->view_data = $view_data;
		$view->conf = $conf;
        $this->template=$view;

      //  $this->request->response = AppCache::app_cache("category_list", $view)->render();
    }

    /*     * *****
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
        $this->template->_data = $view_data;
    }

    /*     * *
     * 将数据加载至文件缓存中
     */

    public function action_set_category() {
        $categoryDb = new Database_Category();
        $categorys = $categoryDb->set_config(array(), array());
    }

    /*     * *
     * 将数据加载至文件缓存中
     */

    public function action_crumb() {
        $id = isset($_GET["id"]) ? $_GET["id"] : "";
        $categoryDb = new Database_Category();
        $categorys = $categoryDb->crumb($id);
        echo Kohana::debug($categorys);
    }

    /*     * *
     * 删除单个分类
     */

    public function action_del_post() {
        $arr_element_names = array('id');
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->del($category);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * ****
     * 批量删除分类
     */

    public function action_m_del_post() {
        $arr_element_names = array('id');
        $category = Arr::filter_Array($_GET, $arr_element_names);
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

    /*     * *****
     * 修改分类
     */

    public function action_update_post() {
        $arr_element_names = array('id', "name", "short_name", "parent_id", "sort");
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->modify($category);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
    }

    /*     * ****
     * 批量修改分类
     */

    public function action_m_update_post() {
        $arr_element_names = array('id', "name", "short_name", "parent_id", "sort");
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->modify($category);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
    }

    /*     * *
     * 新增
     */

    public function action_save_post() {
        $arr_element_names = array('id', "name", "short_name", "parent_id", "sort");
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $categoryDb = new Database_Category();
        $view_data = $categoryDb->modify($category);
        $view_data = Action::sucess_status($view_data);
        $this->template->_data = $view_data;
        $view = View::factory('smarty:');
        $view->posts = $view_data;
        $this->request->response = AppCache::app_cache("category_save", $view)->render();
    }

}