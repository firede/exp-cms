<?php

/* * *
 * 控制器中action的工具包
 */

class Action {

    /**     * *
     * 根据数据状态返回相应的数据集合
     * @$posts
     */
    public static function sucess_status($view_data, $performance="") {
        if ($view_data === "none") {
            $view_data = array(
                'success' => FALSE,
                'message' => $performance . '没有任何此类数据！',
                'result' => '',
            );
        } else if ($view_data === "no_id") {
            $view_data = array(
                'success' => FALSE,
                'message' => $performance . '没有指定的数据！',
                'result' => '',
            );
        } else if ($view_data === "error" || $view_data === FALSE) {
            $view_data = array(
                'success' => FALSE,
                'message' => $performance . '操作失败！',
                'result' => '',
            );
        } else if ($view_data === "exist") {
            $view_data = array(
                'success' => FALSE,
                'message' => $performance . '已经存在',
                'result' => '',
            );
        } else if ($view_data === "data_equal") {
            $view_data = array(
                'success' => TRUE,
                'message' => $performance . '操作成功，但数据没有变动',
                'result' => '',
            );
        } else {
            if (is_array($view_data)) {
                $view_data['success'] = TRUE;
                $view_data['message'] = $performance . '操作成功';
            } else {
                $view_data = array(
                    'success' => TRUE,
                    'message' => $performance . '操作成功',
                    'result' => '',
                );
            }
        }
        return $view_data;
    }

    /**     * *
     * 将已有的值回填给form中
     * @param <type> $form
     * @param <type> $data_arr
     * @return <type>
     */
    public static function build_form_data($form, $data_arr) {
       // if (isset($data_arr["result"][0])) {
           // $data_arr = $data_arr["result"][0];
            foreach ($form as $name => $filed) {
                if (isset($data_arr[$name])) {
                    if ($filed['type'] == "text") {
                        $form[$name]["value"] = $data_arr[$name];
                    } elseif ($filed['type'] == "select") {
                        $form[$name]["value"]["select"] = $data_arr[$name];
                    }
                }
            }
       // }
        return $form;
    }

}

?>
