<?php

defined('SYSPATH') or die('No direct script access.');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of runtimeexception
 *
 * @author Administrator
 */
class ErrorExceptionReport {

    /**     * ***
     * 异常报告处理 在web上显示 不显示 直接抛出 写入log文件
     * @param $e 已经捕捉成功的异常对象
     * @param $get_message bool 程序中获取字符串形式的错误信息
     */
    public static function _errors_report($e,$get_message=FALSE) {
        $message = "错误信息=>" . date("Y-m-d H:i:s") . ":" . $e->getMessage() . "\n" .
                "所在文件:" . $e->getFile() . "\n" .
                "所在行数:" . $e->getLine() . "\n" .
                "出错的代码:" . $e->getCode() . "\n" .
                "流程:" . $e->getTraceAsString() . "\n";
        
        $application = Kohana::config("applicationconfig");
        if (!$application["advanced"]["throw_exception"] == NULL) {
            if ($application["advanced"]["throw_exception"] == "FILE") {
                File::create_or_add(APPPATH . "/log/" . date("Y/m/d") . "/exception_report.log", $message);
            } elseif ($application["advanced"]["throw_exception"] == "WEB") {
                echo nl2br($message);
            } elseif ($application["advanced"]["throw_exception"] == "THROW") {
                throw $e;
            }
           
        }
        if($get_message){//程序中获取错误信息HTML
              
                return nl2br($message);
            }
    }

}

?>
