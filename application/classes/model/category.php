<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of user
 *
 * @author Fanqie
 */
class Model_Category extends Model_Base {

    public function post_validate($post, $type=NULL) {
        $form = Kohana::config("admin_category_form");
        $noset_keys = Arr::get_noset_key($post, array('name', "short_name", "parent_id ", 'sort'));
        $op_data = $form["create"];
        $categoryDao = new Database_Category();
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //name
        if (in_array('name', $noset_keys)) {
            $op_data['name']["message"] = $op_data['name']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['name'])) {
            $op_data['name']["message"] = $op_data['name']["label"] . "不能为空";
        } elseif (!Validate::range($post['name'], $op_data["name"]['min_len'], $op_data["name"]['max_len'])) {
            $op_data["name"]["message"] = $op_data['name']["label"] .
                    "长度必须在" . $op_data["name"]['min_len'] . "-" . $op_data["name"]['max_len'] . "个字符之间";
        } elseif (!($categoryDao->check_exist(array($post['name'])))) {
            $op_data['name']["message"] = "该" . $op_data['name']["label"] . "已经被占用，请重新输入";
        }

        //short_name
        if (in_array('short_name', $noset_keys)) {
            $op_data['short_name']["message"] = $op_data['short_name']["label"] . "没有定义";
        } elseif (!Validate::range($post['short_name'], $op_data['short_name']['min_len'], $op_data['short_name']['max_len'])) {
            $op_data['short_name']["message"] = $op_data['short_name']["label"] .
                    "长度必须在" . $op_data['short_name']['min_len'] . "-" . $op_data['short_name']['max_len'] . "个字符之间";
        }

        //parent_id
        if (in_array('parent_id', $noset_keys)) {
            $op_data['parent_id']["message"] = $op_data['parent_id']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['parent_id'])) {
            $op_data['parent_id']["message"] = "必须选择一个".$op_data['parent_id']["label"] ;
        }
         //sort
        if (in_array('sort', $noset_keys)) {
            $op_data['sort']["message"] = $op_data['sort']["label"] . "没有定义";
        } elseif (!Validate::numeric ($post['sort'])) {
            $op_data['sort']["message"] = $op_data['sort']["label"]."必须是数字" ;
        } elseif (!Validate::range($post['sort'], $op_data['sort']['min_len'], $op_data['sort']['max_len'])) {
            $op_data['sort']["message"] = $op_data['sort']["label"] .
                    "长度必须在" . $op_data['sort']['min_len'] . "-" . $op_data['sort']['max_len'] . "个字符之间";
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
