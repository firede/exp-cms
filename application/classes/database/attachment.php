<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of attachment
 *
 * @author attachment
 */
class Database_Attachment {
    /*******
     *新增一个新的 附件信息
     */
    public function insert($attachement) {
        try {
            $insert = DB::insert("attachement", array("url", "uuid", "file_size", "use_type", "status", "file_type"));
            $insert->values($attachement);
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

    public function query_list($attachement, $page_Param, $sort) {
        $query = DB::select(array('COUNT("id")', 'total_user'))->from('attachement');
        foreach ($user as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    $query->where('user.' . $filedName, "like", "%" . $filedvalue . "%");
                }
        }

        $count_Result = $query->execute()->as_array();
        $count = $count_Result[0]['total_user'];

        //设置查询数据的sql
        $query = DB::select("user.*", array("post.title", "post_name"))->from('attachement');
        $query->join("post", "left")->on("attachement.uuid", "=", "post.uuid");

        foreach ($user as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    $query->where('user.' . $filedName, "like", "%" . $filedvalue . "%");
                }
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
        $users = $query->execute();
        $users = $users->as_array();
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($users); $i++) {
            $users[$i]["status_name"] = Sysconfig_Business::user_Status($users[$i]["status"]);
            $users[$i]["user_type_name"] = Sysconfig_Business::user_User_type($users[$i]["user_type"]);
            $users[$i]["password"] = "";
        }

        if ($count > 0)
            return array(
                'total_items_count' => $count, //总记录数
                'total_page_count' => $total_page_count,
                'items_per_page' => $page_Param["items_per_page"], //每页显示数据条数
                'result' => $users,
            );
        else
            return "none";
    }
     /*******
     *修改一个或者多个 附件信息 多个id 请使用“,”分隔
     */
    public function modify($attachement) {
        try {
            if(!isset($attachement["id"])){
                return "no_id";
            }
            $id=$attachement["id"];
            unset($attachement["id"]);
            $modify = DB::update()->table("attachement")->set($attachement);
            $ids=explode(",", $id);
            $modify->where("id", "in", $ids);
            $modify->execute();
            return "ok";
        } catch (Exception $e) {
            return "error";
        }
    }
     /*******
     *删除一个或者多个 附件信息多个id 请使用“,”分隔
     */
    public function del($attachement) {
        try {
            if(!isset($attachement["id"])){
                return "no_id";
            }
            $id=$attachement["id"];
            $delete = DB::delete()->table("attachement");
            $ids=explode(",", $id);
            $delete->where("id", "in", $ids);
            $delete->execute();
            return "ok";
        } catch (Exception $e) {
            return "error";
        }
    }
}

?>
