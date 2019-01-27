-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2019 at 05:19 PM
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

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `GetBookRecommendations`(IN `userID` VARCHAR(500), IN `bookID` INT(11))
    NO SQL
SELECT * FROM book
WHERE id IN (

    SELECT bookId FROM user_book
    WHERE userId IN(
       
        SELECT userId
        FROM user_book
        WHERE bookId = bookID
        AND userid != userID
    
    )
    
    AND bookid != bookID
)$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `GetBySearchTerm`(IN `searchTerm` VARCHAR(500))
    NO SQL
select * from book where `title` like CONCAT('%',searchTerm,'%') or `author` like CONCAT('%',searchTerm,'%')$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE IF NOT EXISTS `book` (
`id` int(11) NOT NULL,
  `title` varchar(500) NOT NULL,
  `price` decimal(4,2) NOT NULL,
  `cover` varchar(500) NOT NULL,
  `visitorStats` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `author` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`id`, `title`, `price`, `cover`, `visitorStats`, `categoryId`, `author`) VALUES
(1, 'Thinking, fast and slow', '11.00', 'al.jpg', 0, 1, 'Daniel Kahneman'),
(8, 'Dare to Lead: Brave Work. Tough Conversations. Whole Hearts', '12.00', '40109367.jpg', 0, 1, 'Brené Brown*'),
(11, 'Elevation', '1.00', '383554102.jpg', 1, 3, 'Stephen King'),
(12, 'Almost Everything: Notes on Hope', '13.00', '392037904.jpg', 0, 1, 'Anne Lamott'),
(13, 'The Curse in the Candlelight', '14.22', 's-l225.jpg', 0, 6, 'Sophie Cleverly'),
(14, 'Billion Dollar Whale', '2.75', '38743564.jpg', 6, 5, 'Tom Wright'),
(15, 'Lose Well', '2.29', '38139408.jpg', 0, 1, 'Chris Gethard'),
(16, 'When''s Happy Hour?: Work Hard So You Can Hardly Work', '11.60', '40591598.jpg', 0, 1, 'The Betches'),
(17, '(Don''t) Call Me Crazy', '1.67', '33803157.jpg', 0, 1, 'Kelly Jensen,  Victoria Schwab, Adam Silvera '),
(18, 'The First Days', '2.29', '9648068.jpg', 6, 23, 'Rhiannon Frater');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `cartId` int(11) NOT NULL,
  `sessionId` varchar(50) NOT NULL,
  `itemId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
`id` int(11) NOT NULL,
  `name` varchar(500) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(22, 'Action'),
(23, 'Adventure'),
(5, 'Business'),
(3, 'Horror'),
(21, 'Mystery'),
(2, 'Psychology'),
(6, 'Science Fiction'),
(1, 'Self help');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('2kpklkgv5s6p7l1gqsbshl5e5j2p75hs', '::1', 1548600748, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383630303734383b75736572556e6971756549647c733a31333a2235633464633331653930653763223b),
('5c60bfcjufps6cn4m5u8711op1fvuq0i', '::1', 1548600758, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383630303732333b75736572556e6971756549647c733a31333a2235633464633237653537353163223b75736572497341646d696e7c623a313b),
('6mra5tmr8srj6cusmc3llf95gdnis97v', '::1', 1548600706, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383630303433323b75736572556e6971756549647c733a31333a2235633464633331653930653763223b),
('jbl6q6o3fgd191oe3i1b78fqtgtm2h1s', '::1', 1548600400, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383630303339363b75736572556e6971756549647c733a31333a2235633464633237653537353163223b75736572497341646d696e7c623a313b),
('od3p7dg8nti09i5a2rahn5b5ut776got', '::1', 1548600353, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383630303039343b75736572556e6971756549647c733a31333a2235633464633331653930653763223b),
('t8i07nuq9uc16sje5v8srsvdlmuq8l56', '::1', 1548600073, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383539393933343b75736572556e6971756549647c733a31333a2235633464633237653537353163223b75736572497341646d696e7c623a313b),
('u9l5h90kg2ve2c968ps3mmp7j1tl8o0q', '::1', 1548601559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313534383630313535393b75736572556e6971756549647c733a31333a2235633464633237653537353163223b75736572497341646d696e7c623a313b);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
`orderId` int(11) NOT NULL,
  `sessionId` varchar(500) NOT NULL,
  `bookId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Indexes for table `book`
--
ALTER TABLE `book`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
 ADD PRIMARY KEY (`id`), ADD KEY `ci_sessions_timestamp` (`timestamp`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
 ADD PRIMARY KEY (`orderId`);

--
-- Indexes for table `user_book`
--
ALTER TABLE `user_book`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `book`
--
ALTER TABLE `book`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_book`
--
ALTER TABLE `user_book`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
