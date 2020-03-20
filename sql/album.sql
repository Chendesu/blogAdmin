-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2020-03-20 17:12:50
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
-- 表的结构 `album`
--

CREATE TABLE `album` (
  `id` int(4) NOT NULL,
  `username` varchar(40) NOT NULL,
  `time` varchar(40) NOT NULL,
  `text` varchar(200) CHARACTER SET utf8 NOT NULL,
  `images` varchar(1000) NOT NULL,
  `recommend` tinyint(1) NOT NULL,
  `classify` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `album`
--

INSERT INTO `album` (`id`, `username`, `time`, `text`, `images`, `recommend`, `classify`) VALUES
(3, 'eve', '2019-10-18 16:12:10', '周五', 'album/blog_15713863305da973dac23dc.jpg', 0, NULL),
(4, 'Thursday', '2019-10-18 16:15:25', 'bjyxszd!!!!!!!bjyxszd!!!!!!!bjyxszd!!!!!!!bjyxszd!!!!!!!', 'album/blog_15713865255da9749db44e7.jpg', 0, NULL),
(5, 'Thursday', '2019-10-18 16:16:09', '哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈呵呵呵呵', 'album/blog_15713865695da974c9d346a.jpg', 0, NULL),
(6, 'root', '2019-10-18 16:16:52', '晚霞', 'album/blog_15713866125da974f4584fb.jpg', 0, NULL),
(7, 'chen', '2019-10-18 16:17:50', '捕捉到一个小玳瑁', 'album/blog_15713866705da9752e2b9ca.jpg', 0, NULL),
(8, 'chen', '2019-10-18 16:52:42', '', 'album/blog_15713887625da97d5a43d86.jpg', 0, NULL),
(9, 'chen', '2019-10-18 16:53:35', '测试测试测试测试', 'album/blog_15713888155da97d8fe99ee.jpg', 0, NULL),
(10, 'chen', '2019-10-18 16:57:07', '哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈', 'album/blog_15713890275da97e632a867.jpg', 0, NULL),
(11, 'chen', '2019-10-18 16:57:32', '呵呵呵呵呵呵呵呵呵呵呵', 'album/blog_15713890525da97e7c6359c.gif', 0, NULL),
(12, 'chen', '2019-10-18 17:02:48', 'eeeeeeeeeeeeeeeeeeeeee', 'album/blog_15713893685da97fb87ef5a.jpg', 0, NULL),
(13, 'admin', '2019-10-21 09:37:32', '谢丽丽的布丁', 'album/blog_15716218525dad0bdcd6776.jpg', 0, NULL),
(14, 'admin', '2019-10-21 09:40:19', '晚上的路灯', 'album/blog_15716220195dad0c830a2ec.jpg', 0, NULL),
(15, 'admin', '2019-10-21 09:40:58', '望海角', 'album/blog_15716220585dad0caa0d221.jpg', 0, NULL),
(16, 'admin', '2019-10-21 09:42:28', '古镇', 'album/blog_15716221485dad0d04653d1.jpg', 0, NULL),
(17, 'admin', '2019-10-21 11:11:04', '西瓜 ', 'album/blog_15716274645dad21c8f128f.jpg', 0, NULL),
(19, 'admin', '2019-10-25 09:05:11', '哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈哈', 'album/blog_15719655115db24a472d82a.gif', 0, NULL),
(25, 'admin', '2019-11-25 09:31:45', '测试测试测试测试', 'album/blog_15746455055ddb2f0174b94.jpeg', 1, NULL),
(26, 'admin', '2019-11-25 09:36:06', '苹果123', 'album/blog_15746457665ddb30062c509.jpeg', 1, NULL),
(28, 'admin', '2019-11-26 09:15:04', '转', 'album/blog_15747309045ddc7c98898d9.gif', 0, NULL),
(29, 'admin', '2019-11-26 09:15:55', '图图图', 'album/blog_15747309555ddc7ccb88741.jpeg', 1, 1),
(31, 'chen', '2019-12-26 17:22:17', 'Spongebob   海绵宝宝', 'album/blog_15773521375e047bc9d8011.jpeg', 1, 3);

--
-- 转储表的索引
--

--
-- 表的索引 `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `album`
--
ALTER TABLE `album`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
