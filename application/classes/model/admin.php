<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of user
 *
 * @author Fanqie
 */
class Model_Admin extends Model_Base {

    public function post_validate($post, $type=NULL) {
        $form = Kohana::config("admin_admin_form");
        $noset_keys = Arr::get_noset_key($post, array('username', "password", "re_password", 'role'));
        $op_data = $form["create"];
        $adminDao = new Database_admin();
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //username
        if (in_array('username', $noset_keys)) {
            $op_data['username']["message"] = $op_data['username']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['username'])) {
            $op_data['username']["message"] = $op_data['username']["label"] . "不能为空";
        } elseif (!Validate::range($post['username'], $op_data["username"]['min_len'], $op_data["username"]['max_len'])) {
            $op_data["username"]["message"] = $op_data['username']["label"] .
                    "长度必须在" . $op_data["username"]['min_len'] . "-" . $op_data["username"]['max_len'] . "个字符之间";
        } elseif (!($adminDao->check_exist(array($post['username'])))) {
            $op_data['username']["message"] = "该" . $op_data['username']["label"] . "已经存在，请重新输入";
        }
        //password 
        if (in_array('password', $noset_keys)) {
            $op_data['password']["message"] = $op_data['password']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['password'])) {
            $op_data['password']["message"] = $op_data['password']["label"] . "不能为空";
        } elseif (!Validate::range($post['password'], $op_data['password']['min_len'], $op_data['password']['max_len'])) {
            $op_data['password']["message"] = $op_data['password']["label"] .
                    "长度必须在" . $op_data['password']['min_len'] . "-" . $op_data['password']['max_len'] . "个字符之间";
        } elseif (!$post['password'] === $post['re_password']) {
            $op_data['re_password']["message"] =
                    $op_data['re_password']["label"] . "与" . $op_data['password']["label"] . "不一致请重新输入";
        }

        //role
        if (in_array('role', $noset_keys)) {
            $op_data['role']["message"] = $op_data['role']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['role'])) {
            $op_data['role']["message"] = $op_data['role']["label"] . "不能为空";
        }

        //将原有值保留到表单设置
        $form["create"] = $this->set_form_value($form["create"], $post);
        if ($this->has_error($form)) {
            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

}

?>
