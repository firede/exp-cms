<?php

/* * *
 * 控制器中action的工具包
 */

class File extends Kohana_File {
  
     /*     * ***
     * 判断文件夹路径是否存在 如果不存在则创建缺失路径
     * @$path <string> 文件路径 每层路径使用“\”来分隔
     * @return <string> 返回创建完成的路径
     */

    public static  function path_mkdirs($path) {
        $file_boxs = explode("/", $path);
        // echo
        $path = "";
        foreach ($file_boxs as $key => $file_box) {
            //过滤空路径
            if ($file_box == "/") {
                continue;
            } else {
                $path = $path . $file_box . "/";
                $file_boxs[$key]=$path;
            }
        }
        $exists_flag=array();
        echo kohana::debug($file_boxs);
        $count=0;
        for($i=count($file_boxs)-1;$i>=0;$i--){
            if (!file_exists($file_boxs[$i])) {
                $exists_flag[$count++]=$file_boxs[$i];
             }else{break;}
        }
        echo kohana::debug($exists_flag);
        for($i=(count($exists_flag)-1);$i>=0;$i--){
            mkdir($exists_flag[$i]);
        }
        return $path;
    }
}

?>
