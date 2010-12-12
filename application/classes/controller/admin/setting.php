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
        $arr=Kohana::config("cache");
     
        Arr::as_config_file($arr, APPPATH."config/test.php");
    }
    public function action_delete() {

    }

    public function action_mulit_delete() {
        
    }

}