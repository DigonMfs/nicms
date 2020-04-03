-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2020 at 09:48 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nicms`
--

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `row_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `creation_time` date NOT NULL,
  `published` tinyint(1) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT 0,
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `abstract` text NOT NULL,
  `category_id` varchar(11) NOT NULL,
  `subcategory_id` varchar(11) NOT NULL,
  `signed_by` varchar(50) NOT NULL,
  `link` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `articlechannel`
--

CREATE TABLE `articlechannel` (
  `row_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `is_published` tinyint(1) NOT NULL,
  `published_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `row_id` int(11) NOT NULL,
  `category` varchar(50) NOT NULL,
  `parent_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`row_id`, `category`, `parent_id`) VALUES
(1, 'Knowledge Base', 0),
(2, 'Blogs', 0),
(3, 'MFS', 1),
(4, 'Nieuws', 1),
(5, 'Blogs', 2),
(6, 'Nieuws', 2);

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

CREATE TABLE `channel` (
  `row_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `can_unpublish` tinyint(1) NOT NULL,
  `type` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`row_id`, `name`, `can_unpublish`, `type`) VALUES
(1, 'Facebook', 1, 1),
(2, 'LinkedIn', 1, 1),
(3, 'RSS Feed 1', 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `row_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `display_name` varchar(50) NOT NULL,
  `function` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`row_id`, `username`, `password`, `display_name`, `function`) VALUES
(1, 'admin', '$2y$10$T.uAETpifBQugW6yLsafiea8P6AlQmTimaaoVSMCN1Q.t7OyArai6', 'admin', '1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`row_id`),
  ADD UNIQUE KEY `permalink` (`link`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `articlechannel`
--
ALTER TABLE `articlechannel`
  ADD PRIMARY KEY (`row_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `channel_id` (`channel_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`row_id`);

--
-- Indexes for table `channel`
--
ALTER TABLE `channel`
  ADD PRIMARY KEY (`row_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`row_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `articlechannel`
--
ALTER TABLE `articlechannel`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`row_id`);

--
-- Constraints for table `articlechannel`
--
ALTER TABLE `articlechannel`
  ADD CONSTRAINT `articlechannel_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`row_id`),
  ADD CONSTRAINT `articlechannel_ibfk_2` FOREIGN KEY (`channel_id`) REFERENCES `channel` (`row_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
