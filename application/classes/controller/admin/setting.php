<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Setting extends Controller_Admin_BaseAdmin {

 
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