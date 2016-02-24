-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 24, 2016 at 09:39 AM
-- Server version: 5.6.27-0ubuntu0.15.04.1-log
-- PHP Version: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `toolbar`
--

-- --------------------------------------------------------

--
-- Table structure for table `ad`
--

CREATE TABLE IF NOT EXISTS `ad` (
`id` int(11) NOT NULL,
  `image` varchar(512) NOT NULL,
  `link` varchar(256) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ad`
--

INSERT INTO `ad` (`id`, `image`, `link`, `status`) VALUES
(1, 'https://ss0.baidu.com/6ONWsjip0QIZ8tyhnq/it/u=1851037713,3247824961&fm=80', 'http://www.baidu.com', 0),
(2, 'http://img1.gtimg.com/15/1523/152333/15233301_small.png', 'http://www.qq.com', 0),
(3, 'http://img.ithome.com/NewsUploadFiles/thumbnail/2016/2/208096_240.jpg', 'http://www.ithome.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `data_plan`
--

CREATE TABLE IF NOT EXISTS `data_plan` (
`id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `size` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `data_plan`
--

INSERT INTO `data_plan` (`id`, `name`, `size`, `status`) VALUES
(1, '50M 半年流量包', 50, 1),
(2, '100M 半年流量包', 100, 1);

-- --------------------------------------------------------

--
-- Table structure for table `manager`
--

CREATE TABLE IF NOT EXISTS `manager` (
`id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `manager`
--

INSERT INTO `manager` (`id`, `username`, `password`) VALUES
(1, 'admin', '123456');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
`id` int(11) NOT NULL,
  `ip` varchar(16) NOT NULL,
  `yewu` varchar(64) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `ip`, `yewu`) VALUES
(2, '192.168.33.1', '5');

-- --------------------------------------------------------

--
-- Table structure for table `user_liuliang`
--

CREATE TABLE IF NOT EXISTS `user_liuliang` (
`id` int(11) NOT NULL,
  `ip` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `used` decimal(10,2) NOT NULL,
  `size` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_liuliang`
--

INSERT INTO `user_liuliang` (`id`, `ip`, `name`, `used`, `size`, `plan_id`) VALUES
(4, '192.168.33.1', '基础流量包', 331.57, 500, 0),
(5, '192.168.33.1', '100M 半年流量包', 0.61, 100, 2);

-- --------------------------------------------------------

--
-- Table structure for table `yewu`
--

CREATE TABLE IF NOT EXISTS `yewu` (
`id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `icon` varchar(128) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `yewu`
--

INSERT INTO `yewu` (`id`, `name`, `icon`, `status`) VALUES
(1, '彩铃', 'http://192.168.33.10:8080/image/logo.gif', 1),
(2, '邮箱', 'http://192.168.33.10:8080/image/logo.gif', 1),
(3, '手机报', 'http://192.168.33.10:8080/image/logo.gif', 1),
(4, '天气预报', 'http://192.168.33.10:8080/image/logo.gif', 1),
(5, '动感地带', 'http://192.168.33.10:8080/image/logo.gif', 1),
(6, '全球通', 'http://192.168.33.10:8080/image/logo.gif', 1),
(7, '业务1', 'http://192.168.33.10:8080/image/logo.gif', 1),
(8, '业务2', 'http://192.168.33.10:8080/image/logo.gif', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ad`
--
ALTER TABLE `ad`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `data_plan`
--
ALTER TABLE `data_plan`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_liuliang`
--
ALTER TABLE `user_liuliang`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yewu`
--
ALTER TABLE `yewu`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ad`
--
ALTER TABLE `ad`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `data_plan`
--
ALTER TABLE `data_plan`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `manager`
--
ALTER TABLE `manager`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `user_liuliang`
--
ALTER TABLE `user_liuliang`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `yewu`
--
ALTER TABLE `yewu`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
