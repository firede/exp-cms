<?php

defined('SYSPATH') or die('No direct script access.');

class Database_admin {
    /*     * ****
     * 创建一个新的管理员数据 于admin表里
     * @$admin <array> 用户对象的数据内容
     * @return message <string> 直接返回执行情况消息
     */

    public function create($admin) {
        $save = DB::insert("admin", array());
        $save->values($admin);
        $result = (bool) $save->execute();
        return $result ? "ok" : "error";
    }

    /*     * **
     * 获取符合条件的数据 进行分页
     * @$admin <array>  对应admin表列的筛选条件的多个参数
     * @$page_Param <array> 关于分页的一些参数
     * @return <array> 符合条件的user表数据以及其他参数
     * @return message <string> 有错误的情况下会直接返回消息 正常执行的状态下会封装在return array里返回
     */

    public function query_list($admin, $page_Param) {
        $query = DB::select(array('COUNT("id")', 'total_admin'))->from('admin');
        foreach ($admin as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    $query->where('admin.' . $filedName, "like", "%" . $filedvalue . "%");
                }
        }
        $count_Result = $query->execute()->as_array();
        $count = $count_Result[0]['total_admin'];

        //设置查询数据的sql
        $query = DB::select("admin.*")->from('admin');


        foreach ($admin as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    $query->where('admin.' . $filedName, "like", "%" . $filedvalue . "%");
                }
        }

        if (!isset($page_Param["items_per_page"])) {
            $page_Param["items_per_page"] = 20;
        }
        //获取当前数据起始位置
        $current_item = $page_Param["items_per_page"] * ($page_Param["page"] - 1);
        $total_page_count = (int) ceil($count / $page_Param["items_per_page"]);
        $query->offset($current_item)->limit($current_item + $page_Param["items_per_page"]);
        $users = $query->execute();
        $admins = $admins->as_array();
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($admins); $i++) {

            $admins[$i]["role_name"] = Sysconfig_Business::admin_Role($users[$i]["role"]);
            $admins[$i]["password"] = "";
        }

        if ($count > 0)
            return array(
                'total_items_count' => $count, //总记录数
                'total_page_count' => $total_page_count,
                'items_per_page' => $page_Param["items_per_page"], //每页显示数据条数
                'result' => $admins,
            );
        else
            return "none";
    }

    /*     * *
     * 获取指定用户的信息
     * @$id <int> 用户id
     * @return <array> 用户信息
     * @return message <string> 有错误的情况下会直接返回消息 正常执行的状态下会封装在return array里返回
     */

    public function get_user($id) {
        if (!isset($id)) {
            return "no_id";
        }
        //设置查询数据的sql
        $query = DB::select('id', 'username', "password", "role")->from('admin');
        $query->where("id", "=", $id);
        $admins = $query->execute();
        $admins = $users->as_array();
        $count = count($users);
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($admins); $i++) {

            $admins[$i]["role_name"] = Sysconfig_Business::admin_Role($users[$i]["role"]);
            $admins[$i]["password"] = "";
        }
        // echo Kohana::debug($count);
        if ($count > 0)
            return $data = array('result' => $users,);
        else
            return 'none';
    }

    /*     * ***
     * 删除指定管理员
     * @$id <int> 用户id
     * @return message <string> 直接返回执行情况消息
     */

    public function delete($id) {
        if (!isset($id)) {
            return "no_id";
        }
        //设置删除数据的sql
        $delete = DB::delete()->table('admin');
        $delete->where("id", "=", $id);
        $result = (bool) $delete->execute();
        return $result ? "ok" : "error";
    }

    /*     * ***
     * 根据ID，修改admin表行数据
     * @param $admin （array(integer)）
     */

    public function modify($admin) {
        if ($admin == null || count($admin) == 0 || $admin['id'] == null) {
            return 'no_id';
        }
        /* 根据需要从请求中取出需要的数据值 */
        $ids = explode(",", $admin['id']);
        $modify = DB::update()->table('admin')->set($admin);
        //判断是否是批量操作
        if (count($ids) > 1) {
            $modify->where('id', 'in', $ids);
        } else {
            $modify->where('id', '=', $admin['id']);
        }
        $result = (bool) $modify->execute();
        return $result ? 'ok' : 'error';
    }
     /******
     * 检测该账号是否已经存在
     * @$admin <array> 用户信息
     * @return 存在返回exist 不存在返回ok
     */
    public function check_exist($admin) {
        //设置查询数据的sql
        $query = DB::select(array('COUNT("id")', 'total_admin'))->from('admin');
        $query->where("username", "=", $admin["username"]);
        $admins = $query->execute();
        $admins = $admins->as_array();
        $count = $admins[0]["total_admin"];
        $count > 0 ? "exist" : "ok"; //存在的话返回error 不存在返回ok
    }

}

?>
