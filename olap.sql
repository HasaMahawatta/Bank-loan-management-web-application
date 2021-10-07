-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2016 at 02:53 AM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `olap`
--

-- --------------------------------------------------------

--
-- Table structure for table `access_controllers`
--

CREATE TABLE IF NOT EXISTS `access_controllers` (
`ID` int(10) NOT NULL,
  `Contoller_ID` int(11) NOT NULL,
  `Controller_Name` varchar(200) NOT NULL,
  `Action` varchar(200) DEFAULT NULL,
  `Status` varchar(100) NOT NULL,
  `Display_Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=184 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_controllers`
--

INSERT INTO `access_controllers` (`ID`, `Contoller_ID`, `Controller_Name`, `Action`, `Status`, `Display_Name`) VALUES
(161, 1, 'accesscontrolactions', NULL, '', 'Access Controlactions'),
(162, 2, 'Access Controllers', NULL, '', ''),
(163, 3, 'Access Permission', NULL, '', ''),
(164, 4, 'approvalorganization', NULL, '', 'Approval Organization'),
(165, 5, 'areasituation', NULL, '', 'Area Situation'),
(166, 6, 'attractionpointtype', NULL, '', 'Attraction Point Type'),
(167, 7, 'city', NULL, '', 'City'),
(168, 8, 'competitor', NULL, '', 'Competitor'),
(169, 9, 'cultivationtreetype', NULL, '', 'Cultivation Tree Type'),
(170, 10, 'district', NULL, '', 'District'),
(171, 11, 'introducer', NULL, '', 'Introducer'),
(172, 12, 'landitem', NULL, '', 'Land Item'),
(173, 13, 'landoccupiedby', NULL, '', 'Land Occupied By'),
(174, 14, 'landtopology', NULL, '', 'Land Topology'),
(175, 15, 'madistricts', NULL, '', 'Districts'),
(176, 16, 'malocation', NULL, '', 'Location'),
(177, 17, 'project', NULL, '', 'Project'),
(178, 18, 'province', NULL, '', 'Province'),
(179, 19, 'publiclocationcategory', NULL, '', 'Public Location Category'),
(180, 20, 'publiclocation', NULL, '', 'Public Location'),
(181, 21, 'roles', NULL, '', 'Roles'),
(182, 22, 'site', NULL, '', 'Site'),
(183, 23, 'targetclass', NULL, '', 'Target Class');

-- --------------------------------------------------------

--
-- Table structure for table `access_control_actions`
--

CREATE TABLE IF NOT EXISTS `access_control_actions` (
`action_id` int(11) NOT NULL,
  `action_name` varchar(100) NOT NULL,
  `controller_Id` int(11) NOT NULL,
  `Action_Display_Name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1752 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_control_actions`
--

INSERT INTO `access_control_actions` (`action_id`, `action_name`, `controller_Id`, `Action_Display_Name`) VALUES
(1577, 'View', 161, NULL),
(1578, 'Create', 161, NULL),
(1579, 'Update', 161, NULL),
(1580, 'Delete', 161, NULL),
(1581, 'Index', 161, NULL),
(1582, 'Admin', 161, NULL),
(1583, 'ActionName', 161, NULL),
(1584, 'ActionDisplayName', 161, NULL),
(1586, 'View', 162, NULL),
(1587, 'Create', 162, NULL),
(1588, 'Update', 162, NULL),
(1589, 'Delete', 162, NULL),
(1590, 'Index', 162, NULL),
(1591, 'Admin', 162, NULL),
(1592, 'Assignpermission', 162, NULL),
(1593, 'DynamicDsDivisions', 162, NULL),
(1594, 'DynamicGnDivisions', 162, NULL),
(1595, 'getCreatetable', 162, NULL),
(1596, 'AccessControl', 162, NULL),
(1597, 'DisplayName', 162, NULL),
(1599, 'Index', 163, NULL),
(1600, 'Accesscontrol', 163, NULL),
(1601, 'Access', 163, NULL),
(1602, 'Controller', 163, NULL),
(1604, 'View', 164, NULL),
(1605, 'Create', 164, NULL),
(1606, 'Update', 164, NULL),
(1607, 'Delete', 164, NULL),
(1608, 'Index', 164, NULL),
(1609, 'Admin', 164, NULL),
(1611, 'View', 165, NULL),
(1612, 'Create', 165, NULL),
(1613, 'Update', 165, NULL),
(1614, 'Delete', 165, NULL),
(1615, 'Index', 165, NULL),
(1616, 'Admin', 165, NULL),
(1618, 'View', 166, NULL),
(1619, 'Create', 166, NULL),
(1620, 'Update', 166, NULL),
(1621, 'Delete', 166, NULL),
(1622, 'Index', 166, NULL),
(1623, 'Admin', 166, NULL),
(1625, 'View', 167, NULL),
(1626, 'Create', 167, NULL),
(1627, 'Update', 167, NULL),
(1628, 'Delete', 167, NULL),
(1629, 'Index', 167, NULL),
(1630, 'Admin', 167, NULL),
(1631, 'AjaxCities', 167, NULL),
(1632, 'AjaxCitiesCoordinates', 167, NULL),
(1634, 'View', 168, NULL),
(1635, 'Create', 168, NULL),
(1636, 'Update', 168, NULL),
(1637, 'Delete', 168, NULL),
(1638, 'Index', 168, NULL),
(1639, 'Admin', 168, NULL),
(1641, 'View', 169, NULL),
(1642, 'Create', 169, NULL),
(1643, 'Update', 169, NULL),
(1644, 'Delete', 169, NULL),
(1645, 'Index', 169, NULL),
(1646, 'Admin', 169, NULL),
(1648, 'View', 170, NULL),
(1649, 'Create', 170, NULL),
(1650, 'Update', 170, NULL),
(1651, 'Delete', 170, NULL),
(1652, 'Index', 170, NULL),
(1653, 'Admin', 170, NULL),
(1654, 'AjaxDistrict', 170, NULL),
(1656, 'View', 171, NULL),
(1657, 'Create', 171, NULL),
(1658, 'Update', 171, NULL),
(1659, 'Delete', 171, NULL),
(1660, 'Index', 171, NULL),
(1661, 'Admin', 171, NULL),
(1663, 'View', 172, NULL),
(1664, 'Create', 172, NULL),
(1665, 'Update', 172, NULL),
(1666, 'Delete', 172, NULL),
(1667, 'Index', 172, NULL),
(1668, 'Admin', 172, NULL),
(1670, 'View', 173, NULL),
(1671, 'Create', 173, NULL),
(1672, 'Update', 173, NULL),
(1673, 'Delete', 173, NULL),
(1674, 'Index', 173, NULL),
(1675, 'Admin', 173, NULL),
(1677, 'View', 174, NULL),
(1678, 'Create', 174, NULL),
(1679, 'Update', 174, NULL),
(1680, 'Delete', 174, NULL),
(1681, 'Index', 174, NULL),
(1682, 'Admin', 174, NULL),
(1684, 'Index', 175, NULL),
(1686, 'Index', 176, NULL),
(1687, 'DynamicLocation', 176, NULL),
(1689, 'View', 177, NULL),
(1690, 'section1', 177, NULL),
(1691, 'section2', 177, NULL),
(1692, 'section3', 177, NULL),
(1693, 'section4', 177, NULL),
(1694, 'section5', 177, NULL),
(1695, 'section6', 177, NULL),
(1696, 'section7', 177, NULL),
(1697, 'section8', 177, NULL),
(1698, 'section9', 177, NULL),
(1699, 'Update', 177, NULL),
(1700, 'Delete', 177, NULL),
(1701, 'Index', 177, NULL),
(1702, 'Admin', 177, NULL),
(1703, 'AjaxSection3Table', 177, NULL),
(1704, 'AjaxSection4Preferences', 177, NULL),
(1705, 'AjaxSection7Information', 177, NULL),
(1706, 'AjaxSection2NearestTowns', 177, NULL),
(1707, 'AjaxSection2Transport', 177, NULL),
(1708, 'AjaxSetion2PubLocs', 177, NULL),
(1709, 'AjaxSetion1Competitor', 177, NULL),
(1711, 'View', 178, NULL),
(1712, 'Create', 178, NULL),
(1713, 'Update', 178, NULL),
(1714, 'Delete', 178, NULL),
(1715, 'Index', 178, NULL),
(1716, 'Admin', 178, NULL),
(1718, 'View', 179, NULL),
(1719, 'Create', 179, NULL),
(1720, 'Update', 179, NULL),
(1721, 'Delete', 179, NULL),
(1722, 'Index', 179, NULL),
(1723, 'Admin', 179, NULL),
(1725, 'View', 180, NULL),
(1726, 'Create', 180, NULL),
(1727, 'Update', 180, NULL),
(1728, 'Delete', 180, NULL),
(1729, 'Index', 180, NULL),
(1730, 'Admin', 180, NULL),
(1732, 'View', 181, NULL),
(1733, 'Create', 181, NULL),
(1734, 'Update', 181, NULL),
(1735, 'Delete', 181, NULL),
(1736, 'Index', 181, NULL),
(1737, 'Admin', 181, NULL),
(1740, 'Index', 182, NULL),
(1741, 'Config', 182, NULL),
(1742, 'Error', 182, NULL),
(1743, 'Contact', 182, NULL),
(1744, 'Login', 182, NULL),
(1745, 'Logout', 182, NULL),
(1746, 'View', 183, NULL),
(1747, 'Create', 183, NULL),
(1748, 'Update', 183, NULL),
(1749, 'Delete', 183, NULL),
(1750, 'Index', 183, NULL),
(1751, 'Admin', 183, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `access_user_roll`
--

CREATE TABLE IF NOT EXISTS `access_user_roll` (
`ID` int(10) NOT NULL,
  `role_code` int(10) NOT NULL,
  `Contoller_ID` int(10) NOT NULL,
  `action_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `access_user_roll`
--

INSERT INTO `access_user_roll` (`ID`, `role_code`, `Contoller_ID`, `action_id`) VALUES
(1, 13, 177, 1689);

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
`questionId` int(11) NOT NULL,
  `question` varchar(512) NOT NULL,
  `loanType` int(11) DEFAULT NULL,
  `common` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
`rolecode` int(11) NOT NULL,
  `role` varchar(25) NOT NULL,
  `read_only` int(11) NOT NULL,
  `super_access` int(11) NOT NULL,
  `last_update_date` date DEFAULT NULL,
  `last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`rolecode`, `role`, `read_only`, `super_access`, `last_update_date`, `last_update_by`) VALUES
(13, 'Admin', 0, 0, '2015-12-17', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
`id` int(11) NOT NULL,
  `category` varchar(64) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `category`, `key`, `value`) VALUES
(1, 'landItem', 'hightension', 's:1:"2";'),
(3, 'landItem', 'telcommtow', 's:1:"3";'),
(4, 'landItem', 'tapwater', 's:1:"4";');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
`user_id` int(11) NOT NULL,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  `last_update_date` datetime DEFAULT NULL,
  `last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`user_id`, `lastname`, `firstname`, `last_update_date`, `last_update_by`) VALUES
(1, 'Dissanayake', 'Sajith', NULL, NULL),
(2, 'Perera', 'Wasantha', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
`id` int(10) NOT NULL,
  `varname` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `field_type` varchar(50) NOT NULL,
  `field_size` varchar(15) NOT NULL DEFAULT '0',
  `field_size_min` varchar(15) NOT NULL DEFAULT '0',
  `required` int(1) NOT NULL DEFAULT '0',
  `match` varchar(255) NOT NULL DEFAULT '',
  `range` varchar(255) NOT NULL DEFAULT '',
  `error_message` varchar(255) NOT NULL DEFAULT '',
  `other_validator` varchar(5000) NOT NULL DEFAULT '',
  `default` varchar(255) NOT NULL DEFAULT '',
  `widget` varchar(255) NOT NULL DEFAULT '',
  `widgetparams` varchar(5000) NOT NULL DEFAULT '',
  `position` int(3) NOT NULL DEFAULT '0',
  `visible` int(1) NOT NULL DEFAULT '0',
  `last_update_date` datetime DEFAULT NULL,
  `last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_profiles_fields`
--

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`, `last_update_date`, `last_update_by`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3, NULL, NULL),
(2, 'firstname', 'First Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE IF NOT EXISTS `tbl_settings` (
`id` int(11) NOT NULL,
  `category` varchar(64) NOT NULL DEFAULT 'system',
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
`id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `role_code` int(3) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(80) NOT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `last_update_by` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`, `role_code`, `first_name`, `last_name`, `last_update_date`, `last_update_by`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'webmaster@example.com', '1b810cd6364a9592c19f7dda9e6feb78', '2014-10-27 10:52:01', '2016-08-30 03:51:23', 1, 1, 1, 'Sajith', 'Hettiarachchi', '2016-08-30 09:21:23', 1),
(2, 'demo', 'e10adc3949ba59abbe56e057f20f883e', 'demo@example.com', 'e465aefe34ea544f3c79204540ada1bc', '2014-10-27 10:52:01', '0000-00-00 00:00:00', 0, 1, 1, 'Saman', 'Fernando', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access_controllers`
--
ALTER TABLE `access_controllers`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `access_control_actions`
--
ALTER TABLE `access_control_actions`
 ADD PRIMARY KEY (`action_id`), ADD KEY `controller_Id` (`controller_Id`);

--
-- Indexes for table `access_user_roll`
--
ALTER TABLE `access_user_roll`
 ADD PRIMARY KEY (`ID`), ADD KEY `Role_ID` (`role_code`,`Contoller_ID`), ADD KEY `Contoller_ID` (`Contoller_ID`), ADD KEY `action_id` (`action_id`);

--
-- Indexes for table `question`
--
ALTER TABLE `question`
 ADD PRIMARY KEY (`questionId`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
 ADD PRIMARY KEY (`rolecode`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
 ADD PRIMARY KEY (`id`), ADD KEY `category_key` (`category`,`key`);

--
-- Indexes for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_profiles_fields`
--
ALTER TABLE `tbl_profiles_fields`
 ADD PRIMARY KEY (`id`), ADD KEY `varname` (`varname`,`widget`,`visible`);

--
-- Indexes for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
 ADD PRIMARY KEY (`id`), ADD KEY `category_key` (`category`,`key`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD KEY `status` (`status`), ADD KEY `superuser` (`superuser`), ADD KEY `role_code` (`role_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access_controllers`
--
ALTER TABLE `access_controllers`
MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=184;
--
-- AUTO_INCREMENT for table `access_control_actions`
--
ALTER TABLE `access_control_actions`
MODIFY `action_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1752;
--
-- AUTO_INCREMENT for table `access_user_roll`
--
ALTER TABLE `access_user_roll`
MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `question`
--
ALTER TABLE `question`
MODIFY `questionId` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `rolecode` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_profiles_fields`
--
ALTER TABLE `tbl_profiles_fields`
MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `tbl_settings`
--
ALTER TABLE `tbl_settings`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `access_control_actions`
--
ALTER TABLE `access_control_actions`
ADD CONSTRAINT `access_control_actions_ibfk_1` FOREIGN KEY (`controller_Id`) REFERENCES `access_controllers` (`ID`);

--
-- Constraints for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
ADD CONSTRAINT `tbl_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
