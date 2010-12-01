<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Category extends Controller_Base{



    public function action_list() {


        $categoryDb = new Database_Category();
        //设置参数过滤器中需要保留下操作的数据
        $arr_element_names =
                array('id',"name","short_name","parent_id","sort");
        $category = Arr::filter_Array($_GET, $arr_element_names);
   
        $categorys = $categoryDb->query_list($category);
        $categorys = Action::sucess_status($categorys);
        
       
       
      /*  $this->template->layout_main = View::factory('admin/user/list', array(
                    'pagination' => $pagination,
                    'view_data' => $categorys,
                ));*/
    }

    public function action_get_user($id) {
        $userDb = new Database_User();
        $users = $userDb->get_user($id);
        $users = Action::sucess_status($users);
        echo Kohana::debug($users);
        $view = View::factory('smarty:');
        $view->posts = $posts;
        $this->request->response = $view->render();
    }

    public function action_delete() {

    }

    public function action_mulit_delete() {
        
    }

}