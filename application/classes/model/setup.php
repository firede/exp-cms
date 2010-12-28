<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of setup
 *
 * @author Fanqie
 */
class Model_Setup extends Model_Base {

    public function _db_post_validate($post, $type=NULL) {
        $form = Kohana::config("setup_form");
        $noset_keys = Arr::get_noset_key($post, array('db_type', "host_name", "db_name", 'user', 'pwd', 'table_prefix',
                    'avatar', 'admin_id'));
        $op_data = $form['set_db'];
        $setup_db = new Database_Setup();
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //db_type 
        if (in_array('db_type', $noset_keys)) {
            $op_data['db_type']["message"] = $op_data['db_type']["label"] . "没有定义";
        }
        //host_name
        if (in_array('host_name', $noset_keys)) {
            $op_data['host_name']["message"] = $op_data['host_name']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['host_name'])) {
            $op_data['host_name']["message"] = $op_data['host_name']["label"] . "不能为空";
        } elseif (!(Validate::ip($post['host_name']) || Validate::url($post['host_name']))) {
            $op_data['host_name']["message"] = $op_data['host_name']["label"] . "格式无效";
        }

        //user
        if (in_array('user', $noset_keys)) {
            $op_data['user']["message"] = $op_data['user']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['user'])) {
            $op_data['user']["message"] = $op_data['user']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['user']), $op_data["user"]['min_len'], $op_data["user"]['max_len'])) {
            $op_data['user']["message"] = $op_data['user']["label"] .
                    "长度必须在" . $op_data["user"]['min_len'] . "-" . $op_data["user"]['max_len'] . "个字符之间";
        }
        //pwd 
        if (in_array('pwd', $noset_keys)) {
            $op_data['pwd']["message"] = $op_data['pwd']["label"] . "没有定义";
        } elseif (!Validate::range(strlen($post['pwd']), $op_data['pwd']['min_len'], $op_data['pwd']['max_len'])) {
            $op_data['pwd']["message"] = $op_data['pwd']["label"] .
                    "长度必须在" . $op_data['pwd']['min_len'] . "-" . $op_data['pwd']['max_len'] . "个字符之间";
        } elseif (!$setup_db->check_connection($post)) {
            $op_data['user']["message"] =
                    $op_data['user']["label"] . "不存在或" . $op_data['pwd']["label"] . "不正确";
        }
        //db_name
        if (in_array('db_name', $noset_keys)) {
            $op_data['db_name']["message"] = $op_data['db_name']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['db_name'])) {
            $op_data['db_name']["message"] = $op_data['db_name']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['db_name']), $op_data['db_name']['min_len'], $op_data['db_name']['max_len'])) {
            $op_data['db_name']["message"] = $op_data['db_name']["label"] .
                    "长度必须在" . $op_data['db_name']['min_len'] . "-" . $op_data['db_name']['max_len'] . "个字符之间";
        }

        //table_prefix
        if (in_array('table_prefix', $noset_keys)) {
            $op_data['table_prefix']["message"] = $op_data['table_prefix']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['table_prefix'])) {
            $op_data['table_prefix']["message"] = $op_data['table_prefix']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['table_prefix']), $op_data['table_prefix']['min_len'], $op_data['table_prefix']['max_len'])) {
            $op_data['table_prefix']["message"] = $op_data['table_prefix']["label"] .
                    "长度必须在" . $op_data['table_prefix']['min_len'] . "-" . $op_data['table_prefix']['max_len'] . "个字符之间";
        }

        //将原有值保留到表单设置
        $form['set_db'] = $this->set_form_value($op_data, $post, array("pwd"), array());

        if (!$this->has_error($form['set_db'])) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    public function _cache_post_validate($post, $type=NULL) {

        $form = Kohana::config("setup_form");
        $form = $this->check_cache_component($form);
        $noset_keys = Arr::get_noset_key($post, array('driver', "is_open"));
        $op_data = $form['set_cache'];
        $setup_db = new Database_Setup();
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //cache_type
        if (in_array('driver', $noset_keys)) {
            $op_data['driver']["message"] = $op_data['driver']["label"] . "没有定义";
        }
        //default_expire
        if (in_array('is_open', $noset_keys)) {
            $op_data['is_open']["message"] = $op_data['is_open']["label"] . "没有定义";
        }

        //将原有值保留到表单设置
        $form['set_cache'] = $this->set_form_value($op_data, $post);

        if (!$this->has_error($form['set_cache'])) {

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
    public function check_cache_component($form) {

        $cache_arr = $form['set_cache']['driver'];
        $select_stauts = FALSE;
        if (extension_loaded('memcache')) {//1
            $cache_arr['value']['data']['memcache'] = 'memcache';
            $cache_arr['value']["select"] = 'memcache';
            $cache_arr["desc"] = $select_stauts ? $cache_arr["desc"] : "系统推荐您使用memcache";
            $select_stauts = TRUE;
        }
        if (extension_loaded('apc')) {//2
            $cache_arr['value']['data']['apc'] = 'apc';
            $cache_arr['value']["select"] = $select_stauts ? $cache_arr['value']["select"] : 'apc';
            $cache_arr["desc"] = $select_stauts ? $cache_arr["desc"] : "系统推荐您使用apc";
            $select_stauts = TRUE;
        }
        if (extension_loaded('eaccelerator')) {//3
            $cache_arr['value']['data']['eaccelerator'] = 'eaccelerator';
            $cache_arr['value']["select"] = $select_stauts ? $cache_arr['value']["select"] : 'eaccelerator';
            $cache_arr["desc"] = $select_stauts ? $cache_arr["desc"] : "系统推荐您使用eaccelerator";
            $select_stauts = TRUE;
        }
        if (extension_loaded('memcachetag')) {//5
            $cache_arr['value']['data']['memcachetag'] = 'memcachetag';
            $cache_arr['value']["select"] = $select_stauts ? $cache_arr['value']["select"] : 'memcachetag';
            $cache_arr["desc"] = $select_stauts ? $cache_arr["desc"] : "系统推荐您使用memcachetag";
            $select_stauts = TRUE;
        }
        if (extension_loaded('xcache')) {//4
            $cache_arr['value']['data']['xcache'] = 'xcache';
            $cache_arr['value']["select"] = $select_stauts ? $cache_arr['value']["select"] : 'xcache';
            $cache_arr["desc"] = $select_stauts ? $cache_arr["desc"] : "系统推荐您使用xcache";
            $select_stauts = TRUE;
        }
        if (extension_loaded('sqlite3') || extension_loaded('sqlite')) {//6
            $cache_arr['value']['data']['sqlite'] = 'sqlite';
            $cache_arr['value']["select"] = $select_stauts ? $cache_arr['value']["select"] : 'sqlite';
            $cache_arr["desc"] = $select_stauts ? $cache_arr["desc"] : "系统推荐您使用sqlite";
            $select_stauts = TRUE;
        }
        // if (extension_loaded('file')) {//7
        $cache_arr['value']['data']['file'] = 'file';
        $cache_arr['value']["select"] = $select_stauts ? $cache_arr['value']["select"] : 'file';
        $cache_arr["desc"] = $select_stauts ? $cache_arr["desc"] : "系统推荐您使用file";
        $select_stauts = TRUE;
        $cache_arr["desc"] = $select_stauts ? $cache_arr["desc"] : "找不到相应的缓存组件系统将禁用缓存";
        $form['set_cache']['is_open']['value']['seclet'] = 0;
        $form['set_cache']['driver'] = $cache_arr;
        return $form;
    }
    /** ***
     *  设置缓存和缓存类型
     * @param <array> $cache_conf_post
     * @return <bool>
     */
    public function set_cache($cache_conf_post) {
        try {
            $conf = Kohana::config('applicationconfig');
            $conf['cache']['driver'] = $cache_conf_post['driver'];
            $conf['cache']['is_open'] = (bool) $cache_conf_post['is_open'];
            arr::as_config_file($conf, APPPATH . '/config/applicationconfig.php');
            return TRUE;
        } catch (Exception $e) {
            echo ErrorExceptionReport::_errors_report($e,TRUE);
            return FALSE;
        }
    }

}

?>
