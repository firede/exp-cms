<?php defined('SYSPATH') or die('No direct script access.'); 
 return array (
     "site" =>array(
         "webname" => "大犀牛经验分享系统",
         "basehost" => "http://daxiniu.com",
         "indexurl" => "http://daxiniu.com/exp",
         "default_style" => "",
         "powerby" => "这里可以是html",
         "keywords" => "大犀牛，经验分享，游戏，插件",
         "description" => "这里写描述",
         "beian" => "陕SDFE2134F",
    ),
     "cache" =>array(
         "driver" => "sqlite",
         "is_open" => TRUE,
    ),
     "up_img" =>array(
         "path" => "/upload/img",
         "max_size" => 1048,
         "min_size" => 1,
         "max_width" => 1048,
         "max_height" => 768,
         "type" => "jpg,jpeg,png,bmp,gif",
         "watermark_path" => "D:\project\exp-cms\assets\admin\img\logo.png",
         "watermark_position" => 9,
         "watermark_opacity" => 70,
         "watermark_status" => TRUE,
         "watermark_border_space" => 10,
    ),
     "up_file" =>array(
         "path" => "/upload/file/",
         "max_size" => 2048,
         "min_size" => 1,
         "type" => "jpg,jpeg,png,bmp,gif,rar,txt,doc,pdf,xml,7zip,zip,",
    ),
     "user" =>array(
         "reg_open" => TRUE,
         "default_avatar" => "",
         "up_avatar" => array(
             "path" => "/upload_avatar/",
             "max_size" => 1048,
             "min_size" => 1,
             "max_width" => 1048,
             "max_height" => 768,
             "type" => "jpg,jpeg,png,bmp,gif",
             "watermark_path" => "/watermark/logo.png/",
             "watermark_position" => 9,
             "watermark_opacity" => 70,
             "watermark_status" => TRUE,
             "watermark_border_space" => 10,
        ),
    ),
     "post" =>array(
         "title_repeat" => TRUE,
    ),
     "advanced" =>array(
         "throw_exception" => "THROW",
    ),
     "app" =>array(
         "setup" => array(
             "status" => 4,
             "steps_page" => array(
                 0 => "set_db",
                 1 => "set_cache",
                 2 => "set_admin",
                 3 => "finish",
                 4 => TRUE,
            ),
        ),
    ),
) ;
?>