<?php

defined('SYSPATH') or die('No direct script access.');
return array(
    /** **
     * post状态说明
     */
    "post_status" => array(
        '0' => '创建待审核',
        '1' => '已发布',
        '2' => '修改待审核',
        '3' => '驳回待修改',
        '5' => '草稿',
    ),
    /** **
     * post字段flag标记说明
     */

    "post_flag" => array(
        '1' => '精华',
        '2' => '置顶',
        '3' => '推荐',
    ),
    /** **
     * user字段status标记说明
     */
    "user_Status" => array(
        '0' => '正常',
        '1' => '锁定', //限制登录和发布
        '2' => '屏蔽', //不限制登录和发布 但其发布的所有文章 用户不能阅读 管理员可以查看
        '3' => '锁定并屏蔽', //既不能登录发布 文章页不予以显示
    ),
    /** **
     * user字段user_type标记说明
     */
    "user_User_type" => array(
        '0' => '普通',
    ),
    /** **
     * admin表字段role标记说明
     */

    "admin_Role" => array(
        '0' => '编辑',
        '1' => '超级管理员',
    ),
    /** **
     * attachment表字段use_type标记说明
     */
    "attachment_Use_type" => array(
        '0' => '文章',
        '1' => '头像',
    ),
);
?>
