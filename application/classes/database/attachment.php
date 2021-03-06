<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of attachment
 *
 * @author attachment
 */
class Database_Attachment {
    /*     * *****
     * 新增一个新的 附件信息
     */

    public function insert($attachement) {
        try {
            $columns = array();
            foreach ($attachement as $key => $value) {
                $columns[$key] = $key;
            }
            $insert = DB::insert("attachment",$columns);
            $insert->values($attachment);
            $insert->execute();
            return "ok";
        } catch (Exception $e) {
            return "error";
        }
    }

    /*     * **
     * 获取符合条件的数据 进行分页
     * @$user <array>  对应user表列的筛选条件的多个参数
     * @$pageParam <array> 关于分页的一些参数
     * @return <array> 符合条件的user表数据以及其他参数
     * @return message <string> 有错误的情况下会直接返回消息 正常执行的状态下会封装在return array里返回
     */

    public function query_list($attachment, $page_Param, $sort, $keyword="") {
        $query = DB::select(array('COUNT("attachment.id")', 'total_attachment'))->from('attachment');
        $query->join("post", "left")->on("attachment.uuid", "=", "post.uuid");
        $query->join("user", "left")->on("attachment.user_id", "=", "user.id");
        foreach ($attachment as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    $query->where('attachment.' . $filedName, "like", "%" . $filedvalue . "%");
                }
        }
        if (!empty($keyword)) {
            $query->and_where_open();
            $query->or_where('user.username', "like", "%" . $keyword . "%");
            $query->or_where('post.title', "like", "%" . $keyword . "%");
            $query->or_where('attachment.file_type', "like", "%" . $keyword . "%");
            $query->or_where('attachment.url', "like", "%" . $keyword . "%");
            $query->and_where_close();
        }
        $count_Result = $query->execute()->as_array();
        $count = $count_Result[0]['total_attachment'];

        //设置查询数据的sql
        $query = DB::select("attachment.*", array("post.title", "post_name"), array("user.username", "user_name"))->from('attachment');
        $query->join("post", "left")->on("attachment.uuid", "=", "post.uuid");
        $query->join("user", "left")->on("attachment.user_id", "=", "user.id");

        foreach ($attachment as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    $query->where('attachment.' . $filedName, "like", "%" . $filedvalue . "%");
                }
        }
        if (!empty($keyword)) {
            $query->and_where_open();
            $query->or_where('user.username', "like", "%" . $keyword . "%");
            $query->or_where('post.title', "like", "%" . $keyword . "%");
            $query->or_where('attachment.file_type', "like", "%" . $keyword . "%");
            $query->or_where('attachment.url', "like", "%" . $keyword . "%");
            $query->and_where_close();
        }
        if (isset($sort["order_by"]) && isset($sort["sort_type"])) {
            $query->order_by($sort["order_by"], $sort["sort_type"]);
        }
        if (!isset($page_Param["items_per_page"])) {
            $page_Param["items_per_page"] = 20;
        }
        //获取当前数据起始位置
        $current_item = $page_Param["items_per_page"] * ($page_Param["page"] - 1);
        $total_page_count = (int) ceil($count / $page_Param["items_per_page"]);
        $query->offset($current_item)->limit($current_item + $page_Param["items_per_page"]);
        $attachments = $query->execute();
        $attachments = $attachments->as_array();
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($attachments); $i++) {
            $attachments[$i]["use_type_name"] = Sysconfig_Business::attachment_Use_type($attachments[$i]["use_type"]);
        }

        if ($count > 0)
            return array(
                'total_items_count' => $count, //总记录数
                'total_page_count' => $total_page_count,
                'items_per_page' => $page_Param["items_per_page"], //每页显示数据条数
                'result' => $attachments,
            );
        else
            return "none";
    }

    /*     * *****
     * 修改一个或者多个 附件信息 多个id 请使用“,”分隔
     */

    public function modify($attachement) {
        try {
            if (!isset($attachment["id"])) {
                return "no_id";
            }
            $id = $attachment["id"];
            unset($attachment["id"]);
            $modify = DB::update()->table("attachment")->set($attachment);
            $ids = explode(",", $id);
            $modify->where("id", "in", $ids);
            $modify->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * *****
     * 删除一个或者多个 附件信息多个id 请使用“,”分隔
     */

    public function del($attachment) {
        try {
            if (!isset($attachment["id"])) {
                return "no_id";
            }
            $id = $attachment["id"];
            $delete = DB::delete()->table("attachment");
            $ids = explode(",", $id);
            $delete->where("id", "in", $ids);
            $delete->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /**     *
     * 获取无用的 垃圾文件数据
     * @return array
     */
    public function get_rubbish() {
        $post_sql = DB::select("uuid")->from("post");
        $user_sql = DB::select("id")->from("user");
        $post_rebbish_sql = DB::select()->from("attachment");
        $post_rebbish_sql->where("uuid", "not in", $post_sql->execute())->and_where("use_type", "=", "0");
        $user_rebbish_sql = DB::select()->from("attachment");
        $user_rebbish_sql->where("user_id", "not in", $user_sql->execute())->and_where("use_type", "=", "1");
        return $rebbish = array_merge($post_rebbish_sql->execute(), $user_rebbish_sql->execute());
    }

    //清理垃圾数据和文件
    public function clear_rubbish() {
        try {
            DB::query(NULL, "BEGIN WORK")->execute(); //开启事务
            $rubbish = $this->get_rubbish();
            $m_attachment = new Model_Attachment();
            if ($m_attachment->clear_rebbish($rubbish) == TRUE) {
                return "ok";
            }
        } catch (Exception $e) {
            DB::query(NULL, "ROLLBACK")->execute();
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

}

?>
