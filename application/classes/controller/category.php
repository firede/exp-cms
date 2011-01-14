<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Category extends Controller_BaseUser {

    /**
     *
     * @param <type> $dxn_get
     */
    public function action_list_as_post($dxn_get) {
        $categorys = Kohana::config("category");
        $id = $dxn_get["id"];
        $list_as_post = array("self" => array(), "categorys" => array());
        foreach ($categorys as $category) {
            if ($category["id"] == $id) {
                $list_as_post["self"] = $category;
            }
            if ($category["parent_id"] == $id) {
                $list_as_post["categorys"][$category["id"]] = $category;
            }
        }
        if (count($list_as_post["categorys"]) == 0) {
            foreach ($categorys as $category) {
                if ($category["parent_id"] == $list_as_post["self"]["parent_id"]) {
                    $list_as_post["categorys"][$category["id"]] = $category;
                }
            }
            foreach ($categorys as $category) {
                if ($list_as_post["self"]["parent_id"] == $category["id"]) {
                    $list_as_post["self"] = $category;
                }
            }
        }
        $view = View::factory('smarty:admin/post/list', array(
                    'view_data' => $list_as_post,
                ));

        echo AppCache::app_cache("post_view", $view);
    }

}

?>
