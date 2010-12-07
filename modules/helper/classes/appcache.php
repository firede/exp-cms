<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * 服务器应用缓存的使用
 */

/**
 * Description of cache
 *
 * @author Danchengcheng
 */
class AppCache {
/****
 * 将值放入指定缓存并取出 如果重复 则不修改 超过生命周期在此加载会重置最新数据 自动化处理缓存使用方式
 * @$id <string> 缓存对象的名称
 * @$data <array> 缓存对象的值
 * @return <array> 返回给予缓存操作的值
 */
    public static function app_cache($id, $data) {
        $conf = Kohana::config("applicationconfig");
        $driver = $conf["cache"]["driver"];//所选取的缓存组件
        $is_open= $conf["cache"]["is_open"];//缓存是否开启 FALSE 关闭 TRUE 开启
        //如果关闭了缓存
        if($is_open){
            return $data;
        }
        //验证是否服务器安装该组件 如果安装则使用缓存
        if (extension_loaded($driver)) {
            $cache = Cache::instance("$driver");
            $cache->set($id, $data);
            return $cache->get($id);
        } 
            return $data;
       
    }

}

?>
