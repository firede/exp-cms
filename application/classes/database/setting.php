<?php

defined('SYSPATH') or die('No direct script access.');

/**
 * Description of setting
 *
 * @author Fanqie
 */
class Database_Setting {

    /**     * **
     * 将缓存中的数据放入数据库里
     * @return string ok|error
     */
    public function cache_to_db($cache_file='applicationconfig') {
        try {
            $application = Kohana::config($cache_file);
            $conf_list = array();
            $count = 0;
            DB::query(NULL, "BEGIN WORK")->execute(); //开启事务
            foreach ($application as $key_name => $conf_val) {
                foreach ($conf_val as $conf_row_key => $conf_row_val) {
                    $conf_row = array(0 => $conf_row_key, 1 => $conf_row_val, 2 => $key_name);
                    $conf_list[$count++] = $conf_row;
                }
            }
            $insert = DB::insert("sys_config", array("key_name", "conf_value", "module"));
            $clear = DB::delete()->table("sys_config");
            foreach ($conf_list as $list_row) {
                $insert->values($list_row);
            }
            $clear->execute();
            $insert->execute();
            DB::query(NULL, "COMMIT")->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            DB::query(NULL, "ROLLBACK")->execute();
            return "error";
        }
    }

    /*     * ****
     * 将数据库中的配置 放入缓存中
     */

    public function db_to_cache() {
        try {
            $select = DB::select()->from("sys_config");
            $conf_list = $select->execute();
            $application = array();
            foreach ($conf_list as $key => $val) {
                $application[$val["module"]][$val["key_name"]] = $val["conf_value"];
            }
            Arr::as_config_file($application, APPPATH . "/config/applicationconfig.php");
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

    /**     * **
     * 修改一个站点配置
     * @param $configs array 存储config的 键值与值的集合
     * @param $module string 模块名称
     * @return string 返回执行成功或者失败
     */
    public function update_configs($configs, $module="site") {
        try {
            DB::query(NULL, "BEGIN WORK")->execute(); //开启事务
            foreach ($site as $key_name => $conf_value) {

                DB::update("sys_config")->set(array("conf_value" => $conf_value))
                        ->where("key_name", "=", $key_name)
                        ->and_where("module", "=", $module)
                        ->execute();
            }
            DB::query(NULL, "COMMIT")->execute();
            return "ok";
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return "error";
        }
    }

}

?>
