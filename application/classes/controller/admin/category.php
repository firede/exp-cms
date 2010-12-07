<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Category extends Controller_Admin_BaseAdmin {

    public function action_list() {


        $categoryDb = new Database_Category();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id', "name", "short_name", "parent_id", "sort");
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $categorys = $categoryDb->query_tree_array($category, $sort);
        $categorys = Action::sucess_status($categorys);

        /*  $this->template->layout_main = View::factory('admin/user/list', array(
          'pagination' => $pagination,
          'view_data' => $categorys,
          )); */
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

    public function action_delete() {

    }

    public function action_mulit_delete() {
        
    }

}