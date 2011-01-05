<?php
defined('SYSPATH') or die('No direct script access.');
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
    public function site_validate($site) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($site, array('webname', "basehost", "indexurl", 'default_style', 'powerby', 'keywords', 'description', 'beian'));
        $op_data = $form["site"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //webname
        if (in_array('webname', $noset_keys)) {
            $op_data['webname']["message"] = $op_data['webname']["label"] . "没有定义";
        } elseif (!Validate::not_empty($site['webname'])) {
            $op_data['webname']["message"] = $op_data['webname']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($site['webname'], $op_data["webname"])) {
            $op_data["webname"]["message"] = $op_data['webname']["label"] .
                    "长度必须在" . $op_data["webname"]['min_len'] . "-" . $op_data["webname"]['max_len'] . "个字符之间";
        }
        //basehost
        if (in_array('basehost', $noset_keys)) {
            $op_data['basehost']["message"] = $op_data['basehost']["label"] . "没有定义";
        } elseif (!Validate::not_empty($site['basehost'])) {
            $op_data['basehost']["message"] = $op_data['basehost']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($site['basehost'], $op_data["basehost"])) {
            $op_data["basehost"]["message"] = $op_data['basehost']["label"] .
                    "长度必须在" . $op_data["basehost"]['min_len'] . "-" . $op_data["basehost"]['max_len'] . "个字符之间";
        } elseif (Validate::url($site['basehost'])) {

            $op_data['basehost']["message"] = $op_data['basehost']["label"] . " 必须为合法地址";
        }

        //default_style
        if (in_array('default_style', $noset_keys)) {
            $op_data['default_style']["message"] = $op_data['default_style']["label"] . "没有定义";
        } elseif (!Validate::not_empty($site['default_style'])) {
            $op_data['default_style']["message"] = $op_data['default_style']["label"] . "不能为空";
        }

        //powerby
        if (in_array('copyright', $noset_keys)) {
            $op_data['copyright']["message"] = $op_data['copyright']["label"] . "没有定义";
        } elseif (!Validate::not_empty($site['copyright'])) {
            $op_data['copyright']["message"] = $op_data['copyright']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($site['copyright'], $op_data['copyright'])) {
            $op_data['copyright']["message"] = $op_data['copyright']["label"] .
                    "长度必须在" . $op_data['copyright']['min_len'] . "-" . $op_data['copyright']['max_len'] . "个字符之间";
        }
        //keywords
        if (in_array('keywords', $noset_keys)) {
            $op_data['keywords']["message"] = $op_data['keywords']["label"] . "没有定义";
        } elseif (!Validate::not_empty($site['keywords'])) {
            $op_data['keywords']["message"] = $op_data['keywords']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($site['keywords'], $op_data['keywords'])) {
            $op_data['keywords']["message"] = $op_data['keywords']["label"] .
                    "长度必须在" . $op_data['keywords']['min_len'] . "-" . $op_data['keywords']['max_len'] . "个字符之间";
        }

        //description
        if (in_array('description', $noset_keys)) {
            $op_data['description']["message"] = $op_data['description']["label"] . "没有定义";
        } elseif (!Validate::not_empty($site['description'])) {
            $op_data['description']["message"] = $op_data['description']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($site['description'], $op_data['description'])) {
            $op_data['description']["message"] = $op_data['description']["label"] .
                    "长度必须在" . $op_data['description']['min_len'] . "-" . $op_data['description']['max_len'] . "个字符之间";
        }
        //beian
        if (in_array('beian', $noset_keys)) {
            $op_data['beian']["message"] = $op_data['beian']["label"] . "没有定义";
        } elseif (!Validate::not_empty($site['beian'])) {
            $op_data['beian']["message"] = $op_data['beian']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($site['beian'], $op_data['beian'])) {
            $op_data['beian']["message"] = $op_data['beian']["label"] .
                    "长度必须在" . $op_data['beian']['min_len'] . "-" . $op_data['beian']['max_len'] . "个字符之间";
        }

        //将原有值保留到表单设置
        $form["site"] = $this->set_form_value($op_data, $site);
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
    public function cache_validate($cache) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($cache, array('driver', "is_open",));
        $op_data = $form["cache"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //driver
        if (in_array('driver', $noset_keys)) {
            $op_data['driver']["message"] = $op_data['driver']["label"] . "没有定义";
        } elseif (!Validate::not_empty($cache['driver'])) {
            $op_data['driver']["message"] = $op_data['driver']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($cache['driver'], $op_data["driver"])) {
            $op_data["driver"]["message"] = $op_data['driver']["label"] .
                    "长度必须在" . $op_data["driver"]['min_len'] . "-" . $op_data["driver"]['max_len'] . "个字符之间";
        }
        //is_open
        if (in_array('is_open', $noset_keys)) {
            $op_data['is_open']["message"] = $op_data['is_open']["label"] . "没有定义";
        } elseif (!Validate::not_empty($cache['is_open'])) {
            $op_data['is_open']["message"] = $op_data['is_open']["label"] . "不能为空";
        }

        //将原有值保留到表单设置
        $form["cache"] = $this->set_form_value($op_data, $cache);
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
    public function user_validate($user) {
         $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($user, array("reg_open", "default_avatar",'up_avatar.path','up_avatar.max_size','up_avatar.min_size','up_avatar.max_width','up_avatar.max_height','up_avatar.type','up_avatar.watermark_path','up_avatar.watermark_position','up_avatar.watermark_opacity','up_avatar.watermark_status','up_avatar.watermark_border_space'));
        $op_data = $form["user"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //webname
        if (in_array('reg_open', $noset_keys)) {
            $op_data['reg_open']["message"] = $op_data['reg_open']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['reg_open'])) {
            $op_data['reg_open']["message"] = $op_data['reg_open']["label"] . "不能为空";
        }  
        //default_avatar
        if (in_array('default_avatar', $noset_keys)) {
            $op_data['default_avatar']["message"] = $op_data['default_avatar']["label"] . "没有定义";
        }elseif (!$this->validate_length_range ($user['default_avatar'], $op_data["default_avatar"])) {
            $op_data["default_avatar"]["message"] = $op_data['default_avatar']["label"] .
                    "长度不能超过"  . $op_data["default_avatar"]['max_len'] . "个字符";
         } elseif (!(Validate::regex($user['default_avatar'], "/^([\/] [\w-]+)*$/")||Validate::regex($user['default_avatar'], " /^[a-zA-Z];[\\/]((?! )(?![^\\/]*\s+[\\/])[\w -]+[\\/])*(?! )(?![^.]+\s+\.)[\w -]+$/") || Validate::url($user['default_avatar']))) {
            $op_data['default_avatar']["message"] = $op_data['default_avatar']["label"] . "为非法格式";
        }
         if (in_array('up_avatar.path', $noset_keys)) {
            $op_data['up_avatar.path']["message"] = $op_data['up_avatar.path']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.path'])) {
            $op_data['up_avatar.path']["message"] = $op_data['up_avatar.path']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($user['up_avatar.path'], $op_data["up_avatar.path"])) {
            $op_data["up_avatar.path"]["message"] = $op_data['up_avatar.path']["label"] .
                    "长度必须在" . $op_data["up_avatar.path"]['min_len'] . "-" . $op_data["up_avatar.path"]['max_len'] . "个字符之间";
        } elseif (!(Validate::regex($user['up_avatar.path'], "/^([\/] [\w-]+)*$/")||Validate::regex($user['up_avatar.path'], " /^[a-zA-Z];[\\/]((?! )(?![^\\/]*\s+[\\/])[\w -]+[\\/])*(?! )(?![^.]+\s+\.)[\w -]+$/") || Validate::url($user['up_avatar.path']))) {
            $op_data['up_avatar.path']["message"] = $op_data['up_avatar.path']["label"] . "为非法格式";
        }
        //max_size
        if (in_array('up_avatar.max_size', $noset_keys)) {
            $op_data['up_avatar.max_size']["message"] = $op_data['up_avatar.max_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.max_size'])) {
            $op_data['up_avatar.max_size']["message"] = $op_data['up_avatar.max_size']["label"] . "不能为空";
        } elseif (!is_integer($user['up_avatar.max_size'])) {
            $op_data['up_avatar.max_size']["message"] = $op_data['up_avatar.max_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($user['max_size'], $op_data["up_avatar.max_size"]['min_len'], $op_data["up_avatar.max_size"]['max_len'])) {
            $op_data["up_avatar.max_size"]["message"] = $op_data['up_avatar.max_size']["label"] .
                    "大小必须在" . $op_data["up_avatar.max_size"]['min_len'] . "-" . $op_data["max_size"]['max_len'] . "之间";
        }

        //min_size
        if (in_array('up_avatar.min_size', $noset_keys)) {
            $op_data['up_avatar.min_size']["message"] = $op_data['up_avatar.min_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.min_size'])) {
            $op_data['up_avatar.min_size']["message"] = $op_data['up_avatar.min_size']["label"] . "不能为空";
        } elseif (!is_integer($user['up_avatar.min_size'])) {
            $op_data['up_avatar.min_size']["message"] = $op_data['up_avatar.min_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($user['up_avatar.min_size'], $op_data["up_avatar.min_size"]['min_len'], $op_data["up_avatar.min_size"]['max_len'])) {
            $op_data["up_avatar.min_size"]["message"] = $op_data['up_avatar.min_size']["label"] .
                    "大小必须在" . $op_data["up_avatar.min_size"]['min_len'] . "-" . $op_data["up_avatar.min_size"]['max_len'] . "之间";
        }
        //max_width
        if (in_array('up_avatar.max_width', $noset_keys)) {
            $op_data['up_avatar.max_width']["message"] = $op_data['up_avatar.max_width']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.max_width'])) {
            $op_data['up_avatar.max_width']["message"] = $op_data['up_avatar.max_width']["label"] . "不能为空";
        } elseif (!is_integer($user['up_avatar.max_width'])) {
            $op_data['up_avatar.max_width']["message"] = $op_data['up_avatar.max_width']["label"] . " 必须为整数";
        } elseif (!Validate::range($user['up_avatar.max_width'], $op_data["up_avatar.max_size"]['min_len'], $op_data["up_avatar.max_width"]['max_len'])) {
            $op_data["up_avatar.max_width"]["message"] = $op_data['up_avatar.max_width']["label"] .
                    "大小必须在" . $op_data["max_width"]['min_len'] . "-" . $op_data["max_width"]['max_len'] . "之间";
        }
        //max_height
        if (in_array('up_avatar.max_height', $noset_keys)) {
            $op_data['up_avatar.max_height']["message"] = $op_data['up_avatar.max_height']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.max_height'])) {
            $op_data['up_avatar.max_height']["message"] = $op_data['up_avatar.max_height']["label"] . "不能为空";
        } elseif (!is_integer($user['up_avatar.max_height'])) {
            $op_data['up_avatar.max_height']["message"] = $op_data['up_avatar.max_height']["label"] . " 必须为整数";
        } elseif (!Validate::range($user['up_avatar.max_height'], $op_data["up_avatar.max_height"]['min_len'], $op_data["up_avatar.max_height"]['max_len'])) {
            $op_data["up_avatar.max_height"]["message"] = $op_data['up_avatar.max_height']["label"] .
                    "大小必须在" . $op_data["up_avatar.max_height"]['min_len'] . "-" . $op_data["up_avatar.max_height"]['max_len'] . "个字符之间";
        }
        //type
        if (in_array('up_avatar.type', $noset_keys)) {
            $op_data['up_avatar.type']["message"] = $op_data['up_avatar.type']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.type'])) {
            $op_data['up_avatar.type']["message"] = $op_data['up_avatar.type']["label"] . "不能为空";
        }
        //watermark_path 直接上传的返回的路径 由隐藏域获得
        if (in_array('up_avatar.watermark_path', $noset_keys)) {
            $op_data['up_avatar.watermark_path']["message"] = $op_data['up_avatar.watermark_path']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.watermark_path'])) {
            $op_data['up_avatar.watermark_path']["message"] = $op_data['up_avatar.watermark_path']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($user['up_avatar.watermark_path'], $op_data["up_avatar.watermark_path"])) {
            $op_data["up_avatar.watermark_path"]["message"] = $op_data['up_avatar.watermark_path']["label"] .
                    "长度必须在" . $op_data["up_avatar.watermark_path"]['min_len'] . "-" . $op_data["up_avatar.watermark_path"]['max_len'] . "个字符之间";
        } elseif (!(Validate::regex($user['up_avatar.watermark_path'], "/^([\/] [\w-]+)*$/")||Validate::regex($user['up_avatar.watermark_path'], " /^[a-zA-Z];[\\/]((?! )(?![^\\/]*\s+[\\/])[\w -]+[\\/])*(?! )(?![^.]+\s+\.)[\w -]+$/") || Validate::url($user['up_avatar.watermark_path']))) {
            $op_data['up_avatar.watermark_path']["message"] = $op_data['up_avatar.watermark_path']["label"] . "为非法格式";
        }

        //watermark_position
        if (in_array('up_avatar.watermark_position', $noset_keys)) {
            $op_data['up_avatar.watermark_position']["message"] = $op_data['up_avatar.watermark_position']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.watermark_position'])) {
            $op_data['up_avatar.watermark_position']["message"] = $op_data['up_avatar.watermark_position']["label"] . "不能为空";
        } elseif (!is_integer($user['up_avatar.watermark_position'])) {
            $op_data['up_avatar.watermark_position']["message"] = $op_data['up_avatar.watermark_position']["label"] . "必须为整数";
        } elseif (!Validate::range($user['up_avatar.watermark_position'], $op_data['up_avatar.watermark_position']['min_len'], $op_data['up_avatar.watermark_position']['max_len'])) {
            $op_data['up_avatar.watermark_position']["message"] = $op_data['up_avatar.watermark_position']["label"] .
                    "大小必须在" . $op_data['up_avatar.watermark_position']['min_len'] . "-" . $op_data['up_avatar.watermark_position']['max_len'] . "之间";
        }

        //watermark_opacity
        if (in_array('up_avatar.watermark_opacity', $noset_keys)) {
            $op_data['up_avatar.watermark_opacity']["message"] = $op_data['up_avatar.watermark_opacity']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.watermark_opacity'])) {
            $op_data['up_avatar.watermark_opacity']["message"] = $op_data['up_avatar.watermark_opacity']["label"] . "不能为空";
        } elseif (!is_integer($user['up_avatar.watermark_opacity'])) {
            $op_data['up_avatar.watermark_opacity']["message"] = $op_data['up_avatar.watermark_opacity']["label"] . "必须为整数";
        } elseif (!Validate::range($user['up_avatar.watermark_opacity'], $op_data['up_avatar.watermark_opacity']['min_len'], $op_data['up_avatar.watermark_opacity']['max_len'])) {
            $op_data['up_avatar.watermark_opacity']["message"] = $op_data['up_avatar.watermark_opacity']["label"] .
                    "大小必须在" . $op_data['up_avatar.watermark_opacity']['min_len'] . "-" . $op_data['up_avatar.watermark_opacity']['max_len'] . "之间";
        }
        //watermark_status
        if (in_array('up_avatar.watermark_status', $noset_keys)) {
            $op_data['up_avatar.watermark_status']["message"] = $op_data['up_avatar.watermark_status']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.watermark_opacity'])) {
            $op_data['up_avatar.watermark_status']["message"] = $op_data['up_avatar.watermark_status']["label"] . "不能为空";
        }
        //watermark_border_space
        if (in_array('up_avatar.watermark_border_space', $noset_keys)) {
            $op_data['up_avatar.watermark_border_space']["message"] = $op_data['up_avatar.watermark_border_space']["label"] . "没有定义";
        } elseif (!Validate::not_empty($user['up_avatar.watermark_border_space'])) {
            $op_data['up_avatar.watermark_border_space']["message"] = $op_data['up_avatar.watermark_border_space']["label"] . "不能为空";
        } elseif (!is_integer($user['up_avatar.watermark_border_space'])) {
            $op_data['up_avatar.watermark_border_space']["message"] = $op_data['up_avatar.watermark_border_space']["label"] . "必须为整数";
        } elseif (!Validate::range($user['up_avatar.watermark_border_space'], $op_data['up_avatar.watermark_border_space']['min_len'], $op_data['up_avatar.watermark_border_space']['max_len'])) {
            $op_data['up_avatar.watermark_border_space']["message"] = $op_data['up_avatar.watermark_border_space']["label"] .
                    "大小必须在" . $op_data['up_avatar.watermark_opacity']['min_len'] . "-" . $op_data['up_avatar.watermark_border_space']['max_len'] . "之间";
        }
        //将原有值保留到表单设置
        $form["user"] = $this->set_form_value($op_data, $user);
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
    public function up_file_validate($up_file) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($up_file, array("path", "max_size", "min_size", "type"));
        $op_data = $form["up_file"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //webname
        if (in_array('path', $noset_keys)) {
            $op_data['path']["message"] = $op_data['path']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_file['path'])) {
            $op_data['path']["message"] = $op_data['path']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($up_file['path'], $op_data["path"])) {
            $op_data["path"]["message"] = $op_data['path']["label"] .
                    "长度必须在" . $op_data["path"]['min_len'] . "-" . $op_data["path"]['max_len'] . "个字符之间";
         } elseif (!(Validate::regex($up_file['path'], "/^([\/] [\w-]+)*$/")||Validate::regex($up_file['path'], " /^[a-zA-Z];[\\/]((?! )(?![^\\/]*\s+[\\/])[\w -]+[\\/])*(?! )(?![^.]+\s+\.)[\w -]+$/") || Validate::url($up_file['path']))) {
            $op_data['path']["message"] = $op_data['path']["label"] . "为非法格式";
        }
        
        //max_size
        if (in_array('max_size', $noset_keys)) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_file['max_size'])) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . "不能为空";
        } elseif (!is_integer($up_file['max_size'])) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($up_file['max_size'], $op_data["max_size"]['min_len'], $op_data["max_size"]['max_len'])) {
            $op_data["max_size"]["message"] = $op_data['max_size']["label"] .
                    "大小必须在" . $op_data["max_size"]['min_len'] . "-" . $op_data["max_size"]['max_len'] . "之间";
        }

        //min_size
        if (in_array('min_size', $noset_keys)) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_file['min_size'])) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . "不能为空";
        } elseif (!is_integer($up_file['min_size'])) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($up_file['min_size'], $op_data["min_size"]['min_len'], $op_data["min_size"]['max_len'])) {
            $op_data["min_size"]["message"] = $op_data['min_size']["label"] .
                    "大小必须在" . $op_data["min_size"]['min_len'] . "-" . $op_data["min_size"]['max_len'] . "之间";
        }

        //type
        if (in_array('type', $noset_keys)) {
            $op_data['type']["message"] = $op_data['type']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_file['type'])) {
            $op_data['type']["message"] = $op_data['type']["label"] . "不能为空";
        }
        
        //将原有值保留到表单设置
        $form["up_file"] = $this->set_form_value($op_data, $up_file);
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
    public function up_img_validate($up_img) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($up_img, array("path", "max_size", "min_size", "max_width", "max_height", "type", "watermark_path", "watermark_position", "watermark_opacity", "watermark_status", "watermark_border_space",));
        $op_data = $form["up_img"];
        //第一阶段 未定义错误
        //第二阶段 数据非空验证
        //第三阶段 数据有效格式验证
        //第四阶段 数据有效性验证
        //dir
        if (in_array('path', $noset_keys)) {
            $op_data['path']["message"] = $op_data['path']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['path'])) {
            $op_data['path']["message"] = $op_data['path']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($up_img['path'], $op_data["path"])) {
            $op_data["path"]["message"] = $op_data['path']["label"] .
                    "长度必须在" . $op_data["path"]['min_len'] . "-" . $op_data["path"]['max_len'] . "个字符之间";
        } elseif (!(Validate::regex($up_img['path'], "/^([\/] [\w-]+)*$/")||Validate::regex($up_img['path'], " /^[a-zA-Z];[\\/]((?! )(?![^\\/]*\s+[\\/])[\w -]+[\\/])*(?! )(?![^.]+\s+\.)[\w -]+$/") || Validate::url($up_img['path']))) {
            $op_data['path']["message"] = $op_data['path']["label"] . "为非法格式";
        }
        //max_size
        if (in_array('max_size', $noset_keys)) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['max_size'])) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . "不能为空";
        } elseif (!is_integer($up_img['max_size'])) {
            $op_data['max_size']["message"] = $op_data['max_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($up_img['max_size'], $op_data["max_size"]['min_len'], $op_data["max_size"]['max_len'])) {
            $op_data["max_size"]["message"] = $op_data['max_size']["label"] .
                    "大小必须在" . $op_data["max_size"]['min_len'] . "-" . $op_data["max_size"]['max_len'] . "之间";
        }

        //min_size
        if (in_array('min_size', $noset_keys)) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['min_size'])) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . "不能为空";
        } elseif (!is_integer($up_img['min_size'])) {
            $op_data['min_size']["message"] = $op_data['min_size']["label"] . " 必须为整数";
        } elseif (!Validate::range($up_img['min_size'], $op_data["min_size"]['min_len'], $op_data["min_size"]['max_len'])) {
            $op_data["min_size"]["message"] = $op_data['min_size']["label"] .
                    "大小必须在" . $op_data["min_size"]['min_len'] . "-" . $op_data["min_size"]['max_len'] . "之间";
        }
        //max_width
        if (in_array('max_width', $noset_keys)) {
            $op_data['max_width']["message"] = $op_data['max_width']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['max_width'])) {
            $op_data['max_width']["message"] = $op_data['max_width']["label"] . "不能为空";
        } elseif (!is_integer($up_img['max_width'])) {
            $op_data['max_width']["message"] = $op_data['max_width']["label"] . " 必须为整数";
        } elseif (!Validate::range($up_img['max_width'], $op_data["max_size"]['min_len'], $op_data["max_width"]['max_len'])) {
            $op_data["max_width"]["message"] = $op_data['max_width']["label"] .
                    "大小必须在" . $op_data["max_width"]['min_len'] . "-" . $op_data["max_width"]['max_len'] . "之间";
        }
        //max_height
        if (in_array('max_height', $noset_keys)) {
            $op_data['max_height']["message"] = $op_data['max_height']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['max_height'])) {
            $op_data['max_height']["message"] = $op_data['max_height']["label"] . "不能为空";
        } elseif (!is_integer($up_img['max_height'])) {
            $op_data['max_height']["message"] = $op_data['max_height']["label"] . " 必须为整数";
        } elseif (!Validate::range($up_img['max_height'], $op_data["max_height"]['min_len'], $op_data["max_height"]['max_len'])) {
            $op_data["max_height"]["message"] = $op_data['max_height']["label"] .
                    "大小必须在" . $op_data["max_height"]['min_len'] . "-" . $op_data["max_height"]['max_len'] . "个字符之间";
        }
        //type
        if (in_array('type', $noset_keys)) {
            $op_data['type']["message"] = $op_data['type']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['type'])) {
            $op_data['type']["message"] = $op_data['type']["label"] . "不能为空";
        }
        //watermark_path 直接上传的返回的路径 由隐藏域获得
        if (in_array('watermark_path', $noset_keys)) {
            $op_data['watermark_path']["message"] = $op_data['watermark_path']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['path'])) {
            $op_data['watermark_path']["message"] = $op_data['watermark_path']["label"] . "不能为空";
        } elseif (!$this->validate_length_range ($up_img['watermark_path'], $op_data["watermark_path"])) {
            $op_data["watermark_path"]["message"] = $op_data['watermark_path']["label"] .
                    "长度必须在" . $op_data["watermark_path"]['min_len'] . "-" . $op_data["watermark_path"]['max_len'] . "个字符之间";
        } elseif (!(Validate::regex($up_img['watermark_path'], "/^([\/] [\w-]+)*$/")||Validate::regex($up_img['watermark_path'], " /^[a-zA-Z];[\\/]((?! )(?![^\\/]*\s+[\\/])[\w -]+[\\/])*(?! )(?![^.]+\s+\.)[\w -]+$/") || Validate::url($up_img['watermark_path']))) {
            $op_data['watermark_path']["message"] = $op_data['watermark_path']["label"] . "为非法格式";
        }

        //watermark_position
        if (in_array('watermark_position', $noset_keys)) {
            $op_data['watermark_position']["message"] = $op_data['watermark_position']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['watermark_position'])) {
            $op_data['watermark_position']["message"] = $op_data['watermark_position']["label"] . "不能为空";
        } elseif (!is_integer($up_img['watermark_position'])) {
            $op_data['watermark_position']["message"] = $op_data['watermark_position']["label"] . "必须为整数";
        } elseif (!Validate::range($up_img['watermark_position'], $op_data['watermark_position']['min_len'], $op_data['watermark_position']['max_len'])) {
            $op_data['watermark_position']["message"] = $op_data['watermark_position']["label"] .
                    "大小必须在" . $op_data['watermark_position']['min_len'] . "-" . $op_data['watermark_position']['max_len'] . "之间";
        }

        //watermark_opacity
        if (in_array('watermark_opacity', $noset_keys)) {
            $op_data['watermark_opacity']["message"] = $op_data['watermark_opacity']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['watermark_opacity'])) {
            $op_data['watermark_opacity']["message"] = $op_data['watermark_opacity']["label"] . "不能为空";
        } elseif (!is_integer($up_img['watermark_opacity'])) {
            $op_data['watermark_opacity']["message"] = $op_data['watermark_opacity']["label"] . "必须为整数";
        } elseif (!Validate::range($up_img['watermark_opacity'], $op_data['watermark_opacity']['min_len'], $op_data['watermark_opacity']['max_len'])) {
            $op_data['watermark_opacity']["message"] = $op_data['watermark_opacity']["label"] .
                    "大小必须在" . $op_data['watermark_opacity']['min_len'] . "-" . $op_data['watermark_opacity']['max_len'] . "之间";
        }
        //watermark_status
        if (in_array('watermark_status', $noset_keys)) {
            $op_data['watermark_status']["message"] = $op_data['watermark_status']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['watermark_opacity'])) {
            $op_data['watermark_status']["message"] = $op_data['watermark_status']["label"] . "不能为空";
        }
        //watermark_border_space
        if (in_array('watermark_border_space', $noset_keys)) {
            $op_data['watermark_border_space']["message"] = $op_data['watermark_border_space']["label"] . "没有定义";
        } elseif (!Validate::not_empty($up_img['watermark_border_space'])) {
            $op_data['watermark_border_space']["message"] = $op_data['watermark_border_space']["label"] . "不能为空";
        } elseif (!is_integer($up_img['watermark_border_space'])) {
            $op_data['watermark_border_space']["message"] = $op_data['watermark_border_space']["label"] . "必须为整数";
        } elseif (!Validate::range($up_img['watermark_border_space'], $op_data['watermark_border_space']['min_len'], $op_data['watermark_border_space']['max_len'])) {
            $op_data['watermark_border_space']["message"] = $op_data['watermark_border_space']["label"] .
                    "大小必须在" . $op_data['watermark_opacity']['min_len'] . "-" . $op_data['watermark_border_space']['max_len'] . "之间";
        }

        //将原有值保留到表单设置
        $form["up_img"] = $this->set_form_value($op_data, $up_img);
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
    public function post_validate($post) {
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
         //title_repeat
        if (in_array('retrial', $noset_keys)) {
            $op_data['retrial']["message"] = $op_data['retrial']["label"] . "没有定义";
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
    public function advanced_validate($advanced) {
        $form = Kohana::config("admin_setting_form");
        $noset_keys = Arr::get_noset_key($advanced, array('webname', "basehost", "indexurl", 'default_style', 'powerby', 'keywords', 'description', 'beian'));
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
        $form["advanced"] = $this->set_form_value($op_data, $advanced);
        if (!$this->has_error($form)) {

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

        $cache_arr = $form['driver'];
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
        $form['is_open']['value']['seclet'] = 0;
        $form['driver'] = $cache_arr;
        return $form;
    }
}

?>
