-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2023 at 12:32 PM
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
-- Table structure for table `rejectitemdes`
--

CREATE TABLE `rejectitemdes` (
  `id` int(11) NOT NULL,
  `workOrderNo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `itemName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `itemQty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wereHouseQty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wereHouseComment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rejectsNum` int(10) NOT NULL,
  `qtyBack` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `rejectDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `executerNew` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes',
  `executerDate` datetime(6) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `rejectReason` varchar(255) NOT NULL,
  `rejectsNum` int(255) NOT NULL DEFAULT 0,
  `new` varchar(255) NOT NULL DEFAULT 'yes',
  `finishDate` date DEFAULT NULL,
  `issued` varchar(255) NOT NULL DEFAULT 'no',
  `wereHouseDate` datetime(6) DEFAULT NULL,
  `executerAccept` varchar(6) NOT NULL DEFAULT 'no',
  `executerAcceptDate` datetime(6) DEFAULT NULL,
  `inspectorDate` datetime(6) DEFAULT NULL,
  `resentDate` datetime(6) DEFAULT NULL,
  `qtyBackStatus` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no',
  `qtyBackDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id`, `reqNo`, `adminAddedName`, `workOrderNo`, `area`, `item`, `length`, `width`, `height`, `workType`, `priority`, `executer`, `wereHouse`, `inspector`, `notes`, `reqDate`, `executerNew`, `executerDate`, `status`, `rejectReason`, `rejectsNum`, `new`, `finishDate`, `issued`, `wereHouseDate`, `executerAccept`, `executerAcceptDate`, `inspectorDate`, `resentDate`, `qtyBackStatus`, `qtyBackDate`) VALUES
(12, '202300001', 'Basim Kareem', '6574443745754', 'Packing', 'item2', '56', '6', '3', '4 - SD', 'Medium 3-4 Days', 'Luay Saad', 'Ali', 'Mohammed', '543', '2023-08-19 01:24:30.740422', 'no', '2023-08-19 01:25:39.000000', 'accepted', '', 0, 'no', '2023-08-20', 'yes', '2023-08-19 01:25:51.000000', 'yes', '2023-08-19 01:25:57.000000', '2023-08-19 01:26:25.000000', NULL, 'wereHouse', '2023-08-19 01:53:25'),
(13, '202300001', 'Basim Kareem', '654573333', 'Packing', 'item2', '6', '9', '5', '2 - Routine', 'Medium 3-4 Days', 'Luay Saad', 'Ali', 'Mohammed', 'بثي', '2023-08-19 01:40:42.731992', 'yes', '2023-08-19 01:41:15.000000', 'rejected', 'فقث', 1, 'no', '2023-08-20', 'yes', '2023-08-19 01:41:46.000000', 'yes', '2023-08-19 01:42:04.000000', '2023-08-19 01:42:30.000000', NULL, 'no', NULL);

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
  `editedWereHouseQty` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `editedWereHouseComment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qtyBack` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requestitemdes`
--

INSERT INTO `requestitemdes` (`id`, `workOrderNo`, `itemName`, `itemQty`, `wereHouseQty`, `wereHouseComment`, `editedItemQty`, `editedWereHouseQty`, `editedWereHouseComment`, `qtyBack`) VALUES
(48, '6574443745754', 'Pipe scaffolding 6m', '11', '11', '  ', '', '', '', ''),
(49, '6574443745754', 'Woode borders 5m', '22', '22', '  ', '', '', '', ''),
(50, '6574443745754', 'Woode borders Under 1M', '33', '33', '  ', '', '', '', ''),
(51, '654573333', 'Fixed clamp', '6', '6', '  ', '', '', '', ''),
(52, '654573333', 'Woode borders 4m', '4', '4', '  ', '', '', '', ''),
(53, '654573333', 'Pipe scaffolding 4M', '9', '9', '  ', '', '', '', '');

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
(18, '230811044540104', 'Mustafa', 'mustafa@gmail.com', '123456789', '', 'execution', '', 'no'),
(19, '230817124849135', 'exe3', 'exe3@gmail.com', '123456789', '', 'execution', '', 'no');

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
-- Indexes for table `rejectitemdes`
--
ALTER TABLE `rejectitemdes`
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
-- AUTO_INCREMENT for table `rejectitemdes`
--
ALTER TABLE `rejectitemdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `requestitemdes`
--
ALTER TABLE `requestitemdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `worktype`
--
ALTER TABLE `worktype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
