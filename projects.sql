-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2017 �?02 ??01 ??14:04
-- 伺服器版本: 5.6.24
-- PHP 版本： 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 資料庫： `mis`
--

-- --------------------------------------------------------

--
-- 資料表結構 `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `projectId` int(100) NOT NULL,
  `projectCreatorId` int(100) NOT NULL,
  `projectMembersId` int(100) NOT NULL,
  `projectName` varchar(30) NOT NULL,
  `projectClassName` varchar(30) NOT NULL,
  `projectTeacher` varchar(30) NOT NULL,
  `projectCreatetime` date NOT NULL,
  `projectDeadline` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`projectId`), ADD KEY `IDX_projects_projectCreatorId` (`projectCreatorId`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `projects`
--
ALTER TABLE `projects`
  MODIFY `projectId` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `projects`
--
ALTER TABLE `projects`
ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`projectCreatorId`) REFERENCES `users` (`userId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
