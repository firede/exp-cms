-- phpMyAdmin SQL Dump
-- version 3.2.3
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 11 月 25 日 12:04
-- 服务器版本: 5.1.40
-- PHP 版本: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 数据库: `daxiniu`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
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

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'firede', '123456', 1),
(2, 'radeye', '123456', 0),
(3, '魔力波板糖', '22', 0),
(4, 'daxiniu', 'jimogu', 1);

-- --------------------------------------------------------

--
-- 表的结构 `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(256) COLLATE utf8_bin NOT NULL,
  `uuid` varchar(32) COLLATE utf8_bin NOT NULL,
  `file_size` int(11) NOT NULL DEFAULT '0',
  `use_type` int(3) DEFAULT '0',
  `status` int(3) DEFAULT '0',
  `file_type` varchar(32) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `attachment`
--

INSERT INTO `attachment` (`id`, `url`, `uuid`, `file_size`, `use_type`, `status`, `file_type`) VALUES
(1, '1', '1', 0, 0, 0, '11');

-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_bin NOT NULL,
  `short_name` varchar(32) COLLATE utf8_bin NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '-1',
  `sort` int(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `category`
--


-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(32) COLLATE utf8_bin NOT NULL,
  `title` varchar(256) COLLATE utf8_bin NOT NULL,
  `cate_id` int(11) DEFAULT NULL,
  `pub_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `swap` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`id`, `uuid`, `title`, `cate_id`, `pub_time`, `pre_content`, `content`, `user_id`, `status`, `read_count`, `operation_id`, `reference`, `source`, `operation_desc`, `flag`, `swap`) VALUES
(0, '3', '3', 33, '2010-11-24 08:18:46', '2', '', '3', 1, 0, 'admin', NULL, NULL, 'xiaodang', '0,', '2'),
(4, '3', '3', 33, '2010-11-24 08:40:57', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(5, '3', '3', 33, '2010-11-24 08:40:59', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(6, '3', '3', 33, '2010-11-24 08:41:00', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(7, '3', '3', 33, '2010-11-24 08:41:02', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(8, '3', '3', 33, '2010-11-24 08:41:04', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(9, '3', '3', 33, '2010-11-24 08:41:59', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(10, '3', '3', 33, '2010-11-24 09:15:07', '33', 'lalala', '3', 0, 1, '3', NULL, NULL, NULL, '0,', ''),
(11, '3', '3', 33, '2010-11-24 09:15:22', '33', 'lalala', '3', 1, 1, '3', NULL, NULL, NULL, '1,2,3', '');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(32) COLLATE utf8_bin NOT NULL,
  `email` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `user_type` int(3) DEFAULT '0',
  `status` int(3) DEFAULT '0',
  `avatar` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `reg_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `admin_id` varchar(32) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=32 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `user_type`, `status`, `avatar`, `reg_time`, `last_time`, `admin_id`) VALUES
(3, 'dc2002007@163.com', 'admin1', 'dc2002007@163.com', 1, 0, '', '2010-11-12 10:28:40', '2010-11-12 10:29:04', '0'),
(20, '22', '222', '', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-12 10:48:19', '2010-11-12 10:48:43', '0'),
(21, '23', '23454', '22@163.com', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 06:48:48', '2010-11-14 06:49:12', '0'),
(22, '4545', '64564', '22@163.com', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 06:48:55', '2010-11-14 06:49:19', '0'),
(23, '4356346', '3454353', '22@163.com', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 06:49:06', '2010-11-14 06:49:30', '0'),
(24, '324', '32gdsfs', '22@163.com', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 06:49:17', '2010-11-14 06:49:41', '0'),
(25, '而为此', 'dfds ', '22@163.com', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 06:49:29', '2010-11-14 06:49:53', '0'),
(26, '5', '5', '22@163.com', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 07:02:05', '2010-11-14 07:02:29', '0'),
(27, '565', '65765', '22@163.com', 1, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 07:02:13', '2010-11-14 07:02:37', '0'),
(28, '768', '345', 'dc2002007@163.com', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 07:02:21', '2010-11-14 07:02:45', '0'),
(29, '657', '435', '22@163.com', 1, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 07:02:28', '2010-11-14 07:02:52', '0'),
(30, '66', '66', '66@dw.com', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-14 11:23:24', '2010-11-14 11:23:48', '0'),
(31, '123', '23432', '66@dw.com', 0, 1, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-17 03:04:09', '2010-11-17 03:04:33', '0');
