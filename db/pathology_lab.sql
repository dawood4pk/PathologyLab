-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 19, 2015 at 11:03 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pathology_lab`
--

-- --------------------------------------------------------

--
-- Table structure for table `medical_test`
--

CREATE TABLE IF NOT EXISTS `medical_test` (
  `test_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `test_name` varchar(100) NOT NULL,
  PRIMARY KEY (`test_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `medical_test`
--

INSERT INTO `medical_test` (`test_id`, `test_name`) VALUES
(1, 'test 1'),
(2, 'test 2'),
(3, 'test 3'),
(4, 'test 4'),
(5, 'test 5'),
(6, 'test 6'),
(7, 'test 7'),
(8, 'test 8');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE IF NOT EXISTS `patients` (
  `patient_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `patient_username` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `patient_passcode` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `patient_firstname` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `patient_lastname` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=17 ;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `patient_username`, `patient_passcode`, `patient_firstname`, `patient_lastname`) VALUES
(1, 'dawood4pk', '123456', 'Dawood', 'Butt'),
(5, 'd', 'b', 'David', 'Butt'),
(6, 'a', 'b', 'A', 'Butt'),
(7, 'b', 'b', 'B', 'Butt'),
(8, 'c', 'b', 'C', 'Butt'),
(9, 'e', 'b', 'E', 'Butt'),
(10, 'f', 'b', 'F', 'Butt'),
(11, 'g', 'b', 'G', 'Butt'),
(12, 'e', 'b', 'E', 'Butt'),
(13, 'f', 'b', 'F', 'Butt'),
(16, 'h', 'b', 'H', 'Butt');

-- --------------------------------------------------------

--
-- Table structure for table `patient_report`
--

CREATE TABLE IF NOT EXISTS `patient_report` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `report_id` tinyint(4) NOT NULL,
  `test_id` tinyint(4) NOT NULL,
  `test_result` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `patient_report`
--

INSERT INTO `patient_report` (`id`, `report_id`, `test_id`, `test_result`) VALUES
(14, 2, 1, 'Normal'),
(15, 2, 2, 'OK'),
(58, 6, 1, 'Average'),
(59, 6, 2, 'OK'),
(68, 1, 1, 'Required some other tests as well');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `report_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `report_name` varchar(100) NOT NULL,
  `patient_id` tinyint(4) NOT NULL,
  PRIMARY KEY (`report_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`report_id`, `report_name`, `patient_id`) VALUES
(1, 'report 1', 6),
(2, 'report 2', 1),
(6, 'report 6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `password` varchar(100) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
