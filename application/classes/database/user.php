<?php

/*
 * 数据库 user表操作类
 */

/**
 * Description of user
 *
 * @author FanQie
 */
class Database_User {
    /*     * ****
     * 创建一个新的用户数据 于user表里
     * @$user <array> 用户对象的数据内容
     * @return message <string> 直接返回执行情况消息
     */

    public function create($user) {

        $save = DB::insert("user", array('username', "password", 'email', 'user_type', 'status',
                    'avatar', 'reg_time', 'last_time', 'admin_id'));
        $save->values($user);
        $result = (bool) $save->execute();
        return $result ? "ok" : "error";
    }

    /*     * **
     * 获取符合条件的数据 进行分页
     * @$user <array>  对应user表列的筛选条件的多个参数
     * @$pageParam <array> 关于分页的一些参数
     * @return <array> 符合条件的user表数据以及其他参数
     * @return message <string> 有错误的情况下会直接返回消息 正常执行的状态下会封装在return array里返回
     */

    public function query_list($user, $page_Param, $sort) {
        $query = DB::select(array('COUNT("id")', 'total_user'))->from('user');
        foreach ($user as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    if ($filedName == "status" || $filedName == "user_type") {
                        $filed_values = explode(',', (string) $filedvalue);
                        if (count($filed_values) > 0) {
                            $query->where('user.' . $filedName, "in", $filed_values);
                        } else {
                            $query->where('user.' . $filedName, "=", $filedvalue);
                        }
                    } else {
                        $query->where('user.' . $filedName, "like", "%" . $filedvalue . "%");
                    }
                }
        }

        $count_Result = $query->execute()->as_array();
        $count = $count_Result[0]['total_user'];

        //设置查询数据的sql
        $query = DB::select("user.*", array("admin.username", "admin_name"))->from('user');
        $query->join("admin", "left")->on("user.admin_id", "=", "admin.id");


        // echo Kohana::debug($query);
        foreach ($user as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    if ($filedName == "status" || $filedName == "user_type") {
                        $filed_values = explode(',', (string) $filedvalue);
                        if (count($filed_values) > 0) {
                            $query->where('user.' . $filedName, "in", $filed_values);
                        } else {
                            $query->where('user.' . $filedName, "=", $filedvalue);
                        }
                    } else {
                        $query->where('user.' . $filedName, "like", "%" . $filedvalue . "%");
                    }
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
        $conf = Kohana::config("applicationconfig");

        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($users); $i++) {
            if ($users[$i]["avatar"] == "" || $users[$i]["avatar"] == NULL) {//如果没有设置图像则使用默认图像
                $users[$i]["avatar"] = $conf["user"]["default_avatar"];
            }
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
        $query = DB::select('id', 'username', "password", 'email', 'user_type', 'status',
                        'avatar', 'reg_time', 'last_time', 'admin_id')->from('user');
        $query->where("id", "=", $id);
        $users = $query->execute();
        $users = $users->as_array();
        $count = count($users);
        $conf = Kohana::config("applicationconfig");

        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($users); $i++) {
            if ($users[$i]["avatar"] == "" || $users[$i]["avatar"] == NULL) {//如果没有设置图像则使用默认图像
                $users[$i]["avatar"] = $conf["user"]["default_avatar"];
            }
            $users[$i]["status_name"] = Sysconfig_Business::user_Status($users[$i]["status"]);
            $users[$i]["user_type_name"] = Sysconfig_Business::user_User_type($users[$i]["user_type"]);
            $users[$i]["password"] = "";
        }
        // echo Kohana::debug($count);
        if ($count > 0)
            return $data = array('result' => $users,);
        else
            return 'none';
    }

    /*     * ***
     * 删除指定用户
     * @$id <int> 用户id
     * @return message <string> 直接返回执行情况消息
     */

    public function delete($id) {
        try {
            if (!isset($id)) {
                return "no_id";
            }
            //设置删除数据的sql
            $delete = DB::delete()->table('user');
            $delete->where("id", "=", $id);
            $result = (bool) $delete->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * ***
     * 批量删除指定用户
     * @$id <int> 一个或多个用户id 多个id 使用“，”分隔
     * @return message <string> 直接返回执行情况消息
     */

    public function mulit_delete($id) {
        try {
            if (!isset($id)) {
                return "no_id";
            }
            /* 根据需要从请求中取出需要的数据值 */
            $ids = explode(",", $post['id']);
            //设置删除数据的sql
            $delete = DB::delete()->table('user');
            $delete->where('id', 'in', $ids);
            $result = (bool) $delete->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * ***
     * 修改用户的信息
     * @$user <array> 用户需要修改信息的多个参数封装 与数据库表结构应该相符  $user->id 字段为必须
     * @return message <string> 直接返回执行情况消息
     */

    public function modify($user) {
        try {
            if (!isset($user["id"])) {
                return "no_id";
            }
            $id = $user["id"];
            unset($user["id"]);
            //设置删除数据的sql
            $modify = DB::update()->table("user");
            $modify->set($user);
            $modify->where("id", "=", $id);
            $result = (bool) $modify->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * ***
     * 批量修改用户的信息
     * @$user <array> 用户需要修改信息的多个参数封装 与数据库表结构应该相符 $user->id 字段如果
     * 有多个则用“,”分隔 ,$user->id为必须字段，每次至少有一个user被执行
     * @return message <string> 直接返回执行情况消息
     */

    public function mulit_modify($user) {
        try {
            if (!isset($user["id"])) {
                return "no_id";
            }
            $ids = $user["id"];
            unset($user["id"]);
            //设置删除数据的sql
            $modify = DB::update()->table("user");
            $modify->set($user);
            /* 根据需要从请求中取出需要的数据值 */
            $ids = explode(",", $ids);
            $modify->where("id", "in", $ids);
            $modify->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /*     * ***
     * 清除用户图像
     * @$user->id user对象必须包含中必须包含用户id
     * @return message <string> 直接返回执行情况消息
     */

    public function clear_avtar($user) {
        try {
            if (!isset($user['id'])) {
                return "no_id";
            }
            $id = $user["id"];
            unset($user["id"]);
            $user["avtar"] = "";
            //设置删除数据的sql
            $modify = DB::update()->table("user");
            $modify->set($user);
            $modify->where("id", "=", $id);
            $result = (bool) $modify->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /**     * ***
     * 检测该用户是否已经存在
     * @param $user array 用户信息
     * @return bool 存在返回FALSE 不存在返回TRUE
     */
    public function check_exist($user) {
        //设置查询数据的sql
        $query = DB::select(array('COUNT("id")', 'total_user'))->from('user');
        $query->where("username", "=", $user["username"]);
        $users = $query->execute();
        $users = $users->as_array();
        $count = $users[0]["total_user"];
        return $count > 0 ? FALSE : TRUE; //存在的话返回FALSE 不存在返回True
    }

    /*     * ****
     * 检测登录
     * @$user <array> 用户信息
     * @return 存在返回该用户信息 不存在返回ok
     */

    public function check_login($user) {
        if (!isset($id)) {
            return "no_id";
        }
        //设置查询数据的sql
        $query = DB::select('id', 'username', "password", 'email', 'user_type', 'status',
                        'avatar', 'reg_time', 'last_time', 'admin_id')->from('user');
        $query->where("id", "=", $id);
        $users = $query->execute();
        $users = $users->as_array();
        $count = count($users);
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($users); $i++) {

            $users[$i]["status_name"] = Sysconfig_Business::user_Status($users[$i]["status"]);
            $users[$i]["user_type_name"] = Sysconfig_Business::user_User_type($users[$i]["user_type"]);
            $users[$i]["password"] = "";
        }
        // echo Kohana::debug($count);
        if ($count > 0)
            return $data = array('result' => $users,);
        else
            return 'none';
    }

}

?>
