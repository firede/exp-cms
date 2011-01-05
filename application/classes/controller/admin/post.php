<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Post extends Controller_Admin_BaseAdmin {
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
                    'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag', 'is_del');
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        $conf = "";
        if (isset($_GET["is_del"])&&$_GET["is_del"] =="1") {
            
            if (isset($_GET['status'])) {
                unset($_GET['status']);
            }
            $conf = Kohana::config('admin_post_list.recycle');
             
        } else {
            $_GET["is_del"] = "0";
            if (!isset($_GET['status'])) {
                $_GET['status'] = '0';
            }
            $conf_status = 'status_' . $_GET['status'];
            $conf = Kohana::config('admin_post_list')->$conf_status;
        }
        $pageparam = array("page" => $_GET['page'], "items_per_page" => $pagination->__get("items_per_page"));
        $post = Arr::filter_Array($_GET, $arr_element_names);
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $post["keyword"] = isset($_GET["keyword"]) ? $_GET["keyword"] : "";

        $posts = $postDb->query_list_search($post, $pageparam, $sort);
        $posts["message"] = Action::sucess_status($posts["message"]);
        if (isset($posts["total_items_count"]) && isset($posts["total_page_count"])) {
            $pagination->__set('total_items', $posts["total_items_count"]);
        }


        $view = View::factory('smarty:admin/post/list', array(
                    'pagination' => $pagination,
                    'view_data' => $posts,
                    'conf' => $conf,
                ));
           
        $this->template = AppCache::app_cache("post_view", $view);
    }

    /*     * *********
     * 根据关键字查询相应的post表数据,并加载重绘至post列表页面
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
        $post["is_del"] = "0";
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

    /*     * **
     * 跳转至新增文章页面 并推送uuid
     */

    public function action_create() {
        $uuid = Text::uuid();
        $view = View::factory('smarty:', array(
                    'uuid' => $uuid,
                    'conf' => $conf,
                ));
        $this->template = AppCache::app_cache("post_view", $view);
    }

    /*     * **
     * 创建保存一个新的post文章对象
     */

    public function action_create_post() {
        $m_post = new Model_Post();
        $validate_result = $m_post->post_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/post/create', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('post_create_post', $view);
            return;
        }
        $postDb = new Database_Post();
        $arr_element_names =
                array('id', 'uuid', 'title', 'cate_id', 'pub_time',
                    'pre_content', 'content', 'user_id', 'status',
                    'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $postDb->save($post);
        $view_data = Action::sucess_status($view_data);

        $view = View::factory('smarty:');
        $view->view_data = $view_data;
        $this->request->response = AppCache::app_cache("post_view", $view)->render();
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

        $view = View::factory('smarty:');
        $view->posts = $posts;
        $this->request->response = AppCache::app_cache("post_view", $view)->render();
    }

    /**
     * 删除功能子视图
     */
    public function action_del() {
        // $this->request->headers['Cache-control'] = 'max-age=86400';
        $view = View::factory('smarty:admin/post/del');
        $this->template = AppCache::app_cache("post_del", $view);
    }

    /**
     * 批量删除功能子视图
     */
    public function action_m_del() {
        // $this->request->headers['Cache-control'] = 'max-age=86400';
        $view = View::factory('smarty:admin/post/m_del');
        $this->template = AppCache::app_cache("post_m_del", $view);
    }

    /*     * ***
     * 根据ID标记删除post表数据
     * @param $id integer
     */

    public function action_del_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post["is_del"] = "1";
        $view_data = $postDb->del_flag($post);
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * ***
     * 根据多个ID，批量标记删除删除post表数据
     * @param $ids （array(integer)）
     */

    public function action_m_del_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post["is_del"] = "1";
        $view_data = $postDb->del_flag($post);
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
        ///这里还需要对附件进行更新处理
        $view_data = Action::sucess_status($view_data);

        $view = View::factory('json:');
        $view->view_data = $view_data;
        $this->request->response = AppCache::app_cache("post_update_post", $view)->render();
    }

    /**
     * 切换分类子视图
     */
    public function action_change_category() {
        $view = View::factory('smarty:admin/post/change_category');
        $this->template = AppCache::app_cache("post_change_category", $view);
    }

    /**
     * 标记功能子视图
     */
    public function action_flag() {
        $view = View::factory('smarty:admin/post/flag');
        $this->template = AppCache::app_cache("post_flag", $view);
    }

    /**
     * 批量标记功能子视图
     */
    public function action_m_flag() {
        $view = View::factory('smarty:admin/post/m_flag');
        $this->template = AppCache::app_cache("post_m_flag", $view);
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
        //获取操作类型
        $type = isset($_POST["type"]) ? $_POST["type"] : "";
        $arr_element_names = array('id', 'flag');
        //$post = Arr::filter_Array($_POST, $arr_element_names);
        $post = Arr::filter_Array($_POST, $arr_element_names);

        $view_data = $postDb->m_flag($post, $type);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /**
     * 移动功能子视图
     */
    public function action_move() {
        $view = View::factory('smarty:admin/post/move');
        $this->template = AppCache::app_cache("post_move", $view);
    }

    /**
     * 批量移动功能子视图
     */
    public function action_m_move() {
        $view = View::factory('smarty:admin/post/m_move');
        $this->template = AppCache::app_cache("post_m_move", $view);
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
        $view = View::factory('smarty:admin/post/audit');
        $this->template = AppCache::app_cache("post_audit", $view);
    }

    /**
     * 批量审核功能子视图
     */
    public function action_m_audit() {
        $view = View::factory('smarty:admin/post/m_audit');
        $this->template = AppCache::app_cache("post_m_audit", $view);
    }

    /*     * ******
     * 批量 审核
     * 批量post数据 如果id为数字则为单行修改 如果为id=1,2,4,6,34,风格则为批量修改“，”作为分割符号
     */

    public function action_m_audit_post() {
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
	 * 批量还原文章(GET)
	 */
	public function action_restore_all() {
        $view = View::factory('smarty:admin/post/restore_all');
        $this->template = AppCache::app_cache("post_restore_all", $view);
	}

    /**     * *
     * 还原所有回收站文章
     */
    public function action_restore_all_post() {
        $postDb = new Database_Post();
        $view_data = $postDb->restore_all();
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 批量还原文章(GET)
	 */
	public function action_m_restore() {
        $view = View::factory('smarty:admin/post/m_restore');
        $this->template = AppCache::app_cache("post_m_restore", $view);
	}

	/**     * *
     * 回收站－>批量还原文章
     */
    public function action_m_restore_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->restore($post);
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 还原文章(GET)
	 */
	public function action_restore() {
        $view = View::factory('smarty:admin/post/restore');
        $this->template = AppCache::app_cache("post_restore", $view);
	}

    /**     * *
     * 回收站－>还原文章
     */
    public function action_restore_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->restore($post);
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 清空回收站
	 */
	public function action_recycle_empty() {
        $view = View::factory('smarty:admin/post/recycle_empty');
        $this->template = AppCache::app_cache("post_recycle_empty", $view);
	}
	
    /**     * *
     * 回收站－>清空
     */
    public function action_recycle_empty_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->_empty();
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 删除文章(GET)
	 */
	public function action_recycle_del() {
        $view = View::factory('smarty:admin/post/recycle_del');
        $this->template = AppCache::app_cache("post_recycle_del", $view);
	}

    /**     * *
     * 回收站－>删除文章
     */
    public function action_recycle_del_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->delete($post);
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 批量删除文章(GET)
	 */
	public function action_m_recycle_del() {
        $view = View::factory('smarty:admin/post/m_recycle_del');
        $this->template = AppCache::app_cache("post_m_recycle_del", $view);
	}

    /**     * *
     * 回收站－>批量删除文章
     */
    public function action_m_recycle_del_post() {
        $postDb = new Database_Post();
        $arr_element_names =
                array('id');
        $post = Arr::filter_Array($_POST, $arr_element_names);
        $post['operation_id'] = 'admin'; //临时用户
        $view_data = $postDb->delete($post);
        $view_data = Action::sucess_status($view_data);

        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * ******
     * 单行 审核
     */

    public function action_audit_post() {
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
        $view = View::factory('smarty:admin/post/undo_pub');
        $this->template = AppCache::app_cache("post_undo_pub", $view);
    }

    /**
     * 批量撤销发布子视图
     */
    public function action_m_undo_pub() {
        $view = View::factory('smarty:admin/post/m_undo_pub');
        $this->template = AppCache::app_cache("post_m_undo_pub", $view);
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

    public function action_m_undo_pub_post() {
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
        $view = View::factory('smarty:admin/post/undo_rej');

        $this->template = AppCache::app_cache("post_undo_rej", $view);
    }

    /**
     * 批量撤销驳回子视图
     */
    public function action_m_undo_rej() {
        $view = View::factory('smarty:admin/post/m_undo_rej');
        $this->template = AppCache::app_cache("post_m_undo_rej", $view);
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

    public function action_m_undo_rej_post() {
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
     * 获取分类数据 结构为 树形数据结构
     */

    public function action_category() {
        $categoryDb = new Database_Category();
        $arr_element_names =
                array('id', 'name', 'short_name', 'parent_id', 'sort', 'child');
        $category = Arr::filter_Array($_GET, $arr_element_names);
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $view_data = $categoryDb->query_tree_array($category, $sort);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /**
     * 快速预览功能子视图
     */
    public function action_preview() {
        // $this->request->headers['Cache-control'] = 'max-age=86400';
        $view = View::factory('smarty:admin/post/preview');
        $this->template = AppCache::app_cache("post_preview", $view);
    }

    /* public function action_info() {
      ob_start();
      phpinfo(INFO_MODULES); //只查看 模块信息的列表
      $phpinfo = array('phpinfo' => array());
      if (preg_match_all('#(?:<h2>(?:<a name=".*?">)?(.*?)(?:</a>)?</h2>)|(?:<tr(?: class=".*?")?><t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>(?:<t[hd](?: class=".*?")?>(.*?)\s*</t[hd]>)?)?</tr>)#s', ob_get_clean(), $matches, PREG_SET_ORDER)) {

      foreach ($matches as $match) {

      if (isset($match[2]) && $match[2] == "APC Support") {
      echo $match[2] . ":" . $match[3];
      }
      }
      }

      } */
}

?>