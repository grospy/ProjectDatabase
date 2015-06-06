-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2015 at 09:56 PM
-- Server version: 5.6.24-log
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `inholland`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `adminID` varchar(6) NOT NULL DEFAULT 'admin',
  `password` varchar(45) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `password`) VALUES
('admin', 'e7c8a79dbd6c97ac6e5b851e4a52a9a1');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseID` char(7) NOT NULL,
  `name` varchar(300) NOT NULL,
  `minimumstudents` tinyint(4) DEFAULT NULL,
  `capacity` tinyint(1) unsigned NOT NULL,
  `studyload` tinyint(1) unsigned NOT NULL,
  `offer` bit(1) NOT NULL DEFAULT b'1' COMMENT '0 for not being offered, 1 for being offered'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `name`, `minimumstudents`, `capacity`, `studyload`, `offer`) VALUES
('IBIS001', '3D printing: from Design to Print', NULL, 20, 40, b'1'),
('IBIS002', 'Advance your English! Cambridge English Advanced', NULL, 20, 40, b'1'),
('IBIS003', 'Advanced Selling Techniques: telephone acquisition', NULL, 20, 24, b'1'),
('IBIS004', 'Brain Food: Food for Thought', NULL, 20, 20, b'1'),
('IBIS005', 'Breaking Booking.com', NULL, 20, 18, b'1'),
('IBIS006', 'China and the West, a cultural and historical background', NULL, 20, 20, b'1'),
('IBIS007', 'Creative Urban Renewal', NULL, 20, 28, b'1'),
('IBIS008', 'Dutch Language and Culture for Beginners+', NULL, 20, 40, b'1'),
('IBIS009', 'Exploring possibilities of Virtual Reality', NULL, 20, 24, b'1'),
('IBIS010', 'Fast reading', NULL, 20, 6, b'1'),
('IBIS011', 'French, slightly advanced', NULL, 20, 56, b'1'),
('IBIS012', 'Growth hacking - how to get marketing attention without a marketing budget', NULL, 20, 24, b'1'),
('IBIS013', 'How we can learn to innovate from creative users and some mad designers and scientists', NULL, 20, 28, b'1'),
('IBIS014', 'Introduction to Graphic Design', NULL, 20, 20, b'1'),
('IBIS015', 'Introduction to Psychology', NULL, 20, 20, b'1'),
('IBIS016', 'Magazine making & Innovation', NULL, 20, 36, b'1'),
('IBIS017', 'Meaning in Music: The semiotics of Music in Culture', NULL, 20, 12, b'1'),
('IBIS018', 'Microsoft Excel for any level', NULL, 20, 28, b'1'),
('IBIS019', 'Movietime: stories for Business', NULL, 20, 36, b'1'),
('IBIS020', 'NLP: Key to be more effective in work and communication', NULL, 20, 14, b'1'),
('IBIS021', 'New Science of the Mind & Neuromarketing', NULL, 20, 24, b'1'),
('IBIS022', 'Opening the black box: how to develop a clever experience?', NULL, 20, 20, b'1'),
('IBIS023', 'Personal Branding & Networking', NULL, 20, 15, b'1'),
('IBIS024', 'Photoshop Fundamentals', NULL, 20, 56, b'1'),
('IBIS025', 'Religious or not: thatâ€™s the question', NULL, 20, 24, b'1'),
('IBIS026', 'Russia; an eagle looking in two directions', NULL, 20, 20, b'0'),
('IBIS027', 'Social Media Monitoring & Marketing', NULL, 20, 20, b'1'),
('IBIS028', 'Spain as a Brand', NULL, 20, 20, b'1'),
('IBIS029', 'Spanish A1/A2 (beginners)', NULL, 20, 56, b'1'),
('IBIS030', 'Speaking with Confidence', NULL, 20, 20, b'0'),
('IBIS031', 'Visual Harvesting: The Power of Visual Stories', NULL, 20, 8, b'1'),
('IBIS032', 'Website fundamental', NULL, 20, 24, b'1');

-- --------------------------------------------------------

--
-- Table structure for table `enrolledstudent`
--

CREATE TABLE IF NOT EXISTS `enrolledstudent` (
  `registrationID` smallint(6) unsigned NOT NULL,
  `studentID` varchar(6) NOT NULL,
  `courseID` char(7) NOT NULL,
  `status` bit(1) DEFAULT NULL COMMENT '0 for fail, 1 for pass, null for currently taking'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `enrolledstudent`
--

INSERT INTO `enrolledstudent` (`registrationID`, `studentID`, `courseID`, `status`) VALUES
(13, '552301', 'IBIS001', b'0'),
(13, '552301', 'IBIS014', b'1'),
(13, '552301', 'IBIS023', b'0'),
(13, '552301', 'IBIS027', b'0'),
(13, '552301', 'IBIS030', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `guestlecturer`
--

CREATE TABLE IF NOT EXISTS `guestlecturer` (
  `guestID` varchar(6) NOT NULL,
  `courseID` char(7) NOT NULL,
  `contactperson` varchar(50) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE IF NOT EXISTS `lesson` (
  `courseID` char(7) NOT NULL,
  `roomnumber` varchar(6) NOT NULL,
  `date` date NOT NULL,
  `time_start` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`courseID`, `roomnumber`, `date`, `time_start`) VALUES
('IBIS001', 'E-10', '2015-05-04', '09:00:00'),
('IBIS001', 'E-10', '2015-05-22', '12:00:00'),
('IBIS001', 'E-20', '2015-05-29', '12:00:00'),
('IBIS001', 'E-22', '2015-06-04', '09:00:00'),
('IBIS001', 'E-23', '2015-06-04', '12:00:00'),
('IBIS001', 'E-24', '2015-06-04', '15:00:00'),
('IBIS001', 'E-15', '2015-06-05', '09:00:00'),
('IBIS001', 'E-20', '2015-06-05', '12:00:00'),
('IBIS001', 'E-21', '2015-06-05', '15:00:00'),
('IBIS001', 'E-34', '2015-06-08', '09:00:00'),
('IBIS001', 'E-11', '2015-06-19', '09:00:00'),
('IBIS002', 'E-10', '2015-04-29', '09:00:00'),
('IBIS002', 'E-10', '2015-05-01', '12:00:00'),
('IBIS002', 'E-11', '2015-05-22', '12:00:00'),
('IBIS002', 'E-21', '2015-05-29', '12:00:00'),
('IBIS002', 'E-10', '2015-06-01', '09:00:00'),
('IBIS002', 'E-25', '2015-06-04', '12:00:00'),
('IBIS002', 'E-12', '2015-06-19', '12:00:00'),
('IBIS003', 'E-10', '2015-05-13', '09:00:00'),
('IBIS003', 'E-30', '2015-06-04', '09:00:00'),
('IBIS003', 'E-31', '2015-06-04', '12:00:00'),
('IBIS003', 'E-32', '2015-06-04', '15:00:00'),
('IBIS003', 'E-22', '2015-06-05', '09:00:00'),
('IBIS003', 'E-23', '2015-06-05', '12:00:00'),
('IBIS003', 'E-35', '2015-06-08', '09:00:00'),
('IBIS003', 'E-10', '2015-06-08', '12:00:00'),
('IBIS003', 'E-11', '2015-06-08', '15:00:00'),
('IBIS004', 'E-12', '2015-05-22', '12:00:00'),
('IBIS004', 'E-22', '2015-05-29', '12:00:00'),
('IBIS004', 'E-21', '2015-06-12', '15:00:00'),
('IBIS004', 'E-13', '2015-06-19', '15:00:00'),
('IBIS005', 'E-11', '2015-05-01', '12:00:00'),
('IBIS005', 'E-10', '2015-05-07', '15:00:00'),
('IBIS005', 'E-11', '2015-05-13', '09:00:00'),
('IBIS006', 'E-23', '2015-05-29', '09:00:00'),
('IBIS006', 'E-22', '2015-06-12', '09:00:00'),
('IBIS006', 'E-14', '2015-06-19', '12:00:00'),
('IBIS007', 'E-20', '2015-04-30', '15:00:00'),
('IBIS007', 'E-11', '2015-05-07', '15:00:00'),
('IBIS007', 'E-13', '2015-05-22', '12:00:00'),
('IBIS007', 'E-10', '2015-05-28', '15:00:00'),
('IBIS007', 'E-24', '2015-05-29', '15:00:00'),
('IBIS008', 'E-14', '2015-05-22', '12:00:00'),
('IBIS008', 'E-25', '2015-05-29', '12:00:00'),
('IBIS008', 'E-24', '2015-06-05', '12:00:00'),
('IBIS008', 'E-12', '2015-06-08', '12:00:00'),
('IBIS008', 'E-23', '2015-06-12', '12:00:00'),
('IBIS008', 'E-24', '2015-06-12', '15:00:00'),
('IBIS008', 'E-15', '2015-06-19', '12:00:00'),
('IBIS009', 'E-11', '2015-04-29', '09:00:00'),
('IBIS009', 'E-12', '2015-05-01', '15:00:00'),
('IBIS009', 'E-10', '2015-05-11', '09:00:00'),
('IBIS009', 'E-15', '2015-05-22', '15:00:00'),
('IBIS010', 'E-13', '2015-05-01', '09:00:00'),
('IBIS011', 'E-10', '2015-04-28', '15:00:00'),
('IBIS011', 'E-11', '2015-05-11', '09:00:00'),
('IBIS011', 'E-11', '2015-05-28', '15:00:00'),
('IBIS011', 'E-33', '2015-06-04', '12:00:00'),
('IBIS011', 'E-13', '2015-06-08', '12:00:00'),
('IBIS011', 'E-25', '2015-06-12', '12:00:00'),
('IBIS011', 'E-20', '2015-06-19', '12:00:00'),
('IBIS012', 'E-10', '2015-05-08', '09:00:00'),
('IBIS012', 'E-20', '2015-05-22', '09:00:00'),
('IBIS012', 'E-12', '2015-05-28', '15:00:00'),
('IBIS012', 'E-34', '2015-06-04', '15:00:00'),
('IBIS013', 'E-12', '2015-05-11', '09:00:00'),
('IBIS013', 'E-30', '2015-05-29', '09:00:00'),
('IBIS013', 'E-35', '2015-06-04', '12:00:00'),
('IBIS013', 'E-14', '2015-06-08', '12:00:00'),
('IBIS014', 'E-12', '2015-04-29', '09:00:00'),
('IBIS014', 'E-11', '2015-05-08', '15:00:00'),
('IBIS014', 'E-21', '2015-05-22', '15:00:00'),
('IBIS014', 'E-31', '2015-05-29', '15:00:00'),
('IBIS015', 'E-14', '2015-05-01', '12:00:00'),
('IBIS015', 'E-12', '2015-05-08', '12:00:00'),
('IBIS015', 'E-22', '2015-05-22', '12:00:00'),
('IBIS015', 'E-32', '2015-05-29', '12:00:00'),
('IBIS016', 'E-11', '2015-05-04', '09:00:00'),
('IBIS016', 'E-23', '2015-05-22', '12:00:00'),
('IBIS016', 'E-33', '2015-05-29', '12:00:00'),
('IBIS016', 'E-10', '2015-06-04', '15:00:00'),
('IBIS017', 'E-13', '2015-05-11', '09:00:00'),
('IBIS017', 'E-24', '2015-05-22', '09:00:00'),
('IBIS017', 'E-25', '2015-06-05', '09:00:00'),
('IBIS018', 'E-12', '2015-05-04', '09:00:00'),
('IBIS018', 'E-12', '2015-05-13', '09:00:00'),
('IBIS018', 'E-30', '2015-06-05', '09:00:00'),
('IBIS018', 'E-30', '2015-06-12', '09:00:00'),
('IBIS018', 'E-21', '2015-06-19', '09:00:00'),
('IBIS019', 'E-11', '2015-04-28', '15:00:00'),
('IBIS019', 'E-15', '2015-05-01', '15:00:00'),
('IBIS019', 'E-13', '2015-05-08', '15:00:00'),
('IBIS019', 'E-25', '2015-05-22', '15:00:00'),
('IBIS019', 'E-34', '2015-05-29', '15:00:00'),
('IBIS019', 'E-12', '2015-06-02', '15:00:00'),
('IBIS019', 'E-31', '2015-06-12', '15:00:00'),
('IBIS020', 'E-13', '2015-05-28', '15:00:00'),
('IBIS020', 'E-13', '2015-06-02', '15:00:00'),
('IBIS020', 'E-11', '2015-06-04', '15:00:00'),
('IBIS021', 'E-13', '2015-04-29', '09:00:00'),
('IBIS021', 'E-13', '2015-05-13', '09:00:00'),
('IBIS021', 'E-20', '2015-06-03', '09:00:00'),
('IBIS021', 'E-15', '2015-06-08', '09:00:00'),
('IBIS022', 'E-14', '2015-04-29', '09:00:00'),
('IBIS022', 'E-13', '2015-05-04', '09:00:00'),
('IBIS022', 'E-10', '2015-05-12', '15:00:00'),
('IBIS022', 'E-35', '2015-05-29', '09:00:00'),
('IBIS023', 'E-32', '2015-06-12', '15:00:00'),
('IBIS023', 'E-22', '2015-06-19', '15:00:00'),
('IBIS024', 'E-12', '2015-04-28', '15:00:00'),
('IBIS024', 'E-12', '2015-05-07', '15:00:00'),
('IBIS024', 'E-11', '2015-05-12', '15:00:00'),
('IBIS024', 'E-14', '2015-05-28', '15:00:00'),
('IBIS024', 'E-12', '2015-06-04', '15:00:00'),
('IBIS025', 'E-14', '2015-06-02', '15:00:00'),
('IBIS025', 'E-31', '2015-06-05', '12:00:00'),
('IBIS025', 'E-33', '2015-06-12', '12:00:00'),
('IBIS025', 'E-23', '2015-06-19', '12:00:00'),
('IBIS026', 'E-13', '2015-04-28', '15:00:00'),
('IBIS026', 'E-12', '2015-05-12', '15:00:00'),
('IBIS026', 'E-30', '2015-05-22', '12:00:00'),
('IBIS026', 'E-13', '2015-06-04', '15:00:00'),
('IBIS027', 'E-20', '2015-05-01', '09:00:00'),
('IBIS027', 'E-13', '2015-05-12', '15:00:00'),
('IBIS028', 'E-21', '2015-06-03', '09:00:00'),
('IBIS028', 'E-32', '2015-06-05', '09:00:00'),
('IBIS028', 'E-20', '2015-06-08', '12:00:00'),
('IBIS029', 'E-15', '2015-04-29', '09:00:00'),
('IBIS029', 'E-14', '2015-05-04', '09:00:00'),
('IBIS029', 'E-14', '2015-05-11', '09:00:00'),
('IBIS029', 'E-11', '2015-06-01', '09:00:00'),
('IBIS029', 'E-14', '2015-06-04', '12:00:00'),
('IBIS029', 'E-34', '2015-06-12', '12:00:00'),
('IBIS029', 'E-24', '2015-06-19', '12:00:00'),
('IBIS030', 'E-14', '2015-04-28', '15:00:00'),
('IBIS030', 'E-13', '2015-05-07', '15:00:00'),
('IBIS030', 'E-15', '2015-05-11', '09:00:00'),
('IBIS030', 'E-15', '2015-05-28', '15:00:00'),
('IBIS031', 'E-35', '2015-06-12', '15:00:00'),
('IBIS031', 'E-25', '2015-06-19', '15:00:00'),
('IBIS032', 'E-15', '2015-06-02', '15:00:00'),
('IBIS032', 'E-33', '2015-06-05', '12:00:00'),
('IBIS032', 'E-10', '2015-06-12', '12:00:00'),
('IBIS032', 'E-30', '2015-06-19', '12:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `lastdate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `personID` varchar(6) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `type` enum('student','teacher','guest-lecturer','admin') NOT NULL,
  `current` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`personID`, `firstName`, `lastName`, `type`, `current`) VALUES
('10749', 'Sandra', 'Reeb-Gruber', 'teacher', '1'),
('123783', 'Jan', 'Student', 'student', '1'),
('20890', 'Harald', 'Drillenburg', 'teacher', '1'),
('246505', 'Tjhis', 'Student', 'student', '1'),
('345098', 'Ben', 'Student', 'student', '1'),
('345903', 'Mathijs', 'Student', 'student', '1'),
('36451', 'Belinda', 'Kroes', 'teacher', '1'),
('46166', 'Margje', 'Penning', 'teacher', '1'),
('523001', 'Shamil', 'Karimli', 'student', '0'),
('552301', 'Sasmita', 'Santoso', 'student', '1'),
('557797', 'Abraham', 'Foto', 'student', '1'),
('559942', 'Louis', 'Le', 'student', '1'),
('admin', 'admin', 'admin', 'admin', '1'),
('ext001', 'Michael', 'Guirella', 'guest-lecturer', '1'),
('ext002', 'Jan', 'Bakker', 'guest-lecturer', '1'),
('ext003', 'Tim', 'Timmerman', 'guest-lecturer', '1');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
`registrationID` smallint(6) unsigned NOT NULL,
  `opendate` date NOT NULL,
  `closedate` date DEFAULT NULL,
  `closedate2` date NOT NULL,
  `type` enum('first','second') NOT NULL DEFAULT 'first',
  `minimumstudents` int(2) NOT NULL DEFAULT '0',
  `minimumcredits` tinyint(3) unsigned NOT NULL,
  `current` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`registrationID`, `opendate`, `closedate`, `closedate2`, `type`, `minimumstudents`, `minimumcredits`, `current`) VALUES
(13, '2015-06-06', '2015-06-05', '2015-06-05', 'first', 10, 60, '1');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `room_number` varchar(6) NOT NULL,
  `capacity` tinyint(1) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_number`, `capacity`) VALUES
('E-10', 20),
('E-11', 20),
('E-12', 20),
('E-13', 30),
('E-14', 30),
('E-15', 20),
('E-20', 20),
('E-21', 20),
('E-22', 30),
('E-23', 30),
('E-24', 20),
('E-25', 20),
('E-30', 20),
('E-31', 20),
('E-32', 30),
('E-33', 30),
('E-34', 20),
('E-35', 20);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `studentID` varchar(6) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sent` tinyint(1) unsigned DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `set_code` varchar(8) DEFAULT NULL,
  `allowToReg` bit(1) DEFAULT b'0' COMMENT '0 for not allowed, 1 for allowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `email`, `sent`, `password`, `set_code`, `allowToReg`) VALUES
('123783', '123783@student.inholland.nl', NULL, NULL, NULL, b'0'),
('246505', '246505@student.inholland.nl', NULL, NULL, NULL, b'0'),
('345098', '345098@student.inholland.nl', NULL, NULL, NULL, b'0'),
('345903', '345903@student.inholland.nl', NULL, NULL, NULL, b'0'),
('523001', '523001@student.inholland.nl', 0, 'f65deaf5fea7a7936e8fd8413c224023', NULL, b'1'),
('552301', '552301@student.inholland.nl', 0, 'f65deaf5fea7a7936e8fd8413c224023', NULL, b'1'),
('557797', '557797@student.inholland.nl', 0, 'f65deaf5fea7a7936e8fd8413c224023', NULL, b'1'),
('559942', '559942@student.inholland.nl', 5, 'f65deaf5fea7a7936e8fd8413c224023', 'SJ1QD3WL', b'1');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teacherID` varchar(6) NOT NULL,
  `courseID` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`teacherID`, `courseID`) VALUES
('20890', 'IBIS001'),
('20890', 'IBIS002'),
('36451', 'IBIS003'),
('10749', 'IBIS004'),
('20890', 'IBIS005'),
('36451', 'IBIS006'),
('46166', 'IBIS007'),
('10749', 'IBIS008'),
('20890', 'IBIS009'),
('36451', 'IBIS010'),
('46166', 'IBIS011'),
('10749', 'IBIS012'),
('20890', 'IBIS013'),
('36451', 'IBIS014'),
('46166', 'IBIS015'),
('10749', 'IBIS016'),
('20890', 'IBIS017'),
('36451', 'IBIS018'),
('46166', 'IBIS019'),
('10749', 'IBIS020'),
('20890', 'IBIS021'),
('36451', 'IBIS022'),
('46166', 'IBIS023'),
('10749', 'IBIS024'),
('20890', 'IBIS025'),
('46166', 'IBIS027'),
('10749', 'IBIS028'),
('20890', 'IBIS029'),
('46166', 'IBIS031'),
('10749', 'IBIS032');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
 ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
 ADD PRIMARY KEY (`courseID`);

--
-- Indexes for table `enrolledstudent`
--
ALTER TABLE `enrolledstudent`
 ADD PRIMARY KEY (`registrationID`,`studentID`,`courseID`), ADD KEY `enrolledstudent_ibfk_1` (`studentID`), ADD KEY `courseID` (`courseID`);

--
-- Indexes for table `guestlecturer`
--
ALTER TABLE `guestlecturer`
 ADD PRIMARY KEY (`guestID`,`courseID`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
 ADD PRIMARY KEY (`courseID`,`date`,`time_start`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
 ADD PRIMARY KEY (`personID`);

--
-- Indexes for table `registration`
--
ALTER TABLE `registration`
 ADD PRIMARY KEY (`registrationID`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
 ADD PRIMARY KEY (`room_number`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
 ADD PRIMARY KEY (`studentID`), ADD KEY `fk_student_person1_idx` (`studentID`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
 ADD PRIMARY KEY (`teacherID`,`courseID`), ADD KEY `courseID_FK_idx` (`courseID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `registration`
--
ALTER TABLE `registration`
MODIFY `registrationID` smallint(6) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`adminID`) REFERENCES `person` (`personID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `enrolledstudent`
--
ALTER TABLE `enrolledstudent`
ADD CONSTRAINT `enrolledstudent_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `person` (`personID`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `enrolledstudent_ibfk_2` FOREIGN KEY (`registrationID`) REFERENCES `registration` (`registrationID`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `enrolledstudent_ibfk_3` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `guestlecturer`
--
ALTER TABLE `guestlecturer`
ADD CONSTRAINT `guestlecturer_ibfk_1` FOREIGN KEY (`guestID`) REFERENCES `person` (`personID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `lesson`
--
ALTER TABLE `lesson`
ADD CONSTRAINT `lesson_ibfk_1` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `person` (`personID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `teacher`
--
ALTER TABLE `teacher`
ADD CONSTRAINT `teacher_ibfk_1` FOREIGN KEY (`teacherID`) REFERENCES `person` (`personID`) ON DELETE NO ACTION ON UPDATE CASCADE,
ADD CONSTRAINT `teacher_ibfk_2` FOREIGN KEY (`courseID`) REFERENCES `course` (`courseID`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
