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
             
            } else{ $newArry[$arrElementkeys[$i]] = $arr[$arrElementkeys[$i]];}
               
            
        }

        return $newArry;
    }

}

?>