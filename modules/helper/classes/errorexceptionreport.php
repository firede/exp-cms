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
    /******
     *
     */
     public static  function  _errors_report($e){
       
        $application = Kohana::config("applicationconfig");
        if (!$application["advanced"]["throw_exception"] == NULL) {
            if ($application["advanced"]["throw_exception"] == "FILE") {
                $message = $e->getMessage();
                File::create_or_add(APPPATH."/exception.log","错误信息=>".date("Y-m-d H:i:s").":".$message."\n");
            } elseif ($application["advanced"]["throw_exception"] == "WEB") {
               
                $message = $e->getMessage();
                echo "错误信息=>",date("Y-m-d H:i:s"),":".$message;
            } elseif ($application["advanced"]["throw_exception"] == "THROW") {
                throw $e;
            }
        }

        
    }

}

?>
