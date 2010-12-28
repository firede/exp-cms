<?php defined('SYSPATH') or die('No direct script access.'); 
 return array (
     "default" =>array(
         "type" => "mysql",
         "connection" => array(
             "hostname" => "127.0.0.1",
             "database" => "test",
             "username" => "daxiniu",
             "password" => "123456",
             "persistent" => FALSE,
        ),
         "table_prefix" => "dxn_",
         "charset" => "utf8",
         "caching" => FALSE,
         "profiling" => TRUE,
    ),
     "alternate" =>array(
         "type" => "pdo",
         "connection" => array(
             "dsn" => "mysql:host=localhost;dbname=kohana",
             "username" => "root",
             "password" => "r00tdb",
             "persistent" => FALSE,
        ),
         "table_prefix" => "",
         "charset" => "utf8",
         "caching" => FALSE,
         "profiling" => TRUE,
    ),
) ;
?>