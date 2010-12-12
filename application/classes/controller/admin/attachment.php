<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * 附件管理
 */

/**
 * Description of attachment
 *
 * @author  Fanqie
 */
class Controller_Admin_Attachment extends Controller_Admin_BaseAdmin {
    /*     * *
     * 获取带分页的附件信息列表
     */

    public function action_list() {

        $pagination = new Pagination(array(
                    'current_page' => array('source' => 'query_string', 'key' => 'page'),
                    'total_items' => 0,
                    'items_per_page' => 20,
                    'view' => 'pagination/admin',
                    'auto_hide' => TRUE,
                    'first_page_in_url' => FALSE,
                ));
        $arr_element_names = array("url", "uuid", "file_size", "use_type", "status", "file_type");
        $attachmenDb = new Database_Attachment();
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        if (!isset($_GET['use_type'])) {
            $_GET['use_type'] = '0';
        }

        $attachment = Arr::filter_Array($_GET, $arr_element_names);
        $page_Param = array("page" => $_GET['page'], "items_per_page" => $pagination->__get("items_per_page"));
        $sort = Arr::filter_Array($_GET, array("order_by", "sort_type"));
        $attachments = $attachmenDb->query_list($attachment, $page_Param, $sort);

        $attachments = Action::sucess_status($attachments);
        if (isset($attachments["total_items_count"])) {
            $pagination->__set('total_items', $attachments["total_items_count"]);
        }
        $conf_use_type = 'use_type_' . $_GET['use_type'];
		$conf = Kohana::config('admin_attachment_list')->$conf_use_type;
        $view = View::factory('smarty:admin/attachment/list', array(
                    'pagination' => $pagination,
                    'view_data' => $attachments,
					'conf' => $conf,
                ));
        $this->template = AppCache::app_cache("attachement_list", $view);
    }

    /*     * ***
     * 通过id删除 指定用户
     */

    public function action_del_post() {
        $attachemenDb = new Database_Attachment();
        $view_data = $attachemenDb->del($_POST);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * ***
     * 通过id删除 指定用户
     */

    public function action_update_post() {
        $attachemenDb = new Database_Attachment();
        $arr_element_names = array("url", "uuid", "file_size", "use_type", "status", "file_type");
        $attachement = Arr::filter_Array($_GET, $arr_element_names);
        $view_data = $attachemenDb->modify($attachement);
        $view_data = Action::sucess_status($view_data);
        $this->template = View::factory('json:');
        $this->template->_data = $view_data;
    }

    /*     * ***
     * 清理垃圾无用附件
     */

    public function clear_file() {
        
    }

}

?>
