<?php

defined('SYSPATH') or die('No direct script access.');

class Database_Post {
    /*     * ***
     * 根据条件查询相应的post表数据
     *
     * return post信息+分页信息
     */

    public function query_list() {
        $dao = Database::instance();
        $query = DB::select()->from('post')->offset('0')->limit('10')->where('title', 'like', '%post%');
        $posts = $query->execute();
        $posts = $posts->as_array();
        $count = count($posts);
        unset($dao, Database::$instances['default']);
        if ($count > 0)
            return $data = array(
        'count' => $count,
        'result' => $posts,
            );
        else
            '没有任何数据';
    }

    /*     * *
     *根据参数$id 查询指定的post表行数据
     * @param $id integer
     */
    public function getpost($id) {
        if ($id == null) { return "没有指定数据";}
           $dao = Database::instance();
        $query = DB::select()->from('post')->where('id', '=', $id);
        $posts = $query->execute();
        $posts = $posts->as_array();
        $count = count($posts);
        unset($dao, Database::$instances['default']);
        if ($posts>0)
            return $data = array(  'result' => $posts,   );
        else
            '没有任何数据';
    }

    /*     * ***
     * 根据ID删除post表数据
     * @param $id integer 
     */

    public function delete($id) {
        if ($id == null) { return '没有指定数据'; }
         $dao = Database::instance();
        $delete = DB::delete()->table('post')->where('id', '=', $id);
        $count = count($delete->execute()->as_array());
         unset($dao, Database::$instances['default']);
        return $count == 0 ? '删除失败' : 'ok';
    }

    /*     * ***
     * 根据多个ID，批量删除post表数据
     * @param $ids （array(integer)）
     */

    public function multi_delete($ids) {
        if ($ids == null || count($ids) == 0) {
            return '没有指定数据';
        }
         $dao = Database::instance();
        $delete = DB::delete()->table('post')->where('id', 'in', $ids);
        $count = $delete->execute();
         unset($dao, Database::$instances['default']);
        return $count == 0 ? '删除失败' : 'ok';
    }

    /*     * ***
     * 根据ID，修改post表行数据
     * @param $id （array(integer)）
     */

    public function modify($post) {
        if ($post == null||count($post)==0||$post['id']==null) {

            return '没有指定数据';
        }
         //echo Text::uuid();
        $dao = Database::instance();
        $modify = DB::update()->table('post')->set($post)->where('id', '=', $post['id']);

        $count=$modify->execute();
        echo Kohana::debug($modify);

        unset($dao, Database::$instances['default']);
        return $count == 0 ? '修改失败' : 'ok';
    }

}

?>
