<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of user
 *
 * @author Fanqie
 */
class Model_Post extends Model_Base {

    public function post_validate($post, $type=NULL) {
        $form = Kohana::config("admin_post_form");
        $noset_keys = Arr::get_noset_key($post, array('title', "cate_id", "content", 'status', 'reference', 'source',));
          $op_data = $form["create"];
        $postDao = new Database_Post();
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //title
        if (in_array('title', $noset_keys)) {
            $op_data['title']["message"] = $op_data['title']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['title'])) {
            $op_data['title']["message"] = $op_data['title']["label"] . "不能为空";
        } elseif (Validate::range($post['title'], 7, 22)) {
            $op_data['title']["message"] = $op_data['title']["label"] . "长度必须在7-22个字符之间";
        } elseif (!$postDao->check_exist(array($post['title']))) {
            $op_data['title']["message"] = "该" . $op_data['title']["label"] . "已经存在，请重新输入";
        }
        //cate_id
        if (in_array('cate_id', $noset_keys)) {
            $op_data['cate_id']["message"] = $op_data['cate_id']["label"] . "没有定义";
        }
        //content
        if (in_array('content', $noset_keys)) {
            $op_data['content']["message"] = $op_data['content']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['content'])) {
            $op_data['content']["message"] = $op_data['content']["label"] . "不能为空";
        } elseif (!Validate::range($post['content'], $op_data['content']['min_len'], $op_data['content']['max_len'])) {
            $op_data['content']["message"] = $op_data['content']["label"] .
                    "长度必须在" . $op_data['content']['min_len'] . "-" . $op_data['content']['max_len'] . "个字符之间";
        }

        //status
        if (in_array('status', $noset_keys)) {
            $op_data['status']["message"] = $op_data['status']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['status'])) {
            $op_data['status']["message"] = $op_data['status']["label"] . "不能为空";
        }
        //reference
        if (in_array('reference', $noset_keys)) {
            $op_data['reference']["message"] = $op_data['reference']["label"] . "没有定义";
        } elseif (!Validate::range($post['reference'], $op_data['reference']['min_len'], $op_data['reference']['max_len'])) {
            $op_data['reference']["message"] = $op_data['reference']["label"] .
                    "长度必须在" . $op_data['reference']['min_len'] . "-" . $op_data['reference']['max_len'] . "个字符之间";
        }
        //source
        if (in_array('source', $noset_keys)) {
            $op_data['source']["message"] = $op_data['source']["label"] . "没有定义";
        } elseif (!Validate::range($post['source'], $op_data['source']['min_len'], $op_data['source']['max_len'])) {
            $op_data['source']["message"] = $op_data['source']["label"] .
                    "长度必须在" . $op_data['source']['min_len'] . "-" . $op_data['source']['max_len'] . "个字符之间";
        }

        //将原有值保留到表单设置
        $form["create"] = $this->set_form_value($op_data, $post);
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
