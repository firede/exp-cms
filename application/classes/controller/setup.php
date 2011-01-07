<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_setup extends Controller_Base {

    /**     * *
     * 打开安装页面
     */
    public function action_set_db() {
        $db_setup = new Database_Setup();
        $form = Kohana::config("setup_form");
        $form = $db_setup->check_db_component($form);

        //跳转到修改页面
        $view = View::factory('smarty:setup/set_db', array(
                    'form' => $form['set_db'],
                    'data' => array('message' => "",),
                        )
        );
        $this->template = AppCache::app_cache('setup_set_db', $view);
    }

    /**     * *
     * 设置数据库相关配置
     */
    public function action_set_db_post() {
        $m_setup = new Model_Setup();

        $validate_result = $m_setup->_db_post_validate($_POST);
        if (isset($validate_result["success"])) {
            $db_setup = new Database_Setup();
            $validate_result["data"] = $db_setup->check_db_component($validate_result["data"]);
            $data['data']['message'] = "";
            $view = View::factory('smarty:setup/set_db', array(
                        'form' => $validate_result["data"]['set_db'],
                    ));
            $this->template = AppCache::app_cache('setup_set_db_post_error', $view);
            return;
        }
        $db_setup = new Database_Setup();

        $view_data = $db_setup->set_db_conf($_POST);
        if ($view_data) {
            $data['data'] = $view_data;
            $data['data'] = Action::sucess_status($data['data'], "数据库创建");
        } else {
            $data['data']['message'] = "";
        }
     
        $this->set_status(1);
        $form = Kohana::config("setup_form");
        $form = $m_setup->check_cache_component($form);
        $data['form'] = $form['set_cache'];
        $view = View::factory('smarty:setup/set_cache', $data);
        $this->template = AppCache::app_cache('setup_set_cache', $view);
    }

    /**     *
     * 跳转至设置缓存页面
     */
    public function action_set_cache() {
        $cache_setup = new Model_Setup();
        $form = Kohana::config("setup_form");
        $form = $cache_setup->check_cache_component($form);
        $data['form'] = $form['set_cache'];
        $data["data"]['message'] = "";
        $view = View::factory('smarty:setup/set_cache', $data);
        $this->template = AppCache::app_cache('setup_set_cache', $view);
    }

    /**     * *
     * 设置缓存
     * @return <type>
     */
    public function action_set_cache_post() {
        $m_setup = new Model_Setup();
        $validate_result = $m_setup->_cache_post_validate($_POST);
        if (isset($validate_result["success"])) {
            $data['form'] = $validate_result["data"]['set_cache'];
            $data['data']['message'] = "";
            $view = View::factory('smarty:setup/set_cache', $data);
            $this->template = AppCache::app_cache('setup_set_cache_post_error', $view);
            return;
        }
        $view_data = $m_setup->set_cache($_POST);
    
        if ($view_data) {
            $data['data'] = $view_data;
            $data['data'] = Action::sucess_status($data['data'], "缓存设置");
        } else {
            $data['data']['message'] = "";
        }
        $this->set_status(2);
        $data['form'] = Kohana::config('admin_admin_form');

        $view = View::factory('smarty:setup/set_admin', $data);


        $this->template = AppCache::app_cache('setup_set_admin', $view);
    }

    /**     * *
     * 跳转至设置管理员帐号密码页面
     */
    public function action_set_admin() {

        $form = Kohana::config('admin_admin_form.default');
       
        $view = View::factory('smarty:setup/set_admin', array(
                    'form' => $form,
                    'data' => array('message' => "",),
                ));

        $this->template = AppCache::app_cache('setup_set_admin', $view);
    }

    /**     * *
     * 设置管理员帐号密码
     */
    public function action_set_admin_post() {

         $m_admin = new Model_Admin();
        $form = Kohana::config('admin_admin_form.default');
        $function_config = Kohana::config('admin_admin_form.function_config.default.create');
        $legal_fileds = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER);
        $form = Action::form_decorate($form, $function_config);
        $validate_result = $m_admin->post_validate($_POST, $form, $legal_fileds);
        if (isset($validate_result["success"])) {
            $data['data']['message'] = "";
            $view = View::factory('smarty:setup/set_admin', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setup_set_admin', $view);
            return;
        }
        $adminDb = new Database_Admin();
        $arr_element_names = array('username', 'password', 'role');

        $admin = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $adminDb->create($admin);
        $view_data = Action::sucess_status($view_data);
      
        $this->set_status(3);
        if ($view_data) {
            $data['data'] = $view_data;
            $data['data'] = Action::sucess_status($data['data'], "管理员设置");
            $data['data']['message'] = "恭喜您系统安装成功<br/>点击完成跳转到首页";
        } else {
            $data['data']['message'] = "";
        }
        $view = View::factory('smarty:setup/finish', $data);
        $this->template = AppCache::app_cache('setup_finish_post', $view);
    }

    /**     * *
     * 转向恭喜完成页面操作
     */
    public function action_finish() {
        $view = View::factory('smarty:setup/finish',
                array('data' => array('message' => "恭喜您系统安装成功<br/>点击完成跳转到首页",),
                ));

        $this->template = AppCache::app_cache('setup_finish', $view);
    }

    /**     * *
     * 转向恭喜完成页面操作
     */
    public function action_finish_post() {
        $this->set_status(4);
        
        $this->request->redirect("");
    }

    public function set_status($status) {
        $app_conf = Kohana::config("applicationconfig");
        $app_conf["app"]["setup.status"] = $status;
        Arr::as_config_file($app_conf, APPPATH . "/config/applicationconfig.php");
    }

}

?>
