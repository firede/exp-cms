<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of setting
 *
 * @author Administrator
 */
class Model_Setting extends Model_Base {

    /**     * ****
     * 对站点配置更新数据 进行验证
     * @param $site array
     * @return array/bool 验证通过返回TRUE 反之输出 携带错误的表单信息
     */
    public function site_vilidate($site) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($post, array('webname', "basehost", "indexurl", 'default_style', 'powerby', 'keywords', 'description', 'beian'));
        $op_data = $form["site"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //webname
        if (in_array('webname', $noset_keys)) {
            $op_data['webname']["message"] = $op_data['webname']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['webname'])) {
            $op_data['webname']["message"] = $op_data['webname']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['webname']), $op_data["webname"]['min_len'], $op_data["webname"]['max_len'])) {
            $op_data["webname"]["message"] = $op_data['webname']["label"] .
                    "长度必须在" . $op_data["webname"]['min_len'] . "-" . $op_data["webname"]['max_len'] . "个字符之间";
        }
        //basehost
        if (in_array('basehost', $noset_keys)) {
            $op_data['basehost']["message"] = $op_data['basehost']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['basehost'])) {
            $op_data['basehost']["message"] = $op_data['basehost']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['basehost']), $op_data["basehost"]['min_len'], $op_data["basehost"]['max_len'])) {
            $op_data["basehost"]["message"] = $op_data['basehost']["label"] .
                    "长度必须在" . $op_data["basehost"]['min_len'] . "-" . $op_data["basehost"]['max_len'] . "个字符之间";
        } elseif (Validate::url($post['basehost'])) {

            $op_data['basehost']["message"] = $op_data['basehost']["label"] . " 必须为合法地址";
        }

        //default_style
        if (in_array('default_style', $noset_keys)) {
            $op_data['default_style']["message"] = $op_data['default_style']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['default_style'])) {
            $op_data['default_style']["message"] = $op_data['default_style']["label"] . "不能为空";
        }

        //powerby
        if (in_array('powerby', $noset_keys)) {
            $op_data['password']["message"] = $op_data['powerby']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['powerby'])) {
            $op_data['powerby']["message"] = $op_data['powerby']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['powerby']), $op_data['powerby']['min_len'], $op_data['powerby']['max_len'])) {
            $op_data['powerby']["message"] = $op_data['powerby']["label"] .
                    "长度必须在" . $op_data['powerby']['min_len'] . "-" . $op_data['powerby']['max_len'] . "个字符之间";
        }
        //keywords
        if (in_array('keywords', $noset_keys)) {
            $op_data['keywords']["message"] = $op_data['keywords']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['keywords'])) {
            $op_data['keywords']["message"] = $op_data['keywords']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['keywords']), $op_data['keywords']['min_len'], $op_data['keywords']['max_len'])) {
            $op_data['keywords']["message"] = $op_data['keywords']["label"] .
                    "长度必须在" . $op_data['keywords']['min_len'] . "-" . $op_data['keywords']['max_len'] . "个字符之间";
        }

        //description
        if (in_array('description', $noset_keys)) {
            $op_data['description']["message"] = $op_data['description']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['description'])) {
            $op_data['description']["message"] = $op_data['description']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['description']), $op_data['description']['min_len'], $op_data['description']['max_len'])) {
            $op_data['description']["message"] = $op_data['description']["label"] .
                    "长度必须在" . $op_data['description']['min_len'] . "-" . $op_data['description']['max_len'] . "个字符之间";
        }
        //beian
        if (in_array('beian', $noset_keys)) {
            $op_data['beian']["message"] = $op_data['beian']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['beian'])) {
            $op_data['beian']["message"] = $op_data['beian']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['beian']), $op_data['beian']['min_len'], $op_data['beian']['max_len'])) {
            $op_data['beian']["message"] = $op_data['beian']["label"] .
                    "长度必须在" . $op_data['beian']['min_len'] . "-" . $op_data['beian']['max_len'] . "个字符之间";
        }

        //将原有值保留到表单设置
        $form["site"] = $this->set_form_value($op_data, $post);
        if (!$this->has_error($form)) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    /**     * ****
     * 对站点配置更新数据 进行验证
     * @param $cache array
     * @return array/bool 验证通过返回TRUE 反之输出 携带错误的表单信息
     */
    public function cache_vilidate($cache) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($post, array('driver', "is_open",));
        $op_data = $form["cache"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //driver
        if (in_array('driver', $noset_keys)) {
            $op_data['driver']["message"] = $op_data['driver']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['driver'])) {
            $op_data['driver']["message"] = $op_data['driver']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['driver']), $op_data["driver"]['min_len'], $op_data["driver"]['max_len'])) {
            $op_data["driver"]["message"] = $op_data['driver']["label"] .
                    "长度必须在" . $op_data["driver"]['min_len'] . "-" . $op_data["driver"]['max_len'] . "个字符之间";
        }
        //is_open
        if (in_array('is_open', $noset_keys)) {
            $op_data['is_open']["message"] = $op_data['is_open']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['is_open'])) {
            $op_data['is_open']["message"] = $op_data['is_open']["label"] . "不能为空";
        }

        //将原有值保留到表单设置
        $form["cache"] = $this->set_form_value($op_data, $post);
        if (!$this->has_error($form)) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    /**     * ****
     * 对站点配置更新数据 进行验证
     * @param $user array
     * @return array/bool 验证通过返回TRUE 反之输出 携带错误的表单信息
     */
    public function user_vilidate($user) {
         $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($post, array("reg_open", "default_avatar"));
        $op_data = $form["user"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //webname
        if (in_array('reg_open', $noset_keys)) {
            $op_data['reg_open']["message"] = $op_data['reg_open']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['reg_open'])) {
            $op_data['reg_open']["message"] = $op_data['reg_open']["label"] . "不能为空";
        }  
        //default_avatar
        if (in_array('default_avatar', $noset_keys)) {
            $op_data['default_avatar']["message"] = $op_data['default_avatar']["label"] . "没有定义";
        }elseif (!(strlen($post['default_avatar'])> $op_data["default_avatar"]['max_len'])) {
            $op_data["default_avatar"]["message"] = $op_data['default_avatar']["label"] .
                    "长度必须在不能超过"  . $op_data["default_avatar"]['max_len'] . "个字符";
        } elseif (!(Validate::regex($post['default_avatar'], "(^\\.|^/|^[a-zA-Z])?:?/.+(/$)?") || Validate::url($post['default_avatar']))) {
            $op_data['default_avatar']["message"] = $op_data['default_avatar']["label"] . "为非法格式";
        }
        
        //将原有值保留到表单设置
        $form["user"] = $this->set_form_value($op_data, $post);
        if (!$this->has_error($form)) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    /**     * ****
     * 对站点配置更新数据 进行验证
     * @param $up_file array
     * @return array/bool 验证通过返回TRUE 反之输出 携带错误的表单信息
     */
    public function file_vilidate($up_file) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($post, array("dir", "max_size", "min_size", "type"));
        $op_data = $form["file"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //webname
        if (in_array('dir', $noset_keys)) {
            $op_data['dir']["message"] = $op_data['dir']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['dir'])) {
            $op_data['dir']["message"] = $op_data['dir']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['dir']), $op_data["dir"]['min_len'], $op_data["dir"]['max_len'])) {
            $op_data["dir"]["message"] = $op_data['dir']["label"] .
                    "长度必须在" . $op_data["dir"]['min_len'] . "-" . $op_data["dir"]['max_len'] . "个字符之间";
        } elseif (!(Validate::regex($post['dir'], "(^\\.|^/|^[a-zA-Z])?:?/.+(/$)?") || Validate::url($post['dir']))) {
            $op_data['dir']["message"] = $op_data['dir']["label"] . "为非法格式";
        }
        
        //max_size
        if (in_array('max_size', $noset_keys)) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['max_size'])) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . "不能为空";
        } elseif (!is_integer($post['max_size'])) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($post['max_size'], $op_data["max_size"]['min_len'], $op_data["max_size"]['max_len'])) {
            $op_data["max_size"]["message"] = $op_data['max_size']["label"] .
                    "大小必须在" . $op_data["max_size"]['min_len'] . "-" . $op_data["max_size"]['max_len'] . "个字符之间";
        }

        //min_size
        if (in_array('min_size', $noset_keys)) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['min_size'])) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . "不能为空";
        } elseif (!is_integer($post['min_size'])) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($post['min_size'], $op_data["min_size"]['min_len'], $op_data["min_size"]['max_len'])) {
            $op_data["min_size"]["message"] = $op_data['min_size']["label"] .
                    "大小必须在" . $op_data["min_size"]['min_len'] . "-" . $op_data["min_size"]['max_len'] . "个字符之间";
        }

        //type
        if (in_array('type', $noset_keys)) {
            $op_data['type']["message"] = $op_data['type']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['type'])) {
            $op_data['type']["message"] = $op_data['type']["label"] . "不能为空";
        }
        //将原有值保留到表单设置
        $form["file"] = $this->set_form_value($op_data, $post);
        if (!$this->has_error($form)) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    /**     * ****
     * 对站点配置更新数据 进行验证
     * @param $up_img array
     * @return array/bool 验证通过返回TRUE 反之输出 携带错误的表单信息
     */
    public function up_img_vilidate($up_img) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($post, array("dir", "max_size", "min_size", "max_width", "max_height", "type", "watermark_path", "watermark_position", "watermark_opacity", "watermark_status", "watermark_border_space",));
        $op_data = $form["up_img"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //dir
        if (in_array('dir', $noset_keys)) {
            $op_data['dir']["message"] = $op_data['dir']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['dir'])) {
            $op_data['dir']["message"] = $op_data['dir']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['dir']), $op_data["dir"]['min_len'], $op_data["dir"]['max_len'])) {
            $op_data["dir"]["message"] = $op_data['dir']["label"] .
                    "长度必须在" . $op_data["dir"]['min_len'] . "-" . $op_data["dir"]['max_len'] . "个字符之间";
        } elseif (!(Validate::regex($post['dir'], "(^\\.|^/|^[a-zA-Z])?:?/.+(/$)?") || Validate::url($post['dir']))) {
            $op_data['dir']["message"] = $op_data['dir']["label"] . "为非法格式";
        }
        //max_size
        if (in_array('max_size', $noset_keys)) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['max_size'])) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . "不能为空";
        } elseif (!is_integer($post['max_size'])) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($post['max_size'], $op_data["max_size"]['min_len'], $op_data["max_size"]['max_len'])) {
            $op_data["max_size"]["message"] = $op_data['max_size']["label"] .
                    "大小必须在" . $op_data["max_size"]['min_len'] . "-" . $op_data["max_size"]['max_len'] . "个字符之间";
        }

        //min_size
        if (in_array('min_size', $noset_keys)) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['min_size'])) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . "不能为空";
        } elseif (!is_integer($post['min_size'])) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($post['min_size'], $op_data["min_size"]['min_len'], $op_data["min_size"]['max_len'])) {
            $op_data["min_size"]["message"] = $op_data['min_size']["label"] .
                    "大小必须在" . $op_data["min_size"]['min_len'] . "-" . $op_data["min_size"]['max_len'] . "个字符之间";
        }
        //max_width
        if (in_array('max_width', $noset_keys)) {
            $op_data['max_width']["message"] = $op_data['max_width']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['max_width'])) {
            $op_data['max_width']["message"] = $op_data['max_width']["label"] . "不能为空";
        } elseif (!is_integer($post['max_width'])) {
            $op_data['max_width']["message"] = $op_data['max_width']["label"] . " 必须为整数";
        } elseif (!Validate::range($post['max_width'], $op_data["max_size"]['min_len'], $op_data["max_width"]['max_len'])) {
            $op_data["max_width"]["message"] = $op_data['max_width']["label"] .
                    "大小必须在" . $op_data["max_width"]['min_len'] . "-" . $op_data["max_width"]['max_len'] . "个字符之间";
        }
        //max_height
        if (in_array('max_height', $noset_keys)) {
            $op_data['max_height']["message"] = $op_data['max_height']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['max_height'])) {
            $op_data['max_height']["message"] = $op_data['max_height']["label"] . "不能为空";
        } elseif (!is_integer($post['max_height'])) {
            $op_data['max_height']["message"] = $op_data['max_height']["label"] . " 必须为整数";
        } elseif (!Validate::range($post['max_height'], $op_data["max_height"]['min_len'], $op_data["max_height"]['max_len'])) {
            $op_data["max_height"]["message"] = $op_data['max_height']["label"] .
                    "大小必须在" . $op_data["max_height"]['min_len'] . "-" . $op_data["max_height"]['max_len'] . "个字符之间";
        }
        //type
        if (in_array('type', $noset_keys)) {
            $op_data['type']["message"] = $op_data['type']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['type'])) {
            $op_data['type']["message"] = $op_data['type']["label"] . "不能为空";
        }
        //watermark_path 直接上传的返回的路径 由隐藏域获得
        if (in_array('watermark_path', $noset_keys)) {
            $op_data['watermark_path']["message"] = $op_data['watermark_path']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['dir'])) {
            $op_data['watermark_path']["message"] = $op_data['watermark_path']["label"] . "不能为空";
        } elseif (!Validate::range(strlen($post['watermark_path']), $op_data["watermark_path"]['min_len'], $op_data["watermark_path"]['max_len'])) {
            $op_data["watermark_path"]["message"] = $op_data['watermark_path']["label"] .
                    "长度必须在" . $op_data["watermark_path"]['min_len'] . "-" . $op_data["watermark_path"]['max_len'] . "个字符之间";
        } elseif (!(Validate::regex($post['watermark_path'], "(^\\.|^/|^[a-zA-Z])?:?/.+(/$)?") || Validate::url($post['watermark_path']))) {
            $op_data['watermark_path']["message"] = $op_data['watermark_path']["label"] . "为非法格式";
        }

        //watermark_position
        if (in_array('watermark_position', $noset_keys)) {
            $op_data['watermark_position']["message"] = $op_data['watermark_position']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['watermark_position'])) {
            $op_data['watermark_position']["message"] = $op_data['watermark_position']["label"] . "不能为空";
        } elseif (!is_integer($post['watermark_position'])) {
            $op_data['watermark_position']["message"] = $op_data['watermark_position']["label"] . "必须为整数";
        } elseif (!Validate::range($post['watermark_position'], $op_data['watermark_position']['min_len'], $op_data['watermark_position']['max_len'])) {
            $op_data['watermark_position']["message"] = $op_data['watermark_position']["label"] .
                    "大小必须在" . $op_data['watermark_position']['min_len'] . "-" . $op_data['watermark_position']['max_len'] . "个字符之间";
        }

        //watermark_opacity
        if (in_array('watermark_opacity', $noset_keys)) {
            $op_data['watermark_opacity']["message"] = $op_data['watermark_opacity']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['watermark_opacity'])) {
            $op_data['watermark_opacity']["message"] = $op_data['watermark_opacity']["label"] . "不能为空";
        } elseif (!is_integer($post['watermark_opacity'])) {
            $op_data['watermark_opacity']["message"] = $op_data['watermark_opacity']["label"] . "必须为整数";
        } elseif (!Validate::range($post['watermark_opacity'], $op_data['watermark_opacity']['min_len'], $op_data['watermark_opacity']['max_len'])) {
            $op_data['watermark_opacity']["message"] = $op_data['watermark_opacity']["label"] .
                    "大小必须在" . $op_data['watermark_opacity']['min_len'] . "-" . $op_data['watermark_opacity']['max_len'] . "个字符之间";
        }
        //watermark_status
        if (in_array('watermark_status', $noset_keys)) {
            $op_data['watermark_status']["message"] = $op_data['watermark_status']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['watermark_opacity'])) {
            $op_data['watermark_status']["message"] = $op_data['watermark_status']["label"] . "不能为空";
        }
        //watermark_border_space
        if (in_array('watermark_border_space', $noset_keys)) {
            $op_data['watermark_border_space']["message"] = $op_data['watermark_border_space']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['watermark_border_space'])) {
            $op_data['watermark_border_space']["message"] = $op_data['watermark_border_space']["label"] . "不能为空";
        } elseif (!is_integer($post['watermark_border_space'])) {
            $op_data['watermark_border_space']["message"] = $op_data['watermark_border_space']["label"] . "必须为整数";
        } elseif (!Validate::range($post['watermark_border_space'], $op_data['watermark_border_space']['min_len'], $op_data['watermark_border_space']['max_len'])) {
            $op_data['watermark_border_space']["message"] = $op_data['watermark_border_space']["label"] .
                    "大小必须在" . $op_data['watermark_opacity']['min_len'] . "-" . $op_data['watermark_border_space']['max_len'] . "个字符之间";
        }

        //将原有值保留到表单设置
        $form["up_img"] = $this->set_form_value($op_data, $post);
        if (!$this->has_error($form)) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    /**     * ****
     * 对站点配置更新数据 进行验证
     * @param $post array
     * @return array/bool 验证通过返回TRUE 反之输出 携带错误的表单信息
     */
    public function post_vilidate($post) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($post, array('title_repeat'));
        $op_data = $form["post"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
       
        //title_repeat
        if (in_array('title_repeat', $noset_keys)) {
            $op_data['title_repeat']["message"] = $op_data['title_repeat']["label"] . "没有定义";
        } elseif (!Validate::not_empty($post['title_repeat'])) {
            $op_data['title_repeat']["message"] = $op_data['title_repeat']["label"] . "不能为空";
        }

       
        //将原有值保留到表单设置
        $form["post"] = $this->set_form_value($op_data, $post, array("password", "re_password"), array());
        if (!$this->has_error($form)) {

            return array(
                "success" => FALSE,
                "data" => $form,
            );
        }
        return TRUE;
    }

    /**     * ****
     * 对站点配置更新数据 进行验证
     * @param $advanced array
     * @return array/bool 验证通过返回TRUE 反之输出 携带错误的表单信息
     */
    public function advanced_vilidate($advanced) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($post, array('webname', "basehost", "indexurl", 'default_style', 'powerby', 'keywords', 'description', 'beian'));
        $op_data = $form["advanced"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //webname
        if (in_array('throw_exception', $noset_keys)) {
            $op_data['throw_exception']["message"] = $op_data['throw_exception']["label"] . "没有定义";
        }

        //将原有值保留到表单设置
        $form["advanced"] = $this->set_form_value($op_data, $post);
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
