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
            $db_confs = Kohana::config("database");
            $db_conf = $db_confs["default"];

            $db_conf["type"] = $db_conf_post["db_type"];
            $db_conf["connection"]["hostname"] = trim($db_conf_post["host_name"]);
            $db_conf["connection"]["database"] = trim($db_conf_post["db_name"]);
            $db_conf["connection"]["username"] = $db_conf_post["user"];
            $db_conf["connection"]["password"] = $db_conf_post["pwd"];
            $db_conf["table_prefix"] = $db_conf_post["table_prefix"];

            $config_file = APPPATH;
            $config_file = substr($config_file, 0, strlen($config_file) - 12) . 'modules/database/config/database.php';

            $db_confs["default"] = $db_conf;

            Arr::as_config_file($db_confs, $config_file);

            if ($this->exe_sql($db_conf_post, '_setup.sql')) {
                if ($db_conf_post["add_test_data"] == 0) {
                    //add _data;
                    $this->exe_sql($db_conf_post, '_test_data.sql');
                }
                  
                return 'ok';
            } else {
                return 'error';
            }
        } catch (Exception $e) {
            echo ErrorExceptionReport::_errors_report($e, TRUE);
            return 'error';
        }
    }

    public function exe_sql($db_conf_post, $sql_file) {
        try {
            $mysql_db = new mysqli($db_conf_post["host_name"], $db_conf_post["user"], $db_conf_post["pwd"]);
            //$mysql_db->set_charset("utf8");
// $mysql_db->autocommit(false);
            $filename = APPPATH . 'data/' . $db_conf_post["db_type"] . $sql_file;
            $filename = str_replace("\\", "/", $filename);
            $mysql_db->query("set names utf8");
            $sql_text = file_get_contents($filename);
            $sql_text = str_replace("{db_name}", $db_conf_post["db_name"], $sql_text);
            $sql_text = str_replace("{table_prefix}", $db_conf_post["table_prefix"], $sql_text);
            $sql_texts = explode(";", $sql_text);

            foreach ($sql_texts as $key => $sql) {
                $mysql_db->query($sql);
            }

//  $mysql_db->commit();
            return TRUE;
        } catch (Exception $e) {
//   $mysql_db->rollback();
            ErrorExceptionReport::_errors_report($e,TRUE);
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
//  echo $message = "错误信息=>" . date("Y-m-d H:i:s") . ":" . $e->getMessage() . "\n";
            echo ErrorExceptionReport::_errors_report($e, TRUE);
            return FALSE;
        }
    }

    /**     * *
     * 检测当前服务器支持的数据库
     * @return <type>
     */
    public function check_db_component($form) {
        $db_type = $form['set_db']['db_type'];

        $select_stauts = FALSE;
        if (extension_loaded("mysql")) {
            $db_type['value']['data']["mysql"] = "mysql";
            $db_type['value']["select"] = "mysql";
            $db_type["desc"] = "系统推荐您使用mysql";
            $select_stauts = TRUE;
        }
        if (extension_loaded("sqlite3")) {
            $db_type['value']['data']["sqlite3"] = "sqlite3";
            $db_type['value']["select"] = $select_stauts ? $db_type['value']["select"] : "sqlite3";
            $db_type["desc"] = $select_stauts ? $db_type["desc"] : "系统推荐您使用sqlite3";
        }
        $form['set_db']['db_type'] = $db_type;

        return $form;
    }

}

?>
