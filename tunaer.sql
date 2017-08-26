-- phpMyAdmin SQL Dump
-- version 4.4.15.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2017 at 05:59 PM
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `phone`, `passwd`, `qqid`, `wxid`, `regip`, `regtime`, `lastlogin`, `lastonline`, `status`) VALUES
(5, '18328402805', 'e10adc3949ba59abbe56e057f20f883e', '0', '0', '127.0.0.1', '2017-08-26 08:54:50', '2017-08-26 08:54:50', '2017-08-26 08:54:50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userattr`
--

CREATE TABLE IF NOT EXISTS `userattr` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `head` char(15) NOT NULL DEFAULT '0',
  `uname` varchar(20) NOT NULL,
  `sex` enum('男','女') NOT NULL,
  `age` int(11) NOT NULL,
  `addr` varchar(20) NOT NULL,
  `mryst` enum('未婚','已婚','离异','丧偶') NOT NULL,
  `height` int(11) NOT NULL,
  `intro` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `userattr`
--
ALTER TABLE `userattr`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
