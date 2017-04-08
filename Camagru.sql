-- phpMyAdmin SQL Dump
-- version 4.6.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 08, 2017 at 02:03 AM
-- Server version: 5.7.11
-- PHP Version: 7.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Camagru`
--

-- --------------------------------------------------------

--
-- Table structure for table `Comments`
--

CREATE TABLE `Comments` (
  `id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `img_user_id` int(11) DEFAULT NULL,
  `content` varchar(255) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `published` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Comments`
--

INSERT INTO `Comments` (`id`, `file_id`, `img_user_id`, `content`, `author_id`, `published`) VALUES
(1, 4, 1, 'fruit cake', 1, '03-28-2017'),
(2, 4, 1, 'Rainbow Squanch', 1, '03-28-2017'),
(3, 4, 1, 'Another One', 1, '03-28-2017'),
(4, 4, 1, 'Yarp', 1, '03-28-2017'),
(5, 4, 1, 'Newb', 1, '03-28-2017'),
(6, 12, 1, 'Do you even Vape ', 1, '03-28-2017'),
(7, 12, 1, 'Vape Nat', 1, '03-28-2017'),
(8, 2, 1, 'comment', 1, '03-29-2017'),
(9, 2, 1, 'LOSERRR', 1, '03-29-2017'),
(10, 22, 4, 'rainbow face', 4, '03-29-2017'),
(11, 22, 4, 'The coolest man in all the land', 1, '03-29-2017'),
(12, 23, 4, 'i vape', 4, '03-29-2017'),
(13, 23, 4, 'Vape Nat', 1, '03-29-2017');

-- --------------------------------------------------------

--
-- Table structure for table `Gallery`
--

CREATE TABLE `Gallery` (
  `id` int(11) NOT NULL,
  `img_name` varchar(255) DEFAULT NULL,
  `img_path` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Gallery`
--

INSERT INTO `Gallery` (`id`, `img_name`, `img_path`, `user_id`) VALUES
(1, '20170329042054.png', './private/user_images/blockco/20170329042054.png', 3),
(2, '20170329192054.png', './private/user_images/Aaron/20170329192054.png', 1),
(3, '20170328124936.png', './private/user_images/Aaron/20170328124936.png', 1),
(4, '20170328123921.png', './private/user_images/Aaron/20170328123921.png', 1),
(5, '20170330223915.png', './private/user_images/Aaron/20170330223915.png', 1),
(6, '20170328103510.png', './private/user_images/Aaron/20170328103510.png', 1),
(7, '20170406150950.png', './private/user_images/Aaron/20170406150950.png', 1),
(8, '20170406163233.png', './private/user_images/Aaron/20170406163233.png', 1),
(9, '20170328101703.png', './private/user_images/Aaron/20170328101703.png', 1),
(10, '20170329193404.png', './private/user_images/Aaron/20170329193404.png', 1),
(11, '20170329193353.png', './private/user_images/Aaron/20170329193353.png', 1),
(12, '20170328103107.png', './private/user_images/Aaron/20170328103107.png', 1),
(13, '20170328102932.png', './private/user_images/Aaron/20170328102932.png', 1),
(14, '20170328090459.png', './private/user_images/Aaron/20170328090459.png', 1),
(15, '20170406162406.png', './private/user_images/Aaron/20170406162406.png', 1),
(16, '20170328101340.png', './private/user_images/Aaron/20170328101340.png', 1),
(17, '20170329041836.png', './private/user_images/Aaron/20170329041836.png', 1),
(18, '20170328101711.png', './private/user_images/Aaron/20170328101711.png', 1),
(19, '20170328075924.png', './private/user_images/Aaron/20170328075924.png', 1),
(20, '20170328075942.png', './private/user_images/Aaron/20170328075942.png', 1),
(21, '20170329192419.png', './private/user_images/qst0/20170329192419.png', 4),
(22, '20170329213329.png', './private/user_images/qst0/20170329213329.png', 4),
(23, '20170329193517.png', './private/user_images/qst0/20170329193517.png', 4),
(24, '20170329193509.png', './private/user_images/qst0/20170329193509.png', 4),
(25, '20170329205335.png', './private/user_images/bob/20170329205335.png', 5);

-- --------------------------------------------------------

--
-- Table structure for table `Likes`
--

CREATE TABLE `Likes` (
  `id` int(11) NOT NULL,
  `file_id` int(11) DEFAULT NULL,
  `img_user_id` int(11) DEFAULT NULL,
  `likedby_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Likes`
--

INSERT INTO `Likes` (`id`, `file_id`, `img_user_id`, `likedby_id`) VALUES
(1, 4, 1, 1),
(2, 12, 1, 1),
(3, 2, 1, 1),
(4, 22, 4, 4),
(5, 22, 4, 1),
(6, 23, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `Users`
--

CREATE TABLE `Users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Users`
--

INSERT INTO `Users` (`id`, `name`, `password`, `email`) VALUES
(1, 'Aaron', '1f4c694705d4b8a30da09de147e5901b482002030409e183db704d203413545b925e277f7ccb8f6229ba68ad1c18f7d35b50f01c4f52977a0fe70d280b5376fc', 'ach5910@gmail.com'),
(2, 'Mary', '26082f9a81ffd0e471d9b57432486e57ed693779f602c5996a3f18dfd873f72b1c2930bbd0f7a20f3452d375e03154d8b75e46d328c4c2d579057dcc758f0462', 'fake@blah.com'),
(3, 'blockco', '92123d8babb317e1f2718ad6d2585c68b61eb380201e3ac0c765d176def7702a80bc08adff8dd5a87898809b7a37b190801cafa4415a51c52fc5eda9ae84c477', 'robert.passafaro@gmail.com'),
(4, 'qst0', '2b689fd512021ee8914f06fa42187799a6db5e30554251ae8fc72ae3368e35c191e99f1e530e305ddd654b344048357016a299dc595f8fca28ce1e7a94a5599c', 'masondyoung@gmail.com'),
(5, 'bob', '47c6f356f715a2e66925b104eab021fc3339cd2ab042f44242e97c6f580eb3b37f9a94db30cdadd6c704c187e8f030ffea8988f798f3ab6c776512eb73458ddd', 'bobbarker@mail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Comments`
--
ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `img_user_id` (`img_user_id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indexes for table `Gallery`
--
ALTER TABLE `Gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Likes`
--
ALTER TABLE `Likes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `img_user_id` (`img_user_id`),
  ADD KEY `file_id` (`file_id`),
  ADD KEY `likedby_id` (`likedby_id`);

--
-- Indexes for table `Users`
--
ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Comments`
--
ALTER TABLE `Comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `Gallery`
--
ALTER TABLE `Gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT for table `Likes`
--
ALTER TABLE `Likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `Users`
--
ALTER TABLE `Users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`img_user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `Gallery` (`id`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `Gallery`
--
ALTER TABLE `Gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`);

--
-- Constraints for table `Likes`
--
ALTER TABLE `Likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`img_user_id`) REFERENCES `Users` (`id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `Gallery` (`id`),
  ADD CONSTRAINT `likes_ibfk_3` FOREIGN KEY (`likedby_id`) REFERENCES `Users` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
