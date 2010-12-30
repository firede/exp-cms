<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of user
 *
 * @author Fanqie
 */
class Model_Admin extends Model_Base {

    public function post_validate($post, $form, $function_config, $type=NULL) {
        $noset_keys = Arr::get_noset_key($post, array('username', "password", "re_password", 'role'));
        $op_data = $form;
        if (isset($function_config["display"])) {
            $_fileds = explode(",", trim($function_config["display"]));
        }
        $adminDao = new Database_admin();
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //username
        if (in_array("username", $_fileds)) {
            if (in_array('username', $noset_keys)) {
                $op_data['username']["message"] = $op_data['username']["label"] . "没有定义";
            } elseif (!Validate::not_empty($post['username'])) {
                $op_data['username']["message"] = $op_data['username']["label"] . "不能为空";
            } elseif (!Validate::range(strlen($post['username']), $op_data["username"]['min_len'], $op_data["username"]['max_len'])) {
                $op_data["username"]["message"] = $op_data['username']["label"] .
                        "长度必须在" . $op_data["username"]['min_len'] . "-" . $op_data["username"]['max_len'] . "个字符之间";
            } elseif (!($adminDao->check_exist(array("username" => $post['username'])))) {

                $op_data['username']["message"] = "该" . $op_data['username']["label"] . "已经存在，请重新输入";
            }
        }
        //password
        if (in_array("password", $_fileds)) {
            if (in_array('password', $noset_keys)) {
                $op_data['password']["message"] = $op_data['password']["label"] . "没有定义";
            } elseif (!Validate::not_empty($post['password'])) {
                $op_data['password']["message"] = $op_data['password']["label"] . "不能为空";
            } elseif (!Validate::range(strlen($post['password']), $op_data['password']['min_len'], $op_data['password']['max_len'])) {
                $op_data['password']["message"] = $op_data['password']["label"] .
                        "长度必须在" . $op_data['password']['min_len'] . "-" . $op_data['password']['max_len'] . "个字符之间";
            } else {
                if (in_array("re_password", $_fileds)) {
                    if (!($post['password'] === $post['re_password'])) {
                        $op_data['re_password']["message"] =
                                $op_data['re_password']["label"] . "与" . $op_data['password']["label"] . "不一致请重新输入";
                    }
                }
            }
            if (in_array("re_password", $_fileds)) {
                if (!Validate::not_empty($post['re_password'])) {
                    $op_data['re_password']["message"] = $op_data['re_password']["label"] . "不能为空";
                }
            }
        }

        //role
        if (in_array("role", $_fileds)) {
            if (in_array('role', $noset_keys)) {
                $op_data['role']["message"] = $op_data['role']["label"] . "没有定义";
            } elseif (!Validate::not_empty($post['role'])) {
                $op_data['role']["message"] = $op_data['role']["label"] . "不能为空";
            }
        }


        //将原有值保留到表单设置
        $form = $this->set_form_value($op_data, $post, array("password", "re_password"), array());
        if (!$this->has_error($form)) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    /**     * *
     * 登录验证
     * @param <type> $post
     * @param <type> $type
     * @return <type>
     */
    public function auth_validate($post, $type=NULL) {
        $form = Kohana::config("adminauth_login_form");
        $noset_keys = Arr::get_noset_key($post, array('username', "password", "re_password", 'role'));
        $op_data = $form;

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
        } elseif (!Validate::range(strlen($post['username']), $op_data["username"]['min_len'], $op_data["username"]['max_len'])) {
            $op_data["username"]["message"] = $op_data['username']["label"] .
                    "长度必须在" . $op_data["username"]['min_len'] . "-" . $op_data["username"]['max_len'] . "个字符之间";
        }
        $user = FALSE;
        //password
        if (in_array('password', $noset_keys)) {
            $op_data['password']["message"] = $op_data['password']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['password'])) {
            $op_data['password']["message"] = $op_data['password']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['password']), $op_data['password']['min_len'], $op_data['password']['max_len'])) {
            $op_data['password']["message"] = $op_data['password']["label"] .
                    "长度一般为" . $op_data['password']['min_len'] . "-" . $op_data['password']['max_len'] . "个字符之间";
        } elseif (($user = $adminDao->check_login($post)) === FALSE) {
            $op_data['password']["message"] = $op_data['username']["label"] . "不存在或" . $op_data['password']["label"] . "可能错误";
        }

        //将原有值保留到表单设置
        $form = $this->set_form_value($op_data, $post, array("password"), array());
        if (!$this->has_error($form)) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }

        return $user;
    }

}

?>
