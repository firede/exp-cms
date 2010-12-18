<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * 附件管理
 */

/**
 * Description of attachment
 *
 * @author Fanqie
 */
class Model_Attachment extends Model_Base {

    /**     * *****
     * 验证 数据

      public function post_validate($post, $type=NULL) {
      $form = Kohana::config("admin_category_form");
      $noset_keys = Arr::get_noset_key($post, array());
      $op_data = $form["create"];
      $categoryDao = new Database_Category();
      //第一阶段 未定义错误
      //第二阶段 数据非空验证
      //第三阶段 数据有效格式验证
      //第四阶段 数据有效性验证
      //url
      if (in_array('url', $noset_keys)) {
      $op_data['url']["message"] = $op_data['url']["label"] . "没有定义";
      } elseif (!Validate::not_empty($post['url'])) {
      $op_data['url']["message"] = $op_data['url']["label"] . "不能为空";
      } elseif (!Validate::range($post['url'], $op_data["url"]['min_len'], $op_data["url"]['max_len'])) {
      $op_data['url']["message"] = $op_data['url']["label"] .
      "长度必须在" . $op_data["url"]['min_len'] . "-" . $op_data["url"]['max_len'] . "个字符之间";
      } elseif (!($categoryDao->check_exist(array($post['url'])))) {
      $op_data['url']["message"] = "该" . $op_data['url']["label"] . "已经被占用，请重新输入";
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
     */
    /*     * ***
     * 清理垃圾附件
     */
    public function clear_rebbish($rubbish) {
        try {
            foreach ($rubbish as $file) {
                $path = APPPATH . "/" . $file["path"];
                $path = str_replace("\\", "/", $path);
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            return TRUE;
        } catch (Exception $e) {
            throw $e;
            return FALSE;
        }
    }

}

?>
