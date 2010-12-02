<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Upload extends Controller_BaseUser {

    public function action_toupload() {
        $this->template = View::factory('smarty:upload/uptest', array(
                ));
    }

    /*     * *
     * 图片上传配置参数
     */

    public static $IMG_DIR = "C://"; //图片上传的总路径
    public static $IMG_MAX_SIZE = 1048; //图片大小最大值 单位kb
    public static $IMG_MAX_WIDTH = 2048; //图片宽度最大值 单位px
    public static $IMG_MAX_HEIGHT = 2048; //图片高度最大值 单位px
    public static $IMG_TYPE = "jpg,jpeg,png,bmp,gif"; //允许上传的图片类型，多个用“,”分隔
    public static $IMG_WATERMARK_PATH = "c://LOGO.img"; //图片水印路径
    public static $IMG_WATERMARK_POSITION = "1"; //图片水印位置 1上左 |2上中|3上右|4中左 |5中中|6中右|7下左 |8下中|9下右
    public static $IMG_WATERMARK_DIAPHA = "c://LOGO.img"; //图片水印透明度
    public static $IMG_WATERMARK_STATUS = FALSE; //是否使用图片水印 TRUE使用 FALSE不使用
    /*     * **
     * 文件上传配置参数
     */
    public static $FILE_DIR = "C://"; //文件上传的总路径
    public static $FILE_MAX_SIZE = 2048; //图片上传的总路径 单位kb
    public static $FILE_TYPE = "jpg,jpeg,png,bmp,gif,rar,txt,doc,pdf,xml,7zip,zip,"; //允许上传的文件类型，多个用“,”分隔

    public function action_up_img() {
        
        //  echo Kohana::debug($_FILES);
        $file = $_FILES["file"];
        $son_path = ""; //这个 是通过日期生成的
        //判断图片是否合法
        $img_types = explode("/", $file["type"]);

        if ($img_types[0] != "image") {
            "error:该文件类型不正确";
        }

        if (($file["size"] / 1024) > Controller_Upload::$IMG_MAX_SIZE) {

            "error:该文件过大，上传文件不能超过" . (string) (Controller_Upload::$IMG_MAX_SIZE) . "KB";
        }

        $name = (explode(".", $file["name"]));
        echo Kohana::debug($name);
        $type=$img_types[1];
        switch ($img_types[1]) {
            case "x-png":
                $type = "png";
                break;
            case "pjpeg":
                $type = "jpg";
                break;
        }
        Controller_Upload::$IMG_DIR=APPPATH;
        $img_name = "test" . "." . $type; //新的文件名
        $upload_path = Controller_Upload::$IMG_DIR . $son_path;
       
        $url = $upload_path . "" . $img_name;
        ECHO $url;
        Upload::save($_FILES["file"], $img_name, $upload_path, "777"); //上传


        $img_File = Image::factory($url);
       echo Kohana::debug($img_File);
        $img_File->resize(Controller_Upload::$IMG_MAX_WIDTH, Controller_Upload::$IMG_MAX_HEIGHT,Image::AUTO);
       // $img_File->resize(10,NULL);
        //$img_File->save($url);
        echo Kohana::debug($img_File);
    }

    public function action_up_file() {
        
    }

}

// End Welcome
