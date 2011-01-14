<?php

defined('SYSPATH') or die('No direct access allowed.');

class FormValidate extends Validate {

    private $action_form;
    private $form_rules;
    private $request_params;
    private $set_empty;
    private $set_continue;
    //private $

    /**
     * 表单验证构造函数
     * @param <type> $action_form 表单的配置函数
     * @param <type> $form_rules 符合规则的表单字段集合
     * @param <type> $request_params 请求参数集合
     */
    public function __construct($action_form, $form_rules, $request_params, $set_empty=array(), $set_continue=array()) {
        $this->action_form = $action_form;
        $this->form_rules = $form_rules;
        $this->request_params = $request_params;
        $this->set_empty = $set_empty;
        $this->set_continue = $set_continue;
    }

    /**
     * 表单整体验证
     * @return <type>
     */
    public function _form_validate() {

        foreach ($this->form_rules as $filed_name) {
            if (isset($this->action_form[$filed_name]["validate"])) {
                foreach ($this->action_form[$filed_name]["validate"] as $type => $desc) {
                    if ($this->action_form[$filed_name]["message"] == "") {
                        if (is_int($type)) {
                            $str = '$this->' . $desc . '_param("' . $filed_name . '");';
                        } else {
                            $str = '$this->' . $type . '_param("' . $filed_name . '");';
                        }
                        eval($str);
                    }
                }
            }
        }
        $m_base = new Model_Base();
        //将原有值保留到表单设置
        $this->action_form = $m_base->set_form_value($this->action_form, $this->request_params, $this->set_empty, $this->set_continue);
        if (!$m_base->has_error($this->action_form)) {

            return array(
                "success" => FALSE,
                "data" => $this->action_form,
            );
        }
        return TRUE;
        return $this->action_form;
    }

    /**
     * 非空验证
     * @param <type> $filed_name
     * @return <type>
     */
    public function not_empty_param($param_name) {
        $param = $this->action_form[$param_name];
        if (!$this->not_empty($this->request_params[$param_name])) {
            if (isset($param["validate"]["not_empty"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["not_empty"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "不能为空";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 数字类型验证
     * @param <type> $param_name
     * @return <type>
     */
    public function is_numeric_param($param_name) {
        $param = $this->action_form[$param_name];
        if (!$this->numeric($this->request_params[$param_name])) {
            if (isset($param["validate"]["is_numeric"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["is_numeric"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "必须为数字";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 整数验证
     * @param <type> $param_name
     * @return <type>
     */
    public function is_integer_param($param_name) {
        $param = $this->action_form[$param_name];

        if (!($this->regex($this->request_params[$param_name], '~^-?\\d+$~'))) {
            if (isset($param["validate"]["is_integer"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["is_integer"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "必须是一个整数";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 小数验证
     * @param <type> $param_name
     * @return <type>
     */
    public function is_decimal_param($param_name) {
        $param = $this->action_form[$param_name];

        if (!($this->decimal($this->request_params[$param_name]))) {

            if (isset($param["validate"]["is_decimal"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["is_decimal"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "必须是一个小数";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 值范围验证
     * @param <type> $param_name
     * @return <type>
     */
    public function range_param($param_name) {
        $param = $this->action_form[$param_name];
        $error_msg = "";
        if (isset($param["validate"]["range"]["min"])) {
            if ($this->request_params[$param_name] < $param["validate"]["range"]["min"]) {
                $error_msg = $error_msg . $param["message"] . "不能小于" . $param["validate"]["range"]["min"];
            }
        }
        if (isset($param["validate"]["range"]["max"])) {
            if ($this->request_params[$param_name] > $param["validate"]["range"]["max"]) {
                $error_msg = $error_msg . $param["message"] . " 不能大于" . $param["validate"]["range"]["max"];
            }
        }
        if ($error_msg !== "") {
            if (isset($param["validate"]["range"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["range"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "值" . $error_msg;
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * 字符串长度验证
     * @param <type> $param_name
     * @return <type>
     */
    public function str_len_param($param_name) {
        $param = $this->action_form[$param_name];
        $error_msg = "";
        if (isset($param["validate"]["str_len"]["min"])) {
            if (strlen($this->request_params[$param_name]) < $param["validate"]["str_len"]["min"]) {
                $error_msg = $error_msg . $param["message"] . "不能小于" . $param["validate"]["str_len"]["min"];
            }
        }
        if (isset($param["validate"]["str_len"]["max"])) {
            if (strlen($this->request_params[$param_name]) > $param["validate"]["str_len"]["max"]) {
                $error_msg = $error_msg . $param["message"] . "不能大于" . $param["validate"]["str_len"]["max"];
            }
        }
        if ($error_msg !== "") {
            if (isset($param["validate"]["str_len"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["str_len"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "长度" . $error_msg;
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * email
     * @param <type> $param_name
     * @return <type>
     */
    public function email_param($param_name) {
        $param = $this->action_form[$param_name];
        if (!$this->email($this->request_params[$param_name])) {
            if (isset($param["validate"]["email"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["email"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "不是有效的email格式：XXX＠XXX.XXX";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * datatime
     * @param <type> $param_name
     * @return <type>
     */
    public function datatime_param($param_name) {
        $param = $this->action_form[$param_name];
        if (!$this->date($this->request_params[$param_name])) {
            if (isset($param["validate"]["datatime"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["datatime"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "不是有效的日期格式";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * url
     * @param <type> $param_name
     * @return <type>
     */
    public function url_param($param_name) {
        $param = $this->action_form[$param_name];
        if (!$this->url($this->request_params[$param_name])) {
            if (isset($param["validate"]["url"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["url"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "格式错误";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * dir
     * @param <type> $param_name
     * @return <type>
     */
    public function dir_param($param_name) {
        $param = $this->action_form[$param_name];

        if (!($this->regex($this->request_params[$param_name], "/^([\/] [\w-]+)*$/") || $this->regex($this->request_params[$param_name], "/^[a-zA-Z];[\\/]((?! )(?![^\\/]*\s+[\\/])[\w -]+[\\/])*(?! )(?![^.]+\s+\.)[\w -]+$/"))) {
            if (isset($param["validate"]["dir"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["dir"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "格式错误";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * regex
     * @param <type> $param_name
     * @return <type>
     */
    public function reg_param($param_name) {
        $param = $this->action_form[$param_name];

        if (!($this->regex($this->request_params[$param_name], $param["validate"]["dir"]['exp']))) {
            if (isset($param["validate"]["reg"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["reg"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "格式错误";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     * regex
     * @param <type> $param_name
     * @return <type>
     */
    public function exp_param($param_name) {
        $param = $this->action_form[$param_name];

        if (!($this->regex($this->request_params[$param_name], $param["validate"]["dir"]['exp']))) {
            if (isset($param["validate"]["exp"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["exp"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "格式错误";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /**
     *
     * @param <type> $param_name
     * @return <type> 
     */
    public function call_function_param($param_name) {
        $param = $this->action_form[$param_name];
        $method = $param["validate"]["call_function"]["function"];
        $method = explode(".", $method);
        eval('$call_method=new ' . $method[0] . '();');
        eval('$result=$call_method->' . $method[1] . '($this->request_params)?true:false;');
        if (!$result) {
            if (isset($param["validate"]["call_function"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["call_function"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "格式错误";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    public function filed_exp_param($param_name) {
        $param = $this->action_form[$param_name];
        $exp_fileds = $param["validate"]["filed_exp"];
        $exp = "";
        if (isset($this->request_params[$exp_fileds["filed1"]])) {
            $exp = '"' . $this->request_params[$exp_fileds["filed1"]] . '"' . $exp_fileds['opertor'];
        } else {
            $exp = '"' . $exp_fileds["filed1"] . '"' . $exp_fileds['opertor'];
        }
        if (isset($this->request_params[$exp_fileds["filed2"]])) {
            $exp = $exp . '"' . $this->request_params[$exp_fileds["filed2"]] . '"';
        } else {
            $exp = $exp . '"' . $exp_fileds["filed2"] . '"';
        }
        eval('$wq=' . $exp . '?true:false;');
        if (!$wq) {
            if (isset($param["validate"]["filed_exp"]["error_msg"])) {
                $param["message"] =
                        $param["validate"]["filed_exp"]["error_msg"];
            } else {
                $param["message"] = $param["label"] . "的值不符合要求";
            }
            $this->action_form[$param_name] = $param;
            return FALSE;
        }
        return TRUE;
    }

    /* 'validate'=>array(
      'not_empty'=>array('error_msg'=>'用户名不能为空'),
      'is_number',
      'is_int',
      'is_float',
      'range'=>array('min'=>0,'max'=>100,'error_msg'=>'大小必须在0到100之间'),
      'str_len'=>array('min'=>0,'max'=>100,),
      'email',
      'datatime',
      'exp'=>array(),
      'reg'=>array(),
      'url',
      'dir',
      'call_function'=>array('function'=>'Database_Post.methd','params'=>'name','message'=>'用户名已存在'),
      ) */
}

?>
