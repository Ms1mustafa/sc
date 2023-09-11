-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 11 سبتمبر 2023 الساعة 21:15
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
-- Database: `sca`
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
(4, '3', 'Clinker'),
(6, '4', 'open yared');

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
(8, '1', '1', 'line 1'),
(9, '2', '1', 'line 2'),
(10, '3', '1', 'line 3'),
(11, '4', '4', 'mian stor');

-- --------------------------------------------------------

--
-- بنية الجدول `itemdes`
--

CREATE TABLE `itemdes` (
  `id` int(11) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `itemdes`
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
-- بنية الجدول `rejectitemdes`
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

--
-- إرجاع أو استيراد بيانات الجدول `rejectitemdes`
--

INSERT INTO `rejectitemdes` (`id`, `workOrderNo`, `itemName`, `itemQty`, `wereHouseQty`, `wereHouseComment`, `rejectsNum`, `qtyBack`, `rejectDate`) VALUES
(96, '123456745', 'Pipe scaffolding3m', '5', '5', '', 0, '5', '2023-09-01 13:36:49'),
(97, '123456745', 'Pipe scaffolding Under 1M', '5', '5', '', 0, '5', '2023-09-01 13:36:49'),
(98, '123456745', 'Woode borders 4m', '5', '5', '', 0, '5', '2023-09-01 13:36:49'),
(99, '123456745 ', 'Pipe scaffolding Under 1M', '6', '6', '', 1, '5', '2023-09-01 13:40:32'),
(100, '123456745 ', 'Woode borders 3m', '6', '6', '', 1, '5', '2023-09-01 13:40:32'),
(101, '5555566', 'Woode borders 3m', '4', '4', '', 0, '', '2023-09-01 13:56:12'),
(102, '5555566', 'Movable clamp', '4', '4', '', 0, '', '2023-09-01 13:56:12'),
(103, '4545677', 'Woode borders 4m', '', '6', '', 0, '', '2023-09-01 16:19:08'),
(104, '4545677 ', 'Woode borders 3m', '', '', '', 1, '', '2023-09-01 16:20:28'),
(105, '222243444', 'Woode borders 3m', '5', '5', '', 0, '', '2023-09-01 18:00:06'),
(106, '222243444 ', 'Pipe scaffolding 1m', '5', '5', '', 1, '', '2023-09-01 18:01:21'),
(107, '222243444 ', 'Woode borders 3m', '5', '5', '', 1, '', '2023-09-01 18:01:21'),
(108, '556789976', 'Woode borders 3m', '4', '4', '', 0, '', '2023-09-01 18:10:42'),
(109, '556789976 ', 'Woode borders 2m', '5', '', '', 1, '', '2023-09-01 18:13:28'),
(110, '556789976 ', 'Woode borders 1m', '5', '', '', 1, '', '2023-09-01 18:13:28'),
(111, '786999', 'Woode borders 2m', '4', '4', '', 0, '', '2023-09-01 18:31:24'),
(112, '786999 ', 'Woode borders 3m', '5', '', '', 1, '', '2023-09-01 18:43:55'),
(113, '5655', 'Woode borders 3m', '4', '6', '', 0, '', '2023-09-01 23:18:11'),
(114, '5655 ', 'Woode borders 2m', '', '', '', 1, '', '2023-09-01 23:23:02'),
(115, '67578977', 'Woode borders Under 1M', '4', '', '', 0, '', '2023-09-06 22:16:24');

-- --------------------------------------------------------

--
-- بنية الجدول `request`
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
-- إرجاع أو استيراد بيانات الجدول `request`
--

INSERT INTO `request` (`id`, `reqNo`, `adminAddedName`, `workOrderNo`, `area`, `item`, `length`, `width`, `height`, `workType`, `priority`, `executer`, `wereHouse`, `inspector`, `notes`, `reqDate`, `executerNew`, `executerDate`, `status`, `rejectReason`, `rejectsNum`, `new`, `finishDate`, `issued`, `wereHouseDate`, `executerAccept`, `executerAcceptDate`, `inspectorDate`, `resentDate`, `qtyBackStatus`, `qtyBackDate`) VALUES
(40, '202300001', 'Requester', '67578977', 'Packing', 'line 1', '5', '5', '5', '1 - Incident', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', '5555', '2023-09-06 22:15:18.000000', 'no', '2023-09-06 22:16:24.000000', 'pending', '', 0, 'no', '2023-09-16', 'no', NULL, 'no', NULL, NULL, NULL, 'no', NULL);

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
  `requestNum` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `main` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `token`, `username`, `email`, `password`, `area`, `type`, `requestNum`, `main`) VALUES
(25, '230821114033162', 'Requester', 'Requester@gmail.com', 'R12341234', '', 'admin', '202300001', 'yes'),
(26, '230821114122103', 'Warehouse', 'Warehouse@gmail.com', 'W12341234', '', 'wereHouse', '', 'yes'),
(27, '230821114149170', 'Excauter', 'Excauter@gmail.come', 'E12341234', '', 'execution', '', 'yes'),
(28, '230821114217156', 'Inspector', 'Inspector@gmail.com', 'I12341234', '1', 'inspector', '', 'yes'),
(29, '230821114247185', 'Manager', 'Manager@gmail.com', 'M12341234', '', 'owner', '', 'yes'),
(30, '230910110411191', 'supervisor', 'supervisor@gmail.com', 's12341234', '', 'supervisor', '', 'no');

-- --------------------------------------------------------

--
-- بنية الجدول `werehouseback`
--

CREATE TABLE `werehouseback` (
  `id` int(11) NOT NULL,
  `workOrderNo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `itemName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wereHouseComment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qtyBack` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `werehouseback`
--
ALTER TABLE `werehouseback`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `areaitems`
--
ALTER TABLE `areaitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `itemdes`
--
ALTER TABLE `itemdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rejectitemdes`
--
ALTER TABLE `rejectitemdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `werehouseback`
--
ALTER TABLE `werehouseback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `worktype`
--
ALTER TABLE `worktype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
