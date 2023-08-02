-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 26 يوليو 2023 الساعة 20:28
-- إصدار الخادم: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sc`
--

-- --------------------------------------------------------

--
-- بنية الجدول `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `area`
--

INSERT INTO `area` (`id`, `number`, `name`) VALUES
(1, '1', 'Packing'),
(3, '2', 'WareHouse'),
(4, '3', 'Clinker');

-- --------------------------------------------------------

--
-- بنية الجدول `areaitems`
--

CREATE TABLE `areaitems` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `areaId` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `areaitems`
--

INSERT INTO `areaitems` (`id`, `number`, `areaId`, `name`) VALUES
(1, '1', '1', 'item1'),
(2, '2', '1', 'item2');

-- --------------------------------------------------------

--
-- بنية الجدول `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `reqNo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `workOrderNo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `area` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `item` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `length` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `width` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `height` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `workType` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `priority` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `executer` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `inspector` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `notes` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `reqDate` datetime NOT NULL DEFAULT current_timestamp(),
  `pipeQty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `clampQty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `woodQty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `executerDate` datetime DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rejectReason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `new` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes',
  `finishDate` date NOT NULL,
  `pipeQtyStore` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pipeQtyStoreComment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `clampQtyStore` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `clampQtyStoreComment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `woodQtyStore` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `woodQtyStoreComment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `issued` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no',
  `wereHouseDate` datetime DEFAULT NULL,
  `executerAccept` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no',
  `executerAcceptDate` datetime DEFAULT NULL,
  `inspectorDate` datetime DEFAULT NULL,
  `resentDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `request`
--

INSERT INTO `request` (`id`, `reqNo`, `name`, `workOrderNo`, `area`, `item`, `length`, `width`, `height`, `qty`, `workType`, `priority`, `executer`, `inspector`, `notes`, `reqDate`, `pipeQty`, `clampQty`, `woodQty`, `executerDate`, `status`, `rejectReason`, `new`, `finishDate`, `pipeQtyStore`, `pipeQtyStoreComment`, `clampQtyStore`, `clampQtyStoreComment`, `woodQtyStore`, `woodQtyStoreComment`, `issued`, `wereHouseDate`, `executerAccept`, `executerAcceptDate`, `inspectorDate`, `resentDate`) VALUES
(32, '202300001', 'Basim Kareem', '65795576922', 'Packing', 'item1', '56', '34', '45', '', '1', 'High 2-3 Days', 'Luay Saad', 'Mohammed', 'Notes', '2023-07-26 21:07:14', '4', '24', '4', '2023-07-26 21:08:34', 'accepted', '', 'no', '2023-02-02', '4', '', '24', '', '4', '', 'yes', '2023-07-26 21:10:44', 'yes', '2023-07-26 21:12:16', '2023-07-26 21:23:08', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `area` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `requestNum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `token`, `username`, `email`, `password`, `area`, `type`, `requestNum`) VALUES
(8, '230716020913142', 'Bilal', 'bilal@gmail.com', '123456789', '', 'owner', ''),
(11, '230720030605170', 'Ali', 'ali@gmail.com', '123456789', '', 'WereHouse', ''),
(12, '230720031937132', 'Mohammed', 'mohammed@gmail.com', '123456789', '', 'inspector', ''),
(13, '230726082019105', 'Basim Kareem', 'BasimKareem@gmail.com', '123456789', '', 'admin', '202300001'),
(14, '230726083758160', 'Luay Saad', 'LuaySaad@gmail.com', '123456789', '', 'Execution', '');

-- --------------------------------------------------------

--
-- بنية الجدول `worktype`
--

CREATE TABLE `worktype` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `worktype`
--

INSERT INTO `worktype` (`id`, `number`, `name`) VALUES
(1, '1', 'Incident'),
(2, '2', 'Routine'),
(3, '3', 'PM'),
(4, '4', 'SD');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `areaitems`
--
ALTER TABLE `areaitems`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worktype`
--
ALTER TABLE `worktype`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `area`
--
ALTER TABLE `area`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `areaitems`
--
ALTER TABLE `areaitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `worktype`
--
ALTER TABLE `worktype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
