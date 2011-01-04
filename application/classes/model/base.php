<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of base
 *
 * @author Administrator
 */
class Model_Base {

    /**     * ***
     * 将$post中的值放入 $form中 并返回
     * @param $form array
     * @param $post array
     * @param $is_empty array 设置传空值的项
     * @param $set_continue array 设置跳过不设置值的项
     * @return array
     */
    public  function set_form_value($form, $post, $set_empty=array(), $set_continue=array()) {
        foreach ($form as $key => $value) {

            //例外操作
            if (isset($post[$key])) {

                if (in_array($key, $set_empty)) {
                    $post[$key] = "";
                } elseif (in_array($key, $set_continue)) {
                    continue;
                }

                if ($form[$key]["type"] == "select") {
                    $form[$key]["value"]["select"] = $post[$key];
                    continue;
                }
                $form[$key]["value"] = $post[$key];
            }
        }
        return $form;
    }

    /*     * ****
     * 查看$form中是否包括错误提示
     * @param $form array
     * @return bool 有错误信息则返回FALSE 没有则返回TRUE
     */

    public  function has_error($form) {
        foreach ($form as $key => $value) {
            if (isset($form[$key]["message"])) {
                if (Validate::not_empty($form[$key]["message"])) {
                    return FALSE;
                }
            }
        }
        return TRUE;
    }
     /**
     * 检测字符串是否符合范围
     * @param <string> $str
     * @param <array> $obj_desc
     * @return <bool>
     */
    public  function validate_length_range($str, $obj_desc) {
        $len = strlen($str);

        if (isset($obj_desc['max_len']) && !isset($obj_desc['min_len'])) {
             return $len <$obj_desc['max_len'];
        } elseif (isset($obj_desc['min_len']) && !isset($obj_desc['max_len'])) {
            return $len > $obj_desc['min_len'];
        } elseif (isset($obj_desc['min_len']) && isset($obj_desc['max_len'])) {
            return Validate::range($len, $obj_desc['min_len'], $obj_desc['max_len']);
        } else {
            return TRUE;
        }
    }
}

?>
