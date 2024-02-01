-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2024 at 10:12 PM
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
-- Table structure for table `archive_req`
--

CREATE TABLE `archive_req` (
  `id` int(11) NOT NULL DEFAULT 0,
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
  `discription` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `notes` varchar(255) NOT NULL,
  `reqDate` datetime(6) NOT NULL,
  `executerNew` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes',
  `executerDate` datetime(6) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `rejectReason` varchar(255) NOT NULL,
  `rejectsNum` int(255) NOT NULL DEFAULT 0,
  `new` varchar(255) NOT NULL DEFAULT 'yes',
  `finishDate` date DEFAULT NULL,
  `issued` varchar(255) NOT NULL DEFAULT 'no',
  `resend_note` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pending_in` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type_req` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pending_date` datetime(6) NOT NULL DEFAULT current_timestamp(6),
  `wereHouseDate` datetime(6) DEFAULT NULL,
  `executerAccept` varchar(6) NOT NULL DEFAULT 'no',
  `executerAcceptDate` datetime(6) DEFAULT NULL,
  `inspectorDate` datetime(6) DEFAULT NULL,
  `resentDate` datetime(6) DEFAULT NULL,
  `qtyBackStatus` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'no',
  `qtyBackDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_req`
--

INSERT INTO `archive_req` (`id`, `reqNo`, `adminAddedName`, `workOrderNo`, `area`, `item`, `length`, `width`, `height`, `workType`, `priority`, `executer`, `wereHouse`, `inspector`, `discription`, `notes`, `reqDate`, `executerNew`, `executerDate`, `status`, `rejectReason`, `rejectsNum`, `new`, `finishDate`, `issued`, `resend_note`, `pending_in`, `type_req`, `pending_date`, `wereHouseDate`, `executerAccept`, `executerAcceptDate`, `inspectorDate`, `resentDate`, `qtyBackStatus`, `qtyBackDate`) VALUES
(162, '202300001', 'Requester', '000000000', 'Packing', 'line 1', '1', '1', '1', '2 - Routine', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', NULL, 'vv', '2023-12-01 17:47:58.000000', 'yes', '2023-12-01 20:08:18.000000', 'rejected', 'cc', 2, 'no', '2023-12-01', 'yes', '', 'Excauter', 'Reject', '2023-12-01 21:46:43.000000', '2023-12-01 20:15:04.000000', 'yes', '2023-12-01 20:02:35.000000', '2023-12-01 21:46:43.000000', '2023-12-01 20:18:08.000000', 'no', NULL),
(169, '202300008', 'Requester', '5436347321', 'Packing', 'line 1', '1', '1', '1', '2 - Routine', 'Medium 3-4 Days', 'Excauter', 'Warehouse', 'Inspector', 'vdds', 'vvssx', '2024-01-05 00:03:03.000000', 'yes', '2024-01-05 00:04:25.000000', 'accepted', '', 1, 'no', '2024-01-06', 'yes', 'test note', 'Requester', 'Done', '2024-01-11 22:28:27.000000', '2024-01-05 00:05:13.000000', 'yes', '2024-01-05 00:06:28.000000', '2024-01-11 22:07:07.000000', '2024-01-05 13:14:26.000000', 'finish', '2024-01-11 22:27:03'),
(170, '202300009', 'Requester', '745745745843', 'Packing', 'line 1', '1', '1', '1', '1 - Incident', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', 'fgjfnmf', 'fgn', '2024-01-11 21:44:13.000000', 'no', '2024-01-16 20:12:47.000000', 'rejected', 'ؤر يءؤ', 0, 'no', NULL, 'no', '', 'Requester', 'Reject', '2024-01-16 20:12:47.000000', NULL, 'no', NULL, NULL, NULL, 'no', NULL);

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
(8, '1', '1', 'line 1'),
(9, '2', '1', 'line 2'),
(10, '3', '1', 'line 3');

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

--
-- Dumping data for table `rejectitemdes`
--

INSERT INTO `rejectitemdes` (`id`, `workOrderNo`, `itemName`, `itemQty`, `wereHouseQty`, `wereHouseComment`, `rejectsNum`, `qtyBack`, `rejectDate`) VALUES
(96, '098729639492', 'Pipe scaffolding 6m', '1', '1', '', 0, '1', '2023-11-24 15:53:32'),
(97, '1111111222222222', 'Pipe scaffolding 6m', '21', '11', '34ثقيب', 0, '4', '2023-11-24 16:12:05'),
(98, '116622553', 'Pipe scaffolding 6m', '5', '5', '..', 0, '', '2023-11-24 21:11:51'),
(99, '75687684', 'Pipe scaffolding 6m', '1', '1', '', 0, '', '2023-11-24 23:25:12'),
(100, '75687684 ', 'Movable clamp', '4', '4', '', 1, '', '2023-11-24 23:27:55'),
(101, '7563333234', 'Woode borders 1m', '5', '5', '', 0, '', '2023-11-30 00:14:42'),
(102, '7658587965956', 'Pipe scaffolding 5m', '4', '4', '', 0, '', '2023-11-30 00:19:06'),
(103, '000000000', 'Pipe scaffolding 6m', '4', '4', '', 0, '', '2023-12-01 18:06:43'),
(104, '111111111111111', 'Pipe scaffolding 5m', '66', '66', '', 0, '', '2023-12-01 18:18:17'),
(105, '33333', 'Pipe scaffolding 5m', '33', '33', '', 0, '33', '2023-12-01 19:24:18'),
(106, '33333', 'Pipe scaffolding 6m', '4', '4', '', 0, '4', '2023-12-01 19:24:46'),
(107, '33333', 'Pipe scaffolding 4M', '55', '55', '', 0, '55', '2023-12-01 19:27:06'),
(108, '000000000 ', 'Pipe scaffolding 6m', '5', '5', '', 1, '', '2023-12-01 20:06:53'),
(109, '000000000 ', 'Woode borders 3m', '55', '55', '', 1, '', '2023-12-01 20:07:09'),
(110, '000000000 ', 'Woode borders 4m', '55', '55', '', 1, '', '2023-12-01 20:08:18'),
(111, '444444', 'Pipe scaffolding 6m', '4', '', '', 0, '', '2023-12-01 22:38:04'),
(112, '6666754544', 'Pipe scaffolding 6m', '4', '', '', 0, '', '2023-12-08 21:02:28'),
(113, '6666754544', 'Pipe scaffolding3m', '6', '', '', 0, '', '2023-12-08 21:02:28'),
(114, '43634622', 'Pipe scaffolding 5m', '5', '5', '', 0, '', '2023-12-15 21:12:56'),
(115, '5436347321', 'Movable clamp', '1', '1', '', 0, '1', '2024-01-05 00:04:25'),
(116, '000000000 ', 'Pipe scaffolding 6m', '5', '5', 'rr', 2, '', '2024-01-11 21:47:44');

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
  `discription` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `notes` varchar(255) NOT NULL,
  `reqDate` datetime(6) NOT NULL,
  `executerNew` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'yes',
  `executerDate` datetime(6) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `rejectReason` varchar(255) NOT NULL,
  `rejectsNum` int(255) NOT NULL DEFAULT 0,
  `new` varchar(255) NOT NULL DEFAULT 'yes',
  `finishDate` date DEFAULT NULL,
  `issued` varchar(255) NOT NULL DEFAULT 'no',
  `resend_note` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `pending_in` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type_req` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `pending_date` datetime(6) NOT NULL DEFAULT current_timestamp(6),
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

INSERT INTO `request` (`id`, `reqNo`, `adminAddedName`, `workOrderNo`, `area`, `item`, `length`, `width`, `height`, `workType`, `priority`, `executer`, `wereHouse`, `inspector`, `discription`, `notes`, `reqDate`, `executerNew`, `executerDate`, `status`, `rejectReason`, `rejectsNum`, `new`, `finishDate`, `issued`, `resend_note`, `pending_in`, `type_req`, `pending_date`, `wereHouseDate`, `executerAccept`, `executerAcceptDate`, `inspectorDate`, `resentDate`, `qtyBackStatus`, `qtyBackDate`) VALUES
(162, '202300001', 'Requester2', '000000000', 'Packing', 'line 1', '1', '1', '1', '2 - Routine', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', NULL, 'vv', '2023-12-01 17:47:58.000000', 'yes', '2024-01-11 21:47:44.000000', 'backExecuter', 'cc', 2, 'no', '2023-12-01', 'yes', '', 'Excauter', 'Instulation Execution', '2024-01-11 21:50:09.000000', '2024-01-11 21:50:09.000000', 'yes', '2023-12-01 20:02:35.000000', '2023-12-01 21:46:43.000000', '2023-12-01 20:18:08.000000', 'no', NULL),
(163, '202300002', 'Requester', '111111111111111', 'WareHouse', 'line 1', '1', '1', '1', '1 - Incident', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', NULL, 'jf', '2023-12-22 20:56:48.000000', 'yes', '2023-12-01 18:18:17.000000', 'pending', '', 0, 'no', '2023-12-01', 'yes', '', 'Excauter', 'Done', '2023-12-01 19:21:08.000000', '2023-12-01 19:21:08.000000', 'no', NULL, NULL, NULL, 'no', NULL),
(164, '202300003', 'Requester', '2222222222', 'Packing', 'line 2', '1', '1', '1', '1 - Incident', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', NULL, 'ws\r\n', '2023-12-01 19:04:28.000000', 'no', '2023-12-01 19:06:05.000000', 'rejected', 'vv', 0, 'no', NULL, 'no', '', 'Requester', 'Reject', '2023-12-01 19:06:05.000000', NULL, 'no', NULL, NULL, NULL, 'finish', NULL),
(165, '202300004', 'Requester', '33333', 'Packing', 'line 1', '1', '1', '1', '2 - Routine', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', NULL, 'ee', '2023-12-01 19:23:45.000000', 'yes', '2023-12-01 19:27:06.000000', 'accepted', '', 0, 'no', '2023-12-02', 'yes', '', 'Requester', 'Dismantling done', '2023-12-01 21:56:30.000000', '2023-12-01 19:27:30.000000', 'yes', '2023-12-01 19:33:01.000000', '2023-12-01 20:02:09.000000', NULL, 'finish', '2023-12-01 21:33:48'),
(166, '202300005', 'Requester', '444444', 'Packing', 'line 1', '1', '1', '1', '1 - Incident', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', NULL, 'يي\r\n', '2023-12-01 22:36:52.000000', 'no', '2023-12-01 22:38:04.000000', 'pending', '', 0, 'no', '2023-12-02', 'no', '', 'Warehouse', 'WereHouse', '2023-12-01 22:38:04.000000', NULL, 'no', NULL, NULL, NULL, 'no', NULL),
(167, '202300006', 'Requester', '6666754544', 'Packing', 'line 2', '1', '1', '1', '2 - Routine', 'Medium 3-4 Days', 'Excauter', 'Warehouse', 'Inspector', 'fdg', 'eddfvb', '2023-12-08 15:21:58.000000', 'no', '2023-12-08 21:02:28.000000', 'pending', '', 0, 'no', '2023-12-09', 'no', '', 'Warehouse', 'WereHouse', '2023-12-08 21:02:28.000000', NULL, 'no', NULL, NULL, NULL, 'no', NULL),
(168, '202300007', 'Requester', '43634622', 'Packing', 'line 1', '4', '4', '4', '1 - Incident', 'Immediately Today', 'Excauter', 'Warehouse', 'Inspector', 'trhtr', 'rgb', '2023-12-08 21:03:50.000000', 'yes', '2023-12-15 21:12:56.000000', 'accepted', '', 0, 'no', '2023-12-21', 'yes', '', 'Excauter', 'Dismantling', '2023-12-15 21:14:03.000000', '2023-12-15 21:13:11.000000', 'yes', '2023-12-15 21:13:29.000000', '2023-12-15 21:13:37.000000', NULL, 'executer', '2023-12-15 21:14:03');

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
  `main` varchar(5) NOT NULL DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `token`, `username`, `email`, `password`, `area`, `type`, `main`) VALUES
(25, '230821114033162', 'Requester', 'Requester@gmail.com', 'R12341234', '', 'requester', 'yes'),
(26, '230821114122103', 'Warehouse', 'Warehouse@gmail.com', 'W12341234', '', 'wereHouse', 'yes'),
(27, '230821114149170', 'Excauter', 'Executer@gmail.com', 'E12341234', '', 'execution', 'yes'),
(28, '230821114217156', 'Inspector', 'Inspector@gmail.com', 'I12341234', '1', 'inspector', 'yes'),
(29, '230821114247185', 'Manager', 'Manager@gmail.com', 'M12341234', '', 'owner', 'yes'),
(45, '230930122305145', 'Safety', 'safety@gmail.com', 'S12341234', '', 'safety', 'no'),
(47, '231001023153153', 'mohamed qadouri', 'mohammed.qadoury@lafarge.com', '12341234', '3', 'inspector', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `werehouseback`
--

CREATE TABLE `werehouseback` (
  `id` int(11) NOT NULL,
  `workOrderNo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `itemName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `wereHouseComment` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `qtyBack` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `werehouseback`
--

INSERT INTO `werehouseback` (`id`, `workOrderNo`, `itemName`, `wereHouseComment`, `qtyBack`) VALUES
(67, '098729639492', 'Movable clamp', 'tthf', '7'),
(68, '1111111222222222', 'Fixed clamp', '4', '4'),
(69, '33333', 'Woode borders 3m', '55', '55'),
(70, '5436347321', 'Woode borders 1m', 'rr', '2');

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
-- Indexes for table `archive_req`
--
ALTER TABLE `archive_req`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `areaitems`
--
ALTER TABLE `areaitems`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `itemdes`
--
ALTER TABLE `itemdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `rejectitemdes`
--
ALTER TABLE `rejectitemdes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `werehouseback`
--
ALTER TABLE `werehouseback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `worktype`
--
ALTER TABLE `worktype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
