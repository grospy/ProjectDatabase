-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2015 at 02:20 AM
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
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseID` varchar(7) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `capacity` tinyint(3) unsigned NOT NULL,
  `studyload` tinyint(3) unsigned DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`courseID`, `name`, `capacity`, `studyload`) VALUES
('IBIS001', '3D printing: from Design to Print', 20, 40),
('IBIS002', 'Advance your English! Cambridge English Advanced', 20, 40),
('IBIS003', 'Advanced Selling Techniques: telephone acquisition', 20, 24),
('IBIS004', 'Brain Food: Food for Thought', 20, 20),
('IBIS005', 'Breaking Booking.com', 20, 18),
('IBIS006', 'China and the West, a cultural and historical background', 20, 20),
('IBIS007', 'Creative Urban Renewal', 20, 28),
('IBIS008', 'Dutch Language and Culture for Beginners+', 20, 40),
('IBIS009', 'Exploring possibilities of Virtual Reality', 20, 24),
('IBIS010', 'Fast reading', 20, 6),
('IBIS011', 'French, slightly advanced', 20, 56),
('IBIS012', 'Growth hacking – how to get marketing attention without a marketing budget', 20, 24),
('IBIS013', 'How we can learn to innovate from creative users and some mad designers and scientists', 20, 28),
('IBIS014', 'Introduction to Graphic Design', 20, 20),
('IBIS015', 'Introduction to Psychology', 20, 20),
('IBIS016', 'Magazine making & Innovation', 20, 36),
('IBIS017', 'Meaning in Music: The semiotics of Music in Culture', 20, 12),
('IBIS018', 'Microsoft Excel for any level', 20, 28),
('IBIS019', 'Movietime: stories for Business', 20, 36),
('IBIS020', 'NLP: Key to be more effective in work and communication', 20, 14),
('IBIS021', 'New Science of the Mind & Neuromarketing', 20, 24),
('IBIS022', 'Opening the black box: how to develop a clever experience?', 20, 20),
('IBIS023', 'Personal Branding & Networking', 20, 15),
('IBIS024', 'Photoshop Fundamentals', 20, 56),
('IBIS025', 'Religious or not: that’s the question', 20, 24),
('IBIS026', 'Russia; an eagle looking in two directions', 20, 20),
('IBIS027', 'Social Media Monitoring & Marketing', 20, 20),
('IBIS028', 'Spain as a Brand', 20, 20),
('IBIS029', 'Spanish A1/A2 (beginners)', 20, 56),
('IBIS030', 'Speaking with Confidence', 20, 20),
('IBIS031', 'Visual Harvesting: The Power of Visual Stories', 20, 8),
('IBIS032', 'Website fundamental', 20, 24);

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `employee_number` varchar(6) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) NOT NULL,
  `email` varchar(25) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_number`, `first_name`, `last_name`, `email`, `username`, `password`) VALUES
('1', '', '', '', 'administrator', '200ceb26807d6bf99fd6f4f0d1ca54d4'),
('11111', 'Drillenburg', 'Harald', 'Harald.Drillenburg@INHOLL', 'Harald.Drillenburg@I', 'harald'),
('22222', 'Belinda', 'Kroes', 'Belinda.Kroes@INHOLLAND.n', 'Belinda.Kroes@INHOLL', 'belinda'),
('33333', 'Margje', 'Penning', 'margje.penning@inholland.', 'margje.penning@inhol', 'margje'),
('44444', 'Sandra', 'Reeb-Gruber', 'Sandra.ReebGruber@INHOLLA', 'Sandra.ReebGruber@IN', 'sandra');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_students`
--

CREATE TABLE IF NOT EXISTS `enrolled_students` (
  `courseID` varchar(7) NOT NULL,
  `studentID` varchar(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrolled_students`
--

INSERT INTO `enrolled_students` (`courseID`, `studentID`) VALUES
('IBIS001', '559942'),
('IBIS002', '559942'),
('IBIS003', '559942'),
('IBIS004', '559942');

-- --------------------------------------------------------

--
-- Table structure for table `grade`
--

CREATE TABLE IF NOT EXISTS `grade` (
  `student_number` varchar(6) NOT NULL,
  `courseID` char(7) NOT NULL,
  `year` year(4) NOT NULL,
  `term` enum('1','2','3','4') NOT NULL,
  `grade` tinyint(3) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `grade`
--

INSERT INTO `grade` (`student_number`, `courseID`, `year`, `term`, `grade`) VALUES
('559942', '3D Art', 2001, '1', 10),
('559942', '2D Art', 2001, '2', 8);

-- --------------------------------------------------------

--
-- Table structure for table `lesson`
--

CREATE TABLE IF NOT EXISTS `lesson` (
  `courseID` varchar(7) NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time_start` time NOT NULL,
  `room_number` varchar(5) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` (`courseID`, `date`, `time_start`, `room_number`) VALUES
('IBIS001', '2015-05-04', '09:00:00', ''),
('IBIS001', '2015-05-22', '12:00:00', ''),
('IBIS001', '2015-05-29', '12:00:00', ''),
('IBIS001', '2015-06-04', '09:00:00', ''),
('IBIS001', '2015-06-04', '12:00:00', ''),
('IBIS001', '2015-06-04', '15:00:00', ''),
('IBIS001', '2015-06-05', '09:00:00', ''),
('IBIS001', '2015-06-05', '12:00:00', ''),
('IBIS001', '2015-06-05', '15:00:00', ''),
('IBIS001', '2015-06-08', '09:00:00', ''),
('IBIS001', '2015-06-19', '09:00:00', ''),
('IBIS002', '2015-04-29', '09:00:00', ''),
('IBIS002', '2015-05-01', '12:00:00', ''),
('IBIS002', '2015-05-22', '12:00:00', ''),
('IBIS002', '2015-05-29', '12:00:00', ''),
('IBIS002', '2015-06-01', '09:00:00', ''),
('IBIS002', '2015-06-04', '12:00:00', ''),
('IBIS002', '2015-06-19', '12:00:00', ''),
('IBIS003', '2015-05-13', '09:00:00', ''),
('IBIS003', '2015-06-04', '09:00:00', ''),
('IBIS003', '2015-06-04', '12:00:00', ''),
('IBIS003', '2015-06-04', '15:00:00', ''),
('IBIS003', '2015-06-05', '09:00:00', ''),
('IBIS003', '2015-06-05', '12:00:00', ''),
('IBIS003', '2015-06-08', '09:00:00', ''),
('IBIS003', '2015-06-08', '12:00:00', ''),
('IBIS003', '2015-06-08', '15:00:00', ''),
('IBIS004', '2015-05-22', '12:00:00', ''),
('IBIS004', '2015-05-29', '12:00:00', ''),
('IBIS004', '2015-06-12', '15:00:00', ''),
('IBIS004', '2015-06-19', '15:00:00', ''),
('IBIS005', '2015-05-01', '12:00:00', ''),
('IBIS005', '2015-05-07', '15:00:00', ''),
('IBIS005', '2015-05-13', '09:00:00', ''),
('IBIS006', '2015-05-29', '09:00:00', ''),
('IBIS006', '2015-06-12', '09:00:00', ''),
('IBIS006', '2015-06-19', '12:00:00', ''),
('IBIS007', '2015-04-30', '15:00:00', ''),
('IBIS007', '2015-05-07', '15:00:00', ''),
('IBIS007', '2015-05-22', '12:00:00', ''),
('IBIS007', '2015-05-28', '15:00:00', ''),
('IBIS007', '2015-05-29', '15:00:00', ''),
('IBIS008', '2015-05-22', '12:00:00', ''),
('IBIS008', '2015-05-29', '12:00:00', ''),
('IBIS008', '2015-06-05', '12:00:00', ''),
('IBIS008', '2015-06-08', '12:00:00', ''),
('IBIS008', '2015-06-12', '12:00:00', ''),
('IBIS008', '2015-06-12', '15:00:00', ''),
('IBIS008', '2015-06-19', '12:00:00', ''),
('IBIS009', '2015-04-29', '09:00:00', ''),
('IBIS009', '2015-05-01', '15:00:00', ''),
('IBIS009', '2015-05-11', '09:00:00', ''),
('IBIS009', '2015-05-22', '15:00:00', ''),
('IBIS010', '2015-05-01', '09:00:00', ''),
('IBIS011', '2015-04-28', '15:00:00', ''),
('IBIS011', '2015-05-11', '09:00:00', ''),
('IBIS011', '2015-05-28', '15:00:00', ''),
('IBIS011', '2015-06-04', '12:00:00', ''),
('IBIS011', '2015-06-08', '12:00:00', ''),
('IBIS011', '2015-06-12', '12:00:00', ''),
('IBIS011', '2015-06-19', '12:00:00', ''),
('IBIS012', '2015-05-08', '09:00:00', ''),
('IBIS012', '2015-05-22', '09:00:00', ''),
('IBIS012', '2015-05-28', '15:00:00', ''),
('IBIS012', '2015-06-04', '15:00:00', ''),
('IBIS013', '2015-05-11', '09:00:00', ''),
('IBIS013', '2015-05-29', '09:00:00', ''),
('IBIS013', '2015-06-04', '12:00:00', ''),
('IBIS013', '2015-06-08', '12:00:00', ''),
('IBIS014', '2015-04-29', '09:00:00', ''),
('IBIS014', '2015-05-08', '15:00:00', ''),
('IBIS014', '2015-05-22', '15:00:00', ''),
('IBIS014', '2015-05-29', '15:00:00', ''),
('IBIS015', '2015-05-01', '12:00:00', ''),
('IBIS015', '2015-05-08', '12:00:00', ''),
('IBIS015', '2015-05-22', '12:00:00', ''),
('IBIS015', '2015-05-29', '12:00:00', ''),
('IBIS016', '2015-05-04', '09:00:00', ''),
('IBIS016', '2015-05-22', '12:00:00', ''),
('IBIS016', '2015-05-29', '12:00:00', ''),
('IBIS016', '2015-06-04', '15:00:00', ''),
('IBIS017', '2015-05-11', '09:00:00', ''),
('IBIS017', '2015-05-22', '09:00:00', ''),
('IBIS017', '2015-06-05', '09:00:00', ''),
('IBIS018', '2015-05-04', '09:00:00', ''),
('IBIS018', '2015-05-13', '09:00:00', ''),
('IBIS018', '2015-06-05', '09:00:00', ''),
('IBIS018', '2015-06-12', '09:00:00', ''),
('IBIS018', '2015-06-19', '09:00:00', ''),
('IBIS019', '2015-04-28', '15:00:00', ''),
('IBIS019', '2015-05-01', '15:00:00', ''),
('IBIS019', '2015-05-08', '15:00:00', ''),
('IBIS019', '2015-05-22', '15:00:00', ''),
('IBIS019', '2015-05-29', '15:00:00', ''),
('IBIS019', '2015-06-02', '15:00:00', ''),
('IBIS019', '2015-06-12', '15:00:00', ''),
('IBIS020', '2015-05-28', '15:00:00', ''),
('IBIS020', '2015-06-02', '15:00:00', ''),
('IBIS020', '2015-06-04', '15:00:00', ''),
('IBIS021', '2015-04-29', '09:00:00', ''),
('IBIS021', '2015-05-13', '09:00:00', ''),
('IBIS021', '2015-06-03', '09:00:00', ''),
('IBIS021', '2015-06-08', '09:00:00', ''),
('IBIS022', '2015-04-29', '09:00:00', ''),
('IBIS022', '2015-05-04', '09:00:00', ''),
('IBIS022', '2015-05-12', '15:00:00', ''),
('IBIS022', '2015-05-29', '09:00:00', ''),
('IBIS023', '2015-06-12', '15:00:00', ''),
('IBIS023', '2015-06-19', '15:00:00', ''),
('IBIS024', '2015-04-28', '15:00:00', ''),
('IBIS024', '2015-05-07', '15:00:00', ''),
('IBIS024', '2015-05-12', '15:00:00', ''),
('IBIS024', '2015-05-28', '15:00:00', ''),
('IBIS024', '2015-06-04', '15:00:00', ''),
('IBIS025', '2015-06-02', '15:00:00', ''),
('IBIS025', '2015-06-05', '12:00:00', ''),
('IBIS025', '2015-06-12', '12:00:00', ''),
('IBIS025', '2015-06-19', '12:00:00', ''),
('IBIS026', '2015-04-28', '15:00:00', ''),
('IBIS026', '2015-05-12', '15:00:00', ''),
('IBIS026', '2015-05-22', '12:00:00', ''),
('IBIS026', '2015-06-04', '15:00:00', ''),
('IBIS027', '2015-05-01', '09:00:00', ''),
('IBIS027', '2015-05-12', '15:00:00', ''),
('IBIS028', '2015-06-03', '09:00:00', ''),
('IBIS028', '2015-06-05', '09:00:00', ''),
('IBIS028', '2015-06-08', '12:00:00', ''),
('IBIS029', '2015-04-29', '09:00:00', ''),
('IBIS029', '2015-05-04', '09:00:00', ''),
('IBIS029', '2015-05-11', '09:00:00', ''),
('IBIS029', '2015-06-01', '09:00:00', ''),
('IBIS029', '2015-06-04', '12:00:00', ''),
('IBIS029', '2015-06-12', '12:00:00', ''),
('IBIS029', '2015-06-19', '12:00:00', ''),
('IBIS030', '2015-04-28', '15:00:00', ''),
('IBIS030', '2015-05-07', '15:00:00', ''),
('IBIS030', '2015-05-11', '09:00:00', ''),
('IBIS030', '2015-05-28', '15:00:00', ''),
('IBIS031', '2015-06-12', '15:00:00', ''),
('IBIS031', '2015-06-19', '15:00:00', ''),
('IBIS032', '2015-06-02', '15:00:00', ''),
('IBIS032', '2015-06-05', '12:00:00', ''),
('IBIS032', '2015-06-12', '12:00:00', ''),
('IBIS032', '2015-06-19', '12:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `registration`
--

CREATE TABLE IF NOT EXISTS `registration` (
  `year` year(4) NOT NULL,
  `term` enum('1','2','3','4') NOT NULL,
  `openRegDate` datetime NOT NULL,
  `closeRegDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registration`
--

INSERT INTO `registration` (`year`, `term`, `openRegDate`, `closeRegDate`) VALUES
(2015, '4', '2015-05-20 00:00:00', '2015-05-22 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_number` varchar(6) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(20) DEFAULT NULL,
  `email` varchar(25) NOT NULL,
  `sent` int(1) NOT NULL DEFAULT '0',
  `password` varchar(32) NOT NULL,
  `set_code` varchar(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_number`, `first_name`, `last_name`, `email`, `sent`, `password`, `set_code`) VALUES
('559942', 'Louis', NULL, '', 2, 'cfcd208495d565ef66e7dff9f98764da', 'ZCQ2QLFS'),
('552301', 'Sasmita', NULL, '', 1, '3ccbda445fcce40d8aa046f393f256e0', 'SR8QYX9S'),
('560755', 'Niki', NULL, '', 0, '', ''),
('523001', 'Shamil', NULL, '', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `employee_number` varchar(6) NOT NULL,
  `courseID` varchar(7) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teacher`
--

INSERT INTO `teacher` (`employee_number`, `courseID`) VALUES
('11111', 'IBIS001'),
('11111', 'IBIS006'),
('11111', 'IBIS010'),
('11111', 'IBIS014'),
('11111', 'IBIS018'),
('11111', 'IBIS022'),
('11111', 'IBIS026'),
('11111', 'IBIS030'),
('22222', 'IBIS002'),
('22222', 'IBIS007'),
('22222', 'IBIS011'),
('22222', 'IBIS015'),
('22222', 'IBIS019'),
('22222', 'IBIS023'),
('22222', 'IBIS027'),
('22222', 'IBIS031'),
('33333', 'IBIS003'),
('33333', 'IBIS004'),
('33333', 'IBIS008'),
('33333', 'IBIS012'),
('33333', 'IBIS016'),
('33333', 'IBIS020'),
('33333', 'IBIS024'),
('33333', 'IBIS028'),
('33333', 'IBIS032'),
('44444', 'IBIS005'),
('44444', 'IBIS009'),
('44444', 'IBIS013'),
('44444', 'IBIS017'),
('44444', 'IBIS021'),
('44444', 'IBIS025'),
('44444', 'IBIS029');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
 ADD PRIMARY KEY (`courseID`), ADD KEY `courseID` (`courseID`), ADD KEY `courseID_2` (`courseID`), ADD KEY `courseID_3` (`courseID`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
 ADD PRIMARY KEY (`employee_number`);

--
-- Indexes for table `grade`
--
ALTER TABLE `grade`
 ADD PRIMARY KEY (`student_number`,`courseID`);

--
-- Indexes for table `lesson`
--
ALTER TABLE `lesson`
 ADD PRIMARY KEY (`courseID`,`date`,`time_start`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
 ADD PRIMARY KEY (`student_number`);

--
-- Indexes for table `teacher`
--
ALTER TABLE `teacher`
 ADD PRIMARY KEY (`employee_number`,`courseID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
