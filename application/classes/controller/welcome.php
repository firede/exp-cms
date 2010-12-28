<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller_Base {

    // 测试Smarty模板
    public function action_index() {

        if ($this->app_setup()) {

            return;
        }
        $conf = 'id,title';
        $conf_arr = explode(',', $conf);

        $this->template = View::factory('smarty:welcome/index');
        $this->template->conf = $conf;
        $this->template->prefix = array('admin/post/view/', '.html');
        $this->template->data = array(
            'id' => 15,
            'title' => '测试底层模板设计',
            'date' => time(),
            'flag' => array(
                '1' => '精华',
                '2' => '置顶'
            ),
        );

        if (isset($_GET) AND isset($_GET['id'])) {
            $id = (int) $_GET['id'];
        } else {
            $id = NULL;
        }
        $this->template->hello = ($id) ? '你GET的ID是' . $id : 'hello, world!';
    }

    /**     * *
     *  做安装程序的拦截处理
     */
    public function app_setup() {
        $app_conf = Kohana::config("applicationconfig");
        $status = $app_conf["app"]["setup"]["status"];
        if ($app_conf["app"]["setup"]["steps_page"][$status] !== TRUE) {
            $page = 'setup/' . $app_conf["app"]["setup"]["steps_page"][$status];
            $this->request->redirect($page);
            return TRUE;
        }
    }

}

// End Welcome
