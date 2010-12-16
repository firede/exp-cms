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
     */
    public static function _errors_report($e) {
        $message = "错误信息=>" . date("Y-m-d H:i:s") . ":" . $e->getMessage() . "\r\n" .
                "所在文件:" . $e->getFile() . "\r\n" .
                "所在行数:" . $e->getLine() . "\r\n" .
                "出错的代码:" . $e->getCode() . "\r\n" .
                "流程:" . $e->getTraceAsString() . "\r\n";
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
    }

}

?>
