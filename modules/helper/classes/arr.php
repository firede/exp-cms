<?php

defined('SYSPATH') or die('No direct script access.');

class Arr extends Kohana_Arr {
    /*     * ***********************
     * 过滤数组
     * 从$arr（array）中剔除$arrElement（array）中指定的元素之外的下标值返回
     * 如 $arr=array('a'=>'1','b'=>'2','c'=>'3','d'=>5);
     * $arrElementkeys=array('a','b','d');则返回的数组值为 array('a'=>'1','b'=>'2','d'=>5)
     * @param $arr array 原始数组
     * @param $arrElementNames array 需要保留的元素名
     * @return  array() 返回新的数组
     */

    public static function filter_Array($arr, $arrElementkeys) {
        $newArry = array();
        if (count($arrElementkeys) == 0) {
            return $arr;
        }

        for ($i = 0; $i < count($arrElementkeys); $i++) {
            if (!isset($arr[$arrElementkeys[$i]])) {
                
            } else {
                $newArry[$arrElementkeys[$i]] = $arr[$arrElementkeys[$i]];
            }
        }

        return $newArry;
    }

    /*     * *******
     * 将数组写入固定的php文件内
     * @$arr <array>数组
     * @$config_file <string> 需要覆盖入的文件
     */

    public static function as_config_file($arr, $config_file) {

        $config_file = File::path_mkdirs($config_file); //保持路径的完整性,如果不存在则创建 
        $data = StrongKohana::my_dump($arr);
         echo Kohana::debug($arr);
        $data = "<?php defined('SYSPATH') or die('No direct script access.');\n return array" . $data;
        $data=$data."; ?>";
        $config_file = str_replace("/", "\\", $config_file);
        echo $config_file;
        $config_file = substr($config_file, 0, strlen($config_file) - 1);
        $fopen = fopen($config_file, 'w'); //新建文件命令
        fwrite($fopen, $data); //向文件中写入内容;
        fclose($fopen);
    }

}

?>