-- phpMyAdmin SQL Dump
-- version 3.5.8.2
-- http://www.phpmyadmin.net
--
-- Host: sql201.byethost5.com
-- Generation Time: May 03, 2015 at 07:45 AM
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
-- Table structure for table `UserName`
--

CREATE TABLE IF NOT EXISTS `UserName` (
  `UserNameID` int(9) NOT NULL AUTO_INCREMENT,
  `userName` varchar(40) NOT NULL,
  `pass` varchar(40) NOT NULL,
  PRIMARY KEY (`UserNameID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `UserName`
--

INSERT INTO `UserName` (`UserNameID`, `userName`, `pass`) VALUES
(1, '000001', 'admin'),
(2, '000002', 'admin'),
(3, '000003', 'admin'),
(4, '000004', 'admin'),
(5, '000005', 'admin'),
(6, '000006', 'admin'),
(7, '000007', 'admin'),
(8, '000008', 'admin'),
(9, '000009', 'admin'),
(10, '000010', 'admin');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
