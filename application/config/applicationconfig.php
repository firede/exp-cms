<?php defined('SYSPATH') or die('No direct script access.'); 
 return array(
     "site" => array(
         "webname" => "大犀牛经验分享系统",
         "basehost" => "http://daxiniu.com",
         "indexurl" => "http://daxiniu.com/exp",
         "default_style" => "",
         "powerby" => "这里可以是html",
         "keywords" => "大犀牛，经验分享，游戏，插件",
         "description" => "这里写描述",
         "beian" => "陕SDFE2134F",
    ),
     "cache" => array(
         "driver" => "apc",
         "is_open" => "1",
    ),
     "up_img" => array(
         "dir" => "C://",
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
         "dir" => "C://",
         "max_size" => "2048",
         "min_size" => "1",
         "type" => "jpg,jpeg,png,bmp,gif,rar,txt,doc,pdf,xml,7zip,zip,",
    ),
     "user" => array(
         "reg_open" => "1",
         "default_avatar" => "",
    ),
     "post" => array(
         "title_repeat" => "1",
    ),
     "advanced"=>array(//高级选项
            "throw_exception"=>"FILE",//系统是输出异常信息 NULL 不输出|FILE 输出异常信息到文件 路径为应用根目录/exception.log|WEB 会直接通过视图反馈|THROW 直接抛出

    ),
) ;
?>