<?php

defined('SYSPATH') or die('No direct script access.');

class Sysconfig_Business {
    /*     * **
     * 根据状态代码获取post状态说明
     * @$status_id 状态代码
     * @return string
     */

    public static function post_status($status_id) {
        $status_box = array(
            '0' => '创建待审核',
            '1' => '已发布',
            '2' => '修改待审核',
            '3' => '驳回待修改',
            '5' => '草稿',
        );
          return $status_box[$status_id];
    }
    /****
     * post字段flag标记说明
     * @$flag_ids string 使用使用","分隔多个标记
     * @return 返回合理的文字描述
     */
    public static function post_flag($flag_ids) {
        $flag_ids = explode(",", $flag_ids);
        $flags = array(
            '1' => '精华',
            '2' => '置顶',
            '3' => '推荐',
        );
       
        return Arr::filter_Array($flags, $flag_ids);
    }
     /****
     * user字段status标记说明
     * @$Status int
     * @return 返回用户状态描述
     */
    public static function user_Status($status) {
        $status_box = array(
            '0' => '正常',
            '1' => '锁定',
        );
        return $status_box[$status];
    }
    /****
     * user字段user_type标记说明
     * @$user_type int
     * @return 返回用户类型描述
     */
    public static function user_User_type($user_type) {
        $user_type_box = array(
            '0' => '普通',
        );
        return $user_type_box[$user_type];
    }
     /****
     * admin表字段role标记说明
     * @$role int
     * @return 返回用户类型描述
     */
    public static function admin_Role($role) {
        $role_box = array(
            '0' => '编辑',
            '1' => '超级管理员',
        );
        return $role_box[$role];
    }
    /****
     * attachment表字段use_type标记说明
     * @$use_type int
     * @return 返回附件类型描述
     */
    public static function attachment_Use_type($use_type) {
        $use_type_box = array(
            '0' => '文章',
            '1' => '图像',
        );
        return $use_type_box[$use_type];
    }

}

// End
