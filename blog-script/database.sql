-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql210.pakistandeal.cf
-- Generation Time: Oct 20, 2023 at 01:23 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog-script`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`) VALUES
(1, 'site_admin', '$2y$10$Dpk.fqu/RV6.w5tg6YxSb.1F70lSu7lAYdO/pagJBA.9OPMQSAPuK', 'adminemail@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(11) NOT NULL,
  `ads1` text DEFAULT NULL,
  `ads2` text DEFAULT NULL,
  `ads3` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `design`
--

CREATE TABLE `design` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `ads_code` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `design`
--

INSERT INTO `design` (`id`, `logo`, `favicon`, `ads_code`) VALUES
(1, '../uploads/logo.png', '../uploads/favicon.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `message` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`) VALUES
(1, 'test user', 'example@gmail.com', 'geeeeeee');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `featured_image` varchar(255) DEFAULT NULL,
  `slug` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `content`, `created_at`, `featured_image`, `slug`) VALUES
(2, 1, 'à¤‘à¤¨à¤²à¤¾à¤‡à¤¨ à¤§à¥‹à¤–à¤¾à¤§à¤¡à¤¼à¥€ à¤¸à¥‡ à¤¬à¤šà¤¨à¥‡ à¤•à¥‡ à¤²à¤¿à¤', 'à¤‘à¤¨à¤²à¤¾à¤‡à¤¨ à¤§à¥‹à¤–à¤¾à¤§à¤¡à¤¼à¥€ à¤¸à¥‡ à¤¬à¤šà¤¨à¥‡ à¤•à¥‡ à¤²à¤¿à¤ à¤¨à¤¿à¤®à¥à¤¨à¤²à¤¿à¤–à¤¿à¤¤ à¤¬à¤¾à¤¤à¥‹à¤‚ à¤•à¤¾ à¤§à¥à¤¯à¤¾à¤¨ à¤°à¤–à¥‡à¤‚:\r\n\r\nà¤§à¥‹à¤–à¤¾à¤§à¤¡à¤¼à¥€ à¤µà¤¾à¤²à¥€ à¤µà¥‡à¤¬à¤¸à¤¾à¤‡à¤Ÿà¥à¤¸ à¤¸à¥‡ à¤¸à¤¾à¤µà¤§à¤¾à¤¨ à¤°à¤¹à¥‡à¤‚ - à¤•à¤ˆ à¤µà¥‡à¤¬à¤¸à¤¾à¤‡à¤Ÿà¥à¤¸ à¤†à¤•à¤°à¥à¤·à¤• à¤‘à¤«à¤° à¤¦à¤¿à¤–à¤¾à¤•à¤° à¤²à¥‹à¤—à¥‹à¤‚ à¤•à¥‹ à¤§à¥‹à¤–à¤¾ à¤¦à¥‡à¤¤à¥€ à¤¹à¥ˆà¤‚à¥¤ à¤…à¤—à¤° à¤•à¥‹à¤ˆ à¤‘à¤«à¤° à¤¬à¤¹à¥à¤¤ à¤…à¤šà¥à¤›à¤¾ à¤²à¤—à¥‡ à¤¤à¥‹ à¤‰à¤¸ à¤µà¥‡à¤¬à¤¸à¤¾à¤‡à¤Ÿ à¤•à¥€ à¤ªà¥ƒà¤·à¥à¤ à¤­à¥‚à¤®à¤¿ à¤œà¤¾à¤à¤š à¤²à¥‡à¤‚à¥¤ \r\n\r\nà¤•à¤¿à¤¸à¥€ à¤…à¤¨à¤œà¤¾à¤¨ à¤µà¥à¤¯à¤•à¥à¤¤à¤¿ à¤•à¥€ à¤«à¥à¤°à¥€ à¤šà¥€à¤œà¤¼ à¤¸à¥à¤µà¥€à¤•à¤¾à¤° à¤¨ à¤•à¤°à¥‡à¤‚ - à¤•à¤ˆ à¤¬à¤¾à¤° à¤²à¥‹à¤— à¤«à¥à¤°à¥€ à¤®à¥‡à¤‚ à¤†à¤•à¤°à¥à¤·à¤• à¤‰à¤ªà¤¹à¤¾à¤° à¤¯à¤¾ à¤•à¥‚à¤ªà¤¨ à¤­à¥‡à¤œà¤•à¤° à¤†à¤ªà¤•à¤¾ à¤ªà¥à¤°à¤¾à¤‡à¤µà¥‡à¤Ÿ à¤¡à¥‡à¤Ÿà¤¾ à¤šà¥à¤°à¤¾à¤¨à¥‡ à¤•à¥€ à¤•à¥‹à¤¶à¤¿à¤¶ à¤•à¤°à¤¤à¥‡ à¤¹à¥ˆà¤‚à¥¤\r\n\r\nà¤¸à¤‚à¤¦à¤¿à¤—à¥à¤§ à¤ˆà¤®à¥‡à¤² à¤¯à¤¾ à¤²à¤¿à¤‚à¤•à¥à¤¸ à¤ªà¤° à¤•à¥à¤²à¤¿à¤• à¤¨ à¤•à¤°à¥‡à¤‚ - à¤…à¤—à¤° à¤†à¤ªà¤•à¥‹ à¤•à¥‹à¤ˆ à¤…à¤¨à¤œà¤¾à¤¨ à¤ˆà¤®à¥‡à¤² à¤®à¤¿à¤²à¤¤à¤¾ à¤¹à¥ˆ à¤œà¤¿à¤¸à¤®à¥‡à¤‚ à¤†à¤•à¤°à¥à¤·à¤• à¤²à¤¿à¤‚à¤• à¤¯à¤¾ à¤‘à¤«à¤° à¤¹à¥‹ à¤¤à¥‹ à¤‰à¤¸ à¤ªà¤° à¤•à¥à¤²à¤¿à¤• à¤¨ à¤•à¤°à¥‡à¤‚à¥¤\r\n\r\nà¤¸à¤¾à¤°à¥à¤µà¤œà¤¨à¤¿à¤• à¤µà¤¾à¤ˆ-à¤«à¤¼à¤¾à¤ˆ à¤¨à¥‡à¤Ÿà¤µà¤°à¥à¤• à¤ªà¤° à¤¸à¤¾à¤µà¤§à¤¾à¤¨à¥€ à¤¸à¥‡ à¤•à¤¾à¤® à¤•à¤°à¥‡à¤‚ - à¤¸à¤¾à¤°à¥à¤µà¤œà¤¨à¤¿à¤• à¤µà¤¾à¤ˆ-à¤«à¤¼à¤¾à¤ˆ à¤ªà¤° à¤•à¤¿à¤¸à¥€ à¤­à¥€ à¤¨à¤¿à¤œà¥€ à¤œà¤¾à¤¨à¤•à¤¾à¤°à¥€ à¤•à¥‹ à¤¶à¥‡à¤¯à¤° à¤¨ à¤•à¤°à¥‡à¤‚à¥¤\r\n\r\nà¤‘à¤¨à¤²à¤¾à¤‡à¤¨ à¤­à¥à¤—à¤¤à¤¾à¤¨ à¤•à¤°à¤¤à¥‡ à¤¸à¤®à¤¯ à¤¸à¥à¤°à¤•à¥à¤·à¤¿à¤¤ à¤µà¥‡à¤¬à¤¸à¤¾à¤‡à¤Ÿ à¤”à¤° à¤•à¤¨à¥‡à¤•à¥à¤¶à¤¨ à¤•à¤¾ à¤‰à¤ªà¤¯à¥‹à¤— à¤•à¤°à¥‡à¤‚à¥¤\r\n\r\nà¤…à¤ªà¤¨à¥‡ à¤•à¤‚à¤ªà¥à¤¯à¥‚à¤Ÿà¤° à¤”à¤° à¤®à¥‹à¤¬à¤¾à¤‡à¤² à¤•à¥‹ à¤¹à¤®à¥‡à¤¶à¤¾ à¤…à¤ªà¤¡à¥‡à¤Ÿ à¤°à¤–à¥‡à¤‚ à¤¤à¤¾à¤•à¤¿ à¤¸à¥à¤°à¤•à¥à¤·à¤¾ à¤‰à¤¨à¥à¤¨à¤¤ à¤°à¤¹à¥‡à¥¤\r\n\r\nà¤‘à¤¨à¤²à¤¾à¤‡à¤¨ à¤ à¤—à¥€ à¤¸à¥‡ à¤¬à¤šà¤¨à¥‡ à¤•à¥‡ à¤²à¤¿à¤ à¤¸à¤šà¥‡à¤¤ à¤°à¤¹à¤¨à¤¾ à¤¬à¤¹à¥à¤¤ à¤œà¤°à¥‚à¤°à¥€ à¤¹à¥ˆà¥¤ à¤•à¤¿à¤¸à¥€ à¤­à¥€ à¤¸à¤‚à¤¦à¤¿à¤—à¥à¤§ à¤—à¤¤à¤¿à¤µà¤¿à¤§à¤¿ à¤ªà¤° à¤¤à¥à¤°à¤‚à¤¤ à¤•à¤¾à¤°à¥à¤°à¤µà¤¾à¤ˆ à¤•à¤°à¥‡à¤‚ à¤”à¤° à¤ªà¥à¤²à¤¿à¤¸ à¤•à¥‹ à¤¸à¥‚à¤šà¤¿à¤¤ à¤•à¤°à¥‡à¤‚à¥¤ à¤œà¤¾à¤—à¤°à¥‚à¤• à¤°à¤¹à¤•à¤° à¤¹à¥€ à¤¹à¤® à¤‘à¤¨à¤²à¤¾à¤‡à¤¨ à¤§à¥‹à¤–à¤¾à¤§à¤¡à¤¼à¥€ à¤•à¥‡ à¤¶à¤¿à¤•à¤¾à¤° à¤¹à¥‹à¤¨à¥‡ à¤¸à¥‡ à¤¬à¤š à¤¸à¤•à¤¤à¥‡ à¤¹à¥ˆà¤‚à¥¤', '2023-09-18 04:05:34', 'media/à¤‘à¤¨à¤²à¤¾à¤‡à¤¨-à¤§à¥‹à¤–à¤¾à¤§à¤¡à¤¼à¥€-à¤¸à¥‡-à¤•à¥ˆà¤¸à¥‡-à¤¬à¤šà¥‡.jpg', 'n-a'),
(3, 1, 'Keep Your Facebook Account Private and Secure', 'Facebook has become an integral part of our lives. We use it to stay connected with friends and family. However, we also share a lot of personal information on Facebook that can make our account vulnerable.\r\n\r\n[Photo of someone using Facebook on a smartphone]\r\n\r\nThat\'s why it\'s important to use Facebook\'s privacy settings to control who sees what you share. Here are some tips to make your Facebook account more private and secure:\r\n\r\nReview Privacy Settings\r\nGo to \"Settings\" and then \"Privacy.\" Limit the audience for posts, profile info, contacts etc. Make them visible to friends only.\r\n\r\n[Photo of Facebook privacy settings page]\r\n\r\nAccept Friend Requests Selectively\r\nDon\'t accept requests from strangers. Review friends lists and remove any unwanted connections.\r\n\r\n[Photo of rejecting a friend request on Facebook]\r\n\r\nLimit Personal Info Sharing\r\nAvoid sharing your address, phone number or birthday publicly on your profile.\r\n\r\nTurn Off Location Services\r\nDisable location services so your location is not shared automatically in posts.\r\n\r\nCreate Strong Password\r\nUse a complex, unique password that is hard to guess. Update it every few months.\r\n\r\n[Photo of Facebook password field]\r\n\r\nEnable Login Notifications\r\nGet alerts about unrecognized logins to monitor suspicious activity.\r\n\r\n[Photo of Facebook notifications settings]\r\n\r\nBe Wary of Third-Party Apps\r\nLimit apps connected to your account. Remove unused apps.\r\n\r\nUse Security Tools\r\nEnable two-factor authentication. Use Facebook\'s privacy checkup tool.\r\n\r\nBy following these tips, you can keep your Facebook account much more private and secure from unwanted access. Be proactive about your privacy settings and review them regularly.', '2023-09-18 04:42:21', 'media/bd4720ee1bbb978874cd7497a516926b.jpg', 'keep-your-facebook-account-private-and-secure');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `website_name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `keywords` text NOT NULL,
  `newsapi_key` varchar(100) NOT NULL,
  `youtube_api_key` varchar(100) NOT NULL,
  `google_search_api_key` varchar(100) NOT NULL,
  `onesignal_app_id` varchar(100) NOT NULL,
  `onesignal_app_secret` varchar(100) NOT NULL,
  `recaptcha` enum('0','1') NOT NULL DEFAULT '0',
  `recaptcha_site_key` varchar(110) NOT NULL,
  `recaptcha_secret_key` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `website_name`, `description`, `keywords`, `newsapi_key`, `youtube_api_key`, `google_search_api_key`, `onesignal_app_id`, `onesignal_app_secret`, `recaptcha`, `recaptcha_site_key`, `recaptcha_secret_key`) VALUES
(1, 'Blog website', 'Website developer and Computer Mobile tricks', 'Website developer, wordpress,php,blogger', '', '', '', '', '', '0', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `age` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT 'default_avatar.png',
  `cover_picture` varchar(255) DEFAULT 'default_cover.jpg',
  `subscribe` enum('yes','no') NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `ip_address`, `location`, `browser`, `gender`, `bio`, `age`, `profile_picture`, `cover_picture`, `subscribe`) VALUES
(1, 'testuser', 'test@email.com', '$2y$10$7a9Tih18YMRuZQTaJyxHWOTiV3gp53poBFdPIF.WRkftWFvNl/fQW', '49.36.235.50', 'Jaipur, Rajasthan, India', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/118.0.0.0 Safari/537.36', 'male', 'im test user', '25', '13621_56493.png', 'default_cover.jpg', 'no');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `design`
--
ALTER TABLE `design`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `design`
--
ALTER TABLE `design`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
