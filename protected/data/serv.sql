-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2014 at 02:34 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `serv`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_code` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` text NOT NULL,
  PRIMARY KEY (`category_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_code`, `category_name`) VALUES
(3, 'Vehicles Service Center'),
(4, 'Hospital and Healthcare '),
(5, 'Photography'),
(7, 'Wine and Dine'),
(8, 'Vehicle Garage'),
(14, 'Education Institute'),
(15, 'Events'),
(16, 'Places to Visit'),
(17, 'Saloon and Beauty Center'),
(18, 'Wedding Hall');

-- --------------------------------------------------------

--
-- Table structure for table `ma_districts`
--

CREATE TABLE IF NOT EXISTS `ma_districts` (
  `districts_code` int(2) DEFAULT NULL,
  `district_name` varchar(12) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ma_districts`
--

INSERT INTO `ma_districts` (`districts_code`, `district_name`) VALUES
(1, 'Ampara'),
(2, 'Anuradhapura'),
(3, 'Badulla'),
(4, 'Batticaloa'),
(5, 'Colombo'),
(6, 'Galle'),
(7, 'Gampaha'),
(8, 'Hambantota'),
(9, 'Jaffna'),
(10, 'Kalutara'),
(11, 'Kandy'),
(12, 'Kegalle '),
(13, 'Kilinochchi'),
(14, 'Kurunegala '),
(15, 'Mannar'),
(16, 'Matale'),
(17, 'Matara'),
(18, 'Moneragala'),
(19, 'Mullaitivu'),
(20, 'Nuwara Eliya'),
(21, 'Polonnaruwa'),
(22, 'Puttalam'),
(23, 'Ratnapura'),
(24, 'Trincomalee'),
(25, 'Vavuniya');

-- --------------------------------------------------------

--
-- Table structure for table `ma_location`
--

CREATE TABLE IF NOT EXISTS `ma_location` (
  `districts_code` int(1) DEFAULT NULL,
  `location_code` int(3) DEFAULT NULL,
  `location_name` varchar(25) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ma_location`
--

INSERT INTO `ma_location` (`districts_code`, `location_code`, `location_name`) VALUES
(5, 1, 'Akarawita'),
(5, 2, 'Akuregoda'),
(5, 3, 'Angoda'),
(5, 4, 'Athurugiriya'),
(5, 5, 'Avissawella'),
(5, 6, 'Batawala'),
(5, 7, 'Battaramulla'),
(5, 8, 'Batugampola'),
(5, 9, 'Bellanwila'),
(5, 10, 'Bokundara'),
(5, 11, 'Bope'),
(5, 12, 'Boralesgamuwa'),
(5, 13, 'Colombo 1'),
(5, 14, 'Colombo 2'),
(5, 15, 'Colombo 3'),
(5, 16, 'Colombo 4'),
(5, 17, 'Colombo 5'),
(5, 18, 'Colombo 6'),
(5, 19, 'Colombo 7'),
(5, 20, 'Colombo 8'),
(5, 21, 'Colombo 9'),
(5, 22, 'Colombo 10'),
(5, 23, 'Colombo 11'),
(5, 24, 'Colombo 12'),
(5, 25, 'Colombo 13'),
(5, 26, 'Colombo 14'),
(5, 27, 'Colombo 15'),
(5, 28, 'Dedigamuwa'),
(5, 29, 'Dehiwala'),
(5, 30, 'Deltara'),
(5, 31, 'Ethul Kotte'),
(5, 32, 'Gangodawilla'),
(5, 33, 'Godagama'),
(5, 34, 'Gonapola'),
(5, 35, 'Gothatuwa'),
(5, 36, 'Habarakada'),
(5, 37, 'Handapangoda'),
(5, 38, 'Hanwella'),
(5, 39, 'Hewainna'),
(5, 40, 'Hiripitya'),
(5, 41, 'Hokandara'),
(5, 42, 'Homagama'),
(5, 43, 'Horagala'),
(5, 44, 'Ingiriya'),
(5, 45, 'Jalthara'),
(5, 46, 'Kaduwela'),
(5, 47, 'Kahathuduwa'),
(5, 48, 'Kahawala'),
(5, 49, 'Kalatuwawa'),
(5, 50, 'Kaluaggala'),
(5, 51, 'Kalubowila'),
(5, 52, 'Katubedda'),
(5, 53, 'Kelaniya'),
(5, 54, 'Kesbewa'),
(5, 55, 'Kiriwattuduwa'),
(5, 56, 'Kohuwala'),
(5, 57, 'Kolonnawa'),
(5, 58, 'Kosgama'),
(5, 59, 'Koswatta'),
(5, 60, 'Kotikawatta'),
(5, 61, 'Kottawa'),
(5, 62, 'Kotte'),
(5, 63, 'Madapatha'),
(5, 64, 'Madiwela'),
(5, 65, 'Maharagama'),
(5, 66, 'Malabe'),
(5, 67, 'Maradana'),
(5, 68, 'Mattegoda'),
(5, 69, 'Meegoda'),
(5, 70, 'Meepe'),
(5, 71, 'Mirihana'),
(5, 72, 'Moragahahena'),
(5, 73, 'Moraketiya'),
(5, 74, 'Moratuwa'),
(5, 75, 'Mount Lavinia'),
(5, 76, 'Mullegama'),
(5, 77, 'Mulleriyawa'),
(5, 78, 'Napawela'),
(5, 79, 'Navagamuwa'),
(5, 80, 'Nawala'),
(5, 81, 'Nugegoda'),
(5, 82, 'Padukka'),
(5, 83, 'Pannipitiya'),
(5, 84, 'Pelawatta'),
(5, 85, 'Peliyagoda'),
(5, 86, 'Pepiliyana'),
(5, 87, 'Piliyandala'),
(5, 88, 'Pita Kotte'),
(5, 89, 'Pitipana Homagama'),
(5, 90, 'Polgasowita'),
(5, 91, 'Puwakpitiya'),
(5, 92, 'Rajagiriya'),
(5, 93, 'Ranala'),
(5, 94, 'Ratmalana'),
(5, 95, 'Siddamulla'),
(5, 96, 'Sri Jayawardenapura Kotte'),
(5, 97, 'Talawatugoda'),
(5, 98, 'Thalapathpitiya'),
(5, 99, 'Thimbirigasyaya'),
(5, 100, 'Thummodara'),
(5, 101, 'Waga'),
(5, 102, 'Watareka'),
(5, 103, 'Weliwita'),
(5, 104, 'Wellampitiya'),
(5, 105, 'Wellawatte');

-- --------------------------------------------------------

--
-- Table structure for table `option`
--

CREATE TABLE IF NOT EXISTS `option` (
  `option_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_profile_code` int(11) NOT NULL,
  `header` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `option`
--

INSERT INTO `option` (`option_id`, `provider_profile_code`, `header`, `description`) VALUES
(1, 3, 'Nuwan Herath', 'Perched on the summit guests are treated to bird’s eye 360o view of the lush green environs. Though Kithul Kanda is conveniently located only about half hour from Colombo, it is situated in a village where guests can enjoy the full benefit of a local village atmosphere.'),
(2, 3, 'Saman Samathunga', 'The colonial era in Ceylon saw this tea estate being larger in extent, owned and managed by a Britisher and famously known as the ‘Southerland tea estate’. Estate ownership eventually moved to the UHE Group and was renamed ‘Uva Greenlands’.');

-- --------------------------------------------------------

--
-- Table structure for table `photofolio`
--

CREATE TABLE IF NOT EXISTS `photofolio` (
  `photofolio_cod` int(11) NOT NULL AUTO_INCREMENT,
  `header` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `option_id` int(11) NOT NULL,
  PRIMARY KEY (`photofolio_cod`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `photofolio`
--

INSERT INTO `photofolio` (`photofolio_cod`, `header`, `description`, `option_id`) VALUES
(1, 'Weeding', 'We at Paradise Beach Hotel are committed to ensure that our guests have the most memorable holiday of their life time in Sri Lanka', 1);

-- --------------------------------------------------------

--
-- Table structure for table `provider_profile`
--

CREATE TABLE IF NOT EXISTS `provider_profile` (
  `provider_profile_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `districts_code` int(11) NOT NULL,
  `location_code` int(11) NOT NULL,
  `phone_no` varchar(20) NOT NULL,
  `name` varchar(200) NOT NULL,
  `category_code` int(11) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `address` varchar(200) DEFAULT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  `scheduling` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`provider_profile_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `provider_profile`
--

INSERT INTO `provider_profile` (`provider_profile_code`, `id`, `districts_code`, `location_code`, `phone_no`, `name`, `category_code`, `description`, `address`, `latitude`, `longitude`, `scheduling`) VALUES
(1, 3, 5, 1, '+9412588588', 'Budget Taxi', 3, '', 'No. 91 1/7 Galle Road, Colombo 4, Sri Lanka.', '6.924778', '79.887336', 0),
(2, 2, 5, 3, '0115289289', ' KANGAROO CABS', 3, '', 'No. 91 1/7 Galle Road, Colombo 4, Sri Lanka.', '6.897341', '79.856780', 1),
(3, 1, 5, 3, '0115289289', 'Nuwan Herath', 5, '', 'No. 91 1/7 Galle Road, Colombo 4, Sri Lanka.', '6.897341', '79.856780', 1);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `rolecode` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(25) NOT NULL,
  PRIMARY KEY (`rolecode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `roles`
--


-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE IF NOT EXISTS `sub_categories` (
  `sub_category_code` int(11) NOT NULL,
  `category_code` int(11) NOT NULL,
  `sub_category` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sub_categories`
--


-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`user_id`, `lastname`, `firstname`) VALUES
(1, 'Admin', 'Administrator'),
(2, 'Demo', 'Demo'),
(3, 'Dananjaya', 'hasitha');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles_fields`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles_fields` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
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
  PRIMARY KEY (`id`),
  KEY `varname` (`varname`,`widget`,`visible`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_profiles_fields`
--

INSERT INTO `tbl_profiles_fields` (`id`, `varname`, `title`, `field_type`, `field_size`, `field_size_min`, `required`, `match`, `range`, `error_message`, `other_validator`, `default`, `widget`, `widgetparams`, `position`, `visible`) VALUES
(1, 'lastname', 'Last Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect Last Name (length between 3 and 50 characters).', '', '', '', '', 1, 3),
(2, 'firstname', 'First Name', 'VARCHAR', '50', '3', 1, '', '', 'Incorrect First Name (length between 3 and 50 characters).', '', '', '', '', 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`, `type`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', '9a24eff8c15a6a141ece27eb6947da0f', '2014-10-27 16:22:01', '0000-00-00 00:00:00', 1, 1, 0),
(2, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', '099f825543f7850cc038b90aaff39fac', '2014-10-27 16:22:01', '0000-00-00 00:00:00', 0, 1, 1),
(3, 'hasitha', 'e10adc3949ba59abbe56e057f20f883e', '8f1023b166589a998ecbe8ef959e892a', '2014-10-30 04:00:51', '0000-00-00 00:00:00', 0, 0, 0);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;
