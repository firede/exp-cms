<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Post extends Controller {

    public function action_index() {
        echo '1';
    }

    /*     * *********
     * 根据条件查询相应的post表数据
     */

    public function action_querylist() {
        $postDb = new Database_Post();
        echo Kohana::debug($postDb->query_list());
    }

    /*     * *********
     * 根据条件查询相应的post表数据
     */

    public function action_getpost($id) {
        $postDb = new Database_Post();
        echo Kohana::debug($postDb->getpost($id));
    }

    /*     * ***
     * 根据ID删除post表数据
     * @param $id integer
     */

    public function action_delete($id) {
        $postDb = new Database_Post();
        $postDb->delete($id);
    }

    /*     * ***
     * 根据多个ID，批量删除post表数据
     * @param $ids （array(integer)）
     */

    public function action_multi_delete($ids) {
        $postDb = new Database_Post();
        $postDb->multi_delete($ids);
    }
    public function action_modify(){
         $postDb = new Database_Post();
         echo $postDb->modify($_GET);
    }

}

?>