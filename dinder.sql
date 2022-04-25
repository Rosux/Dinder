-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2022 at 09:31 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dinder`
--

-- --------------------------------------------------------

--
-- Table structure for table `dogs`
--

CREATE TABLE `dogs` (
  `dogname` varchar(255) NOT NULL,
  `dog_birth_year` date NOT NULL DEFAULT current_timestamp(),
  `dog_race` varchar(255) NOT NULL,
  `dog_pic_dir` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `dog_description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `dogs`
--

INSERT INTO `dogs` (`dogname`, `dog_birth_year`, `dog_race`, `dog_pic_dir`, `user_id`, `id`, `dog_description`) VALUES
('doggo', '2018-04-03', 'Labradoedel', '../UserImages/79/5af9f75fe325d3bc.jpg', 79, 14, 'Rent veel en houd van andere grote honden'),
('human621243', '0666-06-06', 'human', '../UserImages/79/39a17a881975ceac.jpg', 79, 15, 'Likes doing human stuff');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image_id` int(11) NOT NULL,
  `image_dir` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image_id`, `image_dir`, `created`) VALUES
(50, 79, '../UserImages/79/2a8bcf831c717796.jpg', '2022-04-14 21:19:11'),
(51, 79, '../UserImages/79/85183e516b80960e.png', '2022-04-14 21:19:16'),
(52, 79, '../UserImages/79/4635479da8cda2ff.png', '2022-04-14 21:19:20'),
(53, 79, '../UserImages/79/d74fefc6977a6ffe.jpg', '2022-04-14 21:19:27'),
(54, 79, '../UserImages/79/61fba7350629b845.jpg', '2022-04-14 21:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `accepted` tinyint(1) NOT NULL DEFAULT 0,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `PrimeStatus` tinyint(1) NOT NULL DEFAULT 0,
  `profile_pic_dir` varchar(255) NOT NULL DEFAULT '../images/Profile_Icon.png',
  `banner_pic_dir` varchar(255) NOT NULL DEFAULT '../images/section1dog.png',
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `active` int(1) DEFAULT 0,
  `activation_code` varchar(255) DEFAULT NULL,
  `activation_expiry` datetime DEFAULT NULL,
  `activated_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp(),
  `login_token` varchar(255) DEFAULT NULL,
  `email_reset_token` varchar(255) DEFAULT NULL,
  `email_reset_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Username`, `Description`, `Email`, `Password`, `PrimeStatus`, `profile_pic_dir`, `banner_pic_dir`, `is_admin`, `active`, `activation_code`, `activation_expiry`, `activated_at`, `created_at`, `updated_at`, `login_token`, `email_reset_token`, `email_reset_expiry`) VALUES
(79, 'mborijnland', 'Hey ik houd van wandelen jij ook?', 'mborijnland@rijnland.nl', '$2y$10$.tDKSHljlBCuIVxPLSi17uCVjRm62MRLX6W3AEI5wzQemFxT4jHIu', 0, '../UserImages/79/2dc6eeb614cf79a9.jpg', '../UserImages/79/8370ac6fda8ed4bd.jpg', 0, 1, NULL, NULL, '2022-04-14 21:18:21', '2022-04-14 19:18:09', '2022-04-14 21:18:21', '$2y$10$BssHZNV5kcVA5pmhyFiiM.cjh/oWd9aey/z4OBZ2Ct2Ad5air06wG', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dogs`
--
ALTER TABLE `dogs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
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
-- AUTO_INCREMENT for table `dogs`
--
ALTER TABLE `dogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
