<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Setting extends Controller_Admin_BaseAdmin {

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

    /**     * ***
     * 将数据库中的配置 放入缓存中
     */
    public function action_db_to_cache() {

        $set_Db = new Database_Setting();
        $set_Db->db_to_cache();
    }

    /**
     * 更新网站配置(GET)
     */
    public function action_site() {
        $form = Kohana::config('admin_setting_form.site');
        $setting_db = new Database_Setting();
        $data_arr = $setting_db->get_configs();
        $form = Action::build_form_data($form, $data_arr["result"]['site']);
        $view = View::factory('smarty:admin/setting/site', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_site", $view);
    }

    /**     * *
     * 更新网站配置是
     */
    public function action_site_post() {
        $m_setting = new Model_Setting();
        $validate_result = $m_setting->site_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/setting/site', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setting_site_post', $view);
            return;
        }
        $setting_db = new Database_Setting();
        $arr_element_names =
                array('webname', "basehost", "indexurl", 'default_style', 'copyright', 'keywords', 'description', 'beian');
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $setting_db->update_configs($setting);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('smarty:system/redirect');
        if ($view_data["success"]) {
            $this->template->next_page = "admin/setting/site";
        }
        $this->template->view_data = $view_data;
    }

    /**
     * 更新缓存配置(GET)
     */
    public function action_cache() {
        $m_set = new Model_Setting();
        $form = Kohana::config('admin_setting_form.cache');
        $form = $m_set->check_cache_component($form);
        $setting_db = new Database_Setting();

        $data_arr = $setting_db->get_configs('cache');
        $form = Action::build_form_data($form, $data_arr["result"]['cache']);
        $view = View::factory('smarty:admin/setting/cache', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_cache", $view);
    }

    /**     * *
     * 更新缓存配置
     */
    public function action_cache_post() {
        $m_setting = new Model_Setting();
        $validate_result = $m_setting->cache_validate($_POST);
        if (isset($validate_result["success"])) {
            $m_setting = new Model_Setting();
            $validate_result = $m_setting->check_cache_component($validate_result);
            $view = View::factory('smarty:admin/setting/cache', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setting_cache_post', $view);
            return;
        }
        $setting_db = new Database_Setting();
        $arr_element_names = array('driver', "is_open",);
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $setting["is_open"] = (bool) $setting["is_open"];

        $view_data = $setting_db->update_configs($setting, "cache");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('smarty:system/redirect');
        if ($view_data["success"]) {
            $this->template->next_page = "admin/setting/cache";
        }
        $this->template->view_data = $view_data;
    }

    /**
     * 上传图片配置(GET)
     */
    public function action_up_img() {
        $form = Kohana::config('admin_setting_form.up_img');
        $setting_db = new Database_Setting();
        $data_arr = $setting_db->get_configs('up_img');
        $form = Action::build_form_data($form, $data_arr["result"]['up_img']);
        $view = View::factory('smarty:admin/setting/up_img', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_up_img", $view);
    }

    /**     * *
     * 更新上传图片配置
     */
    public function action_up_img_post() {
        $m_setting = new Model_Setting();
        $validate_result = $m_setting->up_img_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/setting/up_img', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setting_up_img_post', $view);
            return;
        }
        $setting_db = new Database_Setting();
        $arr_element_names = array("dir", "max_size", "min_size", "max_width", "max_height", "type", "watermark_path", "watermark_position", "watermark_opacity", "watermark_status", "watermark_border_space",);
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $setting["watermark_status"] = (bool) $setting["watermark_status"];
        $view_data = $setting_db->update_configs($setting, "up_img");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('smarty:system/redirect');
        if ($view_data["success"]) {
            $this->template->next_page = "admin/setting/up_img";
        }
        $this->template->view_data = $view_data;
    }

    /**
     * 上传文件配置(GET)
     */
    public function action_up_file() {
        $form = Kohana::config('admin_setting_form.up_file');
        $setting_db = new Database_Setting();
        $data_arr = $setting_db->get_configs('up_file');
        $form = Action::build_form_data($form, $data_arr["result"]['up_file']);
        $view = View::factory('smarty:admin/setting/up_file', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_up_file", $view);
    }

    /**     * *
     * 更新上传文件配置
     */
    public function action_up_file_post() {
        $m_setting = new Model_Setting();
        $validate_result = $m_setting->up_file_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/setting/up_file', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setting_up_file_post', $view);
            return;
        }
        $setting_db = new Database_Setting();
        $arr_element_names = array("dir", "max_size", "min_size", "type");
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $setting_db->update_configs($setting, "up_file");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('smarty:system/redirect');
        if ($view_data["success"]) {
            $this->template->next_page = "admin/setting/up_file";
        }
        $this->template->view_data = $view_data;
    }

    /**
     * 用户配置(GET)
     */
    public function action_user() {
        $form = Kohana::config('admin_setting_form.user');
        $setting_db = new Database_Setting();
        $data_arr = $setting_db->get_configs('user');
        $form = Action::build_form_data($form, $data_arr["result"]['user']);
        $view = View::factory('smarty:admin/setting/user', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_user", $view);
    }

    /**     * *
     * 更新用户相关配置
     */
    public function action_user_post() {

        foreach ($_POST as $key => $value) {
            unset($_POST[$key]);
            $_POST[str_replace("up_avatar_", "up_avatar.", $key)] = $value;
        }

        $m_setting = new Model_Setting();
        $validate_result = $m_setting->user_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/setting/up_file', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setting_user_post', $view);
            return;
        }

        $setting_db = new Database_Setting();
        $arr_element_names = array("reg_open", "default_avatar", 'up_avatar.path', 'up_avatar.max_size', 'up_avatar.min_size', 'up_avatar.max_width', 'up_avatar.max_height', 'up_avatar.type', 'up_avatar.watermark_path', 'up_avatar.watermark_position', 'up_avatar.watermark_opacity', 'up_avatar.watermark_status', 'up_avatar.watermark_border_space');
        $setting = Arr::filter_Array($_POST, $arr_element_names);

        $setting["reg_open"] = (bool) $setting["reg_open"];
        $setting["up_avatar.watermark_status"] = (bool) $setting["up_avatar.watermark_status"];

        $view_data = $setting_db->update_configs($setting, "user");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('smarty:system/redirect');
        if ($view_data["success"]) {
            $this->template->next_page = "admin/setting/user";
        }
        $this->template->view_data = $view_data;
    }

    /**

     * 文章配置(GET)
     */
    public function action_post() {
        $form = Kohana::config('admin_setting_form.post');
        $setting_db = new Database_Setting();
        $data_arr = $setting_db->get_configs('post');
        $form = Action::build_form_data($form, $data_arr["result"]['post']);
        $view = View::factory('smarty:admin/setting/post', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_post", $view);
    }

    /**     * *
     * 更新文章相关配置
     */
    public function action_post_post() {
        $m_setting = new Model_Setting();
        $validate_result = $m_setting->post_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/setting/post', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setting_post_post', $view);
            return;
        }
        $setting_db = new Database_Setting();
        $arr_element_names = array('title_repeat', 'retrial');
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $setting["title_repeat"] = (bool) $setting["title_repeat"];
        $setting["retrial"] = (bool) $setting["retrial"];
        $view_data = $setting_db->update_configs($setting, "post");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('smarty:system/redirect');
        if ($view_data["success"]) {
            $this->template->next_page = "admin/setting/post";
        }
        $this->template->view_data = $view_data;
    }

    /**
     * 高级选项配置(GET)
     */
    public function action_advanced() {
        $form = Kohana::config('admin_setting_form.advanced');
        $setting_db = new Database_Setting();
        $data_arr = $setting_db->get_configs('advanced');
        $form = Action::build_form_data($form, $data_arr["result"]['advanced']);
        $view = View::factory('smarty:admin/setting/advanced', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_advanced", $view);
    }

    /**     * *
     * 更新高级选项相关配置
     */
    public function action_advanced_post() {
        $m_setting = new Model_Setting();
        $validate_result = $m_setting->advanced_validate($_POST);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/setting/advanced', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setting_advanced_post', $view);
            return;
        }
        $setting_db = new Database_Setting();
        $arr_element_names = array('throw_exception');
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $setting_db->update_configs($setting, "advanced");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('smarty:system/redirect');
        if ($view_data["success"]) {
            $this->template->next_page = "admin/setting/advanced";
        }
        $this->template->view_data = $view_data;
    }

}