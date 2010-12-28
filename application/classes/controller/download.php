<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Upload extends Controller_BaseUser {

    public function action_toupload() {
        $this->template = View::factory('smarty:upload/uptest', array(
                ));
    }


    /*     * *********
     * 文件上传
     */

    public function action_download() {
       $file_name=$_GET["file_name"];
       //$this->request->
       

    }

}

// End Welcome
