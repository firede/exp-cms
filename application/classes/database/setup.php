<?php

defined('SYSPATH') or die('No direct script access.');

class Database_Setup {

    /**     * **
     * 设置数据库相关配置
     * @param $db_conf_post array 数据库帐号-user／密码-pwd／前缀-table_prefix／
     * 数据库名称-db_name／数据库类型-db_type/数据库服务器地址-host_name
     * @return string "ok"/"errror"
     */
    public function set_db_conf($db_conf_post) {


        try {

            $db_conf = Kohana::config("database");
            $db_conf = $db_conf["default"];
            $db_conf["type"] = $db_conf_post["db_type"];
            $db_conf["connection"]["hostname"] = $db_conf_post["host_name"];
            $db_conf["connection"]["database"] = $db_conf_post["db_name"];
            $db_conf["connection"]["username"] = $db_conf_post["user"];
            $db_conf["connection"]["password"] = $db_conf_post["pwd"];
            $db_conf["table_prefix"] = $db_conf_post["table_prefix"];
            //echo Kohana::debug($db_conf);
            $config_file = APPPATH . '../module/database/config/database';
            Arr::as_config_file($db_conf, $config_file);
            if ($this->create_db($db_conf_post)) {
                return 'ok';
            } else {
                return 'error';
            }
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            return 'error';
        }
    }

    public function create_db($db_conf_post) {
        try {
            $mysql_db->query("BEGIN WORK");
            $mysql_db = new mysqli($db_conf_post["host_name"], $db_conf_post["user"], $db_conf_post["pwd"]);
            $filename = APPPATH . 'data/' . $db_conf_post["db_type"] . '_setup.sql';
            $filename = str_replace("\\", "/", $filename);
            //fopen($filename, $mode);
            $sql_text = file_get_contents($filename);
            $sql_text = str_replace("{db_name}", $db_conf_post["db_name"], $sql_text);
            $sql_text = str_replace("{table_prefix}", $db_conf_post["table_prefix"], $sql_text);
            File::create_or_add($filename, $sql_text, 'w+');
            $mysql_db->query("source " . $filename);
            $mysql_db->query("COMMIT");
            return TRUE;
        } catch (Exception $e) {
            $mysql_db->query("ROLLBACK");
            ErrorExceptionReport::_errors_report($e);
            echo $message = "错误信息=>" . date("Y-m-d H:i:s") . ":" . $e->getMessage() . "\n";
            return FALSE;
        }
    }

    /**     *
     * 检测数据库链接的有效性
     */
    public function check_connection($db_conf_post) {
        try {
            if ($db_conf_post["db_type"] == "mysql") {
                $mysql_db = new mysqli($db_conf_post["host_name"], $db_conf_post["user"], $db_conf_post["pwd"]);
                //$mysql_db = new mysqli("localhost", "daxiniu", "1234562");

                if (mysqli_connect_errno ()) {
                    return FALSE;
                }
                $mysql_db->close();
            } elseif ($db_conf_post["db_type"] == "sqlite") {
                $filename = APPPATH . 'data/' . $db_conf_post["db_name"] . '.db';
                $filename = str_replace("\\", "/", $filename);
                File::path_mkdirs($filename);
                echo $filename;
                $sqlite_db = new SQLite3($filename, SQLITE3_OPEN_CREATE, $db_conf_post["pwd"]);
                $sqlite_db->close();
            }
            return TRUE;
        } catch (Exception $e) {
            ErrorExceptionReport::_errors_report($e);
            echo $message = "错误信息=>" . date("Y-m-d H:i:s") . ":" . $e->getMessage() . "\n";
            return FALSE;
        }
    }

    /**     * *
     * 检测当前服务器支持的数据库
     * @return <type>
     */
    public function check_db_component() {
        $db_conf = array();
        $count = 0;
        $select_stauts = FALSE;
        if (extension_loaded("mysql")) {
            $db_conf[$count] = "mysql";
            $db_conf[$count]["seclet"] = TRUE;
            $select_stauts = TRUE;
            $count++;
        }
        if (extension_loaded("sqlite3")) {
            $db_conf[$count] = "sqlite3";
            $db_conf[$count]["seclet"] = $select_staut ? FALSE : TRUE;
            $count++;
        }
        return $db_conf;
    }

}

?>
