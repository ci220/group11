-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2025 at 03:12 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `railwayforum`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `discussion_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `discussion_id`, `user_id`, `content`, `date`) VALUES
(1, 8, 14, 'test', '2025-01-07 20:02:08'),
(3, 8, 15, 'hi', '2025-01-07 20:22:28');

-- --------------------------------------------------------

--
-- Table structure for table `discussions`
--

CREATE TABLE `discussions` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `discussions`
--

INSERT INTO `discussions` (`id`, `category`, `title`, `content`, `date`, `user_id`, `image_path`) VALUES
(6, 'Travel Tips', 'test', 'test, this is a good place but not exist', '2025-01-07 18:10:38', 13, NULL),
(7, 'Stations', 'ssss', 'asghkjhgtrfghjkihoi8uythgfvbnmkiuy', '2025-01-07 18:14:57', 13, '/uploads/forum/677cfea1f1d36.jpeg'),
(8, 'Travel Tips', 'testetst', 'testestestestestestestestestest', '2025-01-07 18:18:56', 13, NULL),
(9, 'Travel Tips', 'tredfcxvvc', 'dgfdcbbgfdgdfgdfgdgdfgdfdfdgdgdgd', '2025-01-07 20:29:06', 15, '/uploads/forum/677d1e12c070e.png');

-- --------------------------------------------------------

--
-- Table structure for table `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` enum('accepted','pending','none','') NOT NULL DEFAULT 'none',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `friends`
--

INSERT INTO `friends` (`id`, `user_id`, `friend_id`, `status`, `created_at`) VALUES
(6, 9, 13, 'accepted', '2025-01-07 01:05:38'),
(7, 14, 13, 'accepted', '2025-01-07 10:26:47'),
(8, 15, 13, 'accepted', '2025-01-07 12:25:40'),
(9, 15, 14, 'pending', '2025-01-07 12:25:44');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `sent_at` datetime DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `subject`, `body`, `sent_at`, `is_read`) VALUES
(1, 13, 9, '', 'hello', '2025-01-07 17:22:18', 0),
(2, 9, 13, '', 'hai', '2025-01-07 17:25:34', 0),
(3, 9, 13, '', 'testing it is very fun', '2025-01-07 17:41:33', 0),
(4, 13, 9, '', 'really?', '2025-01-07 17:45:25', 0),
(5, 13, 15, '', 'hi dr', '2025-01-07 20:32:00', 0),
(6, 15, 13, '', 'hi clemf', '2025-01-07 20:33:01', 0);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `media_path` varchar(256) NOT NULL,
  `media_type` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `likes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `media_path`, `media_type`, `description`, `created_at`, `likes`) VALUES
(4, 9, 'post_677ce79f6b431.jpg', 'image/jpeg', 'weathering with you\nhahaha\nlove it', '2025-01-07 08:36:47', 0),
(5, 13, 'post_677ce9f84dbbf.jpeg', 'image/jpeg', 'shibuya street', '2025-01-07 08:46:48', 0),
(6, 15, 'post_677d1f55bb395.jpg', 'image/jpeg', 'harry potter', '2025-01-07 12:34:29', 0);

-- --------------------------------------------------------

--
-- Table structure for table `post_likes`
--

CREATE TABLE `post_likes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post_likes`
--

INSERT INTO `post_likes` (`id`, `user_id`, `post_id`) VALUES
(3, 13, 4),
(4, 13, 5),
(5, 14, 5),
(6, 15, 4),
(7, 15, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `second_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `second_name`, `username`, `email`, `password`, `profile_picture`, `created_at`) VALUES
(8, 'Nursyakirah', 'Ruslan', 'kiera', 'di210006@siswa.uthm.edu.my', '$2y$10$yOUiU68E31cIweorluvzzufEPp7sTJw6VZynCPJps8dtM4VWiyZ3y', NULL, '2024-11-22 10:30:00'),
(9, 'test', 'test', 'test', 'test@gmail.com', '$2y$10$DcXUr7sCfBXAeXnYo1baIeFKXWUyJoTGmsYjuZ7Giy/F82zXzesW.', 'profile_677bd61f30fc39.99506048.png', '2025-01-04 07:53:32'),
(13, 'clement', 'foong', 'clemf', 'clementfoong5765@gmail.com', '$2y$10$XUnVo5qFBwP9fyIvwiXpgeZc5GCWYSDrIWIJZ02sVxsA/mbDO724O', 'profile_677bdc58e60c3.jpg', '2025-01-06 13:04:46'),
(14, 'Clement Wen Kai', 'kai zen', 'kaizen', 'kaizen@gamal.com', '$2y$10$dz8wQ.MEkk5zzp.u6EBNGOhqClZRR4/FnMVDuQXWjSt9GrCggwEFK', NULL, '2025-01-07 10:26:26'),
(15, 'feresa', 'abc', 'feresa', 'kaizen20020222@gmail.com', '$2y$10$x.5TzbmychZ68LbSeLbZ/OFeLhTdAAu05KD0HTg4yoDdSYVRHi1ye', 'profile_677d1d64008f9.jpg', '2025-01-07 12:21:37'),
(16, 'test3', 'test3', 'test3', 'clementfoong@aiesec.net', '$2y$10$tSABc/5/.rRR0cJEA0PL3uh32L2FjIRBT4FTrJYzmgyYDDQWos35S', NULL, '2025-01-07 13:32:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_discussion_id` (`discussion_id`),
  ADD KEY `fk_comment_user_id` (`user_id`);

--
-- Indexes for table `discussions`
--
ALTER TABLE `discussions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_user_id` (`user_id`);

--
-- Indexes for table `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`friend_id`),
  ADD KEY `friend_id` (`friend_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `receiver_id` (`receiver_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post_likes`
--
ALTER TABLE `post_likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`,`post_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `discussions`
--
ALTER TABLE `discussions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `post_likes`
--
ALTER TABLE `post_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `fk_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_discussion_id` FOREIGN KEY (`discussion_id`) REFERENCES `discussions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `discussions`
--
ALTER TABLE `discussions`
  ADD CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `friends`
--
ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
