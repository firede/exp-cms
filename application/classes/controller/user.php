<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_user extends Controller_BaseUser {

    /**
     * 跳转到注册用户页面
     */
    public function action_register() {
        $form = Kohana::config('admin_user_form.default');
        $function_config = Kohana::config('admin_user_form.function_config.default.register');
        $form = Action::form_decorate($form, $function_config);
        $captcha = Captcha::instance();
        $view = View::factory('smarty:admin/user/create', array(
                    'form' => $form,
                    'captcha' => $captcha->render(),
                ));
        $this->template = AppCache::app_cache('user_create', $view);
    }
    /**
     * 获取验证码
     */
    public function action_captcha(){
         $captcha = Captcha::instance();
         $this->template=array('captcha' => $captcha->render());
    }

    /**
     * 注册用户
     * @return <type>
     */
    public function action_register_post() {
        $m_user = new Model_User();
        $form = Kohana::config('admin_user_form.default');        
        if(Captcha::valid($_POST['captcha'])){
            $validate_result =FALSE;
        }
        $function_config = Kohana::config('admin_user_form.function_config.default.register');
        $legal_fileds = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER);
        $form = Action::form_decorate($form, $function_config);
        $formvalidate = new FormValidate($form, $legal_fileds, $_POST, array('password', 're_password'), array());
        $validate_result = $formvalidate->_form_validate();
        //$validate_result = $m_user->post_validate($_POST, $form, $legal_fileds);
        if (isset($validate_result["success"])) {
            $view = View::factory('smarty:admin/user/create', array(
                        'form' => $validate_result["data"],
                    ));
            $this->template = AppCache::app_cache('user_create_post', $view);
            return;
        }
        $_POST["avatar"] = isset($_POST["avatar"]) ? $_POST["avatar"] : "";
        $userDb = new Database_User();
        $arr_element_names = Action::legal_fileds($function_config, Action::$LEGAL_FORM_TYPE_WRITER, array("re_password"));
        $user = Arr::filter_Array($_POST, $arr_element_names);

        $user["reg_time"] = date("Y-m-d H:i:s");
        $user["last_time"] = date("Y-m-d H:i:s");

        $view_data = $userDb->create($user);
        $view_data = Action::sucess_status($view_data);

        $view = View::factory('smarty:');
        if ($view_data["success"]) {
            $view->next_page = "admin/user";
        } else {
            $view->next_page = "admin/user/create";
        }
        $view->users = $view_data;
        $this->request->response = AppCache::app_cache("user_create", $view)->render();
    }

}

?>
