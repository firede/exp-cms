-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 12 月 01 日 08:49
-- 服务器版本: 5.1.41
-- PHP 版本: 5.3.1

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `short_name`, `parent_id`, `sort`) VALUES
(1, '少林足球', 'shaolinzuqiu', -1, 0);

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
  `swap` text COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=37 ;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`id`, `uuid`, `title`, `cate_id`, `pub_time`, `update_time`, `pre_content`, `content`, `user_id`, `status`, `read_count`, `operation_id`, `reference`, `source`, `operation_desc`, `flag`, `swap`) VALUES
(0, '3', '这里是标题', 1, '2010-11-24 08:18:46', '0000-00-00 00:00:00', '这是内容，我要预览效果啊', '', '3', 1, 0, 'admin', NULL, NULL, 'xiaodang', '0,', '2'),
(4, '3', '换个标题名', 1, '2010-11-24 08:40:57', '0000-00-00 00:00:00', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(5, '3', '少林足球中，火云邪神的大绝招是啥？', 1, '2010-11-24 08:40:59', '0000-00-00 00:00:00', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(6, '3', '教你怎样才能百分百发挥出如来神掌的威力', 1, '2010-11-24 08:41:00', '0000-00-00 00:00:00', '33', 'lalala', '3', 2, 0, '3', NULL, NULL, NULL, '0,', ''),
(7, '3', '足球比赛中如何施展功夫而不被罚黄牌', 1, '2010-11-24 08:41:02', '0000-00-00 00:00:00', '参考中国足球', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(8, '3', '少林足球中，谁演的那个尼姑', 1, '2010-11-24 08:41:04', '0000-00-00 00:00:00', '33', 'lalala', '3', 5, 0, '3', NULL, NULL, NULL, '0,', ''),
(9, '3', '不是吧，标题全是3', 1, '2010-11-24 08:41:59', '0000-00-00 00:00:00', '33', 'lalala', '3', 0, 0, '3', NULL, NULL, NULL, '0,', ''),
(10, '3', '一二三四五六七八九十一二三四五六七八九十测试', 1, '2010-11-24 09:15:07', '0000-00-00 00:00:00', '测试', 'lalala', '3', 0, 1, '3', NULL, NULL, NULL, '0,', ''),
(11, '3', '没有标题可不行啊', 1, '2010-11-24 09:15:22', '0000-00-00 00:00:00', '33', 'lalala', '3', 1, 1, '3', NULL, NULL, NULL, '1,2,3', ''),
(12, '3', '文章一定得要有标题', 1, '2010-11-25 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,1,2', '2'),
(13, '3', '蓝蓝路与上校间不得不说的故事', 1, '2010-11-26 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,3', '2'),
(14, '3', '教你如何唱蓝蓝路之歌', 1, '2010-11-27 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,2,3', '2'),
(15, '3', '神说，要有光', 1, '2010-11-28 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,1', '2'),
(16, '3', '制造测试数据的全攻略', 1, '2010-11-29 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2'),
(17, '3', '文章一定得要有标题', 1, '2010-11-25 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,3', '2'),
(18, '3', '一二三四五六七八九十一二三四五六七八九十测试', 1, '2010-11-26 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '3', 1, 20, 'admin', NULL, NULL, 'firede', '0,', '2'),
(19, '3', '教你如何唱蓝蓝路之歌', 1, '2010-11-27 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,', '2'),
(20, '3', '神说，要有光', 1, '2010-11-28 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2'),
(21, '3', '制造测试数据的全攻略', 1, '2010-11-29 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '3', 1, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2'),
(22, '3', '文章一定得要有标题', 1, '2010-11-25 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,3', '2'),
(23, '3', '蓝蓝路与上校间不得不说的故事', 1, '2010-11-26 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '3', 1, 20, 'admin', NULL, NULL, 'firede', '0,', '2'),
(24, '3', '教你如何唱蓝蓝路之歌', 1, '2010-11-27 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,2,3', '2'),
(25, '3', '神说，要有光', 1, '2010-11-28 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2'),
(26, '3', '制造测试数据的全攻略', 1, '2010-11-29 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '3', 1, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2'),
(27, '3', '文章一定得要有标题', 1, '2010-11-25 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,3', '2'),
(28, '3', '蓝蓝路与上校间不得不说的故事', 1, '2010-11-26 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '3', 1, 20, 'admin', NULL, NULL, 'firede', '0,2,', '2'),
(29, '3', '教你如何唱蓝蓝路之歌', 1, '2010-11-27 08:18:46', '0000-00-00 00:00:00', '这是内容', '', '1', 3, 20, 'admin', NULL, NULL, 'firede', '0,2,3', '2'),
(30, '3', '神说，要有光', 1, '2010-11-28 08:18:46', '1990-01-01 00:00:00', '这是内容', 'pre内容', '1', 3, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2'),
(31, '3', '制造测试数据的全攻略', 1, '2010-11-29 08:18:46', '1990-01-01 00:00:00', '这是内容', 'pre内容', '3', 3, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2'),
(32, '3', '文章一定得要有标题', 1, '2010-11-25 08:18:46', '1990-01-01 00:00:00', '这是内容', '', '1', 3, 20, 'admin', NULL, NULL, 'firede', '0,3', '2'),
(33, '3', '蓝蓝路与上校间不得不说的故事', 1, '2010-11-26 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '3', 1, 20, 'admin', NULL, NULL, 'firede', '0,2,', '2'),
(34, '3', '教你如何唱蓝蓝路之歌', 1, '2010-11-27 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,2,3', '2'),
(35, '3', '神说，要有光', 1, '2010-11-28 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '1', 1, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2'),
(36, '3', '制造测试数据的全攻略', 1, '2010-11-29 08:18:46', '0000-00-00 00:00:00', '这是内容', 'pre内容', '3', 1, 20, 'admin', NULL, NULL, 'firede', '0,1,3', '2');

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
(1, 'aicoylei@gmail.com', '235252', '', 0, 0, 'http://www.google.com.hk/images/srpr/nav_logo25.png', '2010-11-12 10:48:19', '2010-11-12 10:48:43', '0'),
(3, '火云邪神', 'admin1', 'firede@qq.com', 1, 0, '', '2010-11-12 10:28:40', '2010-11-12 10:29:04', '0'),
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
