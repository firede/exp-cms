<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller_BaseUser {
<<<<<<< HEAD

    
=======
>>>>>>> 4260af4220263d1e0edf5abb75634fa00db4b54b

    /**
     * 获取 带分页的文章的列表
     * @param <type> $dxn_get
     */
    public function action_list($dxn_get) {
        // 分页
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
        if (!isset($dxn_get['page'])) {
            $dxn_get['page'] = 1;
        }
        $conf = "";
        if (isset($dxn_get["is_del"]) && $dxn_get["is_del"] == "1") {

            if (isset($dxn_get['status'])) {
                unset($dxn_get['status']);
            }
            $conf = Kohana::config('admin_post_list.recycle');
        } else {
            $dxn_get["is_del"] = "0";
            if (!isset($dxn_get['status'])) {
                $dxn_get['status'] = '0';
            }
            $conf_status = 'status_' . $dxn_get['status'];
            $conf = Kohana::config('admin_post_list')->$conf_status;
        }
        $pageparam = array("page" => $dxn_get['page'], "items_per_page" => $pagination->__get("items_per_page"));
        $post = Arr::filter_Array($dxn_get, $arr_element_names);
        $sort = Arr::filter_Array($dxn_get, array("order_by", "sort_type"));
        $post["keyword"] = isset($dxn_get["keyword"]) ? $dxn_get["keyword"] : "";

        $posts = $postDb->query_list_search($post, $pageparam, $sort);
        $posts["message"] = Action::sucess_status($posts["message"]);
        if (isset($posts["total_items_count"]) && isset($posts["total_page_count"])) {
            $pagination->__set('total_items', $posts["total_items_count"]);
        }


        $view = View::factory('smarty:post/inc_list', array(
                    'pagination' => $pagination,
                    'view_data' => $posts,
                    'conf' => $conf,
<<<<<<< HEAD
                        ), TRUE);
=======
                ), TRUE);
>>>>>>> 4260af4220263d1e0edf5abb75634fa00db4b54b

        echo AppCache::app_cache("post_view", AppCache::app_cache('before_post_list', $view));
    }

    /**
     * 热门文章
     * @param <type> $dxn_get
     */
    public function action_hots($dxn_get) {
        $dxn_get['order_by'] = 'read_count';
        $dxn_get['sort_type'] = 'desc';
        $this->action_list($dxn_get);
    }

    /**
     * 最新文章
     * @param <type> $dxn_get
     */
    public function action_news($dxn_get) {
        $dxn_get['order_by'] = 'pub_time';
        $dxn_get['sort_type'] = 'desc';
        $this->action_list($dxn_get);
    }

}

?>
