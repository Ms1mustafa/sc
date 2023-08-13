-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2023 at 12:19 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sca`
--

-- --------------------------------------------------------

--
-- Table structure for table `area`
--

CREATE TABLE `area` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `area`
--

INSERT INTO `area` (`id`, `number`, `name`) VALUES
(1, '1', 'Packing'),
(3, '2', 'WareHouse'),
(4, '3', 'Clinker');

-- --------------------------------------------------------

--
-- Table structure for table `areaitems`
--

CREATE TABLE `areaitems` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `areaId` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `areaitems`
--

INSERT INTO `areaitems` (`id`, `number`, `areaId`, `name`) VALUES
(1, '1', '1', 'item1'),
(2, '2', '1', 'item2'),
(6, '3', '2', 'item3');

-- --------------------------------------------------------

--
-- Table structure for table `itemdes`
--

CREATE TABLE `itemdes` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itemdes`
--

INSERT INTO `itemdes` (`id`, `number`, `name`) VALUES
(1, '1', 'Pipe scaffolding 6m'),
(2, '2', 'Pipe scaffolding 5m'),
(3, '3', 'Pipe scaffolding 4M'),
(4, '4', 'Pipe scaffolding3m'),
(5, '5', 'Pipe scaffolding 2m'),
(6, '6', 'Pipe scaffolding 1m'),
(7, '7', 'Pipe scaffolding Under 1M'),
(8, '8', 'Woode borders 6m'),
(9, '9', 'Woode borders 5m'),
(10, '10', 'Woode borders 4m'),
(11, '11', 'Woode borders 3m'),
(12, '12', 'Woode borders 2m'),
(13, '13', 'Woode borders 1m'),
(14, '14', 'Woode borders Under 1M'),
(15, '15', 'Movable clamp'),
(16, '16', 'Fixed clamp');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id` int(11) NOT NULL,
  `reqNo` varchar(255) NOT NULL,
  `adminAddedName` varchar(255) NOT NULL,
  `workOrderNo` varchar(255) NOT NULL,
  `area` varchar(255) NOT NULL,
  `item` varchar(255) NOT NULL,
  `length` varchar(255) NOT NULL,
  `width` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `workType` varchar(255) NOT NULL,
  `priority` varchar(255) NOT NULL,
  `executer` varchar(255) NOT NULL,
  `wereHouse` varchar(255) NOT NULL,
  `inspector` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `reqDate` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `executerDate` datetime(6) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `rejectReason` varchar(255) NOT NULL,
  `new` varchar(255) NOT NULL DEFAULT 'yes',
  `finishDate` datetime(6) DEFAULT NULL,
  `issued` varchar(255) NOT NULL DEFAULT 'no',
  `wereHouseDate` datetime(6) DEFAULT NULL,
  `executerAccept` varchar(6) NOT NULL DEFAULT 'no',
  `executerAcceptDate` datetime(6) DEFAULT NULL,
  `inspectorDate` datetime(6) DEFAULT NULL,
  `resentDate` datetime(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `reqNo`, `adminAddedName`, `workOrderNo`, `area`, `item`, `length`, `width`, `height`, `workType`, `priority`, `executer`, `wereHouse`, `inspector`, `notes`, `reqDate`, `executerDate`, `status`, `rejectReason`, `new`, `finishDate`, `issued`, `wereHouseDate`, `executerAccept`, `executerAcceptDate`, `inspectorDate`, `resentDate`) VALUES
(3, '202300001', 'Basim Kareem', '547457568', 'Packing', 'item1', '6', '3', '8', '2 - Routine', 'Medium 3-4 Days', 'Luay Saad', 'Ali', 'Mohammed', 'te', '2023-08-12 19:21:45.875260', '2023-08-13 01:42:09.000000', 'pending', '', 'no', '2023-08-15 00:00:00.000000', 'no', NULL, 'no', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `requestitemdes`
--

CREATE TABLE `requestitemdes` (
  `id` int(11) NOT NULL,
  `workOrderNo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `itemName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `itemQty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wereHouseQty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wereHouseComment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `editedItemQty` varchar(255) NOT NULL,
  `qtyBack` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requestitemdes`
--

INSERT INTO `requestitemdes` (`id`, `workOrderNo`, `itemName`, `itemQty`, `wereHouseQty`, `wereHouseComment`, `editedItemQty`, `qtyBack`) VALUES
(20, '54745756', 'Pipe scaffolding3m', '6', '', '', '', ''),
(21, '54745756', 'Woode borders 2m', '3', '', '', '', ''),
(22, '547457568', 'Woode borders 5m', '5', '', '', '', ''),
(23, '547457568', 'Woode borders 3m', '8', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `token` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `area` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `requestNum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `main` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `token`, `username`, `email`, `password`, `area`, `type`, `requestNum`, `main`) VALUES
(8, '230716020913142', 'Bilal', 'bilal@gmail.com', '123456789', '', 'owner', '', 'no'),
(11, '230720030605170', 'Ali', 'ali@gmail.com', '123456789', '', 'wereHouse', '', 'yes'),
(12, '230720031937132', 'Mohammed', 'mohammed@gmail.com', '123456789', '1', 'inspector', '', 'no'),
(13, '230726082019105', 'Basim Kareem', 'BasimKareem@gmail.com', '123456789', '', 'admin', '202300001', 'yes'),
(14, '230726083758160', 'Luay Saad', 'LuaySaad@gmail.com', '123456789', '', 'execution', '', 'yes'),
(17, '230811011230189', 'wereHouse2', 'weho2@gmail.com', '123456789', '', 'wereHouse', '', 'no'),
(18, '230811044540104', 'Mustafa', 'mustafa@gmail.com', '123456789', '', 'execution', '', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `worktype`
--

CREATE TABLE `worktype` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `worktype`
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
-- Indexes for table `itemdes`
--
ALTER TABLE `itemdes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `requestitemdes`
--
ALTER TABLE `requestitemdes`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `itemdes`
--
ALTER TABLE `itemdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `requestitemdes`
--
ALTER TABLE `requestitemdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `worktype`
--
ALTER TABLE `worktype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
