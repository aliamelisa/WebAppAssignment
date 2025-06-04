-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2025 at 05:01 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webapplication`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` varchar(255) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phoneNumber` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `fullName`, `password`, `phoneNumber`, `email`) VALUES
('10001', 'Zharfan Mirza Hafiy Ma', 'qwertyuiop', 197295420, '1211101006@student.mmu.edu.my'),
('10002', 'Muhammad Adam bin Mazli Zakuan', 'Chssat0', 197295420, '1211101073@student.mmu.edu.my'),
('10003', 'Maisarah Binti Radzi', 'qwerty123', 123456789, 'maisarahradzi@mmu.edu.my');

-- --------------------------------------------------------

--
-- Table structure for table `announcement`
--

CREATE TABLE `announcement` (
  `announcementID` int(100) NOT NULL,
  `title` text NOT NULL,
  `target` text NOT NULL,
  `announceBy` text NOT NULL,
  `content` text DEFAULT NULL,
  `datePosted` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcement`
--

INSERT INTO `announcement` (`announcementID`, `title`, `target`, `announceBy`, `content`, `datePosted`) VALUES
(1, 'Writing Literature Review Seminar', 'all', 'registrar', 'We are going to conduct a seminar on how to write literature review', '2025-02-02'),
(2, 'Reminder on Meeting Logs Submission', 'student', 'registrar', 'Please ensure to submit your meeting log to your respective supervisor', '2025-02-03');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackID` int(100) NOT NULL,
  `studentID` varchar(255) DEFAULT NULL,
  `supervisorID` varchar(255) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `rate` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackID`, `studentID`, `supervisorID`, `comments`, `rate`) VALUES
(1, '1211103123', NULL, 'Nice website', 3),
(2, NULL, '60001', 'Can optimize in meeting settings', 2),
(3, '1211103123', NULL, 'good job', 4);

-- --------------------------------------------------------

--
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `fileID` int(100) NOT NULL,
  `fileName` varchar(255) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`fileID`, `fileName`, `uploadDate`) VALUES
(1, 'FYP 1 Project Calendar 2430.pdf', '2025-02-02 06:19:18'),
(2, 'Template - Content.docx', '2025-02-02 06:20:09'),
(3, 'Template - Cover Page and Title Page.docx', '2025-02-02 06:20:19'),
(4, 'FYP Intro.pdf', '2025-02-02 06:20:35'),
(5, 'Pre-FYP Briefing T2430.pdf', '2025-02-02 06:20:41');

-- --------------------------------------------------------

--
-- Table structure for table `marksheet`
--

CREATE TABLE `marksheet` (
  `marksheetID` int(100) NOT NULL,
  `supervisorID` varchar(255) DEFAULT NULL,
  `studentID` varchar(255) DEFAULT NULL,
  `subjectCode` varchar(255) DEFAULT NULL,
  `grade` varchar(10) DEFAULT NULL,
  `projectProposal` int(100) NOT NULL,
  `presentation` int(100) NOT NULL,
  `report` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marksheet`
--

INSERT INTO `marksheet` (`marksheetID`, `supervisorID`, `studentID`, `subjectCode`, `grade`, `projectProposal`, `presentation`, `report`) VALUES
(1, '60001', '1211103123', 'FYP01', 'A', 12, 18, 50);

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `meetingID` int(100) NOT NULL,
  `supervisorID` varchar(255) DEFAULT NULL,
  `studentID` varchar(255) DEFAULT NULL,
  `meetingTitle` varchar(255) DEFAULT NULL,
  `meetingDate` date DEFAULT NULL,
  `meetingTime` time DEFAULT NULL,
  `meetingPlatform` varchar(255) DEFAULT NULL,
  `meetingDescription` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`meetingID`, `supervisorID`, `studentID`, `meetingTitle`, `meetingDate`, `meetingTime`, `meetingPlatform`, `meetingDescription`) VALUES
(1, '60001', '1211103123', 'FYP Briefing', '2025-02-04', '11:50:00', 'zoom', 'How to start FYP ');

-- --------------------------------------------------------

--
-- Table structure for table `meetinglog`
--

CREATE TABLE `meetinglog` (
  `meetingLogID` int(100) NOT NULL,
  `meetingID` int(100) DEFAULT NULL,
  `supervisorID` varchar(255) DEFAULT NULL,
  `studentID` varchar(255) DEFAULT NULL,
  `meetingLog` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meetinglog`
--

INSERT INTO `meetinglog` (`meetingLogID`, `meetingID`, `supervisorID`, `studentID`, `meetingLog`) VALUES
(1, 1, '60001', '1211103123', '1211103123 Meeting Log 1.pdf');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `projectID` varchar(255) NOT NULL,
  `supervisorID` varchar(255) DEFAULT NULL,
  `studentID` varchar(255) DEFAULT NULL,
  `progress` int(100) DEFAULT NULL,
  `milestone` text DEFAULT NULL,
  `completionStatus` varchar(255) DEFAULT NULL,
  `projectTitle` varchar(255) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project`
--

INSERT INTO `project` (`projectID`, `supervisorID`, `studentID`, `progress`, `milestone`, `completionStatus`, `projectTitle`, `comment`) VALUES
('1', '60001', '1211103123', 100, 'Update and finalized report', 'Completed', 'Predicting Weather using Machine Learning', 'Good job'),
('3', '60001', '1211134521', 0, 'Not Started', 'In Progress', 'Developing Software Application on Korban', NULL),
('4', '60001', NULL, 0, 'Not Started', 'In Progress', 'Develop Game', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `proposal`
--

CREATE TABLE `proposal` (
  `proposalID` int(100) NOT NULL,
  `supervisorID` varchar(255) DEFAULT NULL,
  `studentID` varchar(255) DEFAULT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `projectTitle` varchar(255) DEFAULT NULL,
  `projectType` varchar(255) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `proposalStatus` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `proposal`
--

INSERT INTO `proposal` (`proposalID`, `supervisorID`, `studentID`, `specialization`, `projectTitle`, `projectType`, `filename`, `proposalStatus`) VALUES
(1, '60001', '1211103123', 'data-science', 'Predicting Weather using Machine Learning', 'research-based', 'Predicting Weather using Machine Learning.pdf', 'Approved'),
(2, '60003', '1211423217', 'cybersecurity', 'Enhancing Security in website', 'application-based', 'Enhance Security of the Website.pdf', 'Rejected'),
(3, '60001', '1211134521', 'software-engineering', 'Developing Software Application on Korban', 'research and application based', 'Developing Software Application for Korban.pdf', 'Approved'),
(4, '60001', NULL, 'game-development', 'Develop Game', 'application-based', 'Developing Game using Sign language.pdf', 'Approved'),
(5, '60002', NULL, 'data-science', 'Dental Checker', 'research and application based', 'Dental Checker.pdf', 'pending'),
(6, '60003', '1211423217', 'data-science', 'Research on IOT Farming', 'research-based', 'Research on IOT Farming.pdf', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `studentID` varchar(255) NOT NULL,
  `supervisorID` varchar(255) DEFAULT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phoneNumber` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`studentID`, `supervisorID`, `fullName`, `password`, `phoneNumber`, `email`) VALUES
('1211103123', '60001', 'Ahmad Albab Bin Abu', 'qwerty123', 60112345633, '1211103123@student.mmu.edu.my'),
('1211134521', '60001', 'Suhanny Borhan', 'qwerty123', 60112345635, '1211134521@student.mmu.edu.my'),
('1211423217', '60003', 'Surenthiran A/L Sakhtesh', 'qwerty123', 60123467223, '1211423217@student.mmu.edu.my'),
('1213145789', NULL, 'Ahmad Daud Bin Razali', 'qwerty123', 60125621311, '1213145789@student.mmu.edu.my'),
('1231103489', '60002', 'Wong Chin Zila', 'qwerty123', 60113467822, '1231103489@student.mmu.edu.my');

-- --------------------------------------------------------

--
-- Table structure for table `supervisor`
--

CREATE TABLE `supervisor` (
  `supervisorID` varchar(255) NOT NULL,
  `fullName` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phoneNumber` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supervisor`
--

INSERT INTO `supervisor` (`supervisorID`, `fullName`, `password`, `phoneNumber`, `email`) VALUES
('60001', 'Dr. Lim Kok Wang', 'qwerty123', 6011344524, 'limkokwang@mmu.edu.my'),
('60002', 'Dr. Seri Hayati Binti Salam', 'qwerty123', 6012340953, 'serihayati@mmu.edu.my'),
('60003', 'Dr. Arumugam A/L Palanysamy', 'qwert123', 60112426822, 'arumugam@mmu.edu.my');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`announcementID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackID`),
  ADD KEY `studentID` (`studentID`),
  ADD KEY `supervisorID` (`supervisorID`);

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fileID`);

--
-- Indexes for table `marksheet`
--
ALTER TABLE `marksheet`
  ADD PRIMARY KEY (`marksheetID`),
  ADD KEY `supervisorID` (`supervisorID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`meetingID`),
  ADD KEY `supervisorID` (`supervisorID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `meetinglog`
--
ALTER TABLE `meetinglog`
  ADD PRIMARY KEY (`meetingLogID`),
  ADD KEY `meetingID` (`meetingID`),
  ADD KEY `supervisorID` (`supervisorID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`projectID`),
  ADD KEY `supervisorID` (`supervisorID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `proposal`
--
ALTER TABLE `proposal`
  ADD PRIMARY KEY (`proposalID`),
  ADD KEY `supervisorID` (`supervisorID`),
  ADD KEY `studentID` (`studentID`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`studentID`),
  ADD KEY `supervisorID` (`supervisorID`);

--
-- Indexes for table `supervisor`
--
ALTER TABLE `supervisor`
  ADD PRIMARY KEY (`supervisorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcement`
--
ALTER TABLE `announcement`
  MODIFY `announcementID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `fileID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `marksheet`
--
ALTER TABLE `marksheet`
  MODIFY `marksheetID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `meetingID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `meetinglog`
--
ALTER TABLE `meetinglog`
  MODIFY `meetingLogID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `proposal`
--
ALTER TABLE `proposal`
  MODIFY `proposalID` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`),
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`supervisorID`) REFERENCES `supervisor` (`supervisorID`);

--
-- Constraints for table `marksheet`
--
ALTER TABLE `marksheet`
  ADD CONSTRAINT `marksheet_ibfk_1` FOREIGN KEY (`supervisorID`) REFERENCES `supervisor` (`supervisorID`),
  ADD CONSTRAINT `marksheet_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);

--
-- Constraints for table `meeting`
--
ALTER TABLE `meeting`
  ADD CONSTRAINT `meeting_ibfk_1` FOREIGN KEY (`supervisorID`) REFERENCES `supervisor` (`supervisorID`),
  ADD CONSTRAINT `meeting_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);

--
-- Constraints for table `meetinglog`
--
ALTER TABLE `meetinglog`
  ADD CONSTRAINT `meetinglog_ibfk_2` FOREIGN KEY (`supervisorID`) REFERENCES `supervisor` (`supervisorID`),
  ADD CONSTRAINT `meetinglog_ibfk_3` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);

--
-- Constraints for table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`supervisorID`) REFERENCES `supervisor` (`supervisorID`),
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);

--
-- Constraints for table `proposal`
--
ALTER TABLE `proposal`
  ADD CONSTRAINT `proposal_ibfk_1` FOREIGN KEY (`supervisorID`) REFERENCES `supervisor` (`supervisorID`),
  ADD CONSTRAINT `proposal_ibfk_2` FOREIGN KEY (`studentID`) REFERENCES `student` (`studentID`);

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`supervisorID`) REFERENCES `supervisor` (`supervisorID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
