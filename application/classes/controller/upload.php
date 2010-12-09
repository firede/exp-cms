<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Upload extends Controller_BaseUser {

    public function action_toupload() {
        $this->template = View::factory('smarty:upload/uptest', array(
                ));
    }
    /********
     * 上传图片
     */
    public function action_up_img() {
        try {
            $conf = Kohana::config("applicationconfig");
            $file = $_FILES["file"];
            $son_path = ""; //这个 是通过日期生成的
            //判断图片是否合法
            $img_types = explode("/", $file["type"]);
            $name = (explode(".", $file["name"]));
            $limit_type_status = FALSE;
            if (!isset($name[0])) {
                echo "错误：图片类型必须是" . $conf["up_img"]["type"] . "为后缀的";
                return;
            }
            if ($img_types[0] != "image") {
                return "错误:该文件类型不正确";
            }
            $limit_types = explode(",", $conf["up_img"]["type"]);

            foreach ($limit_types as $limit_type) {
                if ($limit_type == $name[1]) {
                    $limit_type_status = TRUE;
                    break;
                }
            }
            if (!$limit_type_status) {
                echo "错误：图片类型必须是" . $conf["up_img"]["type"] . "为后缀的";
                return;
            }
            if (($file["size"] / 1024) > $conf["up_img"]["max_size"] || ($file["size"] / 1024) < $conf["up_img"]["min_size"]) {
                echo "错误:文件大小必须在" . (string) $conf["up_img"]["min_size"] . "KB 到 " . (string) $conf["up_img"]["max_size"] . "KB 之间";
                return;
            }
            $type = $img_types[1];
            switch ($img_types[1]) {
                case "x-png":
                    $type = "png";
                    break;
                case "pjpeg":
                    $type = "jpeg";
                    break;
            }
            if ($conf["up_img"]["dir"] = "") {
                $conf["up_img"]["dir"] = APPPATH;
            }
            $img_name = str_replace("-", "", Text::uuid());
            $img_name = $img_name . "." . $type; //新的文件名
            $son_path = date("Y/m/d");
            $upload_path = $conf["up_img"]["dir"] . $son_path;
            /*             * *
             * 判断文件夹是否存在不存在则创建
             */
            $path = str_replace("\\", "/", $upload_path);

            $upload_path = File::path_mkdirs($upload_path);
            $url = str_replace("/", "\\", $upload_path . "\\" . $img_name);
            $relative_url = str_replace("/","\\",("\\".$son_path . "\\" . $img_name));
            Upload::save($_FILES["file"], $img_name, $upload_path, "0644"); //上传
            $img_File = Image::factory($url);
            $img_File->resize($conf["up_img"]["max_width"], $conf["up_img"]["max_height"], Image::AUTO);
            //判断是否需要打水印
            if ($conf["up_img"]["watermark_status"]) {
                //打水印
                $watermark = Image::factory($conf["up_img"]["watermark_path"]);
                //计算水印位置
                $xy_position = $this->watermark_position($img_File, $watermark, $conf["up_img"]["watermark_position"], $conf["up_img"]["watermark_border_space"]);

                $img_File->watermark($watermark, $xy_position["x"], $xy_position["y"], $conf["up_img"]["watermark_opacity"]);
            }
            $img_File->save($img_File->file);
            $result = array(
                "sucess" => "ok",
                "relative_url" => $relative_url,
                "message"=>"图片上传成功",
            );
           
            return $result;
        } catch (Exception $e) {
            return array(
                "sucess" => "error",
                "message"=>"图片上传失败",
            );
        }
    }

    /*     * *********
     * 文件上传
     */

    public function action_up_file() {
        try {
            $file = $_FILES["file"];
            $conf = Kohana::config("applicationconfig");
            if ($file["size"] / 1024 < $conf["up_file"]["min_size"] || $file["size"] / 1024 > $conf["up_file"]["max_size"]) {
                echo "错误:文件大小必须在" . $conf["up_file"]["min_size"] . "KB 到 " . $conf["up_file"]["max_size"] . "KB 之间";
                return;
            }
            $name = (explode(".", $file["name"]));
            $limit_type_status = FALSE;
            if (!isset($name[1])) {
                echo "错误：文件类型必须是" . $conf["up_file"]["type"] . "为后缀的";
                return;
            }
            $limit_types = explode(",", $conf["up_file"]["type"]);

            foreach ($limit_types as $limit_type) {
                if ($limit_type == $name[1]) {
                    $limit_type_status = TRUE;
                    break;
                }
            }
            if (!$limit_type_status) {
                echo "错误：文件类型必须是" . $conf["up_file"]["type"] . "为后缀的";
                return;
            }

            if ($conf["up_file"]["dir"] == "") {
                $conf["up_file"]["dir"] = APPPATH;
            }
            $file_name = str_replace("-", "", Text::uuid());
            $file_name = $file_name . "." . $name[1]; //新的文件名
            $son_path = date("Y/m/d");
            $relative_url = str_replace("/","\\",("\\".$son_path . "\\" . $file_name));
            $upload_path = $conf["up_file"]["dir"] . $son_path;
            /*             * *
             * 判断文件夹是否存在不存在则创建
             */
            $path = str_replace("\\", "/", $upload_path);
            $upload_path = File::path_mkdirs($upload_path);
            $url = str_replace("/", "\\",($upload_path . "" . $file_name));
            Upload::save($_FILES["file"], $file_name, $upload_path, "0644"); //上传
            $result = array(
                    "suess" => "ok",
                    "relative_url" => $relative_url,
                    "message" => "文件上传成功",
            );
            return $result;
        } catch (Exception $e) {
            return $result = array(
                    "suess" => "error",
                    "message"=>"文件上传失败",
            );
        }
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
