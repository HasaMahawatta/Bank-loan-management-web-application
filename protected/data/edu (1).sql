-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 26, 2015 at 09:30 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `edu`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `account_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `count` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `promotions_code` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`account_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=94 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_code`, `id`, `date`, `count`, `type`, `promotions_code`) VALUES
(25, 34, '2015-02-25 12:58:56', 5, 2, 3),
(26, 34, '2015-02-25 13:33:13', 1, 3, 30),
(27, 27, '2015-02-25 16:37:03', 5, 2, 3),
(28, 27, '2015-02-25 16:46:02', 1, 3, 31),
(29, 36, '2015-02-25 16:48:49', 5, 2, 3),
(30, 37, '2015-02-25 17:23:15', 5, 2, 3),
(31, 38, '2015-02-26 10:40:56', 5, 2, 3),
(32, 39, '2015-02-26 10:42:36', 5, 2, 3),
(33, 39, '2015-02-26 11:04:38', 1, 3, 39),
(34, 38, '2015-02-26 11:43:27', 1, 3, 40),
(35, 1, '2015-02-27 11:19:29', 5, 2, 3),
(36, 40, '2015-02-27 11:34:41', 5, 2, 3),
(37, 44, '2015-03-01 12:31:47', 5, 2, 3),
(38, 45, '2015-03-02 08:41:09', 5, 2, 3),
(39, 31, '2015-03-02 09:27:40', 5, 2, 3),
(40, 50, '2015-03-02 14:30:03', 5, 2, 3),
(41, 38, '2015-03-02 17:13:45', 1, 3, 41),
(42, 40, '2015-03-02 20:53:42', 1, 3, 42),
(43, 40, '2015-03-05 10:41:07', 1, 3, 43),
(44, 40, '2015-03-05 10:41:31', 1, 3, 44),
(45, 40, '2015-03-05 10:42:04', 1, 3, 45),
(46, 40, '2015-03-05 13:27:49', 1, 3, 46),
(47, 38, '2015-03-05 22:33:14', 1, 3, 47),
(48, 31, '2015-03-07 08:13:03', 1, 3, 48),
(49, 31, '2015-03-07 08:16:43', 1, 3, 49),
(50, 38, '2015-03-07 08:32:55', 1, 3, 50),
(51, 38, '2015-03-07 09:05:26', 1, 3, 51),
(52, 72, '2015-03-10 11:42:18', 5, 2, 3),
(53, 73, '2015-03-10 11:43:30', 5, 2, 3),
(54, 74, '2015-03-10 12:39:27', 5, 2, 3),
(55, 71, '2015-03-10 12:51:44', 5, 2, 3),
(56, 38, '2015-03-10 14:38:23', 1, 3, 52),
(57, 75, '2015-03-10 22:09:27', 5, 2, 3),
(58, 76, '2015-03-10 22:10:52', 5, 2, 3),
(59, 76, '2015-03-10 23:11:39', 1, 3, 53),
(60, 77, '2015-03-10 23:18:53', 5, 2, 3),
(61, 78, '2015-03-11 00:39:10', 5, 2, 3),
(62, 79, '2015-03-11 11:15:17', 5, 2, 3),
(63, 80, '2015-03-11 12:59:04', 5, 2, 3),
(64, 81, '2015-03-11 13:07:59', 5, 2, 3),
(65, 82, '2015-03-11 18:36:57', 5, 2, 3),
(66, 83, '2015-03-11 18:53:01', 5, 2, 3),
(67, 84, '2015-03-11 20:55:42', 5, 2, 3),
(68, 85, '2015-03-11 22:07:59', 5, 2, 3),
(69, 86, '2015-03-11 22:16:24', 5, 2, 3),
(70, 87, '2015-03-11 22:41:54', 5, 2, 3),
(71, 88, '2015-03-12 01:43:43', 5, 2, 3),
(72, 89, '2015-03-12 07:49:53', 5, 2, 3),
(73, 90, '2015-03-13 22:11:38', 5, 2, 3),
(74, 91, '2015-03-16 17:41:39', 5, 2, 3),
(75, 92, '2015-03-16 17:49:17', 5, 2, 3),
(76, 93, '2015-03-16 18:43:16', 5, 2, 3),
(77, 94, '2015-03-17 08:33:35', 5, 2, 3),
(78, 95, '2015-03-17 10:31:22', 5, 2, 3),
(79, 96, '2015-03-17 14:34:54', 5, 2, 3),
(80, 97, '2015-03-18 21:50:44', 5, 2, 3),
(81, 98, '2015-03-19 08:37:35', 5, 2, 3),
(82, 99, '2015-03-19 08:46:01', 5, 2, 3),
(83, 100, '2015-03-19 11:17:31', 5, 2, 3),
(84, 101, '2015-03-19 11:26:59', 5, 2, 3),
(85, 102, '2015-03-19 17:39:52', 5, 2, 3),
(86, 103, '2015-03-20 10:29:16', 5, 2, 3),
(87, 104, '2015-03-20 20:13:50', 5, 2, 3),
(88, 105, '2015-03-21 18:26:08', 5, 2, 3),
(89, 106, '2015-03-25 09:01:26', 5, 2, 3),
(90, 107, '2015-04-02 11:45:19', 5, 2, 3),
(91, 108, '2015-04-02 12:49:15', 5, 2, 3),
(92, 109, '2015-04-06 23:58:40', 5, 2, 3),
(93, 111, '2015-04-11 23:47:23', 5, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `booking_no` int(8) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `id` int(100) DEFAULT NULL,
  `requested_date` datetime NOT NULL,
  `confirmed_date` datetime DEFAULT NULL,
  `cancel_by` varchar(50) NOT NULL,
  `cancel_date` datetime NOT NULL,
  `closed_by` int(50) NOT NULL,
  `closed_date` datetime NOT NULL,
  `schedule_code` int(11) NOT NULL,
  `comment` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `post_comment` varchar(100) NOT NULL,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `scheduled_time` time NOT NULL,
  PRIMARY KEY (`booking_no`),
  UNIQUE KEY `booking_no` (`booking_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `booking`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `category_code` int(2) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(24) DEFAULT NULL,
  `group_code` int(11) NOT NULL,
  PRIMARY KEY (`category_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_code`, `category_name`, `group_code`) VALUES
(20, 'Biology', 1),
(21, 'Chemistry', 1),
(22, 'Physics', 1),
(23, 'Pure Mathematics', 1),
(24, 'Applied Mathematics', 1),
(25, 'Economics', 2),
(26, 'Accounting', 2),
(27, 'Business studies', 2),
(28, 'Sinhala', 3),
(29, 'Logic', 3),
(30, 'Political Science', 3),
(31, 'Geography', 3),
(32, 'Buddhist Civilization', 3),
(33, 'English Literature', 3),
(34, 'Japanese', 3),
(35, 'History', 3),
(36, 'Drama', 3),
(37, 'History', 3),
(38, 'Drama', 3);

-- --------------------------------------------------------

--
-- Table structure for table `education_qualification`
--

CREATE TABLE IF NOT EXISTS `education_qualification` (
  `education_qualification_code` int(11) NOT NULL AUTO_INCREMENT,
  `education_qualification` varchar(200) NOT NULL,
  `description` varchar(600) NOT NULL,
  `year` int(11) NOT NULL,
  `institute` varchar(200) NOT NULL,
  `id` int(11) NOT NULL,
  PRIMARY KEY (`education_qualification_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `education_qualification`
--

INSERT INTO `education_qualification` (`education_qualification_code`, `education_qualification`, `description`, `year`, `institute`, `id`) VALUES
(2, 'GCE O/L', 'A6,B2,C1.S1', 2006, 'G/Battamulla National Collage ', 34),
(3, 'undergraduate of business Management ', 'Higher diploma in bussness management', 2011, 'NIBM', 27),
(4, 'BEng(hons) in Electronic Engineering(2nd upper) ', 'Graduated with a 2nd upper class ', 2014, 'Shiffield Hallam University (SLIIT) ', 45),
(5, 'Electronic Engineering ', 'B.Eng.(Hons) in Electronic Engineering Sheffield Hallam University', 2015, 'SLIIT', 46),
(6, 'BS.c Special Hons in IT ', 'Special Hons in IT (With IT related subjects)', 2006, 'Sri Lanka Institute of Information Technology - SLIIT', 50),
(7, 'BEng (Hons) in Electronic Engineering', 'Placed 1st in the batch with a 1st class', 2015, 'Sheffield Hallam University', 49),
(8, 'Electronic Enginering', 'Completed With 2nd lower class..', 2014, 'sri Lanka Institute of Information Tecnology', 52),
(9, 'B.Sc', 'second upper', 2015, 'SLIIT', 56),
(10, 'B.Eng(Hons)', 'Second Class', 2013, 'SLIIT', 61),
(11, 'SLIATE Higher National Diploma in IT (Academic & Training Completed )', 'Successfully Completed 6 month Training Period of Computer hardware and Networking in ICT Center, University of Kelaniya.\r\n\r\nFollowing CCNA 200-120 (1st Semester Completed)-IHRA University of Colombo.\r\n\r\nOracle Certified Professional, JAVA SE 6 Programmer.\r\n\r\nInternet & Email Practical Knowledge.\r\n\r\nPractical Computer Hardware Knowledge.\r\n\r\nG.C.E.(O/L) Examination(2002)\r\nIndex Number:-21965331\r\nA-8 B-2\r\n\r\nG.C.E.(A/L) Examination(2010)\r\nIndex Number:-5094135\r\nChemistry C\r\nBiology S\r\nPhysics S\r\nGeneral English S\r\nCommon General Test 072', 2012, 'Sri Lanka Institute of Advanced Technological Education (SLIATE)', 82),
(12, 'CISCO CCNA Qualified', 'Qualified', 2014, 'CISCO Networking Academy VTA, Sri Lanka', 89),
(13, 'National Diploma in Information and Communication Technology', 'Passed', 2014, 'National IT Center, Narahenpita', 89),
(14, 'Computer Hardware & Networking', 'CISCO A+ Qualified\r\n', 2013, 'Vocational Authority of Sri Lanka', 89);

-- --------------------------------------------------------

--
-- Table structure for table `email_list`
--

CREATE TABLE IF NOT EXISTS `email_list` (
  `email_list_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `list` text NOT NULL,
  PRIMARY KEY (`email_list_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `email_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `experience_to_profile`
--

CREATE TABLE IF NOT EXISTS `experience_to_profile` (
  `experience_to_profile_code` int(11) NOT NULL AUTO_INCREMENT,
  `occupations_to_profile_code` int(11) NOT NULL,
  `employer_code` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `description` varchar(500) NOT NULL,
  `position` varchar(200) NOT NULL,
  `organization` varchar(200) NOT NULL,
  PRIMARY KEY (`experience_to_profile_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `experience_to_profile`
--

INSERT INTO `experience_to_profile` (`experience_to_profile_code`, `occupations_to_profile_code`, `employer_code`, `start_date`, `end_date`, `description`, `position`, `organization`) VALUES
(2, 3, 0, '2009-01-01', '0000-00-00', '', 'Software Engineer', 'Sky Management Systems');

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE IF NOT EXISTS `group` (
  `group_code` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` text NOT NULL,
  `description` varchar(200) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `main_code` int(11) NOT NULL,
  PRIMARY KEY (`group_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `group`
--

INSERT INTO `group` (`group_code`, `group_name`, `description`, `icon`, `main_code`) VALUES
(1, 'Science Stream', 'Science stream consists of Biological science or Physical Science. In Biological Science stream you have to follow Biology, Chemistry and Physics (or Agriculture). Physical science stream includes Phy', 'icon-beaker', 1),
(2, 'Commerce Stream', 'Popular subjects in commerce stream consist of Economics, Business Studies and Accounting.', 'icon-money', 1),
(3, 'Arts Stream', 'In Arts stream students follow various subjects: Sinhala, Logic, Political Science, Geography, Buddhist Civilization, English Literature, Japanese, History and Drama.', 'icon-music', 1);

-- --------------------------------------------------------

--
-- Table structure for table `main`
--

CREATE TABLE IF NOT EXISTS `main` (
  `main_code` int(11) NOT NULL AUTO_INCREMENT,
  `main` varchar(500) NOT NULL,
  `orderby` int(11) NOT NULL,
  PRIMARY KEY (`main_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `main`
--

INSERT INTO `main` (`main_code`, `main`, `orderby`) VALUES
(1, 'Advanced Level (A/L)', 1),
(2, 'Ordinary Level (O/L)', 0),
(3, 'University', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ma_districts`
--

CREATE TABLE IF NOT EXISTS `ma_districts` (
  `districts_code` int(2) NOT NULL AUTO_INCREMENT,
  `district_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`districts_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

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
(25, 'Vavuniya'),
(0, 'All of Sri Lanka');

-- --------------------------------------------------------

--
-- Table structure for table `ma_location`
--

CREATE TABLE IF NOT EXISTS `ma_location` (
  `districts_code` int(2) DEFAULT NULL,
  `location_code` int(4) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(25) DEFAULT NULL,
  `latitude` varchar(10) DEFAULT NULL,
  `longitude` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`location_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1741 ;

--
-- Dumping data for table `ma_location`
--

INSERT INTO `ma_location` (`districts_code`, `location_code`, `location_name`, `latitude`, `longitude`) VALUES
(5, 1, 'Akarawita', NULL, NULL),
(5, 2, 'Akuregoda', NULL, NULL),
(5, 3, 'Angoda', NULL, NULL),
(5, 4, 'Athurugiriya', NULL, NULL),
(5, 5, 'Avissawella', NULL, NULL),
(5, 6, 'Batawala', NULL, NULL),
(5, 7, 'Battaramulla', NULL, NULL),
(5, 8, 'Batugampola', NULL, NULL),
(5, 9, 'Bellanwila', NULL, NULL),
(5, 10, 'Bokundara', NULL, NULL),
(5, 11, 'Bope', NULL, NULL),
(5, 12, 'Boralesgamuwa', NULL, NULL),
(5, 13, 'Colombo 1', NULL, NULL),
(5, 14, 'Colombo 2', NULL, NULL),
(5, 15, 'Colombo 3', NULL, NULL),
(5, 16, 'Colombo 4', NULL, NULL),
(5, 17, 'Colombo 5', NULL, NULL),
(5, 18, 'Colombo 6', NULL, NULL),
(5, 19, 'Colombo 7', NULL, NULL),
(5, 20, 'Colombo 8', NULL, NULL),
(5, 21, 'Colombo 9', NULL, NULL),
(5, 22, 'Colombo 10', NULL, NULL),
(5, 23, 'Colombo 11', NULL, NULL),
(5, 24, 'Colombo 12', NULL, NULL),
(5, 25, 'Colombo 13', NULL, NULL),
(5, 26, 'Colombo 14', NULL, NULL),
(5, 27, 'Colombo 15', NULL, NULL),
(5, 28, 'Dedigamuwa', NULL, NULL),
(5, 29, 'Dehiwala', NULL, NULL),
(5, 30, 'Deltara', NULL, NULL),
(5, 31, 'Ethul Kotte', NULL, NULL),
(5, 32, 'Gangodawilla', NULL, NULL),
(5, 33, 'Godagama', NULL, NULL),
(5, 34, 'Gonapola', NULL, NULL),
(5, 35, 'Gothatuwa', NULL, NULL),
(5, 36, 'Habarakada', NULL, NULL),
(5, 37, 'Handapangoda', NULL, NULL),
(5, 38, 'Hanwella', NULL, NULL),
(5, 39, 'Hewainna', NULL, NULL),
(5, 40, 'Hiripitya', NULL, NULL),
(5, 41, 'Hokandara', NULL, NULL),
(5, 42, 'Homagama', NULL, NULL),
(5, 43, 'Horagala', NULL, NULL),
(5, 44, 'Ingiriya', NULL, NULL),
(5, 45, 'Jalthara', NULL, NULL),
(5, 46, 'Kaduwela', NULL, NULL),
(5, 47, 'Kahathuduwa', NULL, NULL),
(5, 48, 'Kahawala', NULL, NULL),
(5, 49, 'Kalatuwawa', NULL, NULL),
(5, 50, 'Kaluaggala', NULL, NULL),
(5, 51, 'Kalubowila', NULL, NULL),
(5, 52, 'Katubedda', NULL, NULL),
(5, 53, 'Kelaniya', NULL, NULL),
(5, 54, 'Kesbewa', NULL, NULL),
(5, 55, 'Kiriwattuduwa', NULL, NULL),
(5, 56, 'Kohuwala', NULL, NULL),
(5, 57, 'Kolonnawa', NULL, NULL),
(5, 58, 'Kosgama', NULL, NULL),
(5, 59, 'Koswatta', NULL, NULL),
(5, 60, 'Kotikawatta', NULL, NULL),
(5, 61, 'Kottawa', NULL, NULL),
(5, 62, 'Kotte', NULL, NULL),
(5, 63, 'Madapatha', NULL, NULL),
(5, 64, 'Madiwela', NULL, NULL),
(5, 65, 'Maharagama', NULL, NULL),
(5, 66, 'Malabe', NULL, NULL),
(5, 67, 'Maradana', NULL, NULL),
(5, 68, 'Mattegoda', NULL, NULL),
(5, 69, 'Meegoda', NULL, NULL),
(5, 70, 'Meepe', NULL, NULL),
(5, 71, 'Mirihana', NULL, NULL),
(5, 72, 'Moragahahena', NULL, NULL),
(5, 73, 'Moraketiya', NULL, NULL),
(5, 74, 'Moratuwa', NULL, NULL),
(5, 75, 'Mount Lavinia', NULL, NULL),
(5, 76, 'Mullegama', NULL, NULL),
(5, 77, 'Mulleriyawa', NULL, NULL),
(5, 78, 'Napawela', NULL, NULL),
(5, 79, 'Navagamuwa', NULL, NULL),
(5, 80, 'Nawala', NULL, NULL),
(5, 81, 'Nugegoda', NULL, NULL),
(5, 82, 'Padukka', NULL, NULL),
(5, 83, 'Pannipitiya', NULL, NULL),
(5, 84, 'Pelawatta', NULL, NULL),
(5, 85, 'Peliyagoda', NULL, NULL),
(5, 86, 'Pepiliyana', NULL, NULL),
(5, 87, 'Piliyandala', NULL, NULL),
(5, 88, 'Pita Kotte', NULL, NULL),
(5, 89, 'Pitipana Homagama', NULL, NULL),
(5, 90, 'Polgasowita', NULL, NULL),
(5, 91, 'Puwakpitiya', NULL, NULL),
(5, 92, 'Rajagiriya', NULL, NULL),
(5, 93, 'Ranala', NULL, NULL),
(5, 94, 'Ratmalana', NULL, NULL),
(5, 95, 'Siddamulla', NULL, NULL),
(5, 96, 'Sri Jayawardenapura Kotte', NULL, NULL),
(5, 97, 'Talawatugoda', NULL, NULL),
(5, 98, 'Thalapathpitiya', NULL, NULL),
(5, 99, 'Thimbirigasyaya', NULL, NULL),
(5, 100, 'Thummodara', NULL, NULL),
(5, 101, 'Waga', NULL, NULL),
(5, 102, 'Watareka', NULL, NULL),
(5, 103, 'Weliwita', NULL, NULL),
(5, 104, 'Wellampitiya', NULL, NULL),
(5, 105, 'Wellawatte', NULL, NULL),
(2, 106, 'Anuradhapura', NULL, NULL),
(2, 107, 'Kekirawa', NULL, NULL),
(2, 108, 'Tambuttegama', NULL, NULL),
(2, 109, 'Eppawala', NULL, NULL),
(2, 110, 'Nochchiyagama', NULL, NULL),
(2, 111, 'Galenbindunuwewa', NULL, NULL),
(2, 112, 'Medawachchiya', NULL, NULL),
(2, 113, 'Talawa', NULL, NULL),
(2, 114, 'Andiyagala', NULL, NULL),
(2, 115, 'Angamuwa', NULL, NULL),
(2, 116, 'Aukana', NULL, NULL),
(2, 117, 'Bogahawewa', NULL, NULL),
(2, 118, 'Dematawewa', NULL, NULL),
(2, 119, 'Dunumadalawa', NULL, NULL),
(2, 120, 'Dutuwewa', NULL, NULL),
(2, 121, 'Elayapattuwa', NULL, NULL),
(2, 122, 'Etawatunuwewa', NULL, NULL),
(2, 123, 'Galadivulwewa', NULL, NULL),
(2, 124, 'Galkadawala', NULL, NULL),
(2, 125, 'Galkiriyagama', NULL, NULL),
(2, 126, 'Galkulama', NULL, NULL),
(2, 127, 'Galnewa', NULL, NULL),
(2, 128, 'Gambirigaswewa', NULL, NULL),
(2, 129, 'Ganewalpola', NULL, NULL),
(2, 130, 'Gnanikulama', NULL, NULL),
(2, 131, 'Habarana', NULL, NULL),
(2, 132, 'Hidogama', NULL, NULL),
(2, 133, 'Horawpatana', NULL, NULL),
(2, 134, 'Hurigaswewa', NULL, NULL),
(2, 135, 'Ihalagama', NULL, NULL),
(2, 136, 'Ipologama', NULL, NULL),
(2, 137, 'Kagama', NULL, NULL),
(2, 138, 'Kahatagasdigiliya', NULL, NULL),
(2, 139, 'Kalakarambewa', NULL, NULL),
(2, 140, 'Kalankuttiya', NULL, NULL),
(2, 141, 'Kala Oya', NULL, NULL),
(2, 142, 'Kapugallawa', NULL, NULL),
(2, 143, 'Katiyawa', NULL, NULL),
(2, 144, 'Kebithigollewa', NULL, NULL),
(2, 145, 'Kiralogama', NULL, NULL),
(2, 146, 'Kitulhitiyawa', NULL, NULL),
(2, 147, 'Kurundankulama', NULL, NULL),
(2, 148, 'Madatugama', NULL, NULL),
(2, 149, 'Maha Elagamuwa', NULL, NULL),
(2, 150, 'Mahabulankulama', NULL, NULL),
(2, 151, 'Mahailluppallama', NULL, NULL),
(2, 152, 'Mahakanadarawa', NULL, NULL),
(2, 153, 'Mahasenpura', NULL, NULL),
(2, 154, 'Mahawilachchiya', NULL, NULL),
(2, 155, 'Maradankadawala', NULL, NULL),
(2, 156, 'Maradankalla', NULL, NULL),
(2, 157, 'Mihintale', NULL, NULL),
(2, 158, 'Mulkiriyawa', NULL, NULL),
(2, 159, 'Nachchaduwa', NULL, NULL),
(2, 160, 'Negampaha', NULL, NULL),
(2, 161, 'Nuwaragam Palatha', NULL, NULL),
(2, 162, 'Padavi Parakramapura', NULL, NULL),
(2, 163, 'Padavi Sri Pura', NULL, NULL),
(2, 164, 'Padavi Sritissapura', NULL, NULL),
(2, 165, 'Padaviya', NULL, NULL),
(2, 166, 'Pahala Halmillewa', NULL, NULL),
(2, 167, 'Pahala Maragahawe', NULL, NULL),
(2, 168, 'Pahalagama', NULL, NULL),
(2, 169, 'Palagala', NULL, NULL),
(2, 170, 'Palugaswewa', NULL, NULL),
(2, 171, 'Pandulagama', NULL, NULL),
(2, 172, 'Parasangahawewa', NULL, NULL),
(2, 173, 'Pemaduwa', NULL, NULL),
(2, 174, 'Perimiyankulama', NULL, NULL),
(2, 175, 'Pubbogama', NULL, NULL),
(2, 176, 'Puliyankulama', NULL, NULL),
(2, 177, 'Punewa', NULL, NULL),
(2, 178, 'Rajanganaya', NULL, NULL),
(2, 179, 'Rambewa', NULL, NULL),
(2, 180, 'Rampathwila', NULL, NULL),
(2, 181, 'Saliyapura', NULL, NULL),
(2, 182, 'Seeppukulama', NULL, NULL),
(2, 183, 'Senapura', NULL, NULL),
(2, 184, 'Sivalakulama', NULL, NULL),
(2, 185, 'Sravasthipura', NULL, NULL),
(2, 186, 'Tantirimale', NULL, NULL),
(2, 187, 'Tennamarawadiya', NULL, NULL),
(2, 188, 'Tirappane', NULL, NULL),
(2, 189, 'Upuldeniya', NULL, NULL),
(2, 190, 'Vijithapura', NULL, NULL),
(2, 191, 'Wahalkada', NULL, NULL),
(2, 192, 'Wahamalgollewa', NULL, NULL),
(2, 193, 'Welioya Project', NULL, NULL),
(1, 194, 'Akkarepattu', NULL, NULL),
(1, 195, 'Ampara', NULL, NULL),
(1, 196, 'Kalmunai', NULL, NULL),
(1, 197, 'Sainthamaruthu', NULL, NULL),
(1, 198, 'Adalaichenai', NULL, NULL),
(1, 199, 'Samanthurai', NULL, NULL),
(1, 200, 'Pottuvil', NULL, NULL),
(1, 201, 'Nintavur', NULL, NULL),
(1, 202, 'Alayadiwembu', NULL, NULL),
(1, 203, 'Bakmitiyawa', NULL, NULL),
(1, 204, 'Central Camp', NULL, NULL),
(1, 205, 'Dadayamtalawa', NULL, NULL),
(1, 206, 'Damana', NULL, NULL),
(1, 207, 'Damanewela', NULL, NULL),
(1, 208, 'Deegawapiya', NULL, NULL),
(1, 209, 'Dehiattakandiya', NULL, NULL),
(1, 210, 'Devalahinda', NULL, NULL),
(1, 211, 'Digamadulla Weeragoda', NULL, NULL),
(1, 212, 'Eragama', NULL, NULL),
(1, 213, 'Galapitagala', NULL, NULL),
(1, 214, 'Gonagolla', NULL, NULL),
(1, 215, 'Hingurana', NULL, NULL),
(1, 216, 'Imkkamam', NULL, NULL),
(1, 217, 'Kannakipuram', NULL, NULL),
(1, 218, 'Karativu', NULL, NULL),
(1, 219, 'Koknahara', NULL, NULL),
(1, 220, 'Komari', NULL, NULL),
(1, 221, 'Lahugala', NULL, NULL),
(1, 222, 'Madawalalanda', NULL, NULL),
(1, 223, 'Mahanagapura', NULL, NULL),
(1, 224, 'Mahaoya', NULL, NULL),
(1, 225, 'Malwatta', NULL, NULL),
(1, 226, 'Marathamune', NULL, NULL),
(1, 227, 'Namal Oya', NULL, NULL),
(1, 228, 'Navithanveli', NULL, NULL),
(1, 229, 'Nawamedagama', NULL, NULL),
(1, 230, 'Oluvil', NULL, NULL),
(1, 231, 'Padiyatalawa', NULL, NULL),
(1, 232, 'Pahalalanda', NULL, NULL),
(1, 233, 'Palamunai', NULL, NULL),
(1, 234, 'Panama', NULL, NULL),
(1, 235, 'Paragahakele', NULL, NULL),
(1, 236, 'Periyaneelavanai', NULL, NULL),
(1, 237, 'Polwaga Janapadaya', NULL, NULL),
(1, 238, 'Rajagalatenna', NULL, NULL),
(1, 239, 'Serankada', NULL, NULL),
(1, 240, 'Siripura', NULL, NULL),
(1, 241, 'Thambiluvil', NULL, NULL),
(1, 242, 'Tirukovil', NULL, NULL),
(1, 243, 'Uhana', NULL, NULL),
(1, 244, 'Wadinagala', NULL, NULL),
(1, 245, 'Werunketagoda', NULL, NULL),
(3, 246, 'Badulla', NULL, NULL),
(3, 247, 'Bandarawela', NULL, NULL),
(3, 248, 'Welimada', NULL, NULL),
(3, 249, 'Mahiyanganaya', NULL, NULL),
(3, 250, 'Hali Ela', NULL, NULL),
(3, 251, 'Passara', NULL, NULL),
(3, 252, 'Diyatalawa', NULL, NULL),
(3, 253, 'Haputale', NULL, NULL),
(3, 254, 'Akkarasiyaya', NULL, NULL),
(3, 255, 'Aluketiyawa', NULL, NULL),
(3, 256, 'Aluttaramma', NULL, NULL),
(3, 257, 'Ambadandegama', NULL, NULL),
(3, 258, 'Ambagasdowa', NULL, NULL),
(3, 259, 'Amunumulla', NULL, NULL),
(3, 260, 'Arawa', NULL, NULL),
(3, 261, 'Arawatta', NULL, NULL),
(3, 262, 'Atakiriya', NULL, NULL),
(3, 263, 'Baduluoya', NULL, NULL),
(3, 264, 'Ballaketuwa', NULL, NULL),
(3, 265, 'Bambarapana', NULL, NULL),
(3, 266, 'Beramada', NULL, NULL),
(3, 267, 'Bibilegama', NULL, NULL),
(3, 268, 'Bogahakumbura', NULL, NULL),
(3, 269, 'Boralanda', NULL, NULL),
(3, 270, 'Bowela', NULL, NULL),
(3, 271, 'Demodara', NULL, NULL),
(3, 272, 'Dikkapitiya', NULL, NULL),
(3, 273, 'Dimbulana', NULL, NULL),
(3, 274, 'Ella', NULL, NULL),
(3, 275, 'Ettampitiya', NULL, NULL),
(3, 276, 'Galauda', NULL, NULL),
(3, 277, 'Gamewela', NULL, NULL),
(3, 278, 'Girandurukotte', NULL, NULL),
(3, 279, 'Gurutalawa', NULL, NULL),
(3, 280, 'Haldummulla', NULL, NULL),
(3, 281, 'Helahalpe', NULL, NULL),
(3, 282, 'Hewanakumbura', NULL, NULL),
(3, 283, 'Kahataruppa', NULL, NULL),
(3, 284, 'Kalupahana', NULL, NULL),
(3, 285, 'Kandaketya', NULL, NULL),
(3, 286, 'Kandegedara', NULL, NULL),
(3, 287, 'Kebillawela', NULL, NULL),
(3, 288, 'Kendagolla', NULL, NULL),
(3, 289, 'Keppetipola', NULL, NULL),
(3, 290, 'Kiriwanagama', NULL, NULL),
(3, 291, 'Koslanda', NULL, NULL),
(3, 292, 'Lunugala', NULL, NULL),
(3, 293, 'Lunuwatta', NULL, NULL),
(3, 294, 'Madulsima', NULL, NULL),
(3, 295, 'Malgoda', NULL, NULL),
(3, 296, 'Mapakadawewa', NULL, NULL),
(3, 297, 'Maussagolla', NULL, NULL),
(3, 298, 'Medawela Udukinda', NULL, NULL),
(3, 299, 'Medawelagama', NULL, NULL),
(3, 300, 'Meegahakiula', NULL, NULL),
(3, 301, 'Mirahawatta', NULL, NULL),
(3, 302, 'Namunukula', NULL, NULL),
(3, 303, 'Narangala', NULL, NULL),
(3, 304, 'Nelumgama', NULL, NULL),
(3, 305, 'Nikapotha', NULL, NULL),
(3, 306, 'Nugatalawa', NULL, NULL),
(3, 307, 'Pelagahatenna', NULL, NULL),
(3, 308, 'Ridimaliyadda', NULL, NULL),
(3, 309, 'Rilpola', NULL, NULL),
(3, 310, 'Silmiyapura', NULL, NULL),
(3, 311, 'Soranatota', NULL, NULL),
(3, 312, 'Spring Valley', NULL, NULL),
(3, 313, 'Taldena', NULL, NULL),
(3, 314, 'Uduhawara', NULL, NULL),
(3, 315, 'Uva Mawelagama', NULL, NULL),
(3, 316, 'Uva Tenna', NULL, NULL),
(3, 317, 'Uva Uduwara', NULL, NULL),
(3, 318, 'Uva Paranagama', NULL, NULL),
(3, 319, 'Wineethagama', NULL, NULL),
(4, 320, 'Batticaloa', NULL, NULL),
(4, 321, 'Kattankudi', NULL, NULL),
(4, 322, 'Eravur', NULL, NULL),
(4, 323, 'Valaichenai', NULL, NULL),
(4, 324, 'Kaluwanchikudi', NULL, NULL),
(4, 325, 'Oddamavadi', NULL, NULL),
(4, 326, 'Chenkaladi', NULL, NULL),
(4, 327, 'Araipattai', NULL, NULL),
(4, 328, 'Ampilanthurai', NULL, NULL),
(4, 329, 'Ayithiyamalai', NULL, NULL),
(4, 330, 'Bakiella', NULL, NULL),
(4, 331, 'Cheddipalayam', NULL, NULL),
(4, 332, 'Kalkudah', NULL, NULL),
(4, 333, 'Kallar', NULL, NULL),
(4, 334, 'Kaluwankemy', NULL, NULL),
(4, 335, 'Kannankudah', NULL, NULL),
(4, 336, 'Karadiyanaru', NULL, NULL),
(4, 337, 'Kathiraveli', NULL, NULL),
(4, 338, 'Kiran', NULL, NULL),
(4, 339, 'Kirankulam', NULL, NULL),
(4, 340, 'Koddaikallar', NULL, NULL),
(4, 341, 'Kokkaddichcholai', NULL, NULL),
(4, 342, 'Kurukkalmadam', NULL, NULL),
(4, 343, 'Mandur', NULL, NULL),
(4, 344, 'Mankemi', NULL, NULL),
(4, 345, 'Miravodai', NULL, NULL),
(4, 346, 'Murakottanchanai', NULL, NULL),
(4, 347, 'Navatkadu', NULL, NULL),
(4, 348, 'Panichankemi', NULL, NULL),
(4, 349, 'Pasikudah', NULL, NULL),
(4, 350, 'Pillaiyaradi', NULL, NULL),
(4, 351, 'Puthukudiyiruppu', NULL, NULL),
(4, 352, 'Thannamunai', NULL, NULL),
(4, 353, 'Thettativu', NULL, NULL),
(4, 354, 'Thikkodai', NULL, NULL),
(4, 355, 'Thuraineelavanai', NULL, NULL),
(4, 356, 'Vantharumoolai', NULL, NULL),
(4, 357, 'Vavunathivu', NULL, NULL),
(4, 358, 'Vellavely', NULL, NULL),
(6, 359, 'Galle', NULL, NULL),
(6, 360, 'Ambalangoda', NULL, NULL),
(6, 361, 'Elpitiya', NULL, NULL),
(6, 362, 'Hikkaduwa', NULL, NULL),
(6, 363, 'Karapitiya', NULL, NULL),
(6, 364, 'Baddegama', NULL, NULL),
(6, 365, 'Ahangama', NULL, NULL),
(6, 366, 'Batapola', NULL, NULL),
(6, 367, 'Agaliya', NULL, NULL),
(6, 368, 'Ahungalla', NULL, NULL),
(6, 369, 'Akmeemana', NULL, NULL),
(6, 370, 'Aluthwala', NULL, NULL),
(6, 371, 'Ampegama', NULL, NULL),
(6, 372, 'Amugoda', NULL, NULL),
(6, 373, 'Anangoda', NULL, NULL),
(6, 374, 'Angulugaha', NULL, NULL),
(6, 375, 'Ankokkawala', NULL, NULL),
(6, 376, 'Balapitiya', NULL, NULL),
(6, 377, 'Banagala', NULL, NULL),
(6, 378, 'Bentota', NULL, NULL),
(6, 379, 'Boossa', NULL, NULL),
(6, 380, 'Bope-Poddala', NULL, NULL),
(6, 381, 'Dikkumbura', NULL, NULL),
(6, 382, 'Dodanduwa', NULL, NULL),
(6, 383, 'Ella Tanabaddegama', NULL, NULL),
(6, 384, 'Ethkandura', NULL, NULL),
(6, 385, 'Ganegoda', NULL, NULL),
(6, 386, 'Ginimellagaha', NULL, NULL),
(6, 387, 'Gintota', NULL, NULL),
(6, 388, 'Gonagalpura', NULL, NULL),
(6, 389, 'Gonamulla Junction', NULL, NULL),
(6, 390, 'Gonapinuwala', NULL, NULL),
(6, 391, 'Habaraduwa', NULL, NULL),
(6, 392, 'Haburugala', NULL, NULL),
(6, 393, 'Halvitigala Colony', NULL, NULL),
(6, 394, 'Hapugala', NULL, NULL),
(6, 395, 'Hawpe', NULL, NULL),
(6, 396, 'Hinatigala', NULL, NULL),
(6, 397, 'Hiniduma', NULL, NULL),
(6, 398, 'Hiyare', NULL, NULL),
(6, 399, 'Ihala Walpola', NULL, NULL),
(6, 400, 'Ihalahewessa', NULL, NULL),
(6, 401, 'Imaduwa', NULL, NULL),
(6, 402, 'Induruwa', NULL, NULL),
(6, 403, 'Kahaduwa', NULL, NULL),
(6, 404, 'Kahawa', NULL, NULL),
(6, 405, 'Kananke Bazaar', NULL, NULL),
(6, 406, 'Karagoda', NULL, NULL),
(6, 407, 'Karandeniya', NULL, NULL),
(6, 408, 'Koggala', NULL, NULL),
(6, 409, 'Kosgoda', NULL, NULL),
(6, 410, 'Kottawagama', NULL, NULL),
(6, 411, 'Kuleegoda', NULL, NULL),
(6, 412, 'Magedara', NULL, NULL),
(6, 413, 'Malgalla Talangalla', NULL, NULL),
(6, 414, 'Mapalagama', NULL, NULL),
(6, 415, 'Mapalagama Central', NULL, NULL),
(6, 416, 'Mattaka', NULL, NULL),
(6, 417, 'Meda-Keembiya', NULL, NULL),
(6, 418, 'Meetiyagoda', NULL, NULL),
(6, 419, 'Nagoda', NULL, NULL),
(6, 420, 'Nakiyadeniya', NULL, NULL),
(6, 421, 'Neluwa', NULL, NULL),
(6, 422, 'Niyagama', NULL, NULL),
(6, 423, 'Opatha', NULL, NULL),
(6, 424, 'Panangala', NULL, NULL),
(6, 425, 'Pitigala', NULL, NULL),
(6, 426, 'Poddala', NULL, NULL),
(6, 427, 'Porawagama', NULL, NULL),
(6, 428, 'Rantotuwila', NULL, NULL),
(6, 429, 'Ratgama', NULL, NULL),
(6, 430, 'Talagampola', NULL, NULL),
(6, 431, 'Talgaspe', NULL, NULL),
(6, 432, 'Talgaswela', NULL, NULL),
(6, 433, 'Talpe', NULL, NULL),
(6, 434, 'Tawalama', NULL, NULL),
(6, 435, 'Tiranagama', NULL, NULL),
(6, 436, 'Udalamatta', NULL, NULL),
(6, 437, 'Udugama', NULL, NULL),
(6, 438, 'Uluvitike', NULL, NULL),
(6, 439, 'Unawatuna', NULL, NULL),
(6, 440, 'Unenwitiya', NULL, NULL),
(6, 441, 'Uragaha', NULL, NULL),
(6, 442, 'Uragasmanhandiya', NULL, NULL),
(6, 443, 'Wakwella', NULL, NULL),
(6, 444, 'Walahanduwa', NULL, NULL),
(6, 445, 'Wanchawela', NULL, NULL),
(6, 446, 'Wanduramba', NULL, NULL),
(6, 447, 'Watugedara', NULL, NULL),
(6, 448, 'Weihena', NULL, NULL),
(6, 449, 'Welivitiya-Divithura', NULL, NULL),
(6, 450, 'Yakkalamulla', NULL, NULL),
(6, 451, 'Yatalamatta', NULL, NULL),
(7, 452, 'Gampaha', NULL, NULL),
(7, 453, 'Negombo', NULL, NULL),
(7, 454, 'Kadawatha', NULL, NULL),
(7, 455, 'Wattala', NULL, NULL),
(7, 456, 'Ja-Ela', NULL, NULL),
(7, 457, 'Kiribathgoda', NULL, NULL),
(7, 458, 'Minuwangoda', NULL, NULL),
(7, 459, 'Kandana', NULL, NULL),
(7, 460, 'Akaragama', NULL, NULL),
(7, 461, 'Alawala', NULL, NULL),
(7, 462, 'Ambagaspitiya', NULL, NULL),
(7, 463, 'Andiambalama', NULL, NULL),
(7, 464, 'Anniyakanda', NULL, NULL),
(7, 465, 'Attanagalla', NULL, NULL),
(7, 466, 'Badalgama', NULL, NULL),
(7, 467, 'Balabowa', NULL, NULL),
(7, 468, 'Banduragoda', NULL, NULL),
(7, 469, 'Batuwatta', NULL, NULL),
(7, 470, 'Bemmulla', NULL, NULL),
(7, 471, 'Biyagama', NULL, NULL),
(7, 472, 'Biyagama IPZ', NULL, NULL),
(7, 473, 'Bokalagama', NULL, NULL),
(7, 474, 'Bollete', NULL, NULL),
(7, 475, 'Bopagama', NULL, NULL),
(7, 476, 'Buthpitiya', NULL, NULL),
(7, 477, 'Dagonna', NULL, NULL),
(7, 478, 'Dalugama', NULL, NULL),
(7, 479, 'Danowita', NULL, NULL),
(7, 480, 'Dekatana', NULL, NULL),
(7, 481, 'Delgoda', NULL, NULL),
(7, 482, 'Delwagura', NULL, NULL),
(7, 483, 'Demalagama', NULL, NULL),
(7, 484, 'Demanhandiya', NULL, NULL),
(7, 485, 'Dewalapola', NULL, NULL),
(7, 486, 'Divulapitiya', NULL, NULL),
(7, 487, 'Divuldeniya', NULL, NULL),
(7, 488, 'Dompe', NULL, NULL),
(7, 489, 'Dunagaha', NULL, NULL),
(7, 490, 'Ekala', NULL, NULL),
(7, 491, 'Ellakkala', NULL, NULL),
(7, 492, 'Essella', NULL, NULL),
(7, 493, 'Ganemulla', NULL, NULL),
(7, 494, 'GonawalaWP', NULL, NULL),
(7, 495, 'Heiyanthuduwa', NULL, NULL),
(7, 496, 'Hendala', NULL, NULL),
(7, 497, 'Henegama', NULL, NULL),
(7, 498, 'Hinatiyana Madawala', NULL, NULL),
(7, 499, 'Hiswella', NULL, NULL),
(7, 500, 'Horampella', NULL, NULL),
(7, 501, 'Hunumulla', NULL, NULL),
(7, 502, 'Ihala Madampella', NULL, NULL),
(7, 503, 'Imbulgoda', NULL, NULL),
(7, 504, 'Kadirana', NULL, NULL),
(7, 505, 'Kahatowita', NULL, NULL),
(7, 506, 'Kalagedihena', NULL, NULL),
(7, 507, 'Kaleliya', NULL, NULL),
(7, 508, 'Kapugoda', NULL, NULL),
(7, 509, 'Katana', NULL, NULL),
(7, 510, 'Kattuwa', NULL, NULL),
(7, 511, 'Katunayake', NULL, NULL),
(7, 512, 'Katunayake Air Force Camp', NULL, NULL),
(7, 513, 'Katuwellegama', NULL, NULL),
(7, 514, 'Kelaniya', NULL, NULL),
(7, 515, 'Kimbulapitiya', NULL, NULL),
(7, 516, 'Kirillawala', NULL, NULL),
(7, 517, 'Kirindiwela', NULL, NULL),
(7, 518, 'Kitulwala', NULL, NULL),
(7, 519, 'Kochchikade', NULL, NULL),
(7, 520, 'Kotadeniyawa', NULL, NULL),
(7, 521, 'Kotugoda', NULL, NULL),
(7, 522, 'Kumbaloluwa', NULL, NULL),
(7, 523, 'Loluwagoda', NULL, NULL),
(7, 524, 'Lunugama', NULL, NULL),
(7, 525, 'Mabodale', NULL, NULL),
(7, 526, 'Madelgamuwa', NULL, NULL),
(7, 527, 'Mahabage', NULL, NULL),
(7, 528, 'Mahara', NULL, NULL),
(7, 529, 'Makewita', NULL, NULL),
(7, 530, 'Makola', NULL, NULL),
(7, 531, 'Malwana', NULL, NULL),
(7, 532, 'Mandawala', NULL, NULL),
(7, 533, 'Marandagahamula', NULL, NULL),
(7, 534, 'Mellawagedara', NULL, NULL),
(7, 535, 'Mirigama', NULL, NULL),
(7, 536, 'Miriswatta', NULL, NULL),
(7, 537, 'Mithirigala', NULL, NULL),
(7, 538, 'Muddaragama', NULL, NULL),
(7, 539, 'Mudungoda', NULL, NULL),
(7, 540, 'Naranwala', NULL, NULL),
(7, 541, 'Nawana', NULL, NULL),
(7, 542, 'Nedungamuwa', NULL, NULL),
(7, 543, 'Nikahetikanda', NULL, NULL),
(7, 544, 'Nittambuwa', NULL, NULL),
(7, 545, 'Niwandama', NULL, NULL),
(7, 546, 'Pallewela', NULL, NULL),
(7, 547, 'Pamunugama', NULL, NULL),
(7, 548, 'Pamunuwatta', NULL, NULL),
(7, 549, 'Pasyala', NULL, NULL),
(7, 550, 'Pepiliyawala', NULL, NULL),
(7, 551, 'Pethiyagoda', NULL, NULL),
(7, 552, 'Polpithimukulana', NULL, NULL),
(7, 553, 'Pugoda', NULL, NULL),
(7, 554, 'Radawadunna', NULL, NULL),
(7, 555, 'Radawana', NULL, NULL),
(7, 556, 'Raddolugama', NULL, NULL),
(7, 557, 'Ragama', NULL, NULL),
(7, 558, 'Ruggahawila', NULL, NULL),
(7, 559, 'Rukmale', NULL, NULL),
(7, 560, 'Seeduwa', NULL, NULL),
(7, 561, 'Siyambalape', NULL, NULL),
(7, 562, 'Talahena', NULL, NULL),
(7, 563, 'Thihariya', NULL, NULL),
(7, 564, 'Thimbirigaskatuwa', NULL, NULL),
(7, 565, 'Tittapattara', NULL, NULL),
(7, 566, 'Udathuthiripitiya', NULL, NULL),
(7, 567, 'Udugampola', NULL, NULL),
(7, 568, 'Uggalboda', NULL, NULL),
(7, 569, 'Urapola', NULL, NULL),
(7, 570, 'Uswetakeiyawa', NULL, NULL),
(7, 571, 'Veyangoda', NULL, NULL),
(7, 572, 'Walgammulla', NULL, NULL),
(7, 573, 'Walpola', NULL, NULL),
(7, 574, 'Wanaluwewa', NULL, NULL),
(7, 575, 'Waragoda', NULL, NULL),
(7, 576, 'Wathurugama', NULL, NULL),
(7, 577, 'Watinapaha', NULL, NULL),
(7, 578, 'Weboda', NULL, NULL),
(7, 579, 'Wegowwa', NULL, NULL),
(7, 580, 'Welisara', NULL, NULL),
(7, 581, 'Weliveriya', NULL, NULL),
(7, 582, 'Weweldeniya', NULL, NULL),
(7, 583, 'Yakkala', NULL, NULL),
(7, 584, 'Yatiyana', NULL, NULL),
(8, 585, 'Tangalla', NULL, NULL),
(8, 586, 'Beliatta', NULL, NULL),
(8, 587, 'Ambalantota', NULL, NULL),
(8, 588, 'Tissamaharama', NULL, NULL),
(8, 589, 'Hambantota', NULL, NULL),
(8, 590, 'Walasmulla', NULL, NULL),
(8, 591, 'Sooriyawewa Town', NULL, NULL),
(8, 592, 'Angunakolapelessa', NULL, NULL),
(8, 593, 'Bandagiriya Colony', NULL, NULL),
(8, 594, 'Barawakumbuka', NULL, NULL),
(8, 595, 'Beragama', NULL, NULL),
(8, 596, 'Beralihela', NULL, NULL),
(8, 597, 'Bowalagama', NULL, NULL),
(8, 598, 'Bundala', NULL, NULL),
(8, 599, 'Ellagala', NULL, NULL),
(8, 600, 'Gangulandeniya', NULL, NULL),
(8, 601, 'Getamanna', NULL, NULL),
(8, 602, 'Goda Koggalla', NULL, NULL),
(8, 603, 'Gonagamuwa Uduwila', NULL, NULL),
(8, 604, 'Gonnoruwa', NULL, NULL),
(8, 605, 'Hakuruwela', NULL, NULL),
(8, 606, 'Horewelagoda', NULL, NULL),
(8, 607, 'Hungama', NULL, NULL),
(8, 608, 'Ihala Beligalla', NULL, NULL),
(8, 609, 'Julampitiya', NULL, NULL),
(8, 610, 'Kahandamodara', NULL, NULL),
(8, 611, 'Kariyamaditta', NULL, NULL),
(8, 612, 'Katuwana', NULL, NULL),
(8, 613, 'Kawantissapura', NULL, NULL),
(8, 614, 'Kirama', NULL, NULL),
(8, 615, 'Kirinda', NULL, NULL),
(8, 616, 'Lunama', NULL, NULL),
(8, 617, 'Lunugamwehera', NULL, NULL),
(8, 618, 'Magama', NULL, NULL),
(8, 619, 'Mahagalwewa', NULL, NULL),
(8, 620, 'Mamadala', NULL, NULL),
(8, 621, 'Medamulana', NULL, NULL),
(8, 622, 'Middeniya', NULL, NULL),
(8, 623, 'Migahajandur', NULL, NULL),
(8, 624, 'Modarawana', NULL, NULL),
(8, 625, 'Mulkirigala', NULL, NULL),
(8, 626, 'Nakulugamuwa', NULL, NULL),
(8, 627, 'Netolpitiya', NULL, NULL),
(8, 628, 'Nihiluwa', NULL, NULL),
(8, 629, 'Okewela', NULL, NULL),
(8, 630, 'Pahala Andarawewa', NULL, NULL),
(8, 631, 'Rammalawarapitiya', NULL, NULL),
(8, 632, 'Ranmuduwewa', NULL, NULL),
(8, 633, 'Ranna', NULL, NULL),
(8, 634, 'Ridiyagama', NULL, NULL),
(8, 635, 'Udamattala', NULL, NULL),
(8, 636, 'Uswewa', NULL, NULL),
(8, 637, 'Vitharandeniya', NULL, NULL),
(8, 638, 'Weeraketiya', NULL, NULL),
(8, 639, 'Weerawila', NULL, NULL),
(8, 640, 'Weerawila NewTown', NULL, NULL),
(8, 641, 'Weligatta', NULL, NULL),
(8, 642, 'Yala', NULL, NULL),
(9, 643, 'Jaffna', NULL, NULL),
(9, 644, 'Manipay', NULL, NULL),
(9, 645, 'Chavakachcheri', NULL, NULL),
(9, 646, 'Nallur', NULL, NULL),
(9, 647, 'Kokuvil', NULL, NULL),
(9, 648, 'Point Pedro', NULL, NULL),
(9, 649, 'Kondavil', NULL, NULL),
(9, 650, 'Chunnakam', NULL, NULL),
(9, 651, 'Allaipiddi', NULL, NULL),
(9, 652, 'Allaveddi', NULL, NULL),
(9, 653, 'Alvai', NULL, NULL),
(9, 654, 'Anaicoddai', NULL, NULL),
(9, 655, 'Analaitivu', NULL, NULL),
(9, 656, 'Atchuveli', NULL, NULL),
(9, 657, 'Chankanai', NULL, NULL),
(9, 658, 'Chullipuram', NULL, NULL),
(9, 659, 'Chundikuli', NULL, NULL),
(9, 660, 'Delft', NULL, NULL),
(9, 661, 'DelftWest', NULL, NULL),
(9, 662, 'Eluvaitivu', NULL, NULL),
(9, 663, 'Erlalai', NULL, NULL),
(9, 664, 'Ilavalai', NULL, NULL),
(9, 665, 'Kaitadi', NULL, NULL),
(9, 666, 'Karainagar', NULL, NULL),
(9, 667, 'Karaveddi', NULL, NULL),
(9, 668, 'Kayts', NULL, NULL),
(9, 669, 'Kodikamam', NULL, NULL),
(9, 670, 'Kopay', NULL, NULL),
(9, 671, 'Kudatanai', NULL, NULL),
(9, 672, 'Mallakam', NULL, NULL),
(9, 673, 'Maruthnkerny', NULL, NULL),
(9, 674, 'Mathagal', NULL, NULL),
(9, 675, 'Meesalai', NULL, NULL),
(9, 676, 'Mirusuvil', NULL, NULL),
(9, 677, 'Nainathivu', NULL, NULL),
(9, 678, 'Neervely', NULL, NULL),
(9, 679, 'Pandaterippu', NULL, NULL),
(9, 680, 'Pungudutivu', NULL, NULL),
(9, 681, 'Putur', NULL, NULL),
(9, 682, 'Sandilipay', NULL, NULL),
(9, 683, 'Siruppiddy', NULL, NULL),
(9, 684, 'Sithankemy', NULL, NULL),
(9, 685, 'Tellippallai', NULL, NULL),
(9, 686, 'Thondamanaru', NULL, NULL),
(9, 687, 'Uduvil', NULL, NULL),
(9, 688, 'Urumpirai', NULL, NULL),
(9, 689, 'Vaddukoddai', NULL, NULL),
(9, 690, 'Valvettithurai', NULL, NULL),
(9, 691, 'Vannarponnai', NULL, NULL),
(9, 692, 'Varany', NULL, NULL),
(9, 693, 'Velanai', NULL, NULL),
(10, 694, 'Panadura', NULL, NULL),
(10, 695, 'Kalutara', NULL, NULL),
(10, 696, 'Horana', NULL, NULL),
(10, 697, 'Bandaragama', NULL, NULL),
(10, 698, 'Matugama', NULL, NULL),
(10, 699, 'Wadduwa', NULL, NULL),
(10, 700, 'Alutgama', NULL, NULL),
(10, 701, 'Beruwala', NULL, NULL),
(10, 702, 'Agalawatta', NULL, NULL),
(10, 703, 'Alubomulla', NULL, NULL),
(10, 704, 'Anguruwatota', NULL, NULL),
(10, 705, 'Baduraliya', NULL, NULL),
(10, 706, 'Bellana', NULL, NULL),
(10, 707, 'Benthara', NULL, NULL),
(10, 708, 'Bolossagama', NULL, NULL),
(10, 709, 'Bombuwala', NULL, NULL),
(10, 710, 'Boralugoda', NULL, NULL),
(10, 711, 'Bulathsinhala', NULL, NULL),
(10, 712, 'Danawala Thiniyawala', NULL, NULL),
(10, 713, 'Delmella', NULL, NULL),
(10, 714, 'Dharga Town', NULL, NULL),
(10, 715, 'Diwalakada', NULL, NULL),
(10, 716, 'Dodangoda', NULL, NULL),
(10, 717, 'Dombagoda', NULL, NULL),
(10, 718, 'Galpatha', NULL, NULL),
(10, 719, 'Gamagoda', NULL, NULL),
(10, 720, 'Gonapola Junction', NULL, NULL),
(10, 721, 'Govinna', NULL, NULL),
(10, 722, 'Halkandawila', NULL, NULL),
(10, 723, 'Haltota', NULL, NULL),
(10, 724, 'Halwatura', NULL, NULL),
(10, 725, 'Hedigalla Colony', NULL, NULL),
(10, 726, 'Ingiriya', NULL, NULL),
(10, 727, 'Ittapana', NULL, NULL),
(10, 728, 'Kalawila Kiranthidiya', NULL, NULL),
(10, 729, 'Kananwila', NULL, NULL),
(10, 730, 'Kehelwatta', NULL, NULL),
(10, 731, 'Kelinkanda', NULL, NULL),
(10, 732, 'Kitulgoda', NULL, NULL),
(10, 733, 'Koholana', NULL, NULL),
(10, 734, 'Kuda Uduwa', NULL, NULL),
(10, 735, 'Kumbuka', NULL, NULL),
(10, 736, 'Madurawala', NULL, NULL),
(10, 737, 'Maggona', NULL, NULL),
(10, 738, 'Mahagama', NULL, NULL),
(10, 739, 'Mahakalupahana', NULL, NULL),
(10, 740, 'Meegahatenna', NULL, NULL),
(10, 741, 'Meegama', NULL, NULL),
(10, 742, 'Millaniya', NULL, NULL),
(10, 743, 'Millewa', NULL, NULL),
(10, 744, 'Miwanapalana', NULL, NULL),
(10, 745, 'Molkawa', NULL, NULL),
(10, 746, 'Morapitiya', NULL, NULL),
(10, 747, 'Morontuduwa', NULL, NULL),
(10, 748, 'Nawattuduwa', NULL, NULL),
(10, 749, 'Neboda', NULL, NULL),
(10, 750, 'Padagoda', NULL, NULL),
(10, 751, 'Pahalahewessa', NULL, NULL),
(10, 752, 'Paiyagala', NULL, NULL),
(10, 753, 'Palindanuwara', NULL, NULL),
(10, 754, 'Pannila', NULL, NULL),
(10, 755, 'Paragastota', NULL, NULL),
(10, 756, 'Paraigama', NULL, NULL),
(10, 757, 'Pelanda', NULL, NULL),
(10, 758, 'Pokunuwita', NULL, NULL),
(10, 759, 'Polgampola', NULL, NULL),
(10, 760, 'Poruwadanda', NULL, NULL),
(10, 761, 'Remunagoda', NULL, NULL),
(10, 762, 'Tebuwana', NULL, NULL),
(10, 763, 'Uduwara', NULL, NULL),
(10, 764, 'Veyangalla', NULL, NULL),
(10, 765, 'Walagedara', NULL, NULL),
(10, 766, 'Walallawita', NULL, NULL),
(10, 767, 'Waskaduwa', NULL, NULL),
(10, 768, 'Welipenna', NULL, NULL),
(10, 769, 'Welmilla Junction', NULL, NULL),
(10, 770, 'Yagirala', NULL, NULL),
(10, 771, 'Yatadolawatta', NULL, NULL),
(11, 772, 'Kandy', NULL, NULL),
(11, 773, 'Katugastota', NULL, NULL),
(11, 774, 'Gampola', NULL, NULL),
(11, 775, 'Peradeniya', NULL, NULL),
(11, 776, 'Akurana', NULL, NULL),
(11, 777, 'Digana', NULL, NULL),
(11, 778, 'Pilimatalawa', NULL, NULL),
(11, 779, 'Gelioya', NULL, NULL),
(11, 780, 'Aladeniya', NULL, NULL),
(11, 781, 'Alawatugoda', NULL, NULL),
(11, 782, 'Aludeniya', NULL, NULL),
(11, 783, 'Ambagahapelessa', NULL, NULL),
(11, 784, 'Ambatenna', NULL, NULL),
(11, 785, 'Ampitiya', NULL, NULL),
(11, 786, 'Aniwatta', NULL, NULL),
(11, 787, 'Ankumbura', NULL, NULL),
(11, 788, 'Asgiriya', NULL, NULL),
(11, 789, 'Atabage', NULL, NULL),
(11, 790, 'Balagolla', NULL, NULL),
(11, 791, 'Balana', NULL, NULL),
(11, 792, 'Bambaragahaela', NULL, NULL),
(11, 793, 'Barawardhana Oya', NULL, NULL),
(11, 794, 'Batagolladeniya', NULL, NULL),
(11, 795, 'Batugoda', NULL, NULL),
(11, 796, 'Batumulla', NULL, NULL),
(11, 797, 'Bawlana', NULL, NULL),
(11, 798, 'Bopana', NULL, NULL),
(11, 799, 'Dangolla', NULL, NULL),
(11, 800, 'Danture', NULL, NULL),
(11, 801, 'Dedunupitiya', NULL, NULL),
(11, 802, 'Deltota', NULL, NULL),
(11, 803, 'Dodanwala', NULL, NULL),
(11, 804, 'Dolapihilla', NULL, NULL),
(11, 805, 'Dolosbage', NULL, NULL),
(11, 806, 'Doluwa', NULL, NULL),
(11, 807, 'Doragamuwa', NULL, NULL),
(11, 808, 'Dunuwila', NULL, NULL),
(11, 809, 'Ekiriya', NULL, NULL),
(11, 810, 'Elamulla', NULL, NULL),
(11, 811, 'Galaboda', NULL, NULL),
(11, 812, 'Galagedara', NULL, NULL),
(11, 813, 'Galaha', NULL, NULL),
(11, 814, 'Galhinna', NULL, NULL),
(11, 815, 'Gallellagama', NULL, NULL),
(11, 816, 'Ganga Ihala Korale', NULL, NULL),
(11, 817, 'Gangawata Korale', NULL, NULL),
(11, 818, 'Godamunna', NULL, NULL),
(11, 819, 'Gomagoda', NULL, NULL),
(11, 820, 'Gonagantenna', NULL, NULL),
(11, 821, 'Gonawalapatana', NULL, NULL),
(11, 822, 'Gunnepana', NULL, NULL),
(11, 823, 'Gurudeniya', NULL, NULL),
(11, 824, 'Halloluwa', NULL, NULL),
(11, 825, 'Handawalapitiya', NULL, NULL),
(11, 826, 'Handessa', NULL, NULL),
(11, 827, 'Hanguranketha', NULL, NULL),
(11, 828, 'Hantane', NULL, NULL),
(11, 829, 'Haragama', NULL, NULL),
(11, 830, 'Harankahawa', NULL, NULL),
(11, 831, 'Harispattuwa', NULL, NULL),
(11, 832, 'Hasalaka', NULL, NULL),
(11, 833, 'Hataraliyadda', NULL, NULL),
(11, 834, 'Heerassagala', NULL, NULL),
(11, 835, 'Hewaheta', NULL, NULL),
(11, 836, 'Hindagala', NULL, NULL),
(11, 837, 'Hondiyadeniya', NULL, NULL),
(11, 838, 'Hunnasgiriya', NULL, NULL),
(11, 839, 'Jambugahapitiya', NULL, NULL),
(11, 840, 'Kadugannawa', NULL, NULL),
(11, 841, 'Kahataliyadda', NULL, NULL),
(11, 842, 'Kalugala', NULL, NULL),
(11, 843, 'Kapuliyadde', NULL, NULL),
(11, 844, 'Karandagolla', NULL, NULL),
(11, 845, 'Kengalla', NULL, NULL),
(11, 846, 'Ketakumbura', NULL, NULL),
(11, 847, 'Ketawala Leula', NULL, NULL),
(11, 848, 'Kiribathkumbura', NULL, NULL),
(11, 849, 'Kobonila', NULL, NULL),
(11, 850, 'Kolabissa', NULL, NULL),
(11, 851, 'Kolongoda', NULL, NULL),
(11, 852, 'Kulugammana', NULL, NULL),
(11, 853, 'Kumbukkandura', NULL, NULL),
(11, 854, 'Kumburegama', NULL, NULL),
(11, 855, 'Kundasale', NULL, NULL),
(11, 856, 'Lewella', NULL, NULL),
(11, 857, 'Madawala Bazaar', NULL, NULL),
(11, 858, 'Madulkele', NULL, NULL),
(11, 859, 'Mahadoraliyadda', NULL, NULL),
(11, 860, 'Mahakanda', NULL, NULL),
(11, 861, 'Mailapitiya', NULL, NULL),
(11, 862, 'Makkanigama', NULL, NULL),
(11, 863, 'Marassana', NULL, NULL),
(11, 864, 'Marymount Colony', NULL, NULL),
(11, 865, 'Maturata', NULL, NULL),
(11, 866, 'Mawilmada', NULL, NULL),
(11, 867, 'Medamahanuwara', NULL, NULL),
(11, 868, 'Medawala Harispattuwa', NULL, NULL),
(11, 869, 'Megoda Kalugamuwa', NULL, NULL),
(11, 870, 'Menikdiwela', NULL, NULL),
(11, 871, 'Menikhinna', NULL, NULL),
(11, 872, 'Mimure', NULL, NULL),
(11, 873, 'Minigamuwa', NULL, NULL),
(11, 874, 'Murutalawa', NULL, NULL),
(11, 875, 'Muruthagahamulla', NULL, NULL),
(11, 876, 'Naranpanawa', NULL, NULL),
(11, 877, 'Nattarampotha', NULL, NULL),
(11, 878, 'Nawalapitiya', NULL, NULL),
(11, 879, 'Nillambe', NULL, NULL),
(11, 880, 'Nugawela', NULL, NULL),
(11, 881, 'Pallebowala', NULL, NULL),
(11, 882, 'Pallekelle', NULL, NULL),
(11, 883, 'Pallekotuwa', NULL, NULL),
(11, 884, 'Panvila', NULL, NULL),
(11, 885, 'Paradeka', NULL, NULL),
(11, 886, 'Pathadumbara', NULL, NULL),
(11, 887, 'Pathahewaheta', NULL, NULL),
(11, 888, 'Pattitalawa', NULL, NULL),
(11, 889, 'Pattiya Watta', NULL, NULL),
(11, 890, 'Pilawala', NULL, NULL),
(11, 891, 'Poholiyadda', NULL, NULL),
(11, 892, 'Polgolla', NULL, NULL),
(11, 893, 'Pujapitiya', NULL, NULL),
(11, 894, 'Pupuressa', NULL, NULL),
(11, 895, 'Pussellawa', NULL, NULL),
(11, 896, 'Putuhapuwa', NULL, NULL),
(11, 897, 'Rajawella', NULL, NULL),
(11, 898, 'Rambukwella', NULL, NULL),
(11, 899, 'Rangala', NULL, NULL),
(11, 900, 'Rantembe', NULL, NULL),
(11, 901, 'Rikillagaskada', NULL, NULL),
(11, 902, 'Sangarajapura', NULL, NULL),
(11, 903, 'Senarathwela', NULL, NULL),
(11, 904, 'Talatuoya', NULL, NULL),
(11, 905, 'Tawalantenna', NULL, NULL),
(11, 906, 'Teldeniya', NULL, NULL),
(11, 907, 'Tennekumbura', NULL, NULL),
(11, 908, 'Uda Peradeniya', NULL, NULL),
(11, 909, 'Udadumbara', NULL, NULL),
(11, 910, 'Udahentenna', NULL, NULL),
(11, 911, 'Udapalatha', NULL, NULL),
(11, 912, 'Uda Talawinna', NULL, NULL),
(11, 913, 'Udispattuwa', NULL, NULL),
(11, 914, 'Ududumbara', NULL, NULL),
(11, 915, 'Udunuwara', NULL, NULL),
(11, 916, 'Uduwahinna', NULL, NULL),
(11, 917, 'Uduwela', NULL, NULL),
(11, 918, 'Ulapane', NULL, NULL),
(11, 919, 'Unuwinna', NULL, NULL),
(11, 920, 'Velamboda', NULL, NULL),
(11, 921, 'Watapuluwa', NULL, NULL),
(11, 922, 'Wattappola', NULL, NULL),
(11, 923, 'Wattegama', NULL, NULL),
(11, 924, 'Weligalla', NULL, NULL),
(11, 925, 'Weligampola', NULL, NULL),
(11, 926, 'Weragantota', NULL, NULL),
(11, 927, 'Werapitiya', NULL, NULL),
(11, 928, 'Werellagama', NULL, NULL),
(11, 929, 'Wettawa', NULL, NULL),
(11, 930, 'Wilanagama', NULL, NULL),
(11, 931, 'Yahalatenna', NULL, NULL),
(11, 932, 'Yatihalagala', NULL, NULL),
(11, 933, 'Yatinuwara', NULL, NULL),
(12, 934, 'Kegalle', NULL, NULL),
(12, 935, 'Mawanella', NULL, NULL),
(12, 936, 'Rambukkana', NULL, NULL),
(12, 937, 'Warakapola', NULL, NULL),
(12, 938, 'Galigamuwa', NULL, NULL),
(12, 939, 'Ruwanwella', NULL, NULL),
(12, 940, 'Aranayaka', NULL, NULL),
(12, 941, 'Dehiowita', NULL, NULL),
(12, 942, 'Alawatura', NULL, NULL),
(12, 943, 'Algama', NULL, NULL),
(12, 944, 'Alutnuwara', NULL, NULL),
(12, 945, 'Ambalakanda', NULL, NULL),
(12, 946, 'Ambepussa', NULL, NULL),
(12, 947, 'Ambulugala', NULL, NULL),
(12, 948, 'Amitirigala', NULL, NULL),
(12, 949, 'Ampagala', NULL, NULL),
(12, 950, 'Anhettigama', NULL, NULL),
(12, 951, 'Aruggammana', NULL, NULL),
(12, 952, 'Atale', NULL, NULL),
(12, 953, 'Batuwita', NULL, NULL),
(12, 954, 'Beligala', NULL, NULL),
(12, 955, 'Berannawa', NULL, NULL),
(12, 956, 'Bopitiya', NULL, NULL),
(12, 957, 'Bossella', NULL, NULL),
(12, 958, 'Bulathkohupitiya', NULL, NULL),
(12, 959, 'Damunupola', NULL, NULL),
(12, 960, 'Debathgama', NULL, NULL),
(12, 961, 'Dedugala', NULL, NULL),
(12, 962, 'Deewala Pallegama', NULL, NULL),
(12, 963, 'Deldeniya', NULL, NULL),
(12, 964, 'Deloluwa', NULL, NULL),
(12, 965, 'Deraniyagala', NULL, NULL),
(12, 966, 'Dewalegama', NULL, NULL),
(12, 967, 'Dewanagala', NULL, NULL),
(12, 968, 'Dombemada', NULL, NULL),
(12, 969, 'Dorawaka', NULL, NULL),
(12, 970, 'Galapitamada', NULL, NULL),
(12, 971, 'Galatara', NULL, NULL),
(12, 972, 'Ganithapura', NULL, NULL),
(12, 973, 'Gantuna', NULL, NULL),
(12, 974, 'Gonagala', NULL, NULL),
(12, 975, 'Hakahinna', NULL, NULL),
(12, 976, 'Hakbellawaka', NULL, NULL),
(12, 977, 'Helamada', NULL, NULL),
(12, 978, 'Hemmatagama', NULL, NULL),
(12, 979, 'Hettimulla', NULL, NULL),
(12, 980, 'Hewadiwela', NULL, NULL),
(12, 981, 'Hingula', NULL, NULL),
(12, 982, 'Hiriwadunna', NULL, NULL),
(12, 983, 'Imbulana', NULL, NULL),
(12, 984, 'Imbulgasdeniya', NULL, NULL),
(12, 985, 'Kabagamuwa', NULL, NULL),
(12, 986, 'Kannattota', NULL, NULL),
(12, 987, 'Kehelpannala', NULL, NULL),
(12, 988, 'Kitulgala', NULL, NULL),
(12, 989, 'Kotiyakumbura', NULL, NULL),
(12, 990, 'Lewangama', NULL, NULL),
(12, 991, 'Mahapallegama', NULL, NULL),
(12, 992, 'Maharangalla', NULL, NULL),
(12, 993, 'Maheena', NULL, NULL),
(12, 994, 'Makehelwala', NULL, NULL),
(12, 995, 'Malmaduwa', NULL, NULL),
(12, 996, 'Molagoda', NULL, NULL),
(12, 997, 'Morontota', NULL, NULL),
(12, 998, 'Nelundeniya', NULL, NULL),
(12, 999, 'Niyadurupola', NULL, NULL),
(12, 1000, 'Noori', NULL, NULL),
(12, 1001, 'Parape', NULL, NULL),
(12, 1002, 'Pinnawala', NULL, NULL),
(12, 1003, 'Pitagaldeniya', NULL, NULL),
(12, 1004, 'Pothukoladeniya', NULL, NULL),
(12, 1005, 'Seaforth Colony', NULL, NULL),
(12, 1006, 'Thalgaspitiya', NULL, NULL),
(12, 1007, 'Teligama', NULL, NULL),
(12, 1008, 'Tholangamuwa', NULL, NULL),
(12, 1009, 'Tulhiriya', NULL, NULL),
(12, 1010, 'Tuntota', NULL, NULL),
(12, 1011, 'Udagaldeniya', NULL, NULL),
(12, 1012, 'Undugoda', NULL, NULL),
(12, 1013, 'Ussapitiya', NULL, NULL),
(12, 1014, 'Wahakula', NULL, NULL),
(12, 1015, 'Waharaka', NULL, NULL),
(12, 1016, 'Watura', NULL, NULL),
(12, 1017, 'Weragala', NULL, NULL),
(12, 1018, 'Yaddehimullla', NULL, NULL),
(12, 1019, 'Yatapana', NULL, NULL),
(12, 1020, 'Yatiyantota', NULL, NULL),
(12, 1021, 'Yattogoda', NULL, NULL),
(13, 1022, 'Karachchi', NULL, NULL),
(13, 1023, 'Pachchilaipalli', NULL, NULL),
(13, 1024, 'Poonakary', NULL, NULL),
(14, 1025, 'Kurunegala', NULL, NULL),
(14, 1026, 'Kuliyapitiya West', NULL, NULL),
(14, 1027, 'Mawathagama', NULL, NULL),
(14, 1028, 'Narammala', NULL, NULL),
(14, 1029, 'Pannala', NULL, NULL),
(14, 1030, 'Polgahawela', NULL, NULL),
(14, 1031, 'Wariyapola', NULL, NULL),
(14, 1032, 'Alawwa', NULL, NULL),
(14, 1033, 'Alahengama', NULL, NULL),
(14, 1034, 'Alahitiyawa', NULL, NULL),
(14, 1035, 'Alawatuwala', NULL, NULL),
(14, 1036, 'Ambakote', NULL, NULL),
(14, 1037, 'Ambanpola', NULL, NULL),
(14, 1038, 'Anhandiya', NULL, NULL),
(14, 1039, 'Anukkane', NULL, NULL),
(14, 1040, 'Aragoda', NULL, NULL),
(14, 1041, 'Ataragalla', NULL, NULL),
(14, 1042, 'Awulegama', NULL, NULL),
(14, 1043, 'Balalla', NULL, NULL),
(14, 1044, 'Bamunukotuwa', NULL, NULL),
(14, 1045, 'Bandara Koswatta', NULL, NULL),
(14, 1046, 'Bingiriya', NULL, NULL),
(14, 1047, 'Bogamulla', NULL, NULL),
(14, 1048, 'Bopitiya', NULL, NULL),
(14, 1049, 'Boraluwewa', NULL, NULL),
(14, 1050, 'Boyagane', NULL, NULL),
(14, 1051, 'Bujjomuwa', NULL, NULL),
(14, 1052, 'Dambadeniya', NULL, NULL),
(14, 1053, 'Daraluwa', NULL, NULL),
(14, 1054, 'Deegalla', NULL, NULL),
(14, 1055, 'Delwite', NULL, NULL),
(14, 1056, 'Demataluwa', NULL, NULL),
(14, 1057, 'Diddeniya', NULL, NULL),
(14, 1058, 'Divullegoda', NULL, NULL),
(14, 1059, 'Dodangaslanda', NULL, NULL),
(14, 1060, 'Doratiyawa', NULL, NULL),
(14, 1061, 'Dummalasuriya', NULL, NULL),
(14, 1062, 'Ehetuwewa', NULL, NULL),
(14, 1063, 'Elibichchiya', NULL, NULL),
(14, 1064, 'Embogama', NULL, NULL),
(14, 1065, 'Etungahakotuwa', NULL, NULL),
(14, 1066, 'Galgamuwa', NULL, NULL),
(14, 1067, 'Gallewa', NULL, NULL),
(14, 1068, 'Ganewatta', NULL, NULL),
(14, 1069, 'Girathalana', NULL, NULL),
(14, 1070, 'Giribawa', NULL, NULL),
(14, 1071, 'Giriulla', NULL, NULL),
(14, 1072, 'Gokaralla', NULL, NULL),
(14, 1073, 'Gonawila', NULL, NULL),
(14, 1074, 'Halmillawewa', NULL, NULL),
(14, 1075, 'Hanhamuwa', NULL, NULL),
(14, 1076, 'Hengamuwa', NULL, NULL),
(14, 1077, 'Hettipola', NULL, NULL),
(14, 1078, 'Hilogama', NULL, NULL),
(14, 1079, 'Hindagolla', NULL, NULL),
(14, 1080, 'Hiriyala Lenawa', NULL, NULL),
(14, 1081, 'Hiruwalpola', NULL, NULL),
(14, 1082, 'Horambawa', NULL, NULL),
(14, 1083, 'Hulugalla', NULL, NULL),
(14, 1084, 'Hunupola', NULL, NULL),
(14, 1085, 'Ibbagamuwa', NULL, NULL),
(14, 1086, 'Ihala Gomugomuwa', NULL, NULL),
(14, 1087, 'Ihala Kadigamuwa', NULL, NULL),
(14, 1088, 'Ihala Katugampola', NULL, NULL),
(14, 1089, 'Ilukhena', NULL, NULL),
(14, 1090, 'Indulgodakanda', NULL, NULL),
(14, 1091, 'Inguruwatta', NULL, NULL),
(14, 1092, 'Iriyagolla', NULL, NULL),
(14, 1093, 'Ithanawatta', NULL, NULL),
(14, 1094, 'Kadigawa', NULL, NULL),
(14, 1095, 'Kahapathwala', NULL, NULL),
(14, 1096, 'Kalugamuwa', NULL, NULL),
(14, 1097, 'Kanadeniyawala', NULL, NULL),
(14, 1098, 'Kanattewewa', NULL, NULL),
(14, 1099, 'Karagahagedara', NULL, NULL),
(14, 1100, 'Karambe', NULL, NULL),
(14, 1101, 'Katupota', NULL, NULL),
(14, 1102, 'Kekunagolla', NULL, NULL),
(14, 1103, 'Kirimetiyawa', NULL, NULL),
(14, 1104, 'Kirindawa', NULL, NULL),
(14, 1105, 'Kirindigalla', NULL, NULL),
(14, 1106, 'Kithalawa', NULL, NULL),
(14, 1107, 'Kobeigane', NULL, NULL),
(14, 1108, 'Kohilagedara', NULL, NULL),
(14, 1109, 'Konwewa', NULL, NULL),
(14, 1110, 'Kosgolla', NULL, NULL),
(14, 1111, 'Kotawehera', NULL, NULL),
(14, 1112, 'Kudagalgamuwa', NULL, NULL),
(14, 1113, 'Kudakatnoruwa', NULL, NULL),
(14, 1114, 'Kuliyapitiya East', NULL, NULL),
(14, 1115, 'Kumbukgeta', NULL, NULL),
(14, 1116, 'Kumbukwewa', NULL, NULL),
(14, 1117, 'Kuratihena', NULL, NULL),
(14, 1118, 'Labbala', NULL, NULL),
(14, 1119, 'Madahapola', NULL, NULL),
(14, 1120, 'Madakumburumulla', NULL, NULL),
(14, 1121, 'Maduragoda', NULL, NULL),
(14, 1122, 'Maeliya', NULL, NULL),
(14, 1123, 'Magulagama', NULL, NULL),
(14, 1124, 'Mahagalkadawala', NULL, NULL),
(14, 1125, 'Mahagirilla', NULL, NULL),
(14, 1126, 'Mahamukalanyaya', NULL, NULL),
(14, 1127, 'Mahananneriya', NULL, NULL),
(14, 1128, 'Maharachchimulla', NULL, NULL),
(14, 1129, 'Mahawa', NULL, NULL),
(14, 1130, 'Maho', NULL, NULL),
(14, 1131, 'Makulewa', NULL, NULL),
(14, 1132, 'Makulpotha', NULL, NULL),
(14, 1133, 'Makulwewa', NULL, NULL),
(14, 1134, 'Malagane', NULL, NULL),
(14, 1135, 'Malkaduwawa', NULL, NULL),
(14, 1136, 'Mallawapitiya', NULL, NULL),
(14, 1137, 'Mandapola', NULL, NULL),
(14, 1138, 'Maspotha', NULL, NULL),
(14, 1139, 'Meegalawa', NULL, NULL),
(14, 1140, 'Meetanwala', NULL, NULL),
(14, 1141, 'Meewellawa', NULL, NULL),
(14, 1142, 'Melsiripura', NULL, NULL),
(14, 1143, 'Metikumbura', NULL, NULL),
(14, 1144, 'Metiyagane', NULL, NULL),
(14, 1145, 'Millawa', NULL, NULL),
(14, 1146, 'Minhettiya', NULL, NULL),
(14, 1147, 'Minuwangete', NULL, NULL),
(14, 1148, 'Mirihanagama', NULL, NULL),
(14, 1149, 'Moragane', NULL, NULL),
(14, 1150, 'Moragollagama', NULL, NULL),
(14, 1151, 'Morathiha', NULL, NULL),
(14, 1152, 'Munamaldeniya', NULL, NULL),
(14, 1153, 'Nabadewa', NULL, NULL),
(14, 1154, 'Nagollagama', NULL, NULL),
(14, 1155, 'Nagollagoda', NULL, NULL),
(14, 1156, 'Nakkawatta', NULL, NULL),
(14, 1157, 'Narangoda', NULL, NULL),
(14, 1158, 'Nawatalwatta', NULL, NULL),
(14, 1159, 'Nelliya', NULL, NULL),
(14, 1160, 'Nikadalupotha', NULL, NULL),
(14, 1161, 'Nikaweratiya', NULL, NULL),
(14, 1162, 'Padeniya', NULL, NULL),
(14, 1163, 'Padiwela', NULL, NULL),
(14, 1164, 'Pahalagiribawa', NULL, NULL),
(14, 1165, 'Pahamune', NULL, NULL),
(14, 1166, 'Panagamuwa', NULL, NULL),
(14, 1167, 'Panaliya', NULL, NULL),
(14, 1168, 'Panduwasnuwara', NULL, NULL),
(14, 1169, 'Panliyadda', NULL, NULL),
(14, 1170, 'Pansiyagama', NULL, NULL),
(14, 1171, 'Periyakadneluwa', NULL, NULL),
(14, 1172, 'Pihimbiya Ratmale', NULL, NULL),
(14, 1173, 'Pihimbuwa', NULL, NULL),
(14, 1174, 'Pilessa', NULL, NULL),
(14, 1175, 'Polpitigama', NULL, NULL),
(14, 1176, 'Pothuhera', NULL, NULL),
(14, 1177, 'Puswelitenna', NULL, NULL),
(14, 1178, 'Ranawana', NULL, NULL),
(14, 1179, 'Rasnayakapura', NULL, NULL),
(14, 1180, 'Ridibendiella', NULL, NULL),
(14, 1181, 'Ridigama', NULL, NULL),
(14, 1182, 'Sandalankawa', NULL, NULL),
(14, 1183, 'Sirisetagama', NULL, NULL),
(14, 1184, 'Siyambalangamuwa', NULL, NULL),
(14, 1185, 'Talawattegedara', NULL, NULL),
(14, 1186, 'Tambutta', NULL, NULL),
(14, 1187, 'Thalakolawewa', NULL, NULL),
(14, 1188, 'Thalwita', NULL, NULL),
(14, 1189, 'Thambagalla', NULL, NULL),
(14, 1190, 'Tharana Udawela', NULL, NULL),
(14, 1191, 'Thelembugalla', NULL, NULL),
(14, 1192, 'Tisogama', NULL, NULL),
(14, 1193, 'Torayaya', NULL, NULL),
(14, 1194, 'Tuttiripitigama', NULL, NULL),
(14, 1195, 'Udubaddawa', NULL, NULL),
(14, 1196, 'Uhumiya', NULL, NULL),
(14, 1197, 'Usgala Siyabmalangamuwa', NULL, NULL),
(14, 1198, 'Wadakada', NULL, NULL),
(14, 1199, 'Wadumunnegedara', NULL, NULL),
(14, 1200, 'Walakumburumulla', NULL, NULL),
(14, 1201, 'Wannigama', NULL, NULL),
(14, 1202, 'Wannirasnayakapura', NULL, NULL),
(14, 1203, 'Watuwatta', NULL, NULL),
(14, 1204, 'Weerambugedara', NULL, NULL),
(14, 1205, 'Weerapokuna', NULL, NULL),
(14, 1206, 'Welawa Juncton', NULL, NULL),
(14, 1207, 'Welipennagahamulla', NULL, NULL),
(14, 1208, 'Wellagala', NULL, NULL),
(14, 1209, 'Wellarawa', NULL, NULL),
(14, 1210, 'Wellawa', NULL, NULL),
(14, 1211, 'Welpalla', NULL, NULL),
(14, 1212, 'Weuda', NULL, NULL),
(14, 1213, 'Wewagama', NULL, NULL),
(14, 1214, 'Yakwila', NULL, NULL),
(14, 1215, 'Yatigaloluwa', NULL, NULL),
(15, 1216, 'Mannar', NULL, NULL),
(15, 1217, 'Pesalai', NULL, NULL),
(15, 1218, 'Nanattan', NULL, NULL),
(15, 1219, 'Chilavathurai', NULL, NULL),
(15, 1220, 'Dharapuram', NULL, NULL),
(15, 1221, 'Adampan', NULL, NULL),
(15, 1222, 'Talaimannar', NULL, NULL),
(15, 1223, 'Murunkan', NULL, NULL),
(15, 1224, 'Athimottai', NULL, NULL),
(15, 1225, 'Erukkalampiddy', NULL, NULL),
(15, 1226, 'Madhu Road', NULL, NULL),
(15, 1227, 'P.P.Potkemy', NULL, NULL),
(15, 1228, 'Temple', NULL, NULL),
(15, 1229, 'Vankalai', NULL, NULL),
(15, 1230, 'Vellan Kulam', NULL, NULL),
(15, 1231, 'Vidataltivu', NULL, NULL),
(16, 1232, 'Matale', NULL, NULL),
(16, 1233, 'Dambulla', NULL, NULL),
(16, 1234, 'Palapathwela', NULL, NULL),
(16, 1235, 'Galewela', NULL, NULL),
(16, 1236, 'Ukuwela', NULL, NULL),
(16, 1237, 'Mahawela', NULL, NULL),
(16, 1238, 'Naula', NULL, NULL),
(16, 1239, 'Rattota', NULL, NULL),
(16, 1240, 'Akuramboda', NULL, NULL),
(16, 1241, 'Alwatta', NULL, NULL),
(16, 1242, 'Ambana', NULL, NULL),
(16, 1243, 'Bambaragaswewa', NULL, NULL),
(16, 1244, 'Beligamuwa', NULL, NULL),
(16, 1245, 'Dankanda', NULL, NULL),
(16, 1246, 'Dewahuwa', NULL, NULL),
(16, 1247, 'Dullewa', NULL, NULL),
(16, 1248, 'Dunkolawatta', NULL, NULL),
(16, 1249, 'Dunuwilapitiya', NULL, NULL),
(16, 1250, 'Elkaduwa', NULL, NULL),
(16, 1251, 'Erawula Junction', NULL, NULL),
(16, 1252, 'Etanawala', NULL, NULL),
(16, 1253, 'Gammaduwa', NULL, NULL),
(16, 1254, 'Handungamuwa', NULL, NULL),
(16, 1255, 'Hattota Amuna', NULL, NULL),
(16, 1256, 'Illukkumbura', NULL, NULL),
(16, 1257, 'Imbulgolla', NULL, NULL),
(16, 1258, 'Inamaluwa', NULL, NULL),
(16, 1259, 'Kaikawala', NULL, NULL),
(16, 1260, 'Kalundawa', NULL, NULL),
(16, 1261, 'Kandalama', NULL, NULL),
(16, 1262, 'Katudeniya', NULL, NULL),
(16, 1263, 'Kavudupelella', NULL, NULL),
(16, 1264, 'Kibissa', NULL, NULL),
(16, 1265, 'Kiwula', NULL, NULL),
(16, 1266, 'Laggala Pallegama', NULL, NULL),
(16, 1267, 'Leliambe', NULL, NULL),
(16, 1268, 'Lenadora', NULL, NULL),
(16, 1269, 'Madawala Ulpotha', NULL, NULL),
(16, 1270, 'Madipola', NULL, NULL),
(16, 1271, 'Mananwatta', NULL, NULL),
(16, 1272, 'Maraka', NULL, NULL),
(16, 1273, 'Melipitiya', NULL, NULL),
(16, 1274, 'Metihakka', NULL, NULL),
(16, 1275, 'Millawana', NULL, NULL),
(16, 1276, 'Nalanda', NULL, NULL),
(16, 1277, 'Nugagolla', NULL, NULL),
(16, 1278, 'Ovilikanda', NULL, NULL),
(16, 1279, 'Pallepola', NULL, NULL),
(16, 1280, 'Ranamuregama', NULL, NULL),
(16, 1281, 'Sigiriya', NULL, NULL),
(16, 1282, 'Talagoda Junction', NULL, NULL),
(16, 1283, 'Talakiriyagama', NULL, NULL),
(16, 1284, 'Udasgiriya', NULL, NULL),
(16, 1285, 'Udatenna', NULL, NULL),
(16, 1286, 'Wahacotte', NULL, NULL),
(16, 1287, 'Walawela', NULL, NULL),
(16, 1288, 'Wehigala', NULL, NULL),
(16, 1289, 'Wilgamuwa', NULL, NULL),
(16, 1290, 'Yatawatta', NULL, NULL),
(17, 1291, 'Matara', NULL, NULL),
(17, 1292, 'Akuressa', NULL, NULL),
(17, 1293, 'Weligama', NULL, NULL),
(17, 1294, 'Dikwella', NULL, NULL),
(17, 1295, 'Hakmana', NULL, NULL),
(17, 1296, 'Kamburupitiya', NULL, NULL),
(17, 1297, 'Kekanadurra', NULL, NULL),
(17, 1298, 'Kamburugamuwa', NULL, NULL),
(17, 1299, 'Alapaladeniya', NULL, NULL),
(17, 1300, 'Aparekka', NULL, NULL),
(17, 1301, 'Athuraliya', NULL, NULL),
(17, 1302, 'Bengamuwa', NULL, NULL),
(17, 1303, 'Beralapanathara', NULL, NULL),
(17, 1304, 'Bopagoda', NULL, NULL),
(17, 1305, 'Dampahala', NULL, NULL),
(17, 1306, 'Deiyandara', NULL, NULL),
(17, 1307, 'Dellawa', NULL, NULL),
(17, 1308, 'Denagama', NULL, NULL),
(17, 1309, 'Denipitiya', NULL, NULL),
(17, 1310, 'Deniyaya', NULL, NULL),
(17, 1311, 'Derangala', NULL, NULL),
(17, 1312, 'Devinuwara', NULL, NULL),
(17, 1313, 'Diyagaha', NULL, NULL),
(17, 1314, 'Diyalape', NULL, NULL),
(17, 1315, 'Gandara', NULL, NULL),
(17, 1316, 'Godapitiya', NULL, NULL),
(17, 1317, 'Gomilamawarala', NULL, NULL),
(17, 1318, 'Handugala', NULL, NULL),
(17, 1319, 'Horapawita', NULL, NULL),
(17, 1320, 'Kalubowitiyana', NULL, NULL),
(17, 1321, 'Karagoda Uyangoda', NULL, NULL),
(17, 1322, 'Karatota', NULL, NULL),
(17, 1323, 'Kirinda-Puhulwella', NULL, NULL),
(17, 1324, 'Kiriwelkele', NULL, NULL),
(17, 1325, 'Kotapola', NULL, NULL),
(17, 1326, 'Kottegoda', NULL, NULL),
(17, 1327, 'Makandura', NULL, NULL),
(17, 1328, 'Maliduwa', NULL, NULL),
(17, 1329, 'Malimbada', NULL, NULL),
(17, 1330, 'Maramba', NULL, NULL),
(17, 1331, 'Mediripitiya', NULL, NULL),
(17, 1332, 'Miella', NULL, NULL),
(17, 1333, 'Mirissa', NULL, NULL),
(17, 1334, 'Moragala Kirillapone', NULL, NULL),
(17, 1335, 'Morawaka', NULL, NULL),
(17, 1336, 'Mulatiyana', NULL, NULL),
(17, 1337, 'Mulatiyana Junction', NULL, NULL),
(17, 1338, 'Nadugala', NULL, NULL),
(17, 1339, 'Naimana', NULL, NULL),
(17, 1340, 'Palatuwa', NULL, NULL),
(17, 1341, 'Parapamulla', NULL, NULL),
(17, 1342, 'Pasgoda', NULL, NULL),
(17, 1343, 'Penetiyana', NULL, NULL),
(17, 1344, 'Pitabeddara', NULL, NULL),
(17, 1345, 'Polhena', NULL, NULL),
(17, 1346, 'Puhulwella', NULL, NULL),
(17, 1347, 'Radawela', NULL, NULL),
(17, 1348, 'Ransegoda', NULL, NULL),
(17, 1349, 'Ratmale', NULL, NULL),
(17, 1350, 'Rotumba', NULL, NULL),
(17, 1351, 'Siyambalagoda', NULL, NULL),
(17, 1352, 'Sultanagoda', NULL, NULL),
(17, 1353, 'Telijjawila', NULL, NULL),
(17, 1354, 'Thihagoda', NULL, NULL),
(17, 1355, 'Urubokka', NULL, NULL),
(17, 1356, 'Urugamuwa', NULL, NULL),
(17, 1357, 'Urumutta', NULL, NULL),
(17, 1358, 'Viharahena', NULL, NULL),
(17, 1359, 'Walakanda', NULL, NULL),
(17, 1360, 'Walasgala', NULL, NULL),
(17, 1361, 'Walpola', NULL, NULL),
(17, 1362, 'Waralla', NULL, NULL),
(17, 1363, 'Wilpita', NULL, NULL),
(17, 1364, 'Yatiyana', NULL, NULL),
(18, 1365, 'Moneragala', NULL, NULL),
(18, 1366, 'Wellawaya', NULL, NULL),
(18, 1367, 'Buttala', NULL, NULL),
(18, 1368, 'Bibile', NULL, NULL),
(18, 1369, 'Kataragama', NULL, NULL),
(18, 1370, 'Medagana', NULL, NULL),
(18, 1371, 'Hulandawa', NULL, NULL),
(18, 1372, 'Tanamalwila', NULL, NULL),
(18, 1373, 'Ayiwela', NULL, NULL),
(18, 1374, 'Badalkumbura', NULL, NULL),
(18, 1375, 'Baduluwela', NULL, NULL),
(18, 1376, 'Bakinigahawela', NULL, NULL),
(18, 1377, 'Boragas', NULL, NULL),
(18, 1378, 'Dambagalla', NULL, NULL),
(18, 1379, 'Dombagahawela', NULL, NULL),
(18, 1380, 'Ekamutugama', NULL, NULL),
(18, 1381, 'Ekiriyankumbura', NULL, NULL),
(18, 1382, 'Ethimalewewa', NULL, NULL),
(18, 1383, 'Ettiliwewa', NULL, NULL),
(18, 1384, 'Galabedda', NULL, NULL),
(18, 1385, 'Hambegamuwa', NULL, NULL),
(18, 1386, 'Kandaudapanguwa', NULL, NULL),
(18, 1387, 'Kandawinna', NULL, NULL),
(18, 1388, 'Kiriibbanwewa', NULL, NULL),
(18, 1389, 'Kotagama', NULL, NULL),
(18, 1390, 'Kotawehera Mankada', NULL, NULL),
(18, 1391, 'Kumbukkana', NULL, NULL),
(18, 1392, 'Modulla', NULL, NULL),
(18, 1393, 'Mahagama Colony', NULL, NULL),
(18, 1394, 'Marawa', NULL, NULL),
(18, 1395, 'Mariarawa', NULL, NULL),
(18, 1396, 'Nakkala', NULL, NULL),
(18, 1397, 'Nannapurawa', NULL, NULL),
(18, 1398, 'Nilgala', NULL, NULL),
(18, 1399, 'Obbegoda', NULL, NULL),
(18, 1400, 'Okkampitiya', NULL, NULL),
(18, 1401, 'Ruwalwela', NULL, NULL),
(18, 1402, 'Sella Kataragama', NULL, NULL),
(18, 1403, 'Sewanagala', NULL, NULL),
(18, 1404, 'Siyambalagune', NULL, NULL),
(18, 1405, 'Siyambalanduwa', NULL, NULL),
(18, 1406, 'Uva Gangodagama', NULL, NULL),
(18, 1407, 'Uva Pelwatta', NULL, NULL),
(18, 1408, 'Warunagama', NULL, NULL),
(18, 1409, 'Wedikumbura', NULL, NULL),
(18, 1410, 'Weherayaya Handapanagala', NULL, NULL),
(18, 1411, 'Wilaoya', NULL, NULL),
(19, 1412, 'Mullativu', NULL, NULL),
(19, 1413, 'Pudukudiyirippu', NULL, NULL),
(19, 1414, 'Mulliyawalai', NULL, NULL),
(19, 1415, 'Udayarkaddu', NULL, NULL),
(19, 1416, 'Alampil', NULL, NULL),
(19, 1417, 'Odduchudan', NULL, NULL),
(19, 1418, 'Mullivaikkal', NULL, NULL),
(19, 1419, 'Visvamadukulam', NULL, NULL),
(19, 1420, 'Karuppaddamurippu', NULL, NULL),
(19, 1421, 'Kokkilai', NULL, NULL),
(19, 1422, 'Mankulam', NULL, NULL),
(19, 1423, 'Maritimepattu', NULL, NULL),
(20, 1424, 'Nuwara Eliya', NULL, NULL),
(20, 1425, 'Hatton', NULL, NULL),
(20, 1426, 'Ginigathena', NULL, NULL),
(20, 1427, 'Talawakele', NULL, NULL),
(20, 1428, 'Hanguranketha', NULL, NULL),
(20, 1429, 'Kotmale', NULL, NULL),
(20, 1430, 'Kandapola', NULL, NULL),
(20, 1431, 'Agarapathana', NULL, NULL),
(20, 1432, 'Ambagamuwa Udabulathgama', NULL, NULL);
INSERT INTO `ma_location` (`districts_code`, `location_code`, `location_name`, `latitude`, `longitude`) VALUES
(20, 1433, 'Ambewela', NULL, NULL),
(20, 1434, 'Bogawantalawa', NULL, NULL),
(20, 1435, 'Dagampitiya', NULL, NULL),
(20, 1436, 'Dayagama Bazaar', NULL, NULL),
(20, 1437, 'Dikoya', NULL, NULL),
(20, 1438, 'Doragala', NULL, NULL),
(20, 1439, 'Haggala', NULL, NULL),
(20, 1440, 'Halgranoya', NULL, NULL),
(20, 1441, 'Hangarapitiya', NULL, NULL),
(20, 1442, 'Hapugastalawa', NULL, NULL),
(20, 1443, 'Harasbedda', NULL, NULL),
(20, 1444, 'Hedunuwewa', NULL, NULL),
(20, 1445, 'Hitigegama', NULL, NULL),
(20, 1446, 'Kalaganwatta', NULL, NULL),
(20, 1447, 'Katukitula', NULL, NULL),
(20, 1448, 'Keerthi Bandarapura', NULL, NULL),
(20, 1449, 'Kotagala', NULL, NULL),
(20, 1450, 'Kottellena', NULL, NULL),
(20, 1451, 'Labukele', NULL, NULL),
(20, 1452, 'Laxapana', NULL, NULL),
(20, 1453, 'Lindula', NULL, NULL),
(20, 1454, 'Maskeliya', NULL, NULL),
(20, 1455, 'Maswela', NULL, NULL),
(20, 1456, 'Mipanawa', NULL, NULL),
(20, 1457, 'Mipilimana', NULL, NULL),
(20, 1458, 'Munwatta', NULL, NULL),
(20, 1459, 'Nanuoya', NULL, NULL),
(20, 1460, 'Nawathispane', NULL, NULL),
(20, 1461, 'Nildandahinna', NULL, NULL),
(20, 1462, 'Norwood', NULL, NULL),
(20, 1463, 'Padiyapelella', NULL, NULL),
(20, 1464, 'Patana', NULL, NULL),
(20, 1465, 'Pattipola', NULL, NULL),
(20, 1466, 'Pitawala', NULL, NULL),
(20, 1467, 'Pundaluoya', NULL, NULL),
(20, 1468, 'Ramboda', NULL, NULL),
(20, 1469, 'Ruwaneliya', NULL, NULL),
(20, 1470, 'Santhipura', NULL, NULL),
(20, 1471, 'Teripeha', NULL, NULL),
(20, 1472, 'Udapussallawa', NULL, NULL),
(20, 1473, 'Walapane', NULL, NULL),
(20, 1474, 'Watagoda', NULL, NULL),
(20, 1475, 'Watawala', NULL, NULL),
(20, 1476, 'Widulipura', NULL, NULL),
(21, 1477, 'Polonnaruwa', NULL, NULL),
(21, 1478, 'Hingurakgoda', NULL, NULL),
(21, 1479, 'Kaduruwela', NULL, NULL),
(21, 1480, 'Jayasiripura', NULL, NULL),
(21, 1481, 'Medirigiriya', NULL, NULL),
(21, 1482, 'Jayanthipura', NULL, NULL),
(21, 1483, 'Aralaganwila', NULL, NULL),
(21, 1484, 'Bakamuna', NULL, NULL),
(21, 1485, 'Alutwewa', NULL, NULL),
(21, 1486, 'Attanakadawala', NULL, NULL),
(21, 1487, 'Dalukana', NULL, NULL),
(21, 1488, 'Dewagala', NULL, NULL),
(21, 1489, 'Dimbulagala', NULL, NULL),
(21, 1490, 'Divulankadawala', NULL, NULL),
(21, 1491, 'Diyabeduma', NULL, NULL),
(21, 1492, 'Diyasenpura', NULL, NULL),
(21, 1493, 'Elahera', NULL, NULL),
(21, 1494, 'Ellewewa', NULL, NULL),
(21, 1495, 'Galamuna', NULL, NULL),
(21, 1496, 'Galoya Junction', NULL, NULL),
(21, 1497, 'Giritale', NULL, NULL),
(21, 1498, 'Hingurakdamana', NULL, NULL),
(21, 1499, 'Kalingaela', NULL, NULL),
(21, 1500, 'Kalukele Badanagala', NULL, NULL),
(21, 1501, 'Kashyapapura', NULL, NULL),
(21, 1502, 'Kawudulla', NULL, NULL),
(21, 1503, 'Kottapitiya', NULL, NULL),
(21, 1504, 'Kumaragama', NULL, NULL),
(21, 1505, 'Lakshauyana', NULL, NULL),
(21, 1506, 'Lankapura', NULL, NULL),
(21, 1507, 'Maha Ambagaswewa', NULL, NULL),
(21, 1508, 'Mampitiya', NULL, NULL),
(21, 1509, 'Minneriya', NULL, NULL),
(21, 1510, 'Nelumwewa', NULL, NULL),
(21, 1511, 'Nuwaragala', NULL, NULL),
(21, 1512, 'Onegama', NULL, NULL),
(21, 1513, 'Palugasdamana', NULL, NULL),
(21, 1514, 'Parakramasamudraya', NULL, NULL),
(21, 1515, 'Pelatiyawa', NULL, NULL),
(21, 1516, 'Pimburattewa', NULL, NULL),
(21, 1517, 'Pulastigama', NULL, NULL),
(21, 1518, 'Sevanapitiya', NULL, NULL),
(21, 1519, 'Sungavila', NULL, NULL),
(21, 1520, 'Talpotha', NULL, NULL),
(21, 1521, 'Tamankaduwa', NULL, NULL),
(21, 1522, 'Tambala', NULL, NULL),
(21, 1523, 'Unagalavehera', NULL, NULL),
(21, 1524, 'Welikanda', NULL, NULL),
(21, 1525, 'Yodaela', NULL, NULL),
(22, 1526, 'Chilaw', NULL, NULL),
(22, 1527, 'Wennappuwa', NULL, NULL),
(22, 1528, 'Puttalam', NULL, NULL),
(22, 1529, 'Dankotuwa', NULL, NULL),
(22, 1530, 'Marawila', NULL, NULL),
(22, 1531, 'Nattandiya', NULL, NULL),
(22, 1532, 'Madampe', NULL, NULL),
(22, 1533, 'Kalpitiya', NULL, NULL),
(22, 1534, 'Adippala', NULL, NULL),
(22, 1535, 'Ambakandawila', NULL, NULL),
(22, 1536, 'Anamaduwa', NULL, NULL),
(22, 1537, 'Andigama', NULL, NULL),
(22, 1538, 'Angunawila', NULL, NULL),
(22, 1539, 'Arachchikattuwa', NULL, NULL),
(22, 1540, 'Attawilluwa', NULL, NULL),
(22, 1541, 'Bangadeniya', NULL, NULL),
(22, 1542, 'Battuluoya', NULL, NULL),
(22, 1543, 'Bujjampola', NULL, NULL),
(22, 1544, 'Dunkannawa', NULL, NULL),
(22, 1545, 'Eluwankulama', NULL, NULL),
(22, 1546, 'Ettale', NULL, NULL),
(22, 1547, 'Galmuruwa', NULL, NULL),
(22, 1548, 'Ihala Kottaramulla', NULL, NULL),
(22, 1549, 'Ihala Puliyankulama', NULL, NULL),
(22, 1550, 'Ilippadeniya', NULL, NULL),
(22, 1551, 'Ismailpuram', NULL, NULL),
(22, 1552, 'Kakkapalliya', NULL, NULL),
(22, 1553, 'Kalladiya', NULL, NULL),
(22, 1554, 'Kandakuliya', NULL, NULL),
(22, 1555, 'Karativponparappi', NULL, NULL),
(22, 1556, 'Karawitagara', NULL, NULL),
(22, 1557, 'Karuwalagaswewa', NULL, NULL),
(22, 1558, 'Katuneriya', NULL, NULL),
(22, 1559, 'Koswatta', NULL, NULL),
(22, 1560, 'Kottantivu', NULL, NULL),
(22, 1561, 'Kottukachchiya', NULL, NULL),
(22, 1562, 'Kudawewa', NULL, NULL),
(22, 1563, 'Kumarakattuwa', NULL, NULL),
(22, 1564, 'Kurinjanpitiya', NULL, NULL),
(22, 1565, 'Lihiriyagama', NULL, NULL),
(22, 1566, 'Lunuwila', NULL, NULL),
(22, 1567, 'Madurankuliya', NULL, NULL),
(22, 1568, 'Mahakumbukkadawala', NULL, NULL),
(22, 1569, 'Mahauswewa', NULL, NULL),
(22, 1570, 'Mahawewa', NULL, NULL),
(22, 1571, 'Mampuri', NULL, NULL),
(22, 1572, 'Mangalaeliya', NULL, NULL),
(22, 1573, 'Mudalakkuliya', NULL, NULL),
(22, 1574, 'Mudukatuwa', NULL, NULL),
(22, 1575, 'Mugunuwatawana', NULL, NULL),
(22, 1576, 'Mukkutoduwawa', NULL, NULL),
(22, 1577, 'Mundalama', NULL, NULL),
(22, 1578, 'Mundel', NULL, NULL),
(22, 1579, 'Nainamadama', NULL, NULL),
(22, 1580, 'Nalladarankattuwa', NULL, NULL),
(22, 1581, 'Nawagattegama', NULL, NULL),
(22, 1582, 'Norachcholai', NULL, NULL),
(22, 1583, 'Palaviya', NULL, NULL),
(22, 1584, 'Pallama', NULL, NULL),
(22, 1585, 'Palliwasalturai', NULL, NULL),
(22, 1586, 'Pothuwatawana', NULL, NULL),
(22, 1587, 'Puttalam Cement Factory', NULL, NULL),
(22, 1588, 'Rajakadaluwa', NULL, NULL),
(22, 1589, 'Saliyawewa Junction', NULL, NULL),
(22, 1590, 'Serukele', NULL, NULL),
(22, 1591, 'Sirambiadiya', NULL, NULL),
(22, 1592, 'Tabbowa', NULL, NULL),
(22, 1593, 'Talawila Church', NULL, NULL),
(22, 1594, 'Toduwawa', NULL, NULL),
(22, 1595, 'Udappuwa', NULL, NULL),
(22, 1596, 'Vanathawilluwa', NULL, NULL),
(22, 1597, 'Waikkal', NULL, NULL),
(22, 1598, 'Wijeyakatupotha', NULL, NULL),
(22, 1599, 'Wilpotha', NULL, NULL),
(22, 1600, 'Yogiyana', NULL, NULL),
(23, 1601, 'Ratnapura', NULL, NULL),
(23, 1602, 'Embilipitiya', NULL, NULL),
(23, 1603, 'Balangoda', NULL, NULL),
(23, 1604, 'Kuruwita', NULL, NULL),
(23, 1605, 'Eheliyagoda', NULL, NULL),
(23, 1606, 'Pelmadulla', NULL, NULL),
(23, 1607, 'Godakawela', NULL, NULL),
(23, 1608, 'Kahawatta', NULL, NULL),
(23, 1609, 'Akarella', NULL, NULL),
(23, 1610, 'Atakalanpanna', NULL, NULL),
(23, 1611, 'Ayagama', NULL, NULL),
(23, 1612, 'Batatota', NULL, NULL),
(23, 1613, 'Belihuloya', NULL, NULL),
(23, 1614, 'Bolthumbe', NULL, NULL),
(23, 1615, 'Bulutota', NULL, NULL),
(23, 1616, 'Dambuluwana', NULL, NULL),
(23, 1617, 'Dela', NULL, NULL),
(23, 1618, 'Delwala', NULL, NULL),
(23, 1619, 'Demuwatha', NULL, NULL),
(23, 1620, 'Dodampe', NULL, NULL),
(23, 1621, 'Doloswalakanda', NULL, NULL),
(23, 1622, 'Dumbara Manana', NULL, NULL),
(23, 1623, 'Elapatha', NULL, NULL),
(23, 1624, 'Ellagawa', NULL, NULL),
(23, 1625, 'Ellawala', NULL, NULL),
(23, 1626, 'Eratna', NULL, NULL),
(23, 1627, 'Erepola', NULL, NULL),
(23, 1628, 'Gabbela', NULL, NULL),
(23, 1629, 'Gallella', NULL, NULL),
(23, 1630, 'Gawaragiriya', NULL, NULL),
(23, 1631, 'Getahetta', NULL, NULL),
(23, 1632, 'Gillimale', NULL, NULL),
(23, 1633, 'Godagampola', NULL, NULL),
(23, 1634, 'Hapugastenna', NULL, NULL),
(23, 1635, 'Hidellana', NULL, NULL),
(23, 1636, 'Ihalagama', NULL, NULL),
(23, 1637, 'Imbulpe', NULL, NULL),
(23, 1638, 'Kahangama', NULL, NULL),
(23, 1639, 'Kalawana', NULL, NULL),
(23, 1640, 'Kaltota', NULL, NULL),
(23, 1641, 'Karandana', NULL, NULL),
(23, 1642, 'Karangoda', NULL, NULL),
(23, 1643, 'Kella Junction', NULL, NULL),
(23, 1644, 'Kiriella', NULL, NULL),
(23, 1645, 'Kolambageara', NULL, NULL),
(23, 1646, 'Kolombugama', NULL, NULL),
(23, 1647, 'Kolonna', NULL, NULL),
(23, 1648, 'Lellopitiya', NULL, NULL),
(23, 1649, 'Madalagama', NULL, NULL),
(23, 1650, 'Malwala Junction', NULL, NULL),
(23, 1651, 'Marapana', NULL, NULL),
(23, 1652, 'Matuwagalagama', NULL, NULL),
(23, 1653, 'Mitipola', NULL, NULL),
(23, 1654, 'Mulgama', NULL, NULL),
(23, 1655, 'Nawalakanda', NULL, NULL),
(23, 1656, 'NawinnaPinnakanda', NULL, NULL),
(23, 1657, 'Niralagama', NULL, NULL),
(23, 1658, 'Nivitigala', NULL, NULL),
(23, 1659, 'Opanayaka', NULL, NULL),
(23, 1660, 'Padalangala', NULL, NULL),
(23, 1661, 'Pallebedda', NULL, NULL),
(23, 1662, 'Panamura', NULL, NULL),
(23, 1663, 'Panapitiya', NULL, NULL),
(23, 1664, 'Panapola', NULL, NULL),
(23, 1665, 'Panawala', NULL, NULL),
(23, 1666, 'Parakaduwa', NULL, NULL),
(23, 1667, 'Pebotuwa', NULL, NULL),
(23, 1668, 'Pothupitiya', NULL, NULL),
(23, 1669, 'Rajawaka', NULL, NULL),
(23, 1670, 'Rakwana', NULL, NULL),
(23, 1671, 'Ranwala', NULL, NULL),
(23, 1672, 'Rassagala', NULL, NULL),
(23, 1673, 'Ratna Hangamuwa', NULL, NULL),
(23, 1674, 'Samanalawewa', NULL, NULL),
(23, 1675, 'Sri Palabaddala', NULL, NULL),
(23, 1676, 'Sudagala', NULL, NULL),
(23, 1677, 'Teppanawa', NULL, NULL),
(23, 1678, 'Tunkama', NULL, NULL),
(23, 1679, 'Udaha Hawupe', NULL, NULL),
(23, 1680, 'Udakarawita', NULL, NULL),
(23, 1681, 'Udaniriella', NULL, NULL),
(23, 1682, 'Udawalawe', NULL, NULL),
(23, 1683, 'Veddagala', NULL, NULL),
(23, 1684, 'Watapotha', NULL, NULL),
(23, 1685, 'Waturawa', NULL, NULL),
(23, 1686, 'Weligepola', NULL, NULL),
(23, 1687, 'Welipathayaya', NULL, NULL),
(23, 1688, 'Wewelwatta', NULL, NULL),
(24, 1689, 'Trincomalee', NULL, NULL),
(24, 1690, 'Kantalai', NULL, NULL),
(24, 1691, 'Kinniya', NULL, NULL),
(24, 1692, 'Mutur', NULL, NULL),
(24, 1693, 'Chinabay', NULL, NULL),
(24, 1694, 'Nilaveli', NULL, NULL),
(24, 1695, 'Mullipothana', NULL, NULL),
(24, 1696, 'Kanniya', NULL, NULL),
(24, 1697, 'Agbopura', NULL, NULL),
(24, 1698, 'Dehiwatte', NULL, NULL),
(24, 1699, 'Galmetiyawa', NULL, NULL),
(24, 1700, 'Gomarankadawala', NULL, NULL),
(24, 1701, 'Kaddaiparichchan', NULL, NULL),
(24, 1702, 'Kiliveddy', NULL, NULL),
(24, 1703, 'Kuchchaveli', NULL, NULL),
(24, 1704, 'Kumburupiddy', NULL, NULL),
(24, 1705, 'Kurinchakemy', NULL, NULL),
(24, 1706, 'Mahadivulwewa', NULL, NULL),
(24, 1707, 'Morawewa', NULL, NULL),
(24, 1708, 'Padavi Sri Pura', NULL, NULL),
(24, 1709, 'Sampaltivu', NULL, NULL),
(24, 1710, 'Serunuwara', NULL, NULL),
(24, 1711, 'Seruwila', NULL, NULL),
(24, 1712, 'Tampalakamam', NULL, NULL),
(24, 1713, 'Tiriyayi', NULL, NULL),
(24, 1714, 'Toppur', NULL, NULL),
(24, 1715, 'Vellamanal', NULL, NULL),
(24, 1716, 'Wanela', NULL, NULL),
(25, 1717, 'Vavuniya South', NULL, NULL),
(25, 1718, 'Vavuniya North', NULL, NULL),
(25, 1719, 'Cheddikulam', NULL, NULL),
(25, 1720, 'Kilinochchi', NULL, NULL),
(25, 1721, 'Neriyakulam', NULL, NULL),
(25, 1722, 'Pampaimadu', NULL, NULL),
(25, 1723, 'Omanthai', NULL, NULL),
(25, 1724, 'Vinayagapuram', NULL, NULL),
(25, 1725, 'Akkarayankulam', NULL, NULL),
(25, 1726, 'Elephant Pass', NULL, NULL),
(25, 1727, 'Kanagarayankulam', NULL, NULL),
(25, 1728, 'Mamaduwa', NULL, NULL),
(25, 1729, 'Maraiyadithakulam', NULL, NULL),
(25, 1730, 'Mulliyan', NULL, NULL),
(25, 1731, 'Nedunkemy', NULL, NULL),
(25, 1732, 'Periyathambanai', NULL, NULL),
(25, 1733, 'Periyaulukkulam', NULL, NULL),
(25, 1734, 'Ramanathapuram', NULL, NULL),
(25, 1735, 'Sasthrikulankulam', NULL, NULL),
(25, 1736, 'Sivapuram', NULL, NULL),
(25, 1737, 'Vaddakachchi', NULL, NULL),
(25, 1738, 'Varikkuttiyoor', NULL, NULL),
(25, 1739, 'Vengalacheddiculam', NULL, NULL),
(25, 1740, 'Veravil', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mcq`
--

CREATE TABLE IF NOT EXISTS `mcq` (
  `mcq_code` int(11) NOT NULL AUTO_INCREMENT,
  `category_code` int(11) NOT NULL,
  `paper_type_code` int(11) NOT NULL,
  `year` int(4) NOT NULL,
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`mcq_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mcq`
--

INSERT INTO `mcq` (`mcq_code`, `category_code`, `paper_type_code`, `year`, `id`, `date`) VALUES
(1, 21, 0, 2000, 1, '2015-09-24 16:16:54'),
(2, 21, 0, 2001, 1, '2015-09-24 16:18:04');

-- --------------------------------------------------------

--
-- Table structure for table `mcq_answers`
--

CREATE TABLE IF NOT EXISTS `mcq_answers` (
  `mcq_answers_code` int(11) NOT NULL AUTO_INCREMENT,
  `mcq_questions_code` int(11) NOT NULL,
  `answers` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `valid` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  PRIMARY KEY (`mcq_answers_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `mcq_answers`
--

INSERT INTO `mcq_answers` (`mcq_answers_code`, `mcq_questions_code`, `answers`, `valid`, `comment`) VALUES
(2, 2, '<p>&nbsp;උපසිරැසිය හදලා ඉවර වෙලා මගේම උපසිරැසියෙන්&nbsp;තෝරාගත්තා<br></p>\r\n', 0, ''),
(3, 4, '<p>වැරද්දක් එහෙම තිබ්බොත්&nbsp;<br></p>', 0, ''),
(4, 4, '<p>කොහොමද ඉතින් ඔයාලට? හුග කාලෙකට පස්සේ නේද මුණගැහෙන්නේ<br></p>\r\n', 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `mcq_questions`
--

CREATE TABLE IF NOT EXISTS `mcq_questions` (
  `mcq_questions_code` int(11) NOT NULL AUTO_INCREMENT,
  `mcq_code` int(11) NOT NULL,
  `question_num` int(11) NOT NULL,
  `question` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `main_mcq_questions_code` int(11) NOT NULL DEFAULT '0',
  `schedule_code` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mcq_questions_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `mcq_questions`
--

INSERT INTO `mcq_questions` (`mcq_questions_code`, `mcq_code`, `question_num`, `question`, `main_mcq_questions_code`, `schedule_code`) VALUES
(4, 1, 1, '<p>කොහොමද ඉතින් ඔයාලට? හුග කාලෙකට පස්සේ නේද මුණගැහෙන්නේ. ඉතින් මම මේ සැරෙත් ගෙනාවේ හින්දි චිත්‍රපටයක්. මම හරිම ආසාවෙන් බලපු චිත්‍රපටයක් තමයි මේක. ඉතින් ඔයාලටත් මේ චිත්‍රපටය බලන්න මගේ දෙවනි උපසිරැසිය විදිහට මේ චිත්‍රපටය තෝරාගත්තා. පළවෙනි එකෙනම් ගොඩාක් අඩුපාඩු තිබුනා නේද? එ්ක නිසා මම මේ උපසිරැසිය හදලා ඉවර වෙලා මගේම උපසිරැසියෙන් මේ චිත්‍රපටය බැලුවා. ආයිමත් අඩුපාඩු හදලා තමයි ඔයාලට මේ දෙන්නේ. වැරද්දක් එහෙම තිබ්බොත් සමාවෙන්න ඕනේ හොදේ.<br></p>', 0, 1),
(5, 1, 2, '<p>ඉතින් මම මේ සැරෙත් ගෙනාවේ හින්දි චිත්‍රපටයක්. මම හරිම ආසාවෙන් බලපු චිත්‍රපටයක් තමයි මේක. ඉතින් ඔයාලටත් මේ චිත්‍රපටය බලන්න මගේ දෙවනි උපසිරැසිය විදිහට මේ චිත්‍රපටය තෝරාගත්තා. පළවෙනි එකෙනම් ගොඩාක් අඩුපාඩු තිබුනා නේද? එ්ක නිසා මම මේ උපසිරැසිය හදලා ඉවර වෙලා මගේම උපසිරැසියෙන් මේ චිත්‍රපටය බැලුවා. ආයිමත් අඩුපාඩු හදලා තමයි ඔයාලට මේ දෙන්නේ. වැරද්දක් එහෙම තිබ්බොත් සමාවෙන්න ඕනේ හොදේ.<br></p>', 0, 2),
(6, 1, 3, '<p>හින්දි චිත්‍රපටයක්. මම හරිම ආසාවෙන් බලපු චිත්‍රපටයක් තමයි මේක. ඉතින් ඔයාලටත් මේ චිත්‍රපටය බලන්න මගේ දෙවනි උපසිරැසිය විදිහට මේ චිත්‍රපටය තෝරාගත්තා. පළවෙනි එකෙනම් ගොඩාක් අඩුපාඩු තිබුනා නේද? එ්ක නිසා මම මේ උපසිරැසිය හදලා ඉවර වෙලා මගේම උපසිරැසියෙන් මේ චිත්‍රපටය බැලුවා. ආයිමත් අඩුපාඩු හදලා තමයි ඔයාලට මේ දෙන්නේ. වැරද්දක් එහෙම තිබ්බොත් සමාවෙන්න ඕනේ හොදේ.<br></p>', 0, 2),
(7, 1, 4, '<p>මගේ දෙවනි උපසිරැසිය විදිහට මේ චිත්‍රපටය තෝරාගත්තා. පළවෙනි එකෙනම් ගොඩාක් අඩුපාඩු තිබුනා නේද? එ්ක නිසා මම මේ උපසිරැසිය හදලා ඉවර වෙලා මගේම උපසිරැසියෙන් මේ චිත්‍රපටය බැලුවා. ආයිමත් අඩුපාඩු හදලා තමයි ඔයාලට මේ දෙන්නේ. වැරද්දක් එහෙම තිබ්බොත් සමාවෙන්න ඕනේ හොදේ.<br></p>', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `note_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `header` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `note_date` datetime NOT NULL,
  `type` int(11) NOT NULL,
  `schedule_code` int(11) NOT NULL,
  PRIMARY KEY (`note_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `note`
--

INSERT INTO `note` (`note_code`, `id`, `header`, `content`, `note_date`, `type`, `schedule_code`) VALUES
(2, 1, 'රදර්ෆඩ්', '<p>&nbsp;ඉතින් අරුන් කල්පනා කරනවා තමාගේ ඇත්ත ජීවිතයත් චිත්‍රපටයකට අරගෙන ඒ කොල්ලට අර කෙල්ලව සෙට් කරලා දෙන්න බලනවා, ඒකට මොහුන් ඒ කොල්ලගෙන් ගානක් අය කරගන්නවා, ඉතින් මේ කොල්ලා හරිම කැතයි, පස්සේ සැලුන් එහෙකට ගිහිල්ලා ෆෙෂල් එකක් එහෙම දාලා කොල්ලව කොහොම හරි ලස්සන කරලා ගන්නවා, ඉතින් කොහොම කොහොම හරි ඒ කොල්ලට මේ කෙල්ලව සෙට් කරනවා, ඊට පස්සේ ඉතින් මේකම මේ සෙට් එක ජොබ් එකක් වශයෙන් කරන්න ගන්නවා, දවසක් සන්තෝෂ් කියලා ලොකු වියාපාරිකයෙක් එනවා මොහු ආස කෙල්ලෙක් ඉන්නවා කොහොම හරි සෙට් කරලා දෙන්න කියලා, එයා තමයි මායා (ප්‍රධාන නිළිය – කීර්ති සුරේෂ්), මේ අය මේ කරන වැඩෙත් සාධාරණව, බොරුවට ආදරය කරනවා කියලා රවට්ටන අයව ප්‍රතික්ෂේප කරලා දානවා, ඉතින් සන්තෝෂ් සල්ලි කාරයෙක් නිසා පොහොසත් මිනිස්සුන්ට කෙල්ලොන්ව නිකන් කාලය කා දැමීමක් වශයෙන් කරන වැඩක් නිසා මේ වැඩේට අරුන් මුලින් කැමති වෙන්නේ නැහැ. පස්සේ මොහු ටීවී එක බලන විටදී මොහුගේ අතීතය මතක් වෙනවා.<br></p>', '2015-09-13 06:16:09', 1, 2),
(3, 1, 'උපපරමාණුක අංශු ', '<p>ජීවිතයත් චිත්‍රපටයකට අරගෙන ඒ කොල්ලට අර කෙල්ලව සෙට් කරලා දෙන්න බලනවා, ඒකට මොහුන් ඒ කොල්ලගෙන් ගානක් අය කරගන්නවා, ඉතින් මේ කොල්ලා හරිම කැතයි, පස්සේ සැලුන් එහෙකට ගිහිල්ලා ෆෙෂල් එකක් එහෙම දාලා කොල්ලව කොහොම හරි ලස්සන කරලා ගන්නවා, ඉතින් කොහොම කොහොම හරි ඒ කොල්ලට මේ කෙල්ලව සෙට් කරනවා, ඊට පස්සේ ඉතින් මේකම මේ සෙට් එක ජොබ් එකක් වශයෙන් කරන්න ගන්නවා, දවසක් සන්තෝෂ් කියලා ලොකු වියාපාරිකයෙක් එනවා මොහු ආස කෙල්ලෙක් ඉන්නවා කොහොම හරි සෙට් කරලා දෙන්න කියලා, එයා තමයි මායා (ප්‍රධාන නිළිය – කීර්ති සුරේෂ්), මේ අය මේ කරන වැඩෙත් සාධාරණව, බොරුවට ආදරය කරනවා කියලා රවට්ටන අයව ප්‍රතික්ෂේප කරලා දානවා, ඉතින් සන්තෝෂ් සල්ලි කාරයෙක් නිසා පොහොසත් මිනිස්සුන්ට කෙල්ලොන්ව නිකන් කාලය කා දැමීමක් වශයෙන් කරන වැඩක් නිසා මේ වැඩේට අරුන් මුලින් කැමති වෙන්නේ නැහැ. පස්සේ මොහු ටීවී එක බලන විටදී මොහුගේ අතීතය මතක් වෙනවා.<br></p>', '2015-09-13 06:39:19', 1, 1),
(4, 1, 'Practicals', '<p><iframe width="560" height="315" src="https://www.youtube.com/embed/0g8lANs6zpQ" frameborder="0" allowfullscreen=""></iframe><br></p>', '2015-09-24 03:43:35', 2, 1),
(6, 1, 'පරමාණුක වයුහය', '<p><iframe width="560" height="315" src="https://www.youtube.com/embed/FSyAehMdpyI" frameborder="0" allowfullscreen=""></iframe><br></p>', '2015-09-24 03:52:51', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `occupations_to_profile`
--

CREATE TABLE IF NOT EXISTS `occupations_to_profile` (
  `occupations_to_profile_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `category_code` int(11) NOT NULL,
  `sub_category_code` int(11) NOT NULL,
  `occupations` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  PRIMARY KEY (`occupations_to_profile_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `occupations_to_profile`
--

INSERT INTO `occupations_to_profile` (`occupations_to_profile_code`, `id`, `category_code`, `sub_category_code`, `occupations`, `description`) VALUES
(3, 34, 12, 993, 'Software Engineer', 'Software Engineer'),
(4, 27, 12, 993, 'HR and Finance', 'Assist HR & Finance department'),
(5, 50, 12, 994, 'Net Work and Database Analysis ', 'Work at Road Development Authority  - Sethsiripaya Battaramulla'),
(6, 40, 12, 993, 'Software Development', 'You describe it, We code it.'),
(7, 49, 12, 1000, 'Service Engineer', 'Currently working as a engineer in Quicki Taxi.'),
(8, 75, 12, 997, 'Any IT Solution', 'Computer Repair ( Desktop/Laptop) , CCTV, LED Systems, Car Audio, Vehicle Camera Systems,, and mach more...');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `payment_code` int(11) NOT NULL AUTO_INCREMENT,
  `cost` decimal(10,2) NOT NULL,
  `commission` int(11) NOT NULL,
  PRIMARY KEY (`payment_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_code`, `cost`, `commission`) VALUES
(1, '0.00', 20);

-- --------------------------------------------------------

--
-- Table structure for table `payment_commission`
--

CREATE TABLE IF NOT EXISTS `payment_commission` (
  `payment_commission_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`payment_commission_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `payment_commission`
--


-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `post_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `schedule_code` int(11) NOT NULL,
  PRIMARY KEY (`post_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`post_code`, `id`, `date`, `body`, `schedule_code`) VALUES
(29, 38, '2015-03-06 13:51:40', 'First batch training starting from 3/6/2015.Reply joiners ', 40),
(30, 34, '2015-03-14 09:17:59', 'How I can start', 40),
(31, 37, '2015-03-16 12:49:25', 'How about 18,000', 54),
(32, 31, '2015-03-30 21:22:35', 'I am looking for a place to stay and go on a three days trip.\n', 61),
(33, 38, '2015-04-04 10:43:03', 'can i  meet u at 3 pm today.', 55);

-- --------------------------------------------------------

--
-- Table structure for table `post_reply`
--

CREATE TABLE IF NOT EXISTS `post_reply` (
  `post_reply_code` int(11) NOT NULL AUTO_INCREMENT,
  `post_code` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `body` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`post_reply_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `post_reply`
--

INSERT INTO `post_reply` (`post_reply_code`, `post_code`, `id`, `body`, `date`) VALUES
(11, 30, 38, 'You can just apply to this project then our team will contact you', '2015-03-14 09:20:02');

-- --------------------------------------------------------

--
-- Table structure for table `post_type`
--

CREATE TABLE IF NOT EXISTS `post_type` (
  `post_type_code` int(11) NOT NULL AUTO_INCREMENT,
  `post_type` varchar(200) NOT NULL,
  `post_type_url` varchar(500) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '3',
  `orderby` int(11) NOT NULL,
  `description` varchar(200) NOT NULL,
  `post` int(11) NOT NULL DEFAULT '0',
  `pre_post_type_code` int(11) NOT NULL,
  PRIMARY KEY (`post_type_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `post_type`
--

INSERT INTO `post_type` (`post_type_code`, `post_type`, `post_type_url`, `icon`, `active`, `type`, `orderby`, `description`, `post`, `pre_post_type_code`) VALUES
(1, 'Jobs', '/booking/index', '<i class="fa fa-suitcase"></i>', 1, 0, 2, 'Find jobs suitable to your services ', 4, 6),
(3, 'Education', '/booking/index', '<i class="fa fa-graduation-cap"></i>', 1, 0, 3, 'Find latest courses in your career ', 4, 8),
(4, 'Projects', '/booking/index', '<i class="fa fa-paper-plane-o"></i>', 1, 3, 1, 'Find project suitable to your services ', 4, 7),
(6, 'Job', 'schedule/index', '<i class="fa fa-briefcase"></i>', 1, 3, 2, 'Post latest jobs you have and find suitable employee for your requirement. Click Here', 3, 0),
(7, 'Project', 'schedule/index', '<i class="fa fa-paper-plane-o"></i>', 1, 3, 1, 'Post latest project you have and find suitable partner for get it done .Click Here', 3, 0),
(8, 'Education', 'schedule/index', '<i class="fa fa-graduation-cap"></i>', 1, 3, 3, 'Post latest course you have and find students. Click Here', 3, 0),
(9, 'Profile', 'providerProfile/index', '<i class="fa fa-user"></i>', 1, 3, 2, 'Upgrade and edit your personal details and profile information ', 6, 0),
(10, 'My Services', 'occupationsToProfile/index', '<i class="fa fa-filter"></i>', 0, 3, 3, 'Add and edit your capability as a services including your skills, project you has been worked , experience and qualifications to strong your profile', 6, 0),
(12, 'Home', 'providerProfile/home', '<i class="fa fa-home"></i>', 1, 3, 1, 'You can see snapshots of your entire process from home ', 6, 0),
(13, 'My Account', 'account/index', '<i class="fa fa-building-o"></i>', 1, 3, 4, '', 6, 0),
(14, 'Events', '/booking/index', '<i class="fa fa-coffee"></i>', 1, 3, 4, 'Find events such as exhibitions, champagnes like that things.', 4, 15),
(15, 'Events', 'schedule/index', '<i class="fa fa-coffee"></i>', 1, 3, 4, 'Post events you have organized such as exhibitions, champagnes like that things and find suitable crowd for get it done.', 3, 0),
(16, 'Services', '/booking/index', '<i class="fa fa-filter"></i>', 1, 3, 0, 'Post latest jobs you have and find suitable employee for your requirement. Click Here', 4, 17),
(17, 'Services', 'schedule/index', '<i class="fa fa-filter"></i>', 1, 3, 0, 'Post latest jobs you have and find suitable employee for your requirement. Click Here', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `project_to_profile`
--

CREATE TABLE IF NOT EXISTS `project_to_profile` (
  `project_code` int(11) NOT NULL AUTO_INCREMENT,
  `occupations_to_profile_code` int(11) NOT NULL,
  `header` varchar(200) NOT NULL,
  `description` varchar(500) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `employer_code` int(11) NOT NULL,
  PRIMARY KEY (`project_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `project_to_profile`
--

INSERT INTO `project_to_profile` (`project_code`, `occupations_to_profile_code`, `header`, `description`, `status`, `start_date`, `end_date`, `employer_code`) VALUES
(2, 3, 'eCitizen', 'Sri Lanka citizen data portal', 0, '0000-00-00', '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE IF NOT EXISTS `promotions` (
  `promotions_code` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(500) NOT NULL,
  `count` int(11) NOT NULL,
  `active` int(11) NOT NULL DEFAULT '1',
  `type` int(11) NOT NULL DEFAULT '0',
  `cost` decimal(10,2) NOT NULL,
  `commission` int(11) NOT NULL,
  PRIMARY KEY (`promotions_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`promotions_code`, `description`, `count`, `active`, `type`, `cost`, `commission`) VALUES
(3, 'Free 5 posts in BETA promotion ', 5, 1, 0, '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `qualifications_to_profile`
--

CREATE TABLE IF NOT EXISTS `qualifications_to_profile` (
  `qualifications_to_profile_code` int(11) NOT NULL AUTO_INCREMENT,
  `occupations_to_profile_code` int(11) NOT NULL,
  `description` varchar(500) NOT NULL,
  `institute` varchar(200) NOT NULL,
  `qualifications` varchar(200) NOT NULL,
  PRIMARY KEY (`qualifications_to_profile_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `qualifications_to_profile`
--


-- --------------------------------------------------------

--
-- Table structure for table `recommendations`
--

CREATE TABLE IF NOT EXISTS `recommendations` (
  `recommendations_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `schedule_code` int(11) NOT NULL,
  PRIMARY KEY (`recommendations_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=82 ;

--
-- Dumping data for table `recommendations`
--

INSERT INTO `recommendations` (`recommendations_code`, `id`, `date`, `schedule_code`) VALUES
(14, 37, '2015-03-15 00:20:38', 53),
(15, 37, '2015-03-15 00:20:55', 52),
(16, 37, '2015-03-15 00:21:03', 50),
(27, 1, '2015-03-15 01:05:25', 51),
(28, 1, '2015-03-15 01:07:31', 30),
(29, 1, '2015-03-15 01:07:40', 48),
(30, 1, '2015-03-15 01:07:42', 49),
(31, 1, '2015-03-15 01:07:46', 55),
(33, 34, '2015-03-15 01:19:44', 30),
(35, 34, '2015-03-15 01:19:52', 49),
(36, 34, '2015-03-15 01:19:55', 50),
(38, 34, '2015-03-15 01:20:02', 53),
(39, 34, '2015-03-15 01:20:04', 55),
(41, 34, '2015-03-15 01:21:08', 40),
(42, 76, '2015-03-15 08:02:20', 53),
(43, 76, '2015-03-15 08:02:27', 48),
(44, 76, '2015-03-15 08:02:28', 49),
(45, 76, '2015-03-15 08:02:32', 30),
(46, 76, '2015-03-15 08:02:40', 42),
(47, 38, '2015-03-15 23:15:13', 52),
(48, 80, '2015-03-16 11:45:20', 52),
(49, 1, '2015-03-17 08:25:01', 40),
(50, 1, '2015-03-17 08:25:07', 32),
(51, 94, '2015-03-17 21:33:40', 52),
(52, 94, '2015-03-17 21:36:26', 49),
(53, 94, '2015-03-17 21:46:18', 61),
(54, 1, '2015-03-17 21:47:17', 61),
(57, 34, '2015-03-17 23:33:28', 51),
(58, 34, '2015-03-17 23:37:55', 48),
(59, 34, '2015-03-17 23:40:00', 42),
(60, 34, '2015-03-17 23:47:11', 61),
(62, 34, '2015-03-17 23:48:22', 52),
(63, 34, '2015-03-18 00:07:16', 62),
(64, 94, '2015-03-18 00:22:32', 50),
(65, 94, '2015-03-18 00:22:34', 51),
(66, 94, '2015-03-18 00:22:39', 62),
(67, 34, '2015-03-18 00:39:31', 63),
(68, 37, '2015-03-18 00:59:38', 62),
(69, 37, '2015-03-18 01:00:06', 49),
(70, 37, '2015-03-18 01:00:17', 30),
(71, 37, '2015-03-18 01:00:18', 48),
(72, 37, '2015-03-18 01:00:22', 51),
(73, 1, '2015-03-18 01:28:49', 63),
(74, 1, '2015-03-19 01:54:13', 52),
(75, 1, '2015-03-21 04:21:08', 50),
(76, 37, '2015-03-31 00:32:13', 55),
(77, 37, '2015-03-31 00:32:21', 54),
(78, 31, '2015-03-31 09:53:12', 61),
(79, 1, '2015-04-07 21:01:03', 64),
(80, 1, '2015-04-09 05:05:16', 65),
(81, 1, '2015-09-11 14:26:15', 1);

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
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `schedule_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `scheduled_date` datetime NOT NULL,
  `sub_category_code` int(11) NOT NULL,
  `header` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `active` int(11) NOT NULL DEFAULT '0',
  `publish` int(11) NOT NULL DEFAULT '1',
  `recommendations` int(11) NOT NULL DEFAULT '0',
  `video_gallery` text NOT NULL,
  `category_code` int(11) NOT NULL,
  PRIMARY KEY (`schedule_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`schedule_code`, `id`, `scheduled_date`, `sub_category_code`, `header`, `description`, `active`, `publish`, `recommendations`, `video_gallery`, `category_code`) VALUES
(1, 1, '2015-09-10 16:29:37', 1, 'පරමාණුව හ උපපරමාණුක අංශු  ', 'මෙහි කතාව පැත්තට පොඩ්ඩක් හැරෙමුකො, අරන් (වික්‍රම් ප්‍රභූ) කියන්නේ කොලේජ් එකෙහි ඉගෙනීම අවසන් කරලා යාළුවන් එක්ක නාට්‍ය කරමින් දියුණු වෙන්න ඕනේ කියලා හිතන පිරිසක්, ඉතින් අද කාලේ මොහුන්ට තේරෙන්න ගන්නවා, නාට්‍ය කරන එක මහා පිස්සු වැඩක්, ඒ නිසා වෙන මොනවා හරි දෙයක් කරන්න ඕනේ කියලා, පස්සේ කොෆි ෂොප් එහෙක ඉඳල කෙනෙක් මේ ගැන කතා කරද්දී ලොකු ටොනික් මුඩියේ හැඩටයට තියෙන කණ්නාඩියක් දාගෙන, කොල්ලෙක් කෙල්ලෙක්ගෙ පස්සෙන් ඇවිල්ලා මම ඔයාට ආදරය කරනවා මාව භාර ගන්න කියලා අහනවා, ඒක කෙල්ල පුකටවත් ගණන් ගන්නේ නැතිව එතනින් යනවා, ඊට පස්සේ මේ කොල්ලව අරුන් සහ යාළුවන් පිරිස දකිනවා, ඉතින් අරුන් කල්පනා කරනවා තමාගේ ඇත්ත ජීවිතයත් චිත්‍රපටයකට අරගෙන ඒ කොල්ලට අර කෙල්ලව සෙට් කරලා දෙන්න බලනවා, ඒකට මොහුන් ඒ කොල්ලගෙන් ගානක් අය කරගන්නවා, ඉතින් මේ කොල්ලා හරිම කැතයි, පස්සේ සැලුන් එහෙකට ගිහිල්ලා ෆෙෂල් එකක් එහෙම දාලා කොල්ලව කොහොම හරි ලස්සන කරලා ගන්නවා, ඉතින් කොහොම කොහොම හරි ඒ කොල්ලට මේ කෙල්ලව සෙට් කරනවා, ඊට පස්සේ ඉතින් මේකම මේ සෙට් එක ජොබ් එකක් වශයෙන් කරන්න ගන්නවා, දවසක් සන්තෝෂ් කියලා ලොකු වියාපාරිකයෙක් එනවා මොහු ආස කෙල්ලෙක් ඉන්නවා කොහොම හරි සෙට් කරලා දෙන්න කියලා, එයා තමයි මායා (ප්‍රධාන නිළිය – කීර්ති සුරේෂ්), මේ අය මේ කරන වැඩෙත් සාධාරණව, බොරුවට ආදරය කරනවා කියලා රවට්ටන අයව ප්‍රතික්ෂේප කරලා දානවා, ඉතින් සන්තෝෂ් සල්ලි කාරයෙක් නිසා පොහොසත් මිනිස්සුන්ට කෙල්ලොන්ව නිකන් කාලය කා දැමීමක් වශයෙන් කරන වැඩක් නිසා මේ වැඩේට අරුන් මුලින් කැමති වෙන්නේ නැහැ. පස්සේ මොහු ටීවී එක බලන විටදී මොහුගේ අතීතය මතක් වෙනවා.', 1, 1, 1, '', 21),
(2, 1, '2015-09-11 12:32:51', 1, 'රදර්ෆඩ්ගෙ න්‍යාෂ්ටික අකෘතිය ', 'දියුණු වෙන්න ඕනේ කියලා හිතන පිරිසක්, ඉතින් අද කාලේ මොහුන්ට තේරෙන්න ගන්නවා, නාට්‍ය කරන එක මහා පිස්සු වැඩක්, ඒ නිසා වෙන මොනවා හරි දෙයක් කරන්න ඕනේ කියලා, පස්සේ කොෆි ෂොප් එහෙක ඉඳල කෙනෙක් මේ ගැන කතා කරද්දී ලොකු ටොනික් මුඩියේ හැඩටයට තියෙන කණ්නාඩියක් දාගෙන, කොල්ලෙක් කෙල්ලෙක්ගෙ පස්සෙන් ඇවිල්ලා මම ඔයාට ආදරය කරනවා මාව භාර ගන්න කියලා අහනවා, ඒක කෙල්ල පුකටවත් ගණන් ගන්නේ නැතිව එතනින් යනවා, ඊට පස්සේ මේ කොල්ලව අරුන් සහ යාළුවන් පිරිස දකිනවා, ඉතින් අරුන් කල්පනා කරනවා තමාගේ ඇත්ත ජීවිතයත් චිත්‍රපටයකට අරගෙන ඒ කොල්ලට අර කෙල්ලව සෙට් කරලා දෙන්න බලනවා, ඒකට මොහුන් ඒ කොල්ලගෙන් ගානක් අය කරගන්නවා, ඉතින් මේ කොල්ලා හරිම කැතයි, පස්සේ සැලුන් එහෙකට ගිහිල්ලා ෆෙෂල් එකක් එහෙම දාලා කොල්ලව කොහොම හරි ලස්සන කරලා ගන්නවා, ඉතින් කොහොම කොහොම හරි ඒ කොල්ලට මේ කෙල්ලව සෙට් කරනවා, ඊට පස්සේ ඉතින් මේකම මේ සෙට් එක ජොබ් එකක් වශයෙන් කරන්න ගන්නවා, දවසක් සන්තෝෂ් කියලා ලොකු වියාපාරිකයෙක් එනවා මොහු ආස කෙල්ලෙක් ඉන්නවා කොහොම හරි සෙට් කරලා දෙන්න කියලා, එයා තමයි මායා (ප්‍රධාන නිළිය – කීර්ති සුරේෂ්), මේ අය මේ කරන වැඩෙත් සාධාරණව, බොරුවට ආදරය කරනවා කියලා රවට්ටන අයව ප්‍රතික්ෂේප කරලා දානවා, ඉතින් සන්තෝෂ් සල්ලි කාරයෙක් නිසා පොහොසත් මිනිස්සුන්ට කෙල්ලොන්ව නිකන් කාලය කා දැමීමක් වශයෙන් කරන වැඩක් නිසා මේ වැඩේට අරුන් මුලින් කැමති වෙන්නේ නැහැ. පස්සේ මොහු ටීවී එක බලන විටදී මොහුගේ අතීතය මතක් වෙනවා.', 1, 1, 0, '', 21),
(3, 1, '2015-09-12 06:09:34', 2, 'රසායනික බන්ධන හටගෙනිම ', '<p>කතාව ගැන කිවුවොත්, රීඩ් රිචඩ්ස් පාසල් වියේ සිටම උත්සාහ කරන්නේ දූරවිස්ථාපනය (ටෙලිපෝට්) කළ හැකි යන්ත්‍රයක් නිෂ්පාදනය කරන්න. එහෙත් පාසලෙන් හෝ වෙනත් කිසිම තැනකින් ඔහුට&nbsp;කිසිදු උපකාරයක්, දිරිගැන්වීමක් ලැබෙන්නේ නෑ. එක්තරා විද්‍යා ප්‍රදර්ශනයකදී අහඹු ලෙස බැක්ස්ටර් නම් සමාගමේ ෆ්‍රෑන්ක්ලින් ස්ටෝම් සහ ඔහුගේ දියණිය වන සූසන් ස්ටෝම්ව &nbsp;රීඩ්ට &nbsp;මුණ ගැසෙනවා.&nbsp;රීඩ්ගේ හැකියාව හඳුනා ගන්නා ෆ්‍රෑන්ක්ලින්, ඔහුට බැක්ස්ටර් සමාගමේ ශිෂ්‍යත්වයක් ලබා දී රීඩ්ගේ පර්යේෂණයට සහයෝගය ලබා දෙනවා. ඒ වන විටත් රීඩ්ගේ පර්යේෂණයෙන් අඩක් පමණ&nbsp;බැක්ස්ටර් පදනම මගින් සොයාගෙන අවසන්. ඔවුන් රීඩ්ගේ සහය ලබා ගන්නේ පර්යේෂණය සම්පූර්ණ කර ගැනීමටයි. ඔවුන්ගේ ව්‍යාපෘතිය මගින් අත්හදා බලන්නේ වෙනත් මානයකට,&nbsp;වෙනත් සමාන්තර ලෝකයකට මිනිසුන් යැවීමයි.&nbsp;</p><p><span style="line-height: 1.45em; background-color: initial;">අවසානයේ පර්යේෂණය සාර්ථක කරගන්නා රීඩ්ගේ කණ්ඩායමේ බලාපොරොත්තුව වන්නේ ප්‍රථමයෙන්ම නව මානයට පා තබන මිනිසුන් ලෙස&nbsp;ඉතිහාසයට එක්වීමයි. එහෙත් එම ව්‍යාපෘතියට ආයෝජනය කරන සමාගමේ අදහස් ඊට ගැලපෙන්නේ නැහැ. ඒ හේතුවෙන් රීඩ්, සූසන්ගේ සොහොයුරා වන ජොනී ස්ටෝම්, රීඩ්ගේ මිතුරෙකු වන&nbsp;බෙන් ග්‍රීම් සහ වික්ටර් වොන් ඩූම් රහසේම නව ලෝකයට පා තබනවා. එහිදී සිදුවන අනතුරකින් වික්ටර්ව එහි තනිකර නැවත පෘථිවියට ඒමට අනෙක් සගයන්ට සිදු වෙනවා. එහිදී නව ලෝකයේ&nbsp;පාරිසරික තත්ත්ව මත රීඩ්, බෙන් සහ ජොනී නැවත පැමිණෙන්නේ අසාමාන්‍ය ශාරීරික තත්ත්වයන් යටතේයි. ඔවුන් නැවත පැමිණීමේදී ඇතිවන පිපුරුමෙන් ඇතිවන බලපෑමෙන් සූසන්ටද අනෙක්&nbsp;අයට මෙන් අසාමාන්‍ය ශාරීරික තත්වයන් ඇතිවෙනවා. වික්ටර්ට මොනවා වුණාද කියලා කවුරුවත් දන්නේ නෑ. ඔය ඇතිනේ.ඉතුරු ටික ඔයාලාට.</span></p>', 1, 1, 0, '', 21);

-- --------------------------------------------------------

--
-- Table structure for table `skills_to_profile`
--

CREATE TABLE IF NOT EXISTS `skills_to_profile` (
  `occupations_to_profile_code` int(11) NOT NULL,
  `skills_to_profile_code` int(11) NOT NULL AUTO_INCREMENT,
  `skill` varchar(200) NOT NULL,
  `description` varchar(400) NOT NULL,
  PRIMARY KEY (`skills_to_profile_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `skills_to_profile`
--

INSERT INTO `skills_to_profile` (`occupations_to_profile_code`, `skills_to_profile_code`, `skill`, `description`) VALUES
(3, 2, 'PHP,C#,Javascript,SQL,MYSQL,jQuery', '');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE IF NOT EXISTS `sub_categories` (
  `category_code` int(2) DEFAULT NULL,
  `sub_category_code` int(4) NOT NULL AUTO_INCREMENT,
  `sub_category` text,
  `sub_category_eng` text NOT NULL,
  `sub_category_tamil` text NOT NULL,
  `orderby` int(11) NOT NULL,
  PRIMARY KEY (`sub_category_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`category_code`, `sub_category_code`, `sub_category`, `sub_category_eng`, `sub_category_tamil`, `orderby`) VALUES
(21, 1, 'පරමාණුක වයුහය', '', '', 0),
(21, 2, 'වයුහය හා බන්ධන ', '', '', 0),
(21, 3, 'රසායනික ගනණය කිරිම් ', '', '', 0),
(21, 4, 'පදාර්ථයේ වායු අවස්ථාව  ', '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_profiles`
--

CREATE TABLE IF NOT EXISTS `tbl_profiles` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(50) NOT NULL DEFAULT '',
  `firstname` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_profiles`
--

INSERT INTO `tbl_profiles` (`user_id`, `lastname`, `firstname`) VALUES
(1, 'Admin', 'Administrator');

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
  `username` varchar(40) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activkey` varchar(128) NOT NULL DEFAULT '',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastvisit_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `superuser` int(1) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `districts_code` int(11) NOT NULL,
  `location_code` int(11) NOT NULL,
  `phone_no1` varchar(15) NOT NULL,
  `phone_no2` varchar(15) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `address` varchar(200) NOT NULL,
  `verified` int(11) NOT NULL DEFAULT '0',
  `refkey` int(11) NOT NULL DEFAULT '1',
  `account_balance` int(11) NOT NULL DEFAULT '0',
  `country_code` int(11) NOT NULL DEFAULT '1',
  `gender` int(11) NOT NULL,
  `date_of_birth` date NOT NULL,
  `key` varchar(100) NOT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `profile_updated` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  KEY `status` (`status`),
  KEY `superuser` (`superuser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=115 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `activkey`, `create_at`, `lastvisit_at`, `superuser`, `status`, `type`, `name`, `districts_code`, `location_code`, `phone_no1`, `phone_no2`, `description`, `address`, `verified`, `refkey`, `account_balance`, `country_code`, `gender`, `date_of_birth`, `key`, `latitude`, `longitude`, `profile_updated`) VALUES
(1, 'admin', 'e34f33a79ef64f5ca094ccabf338cce5', '9a24eff8c15a6a141ece27eb6947da0f', '2015-01-12 23:48:10', '2015-09-26 08:48:33', 1, 1, 1, 'Viraj Chanaka', 5, 7, '0115289289', '0115289289', 'There are no set rules about the length of a Personal Profile but we would suggest you keep it within the 40/70-words boundary; that means no longer than five lines.', 'No. 91 1/7 Galle Road, Colombo 4, Sri Lanka.', 1, 1000, 5, 1, 1, '1989-12-12', '1000', '6.8494', '79.9236', 1),
(27, 'mali@unita.skymanagementsystems.com', 'e10adc3949ba59abbe56e057f20f883e', 'fce691c9bd9f1036b8e61b084344eee6', '2015-02-14 12:37:54', '2015-04-04 17:45:31', 1, 1, 0, 'Hemamali Ukwaththa', 5, 42, '0774605547', '0112748064', 'I''am a Project Coordinator', '319,Galawila Rd, Homagama', 0, 1000, 4, 1, 2, '1988-02-29', '2222', '', '', 1),
(28, 'manushkapradeep@gmail.com', '4abf2ebe14cf2644d10f42156dd4e181', 'e1f019a25f6e5ca401c186019acf28c0', '2015-02-14 17:51:34', '0000-00-00 00:00:00', 0, 1, 0, 'Manushka pradeep gunawardhana', 5, 61, '0713798878', '', '', 'pahala gedara watta,howpe,galle.', 0, 1000, 0, 1, 1, '1990-01-18', '4569', NULL, NULL, 0),
(29, 'chamaraphonesetting@gmail.com', '081ab01e42d0d5889c695fff853fc76c', 'b319789a6fe5cee217382f7d64be669f', '2015-02-14 18:31:58', '0000-00-00 00:00:00', 0, 1, 0, 'danushka', 0, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '4578', NULL, NULL, 0),
(30, 'tharawow@yahoo.com', '16f6fc767c868c35346a2aaa422e60c1', '03e992490b1d5edb71d2dea90a1d6b53', '2015-02-14 18:44:12', '0000-00-00 00:00:00', 0, 1, 0, 'tharaka madushanka', 5, 61, '0757069075', '', '', 'nilantha,allalagoda imaduwa', 0, 1000, 0, 1, 1, '1989-04-09', '4571', NULL, NULL, 0),
(31, 'smsl.cs@gmail.com', '88ef89e78c9e4f6e2d4c0d09e47810a3', '1e5c58aa81530e0199776e74c250b444', '2015-02-15 08:41:48', '2015-04-04 18:07:04', 1, 1, 0, 'Sampath', 5, 65, '0773635534', '', '', '251', 0, 1000, 3, 1, 1, '2015-02-28', '5555', NULL, NULL, 1),
(32, 'farhan@unita.skymanagementsystems.com', 'bc77d7ffd97e861a7dee28d218c4d67f', '1d1b967d57e907f22bc00f32a0837846', '2015-02-15 15:43:47', '0000-00-00 00:00:00', 0, 0, 0, 'Mohamed Ibrahim Mohamed Farhan ', 0, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '5668', NULL, NULL, 0),
(33, 'sidathgunasena@gmail.com', 'd453f3888f6c06c9f77a236bbdb6a075', '2b6446ed24020d1924e59d7dde00a575', '2015-02-15 16:36:36', '0000-00-00 00:00:00', 0, 1, 0, 'Sidath', 0, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '5568', NULL, NULL, 0),
(34, 'bkgchanaka@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '322e126433fc6612af86420285329a9c', '2015-02-25 10:28:45', '2015-03-20 23:18:10', 1, 1, 0, 'Viraj Chanaka', 5, 65, '0782836475', '', '', 'Ajantha, Panugalgoda, Dikkumbura, Ahangama', 0, 1000, 0, 1, 1, '1989-12-12', '1111', NULL, NULL, 1),
(35, 'niroshansgkidev@gmail.com', '25f9e794323b453885f5181f1b624d0b', '133c37a51bcfd083d8dd7c66f6c6e610', '2015-02-25 16:22:38', '2015-03-24 18:55:25', 1, 1, 0, 'Indika Niroshan', 5, 1, '0752241308', '', '', '544/4/2 Godalla Mawatha,Angoda', 0, 1000, 0, 1, 1, '1984-09-23', '4960', '', '', 0),
(36, 'chathubss@gmail.com', '6a7a3830f107310ddef635b3a58282bd', '041981401eebc81cb1127c632407d323', '2015-02-25 16:38:51', '0000-00-00 00:00:00', 0, 1, 0, 'Chathuri Rodrigo', 10, 699, '0717852525', '', '', 'No.75. Moronthuduwa rd, Mawala, Wadduwa', 0, 1111, 5, 1, 2, '1984-07-17', '9109', NULL, NULL, 0),
(37, 'generationx_360@hotmail.com', '79c7267afa6de4aae0270dd6161d93b1', 'c76d18c3f521ac1663e3bfb6dba0a173', '2015-02-25 17:19:57', '2015-07-28 17:51:52', 1, 1, 0, 'Ashan Fernando', 5, 74, '0777132880', '2643606', '', '29/14 Uyana Road Moratuwa Sri Lanka', 0, 1000, 5, 1, 1, '1989-01-07', '3333', '', '', 1),
(38, 'sampath@skymanagementsystems.com', '88ef89e78c9e4f6e2d4c0d09e47810a3', '1f595c8ae91487629712b228a20fc977', '2015-02-25 18:13:22', '2015-09-12 11:57:06', 0, 1, 1, 'Sky Management Systems (Pvt.) Ltd.', 5, 81, '94773635534', '94112836633', 'Sky Management Systems is an innovative IT company based in Sri Lanka and the USA. Blended with technical expertise in both Sri Lanka and the U.S.A, we provide a holistic service in the fields of digital content related solutions, web applications for corporate and government sectors and mobile application development. Our company was awarded with the International Quality Era Award in the gold category for our commitment towards the quality and customer satisfaction. In addition, our company was also recognized for its QC100 Total Quality Management Model.', '#251, Staon Road, Udahamulla, Nugegoda, Sri Lanka.', 0, 5555, 4, 1, 0, '0000-00-00', 'smsl', '6.869963', '79.914385', 1),
(39, 'wasantha.perera@gmail.com', '167e83e79c48c2504034c5dd08491147', 'e9fd2aaf26dc0dde5a484498b423eac5', '2015-02-26 10:07:27', '2015-04-06 23:27:31', 1, 1, 0, 'Wasantha Perera', 7, 452, '0772277543', '', '', '36/2B, Pahala Yagoda, Ganemulla', 0, 1000, 4, 1, 1, '1979-08-13', '8779', NULL, NULL, 1),
(40, 'hasitha@unitb.skymanagementsystems.com', 'fcea920f7412b5da7be0cf42b8c93759', '6532d7740ef0bee9ebdcf921245aa55a', '2015-02-27 11:28:47', '0000-00-00 00:00:00', 1, 1, 0, 'Hasitha Dananjaya', 5, 42, '0710000000', '', '', 'Homagama', 0, 1000, 0, 1, 1, '1993-01-16', '1006', NULL, NULL, 0),
(41, 'thilankanilanjan@gmail.com', 'b54dd04bde30fd69ee388e14e3c8df6b', '2b76fdc3824dd7675ab6d67afc5c6822', '2015-02-28 12:32:40', '2015-03-24 15:17:28', 1, 1, 0, ' Thilanka Nilanjan', 6, 359, '0715864891', '', '', '"Sandamali", Welegedara, W/ Kananke, Imaduwa.', 0, 1000, 0, 1, 1, '1990-01-28', '1001', NULL, NULL, 0),
(42, 'udayangakularathna@gmail.com', 'c7533ef28e3a195f8f4f3f0d477f1795', 'caeb9a532b6abcdb9db4f3147177d60a', '2015-02-28 12:53:54', '0000-00-00 00:00:00', 0, 1, 0, 'Ilangarajage udayanga prabath kularathna ', 14, 1025, '0716321225', '0717456945', '', 'Gonna,Kohilegedara', 0, 1001, 0, 1, 1, '1988-12-21', '14209723', NULL, NULL, 0),
(43, 'mithunr098@gmail.com', '55ab90724607309e671f17c9152a3dcf', '74fb64701b7ef7609c502a56981a674e', '2015-03-01 08:24:26', '0000-00-00 00:00:00', 0, 1, 0, 'Mithun Udhara Ruwanpathirana', 5, 12, '0713476776', '', '', '167/10 A, Temple Road ,Neelammahara, Boralesgamuwa', 0, 1001, 0, 1, 1, '1989-03-17', '46293142', NULL, NULL, 0),
(44, 'hasinthajanaka@gmail.com', 'c01b74667dd6d3c3928d5224bf149430', '540e8553d12dc3b266e6e00fc5fa2b5c', '2015-03-01 12:29:02', '0000-00-00 00:00:00', 1, 1, 0, 'Hasintha Janaka', 5, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '1005', NULL, NULL, 0),
(45, 'ykhrox1989@gmail.com', '2b3b5a58b4dc867f87761e6857815e21', '253a4ede5de046caed4d6018fea6fb51', '2015-03-02 08:27:27', '0000-00-00 00:00:00', 0, 1, 0, 'Yasitha Kanchana Hewamanage', 5, 66, '0770289855', '', '', '851/5 Susithapura Malabe ', 0, 1001, 5, 1, 1, '1989-03-28', '41299189', NULL, NULL, 0),
(46, 'gayansachintha@gmail.com', 'd991946fd733f3a08fcb86242717549c', 'c1cc68e6ff5ab475db0c1da1ee906c13', '2015-03-02 08:58:05', '0000-00-00 00:00:00', 0, 1, 0, 'Gayan Sachintha', 5, 12, '94771554476', '', '', '155/2. Abeyrathnamawatha, Boralesgamuwa.', 0, 1001, 0, 1, 1, '1991-04-10', '10255780', NULL, NULL, 0),
(47, 'ishankasamaraweera@gmail.com', '46f11a77d2e7ade3c52163da14530a20', '77ed2bbef908139b29450c7a7498c455', '2015-03-02 09:59:32', '0000-00-00 00:00:00', 0, 1, 0, 'Ishanka Layanthi Samaraweera', 5, 0, '', '', '', '', 0, 1111, 0, 1, 0, '0000-00-00', '35281357', NULL, NULL, 0),
(48, 'krishanprasanga@gmail.com', '2677954d223a3d43f0176876534eb751', 'df60089ba2bf5ce41be1944ae0300fc8', '2015-03-02 10:05:36', '0000-00-00 00:00:00', 0, 1, 0, 'W.A. Krishan Prasanga', 7, 452, '0716348256', '', '', '61/A,church road ,gapaha', 0, 1001, 0, 1, 1, '1990-05-15', '63728642', NULL, NULL, 0),
(49, 'ncbdrck@hotmail.com', 'fed8c0e2d3111683290980ab54002d39', '2333c4592ff36c62bdbefcf11d7eca65', '2015-03-02 11:10:24', '0000-00-00 00:00:00', 0, 1, 0, 'Navoda Kapukotuwa', 5, 66, '0712512580', '', 'I am an Electronic Engineering graduate from Sri Lanka Institute of Information and Technology (SLIIT) under Sheffield Hallam University (SHU) , United Kingdom with a 1st class and placed 1st in the batch.', '488, Warakapitiya, Ulapane', 0, 1001, 0, 1, 1, '1990-08-01', '08755487', NULL, NULL, 0),
(50, 'iprasa@yahoo.com', '9dfd2993c964e9be53bba45bc321d456', '60cf49356d1b78c8c8ab787617b16d19', '2015-03-02 13:59:16', '0000-00-00 00:00:00', 0, 1, 0, 'Hitihami Mudiyanselage Indika Prasath', 8, 585, '0713480380', '0472247251', '', 'Indika Prasath, No.68, Murungasyaya, Middeniya, (Via-Matara)', 0, 1001, 5, 1, 1, '1981-08-28', '15027251', NULL, NULL, 0),
(51, 'chayapromotion@gmail.com', '96420e9333876c443e6eea0a86287078', 'a0d1cfa588b4c9aa841f62bc96e1ec64', '2015-03-03 04:56:12', '0000-00-00 00:00:00', 0, 1, 0, 'chandana nanayakkara', 5, 65, '0777397880', '0775753653', '', 'maharagama', 0, 1111, 0, 1, 1, '1977-05-16', '39072873', NULL, NULL, 0),
(52, 'sarandikas@gmail.com', 'bd6ec3a596ffcedeb8a34e387d02e640', 'f0c61bc9107770d4be26c664e49bfad4', '2015-03-03 09:26:58', '0000-00-00 00:00:00', 0, 1, 0, 'Ashan', 7, 452, '0712573131', '', '', '186/A, Nedagomuwa, Kotugoda. 11390.', 0, 1001, 0, 1, 1, '1990-11-17', '58950191', NULL, NULL, 0),
(53, 'budhanzna@gmail.com', '77f43005f353f10c2cc11f465942bf42', '27519c205e5139ece1a6973c8eec28f1', '2015-03-03 11:14:27', '0000-00-00 00:00:00', 0, 1, 0, 'Buddhika hansamali nakandala', 5, 81, '0785204395', '0783585332', '', '82/6, Hokandara South, Hokandara', 0, 1001, 0, 1, 2, '1994-07-22', '28685240', NULL, NULL, 0),
(54, 'kanchana1000@gmail.com', '77f43005f353f10c2cc11f465942bf42', '77ab3846b9b8c4e38ed005bb16ccc818', '2015-03-03 11:19:50', '0000-00-00 00:00:00', 0, 1, 0, 'Kanchana indunil Edirisinghe ', 6, 359, '0710129403', '0783585333', '', '"ïndunil" wahala kananke, imaduwa,galle', 0, 1001, 0, 1, 1, '1986-01-26', '54525406', NULL, NULL, 0),
(55, 'udayangapriyasad@yahoo.com', 'e10adc3949ba59abbe56e057f20f883e', '35b6ac1491c8e5f3179455baeff00556', '2015-03-03 12:56:22', '0000-00-00 00:00:00', 0, 1, 0, 'Udayanga Priyasad Weerasekara', 17, 1291, '0712707841', '', '', '43/1,Kumbalgoda,Karatota,Hakmana', 0, 1001, 0, 1, 1, '1988-05-27', '00349942', NULL, NULL, 0),
(56, 'r.krishnathiepan@gmail.com', 'b79569412899cde4ab04da4ee61a5177', 'af0475010923617e463074da64637dd1', '2015-03-03 17:23:26', '0000-00-00 00:00:00', 0, 1, 0, 'krishna rasanayagam', 5, 13, '0758701024', '', '', 'colombo', 0, 1001, 0, 1, 1, '1989-09-22', '19072611', NULL, NULL, 0),
(57, 'dew@dew.com.lk', '2095eefdd521b75845704433922b8059', '45b83b736764a0bb42a8853bf9a9904a', '2015-03-03 20:59:51', '0000-00-00 00:00:00', 0, 1, 0, 'Dhanushka Weeratunga', 5, 0, '', '', '', '', 0, 1111, 0, 1, 0, '0000-00-00', '24857476', NULL, NULL, 0),
(58, 'kaminiranaweera@yahoo.com', 'de6d3ee3ab14653bffc793ee071c03e9', '9690275026cafb74902a8b43794c84fe', '2015-03-05 14:26:45', '0000-00-00 00:00:00', 0, 1, 1, 'Kamani', 10, 0, '', '', '', '', 0, 1111, 0, 1, 0, '0000-00-00', '72392875', NULL, NULL, 0),
(59, 'grvasuki@gmail.com', '280410950f6407591413de3613c435ff', '499a873d9813afe5fc443fe224bdf8a7', '2015-03-05 14:58:35', '0000-00-00 00:00:00', 0, 1, 0, 'Vasukil.Ganesrajah', 5, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '87149701', NULL, NULL, 0),
(60, 'sandu.maxa@gmail.com', 'dc0bf0d2c3fc8d9f8cc2cd5a450cf45b', '7c24bd8c96a65e7b99f708f8f07a5dfd', '2015-03-05 16:07:39', '0000-00-00 00:00:00', 0, 1, 0, 'Sandaru Dulanjana', 5, 12, '0717205138', '', '', '126/5, Diwulpitiya, Boralesgamuwa', 0, 1001, 0, 1, 1, '1993-01-27', '89260731', NULL, NULL, 0),
(61, 'sameera0824@gmail.com', '266fe7ef4c55224759010c7e2a73563e', 'a4840899ee9269d5333d6e0b168d170b', '2015-03-06 08:45:50', '0000-00-00 00:00:00', 0, 1, 0, 'sameera bandara', 14, 1025, '0716601921', '0716601921', '', 'pimburuwellegama,Gonagama,Kurunegala.', 0, 1001, 0, 1, 1, '1988-08-24', '98598025', NULL, NULL, 0),
(62, 'demetras360@hotmail.com', '5fa4fe587bc251b2993b49692bf402c4', '7733bddf32df402469a95e3f54220f51', '2015-03-06 09:36:51', '2015-03-25 18:22:00', 0, 1, 0, 'Ashan Fernando', 5, 1, '779988795', '', '', '195/1/1 New Galle Road Moratuwa ', 0, 3333, 0, 1, 1, '0000-00-00', '00285425', '', '', 1),
(63, 'gayantha_priyasad@outlook.com', '0e615fc5ea67512ec74bd0d670a8c798', '749f8adb5b60d00fa025307dff97c549', '2015-03-06 11:01:38', '0000-00-00 00:00:00', 0, 0, 0, 'Gayantha Priyasad', 5, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '00375967', NULL, NULL, 0),
(64, 'gayanthapriyasad@yahoo.com', '0e615fc5ea67512ec74bd0d670a8c798', '9434be79eafea8ec4b895a2c3532e66b', '2015-03-06 11:08:16', '0000-00-00 00:00:00', 0, 1, 0, 'Gayantha Priyasad', 5, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '67754905', NULL, NULL, 0),
(65, 'waefdo@yahoo.co.uk', '9cd31744fe166a225afe43088e0f3d7b', '2378d6e582a08500ed3c3e311586f0eb', '2015-03-06 18:08:12', '0000-00-00 00:00:00', 0, 1, 0, 'Ajith Fernando', 5, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '98266213', NULL, NULL, 0),
(66, 'tharindusk@gmail.com', '0f7a63541c329dfa3846fa04a4bfd252', 'eb11402ebcd6207a9c28071734bc5714', '2015-03-06 20:18:54', '0000-00-00 00:00:00', 0, 1, 0, 'Sulakkhana Kariyawasam', 5, 87, '0712435324', '', '', '325/19, Gonamadiththa road, Kesbewa', 0, 1001, 0, 1, 1, '1990-12-14', '59942988', NULL, NULL, 0),
(67, 'maduniro20@gmail.com', '9e26f5342e3c66130bc67911b5678ac8', 'e982ee89bdd665465a30e198beb2493c', '2015-03-06 21:40:56', '0000-00-00 00:00:00', 0, 1, 0, 'madushani niroshika rajaguru', 5, 0, '', '', '', '', 0, 1001, 0, 1, 0, '0000-00-00', '57695567', NULL, NULL, 0),
(68, 'aranthi88@gmail.com', '41b9df4a217bb3c10b1c339358111b0d', 'bc68d4e2adcac4073123f1afa3c2d609', '2015-03-10 10:08:52', '0000-00-00 00:00:00', 0, 1, 0, 'Aranthi Fernando', 5, 0, '', '', '', '', 0, 3333, 0, 1, 0, '0000-00-00', '22059338', NULL, NULL, 0),
(71, 'minoka_dominic@hotmail.com', '460045a3207b95745da33a802cab27f8', '01483f759fd048bf75a558f43afc8be3', '2015-03-10 11:41:17', '2015-03-17 19:37:05', 0, 1, 0, 'Minoka Dominic', 5, 74, '0779826798', '', 'I''m involved in a BPO project at the moment.', '5/12 A , Watson Peiris Mawatha , Moratuwa ', 0, 3333, 5, 1, 1, '1999-01-15', '97681739', '', '', 1),
(74, 'info@skymanagementsystems.com', '79c7267afa6de4aae0270dd6161d93b1', '8e99cd032bc38dd0760d92a9df3c785c', '2015-03-10 12:39:27', '0000-00-00 00:00:00', 0, 1, 1, 'Sky Management Systems', 5, 81, '0777132880', '2836633', 'Sky Management Systems is an innovative IT company based in Sri Lanka which caters the needs of both local and international clients', 'No 251 Station Road Udahamulla Nugegoda', 0, 3333, 5, 1, 0, '0000-00-00', '69046525', '', '', 0),
(75, 'lahiruchathuranga@gmail.com', '5c4001a552762787e8fda452aa3cb511', '74161dff3aa64ca49769f56690335f70', '2015-03-10 22:09:27', '2015-03-26 17:04:58', 0, 1, 0, 'Lahiru Chathuranga', 5, 66, '0718817881', '0716123433', '', 'No381/B, Himbutana, Mulleriyawa New Town', 0, 3333, 5, 1, 1, '1987-05-26', '42993969', '6.9173169', '79.9428466', 1),
(76, 'DasunRay@Gmail.Com', 'ca4c0421e58a5c346323f5580dc18b0f', 'd3e39711d398563d11fe2f9d8ad014e7', '2015-03-10 22:10:52', '2015-06-08 16:13:45', 0, 1, 0, 'Tharindu Dasun Perera', 5, 5, '0711144030', '', '', 'No 11/6, Colombo Road, Avissawella.', 0, 3333, 4, 1, 1, '1985-05-23', '45061986', '', '', 1),
(77, 'priyashan.prinna@gmail.com', 'b9901d581d89bd4109e767ce56c58101', '56bd1e3036a4a16523f69793bb917bf6', '2015-03-10 23:18:53', '0000-00-00 00:00:00', 0, 1, 0, 'Priyashan Wijesuriya', 10, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '83858462', NULL, NULL, 0),
(78, 'gayeshgayashan@gmail.com', 'c5f93bee9fd2d0cf005fdc8d65d79fe2', 'a91c0a567a7fbb72c9ef4ba0461b0600', '2015-03-11 00:39:10', '0000-00-00 00:00:00', 0, 1, 0, 'Gayashan Wiesuriya', 10, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '55768693', NULL, NULL, 0),
(79, 'info@primetechsolutions.biz', 'e10adc3949ba59abbe56e057f20f883e', '5611f2b602ac37aa01107570779546f4', '2015-03-11 11:15:17', '0000-00-00 00:00:00', 0, 1, 1, 'Primetech Solutions', 5, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '28011718', NULL, NULL, 0),
(80, 'mewna@unitb.skymanagementsystems.com', '0dcf3699ae19dde17e5b2717dad99de0', '43090bfdffeef9879a63185bc6f68268', '2015-03-11 12:59:04', '2015-03-16 06:14:03', 0, 1, 0, 'Mewna', 7, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '83386879', NULL, NULL, 0),
(81, 'gayahanwijesuriya@Gmail.com', 'c5f93bee9fd2d0cf005fdc8d65d79fe2', '4f568e05ce054773498074ca4bd44599', '2015-03-11 13:07:59', '0000-00-00 00:00:00', 0, 0, 0, 'Gayashan wijesuriya  ', 10, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '83615941', NULL, NULL, 0),
(82, 'Kulasekarakkck@gmail.com', '8003c8cdbcb8ca55652d4b2c5569d748', '7af92ddf06b19bc0401933012c1e02a0', '2015-03-11 18:36:57', '2015-03-16 06:38:01', 0, 1, 0, 'K. K. Chameera Kulasekara', 12, 941, '0718477601', '', '', 'Kulasekara Niwasa, Pattiyawaththa, Maniyamgama, Awissawella.', 0, 3333, 5, 1, 1, '1986-10-03', '31144420', '', '', 0),
(83, 'gayandinusha@gmail.com', '9020b9d3bcdc07f32d2347cd86ab8af2', '7fcc1507a2d91bdd6ff657d5d2f83c57', '2015-03-11 18:53:01', '0000-00-00 00:00:00', 0, 1, 0, 'Gayan', 23, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '07244487', NULL, NULL, 0),
(84, 'hassymj@gmail.com', '91d31870a8f42065fcf192798dccb5c7', '421d2009ba159d5a4a6745d5cfba290c', '2015-03-11 20:55:42', '2015-03-17 14:53:58', 0, 1, 0, 'Hasitha Madusanka', 5, 5, '0714594294', '', '', '11/3.D Colombo Road, Avissawella', 0, 3333, 5, 1, 1, '1991-04-21', '84772613', '', '', 1),
(85, 'Ashan_vvj@hotmail.com', 'bb224bcc6662595bd5abc04e77e2b1b2', '4c953f9e20684ce1a274fd9552fbbfc7', '2015-03-11 22:07:59', '0000-00-00 00:00:00', 0, 0, 0, 'Sanju Maduranga', 5, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '17802162', NULL, NULL, 0),
(86, 'Sanjumaduranga@outlook.com', 'bb224bcc6662595bd5abc04e77e2b1b2', '4681cfe655c4a606ca6eab84c185eb6b', '2015-03-11 22:16:24', '0000-00-00 00:00:00', 0, 1, 0, 'Sanju Maduranga', 5, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '49201535', NULL, NULL, 0),
(87, 'lishwebber@gmail.com', '378b8c5da57af54b42e8af65108f014c', '69a9aa7de5effe4520eee1db12145e4f', '2015-03-11 22:41:54', '0000-00-00 00:00:00', 0, 1, 0, 'Lishan Puwakovita', 23, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '53717787', NULL, NULL, 0),
(88, 'nalakabit@gmail.com', '2849b535f53d660e58295d6dc1e33b4c', 'fe7a4b06e1fbf3f026edfeab9a722c3f', '2015-03-12 01:43:43', '0000-00-00 00:00:00', 0, 1, 0, 'Nalaka Wijayasinghe', 23, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '66358054', NULL, NULL, 0),
(89, 'kusalarunoda@live.com', '209525528bdf5e453f31970d6aad2216', '5107193874161c48967e55ed089c5f18', '2015-03-12 07:49:53', '0000-00-00 00:00:00', 0, 1, 0, 'Kusal Arunoda', 5, 7, '0718246431', '0774102178', '', '200/1, Robert Gunawardana Mawatha, Battaramulla.', 0, 3333, 5, 1, 1, '1992-02-20', '18999847', '', '', 0),
(90, 'rohini.cha@gmail.com', '5a9989b53c236264e8bcbce65d254ef1', 'a3c9a0e66fc4efb6d9f342a3b136b0a0', '2015-03-13 22:11:38', '2015-03-14 05:15:33', 0, 1, 0, 'rohini chandralatha', 5, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '83139555', NULL, NULL, 0),
(92, 'viraj@skymanagementsystems.com', 'e10adc3949ba59abbe56e057f20f883e', 'f0b2028121612cd14dab51c343bed095', '2015-03-16 17:49:17', '2015-03-17 00:49:32', 0, 1, 0, 'Chanaka', 5, 61, '0782836475', '', '', 'No. 91 1/7 Galle Road, Colombo 4, Sri Lanka.', 0, 1111, 5, 1, 1, '0000-00-00', '72486054', '', '', 1),
(93, 's.p.egodawatta@gmail.com', '5b0a7843508c56f60bfd508bd394b1cb', '4adb9fda08f18306b7e524ccc703d4a4', '2015-03-16 18:43:16', '2015-03-17 01:50:40', 0, 1, 0, 'Suranjith Prasad', 12, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '98950279', NULL, NULL, 0),
(94, 'lakseriyateam@gmail.com', 'e34f33a79ef64f5ca094ccabf338cce5', 'eed5582d08707afd05eb8903e3ee6683', '2015-03-17 08:33:35', '2015-04-06 16:01:40', 0, 1, 1, 'Lakseriya', 5, 97, '94114345345', '94766910413', 'We are very much willing to provide you a trusted customer service since the booking reservation till you finish the tour with us. If you have any quarries with regard to our offer please contact our sales department on ', '532/3, Madiwela Road, Thalawathugoda,', 0, 1111, 5, 1, 0, '0000-00-00', '82584771', '', '', 1),
(95, 'spaceboy117@hotmail.com', 'ce1c1cdc2fac8e1167f22cd4bd88d324', '393bb3fa7528306cfd10779d66251b1c', '2015-03-17 10:31:22', '2015-03-17 18:54:31', 0, 1, 0, 'David J', 5, 0, '', '', '', '', 0, 1111, 5, 1, 0, '0000-00-00', '41496607', NULL, NULL, 0),
(96, 'ruwani.fernando@outlook.com', '440c023b6a82943c4c817e6b55c8e428', 'a845ca93a351978a0ef3dc49ca5791e8', '2015-03-17 14:34:54', '2015-03-17 21:37:01', 0, 1, 0, 'Ruwani', 5, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '25162962', NULL, NULL, 0),
(97, 'dineshanth@gmail.com', 'e6b72f57a0670d6f10a14fcc1b9f7ffe', '19219a02038f5fccbafbb1ef6e01cf93', '2015-03-18 21:50:44', '2015-03-19 04:54:40', 0, 1, 0, 'Dineshanth Thaventhiran ', 5, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '36520854', NULL, NULL, 0),
(98, 'saku.amaa93@gmail.com', '0abdecee3a847a2e39be884f5eaa2b86', '289c6dd5aa0e8b87743e34196afeac8b', '2015-03-19 08:37:35', '2015-03-19 15:39:14', 0, 1, 0, 'Rajapaksha Withanage Ama Sakunika', 6, 359, '0770472843', '0770472843', '', '63-B,Sri Sumangala Road,', 0, 1000, 5, 1, 2, '1993-01-15', '64288561', '', '', 0),
(99, 'wijesekarats@gmail.com', '1b885ec62e8c2294cbc8cc60555d0db2', 'b05ad233e71d8e701140b027dd502a34', '2015-03-19 08:46:01', '2015-03-19 15:46:47', 0, 1, 0, 'Thushara Sampath Wijesekara', 7, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '30506875', NULL, NULL, 0),
(100, 'sameeraconstruction2@gmaul.com', 'f8a0806f5e1e76e8622377fcff4f056b', 'a9034c917ead1e35c36cdfa9a84101e4', '2015-03-19 11:17:31', '0000-00-00 00:00:00', 0, 0, 0, 'Sameera Dilshan', 5, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '00847972', NULL, NULL, 0),
(101, 'sameeraconstruction2@gmail.com', 'f8a0806f5e1e76e8622377fcff4f056b', 'f804310ec38b77e3ccfe266f587986ec', '2015-03-19 11:26:59', '2015-03-19 18:30:18', 0, 1, 0, 'Sameera Dilshan', 5, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '69116568', NULL, NULL, 0),
(102, 'flyerdesign6@gmail.com', '62819c4f62dbf2226c61918e5d6b0b2a', 'cd9eb6be0870f250ceefceb83d0d7d8c', '2015-03-19 17:39:52', '0000-00-00 00:00:00', 0, 1, 0, 'Flyer', 16, 1232, '94755425173', '', '', '17# Dambarawa, Dangan Place, Yatawatta', 0, 1111, 5, 1, 1, '1994-11-29', '24630890', '', '', 0),
(103, 'sasanka.chameera@gmail.com', 'f6ca8f027f555426eb96ea49df7dba88', '8f341ec0ced4dc817dee8a522cc2492e', '2015-03-20 10:29:16', '2015-03-20 17:30:56', 0, 1, 0, 'sasanka', 5, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '34417848', NULL, NULL, 0),
(104, 'oshanijayasuriya@gmail.com', 'b47cce5236cc7c06c5bcbef6a979743c', 'fb7a31e785fa834d0dcd6f179cbf5660', '2015-03-20 20:13:50', '2015-03-21 03:14:45', 0, 1, 0, 'Oshani Jayasuriya', 5, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '86579121', NULL, NULL, 0),
(105, 'luckyf94@gmail.com', '05d70f8ee11e3862aeac5f5ed4d71616', '9eefb54751dc9d0e37fad6241de00d7f', '2015-03-21 18:26:08', '2015-03-22 01:27:49', 0, 1, 0, 'Lakshitha Fernando ', 10, 0, '', '', '', '', 0, 1111, 5, 1, 0, '0000-00-00', '78521739', NULL, NULL, 0),
(106, 'upesala@gmail.com', 'd026607c5e98503ca3072caf6114e37f', 'e25aebdebe1fa39f7409e06801996caa', '2015-03-25 09:01:26', '2015-03-25 16:01:51', 0, 1, 0, 'Pesala Wimalarathne', 14, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '73192956', NULL, NULL, 0),
(107, 'uawmali88@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '1f774915f2707e87fee21cfb44fe7d36', '2015-04-02 11:45:19', '0000-00-00 00:00:00', 0, 1, 0, 'Mali Ukwaththa', 7, 0, '', '', '', '', 0, 1000, 5, 1, 0, '0000-00-00', '98068737', NULL, NULL, 0),
(108, 'ruchira@sevensigns.lk', '7830ce3d09b9f0d4e06a2c63d76d4c05', '497960a53bd58512cf796819de3ce70d', '2015-04-02 12:49:15', '2015-04-02 19:55:12', 0, 1, 1, 'Sevensigns', 5, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '08282944', NULL, NULL, 0),
(109, 'thusitha.pushpakumara@gmail.com', 'ac66ad5ac67b86a12da7f5f9f269d761', '0d5f516543533ea862538f05eaf2e252', '2015-04-06 23:58:40', '2015-04-07 07:03:25', 0, 1, 1, 'Sensitive Live Music Band', 7, 452, '0772277543', '0772277544', 'Live music for your any kind of music needs', '36/2B, Pahala Yagoda, Ganemulla', 0, 1000, 5, 1, 0, '0000-00-00', '34114855', '', '', 1),
(111, 'vajithpriyantha@gmail.com', '8f6b0ff8b14c77f8a21d3727e7999b02', 'beefaefb07dc4183a5c315e518815160', '2015-04-11 23:47:23', '0000-00-00 00:00:00', 0, 0, 0, 'Ajith Widisinghe', 5, 0, '', '', '', '', 0, 3333, 5, 1, 0, '0000-00-00', '17320892', NULL, NULL, 0),
(112, 'braxton.lg70@gmail.com', '399a066111ea4a8bb30ff6c3ae3de0d0', '4f8990113e5f12160c2199c476d5967d', '2015-08-07 21:02:59', '0000-00-00 00:00:00', 0, 0, 0, 'zameera MAHABADUGA ', 5, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '59159838', NULL, NULL, 0),
(113, 'onjo.msf@gmail.com', '537a3b33c1a62894d5725302c9c25fbd', 'e35056fbc51349d515e15ef3d4269b95', '2015-08-07 21:07:47', '0000-00-00 00:00:00', 0, 0, 0, 'M D N FERNANDO ', 5, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '09288591', NULL, NULL, 0),
(114, 'msf.ads.001@gmail.com', '224401de4de77fc941b348dd1ca3e4d6', '4532aec0a69258e13625a5d8aede482f', '2015-08-07 21:28:14', '0000-00-00 00:00:00', 0, 1, 0, 'MAHABADUGA DEELIPA NILANTHA FERNANDO', 5, 0, '', '', '', '', 0, 1000, 0, 1, 0, '0000-00-00', '30432311', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `templates`
--

CREATE TABLE IF NOT EXISTS `templates` (
  `templates_code` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `category_code` int(11) NOT NULL,
  `sub_category_code` int(11) NOT NULL,
  `header` varchar(200) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `skills` varchar(1000) NOT NULL,
  `experience` varchar(1000) NOT NULL,
  `qualifications` varchar(1000) NOT NULL,
  `other` varchar(1000) NOT NULL,
  `post_type_code` int(11) NOT NULL,
  PRIMARY KEY (`templates_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `templates`
--


--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_profiles`
--
ALTER TABLE `tbl_profiles`
  ADD CONSTRAINT `user_profile_id` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON DELETE CASCADE;
