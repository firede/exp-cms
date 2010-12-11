<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Upload extends Controller_BaseUser {

    public function action_toupload() {
        $this->template = View::factory('smarty:upload/uptest', array(
                ));
    }

    /*     * ******
     * 上传图片
     */

    public function action_up_img() {
        try {

            $file = $_FILES["file"];

            $model_upload = new Model_Upload();
            $model_upload->_up_img($file);
            //保存图片
        } catch (Exception $e) {

        }
    }

    /*     * *********
     * 文件上传
     */

    public function action_up_file() {
        try {
            $file = $_FILES["file"];

            $model_upload = new Model_Upload();
            $model_upload->_up_file($file);
        } catch (Exception $e) {

        }
    }

}

// End Welcome
