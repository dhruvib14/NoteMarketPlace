-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 03, 2021 at 02:56 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `notemarketplace`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Category_name` varchar(34) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`ID`, `Category_name`, `Description`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(12, 'science', 'it\'s for  a scientists subject', NULL, NULL, NULL, NULL, b'0'),
(13, 'CA', 'ITS A CA FIELD CATEGORY NAME', NULL, NULL, NULL, NULL, b'1'),
(14, 'MBA', 'MBA FIELD CATEGORY', NULL, NULL, NULL, NULL, b'1'),
(15, 'COMPUTER SCIENCE', 'ITS FOR A COMPUTER SCIENCE CATEGORY', NULL, NULL, NULL, NULL, b'1'),
(16, 'SOCIAL SCIENCE', 'ITES A SOCIAL SCEINCE FIELD ', NULL, NULL, NULL, NULL, b'1'),
(17, 'INFORMATION TECHNOLOGY', 'INFORMATION TECHNOLOGY IS USED IN ALL FIELDS', NULL, NULL, NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE `country` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Country_Name` varchar(34) NOT NULL,
  `Country_Code` varchar(50) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`ID`, `Country_Name`, `Country_Code`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'INDIA', '91', NULL, NULL, NULL, NULL, b'1'),
(2, 'USA', '1', NULL, NULL, NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `downloads`
--

CREATE TABLE `downloads` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NoteID` int(10) UNSIGNED NOT NULL,
  `SellerID` int(10) UNSIGNED NOT NULL,
  `DownloaderID` int(10) UNSIGNED NOT NULL,
  `IsSellerHasAllowedDownload` bit(1) NOT NULL,
  `AttachmentPath` varchar(500) DEFAULT NULL,
  `IsAttachmentDownloaded` bit(1) NOT NULL,
  `AttachmentDownloadedDate` datetime DEFAULT NULL,
  `IsPaid` int(10) UNSIGNED NOT NULL,
  `PurchasedPrice` decimal(10,0) DEFAULT NULL,
  `NoteTitle` varchar(100) NOT NULL,
  `NoteCategory` varchar(100) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `downloads`
--

INSERT INTO `downloads` (`ID`, `NoteID`, `SellerID`, `DownloaderID`, `IsSellerHasAllowedDownload`, `AttachmentPath`, `IsAttachmentDownloaded`, `AttachmentDownloadedDate`, `IsPaid`, `PurchasedPrice`, `NoteTitle`, `NoteCategory`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 40, 81, 79, b'1', NULL, b'0', NULL, 4, '50', 'abc', 'science', NULL, NULL, NULL, NULL, b'1'),
(4, 35, 81, 79, b'0', NULL, b'0', NULL, 4, '30', 'abc', 'handwritten', NULL, NULL, NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `notes`
--

CREATE TABLE `notes` (
  `ID` int(10) UNSIGNED NOT NULL,
  `SellerID` int(11) UNSIGNED NOT NULL,
  `Status` int(11) UNSIGNED NOT NULL,
  `Actioned_By` int(11) UNSIGNED DEFAULT NULL,
  `Admin_Remarks` varchar(500) DEFAULT NULL,
  `PublishedDate` datetime DEFAULT NULL,
  `Note_Title` varchar(100) NOT NULL,
  `Category` int(11) UNSIGNED NOT NULL,
  `Note_Display_Picture` varchar(500) DEFAULT NULL,
  `Note_types` int(10) UNSIGNED DEFAULT NULL,
  `Note_Pages` smallint(6) DEFAULT NULL,
  `Description` varchar(500) DEFAULT NULL,
  `University` varchar(100) NOT NULL,
  `Country` int(10) UNSIGNED NOT NULL,
  `Course` varchar(100) NOT NULL,
  `Course_Code` varchar(50) NOT NULL,
  `Professor_Name` varchar(100) NOT NULL,
  `Is_Paid` int(10) UNSIGNED NOT NULL,
  `Price` decimal(10,0) DEFAULT NULL,
  `NotesPreview` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notes`
--

INSERT INTO `notes` (`ID`, `SellerID`, `Status`, `Actioned_By`, `Admin_Remarks`, `PublishedDate`, `Note_Title`, `Category`, `Note_Display_Picture`, `Note_types`, `Note_Pages`, `Description`, `University`, `Country`, `Course`, `Course_Code`, `Professor_Name`, `Is_Paid`, `Price`, `NotesPreview`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(6, 94, 7, NULL, NULL, NULL, 'abc', 16, '../members/94/6/DP_1617381586.png', 1, 12, 'abc', 'aas', 1, 'asa', '12', 'asa', 5, '20', '../members/94/6/Preview_1617381587.png', '2021-04-01 16:18:34', 94, '2021-04-03 15:40:33', 94, b'0'),
(7, 94, 9, NULL, NULL, '2021-04-02 15:49:24', 'a', 16, '../members/default/search1.jpg', 1, 1, 'ajbkadbsakjbd', 'abc', 1, 'a', '12', 'as', 5, '12', NULL, '2021-04-01 17:48:52', 94, '2021-04-01 17:48:52', 94, b'1'),
(8, 94, 8, NULL, NULL, NULL, 'a', 16, '../members/default/search1.jpg', 1, 1, 'ajbkadbsakjbd', 'abc', 1, 'a', '12', 'as', 5, '12', NULL, '2021-04-01 17:50:57', 94, '2021-04-01 17:50:57', 94, b'1'),
(9, 94, 8, NULL, NULL, NULL, 'a', 16, '../members/default/search1.jpg', 1, 1, 'ajbkadbsakjbd', 'abc', 1, 'a', '12', 'as', 5, '12', NULL, '2021-04-01 17:51:48', 94, '2021-04-01 17:51:48', 94, b'1'),
(10, 94, 8, NULL, NULL, NULL, 'a', 16, '../members/default/search1.jpg', 1, 1, 'ajbkadbsakjbd', 'abc', 1, 'a', '12', 'as', 5, '12', NULL, '2021-04-01 17:53:05', 94, '2021-04-01 17:53:05', 94, b'1'),
(11, 94, 8, NULL, NULL, NULL, 'a', 16, '../members/default/search1.jpg', 1, 1, 'ajbkadbsakjbd', 'abc', 1, 'a', '12', 'as', 5, '12', NULL, '2021-04-01 17:54:36', 94, '2021-04-01 17:54:36', 94, b'1'),
(12, 94, 8, NULL, NULL, NULL, 'a', 16, '../members/94/12/DP_1617280052.png', 1, 1, 'ajbkadbsakjbd', 'abc', 1, 'a', '12', 'as', 5, '12', NULL, '2021-04-01 17:57:32', 94, '2021-04-01 17:57:32', 94, b'1'),
(13, 94, 8, NULL, NULL, NULL, 'sh', 15, '../members/94/13/DP_1617286231.png', 1, 0, 'aa', 'a', 1, 'a', '1', 'a', 5, '0', NULL, '2021-04-01 19:40:31', 94, '2021-04-01 19:40:31', 94, b'1'),
(15, 94, 8, NULL, NULL, NULL, 'ada', 13, '../members/94/15/DP_1617286751.jpg', 1, 1212, 'adsad', 'aada', 2, 'adasd', '12', 'ad', 5, '11232', NULL, '2021-04-01 19:49:11', 94, '2021-04-01 19:49:11', 94, b'1'),
(16, 94, 8, NULL, NULL, NULL, 'abc', 15, '../members/94/16/DP_1617287200.png', 2, 12, 'abdasbjkas', 'asa', 2, 'kbcskjbd', '121', 'bdajkd', 5, '121', NULL, '2021-04-01 19:56:40', 94, '2021-04-01 19:56:40', 94, b'1'),
(17, 94, 8, NULL, NULL, NULL, 'ada', 17, '../members/94/17/DP_1617287375.png', 3, 121, 'dasdkjskajd', 'adbajd', 2, 'abdja', '121212', 'cs', 4, '21', NULL, '2021-04-01 19:59:35', 94, '2021-04-01 19:59:35', 94, b'1'),
(18, 94, 8, NULL, NULL, NULL, 'ada', 16, '../members/94/18/DP_1617287600.jpg', 2, 1, 'asdasdadsada', 'asd', 1, 'dsad', '121', 'adasd', 4, '121', NULL, '2021-04-01 20:03:20', 94, '2021-04-01 20:03:20', 94, b'1'),
(19, 94, 8, NULL, NULL, NULL, 'ada', 16, '../members/94/19/DP_1617288069.png', 2, 1, 'adaddddad', 'adadd', 1, 'aa', '121', 'adad', 4, '121212', NULL, '2021-04-01 20:11:09', 94, '2021-04-01 20:11:09', 94, b'1'),
(20, 94, 8, NULL, NULL, NULL, 'ada', 15, '../members/94/20/DP_1617288214.png', 1, 21, 'asdadsa', 'dsd', 2, 'd', '1', 'asdasd', 4, '3', NULL, '2021-04-01 20:13:34', 94, '2021-04-01 20:13:34', 94, b'1'),
(21, 94, 8, NULL, NULL, NULL, 'das', 15, '../members/94/21/DP_1617288407.jpg', 2, 6, 'sadad', 'sda', 1, 'dsa', '12', 'dsa', 4, '11232', NULL, '2021-04-01 20:16:47', 94, '2021-04-01 20:16:47', 94, b'1'),
(22, 94, 8, NULL, NULL, NULL, 'das', 16, '../members/94/22/DP_1617288610.png', 2, 12, 'ffwfewf', 'dsaD', 1, 'D', '3', 'DS', 4, '32', NULL, '2021-04-01 20:20:10', 94, '2021-04-01 20:20:10', 94, b'1'),
(23, 94, 8, NULL, NULL, NULL, 'F', 13, '../members/94/23/DP_1617288710.jpg', 2, 4, 'QRGGG', 'FDA', 1, 'FDAS32', '3', 'AVFD', 4, '43', '../members/94/23/Preview_1617288710.png', '2021-04-01 20:21:50', 94, '2021-04-01 20:21:50', 94, b'1'),
(24, 94, 8, NULL, NULL, NULL, 'f', 16, '../members/94/24/DP_1617288892.png', 1, 4, 'sfd', 'dfa', 1, 'fda', '4', 'dasf', 4, '23', '../members/94/24/Preview_1617288892.png', '2021-04-01 20:24:52', 94, '2021-04-01 20:24:52', 94, b'1'),
(25, 94, 8, NULL, NULL, NULL, 'abvc', 14, '../members/94/25/DP_1617335897.png', 2, 21, 'qqqqqqqqqqqqqqqqq', 'abb', 1, 'jvv', '12', 'bjb', 4, '21', '../members/94/25/Preview_1617335897.png', '2021-04-02 09:28:17', 94, '2021-04-02 09:28:17', 94, b'1'),
(26, 94, 8, NULL, NULL, NULL, 'abc', 12, '../members/94/26/DP_1617336620.png', 2, 43, 'jkdakbaskja', 'da', 2, 'adsf', '32', 'vfare', 4, '2', '../members/94/26/Preview_1617336620.png', '2021-04-02 09:40:20', 94, '2021-04-02 09:40:20', 94, b'1'),
(27, 94, 8, NULL, NULL, NULL, 'jkds', 14, '../members/94/27/DP_1617337076.png', 2, 323, 'dsfjfdsjadjsf', 'sD', 2, 'FDS', '32', 'FAAF', 4, '43', '../members/94/27/Preview_1617337077.png', '2021-04-02 09:47:56', 94, '2021-04-02 09:47:56', 94, b'1'),
(28, 94, 8, NULL, NULL, NULL, 'das', 16, '../members/94/28/DP_1617337316.png', 1, 56, 'vsfsfsdfsddssd', 'ads', 1, 'sad', '9', 'sad', 4, '43', NULL, '2021-04-02 09:51:55', 94, '2021-04-02 09:51:55', 94, b'1'),
(29, 94, 8, NULL, NULL, NULL, 'dkjas', 17, '../members/94/29/DP_1617337413.png', 2, 23, 'ssadsadsa', 'sdsa', 1, 'sada', '54', 'dasdsa', 4, '32', '../members/94/29/Preview_1617337413.png', '2021-04-02 09:53:33', 94, '2021-04-02 09:53:33', 94, b'1'),
(30, 94, 8, NULL, NULL, NULL, 'asd', 14, '../members/94/30/DP_1617337951.png', 1, 34, 'dsfsfdsfsdf', '23', 2, 'dfs', '32', 'dfv', 4, '43', '../members/94/30/Preview_1617337951.png', '2021-04-02 10:02:30', 94, '2021-04-02 10:02:30', 94, b'1'),
(31, 94, 8, NULL, NULL, NULL, 'sa', 15, '../members/94/31/DP_1617338055.png', 1, 43, 'dfadfsdfsdfds', 'ds', 1, 'vfvsfd', '4', 'sd', 5, '43', '../members/94/31/Preview_1617338056.png', '2021-04-02 10:04:15', 94, '2021-04-02 10:04:15', 94, b'1'),
(32, 94, 8, NULL, NULL, NULL, 'sad', 12, '../members/94/32/DP_1617338972.png', 2, 32, 'dfsdfsfsfsd', 'df', 1, 'dfsfs3', '3', 'sds', 4, '3', '../members/94/32/Preview_1617338972.png', '2021-04-02 10:19:32', 94, '2021-04-02 10:19:32', 94, b'1'),
(33, 94, 8, NULL, NULL, NULL, 'sd', 15, '../members/94/33/DP_1617340369.png', 1, 32, 'dd', 'dd', 1, 'ds', '32', 'dss', 4, '321', '../members/94/33/Preview_1617340369.png', '2021-04-02 10:42:49', 94, '2021-04-02 10:42:49', 94, b'1'),
(34, 94, 8, NULL, NULL, NULL, 'dasssssssssssssssssssssssss', 16, '../members/94/34/DP_1617340562.png', 1, 32, 'dsdfdsf', '32', 1, 'fds32', '3', 'sfd', 4, '32', '../members/94/34/Preview_1617340562.png', '2021-04-02 10:46:02', 94, '2021-04-02 10:46:02', 94, b'1'),
(35, 94, 8, NULL, NULL, NULL, 'dsd', 15, '../members/94/35/DP_1617340771.png', 2, 32, 'asaasas', 'sas', 1, 'dfdf', '32', 'dsds', 4, '32', '../members/94/35/Preview_1617340771.png', '2021-04-02 10:49:31', 94, '2021-04-02 10:49:31', 94, b'1'),
(36, 94, 8, NULL, NULL, NULL, 'sds', 15, '../members/94/36/DP_1617341554.png', 1, 32, 'dsfdsfdfds', 'dsdd', 1, 'sdsd', '43', 'fdsfsf', 5, '0', '../members/94/36/Preview_1617341555.png', '2021-04-02 11:02:34', 94, '2021-04-02 11:02:34', 94, b'1'),
(37, 94, 8, NULL, NULL, NULL, 'gjjj', 17, '../members/94/37/DP_1617343155.png', 2, 23, 'hjnmmmmmmmmmm', 'nn', 1, 'kjj', '5', 'vjh', 5, '98', '../members/94/37/Preview_1617343155.png', '2021-04-02 11:29:15', 94, '2021-04-02 11:29:15', 94, b'1'),
(38, 94, 8, NULL, NULL, NULL, 'vgh', 16, '../members/94/38/DP_1617343347.png', 1, 98, 'fchggggg', '98', 1, 'jj', '45', 'fdx', 4, '98', '../members/94/38/Preview_1617343347.png', '2021-04-02 11:32:27', 94, '2021-04-02 11:32:27', 94, b'1'),
(39, 94, 8, NULL, NULL, NULL, 'ad', 12, '../members/94/39/DP_1617343476.png', 3, 32, 'dsfsfsdf', 'fw', 1, 'dfs', '5', 'dd', 4, '32', '../members/94/39/Preview_1617343477.png', '2021-04-02 11:34:36', 94, '2021-04-02 11:34:36', 94, b'1'),
(40, 94, 8, NULL, NULL, NULL, 'v', 16, '../members/94/40/DP_1617343646.png', 1, 88, 'jknk', 'vggh', 1, 'dgf', '4', 'bx', 5, '6554', '../members/94/40/Preview_1617343647.png', '2021-04-02 11:37:26', 94, '2021-04-02 11:37:26', 94, b'1'),
(45, 94, 6, NULL, NULL, NULL, 'science', 16, '../members/default/search1.jpg', 2, 3, 'dsfsfd', 'dsfds', 2, 'da', '1', 'bhhj', 4, '32', NULL, '2021-04-02 22:12:55', 94, '2021-04-02 22:12:55', 94, b'0');

-- --------------------------------------------------------

--
-- Table structure for table `notesattachment`
--

CREATE TABLE `notesattachment` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Note_ID` int(10) UNSIGNED NOT NULL,
  `File_Name` varchar(100) NOT NULL,
  `Path` varchar(255) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notesattachment`
--

INSERT INTO `notesattachment` (`ID`, `Note_ID`, `File_Name`, `Path`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 25, '', '', '2021-04-02 09:28:17', 94, NULL, NULL, b'1'),
(2, 26, '', '', '2021-04-02 09:40:20', 94, NULL, NULL, b'1'),
(3, 27, '', '', '2021-04-02 09:47:57', 94, NULL, NULL, b'1'),
(4, 28, '', '', '2021-04-02 09:51:56', 94, NULL, NULL, b'1'),
(5, 29, '', '', '2021-04-02 09:53:33', 94, NULL, NULL, b'1'),
(6, 30, '', '', '2021-04-02 10:02:31', 94, NULL, NULL, b'1'),
(7, 31, '7_1617338055pdf', '../members/94/31/Attachements/7_1617338055.pdf', '2021-04-02 10:04:15', 94, NULL, NULL, b'1'),
(8, 32, '8_1617338972pdf', '../members/94/32/Attachements/8_1617338972.pdf', '2021-04-02 10:19:32', 94, NULL, NULL, b'1'),
(9, 40, '9_1617343647pdf', '../members/94/40/Attachements/9_1617343647.pdf', '2021-04-02 11:37:26', 94, NULL, NULL, b'1'),
(10, 40, '10_1617343647pdf', '../members/94/40/Attachements/10_1617343647.pdf', '2021-04-02 11:37:27', 94, NULL, NULL, b'1'),
(11, 40, '11_1617343647pdf', '../members/94/40/Attachements/11_1617343647.pdf', '2021-04-02 11:37:27', 94, NULL, NULL, b'1'),
(21, 6, '21_1617374671pdf', '../members/94/6/Attachements/21_1617374671.pdf', '2021-04-02 20:14:31', 94, NULL, NULL, b'1'),
(22, 6, '22_1617381587pdf', '../members/94/6/Attachements/22_1617381587.pdf', '2021-04-02 22:09:47', 94, NULL, NULL, b'1'),
(23, 45, '23_1617381776pdf', '../members/94/45/Attachements/23_1617381776.pdf', '2021-04-02 22:12:55', 94, NULL, NULL, b'1'),
(24, 45, '24_1617381776pdf', '../members/94/45/Attachements/24_1617381776.pdf', '2021-04-02 22:12:56', 94, NULL, NULL, b'1'),
(25, 45, '25_1617381776pdf', '../members/94/45/Attachements/25_1617381776.pdf', '2021-04-02 22:12:56', 94, NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `referencedata`
--

CREATE TABLE `referencedata` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Value` varchar(100) NOT NULL,
  `DataValue` varchar(100) NOT NULL,
  `RefCategory` varchar(100) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `referencedata`
--

INSERT INTO `referencedata` (`ID`, `Value`, `DataValue`, `RefCategory`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'Male', 'M', 'Gender', '2021-04-01 14:18:40', NULL, '2021-04-01 14:18:40', NULL, b'1'),
(2, 'Female', 'Fe', 'Gender', '2021-04-01 14:18:40', NULL, '2021-04-01 14:18:40', NULL, b'1'),
(3, 'Unknown', 'U', 'Gender', '2021-04-01 14:26:51', NULL, '2021-04-01 14:26:51', NULL, b'0'),
(4, 'Paid', 'P', 'Selling Mode', '2021-04-01 14:26:51', NULL, '2021-04-01 14:26:51', NULL, b'1'),
(5, 'Free', 'F', 'Selling Mode', '2021-04-01 14:28:32', NULL, '2021-04-01 14:28:32', NULL, b'1'),
(6, 'Draft', 'Draft', 'Note status', '2021-04-01 14:28:32', NULL, '2021-04-01 14:28:32', NULL, b'1'),
(7, 'Submitted For Review', 'Submitted For Review', 'Notes Status', '2021-04-01 14:29:54', NULL, '2021-04-01 14:29:54', NULL, b'1'),
(8, 'In Review', 'In Review', 'Note Status', '2021-04-01 14:29:54', NULL, '2021-04-01 14:29:54', NULL, b'1'),
(9, 'Published', 'Approved', 'Note Status', '2021-04-01 14:31:45', NULL, '2021-04-01 14:31:45', NULL, b'1'),
(10, 'Rejected', 'Rejected', 'Note Status', '2021-04-01 14:31:45', NULL, '2021-04-01 14:31:45', NULL, b'1'),
(11, 'Removed', 'Removed', 'Notes Status', '2021-04-01 14:32:58', NULL, '2021-04-01 14:32:58', NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NoteID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL,
  `againstDownloadID` int(10) UNSIGNED NOT NULL,
  `Remarks` varchar(500) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `review_rating`
--

CREATE TABLE `review_rating` (
  `ID` int(10) UNSIGNED NOT NULL,
  `NoteID` int(10) UNSIGNED NOT NULL,
  `UserID` int(10) UNSIGNED NOT NULL,
  `againstdownloadID` int(10) UNSIGNED NOT NULL,
  `ratings` decimal(10,0) NOT NULL,
  `Comments` varchar(500) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `system_configuration`
--

CREATE TABLE `system_configuration` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Key_info` varchar(100) NOT NULL,
  `Value` varchar(255) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `ID` int(10) UNSIGNED NOT NULL,
  `Type_Name` varchar(34) NOT NULL,
  `Description` varchar(500) NOT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`ID`, `Type_Name`, `Description`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'HandWritten', 'this book is handwritten', NULL, NULL, NULL, NULL, b'1'),
(2, 'Story Books', 'this is the story book', NULL, NULL, NULL, NULL, b'1'),
(3, 'University Notes', 'it\'s a university notes for students', NULL, NULL, NULL, NULL, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `userroles`
--

CREATE TABLE `userroles` (
  `ID` int(11) UNSIGNED NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `userroles`
--

INSERT INTO `userroles` (`ID`, `Name`, `Description`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `ModifiedBy`, `IsActive`) VALUES
(1, 'khyati', 'superadmin', NULL, NULL, NULL, NULL, b'0000000000');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(10) UNSIGNED NOT NULL,
  `RoleID` int(10) UNSIGNED NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `LastName` varchar(50) NOT NULL,
  `EmailID` varchar(100) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `IsEmailVerified` bit(10) NOT NULL DEFAULT b'0',
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `IsActive` bit(10) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `RoleID`, `FirstName`, `LastName`, `EmailID`, `Password`, `IsEmailVerified`, `CreatedDate`, `CreatedBy`, `ModifiedDate`, `IsActive`) VALUES
(1, 1, 'khyati', 'patel', 'khyatipatel@gmail.com', 'khyati123', b'0000000001', NULL, NULL, NULL, b'0000000000'),
(34, 1, 'a', 'b', '12@fmk.d', 'khyati123', b'0000000000', NULL, NULL, NULL, b'0000000000'),
(46, 1, 'a', 'b', 'princebhikadiya2@gmail.com', '123', b'0000000000', NULL, NULL, NULL, b'0000000000'),
(53, 1, 'a', 'b', 'abcc@gmail.com', '123', b'0000000000', '2021-03-24 00:00:00', NULL, '2021-03-24 00:00:00', b'0000000000'),
(54, 1, 'a', 'b', 'a@g.c', '1', b'0000000000', '2021-03-24 09:53:38', NULL, '2021-03-24 09:53:38', b'0000000000'),
(55, 1, 'a', 'b', 'c@d.f', '1', b'0000000000', '2021-03-24 09:57:21', NULL, '2021-03-24 09:57:21', b'0000000000'),
(56, 1, 'a', 'a', 'a@a.a', 'm', b'0000000000', '2021-03-24 00:00:00', NULL, '2021-03-24 00:00:00', b'0000000000'),
(58, 1, 'a', 'b', 'dhruvibhikadiya14@gmail.co', '123', b'0000000000', '2021-03-24 10:32:19', NULL, '2021-03-24 10:32:19', b'0000000000'),
(59, 1, 'a', 'b', 'dhruvibhikadiya14@gmail.c', '123', b'0000000000', '2021-03-24 10:44:31', NULL, '2021-03-24 10:44:31', b'0000000000'),
(60, 1, 'a', 'b', 'aa@ds.dsbjbk', '123', b'0000000000', '2021-03-24 10:52:03', NULL, '2021-03-24 10:52:03', b'0000000000'),
(62, 1, 'a', 'bkj', 'kj@skb.sdvn', '1', b'0000000000', '2021-03-24 10:56:27', NULL, '2021-03-24 10:56:27', b'0000000000'),
(79, 1, 'a', 'hb', 'khyatipatel@gmail.co', 'khyati123', b'0000000000', '2021-03-25 09:27:14', NULL, '2021-03-25 09:27:14', b'0000000000'),
(80, 1, 'ah', 'jnk', 'nj@djkfs.csjbds', '1111', b'0000000000', '2021-03-25 09:30:39', NULL, '2021-03-25 09:30:39', b'0000000000'),
(81, 1, 'A', 'BB', 'dhruvibhikadiya14@gmail.comDS', '123', b'0000000000', '2021-03-25 09:35:56', NULL, '2021-03-25 09:35:56', b'0000000000'),
(82, 1, 'SCB', 'JD', 'JDS@ND.WED', '1', b'0000000000', '2021-03-25 09:38:01', NULL, '2021-03-25 09:38:01', b'0000000000'),
(83, 1, 'a', 'b', 'jsad@kjbsd.d', '1', b'0000000000', '2021-03-25 09:42:58', NULL, '2021-03-25 09:42:58', b'0000000000'),
(84, 1, 'a', 'b', 'djasas@mf.aa', '1', b'0000000000', '2021-03-25 09:46:45', NULL, '2021-03-25 09:46:45', b'0000000000'),
(88, 1, 'dhruvi', 'b', 'dhruvibhikadiya14@gmail.com', 'e3037d45bf7d37b07013198e69dc75ed', b'0000000001', '2021-03-25 14:00:25', NULL, '2021-03-25 14:00:25', b'0000000000'),
(89, 1, 'dhruvi', 'b', 'trainingm08@gmail.com', '1', b'0000000001', '2021-03-25 14:17:11', NULL, '2021-03-25 14:17:11', b'0000000000'),
(91, 1, 'dhruvi', 'b', 'abc@gmail.com', '900150983cd24fb0d6963f7d', b'0000000000', '2021-03-26 05:02:03', NULL, '2021-03-26 05:02:03', b'0000000000'),
(92, 1, 'abc', 'abcd', 'abcd@a.com', '900150983cd24fb0d6963f7d28e17f72', b'0000000001', '2021-03-26 05:16:04', NULL, '2021-03-26 05:16:04', b'0000000000'),
(93, 1, 'a', 'b', '1@b.aksjab', 'c20ad4d76fe97759aa27a0c99bff6710', b'0000000000', '2021-03-26 06:36:12', NULL, '2021-03-26 06:36:12', b'0000000000'),
(94, 1, 'a', 'a', 'a@a.aaa', '47bce5c74f589f4867dbd57e9ca9f808', b'0000000001', '2021-03-26 09:10:39', NULL, '2021-03-26 09:10:39', b'0000000000'),
(95, 1, 'dhruvi', 'dhruvi', 'hello@gm.ac', 'ba1d57cedac7fbae1f2fd8373d00f18a', b'0000000000', '2021-03-26 10:39:40', NULL, '2021-03-26 10:39:40', b'0000000000'),
(96, 1, 'dhruvi', 'bhi', 'hello@gm.a', 'ba1d57cedac7fbae1f2fd8373d00f18a', b'0000000000', '2021-03-26 10:45:51', NULL, '2021-03-26 10:45:51', b'0000000000'),
(97, 1, 'dhruvi', 'bhikadiya', 'hello@gm.abc', 'ba1d57cedac7fbae1f2fd8373d00f18a', b'0000000000', '2021-03-26 10:47:47', NULL, '2021-03-26 10:47:47', b'0000000000'),
(98, 1, 'dhruvi', 'bhik', 'hello@gm.acdb', 'ba1d57cedac7fbae1f2fd8373d00f18a', b'0000000000', '2021-03-26 10:48:53', NULL, '2021-03-26 10:48:53', b'0000000000');

-- --------------------------------------------------------

--
-- Table structure for table `users-details`
--

CREATE TABLE `users-details` (
  `ID` int(11) UNSIGNED NOT NULL,
  `Role_Id` int(11) UNSIGNED NOT NULL,
  `Note_Id` int(11) UNSIGNED NOT NULL,
  `User_Type` varchar(16) NOT NULL,
  `Dob` datetime DEFAULT NULL,
  `Gender` int(10) UNSIGNED DEFAULT NULL,
  `Phone_No_Country_Code` int(10) UNSIGNED NOT NULL,
  `Phone_No` varchar(20) NOT NULL,
  `Profile_Pic` varchar(500) DEFAULT NULL,
  `Secondary_Email` varchar(100) DEFAULT NULL,
  `Address_1` varchar(100) NOT NULL,
  `Address_2` varchar(100) NOT NULL,
  `City` varchar(50) NOT NULL,
  `State` varchar(50) NOT NULL,
  `Zip_Code` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `University` varchar(100) DEFAULT NULL,
  `College` varchar(100) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `CreatedBy` int(11) DEFAULT NULL,
  `ModifiedDate` datetime DEFAULT NULL,
  `ModifiedBy` int(11) DEFAULT NULL,
  `IsActive` bit(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `country`
--
ALTER TABLE `country`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `downloads`
--
ALTER TABLE `downloads`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `downloads_ibfk_1` (`NoteID`),
  ADD KEY `SellerID` (`SellerID`),
  ADD KEY `DownloaderID` (`DownloaderID`);

--
-- Indexes for table `notes`
--
ALTER TABLE `notes`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `SellerID` (`SellerID`),
  ADD KEY `Status` (`Status`),
  ADD KEY `Actioned_By` (`Actioned_By`),
  ADD KEY `Category` (`Category`),
  ADD KEY `Note_types` (`Note_types`),
  ADD KEY `Country` (`Country`),
  ADD KEY `Is_Paid` (`Is_Paid`);

--
-- Indexes for table `notesattachment`
--
ALTER TABLE `notesattachment`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Note_ID` (`Note_ID`);

--
-- Indexes for table `referencedata`
--
ALTER TABLE `referencedata`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `againstDownloadID` (`againstDownloadID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `NoteID` (`NoteID`);

--
-- Indexes for table `review_rating`
--
ALTER TABLE `review_rating`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `NoteID` (`NoteID`),
  ADD KEY `againstdownloadID` (`againstdownloadID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `system_configuration`
--
ALTER TABLE `system_configuration`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `userroles`
--
ALTER TABLE `userroles`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `EmailID` (`EmailID`),
  ADD KEY `RoleID` (`RoleID`);

--
-- Indexes for table `users-details`
--
ALTER TABLE `users-details`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Role_Id` (`Role_Id`),
  ADD KEY `Note_Id` (`Note_Id`),
  ADD KEY `Phone_No_Country_Code` (`Phone_No_Country_Code`),
  ADD KEY `Gender` (`Gender`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `country`
--
ALTER TABLE `country`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `downloads`
--
ALTER TABLE `downloads`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notes`
--
ALTER TABLE `notes`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `notesattachment`
--
ALTER TABLE `notesattachment`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `referencedata`
--
ALTER TABLE `referencedata`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_rating`
--
ALTER TABLE `review_rating`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_configuration`
--
ALTER TABLE `system_configuration`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `userroles`
--
ALTER TABLE `userroles`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `users-details`
--
ALTER TABLE `users-details`
  MODIFY `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `downloads`
--
ALTER TABLE `downloads`
  ADD CONSTRAINT `downloads_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `notes` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `downloads_ibfk_2` FOREIGN KEY (`SellerID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `downloads_ibfk_3` FOREIGN KEY (`DownloaderID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `notes`
--
ALTER TABLE `notes`
  ADD CONSTRAINT `notes_ibfk_1` FOREIGN KEY (`SellerID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `notes_ibfk_2` FOREIGN KEY (`Status`) REFERENCES `referencedata` (`ID`),
  ADD CONSTRAINT `notes_ibfk_3` FOREIGN KEY (`Actioned_By`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `notes_ibfk_4` FOREIGN KEY (`Category`) REFERENCES `category` (`ID`),
  ADD CONSTRAINT `notes_ibfk_5` FOREIGN KEY (`Note_types`) REFERENCES `type` (`ID`),
  ADD CONSTRAINT `notes_ibfk_6` FOREIGN KEY (`Country`) REFERENCES `country` (`ID`),
  ADD CONSTRAINT `notes_ibfk_7` FOREIGN KEY (`Is_Paid`) REFERENCES `referencedata` (`ID`);

--
-- Constraints for table `notesattachment`
--
ALTER TABLE `notesattachment`
  ADD CONSTRAINT `notesattachment_ibfk_1` FOREIGN KEY (`Note_ID`) REFERENCES `notes` (`ID`);

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`againstDownloadID`) REFERENCES `downloads` (`ID`),
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`NoteID`) REFERENCES `notes` (`ID`);

--
-- Constraints for table `review_rating`
--
ALTER TABLE `review_rating`
  ADD CONSTRAINT `review_rating_ibfk_1` FOREIGN KEY (`NoteID`) REFERENCES `notes` (`ID`),
  ADD CONSTRAINT `review_rating_ibfk_2` FOREIGN KEY (`againstdownloadID`) REFERENCES `downloads` (`ID`),
  ADD CONSTRAINT `review_rating_ibfk_3` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `userroles` (`ID`);

--
-- Constraints for table `users-details`
--
ALTER TABLE `users-details`
  ADD CONSTRAINT `users-details_ibfk_1` FOREIGN KEY (`Role_Id`) REFERENCES `userroles` (`ID`),
  ADD CONSTRAINT `users-details_ibfk_2` FOREIGN KEY (`Note_Id`) REFERENCES `notes` (`ID`),
  ADD CONSTRAINT `users-details_ibfk_3` FOREIGN KEY (`Phone_No_Country_Code`) REFERENCES `country` (`ID`),
  ADD CONSTRAINT `users-details_ibfk_4` FOREIGN KEY (`Gender`) REFERENCES `referencedata` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
