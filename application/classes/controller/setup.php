<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_setup extends Controller_Base {

    /**     * *
     * 打开安装页面
     */
    public function action_set_db() {
         $db_setup=new Database_Setup();
        echo Kohana::debug($db_setup-> check_component() );
        //跳转到修改页面
        $this->template = View::factory('smarty:setup/set_db', array());
    }

    /**     * *
     *设置数据库相关配置
     */
    public function action_set_db_post() {
        $db_setup=new Database_Setup();
        //$db_setup->set_db_conf(array());
        echo $db_setup->check_connection($_GET);
        
        //  $this->template = View::factory('smarty:setup/set_db', array());
    }

}

?>
