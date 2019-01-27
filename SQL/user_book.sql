-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2019 at 03:58 PM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `book_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_book`
--

CREATE TABLE IF NOT EXISTS `user_book` (
`id` int(11) NOT NULL,
  `userId` varchar(500) NOT NULL,
  `bookId` int(11) NOT NULL,
  `dateViewed` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `user_book`
--

INSERT INTO `user_book` (`id`, `userId`, `bookId`, `dateViewed`) VALUES
(1, '5c4dc27e5751c', 18, '2019-01-27 20:08:59'),
(2, '5c4dc27e5751c', 18, '2019-01-27 20:09:38'),
(3, '5c4dc27e5751c', 18, '2019-01-27 20:09:56'),
(4, '5c4dc27e5751c', 18, '2019-01-27 20:09:59'),
(5, '5c4dc27e5751c', 18, '2019-01-27 20:10:57'),
(6, '5c4dc27e5751c', 14, '2019-01-27 20:11:09'),
(7, '5c4dc31e90e7c', 14, '2019-01-27 20:11:54'),
(8, '5c4dc31e90e7c', 14, '2019-01-27 20:15:53'),
(9, '5c4dc27e5751c', 11, '2019-01-27 20:16:40'),
(10, '5c4dc31e90e7c', 14, '2019-01-27 20:17:12'),
(11, '5c4dc31e90e7c', 14, '2019-01-27 20:21:46'),
(12, '5c4dc27e5751c', 14, '2019-01-27 20:22:12'),
(13, '5c4dc27e5751c', 18, '2019-01-27 20:22:20'),
(14, '5c4dc31e90e7c', 18, '2019-01-27 20:22:28'),
(15, '5c4dc27e5751c', 18, '2019-01-27 20:22:38');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_book`
--
ALTER TABLE `user_book`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_book`
--
ALTER TABLE `user_book`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
