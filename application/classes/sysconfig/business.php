<?php

defined('SYSPATH') or die('No direct script access.');

class Sysconfig_Business {
    /*     * **
     * 根据状态代码获取post状态说明
     * @$status_id 状态代码
     * @return string
     */

    public static function post_status($status_id) {
        $status = "状态异常";
        switch ($status_id) {
            case 0:
                $status = "创建待审核";
                break;
            case 1:
                $status = "已发布";
                break;
            case 2:
                $status = "修改待审核";
                break;
            case 2:
                $status = "修改待审核";
                break;
            case 2:
                $status = "驳回待修改";
                break;
        }
        return $status;
    }

    public static function post_flag($flag_ids) {
        $flag_ids = explode(",", $flag_ids);
        $flags = array(
            '1' => '精华',
            '2' => '置顶',
            '3' => '推荐',
        );
       
        return Arr::filter_Array($flags, $flag_ids);
    }

}

// End
