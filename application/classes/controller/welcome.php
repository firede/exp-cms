<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_BaseUser {

    // 测试Smarty模板
    public function action_index() {
     
        if ($this->app_setup()) {
            return;
        }
		
        $this->template = View::factory('smarty:post/list',NULL, $this->_enable_themes);
    }

    /**     * *
     *  做安装程序的拦截处理
     */
    public function app_setup() {
        $app_conf = Kohana::config("applicationconfig");
        $status = $app_conf["app"]["setup.status"];
        $steps=explode(",", $app_conf["app"]["setup.steps_page"]);
        if ($steps[$status] != TRUE) {
            $page = 'setup/' . $steps[$status];
            $this->request->redirect($page);
            return TRUE;
        }
    }

}

// End Welcome
