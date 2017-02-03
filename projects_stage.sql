-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- 主機: 127.0.0.1
-- 產生時間： 2017 �?02 ??03 ??13:25
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
-- 資料表結構 `projects_stage`
--

CREATE TABLE IF NOT EXISTS `projects_stage` (
  `projects_stageId` int(100) NOT NULL,
  `projectId` int(100) NOT NULL,
  `project_stageStart` date NOT NULL,
  `project_stageEnd` date NOT NULL,
  `project_stageName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

--
-- 資料表的匯出資料 `projects_stage`
--

INSERT INTO `projects_stage` (`projects_stageId`, `projectId`, `project_stageStart`, `project_stageEnd`, `project_stageName`) VALUES
(26, 54, '2017-02-01', '2017-02-03', 'å°'),
(27, 54, '2017-02-04', '2017-02-06', 'äºŒ'),
(28, 54, '2017-02-08', '2017-02-16', 'ä¸‰'),
(29, 55, '2017-02-03', '2017-02-04', 'æ¸¬è©¦'),
(30, 55, '2017-02-05', '2017-02-06', 'æ¸¬è©¦'),
(31, 55, '2017-02-07', '2017-02-08', 'æ¸¬è©¦'),
(32, 56, '2017-02-24', '0000-00-00', 'å¤§'),
(33, 56, '0000-00-00', '0000-00-00', 'å¤§'),
(34, 56, '0000-00-00', '0000-00-00', 'å¤§');

--
-- 已匯出資料表的索引
--

--
-- 資料表索引 `projects_stage`
--
ALTER TABLE `projects_stage`
  ADD PRIMARY KEY (`projects_stageId`), ADD KEY `projectId` (`projectId`);

--
-- 在匯出的資料表使用 AUTO_INCREMENT
--

--
-- 使用資料表 AUTO_INCREMENT `projects_stage`
--
ALTER TABLE `projects_stage`
  MODIFY `projects_stageId` int(100) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=35;
--
-- 已匯出資料表的限制(Constraint)
--

--
-- 資料表的 Constraints `projects_stage`
--
ALTER TABLE `projects_stage`
ADD CONSTRAINT `projects_stage_ibfk_1` FOREIGN KEY (`projectId`) REFERENCES `projects` (`projectId`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
