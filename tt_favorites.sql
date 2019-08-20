-- phpMyAdmin SQL Dump
-- version 4.4.15.10
-- https://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-08-20 10:00:00
-- 服务器版本： 5.5.62-log
-- PHP Version: 5.4.45

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tt_favorites`
--

CREATE DATABASE IF NOT EXISTS `tt_favorites` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `tt_favorites`;

-- --------------------------------------------------------

--
-- 表的结构 `tt_favorites`
--

CREATE TABLE IF NOT EXISTS `tt_favorites` (
  `f_id` smallint(5) NOT NULL COMMENT '收藏链接ID',
  `f_name` text NOT NULL COMMENT '收藏链接名字',
  `f_url` text NOT NULL COMMENT '收藏链接',
  `t_id` tinyint(3) NOT NULL COMMENT '收藏类型',
  `f_addtime` int(11) NOT NULL COMMENT '添加时间'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='链接收藏表';

--
-- 转存表中的数据 `tt_favorites`
--

INSERT INTO `tt_favorites` (`f_id`, `f_name`, `f_url`, `t_id`, `f_addtime`) VALUES
(1, 'Google 翻译', 'https://translate.google.cn', 1, 1546272000),
(2, 'Rat Blog超实用博客', 'https://www.moerats.com', 2, 1546272000),
(3, '时间戳转换工具', 'https://tool.lu/timestamp/', 3, 1546272000),
(4, '阿里云控制台首页', 'https://homenew.console.aliyun.com', 4, 1546272000);

-- --------------------------------------------------------

--
-- 表的结构 `tt_favorites_type`
--

CREATE TABLE IF NOT EXISTS `tt_favorites_type` (
  `t_id` smallint(5) NOT NULL COMMENT '收藏类型ID',
  `t_name` text NOT NULL COMMENT '收藏类型名字'
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='链接收藏类型表';

--
-- 转存表中的数据 `tt_favorites_type`
--

INSERT INTO `tt_favorites_type` (`t_id`, `t_name`) VALUES
(1, '普通'),
(2, '教程'),
(3, '工具'),
(4, '后台');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tt_favorites`
--
ALTER TABLE `tt_favorites`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `tt_favorites_type`
--
ALTER TABLE `tt_favorites_type`
  ADD PRIMARY KEY (`t_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tt_favorites`
--
ALTER TABLE `tt_favorites`
  MODIFY `f_id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '收藏链接ID',AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tt_favorites_type`
--
ALTER TABLE `tt_favorites_type`
  MODIFY `t_id` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '收藏类型ID',AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
