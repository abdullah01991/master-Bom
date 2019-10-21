-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2019 at 05:12 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bom`
--
USE `bom`;
-- --------------------------------------------------------

--
-- Table structure for table `releases`
--

DROP TABLE `releases`; 
CREATE TABLE `releases` (
  `id` varchar(15) NOT NULL COMMENT 'release identifier',
  `name` varchar(100) NOT NULL,
  `type` varchar(25) NOT NULL,
  `status` varchar(15) NOT NULL,
  `open_date` date DEFAULT NULL,
  `dependency_date` date DEFAULT NULL,
  `freeze_date` date DEFAULT NULL,
  `rtm_date` date DEFAULT NULL,
  `manager` varchar(25) DEFAULT NULL COMMENT 'release manager',
  `author` varchar(25) DEFAULT NULL COMMENT 'requester of this release',
  `app_id` varchar(15) DEFAULT NULL COMMENT 'foreign key to the bom'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `releases`
--

INSERT INTO `releases` (`id`, `name`, `type`, `status`, `open_date`, `dependency_date`, `freeze_date`, `rtm_date`, `manager`, `author`, `app_id`) VALUES
('ICS-201684', 'SAFe Project V.5.6.8', 'Async ', 'Draft', '2020-10-01', '2020-08-23', '2020-10-18', '2020-12-06', 'Brill, Barbara', 'Ram, Christina', 'BOM-107'),
('ICS-201685', 'SAFe Project V.5.6.9', 'Async ', 'Draft', '2021-10-01', '2021-08-23', '2021-10-18', '2021-12-06', 'Brill, Barbara', 'Ram, Christina', 'BOM-112'),
('ICS-201689', 'SAFe Project V.5.6.7', 'Async ', 'Active', '2019-10-01', '2019-08-23', '2019-10-18', '2019-12-06', 'Brill, Barbara', 'Ram, Christina', 'BOM-102'),
('ICS-201812', 'QuizMaster 1.1', 'Major', 'Completed', '2019-08-23', '2019-10-18', '0000-00-00', '2019-08-14', 'Jasthi, Siva', 'Knight, Mark', 'BOM-100'),
('ICS-201814', 'QuizMaster 1.2', 'Major', 'Draft', '2020-08-23', '2020-10-18', '0000-00-00', '2020-08-14', 'Jasthi, Siva', 'Knight, Mark', 'BOM-105'),
('ICS-201815', 'QuizMaster That Works in English, Telugu, Hindi, Kannada and Other Indic Languages V 2020', 'Major', 'Draft', '2021-08-23', '2021-10-18', '0000-00-00', '2021-08-14', 'Jasthi, Siva', 'Knight, Mark', 'BOM-110'),
('ICS-201944', 'Bingo 2.4', 'Minor', 'Draft', '2020-10-18', '0000-00-00', '0000-00-00', '2020-09-05', 'Doe, John', 'Doe, Jane', 'BOM-106'),
('ICS-201945', 'Bingo 2.3', 'Minor', 'Draft', '2019-10-18', '0000-00-00', '0000-00-00', '2019-09-05', 'Doe, John', 'Doe, Jane', 'BOM-101'),
('ICS-201955', 'Bingo 2.5', 'Minor', 'Draft', '2021-10-18', '0000-00-00', '0000-00-00', '2021-09-05', 'Doe, John', 'Doe, Jane', 'BOM-111'),
('ICS-789084', 'Registration System V.2020', 'Async ', 'Draft', '2020-10-01', '2020-08-23', '2020-10-18', '2020-12-06', 'Drew, Andy', 'Peterson, Rocky', 'BOM-108'),
('ICS-789085', 'Registration System V.2020.1', 'Async ', 'Draft', '2021-10-01', '2021-08-23', '2021-10-18', '2021-12-06', 'Drew, Andy', 'Peterson, Rocky', 'BOM-113'),
('ICS-789089', 'Registration System V.2019', 'Async ', 'Released', '2019-10-01', '2019-08-23', '2019-10-18', '2019-12-06', 'Drew, Andy', 'Peterson, Rocky', 'BOM-103'),
('ICS-898984', 'Word Explorer 2021', 'Patch', 'Draft', '2020-10-01', '2020-08-23', '2020-10-18', '2020-12-06', 'Jasthi, Siva', 'Jasthi, Siva', 'BOM-109'),
('ICS-898985', 'Word Explorer 2022', 'Patch', 'Draft', '2021-10-01', '2021-08-23', '2021-10-18', '2021-12-06', 'Jasthi, Siva', 'Jasthi, Siva', 'BOM-114'),
('ICS-898989', 'Word Explorer 2020', 'Patch', 'Completed', '2019-10-01', '2019-08-23', '2019-10-18', '2019-12-06', 'Jasthi, Siva', 'Jasthi, Siva', 'BOM-104');

-- --------------------------------------------------------

--
-- Table structure for table `sbom`
--

DROP TABLE `sbom`; 
CREATE TABLE `sbom` (
  `row_id` int(6) NOT NULL,
  `app_id` varchar(15) NOT NULL,
  `app_name` varchar(100) NOT NULL,
  `app_version` varchar(15) NOT NULL,
  `cmp_id` varchar(15) NOT NULL,
  `cmp_name` varchar(100) NOT NULL,
  `cmp_version` varchar(15) NOT NULL,
  `cmp_type` varchar(15) NOT NULL,
  `app_status` varchar(15) NOT NULL,
  `cmp_status` varchar(15) NOT NULL,
  `request_id` varchar(15) DEFAULT NULL,
  `request_date` date DEFAULT NULL,
  `request_status` varchar(15) DEFAULT NULL,
  `request_step` varchar(30) DEFAULT NULL,
  `notes` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sbom`
--

INSERT INTO `sbom` (`row_id`, `app_id`, `app_name`, `app_version`, `cmp_id`, `cmp_name`, `cmp_version`, `cmp_type`, `app_status`, `cmp_status`, `request_id`, `request_date`, `request_status`, `request_step`, `notes`) VALUES
(1, 'BOM-100', 'QuizMaster', '1.1', '101.1', 'DB_Layer', '2.3', 'internal', 'released', 'released', 'xyz_123_r', '2020-10-01', 'Approved', 'Approval Step', ''),
(2, 'BOM-100', 'QuizMaster', '1.1', '101.2', 'Jquery', '4.3', 'open source', 'released', 'approved', 'xyz_124_r', '2020-10-01', 'Pending', 'Review Step', 'open source, no commercial support'),
(3, 'BOM-100', 'QuizMaster', '1.1', '101.3', 'Bootstrap', '8.5.c', 'open source', 'released', 'pending', 'xyz_323_r', '2019-08-01', 'Submitted', 'Review Step', ''),
(4, 'BOM-100', 'QuizMaster', '1.1', '101.4', 'IconFinder', '2019', 'commercial', 'released', 'submitted', 'xyz_423_r', '2020-10-05', 'Submitted', 'Inspection Step', ''),
(5, 'BOM-100', 'QuizMaster', '1.1', '101.5', 'Excel', '2019', 'commercial', 'released', 'in_review', 'xyz_163_r', '2020-10-01', 'Approved', 'Approval Step', ''),
(6, '101.1', 'DB_Layer', '2.3', '101.1.1', 'DB_Layer_MySQL', 'v1.0', 'internal', 'released', 'released', 'xyz_143_r', '2019-08-01', 'Pending', 'Review Step', ''),
(8, '101.1', 'DB_Layer', '2.3', '101.1.2', 'DB_Layer_DB2', 'v1.0', 'internal', 'released', 'released', 'xyz_1234_r', '2020-10-05', 'Submitted', 'Inspection Step', ''),
(10, '101.1', 'DB_Layer', '2.3', '101.1.4', 'DB_Layer_Ingress', 'v1.0', 'internal', 'released', 'released', 'xyzff_123_r', '2020-08-01', 'Approved', 'Review Step', ''),
(11, 'BOM-104', 'QuizMaster', '2.2', '202.2', 'DB_Layer', '2.3', 'internal', 'released', 'released', 'xyz_123_rr', '2020-03-05', 'Pending', 'Approval Step', ''),
(12, 'BOM-104', 'QuizMaster', '2.2', '202.2', 'Jquery', '4.3', 'open source', 'released', 'approved', 'xyz_123_rrr', '2020-10-01', 'Approved', 'Review Step', 'open source, no commercial support'),
(13, 'BOM-104', 'QuizMaster', '2.2', '202.3', 'Bootstrap', '8.5.c', 'open source', 'released', 'pending', 'xyz_12345_r', '2019-05-06', 'Submitted', 'Inspection Step', ''),
(14, 'BOM-104', 'QuizMaster', '2.2', '202.4', 'IconFinder', '2029', 'commercial', 'released', 'submitted', 'xyz_13423_r', '2020-08-01', 'Approved', 'Approval Step', ''),
(15, 'BOM-104', 'QuizMaster', '2.2', '202.5', 'Excel', '2029', 'commercial', 'released', 'in_review', 'xyz_12453_r', '2019-10-01', 'Pending', 'Inspection Step', ''),
(16, '202.2', 'DB_Layer', '2.3', '202.2.2', 'DB_Layer_Maria', 'v2.0', 'internal', 'released', 'released', 'xyz_123_rtr', '2020-08-05', 'Approved', 'Review Step', ''),
(17, '202.2', 'DB_Layer', '2.3', '202.2.2', 'DB_Layer_DB2', 'v2.0', 'internal', 'released', 'released', 'xyz_12ew3_r', '2021-12-01', 'Submitted', 'Approval Step', ''),
(18, '202.2', 'DB_Layer', '2.3', '202.2.3', 'DB_Layer_Oracle', 'v2.0', 'internal', 'released', 'released', 'xyz_12323_r', '2020-10-25', 'Pending', 'Review Step', ''),
(19, '202.2', 'DB_Layer', '2.3', '202.2.4', 'DB_Layer_Ingress', 'v2.0', 'internal', 'released', 'released', 'xyz_13123_r', '2021-10-21', 'Approved', 'Review Step', ''),
(20, '202.2', 'DB_Layer', '2.3', '202.2.5', 'DB_Layer_MS_SQL', 'v2.0', 'internal', 'released', 'released', 'abc_123_r', '2020-11-15', 'Submitted', 'Approval Step', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `releases`
--
ALTER TABLE `releases`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sbom`
--
ALTER TABLE `sbom`
  ADD PRIMARY KEY (`row_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sbom`
--
ALTER TABLE `sbom`
  MODIFY `row_id` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
