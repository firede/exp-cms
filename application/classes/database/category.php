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

    private function as_tree_array($categorys) {

        return $this->build_child("-1", $categorys, array());
    }

    private function build_child($parent_id, $categorys, $parent_childs) {
        //$temp = array();
        $childs = array();
        foreach ($categorys as $category) {

            if ($category["parent_id"] == $parent_id) {
                $child = array();
                $child = $category;

                //    $parent_childs=count($parent_childs<1)?$childs:$parent_childs;
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

    public function query_list($category, $sort) {
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
        if (isset($sort["order_by"]) && isset($sort["sort_type"])) {
            $query->order_by($sort["order_by"], $sort["sort_type"]);
        } else {
            $query->order_by("sort", "ASC");
        }
        $categorys = $query->execute();
        $categorys = $categorys->as_array();
        return $categorys;
    }

    public function set_config($category) {
        $categorys = $this->query_list($category, array());
        Arr::as_config_file($categorys,APPPATH."config/category.php");
        return Kohana::config("category");
       /// return $this->build_parent("-1",$categorys, array());
    }

    private function build_parent($parent_id,$categorys, $arr) {
        $count = 0;


        $childs = array();
        foreach ($categorys as $category) {
            
            if($category["id"]=="-1"){
                 $childs[$category["id"]][$count] = $child;
            }elseif ($category["id"] == $parent_id) {
             
                $child = $category["name"];
                echo $child;
                //    $parent_childs=count($parent_childs<1)?$childs:$parent_childs;
                $child = $this->build_parent($category["parent_id"], $categorys, $child);
               
                $count++;
            } else {
                continue;
            }
        }
        $arr = $childs;
        return $arr;
        
        
    }

}

?>
