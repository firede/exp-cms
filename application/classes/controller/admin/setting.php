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

        $view = View::factory('smarty:admin/setting/site', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_site", $view);
	}

    /**     * *
     * 更新网站配置
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
                array('webname', "basehost", "indexurl", 'default_style', 'powerby', 'keywords', 'description', 'beian');
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $setting_db->update_configs($setting);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 更新缓存配置(GET)
	 */
	public function action_cache() {
        $form = Kohana::config('admin_setting_form.cache');

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
            $view = View::factory('smarty:admin/setting/cache', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('setting_cache_post', $view);
            return;
        }
        $setting_db = new Database_Setting();
        $arr_element_names = array('driver', "is_open",);
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $setting_db->update_configs($setting, "cache");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 上传图片配置(GET)
	 */
	public function action_up_img() {
        $form = Kohana::config('admin_setting_form.up_img');

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
        $view_data = $setting_db->update_configs($setting, "up_img");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 上传文件配置(GET)
	 */
	public function action_up_file() {
        $form = Kohana::config('admin_setting_form.up_file');

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
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

	/**
	 * 用户配置(GET)
	 */
	public function action_user() {
        $form = Kohana::config('admin_setting_form.user');

        $view = View::factory('smarty:admin/setting/user', array(
                    'form' => $form,
                ));

        $this->template = AppCache::app_cache("setting_user", $view);
	}

    /**     * *
     * 更新用户相关配置
     */
    public function action_user_post() {
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
        $arr_element_names = array("reg_open", "default_avatar");
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $setting_db->update_configs($setting, "user");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
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
        $arr_element_names = array('title_repeat');
        $setting = Arr::filter_Array($_POST, $arr_element_names);
        $view_data = $setting_db->update_configs($setting, "post");
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
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
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

}