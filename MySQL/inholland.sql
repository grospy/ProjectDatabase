-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql201.byethost5.com
-- Generation Time: May 14, 2015 at 06:38 AM
-- Server version: 5.6.22-71.0
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `b5_16152360_inholland`
--

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `courseID` varchar(7) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `capacity` tinyint(3) unsigned NOT NULL,
  `studyload` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`courseID`),
  KEY `courseID` (`courseID`),
  KEY `courseID_2` (`courseID`),
  KEY `courseID_3` (`courseID`)
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
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`employee_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- Employee modified

CREATE TABLE IF NOT EXISTS `Employee` (
    `first_name` varchar(15),
	`last_name`  varchar(20),
	`email`      varchar(15),
	`phone_nr`   int(20),
	`emp_nr`     int(20),
	PRIMARY KEY(`emp_id`),
	FOREIGN KEY(`emp_type`)
	)
	
CREATE TABLE IF NOT EXISTS `type` (
    `internal`   varchar(20),
	`external`   varchar(15)
	)

--
-- Dumping data for table `employee`
--


INSERT INTO `employee`  VALUES ('1', '', '', '', 'administrator', '200ceb26807d6bf99fd6f4f0d1ca54d4');
INSERT INTO `employee`  VALUES ('11111', 'Drillenburg', 'Harald', 'Harald.Drillenburg@INHOLL', 'Harald.Drillenburg@I', 'harald');
INSERT INTO `employee`  VALUES ('22222', 'Belinda', 'Kroes', 'Belinda.Kroes@INHOLLAND.n', 'Belinda.Kroes@INHOLL', 'belinda');
INSERT INTO `employee`  VALUES ('33333', 'Margje', 'Penning', 'margje.penning@inholland.', 'margje.penning@inhol', 'margje');
INSERT INTO `employee`  VALUES ('44444', 'Sandra', 'Reeb-Gruber', 'Sandra.ReebGruber@INHOLLA', 'Sandra.ReebGruber@IN', 'sandra');


-- --------------------------------------------------------

--
-- Table structure for table `enrolled_students`
--

CREATE TABLE IF NOT EXISTS `enrolled_students` (
  `courseID` varchar(7) NOT NULL,
  `studentID` varchar(6) NOT NULL
  `phone_nr` int(9) NOT NULL,
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrolled_students`
--


INSERT INTO `enrolled_students` VALUES ('IBIS001', '559942','0627349328749');
INSERT INTO `enrolled_students` VALUES ('IBIS002', '556789','0627349328758');
INSERT INTO `enrolled_students` VALUES ('IBIS003', '559942','0627349328747');
INSERT INTO `enrolled_students` VALUES ('IBIS004', '559942','0627349328745');
INSERT INTO `enrolled_students` VALUES ('IBIS005', '552301','0627349328742');
INSERT INTO `enrolled_students` VALUES ('IBIS006', '552301','0627349328741');
INSERT INTO `enrolled_students` VALUES ('IBIS007', '552301','0627349328743');
INSERT INTO `enrolled_students` VALUES ('IBIS008', '552301','0627349328767');

-- --------------------------------------------------------

-- grade
CREATE TABLE IF NOT EXISTS `grade` (
  `Year` int(6),
  `Semester` varchar(6),
  `Grade`   int(3),
  PRIMARY KEY(`course_ID`)
  ) 
  -- student_grade
  CREATE TABLE IF NOT EXISTS `student_grade` (
  `student_number` varchar(6) NOT NULL,
  `courseID` char(7) NOT NULL,
  `year` year(4) NOT NULL,
  `term` enum('1','2','3','4') NOT NULL,
  `grade` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`student_number`,`courseID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Registration` (
   `Starttime` varchar(10),
   `EndTime`   varchar(10)
   )
   
-- Students & course

CREATE TABLE IF NOT EXISTS `students&course` (
   `student_nr` int(10),
   `course_ID`  int(14),
   )
   
--  Course
  PRIMARY KEY (`courseID`,`date`,`time_start`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
--Creating table lesson`
---- Lesson


   
   CREATE TABLE IF NOT EXISTS `lesson` (
  `capacity` varchar(6) NOT NULL,
  `course_ID` varchar(20) NOT NULL,
  `date` varchar(20) NOT NULL,
  `start_time` varchar(25) NOT NULL,
  `room_number` varchar(20) NOT NULL,
  `location` varchar(32) NOT NULL,
   PRIMARY KEY (`date`)
)
--
-- Dumping data for table `lesson`
--

INSERT INTO `lesson` VALUES 
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-05-04', '09:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-05-22', '12:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-05-29', '12:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-06-04', '09:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-06-04', '12:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-06-04', '15:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-06-05', '09:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-06-05', '12:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-06-05', '15:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-06-08', '09:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS001', '2015-06-19', '09:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS002', '2015-04-29', '09:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS002', '2015-05-01', '12:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS002', '2015-05-22', '12:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS002', '2015-05-29', '12:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS002', '2015-06-01', '09:00:00', 'B2-14','Diemen');
INSERT INTO `lesson` VALUES ('50','IBIS002', '2015-06-04', '12:00:00', 'B2-14','Diemen');

-- 
/* To be modified
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
*/
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
  `set_code` varchar(8) NOT NULL,
  PRIMARY KEY (`student_number`)
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

CREATE TABLE IF NOT EXISTS `Course` (
   `name` varchar(10),
   PRIMARY KEY(`course_ID`)
   )
   



--Location

CREATE TABLE IF NOT EXISTS `Location` (
    `room_capacity` int(10),
	PRIMARY KEY(`room_number`)
	)
  
INSERT INTO `teacher` (`employee_number`, `courseID`) VALUES
('11111', 'IBIS001'),
('11111', 'IBIS006'),
('22222', 'IBIS002'),
('22222', 'IBIS007'),
('33333', 'IBIS003'),
('33333', 'IBIS004'),
('33333', 'IBIS008'),
('44444', 'IBIS005');
  
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
