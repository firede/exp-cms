<?php

defined('SYSPATH') or die('No direct script access.');

class Database_Post {
    /*     * ***
     * 根据条件查询相应的post表数据
     * @$post
     * @$filedNames
     * @$pageParam
     * return post信息+分页信息
     */

    public function query_list($post, $filedNames, $pageParam) {
        $dao = Database::instance();
        $query = DB::select(array('COUNT("id")', 'total_post'))->from('post');
        // echo Kohana::debug($query);
        foreach ($filedNames as $filedName) {
            if (isset($post[$filedName]))
                if ($post[$filedName] != null) {
                    if ($filedName = "status") {
                        $filed_values=explode(',',(string)$post[$filedName]);
                        if (count( $filed_values) > 0) {

                        $query->where('post.' . $filedName, "in",$filed_values);
                        } else {
                            $query->where('post.' . $filedName, "=", $post[$filedName]);
                        }
                    } else {
                        $query->where('post.' . $filedName, "like", "%" . $post[$filedName] . "%");
                    }
                }
        }

        $count_Result = $query->execute()->as_array();
        $count = $count_Result[0]['total_post'];

        //设置查询数据的sql
        $query = DB::select('post.id', 'uuid', 'title', 'cate_id', array("category.name", "cate_name"), 'pub_time',
                        'pre_content', 'content', 'user_id', array("user.username", "user_name"), 'post.status',
                        'read_count', 'operation_id', array("admin.username", "operation_name"), 'reference', 'source', 'operation_desc', 'flag')->from('post');
        $query->join("admin", "left")->on("post.operation_id", "=", "admin.id");
        $query->join("user", 'left')->on("post.user_id", "=", "user.id");
        $query->join("category", 'left')->on("post.cate_id", "=", "category.id");

        // echo Kohana::debug($query);
        foreach ($filedNames as $filedName) {
            if (isset($post[$filedName]))
                if ($post[$filedName] != null) {
                    if ($filedName = "status") {
                        $filed_values=explode(',',(string)$post[$filedName]);
                        if (count( $filed_values) > 0) {
                          
                        $query->where('post.' . $filedName, "in",$filed_values);
                        } else {
                            $query->where('post.' . $filedName, "=", $post[$filedName]);
                        }
                    } else {
                        $query->where('post.' . $filedName, "like", "%" . $post[$filedName] . "%");
                    }
                }
        }

        if (!isset($pageParam["items_per_page"])) {
            $pageParam["items_per_page"] = 20;
        }
        //获取当前数据起始位置
        $current_item = $pageParam["items_per_page"] * ($pageParam["page"] - 1);
        $total_page_count = (int) ceil($count / $pageParam["items_per_page"]);
        $query->offset($current_item)->limit($current_item + $pageParam["items_per_page"]);
        $posts = $query->execute();
        $posts = $posts->as_array();
        //加入一些业务值
        for ($i = 0; $i < count($posts); $i++) {

            $posts[$i]["status_name"] = Sysconfig_Business::post_status($posts[$i]["status"]);
            $posts[$i]["flag"] = Sysconfig_Business::post_flag($posts[$i]["flag"]);
            $posts[$i]["swap"] = "";
        }

        unset($dao, Database::$instances['default']);
        if ($count > 0)
            return array(
                'total_items_count' => $count, //总记录数
                'total_page_count' => $total_page_count,
                'items_per_page' => $pageParam["items_per_page"], //每页显示数据条数
                'result' => $posts,
            );
        else
            return "none";
    }

    /*     * *
     * 根据参数$id 查询指定的post表行数据
     * @param $id integer
     * @return 行数据 array
     */

    public function getpost($id) {

        if ($id == null) {
            return "no_id";
        }
        $dao = Database::instance();
        $query = DB::select()->from('post')->where('id', '=', $id);
        $posts = $query->execute();
        $posts = $posts->as_array();
        $count = count($posts);
        // echo Kohana::debug($count);
        unset($dao, Database::$instances['default']);
        if ($count > 0)
            return $data = array('result' => $posts,);
        else
            return 'none';
    }

    /*     * ***
     * 根据ID删除post表数据
     * @param $id integer 
     */

    public function delete($id) {
        if (isset($ids)) {
            return 'no_id';
        }
        $dao = Database::instance();
        $delete = DB::delete()->table('post')->where('id', '=', $id);
        $count = count($delete->execute());
        unset($dao, Database::$instances['default']);
        echo Kohana::debug($count);
        return $count == 0 ? 'error' : 'ok'; //返回值有误 需要进一步分析kohana数据库操作的反馈机制
    }

    /*     * ***
     * 根据多个ID，批量删除post表数据
     * @param $ids （array(integer)）
     */

    public function multi_delete($ids) {
        if (isset($ids)) {
            return 'no_id';
        }
        $dao = Database::instance();
        $delete = DB::delete()->table('post')->where('id', 'in', $ids);
        $count = $delete->execute();
        unset($dao, Database::$instances['default']);
        echo Kohana::debug($count);
        return $count == 0 ? 'error' : 'ok';
    }

    /*     * ***
     * 根据ID，修改post表行数据
     * @param $post （array(integer)）
     */

    public function modify($post) {
        if ($post == null || count($post) == 0 || $post['id'] == null) {

            return 'no_id';
        }
        /* 根据需要从请求中取出需要的数据值 */
        $ids = explode(",", $post['id']);
        // echo Kohana::debug(explode(",", $ids));
        //echo Kohana::debug($ids);
        $dao = Database::instance();

        $modify = DB::update()->table('post')->set($post);
        $modify->set(array('swap' => 'Filed:content', 'content' => "Filed:pre_content", 'pre_content' => "Filed:swap"));
        //判断是否是批量操作
        if (count($ids) > 1) {
            $modify->where('id', 'in', $ids);
        } else {
            $modify->where('id', '=', $post['id']);
        }
        $count = $modify->execute();
        //   echo Kohana::debug($modify);

        unset($dao, Database::$instances['default']);
        return $count == 0 ? '修改失败' : 'ok';
    }

}

?>
