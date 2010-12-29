<?php
/* * *
 * 控制器中action的工具包
 */
class Action {
    /** **
     * 根据数据状态返回相应的数据集合
     * @$posts 
     */
    public static function sucess_status($view_data,$performance="") {
        if ($view_data === "none") {
            $view_data = array(
                'success' => FALSE,
                'message' => $performance.'没有任何此类数据！',
                'result' => '',
            );
        } else if ($view_data === "no_id") {
            $view_data = array(
                'success' => FALSE,
                'message' => $performance.'没有指定的数据！',
                'result' => '',
            );
        } else if ($view_data === "error"||$view_data===FALSE) {
            $view_data = array(
                'success' => FALSE,
                'message' => $performance.'操作失败！',
                'result' => '',
            );
        } else if ($view_data === "exist") {
            $view_data = array(
                'success' => FALSE,
                'message' => $performance.'已经存在',
                'result' => '',
            );
        }else if($view_data === "data_equal"){
             $view_data = array(
                'success' => TRUE,
                'message' => $performance.'操作成功，但数据没有变动',
                'result' => '',
            );
        } else {
            if (is_array($view_data)) {
                $view_data['success'] = TRUE;
                $view_data['message'] = $performance.'操作成功';
            } else {
                $view_data = array(
                    'success' => TRUE,
                    'message' => $performance.'操作成功',
                    'result' => '',
                );
            }
        }
        return $view_data;
    }
}

?>
