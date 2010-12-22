-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 12 月 01 日 08:49
-- 服务器版本: 5.1.41
-- PHP 版本: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
CREATE DATABASE IF NOT EXISTS {db_name} ;
use {db_name} ;
--
-- 数据库: `daxiniu`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `{table_prefix}admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `role` int(2) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `username_3` (`username`),
  UNIQUE KEY `id_2` (`id`),
  KEY `id` (`id`),
  KEY `username_2` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- 表的结构 `attachment`
--

CREATE TABLE IF NOT EXISTS `{table_prefix}attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(256) COLLATE utf8_bin NOT NULL,
  `uuid` varchar(32) COLLATE utf8_bin NOT NULL,
  `file_size` int(11) NOT NULL DEFAULT '0',
  `use_type` int(3) DEFAULT '0',
  `status` int(3) DEFAULT '0',
  `file_type` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;



-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `{table_prefix}category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `short_name` varchar(32) COLLATE utf8_bin NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '-1',
  `sort` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;


-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `{table_prefix}post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(32) COLLATE utf8_bin NOT NULL,
  `title` varchar(256) COLLATE utf8_bin NOT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `pub_time` timestamp NOT NULL DEFAULT '1990-01-01 00:00:00',
  `update_time` timestamp NOT NULL DEFAULT '1990-01-01 00:00:00',
  `pre_content` text COLLATE utf8_bin,
  `content` text COLLATE utf8_bin,
  `user_id` varchar(32) COLLATE utf8_bin NOT NULL,
  `status` int(11) DEFAULT '0',
  `read_count` int(11) DEFAULT '0',
  `operation_id` varchar(32) COLLATE utf8_bin NOT NULL,
  `reference` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `source` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `operation_desc` varchar(256) COLLATE utf8_bin DEFAULT NULL,
  `flag` varchar(32) COLLATE utf8_bin DEFAULT '0,',
  `is_del` int(2) COLLATE utf8_bin DEFAULT 0,
  `swap` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;


-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `{table_prefix}user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_type` int(3) DEFAULT '0',
  `status` int(3) DEFAULT '0',
  `avatar` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `reg_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin_id` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=32 ;


-----------
-- 表结构
--------
CREATE TABLE IF NOT EXISTS `{table_prefix}sys_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key_name` varchar(32) COLLATE utf8_bin NOT NULL,
  `conf_value` varchar(1023) COLLATE utf8_bin NOT NULL,
  `module` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '',  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=32 ;
