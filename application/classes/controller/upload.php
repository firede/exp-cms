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
    public static $IMG_MAX_WIDTH = 1048; //图片宽度最大值 单位px
    public static $IMG_MAX_HEIGHT = 768; //图片高度最大值 单位px
    public static $IMG_TYPE = "jpg,jpeg,png,bmp,gif"; //允许上传的图片类型，多个用“,”分隔
    public static $IMG_WATERMARK_PATH = "D:\project\exp-cms\assets\admin\img\logo.png"; //图片水印路径
    public static $IMG_WATERMARK_POSITION = 9; //图片水印位置 1上左 |2上中|3上右|4中左 |5中中|6中右|7下左 |8下中|9下右
    public static $IMG_WATERMARK_OPACITY = 70; //图片水印透明度
    public static $IMG_WATERMARK_STATUS = TRUE; //是否使用图片水印 TRUE使用 FALSE不使用
    public static $IMG_WATERMARK_BORDER_SPACE = 10; //水印与边框距离 单位：px
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
    
        $type = $img_types[1];
        switch ($img_types[1]) {
            case "x-png":
                $type = "png";
                break;
            case "pjpeg":
                $type = "jpeg";
                break;
        }
        Controller_Upload::$IMG_DIR = APPPATH;

        $img_name = str_replace("-", "", Text::uuid());
        $img_name = $img_name . "." . $type; //新的文件名
        $son_path = date("Y/m/d");
        $upload_path = Controller_Upload::$IMG_DIR . $son_path;

     
        /*         * *
         * 判断文件夹是否存在不存在则创建
         */
        $path = str_replace("\\", "/", $upload_path);
        $upload_path = File::path_mkdirs($upload_path);

    
        $url = str_replace("/", "\\", $upload_path . "" . $img_name);
    
        Upload::save($_FILES["file"], $img_name, $upload_path, "0644"); //上传


        $img_File = Image::factory($url);
        //echo Kohana::debug($img_File);
        $img_File->resize(Controller_Upload::$IMG_MAX_WIDTH, Controller_Upload::$IMG_MAX_HEIGHT, Image::AUTO);
        //判断是否需要打水印
        if (Controller_Upload::$IMG_WATERMARK_STATUS) {

            //打水印
            $watermark = Image::factory(Controller_Upload::$IMG_WATERMARK_PATH);
            //计算水印位置
            $xy_postion = $this->watermark_position($img_File, $watermark, Controller_Upload::$IMG_WATERMARK_POSITION, Controller_Upload::$IMG_WATERMARK_BORDER_SPACE);
            echo kohana::debug($xy_postion);

            $img_File->watermark($watermark, $xy_postion["x"], $xy_postion["y"], Controller_Upload::$IMG_WATERMARK_OPACITY);
        }
        $img_File->save($img_File->file);
    }

    public function action_up_file() {
        
    }

  

    /*     * **
     * 计算图片打水印的位置
     * @$img_File <Image>主图片对象
     * @$watermark <Image> 水印图片对象
     * @$position_flag <integer> 图片水印位置 1上左 |2上中|3上右|4中左 |5中中|6中右|7下左 |8下中|9下右
     * @$border_space <integer> 水印距离图片边缘的位置 px
     * @return  $xy_postion <array> $xy_postion["x"],$xy_postion["y"] 分别为X，Y轴坐标
     */

    public function watermark_position($img_File, $watermark, $position_flag, $border_space) {

        //获取到 图片 和水印的 高宽
        $img_File_w = $img_File->width;
        $img_File_h = $img_File->height;
        $watermark_w = $watermark->width;
        $watermark_h = $watermark->height;
        $xy_postion = array();
        switch ($position_flag) {
            case 1://上左
                $xy_postion["x"] = $border_space;
                $xy_postion["y"] = $border_space;
                break;
            case 2://上中
                $xy_postion["x"] = ceil(($img_File_w - $watermark_w) / 2);
                $xy_postion["y"] = $border_space;
                break;
            case 3://上右
                $xy_postion["x"] = $img_File_w - $watermark_w - $border_space;
                $xy_postion["y"] = $border_space;
                break;
            case 4://中左
                $xy_postion["x"] = $border_space;
                $xy_postion["y"] = (ceil($img_File_h - $watermark_h) / 2);

                break;
            case 5://中中
                $xy_postion["x"] = ceil(($img_File_w - $watermark_w) / 2);
                $xy_postion["y"] = ceil(($img_File_h - $watermark_h) / 2);
                break;
            case 6:
                $xy_postion["x"] = $img_File_w - $watermark_w - $border_space;
                $xy_postion["y"] = ceil(($img_File_h - $watermark_h) / 2);
                break;
            case 7:
                $xy_postion["x"] = $border_space;
                $xy_postion["y"] = $img_File_h - $watermark_h - $border_space;
                break;
            case 8:
                $xy_postion["x"] = ceil(($img_File_w - $watermark_w) / 2);
                $xy_postion["y"] = $img_File_h - $watermark_h - $border_space;
                break;
            case 9:
                $xy_postion["x"] = $img_File_w - $watermark_w - $border_space;
                $xy_postion["y"] = $img_File_h - $watermark_h - $border_space;
                break;
        } return $xy_postion;
    }

}

// End Welcome
