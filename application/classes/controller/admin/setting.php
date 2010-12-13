<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Setting extends Controller_Admin_BaseAdmin {

    public function action_system() {
        $form = Kohana::config('admin_setting_form.system');

        $view = View::factory('smarty:admin/setting/system', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_system", $view);
    }

    public function action_query_list() {
        
    }

    public function action_test() {
        $arr = Kohana::config("cache");

        Arr::as_config_file($arr, APPPATH . "config/test.php");
    }

    public function action_delete() {

    }

    public function action_mulit_delete() {
        
    }
    /**     * **
     * 将缓存中的数据放入数据库里
     * @return string ok|error
     */
    public function action_cache_to_db() {

        $set_Db = new Database_Setting();
        $set_Db->cache_to_db();
    }

    /** ****
     * 将数据库中的配置 放入缓存中
     */
    public function action_db_to_cache() {

        $set_Db = new Database_Setting();
        $set_Db->db_to_cache();
    }

}