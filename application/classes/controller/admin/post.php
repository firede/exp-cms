<?php
defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Post extends Controller_Admin_BaseAdmin {

    public function action_index() {

    }

    /*     * *********
     * 根据条件查询相应的post表数据,并加载重绘至post列表页面
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
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $posts = $postDb->query_list($post, $pageparam, $sort);
        $posts["message"] = Action::sucess_status($posts["message"]);
        if (isset($posts["total_items_count"]) && isset($posts["total_page_count"])) {
            $pagination->__set('total_items', $posts["total_items_count"]);
        }

        $conf_status = 'status_' . $_GET['status'];
        $conf = Kohana::config('admin_post')->$conf_status;
        // $this->cache = Cache::instance("apc");
        $view = View::factory('smarty:admin/post/list', array(
                    'pagination' => $pagination,
                    'view_data' => $posts,
                    'conf' => $conf,
                ));
        // $this->cache->set("post_list_view", $view);
        $this->template = $view;
        // $this->template = $this->cache->get("post_list_view");
    }

    /*     * **
     * 跳转至新增文章页面 并推送uuid
     */

    public function action_create() {
        $uuid = Text::uuid();
        echo Kohana::debug($_POST["uuid"]);

        $this->template = View::factory('smarty:', array(
                    'uuid' => $uuid,
                    'conf' => $conf,
                ));
    }

    /*     * **
     * 创建保存一个新的post文章对象
     */

    public function action_create_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'uuid', 'title', 'cate_id', 'pub_time',
                    'pre_content', 'content', 'user_id', 'status',
                    'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->save($post);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /*     * *********
     * 根据条件id查询相应的post表数据
     */

    public function action_get($id) {
        $id = isset($id) ? $id : "";
        $postDb = new Database_Post();
        $posts = $postDb->getpost($id);
        $posts = Action::sucess_status($posts);

		$this->template = View::factory('json:');
		$this->template->_data = $posts;

//        echo Kohana::debug($posts);
//        $view = View::factory('smarty:');
//        $view->posts = $posts;
//        $this->request->response = $view->render();
    }

    /*     * *********
     * 根据条件id查询相应的post表数据,并加载重绘至修改页面
     * @$id post.ID 
     */

    public function action_update($id) {
        $id = isset($id) ? $id : "";
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

    /**
     * 删除功能子视图
     */
    public function action_del() {
        // $this->request->headers['Cache-control'] = 'max-age=86400';

        $this->template = View::factory('smarty:admin/post/del');
    }

    /**
     * 批量删除功能子视图
     */
    public function action_m_del() {
        // $this->request->headers['Cache-control'] = 'max-age=86400';

        $this->template = View::factory('smarty:admin/post/m_del');
    }

    /*     * ***
     * 根据ID删除post表数据
     * @param $id integer
     */

    public function action_del_post() {

        $id = isset($_POST["id"]) ? $_POST["id"] : $_GET["id"];
        $postDb = new Database_Post();
        $view_data = $postDb->delete($id);
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /*     * ***
     * 根据多个ID，批量删除post表数据
     * @param $ids （array(integer)）
     */

    public function action_m_del_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'uuid', 'title', 'cate_id', 'pub_time',
                    'pre_content', 'content', 'user_id', 'status',
                    'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->multi_delete($post);

        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /*     * ******
     * 修改post数据行 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_update_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'uuid', 'title', 'cate_id', 'pub_time',
                    'pre_content', 'content', 'user_id', 'status',
                    'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->modify($post);
        $view_data = Action::sucess_status($view_data);
        echo Kohana::debug($view_data);
        $view = View::factory('json:');
        $view->view_data = $view_data;
        $this->request->response = $view->render();
    }

    /**
     * 标记功能子视图
     */
    public function action_flag() {
        $this->template = View::factory('smarty:admin/post/flag');
    }

    /**
     * 批量标记功能子视图
     */
    public function action_m_flag() {
        $this->template = View::factory('smarty:admin/post/m_flag');
    }

    /*     * ******
     * 加精/取消精华
     * 单行操作
     */

    public function action_flag_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'flag');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->modify($post);
       
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /*     * ******
     * 批量 加精/取消精华
     * 批量post数据行 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_m_flag_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'flag');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->modify($post);
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /**
     * 移动功能子视图
     */
    public function action_move() {
        $this->template = View::factory('smarty:admin/post/move');
    }

    /**
     * 批量移动功能子视图
     */
    public function action_m_move() {
        $this->template = View::factory('smarty:admin/post/m_move');
    }

    /*     * ******
     * 批量 移动
     * 批量post数据 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_m_move_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'cate_id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->modify($post);
         
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /**
     * 审核功能子视图
     */
    public function action_audit() {
        $this->template = View::factory('smarty:admin/post/audit');
    }

    /**
     * 批量审核功能子视图
     */
    public function action_m_audit() {
        $this->template = View::factory('smarty:admin/post/m_audit');
    }

    /*     * ******
     * 批量 审核
     * 批量post数据 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_m_trial_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'status', 'operation_desc');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->trial($post);
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /*     * ******
     * 单行 审核
     */

    public function action_trial_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'status', 'operation_desc');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->trial($post);
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /**
     * 撤销发布子视图
     */
    public function action_undo_pub() {
        $this->template = View::factory('smarty:admin/post/undo_pub');
    }

    /**
     * 批量撤销发布子视图
     */
    public function action_m_undo_pub() {
        $this->template = View::factory('smarty:admin/post/m_undo_pub');
    }

    /*     * ******
     * 撤销发布
     */

    public function action_undo_pub_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $post['operation_desc'] = '';
        $view_data = $postDb->undo_pub($post);
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /*     * ******
     * 批量撤销发布 id 格式为 &id=1，2,3,4
     */

    public function action_multi_undo_pub_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $post['operation_desc'] = '';
        $view_data = $postDb->undo_pub($post);
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /**
     * 撤销驳回子视图
     */
    public function action_undo_rej() {
        $this->template = View::factory('smarty:admin/post/undo_rej');
    }

    /**
     * 批量撤销驳回子视图
     */
    public function action_m_undo_rej() {
        $this->template = View::factory('smarty:admin/post/m_undo_rej');
    }

    /*     * ******
     * 撤销驳回 
     */

    public function action_undo_rej_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $post['operation_desc'] = '';
        $view_data = $postDb->undo_reject($post);
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /*     * ******
     * 批量撤销驳回 id 格式为 &id=1，2,3,4
     */

    public function action_multi_undo_rej_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $post['operation_desc'] = '';
        $view_data = $postDb->undo_reject($post);
        $view_data = Action::sucess_status($view_data);

		$this->template = View::factory('json:');
		$this->template->_data = $view_data;
    }

    /**
     * 快速预览功能子视图
     */
    public function action_preview() {
        // $this->request->headers['Cache-control'] = 'max-age=86400';

        $this->template = View::factory('smarty:admin/post/preview');
    }

    public function action_info() {
        ob_start();
        phpinfo(INFO_MODULES);//只查看 模块信息的列表
        $phpinfo = array('phpinfo' => array());
        if (preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER))
        {
            echo Kohana::debug($matches);
            foreach ($matches as $match){
                 
                if(isset($match[2])&&$match[2]=="APC Support"){
                    echo $match[2].":".$match[3];
                }
            }
        }
      
//       echo Kohana::debug(phpinfo_array());
    }

}
?>