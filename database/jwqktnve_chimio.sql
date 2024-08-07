-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 27, 2022 at 09:46 AM
-- Server version: 5.7.38-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jwqktnve_chimio`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(200) NOT NULL,
  `creator` varchar(200) DEFAULT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `name`, `username`, `password`, `type`, `creator`, `created`) VALUES
(1, 'admin', 'admin', '$2y$10$WcBfKcZZ7vOAbUhioIJUauNwzzQkQq687oC25aDOkNOAZEHm0RnDy', 'super', '', '2017-01-30 00:00:00'),
(2, 'Styve', 'stivisty', '$2y$10$7OxMIxd1ZuqwjklUA6KMW.FHiRuydFc/wY.DlcO1y1VLSb5P8.jkK', 'super', NULL, '2022-05-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `a_lookup`
--

CREATE TABLE `a_lookup` (
  `nLookUpId` bigint(20) NOT NULL,
  `vLookUpName` varchar(100) NOT NULL DEFAULT '',
  `vLookUpValue` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `a_lookup`
--

INSERT INTO `a_lookup` (`nLookUpId`, `vLookUpName`, `vLookUpValue`) VALUES
(1, 'country_site', 'Burundi'),
(2, 'name_site', 'CHIMIO'),
(3, 'url_site', 'http://chimio.bi'),
(4, 'company_name', 'CHIMIO'),
(5, 'company_address', 'Bujumbura'),
(6, 'admin_name', 'CHIMIO'),
(7, 'admin_email', 'info@chimio.bi'),
(8, 'admin_signature', 'Chimio'),
(9, 'staff_site', 'info@chimio.bi'),
(10, 'phone_site', '+25779092015'),
(11, 'currency_site', 'BIF'),
(12, 'tva_site', '0'),
(13, 'logo_site', 'images/logo/16062022_094637pm.png'),
(14, 'email_password', 'password'),
(15, 'terms_conditions', '&lt;p&gt;Put here your terms and conditions&lt;/p&gt;\r\n'),
(16, 'lang', 'FR'),
(17, 'discount', ''),
(18, 'policy_privacy', '&lt;p&gt;Put here the policy privacy&lt;/p&gt;\r\n'),
(19, 'access_token', ''),
(20, 'app_id', '<br /><b>Notice</b>:  Undefined variable: app_id in <b>/home/zpertcvu/public_html/akabanga/settings/index_page.php</b> on line <b>170</b><br />'),
(21, 'app_secret', '');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `item` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `signature` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL,
  `creator` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `item`, `file_name`, `status`, `signature`, `created`, `creator`) VALUES
(1, 'invoice_20211230', 'invoice_16062022_093811pm.xml', 1, '44d3d64d-990f-4417-a536-2163179a127c-0003673f', '2022-06-16 23:38:11', 'admin'),
(2, 'invoice_20211231', 'invoice_16062022_114507pm.xml', 1, '4000061905/ws400006190500013/20220616234508/19310', '2022-06-17 01:45:07', 'admin'),
(6, '19-06-022 09:22', 'invoice_17062022_072350am.xml', 1, '4000061905/ws400006190500013/20220627221727/7365', '2022-06-17 09:23:50', 'admin'),
(7, '19-06-022 09:26', 'invoice_17062022_072648am.xml', 1, '4000061905/ws400006190500013/20220617072648/7366', '2022-06-17 09:26:48', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
