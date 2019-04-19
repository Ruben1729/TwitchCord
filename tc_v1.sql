-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 19, 2019 at 01:53 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `banned`
--

CREATE TABLE `banned` (
  `user_id` int(5) NOT NULL,
  `channel_id` int(5) NOT NULL,
  `banned_on` date NOT NULL,
  `ban_binary` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `channelmodel`
--

CREATE TABLE `channelmodel` (
  `channel_id` int(5) NOT NULL,
  `channel_name` varchar(20) NOT NULL,
  `description` varchar(80) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `picture_id` int(5) DEFAULT NULL,
  `owner_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `channelmodel`
--

INSERT INTO `channelmodel` (`channel_id`, `channel_name`, `description`, `created_on`, `picture_id`, `owner_id`) VALUES
(1, 'soroban1729', 'Hello, my name is MOTHER RUSSIANOoooda', '2019-04-18 03:06:55', 14, 3);

-- --------------------------------------------------------

--
-- Table structure for table `follower`
--

CREATE TABLE `follower` (
  `user_id` int(5) NOT NULL,
  `channel_id` int(6) NOT NULL,
  `followed_on` date NOT NULL,
  `notification` int(1) NOT NULL,
  `role_id` int(5) NOT NULL DEFAULT '1',
  `permission_binary` int(10) NOT NULL DEFAULT '112'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_chat`
--

CREATE TABLE `group_chat` (
  `group_chat_id` int(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `channel_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `group_message`
--

CREATE TABLE `group_message` (
  `message_id` int(10) NOT NULL,
  `text` text NOT NULL,
  `group_chat_id` int(6) NOT NULL,
  `created_on` date NOT NULL,
  `user_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_message`
--

INSERT INTO `group_message` (`message_id`, `text`, `group_chat_id`, `created_on`, `user_id`) VALUES
(1, 'test', 0, '0000-00-00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `picturemodel`
--

CREATE TABLE `picturemodel` (
  `picture_id` int(11) NOT NULL,
  `path` varchar(300) NOT NULL,
  `owner_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `picturemodel`
--

INSERT INTO `picturemodel` (`picture_id`, `path`, `owner_id`) VALUES
(14, '\\Pictures\\5cb7e9dbf14dd.jpg', 3);

-- --------------------------------------------------------

--
-- Table structure for table `profilemodel`
--

CREATE TABLE `profilemodel` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `bio` varchar(80) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `picture_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `relationmodel`
--

CREATE TABLE `relationmodel` (
  `user_id` int(11) NOT NULL,
  `user_id_1` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(10) NOT NULL,
  `permission_binary` int(10) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `permission_binary`, `name`) VALUES
(1, 112, 'Regular'),
(2, 126, 'Moderator'),
(3, 127, 'Owner');

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `status_id` int(5) NOT NULL,
  `status_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `usermodel`
--

CREATE TABLE `usermodel` (
  `user_id` int(5) NOT NULL,
  `username` varchar(80) NOT NULL,
  `password_hash` varchar(80) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `usermodel`
--

INSERT INTO `usermodel` (`user_id`, `username`, `password_hash`, `email`) VALUES
(1, 'test', '$2y$10$cSM4/aA902vL3YY0TchzjOa4I8Eevgjplmk2N4cSKZWhTfjsdu4ym', 'test@test.com'),
(2, 'test2', '$2y$10$lYu/liAJOGjE0qVrVL2xEO1SrfIB/6fcKKBPoGl2vwFS1gPEM8m16', 'gameactin@gmail.com'),
(3, 'Root', '$2y$10$jatArJSnx26KTFWhFccyauzkIpTTqNBz4yePLTq4NmviaIjjIgZoy', 'root@tor.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banned`
--
ALTER TABLE `banned`
  ADD PRIMARY KEY (`user_id`,`channel_id`);

--
-- Indexes for table `channelmodel`
--
ALTER TABLE `channelmodel`
  ADD PRIMARY KEY (`channel_id`),
  ADD UNIQUE KEY `owner_id` (`owner_id`),
  ADD UNIQUE KEY `picture_id` (`picture_id`);

--
-- Indexes for table `follower`
--
ALTER TABLE `follower`
  ADD PRIMARY KEY (`user_id`,`channel_id`),
  ADD KEY `follower_channel_id_FK` (`channel_id`),
  ADD KEY `follower_role_id_FK` (`role_id`);

--
-- Indexes for table `group_chat`
--
ALTER TABLE `group_chat`
  ADD PRIMARY KEY (`group_chat_id`),
  ADD UNIQUE KEY `channel_id` (`channel_id`),
  ADD UNIQUE KEY `role_id` (`role_id`);

--
-- Indexes for table `group_message`
--
ALTER TABLE `group_message`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `picturemodel`
--
ALTER TABLE `picturemodel`
  ADD PRIMARY KEY (`picture_id`),
  ADD KEY `picturemodel_usermodel_FK` (`owner_id`);

--
-- Indexes for table `profilemodel`
--
ALTER TABLE `profilemodel`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `Profile_user_id_FK` (`user_id`);

--
-- Indexes for table `relationmodel`
--
ALTER TABLE `relationmodel`
  ADD PRIMARY KEY (`user_id`,`user_id_1`),
  ADD UNIQUE KEY `status_id` (`status_id`),
  ADD KEY `Relation_user_id_1_FK` (`user_id_1`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `usermodel`
--
ALTER TABLE `usermodel`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `channelmodel`
--
ALTER TABLE `channelmodel`
  MODIFY `channel_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `group_chat`
--
ALTER TABLE `group_chat`
  MODIFY `group_chat_id` int(6) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_message`
--
ALTER TABLE `group_message`
  MODIFY `message_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `picturemodel`
--
ALTER TABLE `picturemodel`
  MODIFY `picture_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `profilemodel`
--
ALTER TABLE `profilemodel`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `status_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `usermodel`
--
ALTER TABLE `usermodel`
  MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `follower`
--
ALTER TABLE `follower`
  ADD CONSTRAINT `follower_channel_id_FK` FOREIGN KEY (`channel_id`) REFERENCES `channelmodel` (`channel_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `follower_role_id_FK` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `follower_user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `usermodel` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `picturemodel`
--
ALTER TABLE `picturemodel`
  ADD CONSTRAINT `picturemodel_usermodel_FK` FOREIGN KEY (`owner_id`) REFERENCES `usermodel` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `profilemodel`
--
ALTER TABLE `profilemodel`
  ADD CONSTRAINT `Profile_user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `usermodel` (`user_id`);

--
-- Constraints for table `relationmodel`
--
ALTER TABLE `relationmodel`
  ADD CONSTRAINT `Relation_user_id_1_FK` FOREIGN KEY (`user_id_1`) REFERENCES `usermodel` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Relation_user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `usermodel` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
