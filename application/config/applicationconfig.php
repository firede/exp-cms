<?php defined('SYSPATH') or die('No direct script access.'); 
 return  array(
     "site" => array(
         "webname" => "大犀牛内容分享系统",
         "basehost" => "http://daxiniu.com",
         "indexurl" => "http://daxiniu.com/exp",
         "default_style" => "default",
         "copyright" => "&lt;a href='http://daxiniu.com'&gt;大犀牛&lt;/a&gt;",
         "keywords" => "大犀牛，内容分享，游戏，插件",
         "description" => "这里写描述",
         "beian" => "测试",
    ),
     "cache" => array(
         "driver" => "sqlite",
         "is_open" => "1",
    ),
     "up_img" => array(
         "path" => "/upload/img",
         "max_size" => "1048",
         "min_size" => "1",
         "max_width" => "1048",
         "max_height" => "768",
         "type" => "jpg,jpeg,png,bmp,gif",
         "watermark_path" => "D:\project\exp-cms\assets\admin\img\logo.png",
         "watermark_position" => "9",
         "watermark_opacity" => "70",
         "watermark_status" => "1",
         "watermark_border_space" => "10",
    ),
     "up_file" => array(
         "path" => "/upload/file/",
         "max_size" => "2048",
         "min_size" => "1",
         "type" => "jpg,jpeg,png,bmp,gif,rar,txt,doc,pdf,xml,7zip,zip,",
    ),
     "user" => array(
         "reg_open" => "1",
         "default_avatar" => "",
         "up_avatar.path" => "/upload_avatar/",
         "up_avatar.max_size" => "1048",
         "up_avatar.min_size" => "1",
         "up_avatar.max_width" => "1048",
         "up_avatar.max_height" => "768",
         "up_avatar.type" => "jpg,jpeg,png,bmp,gif",
         "up_avatar.watermark_path" => "/watermark/logo.png/",
         "up_avatar.watermark_position" => "9",
         "up_avatar.watermark_opacity" => "70",
         "up_avatar.watermark_status" => "1",
         "up_avatar.watermark_border_space" => "10",
    ),
     "post" => array(
         "title_repeat" => "1",
    ),
     "advanced" => array(
         "throw_exception" => "THROW",
    ),
     "app" => array(
         "setup.status" => "4",
         "setup.steps_page" => "set_db,set_cache,set_admin,finish,TRUE",
    ),
) ;
?>