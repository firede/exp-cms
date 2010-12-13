<?php

/**
 * 内容分类数据操作类
 *
 * @author FanQie
 */
class Database_Category {

    /**     * ***
     * 创建一个新的用户数据 于category表里
     * @param $category array 用户对象的数据内容
     * @return string 直接返回执行情况消息
     */
    public function create($category) {
        $save = DB::insert("category", array());
        $save->values($category);
        $result = (bool) $save->execute();
        return $result ? "ok" : "error";
    }

    /**     * *
     * 获取符合条件的数据 并返回tree 格式的数据结构数组
     * @param $category array  对应category表列的筛选条件的多个参数
     * @param $sort array 排序规则
     * @return array/string 符合条件的category表数据以及其他参数
     * 有错误的情况下会直接返回消息 正常执行的状态下会封装在return array里返回
     */
    public function query_tree_array($category, $sort) {

        $categorys = $this->query_list($category, $sort);
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

    /**     * *****
     * 根据数据父子关系 构造一个树形分级数组
     */
    private function as_tree_array($categorys) {

        return $this->build_child("-1", $categorys, array());
    }

    private function build_child($parent_id, $categorys, $parent_childs) {
        $childs = array();
        foreach ($categorys as $category) {

            if ($category["parent_id"] == $parent_id) {
                $child = array();
                $child = $category;
                $child["child"] = $this->build_child($category["id"], $categorys, $parent_childs);
                $childs[$category["id"]] = $child;
            } else {
                continue;
            }
        }
        $parent_childs = $childs;
        return $parent_childs;
    }

    /**     * *
     * 获取符合条件的数据 
     * @param $category array  对应category表列的筛选条件的多个参数
     * @param $sort array 排序规则
     * @return array 符合条件的category表数据以及其他参数
     */
    public function query_list($category, $sort, $page_Param=NULL) {
        if ($page_Param != NULL) {
            return $this->query_list_page($category, $sort, $page_Param);
        }
        //设置查询数据的sql
        $query = DB::select("a.*", array("b.name", "parent_name"))->from(array("category", "a"));
        $query->join(array("category", "b"), "left")->on("b.id", "=", "a.parent_id");
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

        if (isset($sort["order_by"]) && isset($sort["sort_type"])) {
            $query->order_by($sort["order_by"], $sort["sort_type"]);
        } else {
            $query->order_by("sort", "ASC");
        }
        $categorys = $query->execute();
        $categorys = $categorys->as_array();
        $parent_ids = array();
        for ($f = 0; $f < count($categorys); $f++) {
            $parent_ids[$f] = $categorys[$f]["parent_id"];
        }
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($categorys); $i++) {
            if (in_array($categorys[$i]["id"], $parent_ids)) {
                $categorys[$i]["has_child"] = TRUE;
            } else {
                $categorys[$i]["has_child"] = FALSE;
            }
        }

        return $categorys;
    }

    /**     * *
     * 获取符合条件的数据 并进行分页
     * @param $category array  对应category表列的筛选条件的多个参数
     * @param $sort array 排序规则
     * @return array 符合条件的category表数据以及其他参数
     */
    public function query_list_page($category, $sort, $page_Param=NULL) {
        $query = DB::select(array('COUNT("id")', 'total_category'))->from('category');
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

        $count_Result = $query->execute()->as_array();
        $count = $count_Result[0]['total_category'];
        //设置查询数据的sql
        $query = DB::select("a.*", array("b.name", "parent_name"))->from(array("category", "a"));
        $query->join(array("category", "b"), "left")->on("b.id", "=", "a.parent_id");
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
        //添加分页
        if ($page_Param != NULL) {
            if (!isset($page_Param["items_per_page"])) {
                $page_Param["items_per_page"] = 20;
            }
            //获取当前数据起始位置
            $current_item = $page_Param["items_per_page"] * ($page_Param["page"] - 1);
            $total_page_count = (int) ceil($count / $page_Param["items_per_page"]);
            $query->offset($current_item)->limit($current_item + $page_Param["items_per_page"]);
        }
        if (isset($sort["order_by"]) && isset($sort["sort_type"])) {
            $query->order_by($sort["order_by"], $sort["sort_type"]);
        } else {
            $query->order_by("sort", "ASC");
        }
        $categorys = $query->execute();
        $categorys = $categorys->as_array();
        $parent_ids = array();
        for ($f = 0; $f < count($categorys); $f++) {
            $parent_ids[$f] = $categorys[$f]["parent_id"];
        }
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($categorys); $i++) {
            if (in_array($categorys[$i]["id"], $parent_ids)) {
                $categorys[$i]["has_child"] = TRUE;
            } else {
                $categorys[$i]["has_child"] = FALSE;
            }
        }
        if ($count > 0)
            return array(
                'total_items_count' => $count, //总记录数
                'total_page_count' => $total_page_count,
                'items_per_page' => $page_Param["items_per_page"], //每页显示数据条数
                'result' => $categorys,
            );
        else
            return "none";
    }

    public function set_config($category) {
        $categorys = $this->query_list($category, array());
        Arr::as_config_file($categorys, APPPATH . "config/category.php");
        return Kohana::config("category");
    }

    /**     * *
     * 通过分类ID获取 所有包含的上层目录名称
     */
    public function crumb($id) {

        $categorys = Kohana::config("category");
        if (count($categorys) == 0) {
            $this->set_config(array());
        }
        $parent_id = "";
        $arr = array();
        foreach ($categorys as $this_category) {
            if ($this_category["id"] == $id) {
                $parent_id = $this_category["id"];
            }
        }
        $crumbs = $this->build_crumbs($parent_id, $categorys, $arr);
        return $crumbs;
    }

    /**     *
     * 使用递归算法 从分类集合中取出符合
     */
    private function build_crumbs($parent_id, $categorys, $arr) {
        $crumbs = array();
        $count = 0;
        foreach ($categorys as $category) {
            $count++;
            if ($category["id"] == $parent_id) {
                $parent["id"] = $category["id"];
                $parent["name"] = $category["name"];
                $parent["parent_id"] = $category["parent_id"];
                $crumbs = $this->build_crumbs($category["parent_id"], $categorys, $parent);
                $crumbs[$count] = $parent;
            } else {
                continue;
            }
        }
        return $crumbs;
    }

    /**     * *******
     * 删除分类 支持批量删除 批量删除 用 ","分隔
     
    public function del($category) {
        try {
            if (isset($category["id"])) {
                return "no_id";
            }
            $id = $category["id"];
            $delete = DB::delete()->table("category");
            $modify->where("id", "in", $ids);
            $modify->execute();
            $this->set_config(array());
            return "ok";
        } catch (ErrorException $e) {
            return "error";
        }
    }*/

    /**     * **
     * 修改 一个或多个分类信息 批量删除 ID用“,”分隔
     */
    public function modify($category) {
        try {
            if (isset($category["id"])) {
                return "no_id";
            }
            $id = $category["id"];
            unset($category["id"]);
            $ids = explode(",", $category["id"]);
            $modify = DB::update()->table("category")->set($category);
            $modify->where("id", "in", $ids);
            $modify->execute();
            $this->set_config(array());
            return "ok";
       } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /**     * **
     * 添加一个新的 分类信息
     * @$category 分类信息封装对象 与 数据库category表字段完全对应
     */
    public function save($category) {
        try {
            $save = DB::insert("category", array("id", "name", "short_name", "parent_id", "sort"));
            $save->values($category);
            $save->execute();
            $this->set_config(array());
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /**     * ***
     * 检测该分类名称是否已经存在
     * @param $category array 分类信息
     * @return bool 存在返回FALSE 不存在返回TRUE
     */
    public function check_exist($category) {
        //设置查询数据的sql
        $query = DB::select(array('COUNT("id")', 'total_name'))->from('category');
        $query->where("name", "=", $category["name"]);
        $categorys = $query->execute();
        $categorys = $categorys->as_array();
        $count = $categorys[0]["total_name"];
        return $count > 0 ? FALSE : TRUE; //存在的话返回FALSE 不存在返回True
    }

    /**     * ********
     * 转移一到多个分类的所有子分类到指定分类下
     * @param array/integer $id 需要转移的分类ID  多个分类ID使用“,”分隔
     * @param integer 将子分类移动至指定的分类中
     * @return string 返回执行结果
     */
    public function move_child($old_parent_id, $new_parent_id) {
        try {
            if (!isset($old_parent_id) || !isset($new_parent_id)) {
                return "no_id";
            }
            $ids = explode(",", $old_parent_id);
            $move = DB::update("category");
            $move->set(array("parent_id" => $new_parent_id));
            $move->where("parent_id", "in", $ids);
            $move->execute();
            return "ok";
      } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /**     * ******
     * 删除分类
     * @param $move_relevance bool 是否删除与该分类相关的信息
     * @param $new_parent_id  integer 把子分类转移至新的分类的子分类的id
     * @param $move_child bool 设置是否将原有子分类转移至新的分类的子分类里
     */
    public function del($id, $move_relevance=FALSE, $new_child_parent=NULL, $move_child=FALSE) {
        DB::query(NULL, "BEGIN WORK")->execute(); //开启事务
        try {
            $del = DB::delete()->table("category");
            $ids = explode(",", $id);
            $del->where("id", "in", $ids);
            $del->execute();
            //删除与该分类相关的文章内容
            if ($move_relevance) {
                $del_post = DB::delete()->table("category");
                $del_post->where("id", "in", $ids);
                $del_post->execute();
            }
            //转移子分类到新的分类的子分类里
            if ($move_child && $new_child_parent != NULL) {
                $this->move_child($id, $new_child_parent);
            }
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            DB::query(NULL, "ROLLBACK")->execute();
            return "error";
        }
    }

    /**     *
     * 删除清空指定分类的所有信息包括相关文章
     * @param $category array 必须包含有 $category["id"]
     * @param $include_oneself bool 同时删除并清空自己相关的数据 TRUE 包含|FALSE 不包含
     * @return string
     */
    public function del_clear_child($category, $include_oneself=FALSE) {
        DB::query(NULL, "BEGIN WORK")->execute(); //开启事务
        try {


            $categorys = Kohana::config("category");
            if (count($categorys) == 0) {
                $this->set_config(array());
            }
            $category_child_lists = $this->build_child_list($category["id"], $categorys, array());
            $clear_cate = DB::delete("category");
            $clear_post = DB::delete("post");
            $where_id = array();
            $count = 0;
            foreach ($category_child_lists as $key => $row) {
                $where_id[$count++] = $row["id"];
            }
            if ($include_oneself) {
                $where_id[$count++] = $category["id"];
            }
            $clear_cate->where("id", "in", $where_id);
            $clear_post->where("cate_id", "in", $where_id);

            $clear_cate->execute();
            $clear_post->execute();
            DB::query(NULL, "COMMIT")->execute();
            return "ok";
     } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            DB::query(NULL, "ROLLBACK")->execute();
            return "error";
        }
    }

    /**     *
     * 使用递归算法 从分类集合中取出所有子分类的列表呈现形式
     */
    private function build_child_list($parent_id, $categorys, $arr=array()) {
        $childs = array();
        $childs_node = array();

        foreach ($categorys as $category) {

            if ($category["parent_id"] == $parent_id) {
                $child = array();
                $child = $category;
                $child = $this->build_child_list($category["id"], $categorys, $arr);
                $childs_node[$category["id"]]["id"] = $category["id"];
                $childs_node[$category["id"]]["name"] = $category["name"];
                $childs_node[$category["id"]]["short_name"] = $category["short_name"];
                $childs_node[$category["id"]]["parent_id"] = $category["parent_id"];
                $childs_node = array_merge($child, $childs_node);
            } else {
                continue;
            }
        }
        return $childs_node;
    }

}

?>
