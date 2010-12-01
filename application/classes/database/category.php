<?php

/**
 * 内容分类数据操作类
 *
 * @author FanQie
 */
class Database_Category {
    /*     * ****
     * 创建一个新的用户数据 于category表里
     * @$category <array> 用户对象的数据内容
     * @return message <string> 直接返回执行情况消息
     */

    public function create($category) {
        $save = DB::insert("category", array());
        $save->values($category);
        $result = (bool) $save->execute();
        return $result ? "ok" : "error";
    }

    /*     * **
     * 获取符合条件的数据 并返回tree 格式的数据结构数组
     * @$category <array>  对应category表列的筛选条件的多个参数
     * @return <array> 符合条件的category表数据以及其他参数
     * @return message <string> 有错误的情况下会直接返回消息 正常执行的状态下会封装在return array里返回
     */

    public function query_list($category) {
        //设置查询数据的sql
        $query = DB::select("category.*")->from('category');
        foreach ($category as $filedName => $filedvalue) {
            if (isset($filedvalue))
                if ($filedvalue != null) {
                    if ($filedName == "parent_id") {
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

        $categorys = $query->execute();
        $categorys = $categorys->as_array();
        //加入一些业务值，特殊业务值的替换或者加入
        //
        $categorys = $this->as_tree_array($categorys);

        if (count($categorys) > 0)
            return array(
                'result' => $categorys,
            );
        else
            return "none";
    }

    private $cate_tree = array();

    private function as_tree_array($categorys) {

        $this->build_child("-1", $categorys);
        return $categorys = $this->cate_tree;
    }

    private function build_child($parent_id, $categorys, $cate_tree_now) {
        foreach ($categorys as $category) {
            if ($category["parent_id"] == $parent_id) {

                $cate_tree_now = $this->cate_tree[$category["parent_id"]][$category["id"]] = $category;
                $this->build_child($category["id"], $categorys, $cate_tree_now);
            } else {
                continue;
            }
        }
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

    /*     * ***
     * 删除指定用户
     * @$id <int> 用户id
     * @return message <string> 直接返回执行情况消息
     */

    public function delete($id) {
        if (!isset($id)) {
            return "no_id";
        }
        //设置删除数据的sql
        $delete = DB::delete()->table('user');
        $delete->where("id", "=", $id);
        $result = (bool) $delete->execute();
        return $result ? "ok" : "error";
    }

    /*     * ***
     * 批量删除指定用户
     * @$id <int> 一个或多个用户id 多个id 使用“，”分隔
     * @return message <string> 直接返回执行情况消息
     */

    public function mulit_delete($id) {
        if (!isset($id)) {
            return "no_id";
        }
        /* 根据需要从请求中取出需要的数据值 */
        $ids = explode(",", $post['id']);
        //设置删除数据的sql
        $delete = DB::delete()->table('user');
        $delete->where('id', 'in', $ids);
        $result = (bool) $delete->execute();
        return $result ? "ok" : "error";
    }

    /*     * ***
     * 修改用户的信息
     * @$user <array> 用户需要修改信息的多个参数封装 与数据库表结构应该相符  $user->id 字段为必须
     * @return message <string> 直接返回执行情况消息
     */

    public function modify($user) {
        if ($user == null || count($user) == 0 || $user['id'] == null) {
            return 'no_id';
        }
        $id = $user['id'];
        //设置删除数据的sql
        $modify = DB::update()->table("user");
        $modify->set($user);
        $modify->where("id", "=", $id);
        $result = (bool) $modify->execute();
        return $result ? "ok" : "error";
    }

    /*     * ***
     * 批量修改用户的信息
     * @$user <array> 用户需要修改信息的多个参数封装 与数据库表结构应该相符 $user->id 字段如果
     * 有多个则用“,”分隔 ,$user->id为必须字段，每次至少有一个user被执行
     * @return message <string> 直接返回执行情况消息
     */

    public function mulit_modify($user) {
        if (!isset($id)) {
            return "no_id";
        }
        //设置删除数据的sql
        $modify = DB::update()->table("user");
        $modify->set($user);
        /* 根据需要从请求中取出需要的数据值 */
        $ids = explode(",", $post['id']);
        $modify->where("id", "in", $id);
        $result = (bool) $modify->execute();
        return $result ? "ok" : "error";
    }

    /*     * ***
     * 清除用户图像
     * @$user->id user对象必须包含中必须包含用户id
     * @return message <string> 直接返回执行情况消息
     */

    public function clear_avtar($user) {
        if (!isset($user['id'])) {
            return "no_id";
        }
        $user["avtar"] = "";
        //设置删除数据的sql
        $modify = DB::update()->table("user");
        $modify->set($user);
        $modify->where("id", "=", $id);
        $result = (bool) $modify->execute();
        return $result ? "ok" : "error";
    }

    /*     * ****
     * 检测该用户是否已经存在
     * @$user <array> 用户信息
     * @return 存在返回exist 不存在返回ok
     */

    public function check_exist($user) {
        //设置查询数据的sql
        $query = DB::select(array('COUNT("id")', 'total_user'))->from('user');
        $query->where("username", "=", $user["username"]);
        $users = $query->execute();
        $users = $users->as_array();
        $count = $users[0]["total_user"];
        $count > 0 ? "exist" : "ok"; //存在的话返回error 不存在返回ok
    }

}

?>
