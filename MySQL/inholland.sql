-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql201.byetcluster.com
-- Generation Time: May 03, 2015 at 07:35 PM
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
-- Table structure for table `employee`
--

CREATE TABLE IF NOT EXISTS `employee` (
  `employee_number` int(6) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`employee_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`employee_number`, `username`, `password`) VALUES
(1, 'administrator', '200ceb26807d6bf99fd6f4f0d1ca54d4');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_number` int(6) NOT NULL,
  `first_name` varchar(35) NOT NULL,
  `password` varchar(32) NOT NULL,
  `phone_nr` int(9) NOT NULL,
  PRIMARY KEY (`student_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`student_number`, `first_name`, `password`) VALUES
(480402, 'Louis', '5e92b6d9772966b339aef40faf6b640b'
 523001, 'Shamil','5e92b6d9772966b339aef40faf6b640c');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- grade
CREATE TABLE IF NOT EXISTS `grade` (
  `Year` int(6),
  `Semester` varchar(6),
  `Grade`   int(3),
  PRIMARY KEY(`course_ID`)
  ) 
  
-- Registration

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

CREATE TABLE IF NOT EXISTS `Course` (
   `name` varchar(10),
   PRIMARY KEY(`course_ID`)
   )
   
-- Lesson

CREATE TABLE IF NOT EXISTS `Lesson` (
   `capacity` int(10),
   FOREIGN KEY(`course_ID`),
   PRIMARY KEY(`date`),
   
   PRIMARY KEY(`location`),
   PRIMARY KEY(`start_time`)
   )


--Location

CREATE TABLE IF NOT EXISTS `Location` (
    `room_capacity` int(10),
	PRIMARY KEY(`room_number`)
	)
  