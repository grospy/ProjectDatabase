drop database inholland;
create database inholland;
use inholland;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

CREATE TABLE IF NOT EXISTS `admin` (
  `adminID` varchar(6) NOT NULL DEFAULT 'admin',
  `password` varchar(45) NOT NULL DEFAULT 'admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `admin` (`adminID`, `password`) VALUES
('admin', 'e7c8a79dbd6c97ac6e5b851e4a52a9a1');

CREATE TABLE IF NOT EXISTS `course` (
  `courseID` varchar(7) NOT NULL,
  `name` varchar(300) NOT NULL,
  `capacity` tinyint(1) unsigned NOT NULL,
  `studyload` tinyint(1) unsigned NOT NULL,
  `offer` bit(1) NOT NULL DEFAULT b'1' COMMENT '0 for not being offered, 1 for being offered'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `course` (`courseID`, `name`, `capacity`, `studyload`, `offer`) VALUES
('IBIS001', '3D printing: from Design to Print', 20, 40, b'1'),
('IBIS002', 'Advance your English! Cambridge English Advanced', 20, 40, b'1'),
('IBIS003', 'Advanced Selling Techniques: telephone acquisition', 20, 24, b'1'),
('IBIS004', 'Brain Food: Food for Thought', 20, 20, b'1'),
('IBIS005', 'Breaking Booking.com', 20, 18, b'1'),
('IBIS006', 'China and the West, a cultural and historical background', 20, 20, b'1'),
('IBIS007', 'Creative Urban Renewal', 20, 28, b'1'),
('IBIS008', 'Dutch Language and Culture for Beginners+', 20, 40, b'1'),
('IBIS009', 'Exploring possibilities of Virtual Reality', 20, 24, b'1'),
('IBIS010', 'Fast reading', 20, 6, b'1'),
('IBIS011', 'French, slightly advanced', 20, 56, b'1'),
('IBIS012', 'Growth hacking - how to get marketing attention without a marketing budget', 20, 24, b'1'),
('IBIS013', 'How we can learn to innovate from creative users and some mad designers and scientists', 20, 28, b'1'),
('IBIS014', 'Introduction to Graphic Design', 20, 20, b'1'),
('IBIS015', 'Introduction to Psychology', 20, 20, b'1'),
('IBIS016', 'Magazine making & Innovation', 20, 36, b'1'),
('IBIS017', 'Meaning in Music: The semiotics of Music in Culture', 20, 12, b'1'),
('IBIS018', 'Microsoft Excel for any level', 20, 28, b'1'),
('IBIS019', 'Movietime: stories for Business', 20, 36, b'1'),
('IBIS020', 'NLP: Key to be more effective in work and communication', 20, 14, b'1'),
('IBIS021', 'New Science of the Mind & Neuromarketing', 20, 24, b'1'),
('IBIS022', 'Opening the black box: how to develop a clever experience?', 20, 20, b'1'),
('IBIS023', 'Personal Branding & Networking', 20, 15, b'1'),
('IBIS024', 'Photoshop Fundamentals', 20, 56, b'1'),
('IBIS025', 'Religious or not: thatâ€™s the question', 20, 24, b'1'),
('IBIS026', 'Russia; an eagle looking in two directions', 20, 20, b'1'),
('IBIS027', 'Social Media Monitoring & Marketing', 20, 20, b'1'),
('IBIS028', 'Spain as a Brand', 20, 20, b'1'),
('IBIS029', 'Spanish A1/A2 (beginners)', 20, 56, b'1'),
('IBIS030', 'Speaking with Confidence', 20, 20, b'1'),
('IBIS031', 'Visual Harvesting: The Power of Visual Stories', 20, 8, b'1'),
('IBIS032', 'Website fundamental', 20, 24, b'1');

CREATE TABLE IF NOT EXISTS `enrolledstudent` (
  `registrationID` char(10) NOT NULL,
  `studentID` varchar(6) NOT NULL,
  `courseID` varchar(7) NOT NULL,
  `grade` tinyint(1) unsigned DEFAULT NULL,
  `status` bit(1) DEFAULT NULL COMMENT '0 for fail, 1 for pass, null for currently taking'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `guestlecturer` (
  `guestID` varchar(6) NOT NULL,
  `courseID` varchar(7) NOT NULL,
  `contactperson` varchar(50) DEFAULT NULL,
  `remark` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `lesson` (
  `courseID` varchar(7) NOT NULL,
  `roomnumber` varchar(6) NOT NULL,
  `date` date NOT NULL,
  `time_start` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `lesson` (`courseID`, `roomnumber`, `date`, `time_start`) VALUES
('IBIS001', 'E-10', '2015-05-04', '09:00:00'),
('IBIS001', 'E-10', '2015-05-22', '12:00:00'),
('IBIS001', 'E-11', '2015-06-19', '09:00:00'),
('IBIS001', 'E-15', '2015-06-05', '09:00:00'),
('IBIS001', 'E-20', '2015-05-29', '12:00:00'),
('IBIS001', 'E-20', '2015-06-05', '12:00:00'),
('IBIS001', 'E-21', '2015-06-05', '15:00:00'),
('IBIS001', 'E-22', '2015-06-04', '09:00:00'),
('IBIS001', 'E-23', '2015-06-04', '12:00:00'),
('IBIS001', 'E-24', '2015-06-04', '15:00:00'),
('IBIS001', 'E-34', '2015-06-08', '09:00:00'),
('IBIS002', 'E-10', '2015-04-29', '09:00:00'),
('IBIS002', 'E-10', '2015-05-01', '12:00:00'),
('IBIS002', 'E-10', '2015-06-01', '09:00:00'),
('IBIS002', 'E-11', '2015-05-22', '12:00:00'),
('IBIS002', 'E-12', '2015-06-19', '12:00:00'),
('IBIS002', 'E-21', '2015-05-29', '12:00:00'),
('IBIS002', 'E-25', '2015-06-04', '12:00:00'),
('IBIS003', 'E-10', '2015-05-13', '09:00:00'),
('IBIS003', 'E-10', '2015-06-08', '12:00:00'),
('IBIS003', 'E-11', '2015-06-08', '15:00:00'),
('IBIS003', 'E-22', '2015-06-05', '09:00:00'),
('IBIS003', 'E-23', '2015-06-05', '12:00:00'),
('IBIS003', 'E-30', '2015-06-04', '09:00:00'),
('IBIS003', 'E-31', '2015-06-04', '12:00:00'),
('IBIS003', 'E-32', '2015-06-04', '15:00:00'),
('IBIS003', 'E-35', '2015-06-08', '09:00:00'),
('IBIS004', 'E-12', '2015-05-22', '12:00:00'),
('IBIS004', 'E-13', '2015-06-19', '15:00:00'),
('IBIS004', 'E-21', '2015-06-12', '15:00:00'),
('IBIS004', 'E-22', '2015-05-29', '12:00:00'),
('IBIS005', 'E-10', '2015-05-07', '15:00:00'),
('IBIS005', 'E-11', '2015-05-01', '12:00:00'),
('IBIS005', 'E-11', '2015-05-13', '09:00:00'),
('IBIS006', 'E-14', '2015-06-19', '12:00:00'),
('IBIS006', 'E-22', '2015-06-12', '09:00:00'),
('IBIS006', 'E-23', '2015-05-29', '09:00:00'),
('IBIS007', 'E-10', '2015-05-28', '15:00:00'),
('IBIS007', 'E-11', '2015-05-07', '15:00:00'),
('IBIS007', 'E-13', '2015-05-22', '12:00:00'),
('IBIS007', 'E-20', '2015-04-30', '15:00:00'),
('IBIS007', 'E-24', '2015-05-29', '15:00:00'),
('IBIS008', 'E-12', '2015-06-08', '12:00:00'),
('IBIS008', 'E-14', '2015-05-22', '12:00:00'),
('IBIS008', 'E-15', '2015-06-19', '12:00:00'),
('IBIS008', 'E-23', '2015-06-12', '12:00:00'),
('IBIS008', 'E-24', '2015-06-05', '12:00:00'),
('IBIS008', 'E-24', '2015-06-12', '15:00:00'),
('IBIS008', 'E-25', '2015-05-29', '12:00:00'),
('IBIS009', 'E-10', '2015-05-11', '09:00:00'),
('IBIS009', 'E-11', '2015-04-29', '09:00:00'),
('IBIS009', 'E-12', '2015-05-01', '15:00:00'),
('IBIS009', 'E-15', '2015-05-22', '15:00:00'),
('IBIS010', 'E-13', '2015-05-01', '09:00:00'),
('IBIS011', 'E-10', '2015-04-28', '15:00:00'),
('IBIS011', 'E-11', '2015-05-11', '09:00:00'),
('IBIS011', 'E-11', '2015-05-28', '15:00:00'),
('IBIS011', 'E-13', '2015-06-08', '12:00:00'),
('IBIS011', 'E-20', '2015-06-19', '12:00:00'),
('IBIS011', 'E-25', '2015-06-12', '12:00:00'),
('IBIS011', 'E-33', '2015-06-04', '12:00:00'),
('IBIS012', 'E-10', '2015-05-08', '09:00:00'),
('IBIS012', 'E-12', '2015-05-28', '15:00:00'),
('IBIS012', 'E-20', '2015-05-22', '09:00:00'),
('IBIS012', 'E-34', '2015-06-04', '15:00:00'),
('IBIS013', 'E-12', '2015-05-11', '09:00:00'),
('IBIS013', 'E-14', '2015-06-08', '12:00:00'),
('IBIS013', 'E-30', '2015-05-29', '09:00:00'),
('IBIS013', 'E-35', '2015-06-04', '12:00:00'),
('IBIS014', 'E-11', '2015-05-08', '15:00:00'),
('IBIS014', 'E-12', '2015-04-29', '09:00:00'),
('IBIS014', 'E-21', '2015-05-22', '15:00:00'),
('IBIS014', 'E-31', '2015-05-29', '15:00:00'),
('IBIS015', 'E-12', '2015-05-08', '12:00:00'),
('IBIS015', 'E-14', '2015-05-01', '12:00:00'),
('IBIS015', 'E-22', '2015-05-22', '12:00:00'),
('IBIS015', 'E-32', '2015-05-29', '12:00:00'),
('IBIS016', 'E-10', '2015-06-04', '15:00:00'),
('IBIS016', 'E-11', '2015-05-04', '09:00:00'),
('IBIS016', 'E-23', '2015-05-22', '12:00:00'),
('IBIS016', 'E-33', '2015-05-29', '12:00:00'),
('IBIS017', 'E-13', '2015-05-11', '09:00:00'),
('IBIS017', 'E-24', '2015-05-22', '09:00:00'),
('IBIS017', 'E-25', '2015-06-05', '09:00:00'),
('IBIS018', 'E-12', '2015-05-04', '09:00:00'),
('IBIS018', 'E-12', '2015-05-13', '09:00:00'),
('IBIS018', 'E-21', '2015-06-19', '09:00:00'),
('IBIS018', 'E-30', '2015-06-05', '09:00:00'),
('IBIS018', 'E-30', '2015-06-12', '09:00:00'),
('IBIS019', 'E-11', '2015-04-28', '15:00:00'),
('IBIS019', 'E-12', '2015-06-02', '15:00:00'),
('IBIS019', 'E-13', '2015-05-08', '15:00:00'),
('IBIS019', 'E-15', '2015-05-01', '15:00:00'),
('IBIS019', 'E-25', '2015-05-22', '15:00:00'),
('IBIS019', 'E-31', '2015-06-12', '15:00:00'),
('IBIS019', 'E-34', '2015-05-29', '15:00:00'),
('IBIS020', 'E-11', '2015-06-04', '15:00:00'),
('IBIS020', 'E-13', '2015-05-28', '15:00:00'),
('IBIS020', 'E-13', '2015-06-02', '15:00:00'),
('IBIS021', 'E-13', '2015-04-29', '09:00:00'),
('IBIS021', 'E-13', '2015-05-13', '09:00:00'),
('IBIS021', 'E-15', '2015-06-08', '09:00:00'),
('IBIS021', 'E-20', '2015-06-03', '09:00:00'),
('IBIS022', 'E-10', '2015-05-12', '15:00:00'),
('IBIS022', 'E-13', '2015-05-04', '09:00:00'),
('IBIS022', 'E-14', '2015-04-29', '09:00:00'),
('IBIS022', 'E-35', '2015-05-29', '09:00:00'),
('IBIS023', 'E-22', '2015-06-19', '15:00:00'),
('IBIS023', 'E-32', '2015-06-12', '15:00:00'),
('IBIS024', 'E-11', '2015-05-12', '15:00:00'),
('IBIS024', 'E-12', '2015-04-28', '15:00:00'),
('IBIS024', 'E-12', '2015-05-07', '15:00:00'),
('IBIS024', 'E-12', '2015-06-04', '15:00:00'),
('IBIS024', 'E-14', '2015-05-28', '15:00:00'),
('IBIS025', 'E-14', '2015-06-02', '15:00:00'),
('IBIS025', 'E-23', '2015-06-19', '12:00:00'),
('IBIS025', 'E-31', '2015-06-05', '12:00:00'),
('IBIS025', 'E-33', '2015-06-12', '12:00:00'),
('IBIS026', 'E-12', '2015-05-12', '15:00:00'),
('IBIS026', 'E-13', '2015-04-28', '15:00:00'),
('IBIS026', 'E-13', '2015-06-04', '15:00:00'),
('IBIS026', 'E-30', '2015-05-22', '12:00:00'),
('IBIS027', 'E-13', '2015-05-12', '15:00:00'),
('IBIS027', 'E-20', '2015-05-01', '09:00:00'),
('IBIS028', 'E-20', '2015-06-08', '12:00:00'),
('IBIS028', 'E-21', '2015-06-03', '09:00:00'),
('IBIS028', 'E-32', '2015-06-05', '09:00:00'),
('IBIS029', 'E-11', '2015-06-01', '09:00:00'),
('IBIS029', 'E-14', '2015-05-04', '09:00:00'),
('IBIS029', 'E-14', '2015-05-11', '09:00:00'),
('IBIS029', 'E-14', '2015-06-04', '12:00:00'),
('IBIS029', 'E-15', '2015-04-29', '09:00:00'),
('IBIS029', 'E-24', '2015-06-19', '12:00:00'),
('IBIS029', 'E-34', '2015-06-12', '12:00:00'),
('IBIS030', 'E-13', '2015-05-07', '15:00:00'),
('IBIS030', 'E-14', '2015-04-28', '15:00:00'),
('IBIS030', 'E-15', '2015-05-11', '09:00:00'),
('IBIS030', 'E-15', '2015-05-28', '15:00:00'),
('IBIS031', 'E-25', '2015-06-19', '15:00:00'),
('IBIS031', 'E-35', '2015-06-12', '15:00:00'),
('IBIS032', 'E-10', '2015-06-12', '12:00:00'),
('IBIS032', 'E-15', '2015-06-02', '15:00:00'),
('IBIS032', 'E-30', '2015-06-19', '12:00:00'),
('IBIS032', 'E-33', '2015-06-05', '12:00:00');

CREATE TABLE IF NOT EXISTS `person` (
  `personID` varchar(6) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `type` enum('student','teacher','guest-lecturer','admin') NOT NULL,
  `current` enum('0','1') NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `person` (`personID`, `firstName`, `lastName`, `type`, `current`) VALUES
('11111', 'Harald', 'Drillenburg', 'teacher', '1'),
('22222', 'Kroes', 'Belinda', 'teacher', '1'),
('33333', 'Penning', 'Margje', 'teacher', '1'),
('44444', 'Reeb-Gruber', 'Sandra', 'teacher', '1'),
('523001', 'Shamil', 'Karimli', 'student', '0'),
('552301', 'Sasmita', 'Santoso', 'student', '1'),
('557797', 'Abraham', 'Foto', 'student', '1'),
('559942', 'Louis', 'Le', 'student', '1'),
('admin', 'admin', 'admin', 'admin', '1'),
('ext001', 'Michael', 'Guirella', 'guest-lecturer', '1'),
('ext002', 'Jan', 'Bakker', 'guest-lecturer', '1'),
('ext003', 'Tim', 'Timmerman', 'guest-lecturer', '1');

CREATE TABLE IF NOT EXISTS `registration` (
  `registrationID` mediumint(6) NOT NULL,
  `opendate` date NOT NULL,
  `closedate` date DEFAULT NULL,
  `closedate2` date NOT NULL,
  `type` enum('first','second') NOT NULL DEFAULT 'first',
  `minimumstudents` int(2) NOT NULL DEFAULT '0',
  `minimumcredits` tinyint(3) unsigned NOT NULL,
  `current` enum('1','0') NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `room` (
  `room_number` varchar(6) NOT NULL,
  `capacity` tinyint(1) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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

CREATE TABLE IF NOT EXISTS `student` (
  `studentID` varchar(6) NOT NULL,
  `email` varchar(30) NOT NULL,
  `sent` tinyint(1) unsigned DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `set_code` varchar(8) DEFAULT NULL,
  `allowToReg` bit(1) DEFAULT b'0' COMMENT '0 for not allowed, 1 for allowed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `student` (`studentID`, `email`, `sent`, `password`, `set_code`, `allowToReg`) VALUES
('523001', '523001@student.inholland.nl', 0, 'f65deaf5fea7a7936e8fd8413c224023', NULL, b'1'),
('552301', '552301@student.inholland.nl', 0, 'f65deaf5fea7a7936e8fd8413c224023', NULL, b'1'),
('557797', '557797@student.inholland.nl', 0, 'f65deaf5fea7a7936e8fd8413c224023', NULL, b'1'),
('559942', '559942@student.inholland.nl', 5, 'f65deaf5fea7a7936e8fd8413c224023', 'SJ1QD3WL', b'1');

CREATE TABLE IF NOT EXISTS `teacher` (
  `teacherID` varchar(6) NOT NULL,
  `courseID` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `teacher` (`teacherID`, `courseID`) VALUES
('44444', 'IBIS001'),
('11111', 'IBIS002'),
('22222', 'IBIS003'),
('44444', 'IBIS004'),
('11111', 'IBIS005'),
('22222', 'IBIS006'),
('33333', 'IBIS007'),
('44444', 'IBIS008'),
('11111', 'IBIS009'),
('22222', 'IBIS010'),
('33333', 'IBIS011'),
('44444', 'IBIS012'),
('11111', 'IBIS013'),
('22222', 'IBIS014'),
('33333', 'IBIS015'),
('44444', 'IBIS016'),
('11111', 'IBIS017'),
('22222', 'IBIS018'),
('33333', 'IBIS019'),
('44444', 'IBIS020'),
('11111', 'IBIS021'),
('22222', 'IBIS022'),
('33333', 'IBIS023'),
('44444', 'IBIS024'),
('11111', 'IBIS025'),
('22222', 'IBIS026'),
('33333', 'IBIS027'),
('44444', 'IBIS028'),
('11111', 'IBIS029'),
('22222', 'IBIS030'),
('33333', 'IBIS031'),
('44444', 'IBIS032');


ALTER TABLE `course`
  ADD PRIMARY KEY (`courseID`);

ALTER TABLE `enrolledstudent`
  ADD PRIMARY KEY (`registrationID`,`studentID`,`courseID`);

ALTER TABLE `person`
  ADD PRIMARY KEY (`personID`),
  ADD KEY `personID` (`personID`);

ALTER TABLE `registration`
  ADD PRIMARY KEY (`registrationID`);

ALTER TABLE `room`
  ADD PRIMARY KEY (`room_number`);

ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `fk_student_person1_idx` (`studentID`);

ALTER TABLE `teacher`
  ADD PRIMARY KEY (`teacherID`,`courseID`),
  ADD KEY `courseID_FK_idx` (`courseID`);


ALTER TABLE `registration`
  MODIFY `registrationID` mediumint(6) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;

ALTER TABLE `student`
  ADD CONSTRAINT `fk_student_person1` FOREIGN KEY (`studentID`) REFERENCES `person` (`personID`) ON DELETE NO ACTION ON UPDATE NO ACTION;