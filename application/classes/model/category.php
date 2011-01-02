<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of user
 *
 * @author Fanqie
 */
class Model_Category extends Model_Base {

    public function post_validate($post, $form, $legal_fileds, $type=NULL) {

        $noset_keys = Arr::get_noset_key($post, $legal_fileds);
        $op_data = $form;
        $categoryDao = new Database_Category();
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //name
        if (in_array("name", $legal_fileds)) {
            if (in_array('name', $noset_keys)) {
                $op_data['name']["message"] = $op_data['name']["label"] . "没有定义";
            } elseif (!Validate::not_empty($post['name'])) {
                $op_data['name']["message"] = $op_data['name']["label"] . "不能为空";
            } elseif (!$this->validate_length_range ($post['name'], $op_data["name"])) {
                $op_data["name"]["message"] = $op_data['name']["label"] .
                        "长度必须在" . $op_data["name"]['min_len'] . "-" . $op_data["name"]['max_len'] . "个字符之间";
            } elseif (!($categoryDao->check_exist($post['name']))) {
                $op_data['name']["message"] = "该" . $op_data['name']["label"] . "已经被占用，请重新输入";
            }
        }

        //short_name
        if (in_array("short_name", $legal_fileds)) {
            if (in_array('short_name', $noset_keys)) {
                $op_data['short_name']["message"] = $op_data['short_name']["label"] . "没有定义";
            } elseif (!$this->validate_length_range ($post['short_name'], $op_data['short_name'])) {
                $op_data['short_name']["message"] = $op_data['short_name']["label"] .
                        "长度必须在" . $op_data['short_name']['min_len'] . "-" . $op_data['short_name']['max_len'] . "个字符之间";
            }
        }

        //parent_id
        if (in_array("parent_id", $legal_fileds)) {
            if (in_array('parent_id', $noset_keys)) {
                $op_data['parent_id']["message"] = $op_data['parent_id']["label"] . "没有定义";
            } elseif (!Validate::not_empty($post['parent_id'])) {
                $op_data['parent_id']["message"] = "必须选择一个" . $op_data['parent_id']["label"];
            }
        }
        //sort
        if (in_array("sort", $legal_fileds)) {
            if (in_array('sort', $noset_keys)) {
                $op_data['sort']["message"] = $op_data['sort']["label"] . "没有定义";
            } elseif (!Validate::numeric($post['sort'])) {
                $op_data['sort']["message"] = $op_data['sort']["label"] . "必须是数字";
            } elseif (!$this->validate_length_range($post['sort'], $op_data['sort'])) {
                $op_data['sort']["message"] = $op_data['sort']["label"] .
                        "长度必须在" . $op_data['sort']['min_len'] . "-" . $op_data['sort']['max_len'] . "个字符之间";
            }
        }
        //将原有值保留到表单设置
        $form = $this->set_form_value($op_data, $post);
        if (!$this->has_error($form)) {
            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

}

?>
