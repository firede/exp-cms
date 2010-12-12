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
     * @$sort <array> 排序规则
     * @return <array> 符合条件的category表数据以及其他参数
     * @return message <string> 有错误的情况下会直接返回消息 正常执行的状态下会封装在return array里返回
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

    /*     * ******
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

    /*     * **
     * 获取符合条件的数据 
     * @$category <array>  对应category表列的筛选条件的多个参数
     * @$sort <array> 排序规则
     * @return <array> 符合条件的category表数据以及其他参数
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
      /*    $conf = Kohana::config("applicationconfig");
        //加入一些业务值，特殊业务值的替换或者加入
        for ($i = 0; $i < count($categorys); $i++) {
            if ($categorys[$i]["parent_name"] == "" || $categorys[$i]["parent_name"] == NULL) {//如果没有设置图像则使用默认图像
                $categorys[$i]["parent_name"] =$conf["site"]["category_root_name"];
            }
        }*/
       
        return $categorys;
    }

    /*     * **
     * 获取符合条件的数据 并进行分页
     * @$category <array>  对应category表列的筛选条件的多个参数
     * @$sort <array> 排序规则
     * @return <array> 符合条件的category表数据以及其他参数
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
           //加入一些业务值，特殊业务值的替换或者加入
     /*  $conf = Kohana::config("applicationconfig");
      for ($i = 0; $i < count($categorys); $i++) {
            if ($categorys[$i]["parent_name"] == "" || $categorys[$i]["parent_name"] == NULL) {//如果没有设置图像则使用默认图像
                $categorys[$i]["parent_name"] =$conf["site"]["category_root_name"];
            }
        }*/

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

    /*     * **
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

    /*     * *
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

    /*     * ********
     * 删除分类 支持批量删除 批量删除 用 ","分隔
     */

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
        } catch (Exception $e) {
            return "error";
        }
    }

    /*     * ***
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
            return "error";
        }
    }

    /*     * ***
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
        } catch (exception $e) {
            return "error";
        }
    }

}

?>
