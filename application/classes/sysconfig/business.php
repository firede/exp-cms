<?php

defined('SYSPATH') or die('No direct script access.');

class Sysconfig_Business {
    /*     * **
     * 根据状态代码获取post状态说明
     * @$status_id 状态代码
     * @return string
     */

    public static function post_status($status_id) {
        $status_box =Sysconfig_Business::get_config("post_status");
          return $status_box[$status_id];
    }
    /****
     * post字段flag标记说明
     * @$flag_ids string 使用使用","分隔多个标记
     * @return 返回合理的文字描述
     */
    public static function post_flag($flag_ids) {
        $flag_ids = explode(",", $flag_ids);
        $flags =Sysconfig_Business::get_config("post_flag");
        return Arr::filter_Array($flags, $flag_ids);
    }
     /****
     * user字段status标记说明
     * @$Status int
     * @return 返回用户状态描述
     */
    public static function user_Status($status) {
        $status_box = Sysconfig_Business::get_config("user_Status");
        return $status_box[$status];
    }
    /****
     * user字段user_type标记说明
     * @$user_type int
     * @return 返回用户类型描述
     */
    public static function user_User_type($user_type) {
        $user_type_box = Sysconfig_Business::get_config("user_User_type");
        return $user_type_box[$user_type];
    }
     /****
     * admin表字段role标记说明
     * @$role int
     * @return 返回用户类型描述
     */
    public static function admin_Role($role) {
        $role_box = aSysconfig_Business::get_config("admin_Role");
        return $role_box[$role];
    }
    /****
     * attachment表字段use_type标记说明
     * @$use_type int
     * @return 返回附件类型描述
     */
    public static function attachment_Use_type($use_type) {
        
        $use_type_box = Sysconfig_Business::get_config("attachment_Use_type");
        return $use_type_box[$use_type];
    }
    /**
     *根据需要的业务配置对象名取出相对有的对象
     * @param <type> $function_name
     */
    public static function  get_config($function_name){
        $business=Kohana::config("business_config");
        return isset($business[$function_name])?$business[$function_name]:array();
    }

}

// End
