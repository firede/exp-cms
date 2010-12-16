<?php

defined('SYSPATH') or die('No direct script access.');
return array(
    "site" => array(
        "webname" => "大犀牛经验分享系统", //网站名称
        "basehost" => "http://daxiniu.com", //站点根网址
        "indexurl" => "http://daxiniu.com/exp", //网页主页链接
        "default_style" => "", //模板默认风格
        "powerby" => "这里可以是html", //版权信息
        "keywords" => "大犀牛，经验分享，游戏，插件", //站点默认关键字
        "description" => "这里写描述", //站点描述
        "beian" => "陕SDFE2134F", //备案号
    ),
    "cache" => array(
        "driver" => 'apc', //选择使用何种缓存组件
        "is_open" => TRUE, //是否开启缓存 TRUE开启|FALSE关闭
    ),
    "up_img" => array(//上传图片设置
        "path" => "/upload/img", //图片上传的总路径
        "max_size" => 1048, //图片大小最大值 单位kb
        "min_size" => 1, //图片大小最小值 单位kb
        "max_width" => 1048, //图片宽度最大值 单位px
        "max_height" => 768, //图片高度最大值 单位px
        "type" => "jpg,jpeg,png,bmp,gif", //允许上传的图片类型，多个用“,”分隔
        "watermark_path" => "D:\project\exp-cms\assets\admin\img\logo.png", //图片水印路径
        "watermark_position" => 9, //图片水印位置 1上左 |2上中|3上右|4中左 |5中中|6中右|7下左 |8下中|9下右
        "watermark_opacity" => 70, //图片水印透明度
        "watermark_status" => TRUE, //是否使用图片水印 TRUE使用 FALSE不使用
        "watermark_border_space" => 10, //水印与边框距离 单位：px
    ),
    "up_file" => array(//上传文件设置
        "path" => "/upload/file/", //图片上传的总路径
        "max_size" => 2048, //文件大小最大值 单位kb
        "min_size" => 1, //文件大小最小值 单位kb
        "type" => "jpg,jpeg,png,bmp,gif,rar,txt,doc,pdf,xml,7zip,zip,", //允许上传的文件类型，多个用“,”分隔
    ),
    "user" => array(
        "reg_open" => TRUE, //注册开关 TRUE 开启 FALSE关闭
        "default_avatar" => "", //默认用户头像路径
        "up_avatar" => array(//用户上传头像的约束
            "path" => "/upload_avatar/", //图片上传的总路径
            "max_size" => 1048, //图片大小最大值 单位kb
            "min_size" => 1, //图片大小最小值 单位kb
            "max_width" => 1048, //图片宽度最大值 单位px
            "max_height" => 768, //图片高度最大值 单位px
            "type" => "jpg,jpeg,png,bmp,gif", //允许上传的图片类型，多个用“,”分隔
            "watermark_path" => "/watermark/logo.png/", //图片水印路径
            "watermark_position" => 9, //图片水印位置 1上左 |2上中|3上右|4中左 |5中中|6中右|7下左 |8下中|9下右
            "watermark_opacity" => 70, //图片水印透明度
            "watermark_status" => TRUE, //是否使用图片水印 TRUE使用 FALSE不使用
            "watermark_border_space" => 10, //水印与边框距离 单位：px
        ),
    ),
    "post" => array(
        "title_repeat" => TRUE, //文章标题是否可以重复  TRUE 可以重复|FALSE 不可以重复
    ),
    "advanced" => array(//高级选项
        "throw_exception" => NULL, //系统是输出异常信息 NULL 不输出|FILE 输出异常信息到文件 路径为应用根目录/exception.log|WEB 会直接通过视图反馈|THROW 直接抛出
    ),
);
?>
