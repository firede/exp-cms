<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * 回收站
 */

/**
 * Description of recyclePost
 *
 * @author FanQie
 */
class Controller_Admin_ecyclePost extends Controller_Admin_BaseAdmin {

    /**     * ***
     * 回收站列表
     */
    public function action_list() {

        // 测试分页
        $pagination = new Pagination(array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => 0,
                    'items_per_page' => 20,
                    'view' => 'pagination/admin',
                    'auto_hide' => FALSE,
                    'first_page_in_url' => FALSE,
                ));
        $postDb = new Database_Post();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id', 'uuid', 'title', 'cate_id', 'pub_time', 'update_time',
                    'pre_content', 'content', 'user_id', 'status',
                    'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag');
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        if (!isset($_GET['status'])) {
            $_GET['status'] = '0';
        }

        $pageparam = array("page" => $_GET['page'], "items_per_page" => $pagination->__get("items_per_page"));
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $post["is_del"] = "1"; //已删除
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));

        $posts = $postDb->query_list($post, $pageparam, $sort);
        $posts["message"] = Action::sucess_status($posts["message"]);
        if (isset($posts["total_items_count"]) && isset($posts["total_page_count"])) {
            $pagination->__set('total_items', $posts["total_items_count"]);
        }

        $conf_status = 'status_' . $_GET['status'];
        $conf = Kohana::config('admin_post_list')->$conf_status;

        $view = View::factory('smarty:admin/post/list', array(
                    'pagination' => $pagination,
                    'view_data' => $posts,
                    'conf' => $conf,
                ));

        $this->template = AppCache::app_cache("post_view", $view);
    }

    /*     * *********
     * 回收站-- 根据关键字查询相应的post表数据,并加载重绘至post列表页面
     * 链接示意 admin/post/search?status=2&page=1&keyword=神说，要有光
     */

    public function action_search() {

        // 测试分页
        $pagination = new Pagination(array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => 0,
                    'items_per_page' => 20,
                    'view' => 'pagination/admin',
                    'auto_hide' => FALSE,
                    'first_page_in_url' => FALSE,
                ));
        $postDb = new Database_Post();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names = array('id', 'uuid', 'title', 'cate_id', 'pub_time', 'update_time',
            'pre_content', 'content', 'user_id', 'status',
            'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag', "keyword");
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        if (!isset($_GET['status'])) {
            $_GET['status'] = '0';
        }

        $pageparam = array("page" => $_GET['page'], "items_per_page" => $pagination->__get("items_per_page"));
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $post["keyword"] = isset($post["keyword"]) ? $post["keyword"] : "";
        $post["is_del"] = "1"; //已删除
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $posts = $postDb->query_list_search($post, $pageparam, $sort);
        $posts["message"] = Action::sucess_status($posts["message"]);
        if (isset($posts["total_items_count"]) && isset($posts["total_page_count"])) {
            $pagination->__set('total_items', $posts["total_items_count"]);
        }

        $conf_status = 'status_' . $_GET['status'];
        $conf = Kohana::config('admin_post')->$conf_status;

        $view = View::factory('smarty:admin/post/list', array(
                    'pagination' => $pagination,
                    'view_data' => $posts,
                    'conf' => $conf,
                ));

        $this->template = AppCache::app_cache("post_view", $view);
    }

    /*     * ******
     * 还原文章
     */

    public function action_restore_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post["is_del"] = "0";
        $view_data = $postDb->modify($post);
        ///这里还需要对附件进行更新处理
        $view_data = Action::sucess_status($view_data);

        $view = View::factory('json:');
        $view->view_data = $view_data;
        $this->request->response = AppCache::app_cache("post_update_post", $view)->render();
    }

    /*     * ******
     * 批量还原文章 id用“,”分隔
     */

    public function action_m_restore_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post["is_del"] = "0";
        $view_data = $postDb->modify($post);
        ///这里还需要对附件进行更新处理
        $view_data = Action::sucess_status($view_data);

        $view = View::factory('json:');
        $view->view_data = $view_data;
        $this->request->response = AppCache::app_cache("post_update_post", $view)->render();
    }

    /**     * **
     * 根据Id彻底删除post表数据
     * @param $id integer
     */
    public function action_del_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->delete($post);
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /**     * **
     * 根据多个ID，彻底删除post表数据
     * @param $ids （array(integer)）
     */
    public function action_m_del_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->delete($post);
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /**     * **
     * 清空所有post表中标记为已删除的所有文章
     * @param $ids （array(integer)）
     */
    public function action_clear_post() {
        $postDb = new Database_Post();
        $view_data = $postDb->clear();
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

     /**     * **
     * 还原所有post表中标记为已删除的所有文章
     * @param $ids （array(integer)）
     */
    public function action_restore_all_post() {
        $postDb = new Database_Post();
        $view_data = $postDb->restore_all();
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

}

?>
