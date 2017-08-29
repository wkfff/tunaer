-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2017 at 05:33 PM
-- Server version: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tunaer`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL,
  `aname` varchar(20) NOT NULL,
  `passwd` char(33) NOT NULL,
  `adminflag` tinyint(1) NOT NULL COMMENT '管理类型'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `aname`, `passwd`, `adminflag`) VALUES
(1, '张管理', '202cb962ac59075b964b07152d234b70', 9);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `phone` char(12) NOT NULL,
  `passwd` char(32) NOT NULL,
  `qqid` varchar(30) NOT NULL DEFAULT '0' COMMENT 'qq登录授权openid',
  `wxid` varchar(30) NOT NULL DEFAULT '0' COMMENT '微信登录授权openid',
  `regip` char(15) NOT NULL DEFAULT '0',
  `regtime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastonline` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常/0冻结'
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `phone`, `passwd`, `qqid`, `wxid`, `regip`, `regtime`, `lastlogin`, `lastonline`, `status`) VALUES
(5, '18328402805', 'e10adc3949ba59abbe56e057f20f883e', '0', '0', '127.0.0.1', '2017-08-26 08:54:50', '2017-08-26 08:54:50', '2017-08-26 08:54:50', 1),
(6, '18328402801', '202cb962ac59075b964b07152d234b70', '0', '0', '127.0.0.1', '2017-08-29 06:23:11', '2017-08-29 06:23:11', '2017-08-29 06:23:11', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userattr`
--

CREATE TABLE IF NOT EXISTS `userattr` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `head` char(25) NOT NULL DEFAULT '0',
  `uname` varchar(20) NOT NULL,
  `sex` enum('男','女') NOT NULL,
  `age` int(11) NOT NULL,
  `addr` varchar(20) NOT NULL,
  `mryst` enum('未婚','已婚','离异','丧偶') NOT NULL,
  `height` int(11) NOT NULL DEFAULT '0',
  `intro` varchar(60) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `userattr`
--

INSERT INTO `userattr` (`id`, `uid`, `head`, `uname`, `sex`, `age`, `addr`, `mryst`, `height`, `intro`) VALUES
(1, 5, '5_1503983652.jpg', '听闻君莫笑', '女', 25, '成都', '未婚', 0, 'hahahhahahah'),
(2, 6, '0', '浊酒杯醉人不醉', '男', 25, '成都', '未婚', 0, 'asdcjas8u chasui chasuidc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `userattr`
--
ALTER TABLE `userattr`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `userattr`
--
ALTER TABLE `userattr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
