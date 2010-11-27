<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author Administrator
 */
class Database_User {

    public function query_list($user, $pageParam) {
        $dao = Database::instance();
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
        $query = DB::select("user.*",array("admin.username","admin_name"))->from('user');
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

        if (!isset($pageParam["items_per_page"])) {
            $pageParam["items_per_page"] = 20;
        }
        //获取当前数据起始位置
        $current_item = $pageParam["items_per_page"] * ($pageParam["page"] - 1);
        $total_page_count = (int) ceil($count / $pageParam["items_per_page"]);
        $query->offset($current_item)->limit($current_item + $pageParam["items_per_page"]);
        $users = $query->execute();
        $users = $users->as_array();
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($users); $i++) {

            $users[$i]["status_name"] = Sysconfig_Business::adminUser_Status($users[$i]["status"]);
            $users[$i]["user_type_name"] = Sysconfig_Business::adminUser_user_type($users[$i]["user_type"]);
            
        }

        unset($dao, Database::$instances['default']);
        if ($count > 0)
            return array(
                'total_items_count' => $count, //总记录数
                'total_page_count' => $total_page_count,
                'items_per_page' => $pageParam["items_per_page"], //每页显示数据条数
                'result' => $users,
            );
        else
            return "none";
        unset($dao, Database::$instances['default']);
    }

    public function get_user($id) {
        $dao = Database::instance();
        
        unset($dao, Database::$instances['default']);
    }

    public function delete() {
        $dao = Database::instance();
        unset($dao, Database::$instances['default']);
    }

    public function modify() {
        $dao = Database::instance();
        unset($dao, Database::$instances['default']);
    }

    public function clear_avtar() {
        $dao = Database::instance();
        unset($dao, Database::$instances['default']);
    }

}

?>
