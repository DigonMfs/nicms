-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 28, 2020 at 07:33 PM
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
  `title` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `abstract` text NOT NULL,
  `date_to_publish` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `articlecategory`
--

CREATE TABLE `articlecategory` (
  `row_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
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
  `category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `channel`
--

CREATE TABLE `channel` (
  `row_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `can_unpublish` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `channel`
--

INSERT INTO `channel` (`row_id`, `name`, `can_unpublish`) VALUES
(1, 'Mail', 0),
(2, 'Facebook', 1),
(3, 'LinkedIn', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `row_id` int(11) NOT NULL,
  `username` int(50) NOT NULL,
  `password` int(25) NOT NULL,
  `displayname` int(50) NOT NULL,
  `function` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`row_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `articlecategory`
--
ALTER TABLE `articlecategory`
  ADD PRIMARY KEY (`row_id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `category_id` (`category_id`);

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
  ADD PRIMARY KEY (`row_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `articlecategory`
--
ALTER TABLE `articlecategory`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `articlechannel`
--
ALTER TABLE `articlechannel`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `channel`
--
ALTER TABLE `channel`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `row_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`row_id`);

--
-- Constraints for table `articlecategory`
--
ALTER TABLE `articlecategory`
  ADD CONSTRAINT `articlecategory_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`row_id`),
  ADD CONSTRAINT `articlecategory_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `category` (`row_id`);

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