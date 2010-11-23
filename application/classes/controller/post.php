<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller {

    public function action_index() {
        echo '1';
    }

    /*     * *********
     * 根据条件查询相应的post表数据,并加载重绘至post列表页面
     */

    public function action_query_list() {
        $postDb = new Database_Post();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id', 'uuid', 'title', 'cate_id', 'pub_time',
                    'pre_content', 'content', 'user_id', 'status',
                    'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag');
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        $pageparam = array('page' => $_GET['page'], 'items_per_page' => 2);
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $posts = $postDb->query_list($post, $arr_element_names, $pageparam);
        $posts = Action::sucess_status($posts);
        echo Kohana::debug($posts);
        $view = View::factory('smarty:');
        $view->posts = $posts;
        $this->request->response = $view->render();
    }

    /*     * *********
     * 根据条件id查询相应的post表数据
     */

    public function action_get_post($id) {
        $postDb = new Database_Post();
        $posts = $postDb->getpost($id);
        $posts = Action::sucess_status($posts);
        echo Kohana::debug($posts);
        $view = View::factory('smarty:');
        $view->posts = $posts;
        $this->request->response = $view->render();
    }

    /*     * *********
     * 根据条件id查询相应的post表数据,并加载重绘至修改页面
     * @$id post.ID 
     */

    public function action_get_modify_post($id) {

        $postDb = new Database_Post();
        $post = $postDb->getpost($id);
        if (count($post) > 1) {
            $post["uuid"] = Text::uuid();
        }
        $posts = Action::sucess_status($posts);
        echo Kohana::debug($posts);
        $view = View::factory('smarty:');
        $view->posts = $posts;
        $this->request->response = $view->render();
    }

    /*     * ***
     * 根据ID删除post表数据
     * @param $id integer
     */

    public function action_delete($id) {
        $postDb = new Database_Post();
        $view_data=$postDb->delete($id);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /*     * ***
     * 根据多个ID，批量删除post表数据
     * @param $ids （array(integer)）
     */

    public function action_multi_delete($ids) {
        $postDb = new Database_Post();
        $view_data = $postDb->multi_delete($ids);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /*     * ******
     * 修改post数据行 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_modify() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'uuid', 'title', 'cate_id', 'pub_time',
                    'pre_content', 'content', 'user_id', 'status',
                    'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag');
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $view_data = $postDb->modify($post);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /*     * ******
     * 加精/取消精华
     * 单行操作
     */

    public function action_flag() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'flag');
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $view_data = $postDb->modify($post);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /*     * ******
     * 批量 加精/取消精华
     * 批量post数据行 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_multi_flag() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'flag');
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $view_data = $postDb->modify($post);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /*     * ******
     * 批量 移动
     * 批量post数据 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_multi_move() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'cate_id');
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $view_data = $postDb->modify($post);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /*     * ******
     * 批量 审核
     * 批量post数据 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_multi_trial() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'status', 'operation_desc');
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->modify($post);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /*     * ******
     * 单行 审核
     */

    public function action_trial() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'status', 'operation_desc');
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->modify($post);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

}

?>