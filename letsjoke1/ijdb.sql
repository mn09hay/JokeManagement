-- phpMyAdmin SQL Dump
-- version 4.1.13
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 15, 2014 at 06:02 AM
-- Server version: 5.5.34
-- PHP Version: 5.5.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ijdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `author`
--

CREATE TABLE IF NOT EXISTS `author` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `path` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `author`
--

INSERT INTO `author` (`id`, `name`, `email`, `password`, `path`) VALUES
(12, 'Chase', 'chase0808@gmail.com', '8d3a85614b6f848c085a4919e4a3b4c2', '/pic/chase.jpg'),
(13, 'Melissa', 'mn09hay@gmail.com', '8d3a85614b6f848c085a4919e4a3b4c2', '/pic/meli.jpg'),
(14, 'Angela', 'angelazhao126@gmail.com', '8d3a85614b6f848c085a4919e4a3b4c2', '/pic/angela.jpg'),
(15, 'Leo', 'donglu193@gmail.com', '8d3a85614b6f848c085a4919e4a3b4c2', '/pic/leo.jpg'),
(16, 'Chris', 'chaofanbi@gmail.com', '8d3a85614b6f848c085a4919e4a3b4c2', NULL),
(17, 'Lu', 'dongl@rpi.edu', '8d3a85614b6f848c085a4919e4a3b4c2', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `authorrole`
--

CREATE TABLE IF NOT EXISTS `authorrole` (
  `authorid` int(11) NOT NULL,
  `roleid` varchar(255) NOT NULL,
  PRIMARY KEY (`authorid`,`roleid`),
  KEY `roleid` (`roleid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `authorrole`
--

INSERT INTO `authorrole` (`authorid`, `roleid`) VALUES
(17, 'Account Administrator'),
(17, 'Content Editor'),
(17, 'Site Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Knock-knock'),
(2, 'Cross the road'),
(3, 'Lawyers'),
(4, 'Walk the bar');

-- --------------------------------------------------------

--
-- Table structure for table `friendship`
--

CREATE TABLE IF NOT EXISTS `friendship` (
  `userid` int(11) DEFAULT NULL,
  `friendid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `friendship`
--

INSERT INTO `friendship` (`userid`, `friendid`) VALUES
(12, 13),
(12, 14),
(12, 15);

-- --------------------------------------------------------

--
-- Table structure for table `joke`
--

CREATE TABLE IF NOT EXISTS `joke` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `joketext` text,
  `jokedate` date NOT NULL,
  `authorid` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `authorid` (`authorid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `joke`
--

INSERT INTO `joke` (`id`, `joketext`, `jokedate`, `authorid`, `rate`) VALUES
(20, 'I totally understand how batteries feel because I''m rarely ever included in things either.', '2014-05-14', 12, 1),
(21, 'Looking back, Kel''s orange soda fetish is kind of weird. Wonder what his FANTAsies were?', '2014-05-14', 12, 2),
(22, ' A magician was walking down the street and turned into a grocery store.', '2014-05-14', 12, 1),
(23, 'If you want to catch a squirrel just climb a tree and act like a nut.', '2014-05-14', 12, 2),
(24, 'A blind man walks into a bar. And a table. And a chair.', '2014-05-14', 12, 1),
(25, 'What time is it when you have to go to the dentist? Tooth-hurtie.', '2014-05-14', 12, 1),
(26, 'Why was six afraid of seven? Because seven was a well known six offender.', '2014-05-14', 12, 1),
(28, 'Time flies like an arrow, fruit flies like banana.', '2014-05-14', 12, 0),
(29, 'How do you make Holy water? Boil the hell out of it. ', '2014-05-14', 13, 2),
(30, 'Dry erase boards are remarkable.', '2014-05-14', 13, 1),
(31, 'Dwarfs and midgets have very little in common.', '2014-05-14', 13, 0),
(32, 'I started a band called 999 Megabytes — we haven’t gotten a gig yet.\r\n', '2014-05-14', 13, 0),
(33, 'How did the hipster burn his tongue? He drank his coffee before it was cool.', '2014-05-14', 13, 0),
(34, 'Last night I almost had a threesome, I only needed two more people!', '2014-05-14', 13, 1),
(36, '谢谢你的帮助', '2014-05-14', 13, 2),
(37, 'Two fish are in a tank. One turns to the other and asks “How do you drive this thing?”', '2014-05-14', 15, 0),
(38, 'I wondered why the baseball was getting bigger. Then it hit me.\r\n', '2014-05-14', 15, 0),
(39, 'Why can’t a bike stand on its own? It’s two tired.', '2014-05-14', 14, 1),
(40, 'I wrote a song about a tortilla. Well actually, it’s more of a wrap.', '2014-05-14', 14, 0),
(41, 'What kind of shoes do ninjas wear? Sneakers.', '2014-05-14', 16, 0),
(42, 'Why was six afraid of seven? Because seven was a well known six offender.', '2014-05-14', 16, 0);

-- --------------------------------------------------------

--
-- Table structure for table `jokecategory`
--

CREATE TABLE IF NOT EXISTS `jokecategory` (
  `jokeid` int(11) NOT NULL,
  `categoryid` int(11) NOT NULL,
  PRIMARY KEY (`jokeid`,`categoryid`),
  KEY `categoryid` (`categoryid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jokecategory`
--

INSERT INTO `jokecategory` (`jokeid`, `categoryid`) VALUES
(20, 1),
(21, 1),
(28, 1),
(29, 1),
(30, 1),
(33, 1),
(37, 1),
(39, 1),
(41, 1),
(42, 1),
(20, 2),
(24, 2),
(26, 2),
(30, 2),
(33, 2),
(34, 2),
(37, 2),
(38, 2),
(40, 2),
(22, 3),
(23, 3),
(31, 3),
(32, 3),
(34, 3),
(36, 3),
(42, 3),
(21, 4);

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `description`) VALUES
('Account Administrator', 'Add, remove, and edit authors'),
('Content Editor', 'Add, remove, and edit jokes'),
('Site Administrator', 'Add, remove, and edit categories'),
('User', 'Use the website');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `authorrole`
--
ALTER TABLE `authorrole`
  ADD CONSTRAINT `authorrole_ibfk_1` FOREIGN KEY (`authorid`) REFERENCES `author` (`id`),
  ADD CONSTRAINT `authorrole_ibfk_2` FOREIGN KEY (`roleid`) REFERENCES `role` (`id`);

--
-- Constraints for table `joke`
--
ALTER TABLE `joke`
  ADD CONSTRAINT `joke_ibfk_1` FOREIGN KEY (`authorid`) REFERENCES `author` (`id`);

--
-- Constraints for table `jokecategory`
--
ALTER TABLE `jokecategory`
  ADD CONSTRAINT `jokecategory_ibfk_1` FOREIGN KEY (`jokeid`) REFERENCES `joke` (`id`),
  ADD CONSTRAINT `jokecategory_ibfk_2` FOREIGN KEY (`categoryid`) REFERENCES `category` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
