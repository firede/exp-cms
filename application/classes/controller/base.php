<?php

defined('SYSPATH') or die('No direct script access.');
/* * ******
 * 控制器父类
 */

class Controller_Base extends Controller {

    public $template = 'template';
    public $xss_green_light=array();//xxs 放行的参数 如果你需要放行可以 修改这个参数的值 然后使用parent::before()继承执行即可
    public function before() {
        $_GET = $this->filter_XSS($_GET);//xss过滤
        $_POST = $this->filter_XSS($_POST);//xss过滤
        parent::before();
    }

    /*     * ********
     * xss过滤
     */
    public function filter_XSS($params) {
        foreach ($params as $key => $value) {
            //如果该参数属于XSS放行行列 则不进行转义
            if(!isset($this->xss_green_light[$key])){
                continue;
            }
            //将当前参数进行转义
            $params[$key] = htmlspecialchars($value, ENT_QUOTES);
        }
        return $params;
    }

    public function after() {

        // 输出视图前定义变量
		$this->template->VERSION = '1-0-0-pre';
        $this->template->BASE_URL = URL::base();
		$this->template->URL_PARAMS = json_encode($_GET);

        $this->request->response = $this->template;

        return parent::after();
    }

}

?>