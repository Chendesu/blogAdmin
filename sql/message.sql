-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-03-20 17:14:13
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `db`
--

-- --------------------------------------------------------

--
-- 表的结构 `message`
--

CREATE TABLE `message` (
  `id` int(4) NOT NULL,
  `username` varchar(40) CHARACTER SET utf8 NOT NULL,
  `time` varchar(20) CHARACTER SET utf8 NOT NULL,
  `text` text CHARACTER SET utf8 NOT NULL,
  `image` varchar(200) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `message`
--

INSERT INTO `message` (`id`, `username`, `time`, `text`, `image`) VALUES
(78, 'Thursday', '2019-10-25 17:01:39', '测试测试', 'uploads/blog_15719940995db2b9f39b77a.jpg'),
(80, 'chen', '2019-10-25 17:02:15', '苹果', 'uploads/blog_15719941355db2ba17cb122.png'),
(81, 'chen', '2019-10-25 17:02:34', 'bjyxszd', 'uploads/blog_15719941545db2ba2a7d23a.jpg'),
(82, 'eve', '2019-10-25 17:03:10', '壁纸', 'uploads/blog_15719941905db2ba4edd507.jpg'),
(83, 'admin', '2019-10-25 17:05:13', '布丁', 'uploads/blog_15719943135db2bac9b291a.jpg'),
(84, 'Tuesday', '2019-10-25 17:06:10', '周五', 'uploads/blog_15719943705db2bb02c73b9.jpg'),
(85, 'root', '2019-10-25 17:07:01', '这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话这是一段话', 'uploads/blog_15719944215db2bb35d1320.gif'),
(87, 'root', '2019-10-25 17:07:32', '哈哈哈哈哈哈', 'uploads/blog_15719944525db2bb5410a35.gif'),
(88, 'chen', '2019-10-28 10:48:24', 'o_O', 'uploads/blog_15722309045db656f83a093.gif'),
(89, 'chen', '2019-10-28 10:48:47', 'now', 'uploads/blog_15722309275db6570fe21d4.png'),
(90, 'chen', '2019-11-13 09:11:10', '哈', 'uploads/blog_15736074705dcb582e84f1b.png'),
(93, 'admin', '2019-11-26 15:58:17', '苹果123', 'uploads/blog_15747550975ddcdb1989971.png'),
(94, 'admin', '2019-11-26 16:00:23', '23333~', 'uploads/blog_15747552235ddcdb97aa80e.jpeg'),
(95, 'chen', '2019-11-26 16:00:56', '蟲', 'uploads/blog_15747552565ddcdbb859c4c.jpg'),
(106, 'test', '2020-02-25 13:58:37', '123', 'uploads/blog_15826103175e54b78df1ab8.gif');

--
-- 转储表的索引
--

--
-- 表的索引 `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `message`
--
ALTER TABLE `message`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
