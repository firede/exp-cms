<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of setup
 *
 * @author Fanqie
 */
class Model_Setup extends Model_Base {

    public function post_validate($post, $type=NULL) {
        $form = Kohana::config("admin_user_form");
        $noset_keys = Arr::get_noset_key($post, array('username', "password", "re_password", 'email', 'status', 'user_type',
                    'avatar', 'admin_id'));
        $op_data = $form;
        $userDao = new Database_User ();
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //用户名检测
        if (in_array('username', $noset_keys)) {
            $op_data['username']["message"] = $op_data['username']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['username'])) {
            $op_data['username']["message"] = $op_data['username']["label"] . "不能为空";
        } elseif (!Validate::range($post['username'], $op_data["username"]['min_len'], $op_data["username"]['max_len'])) {
            $op_data['username']["message"] = $op_data['username']["label"] .
                    "长度必须在" . $op_data["username"]['min_len'] . "-" . $op_data["username"]['max_len'] . "个字符之间";
        } elseif (!($userDao->check_exist(array($post['username'])))) {
            $op_data['username']["message"] = "该" . $op_data['username']["label"] . "已经存在，请重新输入";
        }
        //password 密码检测
        if (in_array('password', $noset_keys)) {
            $op_data['password']["message"] = $op_data['password']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['password'])) {
            $op_data['password']["message"] = $op_data['password']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['password']), $op_data['password']['min_len'], $op_data['password']['max_len'])) {
            $op_data['password']["message"] = $op_data['password']["label"] .
                    "长度必须在" . $op_data['password']['min_len'] . "-" . $op_data['password']['max_len'] . "个字符之间";
        } elseif (!$post['password'] === $post['re_password']) {
            $op_data['re_password']["message"] =
                    $op_data['re_password']["label"] . "与" . $op_data['password']["label"] . "不一致请重新输入";
        }
        if (!Validate::not_empty($post['re_password'])) {
            $op_data['re_password']["message"] = $op_data['re_password']["label"] . "不能为空";
        }
        //email 密码检测
        if (in_array('email', $noset_keys)) {
            $op_data['email']["message"] = $op_data['email']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['email'])) {
            $op_data['email']["message"] = $op_data['email']["label"] . "不能为空";
        } elseif (!Validate::email($post['email'])) {
            $op_data['email']["message"] = $op_data['email']["label"] . "不是有效的E-mail格式";
        }
        //status 密码检测
        if (in_array('status', $noset_keys)) {
            $op_data['status']["message"] = $op_data['status']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['status'])) {
            $op_data['status']["message"] = $op_data['status']["label"] . "不能为空";
        }
        //user_type 密码检测
        if (in_array('user_type', $noset_keys)) {
            $op_data['user_type']["message"] = $op_data['user_type']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['user_type'])) {
            $op_data['user_type']["message"] = $op_data['user_type']["label"] . "不能为空";
        }
        //status 密码检测
        if (in_array('avatar', $noset_keys)) {
            $op_data['avatar']["message"] = $op_data['avatar']["label"] . "没有定义";
        }
        //admin_id 密码检测
        if (in_array('admin_id', $noset_keys)) {
            $op_data['admin_id']["message"] = $op_data['avatar']["label"] . "没有定义";
        }
        //将原有值保留到表单设置
        $form = $this->set_form_value($op_data, $post, array("password", "re_password"), array());
        if ($this->has_error($form)) {
            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    /**     * **
     * 判断服务可以已经拥有的缓存组件
     * 'memcache'
      'memcachetag'
      'apc'
      'sqlite'
      'eaccelerator'
      'xcache'
      'file'
     */
    public function check_cache_component() {
        $cache_arr = array();
        $count = 0;
        $select_stauts=FALSE;
        if (extension_loaded('memcache')) {//1
            $cache_arr[$count] = 'memcache';
            $cache_arr[$count]["seclet"]=TRUE;
            $select_stauts=TRUE;
            $count++;
        }
        if (extension_loaded('apc')) {//2
            $cache_arr[$count] = 'apc';
            $cache_arr[$count]["seclet"]=$select_staut?FALSE:TRUE;
            $select_stauts=TRUE;
            $count++;
        }
        if (extension_loaded('eaccelerator')) {//3
            $cache_arr[$count] = 'eaccelerator';
            $cache_arr[$count]["seclet"]=$select_staut?FALSE:TRUE;
            $select_stauts=TRUE;
            $count++;
        }
        if (extension_loaded('memcachetag')) {//5
            $cache_arr[$count] = 'memcachetag';
            $cache_arr[$count]["seclet"]=$select_staut?FALSE:TRUE;
            $select_stauts=TRUE;
            $count++;
        }
        if (extension_loaded('xcache')) {//4
            $cache_arr[$count] = 'xcache';
            $cache_arr[$count]["seclet"]=$select_staut?FALSE:TRUE;
            $select_stauts=TRUE;
            $count++;
        }
        if (extension_loaded('sqlite3')||extension_loaded('sqlite')) {//6
            $cache_arr[$count] = 'sqlite';
            $cache_arr[$count]["seclet"]=$select_staut?FALSE:TRUE;
            $select_stauts=TRUE;
            $count++;
        }
        if (extension_loaded('file')) {//7
            $cache_arr[$count] = 'file';
            $cache_arr[$count]["seclet"]=$select_staut?FALSE:TRUE;
            $select_stauts=TRUE;
            $count++;
        }
    }

}

?>
