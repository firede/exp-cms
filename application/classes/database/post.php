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

    public function query_list($post, $pageParam, $sort) {
        return $this->_query_list($post, $pageParam, $sort, "0");
    }

    /*     * ***
     * 根据条件综合搜索查询相应的post表数据 条件对所有字段进行匹配
     * @$post
     * @$filedNames
     * @$pageParam
     * return post信息+分页信息
     */

    public function query_list_search($post, $pageParam, $sort) {
        return $this->_query_list($post, $pageParam, $sort, "1");
    }

    /*     * ***
     * 根据条件查询相应的post表数据
     * @$post
     * @$filedNames
     * @$pageParam
     * @$type <integer> 查询类型： 0 普通 |1 综合搜索
     * return post信息+分页信息
     */

    public function _query_list($post, $pageParam, $sort, $type) {
        $query = DB::select(array('COUNT("*")', 'total_post'))->from('post');
        $query->join("admin", "left")->on("post.operation_id", "=", "admin.id");
        $query->join("user", 'left')->on("post.user_id", "=", "user.id");
        $query->join("category", 'left')->on("post.cate_id", "=", "category.id");
        foreach ($post as $filedName => $filedvalue) {
            if (isset($filedvalue)) {

                if ($filedvalue != null) {
                    if ($filedName == "status" || $filedName == "flag" || $filedName == "is_del") {
                        $filed_values = explode(',', (string) $filedvalue);
                        if (count($filed_values) > 0) {
                            $query->and_where('post.' . $filedName, "in", $filed_values);
                        } else {
                            $query->and_where('post.' . $filedName, "=", $filedvalue);
                        }
                    }
                }
            }
        }
        if ($type == "1") {

            $query->and_where_open();
            $query->where('title', "like", "%" . $post["keyword"] . "%");
            $query->or_where("user.username", "like", "%" . $post["keyword"] . "%");
            $query->or_where("category.name", "like", "%" . $post["keyword"] . "%");
            $query->and_where_close();
        }

        $count_Result = $query->execute()->as_array();
        $count = $count_Result[0]['total_post'];

        //设置查询数据的sql
        $query = DB::select('post.id', 'uuid', 'title', 'cate_id', array("category.name", "cate_name"), 'pub_time', 'update_time',
                        'pre_content', 'content', 'user_id', array("user.username", "user_name"), 'post.status',
                        'read_count', 'operation_id', array("admin.username", "operation_name"), 'reference', 'source', 'operation_desc', 'flag', 'is_del')->from('post');
        $query->join("admin", "left")->on("post.operation_id", "=", "admin.id");
        $query->join("user", 'left')->on("post.user_id", "=", "user.id");
        $query->join("category", 'left')->on("post.cate_id", "=", "category.id");


        foreach ($post as $filedName => $filedvalue) {
            if (isset($filedvalue)) {

                if ($filedvalue != null) {
                    if ($filedName == "status" || $filedName == "flag" || $filedName == "is_del") {
                        $filed_values = explode(',', (string) $filedvalue);
                        if (count($filed_values) > 0) {
                            $query->and_where('post.' . $filedName, "in", $filed_values);
                        } else {
                            $query->and_where('post.' . $filedName, "=", $filedvalue);
                        }
                    }
                }
            }
        }
        if ($type == "1") {

            $query->and_where_open();
            $query->where('title', "like", "%" . $post["keyword"] . "%");
            $query->or_where("user.username", "like", "%" . $post["keyword"] . "%");
            $query->or_where("category.name", "like", "%" . $post["keyword"] . "%");
            $query->and_where_close();
        }

        if (isset($sort["order_by"]) && isset($sort["sort_type"])) {
            $query->order_by($sort["order_by"], $sort["sort_type"]);
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
        if ($count > 0)
            return array(
                'total_items_count' => $count, //总记录数
                'total_page_count' => $total_page_count,
                'items_per_page' => $pageParam["items_per_page"], //每页显示数据条数
                'result' => $posts,
                "message" => "ok"
            );
        else
            return array(
                'total_items_count' => $count, //总记录数
                'total_page_count' => $total_page_count,
                'items_per_page' => $pageParam["items_per_page"], //每页显示数据条数
                'result' => $posts,
                "message" => "none"
            );
    }

    /*     * ****
     * 保存数据至post表里
     * @$post <array> post数据的字段集合
     * @return 执行成功返回ok 失败返回error
     */

    public function insert($post) {
        $columns = array();
        foreach ($post as $key => $value) {
            $columns[$key] = $key;
        }
        /*  $columns =
          array('id', 'uuid', 'title', 'cate_id', 'pub_time', 'update_time',
          'pre_content', 'content', 'user_id', 'status',
          'read_count', 'operation_id', 'reference', 'source', 'operation_desc', 'flag'); */
        try {
            $save = DB::insert("post", $columns);
            $result = (bool) $save->values($post);
            return 'ok';
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * *
     * 根据参数$id 查询指定的post表行数据
     * @param $id integer
     * @return 行数据 array
     */

    public function getpost($id) {

        if ($id == null || $id == "") {
            return "no_id";
        }
        $query = DB::select()->from('post')->where('id', '=', $id);
        $posts = $query->execute();
        $posts = $posts->as_array();
        $count = count($posts);
        if ($count > 0)
            return $data = array('result' => $posts,);
        else
            return 'none';
    }

    /*     * ***
     * 根据一个或多个ID，批量删除post表数据 多个$post["id"]用","分隔多个id
     * @param $ids （array(integer)）
     */

    public function delete($post) {
        if ($post["id"] == null || $post["id"] == "") {
            return "no_id";
        }
        try {
            $ids = explode(",", $post["id"]);
            $delete = DB::delete()->table('post')->where('id', 'in', $ids);
            $delete->execute();

            return 'ok';
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * ***
     * 根据一个或者多个ID，post表数据标记为已删除
     * @param $post （array）
     */

    public function del_flag($post) {
        if ($post["id"] == null || $post["id"] == "") {
            return "no_id";
        }
        try {
            $ids = explode(",", $post["id"]);
            unset($post["id"]);
            $del_flag = DB::update("post")->set($post)->where('id', 'in', $ids);
            echo Kohana::debug($del_flag);
            $del_flag->execute();
            return 'ok';
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * ***
     * 根据ID，修改post表行数据
     * @param $post （array(integer)）
     */

    public function modify($post) {
        try {
            if ($post['id'] == null) {
                return 'no_id';
            }

            $id = $post["id"];

            unset($post['id']);
            /* 根据需要从请求中取出需要的数据值 */
            $ids = explode(",", $id);

            $modify = DB::update()->table('post')->set($post);
            // $modify->set(array('swap' => 'Filed:content', 'content' => "Filed:pre_content", 'pre_content' => "Filed:swap"));
            //判断是否是批量操作
            if (count($ids) > 1) {
                $modify->where('id', 'in', $ids);
            } else {
                $modify->where('id', '=', $id);
            }
            $result = (bool) $modify->execute();
            return 'ok';
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * *****
     * 批量修改标记
     * @$post 需要修改的值
     * @$type 操作类型 0撤销 | 1增加
     */

    public function m_flag($post, $type) {
        if ($post == null || count($post) == 0 || $post['id'] == null) {
            return 'no_id';
        }
        $id = $post['id'];
        unset($post['id']);
        /* 根据需要从请求中取出需要的数据值 */
        $ids = explode(",", $id);
        try {
            $select = DB::select_array(array("flag", "id"))->from("post");
            //判断是否是批量操作
            if (count($ids) > 1) {

                $select->where('id', 'in', $ids);
            } else {
                // $modify->where('id', '=', $post['id']);
                $select->where('id', '=', $id);
            }
            $result = $select->execute();
            $flags = explode(",", $post["flag"]);

            $flag_result = array();
            DB::query(NULL, "BEGIN WORK")->execute(); //开启事务
            foreach ($result as $key => $value) {
                $values = explode(",", $value["flag"]);
                if ($type == "0") {//取消指定标记
                    $values = Arr::_move_value_Array($values, $flags);
                } elseif ($type == "1") {//增加标记并去除重复标记
                    $values = array_unique(array_merge($flags, $values));
                }

                if (implode(",", $values) != $value["flag"]) {
                    $modify = DB::update()->table('post');
                    $modify->set(array("flag" => implode(",", $values)));

                    $modify->where('id', '=', $id);

                    $flag_result[$key] = (bool) $modify->execute();
                }
            }

            //事务处理

            DB::query(NULL, "COMMIT")->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            DB::query(NULL, "ROLLBACK")->execute();
            return "error";
        }
    }

    /*     * ***
     * 根据ID，审核处理内容
     * @param $post （array(integer)）
     */

    public function trial($post) {
        if ($post == null || count($post) == 0 || $post['id'] == null) {

            return "no_id";
        }
        $id = $post['id'];
        unset($post['id']);
        /* 根据需要从请求中取出需要的数据值 */
        $ids = explode(",", $id);
        try {
            $modify = DB::update()->table('post')->set($post);
            if ($post["status"] == 1) {//正式发布的情况下 将会与发布内容与已发布内容进行交换
                //将预发布内容和内容进行替换
                $modify->set(array('swap' => 'Filed:content', 'content' => "Filed:pre_content", 'pre_content' => "Filed:swap"));
            }
            //判断是否是批量操作
            if (count($ids) > 1) {
                $modify->where('id', 'in', $ids);
            } else {
                $modify->where('id', '=', $id);
            }
            $modify->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * ***
     * 根据ID，撤销发布，批量撤销发布
     * @param $post （array(integer)）
     */

    public function undo_pub($post) {
        if ($post == null || count($post) == 0 || $post['id'] == null) {

            return 'no_id';
        }
        $id = $post['id'];
        unset($post['id']);
        /* 根据需要从请求中取出需要的数据值 */
        $ids = explode(",", $id);
        DB::query(NULL, "BEGIN WORK")->execute(); //开启事务
        try {
            $modify = DB::update()->table('post')->set($post);
            //如果发布过的内容需要进行此操作
            //将预发布内容和内容进行替换 状态改为创建待审核
            $modify->set(array('status' => '5', 'swap' => 'Filed:content', 'content' => "Filed:pre_content", 'pre_content' => "Filed:swap"));
            $modify->where("content", "<>", "")->and_where("pre_content", "=", "");
            //判断是否是批量操作
            if (count($ids) > 1) {
                $modify->where('id', 'in', $ids);
            } else {
                $modify->where('id', '=', $id);
            }
            $undo_create_result = (bool) $modify->execute();


            $modify = DB::update()->table('post')->set($post);
            //如果发布过的内容需要进行此操作
            //将预发布内容和内容进行替换 状态改为修改待审核2
            $modify->set(array('status' => '2', 'swap' => 'Filed:content', 'content' => "Filed:pre_content", 'pre_content' => "Filed:swap"));
            $modify->where("content", "<>", "")->and_where("pre_content", "<>", "");
            //判断是否是批量操作
            if (count($ids) > 1) {
                $modify->where('id', 'in', $ids);
            } else {
                $modify->where('id', '=', $id);
            }
            $undo_update_result = (bool) $modify->execute();

            DB::query(NULL, "COMMIT")->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            DB::query(NULL, "ROLLBACK")->execute();
            return "error";
        }
    }

    /*     * *
     * 根据ID，撤销驳回，批量撤销驳回
     * @param $post （array(integer)）
     */

    public function undo_reject($post) {
        if ($post == null || count($post) == 0 || !isset($post['id'])) {

            return 'no_id';
        }
        $id = $post['id'];
        unset($post['id']);
        /* 根据需要从请求中取出需要的数据值 */
        $ids = explode(",", $id);
        DB::query(NULL, "BEGIN WORK")->execute(); //开启事务
        try {
            $modify = DB::update()->table('post')->set($post);
            //如果发布过的内容需要进行此操作
            //将预发布内容和内容进行替换 状态改为创建待审核
            $modify->set(array('status' => '5'));
            $modify->where("content", "<>", "")->and_where("pre_content", "=", "");
            //判断是否是批量操作
            if (count($ids) > 1) {
                $modify->where('id', 'in', $ids);
            } else {
                $modify->where('id', '=', $id);
            }
            $undo_create_result = (bool) $modify->execute();

            $modify = DB::update()->table('post')->set($post);
            //如果发布过的内容需要进行此操作
            //将预发布内容和内容进行替换 状态改为修改待审核2
            $modify->set(array('status' => '2'));
            $modify->where("content", "<>", "")->and_where("pre_content", "<>", "");
            //判断是否是批量操作
            if (count($ids) > 1) {
                $modify->where('id', 'in', $ids);
            } else {
                $modify->where('id', '=', $id);
            }
            $undo_update_result = (bool) $modify->execute();

            DB::query(NULL, "COMMIT")->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            DB::query(NULL, "ROLLBACK")->execute();
            return "error";
        }
    }

    /**     * ***
     * 检测该文章标题是否已经存在
     * @param $post array 文章信息
     * @return bool 存在返回FALSE 不存在返回TRUE
     */
    public function check_exist($post) {
        //设置查询数据的sql
        $query = DB::select(array('COUNT("id")', 'total_post'))->from('post');
        $query->where("title", "=", $post["title"]);
        $posts = $query->execute();
        $posts = $posts->as_array();
        $count = $posts[0]["total_post"];
        return $count > 0 ? FALSE : TRUE; //存在的话返回FALSE 不存在返回ok
    }

    /**     * **
     * 清空回收站中所有数据
     * @return string success
     */
    public function _empty() {

        try {

            $delete = DB::delete()->table('post')->where('is_del', '=', "1");
            $delete->execute();
            return 'ok';
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /**     * **
     * 还原回收站中所有数据
     * @return string success
     */
    public function restore_all() {

        try {

            $restore = DB::update("post")->set(array("is_del" => "0"))->where('is_del', '=', "1");
            $restore->execute();
            return 'ok';
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /**     * **
     * 还原回收站中所有数据
     * @return string success
     */
    public function restore($post) {

        try {
            $id = $post['id'];
            unset($post['id']);
            /* 根据需要从请求中取出需要的数据值 */
            $ids = explode(",", $id);

            $restore = DB::update("post")->set(array("is_del" => "0"))->where('is_del', '=', "1");
            $restore->where("id", "in", $ids);
            $restore->execute();
            return 'ok';
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

}

?>
