-- phpMyAdmin SQL Dump
-- version 3.5.3
-- http://www.phpmyadmin.net
--
-- Host: 158815c46665498920e34bcd3a830e12e8fb0484.rackspaceclouddb.com
-- Generation Time: Dec 19, 2012 at 11:30 AM
-- Server version: 5.1.63-0+squeeze1
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `campuslinc`
--

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE IF NOT EXISTS `billing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) NOT NULL,
  `attentionto` varchar(255) NOT NULL COMMENT 'Attention To',
  `billingcontact` varchar(255) NOT NULL,
  `billingaddress` varchar(255) NOT NULL,
  `billingaddress2` varchar(255) NOT NULL,
  `billingcity` varchar(255) NOT NULL,
  `billingstate` varchar(255) NOT NULL,
  `billingzip` varchar(255) NOT NULL,
  `billingemail` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=39 ;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `companyid`, `attentionto`, `billingcontact`, `billingaddress`, `billingaddress2`, `billingcity`, `billingstate`, `billingzip`, `billingemail`) VALUES
(1, 36, '', 'Julie Yates', '123 Main St', 'suite 202', 'Buffalo', 'NY', '1234', ''),
(2, 35, '', 'Mike the dyke', '444 Asper st', '', 'Amherst ', 'ny', '14322', 'leesalminen@gmail.com'),
(3, 35, '', 'Lisa Smith', '1234 Main St.', 'Suite 102', 'New York', 'NY', '10017', ''),
(9, 35, '', 'Nacy Billing', '', '', '', '', '444444', ''),
(16, 36, 'Billing', 'Lauren Smithson', '3375 Moorhead Ave', 'Suite 108', 'Boulder', 'CO', '80305', 'leesalminen@gmail.com'),
(18, 37, '', 'Brett Burnsworth', '', '', '', '', '1235', ''),
(19, 40, '', 'Greg Watkins', '123 Main st', '', 'Angola', 'NY', '14006', ''),
(20, 36, 'Billing Department', 'Matthew Christensen', '123 Apple St.', 'Suite 224', 'Buffalo', 'NY', '14228', ''),
(21, 36, 'Chris Hills', 'Chris Hills', '123 Apple Lane', '', 'Boulder', 'CO', '80305', ''),
(22, 0, 'HR', 'Christopher Hills', '8065 Baseline Rd', '', 'Boulder', 'CO', '80305', ''),
(23, 41, 'HR', 'Matt C', '3375 moorhead ave', '', 'boudler', 'co', '80305', ''),
(24, 46, 'Adam Ryan', 'Jerry rice', '12345 Main St.', '', 'Akron', 'NY', '14441', ''),
(25, 44, '"Ron Caal', 'Ken Cabam', '23456 Micheal Bolton Rd', '', 'Akron', 'NY', '99999', ''),
(26, 47, 'Chi  Baai', 'Blake Adams ', '3456 CC Rd', '', 'Akron', 'NY', '99998', 'leesalminen@gmail.com'),
(27, 39, 'Ray Jay', 'Chris Donke', '4567 Red St', '', 'Akron', 'PA', '99997', ''),
(28, 0, 'Jerry Batz', 'Nancy Telp', '5678 winter Rd', '', 'Akron', 'PA', '99997', ''),
(29, 49, 'Dan Rander', 'Steven Retel', '6789 Winter Blvd', '', 'Rede ', 'PA', '99997', ''),
(30, 43, 'Dave Glenn', 'Brad Demar', '6789 Tommit Rd', '', 'Clarence', 'NY', '99996', ''),
(31, 53, 'Frank Crisp', 'George Flee', '7891 Rail Rd', '', 'Buffalo', 'NY', '99994', ''),
(32, 52, 'Phil Mona ', 'Thomas Donre', '8894 Franklin Ave', '', 'Buffalo', 'NY', '14221', ''),
(33, 48, 'Steve Ellis', 'Steve Grel', '8910', '', 'Buffalo', 'NY', '14221', ''),
(34, 51, 'David Marks ', 'Katie Rords ', '9874 Grand Rd', '', 'Buffalo', 'NY', '10112', 'me@leesalminen.com'),
(35, 50, 'Thomas Lope', 'Larry Groper', '1003 Randel Rd', '', 'Buffalo', 'NY', '14221', ''),
(36, 45, 'Jeff Blaze', 'Brad Berneto', '1012 Medow Lake Rd', '', 'Buffalo ', 'NY', '10133', ''),
(37, 54, 'Jack Jones', 'Stephanie Jones', '1444 Dolphin St', '', 'Buffalo', 'NY', '14444', 'leesalminen@gmail.com'),
(38, 55, '', 'Robert Bennett', '2376 South Park Avenue', '', 'Buffalo', 'New York', '14220', '');

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(255) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `class_schedule`
--

CREATE TABLE IF NOT EXISTS `class_schedule` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classtitleid` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `duration` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL,
  `laptops` enum('No','Yes') NOT NULL DEFAULT 'No',
  `howmanylaptops` varchar(255) NOT NULL,
  `type` enum('Public','Private') NOT NULL DEFAULT 'Public',
  `cancelled` enum('No','Yes') NOT NULL DEFAULT 'No',
  `location` enum('Campus Linc','Customer Location') NOT NULL,
  `instructor` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `class_schedule`
--

INSERT INTO `class_schedule` (`id`, `classtitleid`, `startdate`, `enddate`, `duration`, `notes`, `laptops`, `howmanylaptops`, `type`, `cancelled`, `location`, `instructor`) VALUES
(5, 329, '2012-08-31', '2012-08-30', '1 dyy', '', 'No', '', 'Public', 'No', '', 'Julie Moolie'),
(4, 235, '2012-08-30', '2012-08-29', '1 day', '', 'No', '', 'Public', 'No', '', 'Rosa Harris'),
(6, 438, '2012-08-29', '2012-08-29', '', '', 'No', '', 'Public', 'No', '', 'Joe Smoe'),
(7, 331, '2012-09-10', '2012-09-10', '8 hour course', 'shaune is teaching this class', 'No', '5', 'Public', 'No', 'Campus Linc', 'Jason'),
(8, 210, '2012-09-30', '2012-09-30', '1 day', '', 'No', '', 'Public', 'No', '', ''),
(9, 312, '2012-09-26', '2012-09-26', '1 day', '', 'No', '', 'Public', 'No', '', ''),
(10, 438, '2012-11-07', '2012-11-07', '1', '', 'No', '', 'Public', 'No', '', 'Jenny jones'),
(11, 438, '2012-11-27', '2012-11-27', '4 hours', 'Cool Class', 'No', '', 'Public', 'No', 'Campus Linc', 'Shaune'),
(12, 438, '2012-12-10', '2012-12-10', '1 Day', 'Test Notes', 'No', '1', 'Public', 'No', 'Campus Linc', 'Lee'),
(13, 504, '2012-12-11', '2012-12-11', '4 Hours', 'Class Notes Here', 'No', '', 'Public', 'No', 'Campus Linc', '1'),
(14, 341, '2012-12-11', '2012-12-11', '3 Hours', 'Class Notes Here', 'No', '', 'Public', 'No', 'Campus Linc', 'Mark'),
(15, 382, '2012-12-10', '2012-12-10', '4 hours', 'good class on indesign', 'No', '', 'Public', 'No', 'Campus Linc', 'Mark Busch'),
(16, 304, '2012-12-28', '2012-12-29', '2 Days', 'Students will need handbook', 'Yes', '6', 'Public', 'No', 'Campus Linc', 'Mark Busch'),
(17, 13, '2012-12-30', '2012-12-30', '6 Hours', 'Excel needed', 'No', '', 'Public', 'No', 'Campus Linc', 'Mark Busch'),
(18, 444, '2012-12-25', '2012-12-26', '6 hours', 'class notes', 'No', '', 'Public', 'No', 'Campus Linc', 'Mark Busch'),
(19, 400, '2012-12-14', '2012-12-14', '6 Hours', '', 'No', '', 'Public', 'No', 'Campus Linc', 'Linda Marotta-Moore'),
(20, 493, '2012-12-14', '2012-12-14', '2', '', 'No', '', 'Public', 'No', 'Campus Linc', 'Linda Marotta-Moore'),
(21, 241, '2012-12-17', '2012-12-17', '8 Hours', '', 'Yes', '8', 'Public', 'No', 'Campus Linc', 'Linda Marotta-Moore'),
(22, 181, '2012-12-18', '2012-12-18', '3 Hours', '', 'No', '', 'Public', 'No', 'Campus Linc', 'Linda Marotta-Moore'),
(23, 32, '2012-12-17', '2012-12-17', '8 Hours', '', 'No', '', 'Public', 'No', 'Campus Linc', 'Linda Marotta-Moore'),
(24, 438, '2012-12-01', '2012-12-11', '3 day', 'zzzz', 'No', '0', 'Private', 'No', 'Customer Location', 'Linda Marotta-Moore'),
(25, 312, '2012-12-05', '2012-12-12', '1 Week ', 'Food for 5', 'No', '0', 'Private', 'No', 'Customer Location', 'Mark'),
(26, 560, '2012-12-31', '2012-12-31', '1', '', 'Yes', '12', 'Public', 'No', 'Campus Linc', 'Mark Busch');

-- --------------------------------------------------------

--
-- Table structure for table `class_titles`
--

CREATE TABLE IF NOT EXISTS `class_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classname` varchar(255) NOT NULL,
  `tuition` varchar(255) NOT NULL,
  `courseware` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `length` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=561 ;

--
-- Dumping data for table `class_titles`
--

INSERT INTO `class_titles` (`id`, `classname`, `tuition`, `courseware`, `total`, `length`) VALUES
(2, 'Microsoft Outlook 2003 Level 2', '175', '', 0, '1 day'),
(3, 'Microsoft Outlook 2003 Level 3', '175', '', 0, '1 day'),
(4, 'Crystal Reports XI Level 1', '485', '', 0, '2 days'),
(5, 'Crystal Reports XI Level 2', '485', '', 0, '2 days'),
(6, 'Microsoft Visio Professional 2003 Level 1', '175', '', 0, '1 day'),
(7, 'Microsoft Visio Professional 2003 Level 2', '175', '', 0, '1 day'),
(8, 'Microsoft Windows XP Introduction', '175', '', 0, '1 day'),
(9, 'Microsoft Project 2003 Level 1', '175', '', 0, '1 day'),
(10, 'Microsoft Project 2003 Level 2', '175', '', 0, '1 day'),
(11, 'Microsoft PowerPoint 2003 Level 1', '175', '', 0, '1 day'),
(12, 'Microsoft PowerPoint 2003 Level 2', '175', '', 0, '1 day'),
(13, 'Microsoft Excel 2003 Level 1', '175', '', 0, '1 day'),
(14, 'Microsoft Excel 2003 Level 2', '175', '', 0, '1 day'),
(15, 'Microsoft Excel 2003 Level 3', '175', '', 0, '1 day'),
(16, 'Microsoft Excel 2003 Introduction to VBA', '155', '', 0, '1 day'),
(17, 'HTML 4.01 Web Authoring Level 1', '295', '', 0, '1 day'),
(18, 'HTML 4.01 Web Authoring Level 2', '295', '', 0, '1 day'),
(19, 'HTML 4.01 Web Authoring Level 3', '295', '', 0, '1 day'),
(20, 'Microsoft Word 2003 Level 1', '175', '', 0, '1 day'),
(21, 'Microsoft Word 2003 Level 2', '175', '', 0, '1 day'),
(22, 'Microsoft Word 2003 Level 3', '175', '', 0, '1 day'),
(23, 'SQL Fundamentals of Querying', '395', '', 0, '1 day'),
(24, 'SQL Advanced Querying', '395', '', 0, '1 day'),
(25, 'M2433B: MS Visual Basic Scripting Edition & Microsoft Windows Script Host Essentials', '1255', '', 0, '3 days'),
(26, 'M2824: Implementing Microsoft Internet Security and Acceleration Server 2004', '2095', '', 0, '5 days'),
(27, 'M2124: Programming with C#', '2095', '', 0, '5 days'),
(28, 'M2373 Programming with Visual Basic .Net', '2095', '', 0, '5 days'),
(29, 'M2559: Introduction to Visual Basic .Net Programming', '2095', '', 0, '5 days'),
(30, 'M1303: Mastering Microsoft Visual Basic 6 Fundamentals', '2095', '', 0, '5 days'),
(31, 'CompTIA Network+ (2009 Objectives)', '1995', '', 0, '5 days'),
(32, 'CCNA: Certified Cisco Network Associate Bootcamp', '2895', '', 0, '5 days'),
(33, 'Certified Ethical Hacker', '2495', '', 0, '5 days'),
(34, 'Certified Information Systems Security Professional (CISSP)', '2495', '', 0, '5 days'),
(35, 'Microsoft PowerPoint 2007 New Features', '95', '', 0, '0.5 day'),
(36, 'M5058 Deploying Microsoft Office 2007 Professional Plus', '840', '', 0, '2 days'),
(37, 'CompTIA Server+ Certification', '1995', '', 0, '5 days'),
(38, 'Microsoft Access 2007 New Features', '95', '', 0, '0.5 day'),
(39, 'Microsoft Excel 2007 New Features', '95', '', 0, '.5 day'),
(40, 'Microsoft Word 2007 New Features', '95', '', 0, '0.5 day'),
(41, 'Microsoft Access 2003 Level 1&2', '350', '', 0, '2 days'),
(42, 'Microsoft Access 2003 Level 3', '175', '', 0, '1 day'),
(43, 'Microsoft Access 2003 Level 4', '175', '', 0, '1 day'),
(44, 'Microsoft Outlook 2007 Level 1', '175', '', 0, '1 day'),
(45, 'Microsoft Outlook 2007 Level 2', '175', '', 0, '1 day'),
(46, 'Microsoft Excel 2007 Level 1', '175', '', 0, '1 day'),
(47, 'Microsoft Excel 2007 Level 2', '175', '', 0, '1 day'),
(48, 'Microsoft Word 2007 Level 1', '175', '', 0, '1 day'),
(49, 'Microsoft Word 2007 Level 2', '175', '', 0, '1 day'),
(50, 'Microsoft PowerPoint 2007 Level 1', '175', '', 0, '1 day'),
(51, 'Microsoft PowerPoint 2007 Level 2', '175', '', 0, '1 day'),
(52, 'Microsoft Outlook 2003 Level 1', '175', '', 0, '1 day'),
(53, 'M2389 Programming with Microsoft ADO.NET', '1255', '', 0, '3 days'),
(54, 'M5060A Implementing Windows SharePoint Services 3.0', '840', '', 0, '2 days'),
(55, 'M5061 Implementing Microsoft Office SharePoint Server 2007', '1255', '', 0, '3 days'),
(56, 'JavaScript: Programming', '395', '', 0, '1 day'),
(57, 'JavaScript Programming Advanced', '790', '', 0, '2 days'),
(58, 'M2596 Managing Microsoft Systems Management Server 2003', '2095', '', 0, '5 days'),
(59, 'Microsoft InfoPath 2003 Creating InfoPath Forms', '295', '', 0, '2 days'),
(60, 'Microsoft Access 2007 Level 3', '175', '', 0, '1 day'),
(61, 'Microsoft Access 2007 Level 1&2', '350', '', 0, '2 days'),
(62, 'Microsoft Project 2003 Professional', '295', '', 0, '1 day'),
(63, 'Web Design Best Practices', '595', '', 0, '1 day'),
(64, 'M4994 Introduction to Programming Microsoft .NET Framework Applications with Microsoft Visual Studio 2005', '2095', '', 0, '5 days'),
(65, 'Cisco IP Telephony Part 1 (CIPT1) v4.1', '2495', '', 0, '5 days'),
(66, 'Microsoft Word 2007 Level 3', '175', '', 0, '1 day'),
(67, 'Microsoft Excel 2007 Level 3', '175', '', 0, '1 day'),
(68, 'Securing Cisco Network Devices (SND) v2.0', '2895', '', 0, '5 days'),
(69, 'M2544 Advanced Web Application Technologies with Microsoft Visual Studio 2005', '840', '', 0, '2 days'),
(70, 'M2547 Advanced Windows Forms Technologies with Microsoft Visual Studio 2005', '840', '', 0, '2 days'),
(71, 'M2543 Core Web Application Technologies with Microsoft Visual Studio 2005', '1255', '', 0, '3 days'),
(72, 'M2562 Getting Started with Microsoft Visual Studio 2005 for Microsoft Visual Basic 6.0 Developers', '840', '', 0, '2 days'),
(73, 'M4995 Programming with the Microsoft .NET Framework Using Microsoft Visual Studio 2005', '2095', '', 0, '5 Days'),
(74, 'M2957 Advanced Foundations of Microsoft .NET 2.0 Development', '1255', '', 0, '3 days'),
(75, 'M2500 Introduction to XML and the Microsoft .NET Platform', '840', '', 0, '2 days'),
(76, 'M2349 Programming with the Microsoft .NET Framework (Microsoft Visual C# .NET)', '2095', '', 0, '5 days'),
(77, 'M2415 Programming with the Microsoft .NET Framework (Microsoft Visual Basic .NET)', '2095', '', 0, '5 days'),
(78, 'M2524 Developing XML Web Services Using Microsoft ASP.NET', '1255', '', 0, '3 days'),
(79, 'M2369 Designing an Application Migration Strategy to Microsoft .NET', '840', '', 0, '2 days'),
(80, 'Microsoft Project 2007 Level 1', '175', '', 0, '1 day'),
(81, 'Microsoft Project 2007 Level 2', '175', '', 0, '1 day'),
(82, 'Project Management Professional (PMP) Certification Preparation - Evenings', '1995', '', 0, '16 nights'),
(83, 'M2541Core Data Access with Microsoft Visual Studio 2005', '1255', '', 0, '3 days'),
(84, 'M2542 Advanced Data Access with Microsoft Visual Studio 2005', '840', '', 0, '2 days'),
(85, 'M2546 Core Windows Forms Technologies with Microsoft Visual Studio 2005', '1255', '', 0, '3 days'),
(86, 'M2548 Core Distributed Application Development with Microsoft Visual Studio 2005', '1255', '', 0, '3 days'),
(87, 'M2549 Advanced Distributed Application Development with Microsoft Visual Studio 2005', '840', '', 0, '2 days'),
(88, 'M2555 Developing Microsoft .NET Applications for Windows (Visual C# .NET)', '2095', '', 0, '5 days'),
(89, 'M2565 Developing Microsoft .NET Applications for Windows (Visual Basic .NET)', '2095', '', 0, '5 days'),
(90, 'M2609 Introduction to C# Programming with Microsoft .NET', '2095', '', 0, '5 days'),
(91, 'M2311 Advanced Web Application Development using Microsoft ASP.NET', '1255', '', 0, '3 days'),
(92, 'M2667  Introduction to Programming', '1255', '', 0, '3 days'),
(93, 'M2810: Network Security Fundamentals', '1680', '', 0, '4 days'),
(94, 'Microsoft Access 2007 Level 4', '175', '', 0, '1 day'),
(95, 'Disaster Recovery & Business Continuity Planning Training', '2495', '', 0, '5 days'),
(96, 'Certified Penetration Testing Specialist', '2495', '', 0, '5 Days'),
(97, 'Building Scalable Cisco Internetworks (BSCI) v3.0', '2895', '', 0, '5 days'),
(98, 'M6416C Updating your Active Directory Technology Skills to Windows Server 2008', '2095', '', 0, '5 days'),
(99, 'M6417 Updating your Application Platform Technology Skills to Windows Server 2008', '1255', '', 0, '3 days'),
(100, 'Change Management for Managers', '395', '', 0, '1 day'),
(101, 'Communicating Across Cultures', '395', '', 0, '1/2 Day'),
(102, 'Successful Business Writing', '395', '', 0, '1 day'),
(103, 'Effective Time Management', '395', '', 0, '1 day'),
(104, 'Fundamentals of Selling', '395', '', 0, '1 day'),
(105, 'Managing Innovation and Creativity', '395', '', 0, '1/2 Day'),
(106, 'Performance Management', '395', '', 0, '1 day'),
(107, 'Appraising Performance', '395', '', 0, '1 day'),
(108, 'Finance Essentials', '295', '', 0, '1 day'),
(109, 'Fundamentals of Customer Service', '395', '', 0, '1 day'),
(110, 'Grammar Essentials', '395', '', 0, ''),
(111, 'Change Management for Employees', '395', '', 0, '1/2 Day'),
(112, 'Coaching Essentials', '395', '', 0, '1 day'),
(113, 'Effective Facilitation Skills', '395', '', 0, '1 day'),
(114, 'Emotional Intelligence for Managers', '395', '', 0, ''),
(115, 'Fundamentals of Communication', '395', '', 0, '1 day'),
(116, 'Managing Project Teams', '395', '', 0, '1 day'),
(117, 'Negotiating Skills', '395', '', 0, '1 day'),
(118, 'Motivating Your Employees', '395', '', 0, '.5 day'),
(119, 'Practical Leadership', '395', '', 0, '1 day'),
(120, 'Project Management Skills for Non-Project Managers', '195', '', 0, '.5 day'),
(121, 'Sexual Harassment Awareness for Supervisors', '395', '', 0, '.5 day'),
(122, 'Strategic Planning Skills', '395', '', 0, '1 day'),
(123, 'Microsoft Visio Professional 2007 Level 1', '175', '', 0, '1 day'),
(124, 'Microsoft Visio Professional 2007  Level 2', '175', '', 0, '1 day'),
(125, 'Symantec Ghost Solution Suite 2.0', '2995', '', 0, '4 days'),
(126, 'ITIL IT Service Management Essentials v3', '795', '', 0, '2 days'),
(127, 'M6418B Deploying Windows Server 2008', '1255', '', 0, '3 days'),
(128, 'M6429A Configuring and Managing Windows Media Services', '840', '', 0, '2 days'),
(129, 'M6425C Configuring Windows Server 2008 Active Directory Domain Services', '2095', '', 0, '5 days'),
(130, 'M6421B Configuring and Troubleshooting a Windows Sever 2008 Network Infrastructure', '2095', '', 0, '5 days'),
(131, 'Microsoft Access Intro to Application Development', '395', '', 0, '2 days'),
(132, 'Microsoft Outlook 2007 Level 3', '175', '', 0, '1 day'),
(133, 'Microsoft Publisher 2003', '175', '', 0, '1 Day'),
(134, 'Microsoft Publisher 2007', '175', '', 0, '1 Day'),
(135, 'Creating and Maintaining Life Balance', '395', '', 0, '1 Day'),
(136, 'What Good Managers Do: The First 100 Days', '395', '', 0, '1/2 Day'),
(137, 'Introduction to Data Modeling', '995', '', 0, '2 Days'),
(138, 'Advanced Communication Skills', '395', '', 0, '1/2 Day'),
(139, 'Microsoft Expression Web 2007 Level 2', '295', '', 0, '1 Day'),
(140, 'Microsoft SharePoint Designer 2007 Level 1', '445', '', 0, '1 Day'),
(141, 'M2439 Scripting Using Microsoft Windows Management Instrumentation', '840', '', 0, '2 Days'),
(142, 'M6428 Configuring and Troubleshooting Windows Server 2008 Terminal Services', '840', '', 0, '2 Days'),
(143, 'M6427A Configuring and Troubleshooting Internet Information Services in Windows Server 2008', '1255', '', 0, '3 Days'),
(144, 'Microsoft Expression Web 2007 Level 1', '295', '', 0, '1 Day'),
(145, 'Microsoft SharePoint Services 3.0', '1195', '', 0, '3 Days'),
(146, 'Microsoft Project 2007 Professional', '295', '', 0, '1 Day'),
(147, 'Microsoft Project 2007 Web Access', '295', '', 0, '1 Day'),
(148, 'Microsoft InfoPath 2007 Creating InfoPath Forms', '295', '', 0, '1 Day'),
(149, 'Problem Solving Skills', '395', '', 0, '1 Day'),
(150, 'Effective Management (E)', '395', '', 0, '1 Day'),
(151, 'Getting the Results Without the Authority', '395', '', 0, '1 Day'),
(152, 'Using Data to Communicate', '395', '', 0, '1 Day'),
(153, 'M5928 Microsoft Office Project Server 2007 ? Managing Projects', '1495', '', 0, '3 Days'),
(154, 'M5927 Microsoft Office Project 2007, Managing Projects', '1575', '', 0, '3 Days'),
(155, 'Design Concepts', '345', '', 0, '1 Day'),
(156, 'Essential Security Awareness For Everyone (Introduction)', '495', '', 0, '1 Day'),
(157, 'Social Engineering - The Human Factor', '495', '', 0, '1 Day'),
(158, 'Certified Penetration Testing Specialist ? Web Analysis', '2495', '', 0, '5 Days'),
(159, 'Wireless Administration & Security CWNA & CWSP', '2495', '', 0, '5 Days'),
(160, 'M2933 Developing Business Process and Integration Solutions Using Microsoft BizTalk Server 2006', '2095', '', 0, '5 Days'),
(161, 'M2934 Deploying and Managing Business Process and Integration Solutions Using Microsoft BizTalk Server 2006', '845', '', 0, '2 Days'),
(162, 'Microsoft SharePoint Services 3.0 Level 1', '895', '', 0, '2 Days'),
(163, 'Microsoft SharePoint Services 3.0 Level 2', '895', '', 0, '2 Days'),
(164, 'Microsoft Outlook 2007 New Features', '155', '', 0, '1 Day'),
(165, 'Crystal Reports 2008 Level 1', '485', '', 0, '2 Days'),
(166, 'Crystal Reports 2008 Level 2', '485', '', 0, '2 days'),
(167, 'M5179 Implementing and Maintaining Telephony Using Microsoft Office Communications Server 2007', '895', '', 0, '2 Days'),
(168, 'M5177 Implementing and Maintaining Instant Messaging Using Microsoft Office Communications Server', '450', '', 0, '1 Day'),
(169, 'M5178 Implementing and Maintaining Audio/Visual Conferencing and Web Conferencing Using Microsoft Office Communications Server 2007', '895', '', 0, '2 Days'),
(170, 'M50028 Managing System Center Operations Manager 2007', '2095', '', 0, '5 Days'),
(171, 'M6451 Planning, Deploying and Managing Microsoft System Center Configuration Manager 2007', '2095', '', 0, '5 Days'),
(172, 'M6423 Implementing and Managing Windows Server 2008 Clustering', '1255', '', 0, '3 Days'),
(173, 'Adobe Flash CS3 ActionScript 3', '1485', '', 0, '3 Days'),
(174, 'M6460A Visual Studio 2008: Windows Presentation Foundation', '1575', '', 0, '3 Days'),
(175, 'M6461 Visual Studio 2008: Windows Communication Foundation', '1495', '', 0, '3 Days'),
(176, 'M6462 Visual Studio 2008: Windows Workflow Foundation', '1050', '', 0, '2 Days'),
(177, 'M6464 Visual Studio 2008: ADO.NET 3.5', '1050', '', 0, '2 Days'),
(178, 'Securing Networks With Cisco Routers and Switches (SNRS)', '2975', '', 0, '5 Days'),
(179, 'Microsoft Office 2007 New Features', '175', '', 0, '1 Day'),
(180, 'Web Design with XHTML, HTML, and CSS Level 1', '395', '', 0, '1 Day'),
(181, 'Excellence in Technical Customer Service', '395', '', 0, '1 Day'),
(182, 'You know to create simple FrameMaker documents and export them to XML, HTML, and PDF formats. Now, you may need to use Adobe FrameMaker to build a boo', '295', '', 0, '1 Day'),
(183, 'Web Design with XHTML, HTML, and CSS Level 2', '395', '', 0, '1 Day'),
(184, 'Web Design with XHTML, HTML, and CSS Level 3', '395', '', 0, '1 Day'),
(185, 'M6422A Implementing and Managing Windows Server 2008 Hyper-V', '1995', '', 0, '3 Days'),
(186, 'M2778 Writing Queries Using Microsoft SQL Server 2008 Transact-SQL', '1255', '', 0, '3 Days'),
(187, 'M6158 Updating Your SQL Server 2005 Skills to SQL Server 2008', '1255', '', 0, '3 Days'),
(188, 'M6231B Maintaining a Microsoft SQL Server 2008 Database', '2095', '', 0, '5 Days'),
(189, 'M6232B Implementing a Microsoft SQL Server 2008 R2 Database', '2095', '', 0, '5 Days'),
(190, 'M6234 Implementing and Maintaining Microsoft SQL Server 2008 Analysis Services', '1255', '', 0, '3 Days'),
(191, 'M6235 Implementing and Maintaining SQL Server 2008 Integration Services', '1255', '', 0, '3 Days'),
(192, 'M6236 Implementing and Maintaining Microsoft SQL Server 2008 Reporting Services', '1255', '', 0, '3 Days'),
(193, 'M2310D Developing Web Applications Using Microsoft Visual Studio 2008 SP1', '2095', '', 0, '5 Days'),
(194, 'M2956 Core Foundations of Microsoft .NET 2.0 Development', '1255', '', 0, '3 Days'),
(195, 'M7197 Managing Enterprise Desktops Using Microsoft Desktop Optimization Pack', '2095', '', 0, '5 Days'),
(196, 'M6431 Managing and Maintaining Windows Server 2008 Infrastructure Servers', '1255', '', 0, '3 Days'),
(197, 'M6437 Designing a Windows Server 2008 Applications Infrastructure', '1255', '', 0, '3 Days'),
(198, 'CTT+', '795', '', 0, '2 Days'),
(199, 'Securing Networks with PIX and ASA (SNPA)', '2995', '', 0, '5 Days'),
(200, 'M6463 ASP.NET 3.5', '1050', '', 0, '2 Days'),
(201, 'M6426C Configuring and Troubleshooting Identity and Access Solutions with Windows Server 2008 Active Directory', '1575', '', 0, '3 Days'),
(202, 'Effective Presentations', '395', '', 0, '1 Day'),
(203, 'Managing Organizational Goals', '395', '', 0, '1 Day'),
(204, 'M6435 Designing a Windows Server 2008 Network Infrastructure', '2095', '', 0, '5 Days'),
(205, 'Security Awareness', '395', '', 0, '1 Day'),
(206, 'Interconnecting Cisco Networking Devices Part 1 (ICND1) v1.0', '2495', '', 0, '5 Days'),
(207, 'Interconnecting Cisco Networking Devices Part 2 (ICND2) v1.0', '2495', '', 0, '5 Days'),
(208, 'M2830 Designing Security for Microsoft Networks', '1255', '', 0, '3 Days'),
(209, 'M6434 Automating Windows Server 2008 Administration with Windows PowerShell', '1295', '', 0, '3 Days'),
(210, 'Adobe Acrobat 9.0 Pro: Level 1', '295', '', 0, '1 Day'),
(211, 'Adobe Acrobat 9.0 Pro: Level 2', '295', '', 0, '1 Day'),
(212, 'M6215 Implementing and Administering Microsoft Visual Studio 2008 Team Foundation Server', '840', '', 0, '2 Days'),
(213, 'M6214 Effective Team Development Using Microsoft Visual Studio Team System', '1255', '', 0, '3 Days'),
(214, 'Symantec Endpoint Protection Administration 11.0', '2995', '', 0, '5 Days'),
(215, 'M6436 Designing a Windows Server 2008 Active Directory Infrastructure and Services', '2095', '', 0, '5 days'),
(216, 'Project Management Fundamentals', '295', '', 0, '1 Day'),
(217, 'Microsoft SharePoint 2007 for Developers', '2095', '', 0, '5 Days'),
(218, 'Microsoft SharePoint Designer 2007 Level 2', '445', '', 0, '1 Day'),
(219, 'M50064A Advanced SharePoint 2007 Development', '2095', '', 0, '5 Days'),
(220, 'M50146A Programming Microsoft Office SharePoint Server - MOSS', '2095', '', 0, '5 Days'),
(221, 'M50141A Microsoft Office PerformancePoint Server 2007 Technical Training', '1675', '', 0, '4 Days'),
(222, 'Oracle Database 11g: SQL Fundamentals', '2495', '', 0, '5 Days'),
(223, 'Oracle Database 11g: PL/SQL Fundamentals', '2495', '', 0, '5 Days'),
(224, 'Oracle Database 11g: New & Advanced Features for Developers', '2495', '', 0, ''),
(225, 'Oracle Database 11g: Administration I', '2495', '', 0, '5 Days'),
(226, 'Oracle Database 11g: Administration II', '2495', '', 0, '5 Days'),
(227, 'Oracle Database 11g: Data Warehousing & Oracle Warehouse Builder', '2495', '', 0, '5 Days'),
(228, 'Oracle Database 11g: Backup & Recovery', '2495', '', 0, '5 Days'),
(229, 'Oracle Database 11g New Features for Administrators', '2495', '', 0, '5 Days'),
(230, 'Relational Database Design', '295', '', 0, '1 Day'),
(231, 'C Programming: An Introduction', '2195', '', 0, '5 Days'),
(232, 'M6064A Implementing and Managing a Windows Mobile Infrastructure', '1255', '', 0, '5 Days'),
(233, 'M50149 SharePoint 2007 Operations', '2095', '', 0, '5 Days'),
(234, 'M6438 Implementing and Administering Windows SharePoint Services 3.0 in Windows Server 2008', '1255', '', 0, '2 Days'),
(235, 'Adobe Dreamweaver CS4 Level 1', '295', '', 0, '1 Day'),
(236, 'M50068 Microsoft SQL Server 2008 for the Experienced Oracle Database Administrator', '1775', '', 0, '4 Days'),
(237, 'M6419B Configuring, Managing and Maintaining Windows Server 2008 Servers', '2095', '', 0, '5 days'),
(238, 'M6317 Upgrading Your SQL Server 2000 Database Administration (DBA) Skills to SQL Server 2008 DBA Skills', '1255', '', 0, '3 days'),
(239, 'Adobe InDesign CS4 Level 1', '295', '', 0, '1 day'),
(240, 'Adobe Illustrator CS4 Level 1', '295', '', 0, '1 Day'),
(241, 'Adobe Photoshop CS4 Level 1', '295', '', 0, '1 Day'),
(242, 'UNIX and Linux: Fundamentals', '895', '', 0, '2 Days'),
(243, 'UNIX and Linux: Advanced User', '895', '', 0, '2 Days'),
(244, 'Fundamentals of UNIX Administration', '2245', '', 0, '5 Days'),
(245, 'XML: XSL Transformations - Level 1 (Second Edition)', '895', '', 0, '2 Days'),
(246, 'XML: XSL Transformations - Level 2 (Second Edition)', '495', '', 0, '1 Day'),
(247, 'XML: An Introduction (Fourth Edition)', '495', '', 0, '1 Day'),
(248, 'Advanced Business Writing', '395', '', 0, '1 Day'),
(249, 'Writing for a Global Audience', '395', '', 0, 'Half Day'),
(250, 'QuarkXPress 7: Level 1', '295', '', 0, '1 Day'),
(251, 'QuarkXPress 7: Level 2', '295', '', 0, '1 Day'),
(252, 'Microsoft Excel Introduction to VBA', '195', '', 0, '1 day'),
(253, 'Designing for Cisco Internetwork Solutions (DESGN) v2.1', '2895', '', 0, '5 Days'),
(254, 'Adobe Dreamweaver CS4 Level 2', '295', '', 0, '1 Day'),
(255, 'Adobe Illustrator CS4 Level 2', '295', '', 0, '1 Day'),
(256, 'Adobe Photoshop CS4 Level 2', '295', '', 0, '1 Day'),
(257, 'Project Portfolio Management', '395', '', 0, '1 Day'),
(258, 'Marketing Essentials', '395', '', 0, '1 Day'),
(259, 'Introduction to Perl/CGI', '895', '', 0, '2 Days'),
(260, 'Fundamentals of Database Using Oracle', '345', '', 0, '1 Day'),
(261, 'Sexual Harassment Awareness for Employees', '395', '', 0, '5 Days'),
(262, 'Xcelsius 2008: Essentials', '295', '', 0, '1 Day'),
(263, 'Developing Web Applications Using Microsoft Silverlight 2.0', '1495', '', 0, '3 Days'),
(264, 'RPG IV Programming: Not Your Father''s RPG (course 1)', '990', '', 0, '2 Days'),
(265, 'RPG IV Programming: Integrating RPG IV and SQL (course 3)', '495', '', 0, '1 Day'),
(266, 'RPG IV Programming: Procedures & ILE Programming (course 2)', '495', '', 0, '1 Day'),
(267, 'RPG IV Programming: Triggers & API''s (course 4)', '495', '', 0, '1 Day'),
(268, 'RPG IV Programming: Externalizing Modifications (course 5)', '495', '', 0, '1 Day'),
(269, 'RPG IV Programming: Extending to the Web (course 6)', '495', '', 0, '1 Day'),
(270, 'RPG IV Programming: Advanced SQL & RPG (course 7)', '990', '', 0, '2 Days'),
(271, 'Adobe Flash CS4 Level 1', '490', '', 0, '2 days'),
(272, 'Adobe Flash CS4 Level 2', '490', '', 0, '2 days'),
(273, 'Adobe InDesign CS4 Level 2', '295', '', 0, '1 day'),
(274, 'RPG IV Programming: Introduction to RPG for non-RPG Programmers (course 0)', '295', '', 0, '.5 day'),
(275, 'Rational Developer for i Introduction, a Primer (course 8)', '295', '', 0, 'half day'),
(276, 'Oracle Database 11g: Advanced PL/SQL Programming & Tuning (5 Days)', '2495', '', 0, '5 Days'),
(277, 'Microsoft Project 2003: Web Access', '295', '', 0, '1 Day'),
(278, 'Just Enough Project Management', '795', '', 0, '2 Days'),
(279, 'Diversity in the Workplace', '395', '', 0, '1 Day'),
(280, 'Introduction to Agile Project Management', '395', '', 0, '1 Day'),
(281, 'M6288 Deploying Windows 7 Beta Business Desktops by Using the Microsoft Deployment Toolkit 2010 Beta', '1255', '', 0, '3 Days'),
(282, 'M6292A Installing and Configuring Windows 7 Client', '1255', '', 0, '3 Days'),
(283, 'Search Engine Optimization (SEO) Made Easy', '495', '', 0, '8 hours'),
(284, 'Adobe Photoshop Elements 6.0', '295', '', 0, '1 Day'),
(285, 'Understanding the Microsoft Solutions Framework', '895', '', 0, '2 Day'),
(286, 'Organizational Skills', '395', '', 0, '1 Day'),
(287, 'M10135A  Configuring, Managing and Troubleshooting Microsoft Exchange Server 2010', '2095', '', 0, '5 Days'),
(288, 'M6294A Planning and Managing Windows 7 Desktop Deployments and Environments', '2095', '', 0, '5 Days'),
(289, 'M50219A Introduction to Windows 7 for Developers', '420', '', 0, '1 Day'),
(290, 'M50218 Windows 7 Training for Developers', '1995', '', 0, '4 Days'),
(291, 'Adobe Captivate 4', '495', '', 0, '1 Day'),
(292, 'Microsoft Access 2007 Intro to Application Development', '370', '', 0, '2 Day'),
(293, 'Adobe Fireworks CS4', '990', '', 0, '2 Day'),
(294, 'Microsoft Windows 7 Level 1', '175', '', 0, '1 Day'),
(295, 'Microsoft Windows 7 Level 2', '175', '', 0, '1 Day'),
(296, 'M50261A Office SharePoint Server 2007: Power End Users', '1695', '', 0, '4 Days'),
(297, 'ECSA/LPT Certification Bootcamp', '2495', '', 0, '5 Days'),
(298, 'M50229A: Understanding the Microsoft Solutions Framework', '995', '', 0, '2 Day'),
(299, 'CompTIA  Project+ Certification (2009 Objectives)', '2295', '', 0, '5 Days'),
(300, 'Introduction to Personal Computers Using Windows 7', '155', '', 0, '1 Day'),
(301, 'Linux Fundamentals', '2295', '', 0, '5 Days'),
(302, 'Linux Administration I (Local Administration)', '2295', '', 0, '5 Days'),
(303, 'Linux Administration II (Network Administration)', '2295', '', 0, '5 Days'),
(304, 'CompTIA A+ Certification Part 1 (2009 Objectives)', '1995', '', 0, '5 Days'),
(305, 'SNAF Securing Networks with ASA Fundamentals v1', '2895', '', 0, '5 Days'),
(306, 'Microsoft Excel 2003 for Power Users', '155', '', 0, '1 Day'),
(307, 'Microsoft Excel 2007 for Power Users', '175', '', 0, '1 Day'),
(308, 'Cisco Voice over IP (CVOICE v6.0)', '2895', '', 0, '5 Days'),
(309, 'Adobe RoboHelp 8 Level 1', '295', '', 0, '1 Day'),
(310, 'Adobe FrameMaker 9.0 Level 2', '490', '', 0, '2'),
(311, 'Adobe FrameMaker 9.0 Level 1', '295', '', 0, '1'),
(312, 'Adobe ActionScript 3.0', '295', '', 0, '1'),
(313, 'M6445A: Implementing and Administering Windows Small Business Server 2008', '2095', '', 0, '5'),
(314, 'M50162A:  Exchange Administrators Guide to Scripting using the Exchange Management Shell (EMS)', '425', '', 0, '1'),
(315, 'QuarkXPress 8: Level 1', '295', '', 0, '1'),
(316, 'Microsoft Excel 2010 Transition from Excel 2003', '115', '', 0, '4 hours'),
(317, 'Adobe After Effects CS4', '990', '', 0, '2'),
(318, 'CompTIA A+ Certification Part 2 (2009 Objectives)', '1995', '', 0, '5 days'),
(319, 'Microsoft Word 2010 Transition from Word 2003', '115', '', 0, '4 hours'),
(320, 'M50331C: Windows 7, Enterprise Desktop Support Technician', '2095', '', 0, '5 Days'),
(321, 'Adobe Photoshop CS4 Photo Printing and Color', '295', '', 0, '1 Day'),
(322, 'Adobe Photoshop CS4 Web Production', '295', '', 0, '1 Day'),
(323, 'M50351A: SharePoint 2010 Overview for Developers', '840', '', 0, '2 Days'),
(324, 'M50352A: SharePoint 2010 Overview for End Users', '1255', '', 0, '3 Days'),
(325, 'M50353A: SharePoint 2010 Overview for IT Professionals', '1255', '', 0, '3 Days'),
(326, 'M50354A: SharePoint 2010 SharePoint Designer', '840', '', 0, '2 Days'),
(327, 'Implementing Citrix XenApp 5.0 for Windows Server 2008', '2895', '', 0, '5 days'),
(328, 'Cisco Implementing Cisco IOS Unified Communications (IIUC)', '2895', '', 0, '5 Days'),
(329, 'Adobe Dreamweaver CS5 Level 1', '295', '', 0, '1 day'),
(330, 'Adobe Illustrator CS5 Level 1', '295', '', 0, '1 day'),
(331, 'Adobe Photoshop CS5 Level 1', '295', '', 0, '1 day'),
(332, 'Adobe Flash CS5 Level 1', '595', '', 0, '2 days'),
(333, 'Microsoft PowerPoint 2010 Transition from PowerPoint 2003', '115', '', 0, '4 hours'),
(334, 'M50322B Configuring and Administering Windows 7', '2095', '', 0, '5'),
(335, 'CompTIA Strata Green IT', '495', '', 0, '1'),
(336, 'M10174B Configuring and Managing Microsoft SharePoint 2010', '2095', '', 0, '5 days'),
(337, 'M6368A Programming with the Microsoft .NET Framework Using Microsoft Visual Studio 2008', '2095', '', 0, '5 days'),
(338, 'Effectively Managing Technical Teams', '395', '', 0, '1 day'),
(339, 'Project Management for Technical Teams', '225', '', 0, '.5 days'),
(340, 'M6430B Planning for Windows Server 2008 Servers', '1675', '', 0, '4 days'),
(341, 'Adobe CS5 New Features', '295', '', 0, '1 day'),
(342, 'Microsoft Office 2010 Transition from Office 2003', '175', '', 0, '1 day'),
(343, 'Microsoft Excel 2010 Level 1', '175', '', 0, '1 day'),
(344, 'Microsoft Outlook 2010 Transition from Outlook 2003', '115', '', 0, '4 hours'),
(345, 'Microsoft Access 2010 Level 1&2', '350', '', 0, '2 Days'),
(346, 'Microsoft Outlook 2010 Level 1', '175', '', 0, '1 day'),
(347, 'Introduction to Software Testing', '395', '', 0, '1 day'),
(348, 'Microsoft PowerPoint 2010 Level 1', '175', '', 0, '1 day'),
(349, 'Certified Software Tester (CSTE)', '1695', '', 0, '4 days'),
(350, 'Introduction to Six Sigma', '395', '', 0, '1 day'),
(351, 'Project Managing Outsourced Resources', '395', '', 0, '1 day'),
(352, 'Introduction to Telecommunications', '495', '', 0, '1 day'),
(353, 'Fundamentals of Voice Over IP', '995', '', 0, '2 days'),
(354, 'Telephony: Voice Over IP', '1995', '', 0, '4 days'),
(355, 'Microsoft SharePoint Foundation 2010 Level 1', '845', '', 0, '2 days'),
(356, 'Microsoft SharePoint Foundation 2010 Level 2', '845', '', 0, '2 days'),
(357, 'M10325A Automating Administration with Windows PowerShell 2.0', '2095', '', 0, '5 days'),
(358, 'M10324A  Implementing and Managing Microsoft Desktop Virtualization', '2095', '', 0, '5 days'),
(359, 'Microsoft OneNote 2007', '155', '', 0, '1 day'),
(360, 'M10215A Implementing and Managing Microsoft Server Virtualization', '2095', '', 0, '5 days'),
(361, 'M50357A Implementing Forefront Threat Management Gateway 2010', '845', '', 0, '2 days'),
(362, 'Adobe Illustrator CS5 Level 2', '295', '', 0, '1 day'),
(363, 'Certified Information Systems Auditor (CISA) Certification', '2495', '', 0, '5 days'),
(364, 'Harnessing Innovation Within Teams', '395', '', 0, '1 day'),
(365, 'Hiring Top Performers', '395', '', 0, '1 day'),
(366, 'Winning with People at Work', '395', '', 0, '1 day'),
(367, 'Performance Under Pressure', '395', '', 0, '1 day'),
(368, 'M10175A Microsoft SharePoint 2010, Application Development', '2095', '', 0, '5 days'),
(369, 'M10266A Programming in C# with Microsoft Visual Studio 2010', '2095', '', 0, '5 days'),
(370, 'M10263A Developing Windows Communication Foundation Solutions with Microsoft Visual Studio 2010', '1255', '', 0, '3 days'),
(371, 'Microsoft Excel 2007 Level 4', '175', '', 0, '1 Day'),
(372, 'Upgrade from Windows Server 2003 to Windows Server 2008 Boot Camp', '3345', '', 0, '5 days'),
(373, 'M10267A Introduction to Web Development with Microsoft Visual Studio 2010', '2095', '', 0, '5 days'),
(374, 'M10264A Developing Web Applications with Microsoft Visual Studio 2010', '2095', '', 0, '5 days'),
(375, 'M10265A Developing Data Access Solutions with Microsoft Visual Studio 2010', '2095', '', 0, '5 days'),
(376, 'Microsoft Word 2010 Level 1', '175', '', 0, '1 day'),
(377, 'Microsoft Word 2010 Level 2', '175', '', 0, '1 day'),
(378, 'M50273A Planning and Designing Microsoft Virtualization Solutions', '2095', '', 0, '5 days'),
(379, 'Program Management Professional (PgMP)SM Credential', '2295', '', 0, '5 days'),
(380, 'PMI Scheduling Professional (PMI-SP) Certification', '1295', '', 0, '3 days'),
(381, 'PMI Risk Management Professional (PMI-RMP) Certification', '1795', '', 0, '4 Days'),
(382, 'Adobe InDesign CS5 Level 1', '295', '', 0, '1 day'),
(383, 'Adobe Photoshop CS5 Level 2', '295', '', 0, '1 day'),
(384, 'Microsoft Project 2010 Level 1', '175', '', 0, '1 day'),
(385, 'M10233A Designing and Deploying Messaging Solutions with Microsoft Exchange Server 2010', '2095', '', 0, '5 Days'),
(386, 'M10508A Planning, Deploying, and Managing Microsoft Exchange Server 2010 Unified Messaging', '1255', '', 0, '3 days'),
(387, 'M50360A Implementing Forefront Protection 2010 for Exchange and SharePoint', '845', '', 0, '2 Days'),
(388, 'Create Legal Forms Using Microsoft Office Word 2007', '95', '', 0, '0.5 Day'),
(389, 'Microsoft Excel 2010 Level 2', '175', '', 0, '1 Day'),
(390, 'Microsoft Project 2010 Level 2', '175', '', 0, '1 Day'),
(391, 'Microsoft Excel 2010 Level 3', '175', '', 0, '1 Day'),
(392, 'Microsoft PowerPoint 2010 Level 2', '175', '', 0, '1 Day'),
(393, 'Microsoft Access 2010 Level 3', '175', '', 0, '1 Day'),
(394, 'Microsoft Outlook 2010 Level 2', '175', '', 0, '1 Day'),
(395, 'Microsoft Word 2010 Level 3', '175', '', 0, '1 Day'),
(396, 'Microsoft Access 2010 Level 4', '175', '', 0, '1 Day'),
(397, 'Microsoft Excel 2010 Level 4', '175', '', 0, '1 Day'),
(398, 'Customer Service Via Phone and Email', '395', '', 0, '1 Day'),
(399, 'Microsoft Windows 7 Transition from Windows XP', '95', '', 0, '1/2 day'),
(400, 'Adobe InDesign CS5 Level 2', '295', '', 0, '1 Day'),
(401, 'Adobe Dreamweaver CS5 Level 2', '295', '', 0, '1 Day'),
(402, 'Adobe Flash CS5 Level 2', '595', '', 0, '2 days'),
(403, 'Introduction to Lean Six Sigma', '795', '', 0, '2 days'),
(404, 'Microsoft SharePoint 2010 Introduction', '155', '', 0, '1 Day'),
(405, 'Microsoft Access 2010 Transition from Access 2003', '115', '', 0, '4 hours'),
(406, 'Project Management Professional (PMP) Certification Preparation - Days', '1995', '', 0, '5 Days'),
(407, 'Managing Conflict', '395', '', 0, '1 Day'),
(408, 'Managing Information Effectively', '395', '', 0, '1 Day'),
(409, 'Deploying Cisco ASA Firewall Features (FIREWALL)', '2895', '', 0, '5 Days'),
(410, 'Microsoft Outlook 2010 Level 3', '175', '', 0, '1 Day'),
(411, 'Adobe Photoshop CS5 Web Production', '295', '', 0, '1 Day'),
(412, 'M10231B Designing a Microsoft SharePoint 2010 Infrastructure', '2095', '', 0, '5 days'),
(413, 'Adobe Dreamweaver CS5: Level 3', '295', '', 0, ''),
(414, 'Adobe Flash CS5 Level 3', '395', '', 0, '1.0 days'),
(415, 'Dealing with Challenging Customer Interactions', '395', '', 0, ''),
(416, 'Get Going with Quickbooks 2011', '245', '', 0, '1 Day'),
(417, 'Red Hat System Administration 1', '2495', '', 0, '5 Days'),
(418, 'Red Hat System Administration II', '2495', '', 0, '5 Days'),
(419, 'Red Hat System Administration III', '2495', '', 0, '5 Days'),
(420, 'Leadership Skills', '395', '', 0, '0.5 Days'),
(421, 'M10159A Updating Your Windows Server 2008 Technology Specialist Skills to Windows Server 2008 R2', '1255', '', 0, '3 Days'),
(422, 'M10262A Developing Windows Applications with Microsoft Visual Studio 2010', '2095', '', 0, '5 Days'),
(423, 'M10232A Designing and Developing Microsoft SharePoint 2010 Applications', '2095', '', 0, '5 Days'),
(424, 'M50255B: Managing Windows Environments with Group Policy', '1675', '', 0, '4 Days'),
(425, 'Adobe Flash CS5: Level 3', '395', '', 0, '1 Day'),
(426, 'Fast Track to ColdFusion 9', '1495', '', 0, '3 Days'),
(427, 'M6331A Deploying and Managing Microsoft System Center Virtual Machine Manager', '1255', '', 0, '3 Days'),
(428, 'M6446A: Implementing and Administering Windows Essential Business Server 2008', '2095', '', 0, '5 Days'),
(429, 'M6432A: Managing and Maintaining Windows Server 2008 Active Directory Servers', '840', '', 0, '2 Days'),
(430, 'M50469A Sharepoint 2010 End User Level 2', '840', '', 0, '2 days'),
(431, 'M50470A Microsoft SharePoint 2010 for the Site Owner/Power User', '840', '', 0, '2 Days'),
(432, 'M50400A Designing, Optimizing, and Maintaining a Database Administrative Solution for Microsoft SQL Server 2008', '2095', '', 0, '5 Days'),
(433, 'M50217A Planning Deploying Managing Microsoft System Center Service Manager 2010', '1675', '', 0, '4 Days'),
(434, 'Microsoft Visio 2010 Level 1', '175', '', 0, '1 Day'),
(435, 'Microsoft Visio 2010 Level 2', '175', '', 0, '1 Day'),
(436, 'Introducing Cisco Voice and Unified Communications Administration (ICOMM)', '2895', '', 0, '5 days'),
(437, 'Microsoft Excel 2010 Pivot Tables', '115', '', 0, '0.5 Days'),
(438, 'Adobe Acrobat  X Pro', '295', '', 0, '1 Day'),
(439, 'M6293A Troubleshooting and Supporting Windows 7 in the Enterprise', '1255', '', 0, '3 Days'),
(440, 'M50468A SharePoint 2010 End User Level 1', '1255', '', 0, '3 Days'),
(441, 'M10534A: Planning and Designing a Microsoft Lync Server 2010 Solution', '2095', '', 0, '5 Days'),
(442, 'M10550A: Programming in Visual Basic with Microsoft Visual Studio 2010', '2095', '', 0, '5 Days'),
(443, 'Developing and Presenting Successful Training for Non-Training Professionals', '395', '', 0, '1 day'),
(444, 'Adobe Captivate 5', '495', '', 0, '1 day'),
(445, 'Microsoft Publisher 2010', '175', '', 0, '1 day'),
(446, 'CompTIA Security+ (2011 Objectives)', '1995', '', 0, '5 Days'),
(447, 'Fundamentals of Data Warehousing', '295', '', 0, '0.5 Days'),
(448, 'Excellence in Customer Relations', '395', '', 0, '1 Day'),
(449, 'M50466B: Windows Azure Solutions with Microsoft Visual Studio 2010', '1495', '', 0, '3 Days'),
(450, 'IPv6 for Enterprise Networks', '2695', '', 0, '5 Days'),
(451, 'M10533A Deploying, Configuring, and Administering Microsoft Lync Server 2010', '2095', '', 0, '5 Days'),
(452, 'M10165A Updating Your Skills from Microsoft Exchange Server 2003 or Exchange Server 2007 to Exchange Server 2010 SP1', '2095', '', 0, '5 days'),
(453, 'M6420B Fundamentals of Windows Server 2008', '2095', '', 0, '5 Days'),
(454, 'Adobe Photoshop CS5: Photo Printing and Color', '295', '', 0, '1 Day'),
(455, 'M10337A Updating Your Microsoft SQL Server 2008 BI Skills to SQL Server 2008 R2', '1255', '', 0, '3 Days'),
(456, 'Keep Going with QuickBooks 2011', '295', '', 0, '1 Day'),
(457, 'M50414A: Microsoft Windows PowerShell v2 For Administrators', '1675', '', 0, '4 Days'),
(458, 'M50311A: Updating Your Technology Skills from Windows XP to Windows 7', '1255', '', 0, '3 Days'),
(459, 'Getting Started with Citrix XenApp 6', '2895', '', 0, '5 Days'),
(460, 'M10553A: Fundamentals of XAML and Expression Blend', '1255', '', 0, '3 Days'),
(461, 'Internet Marketing Bootcamp', '795', '', 0, '2 Days'),
(462, 'Linux Professional Certification Preparation', '2295', '', 0, '1 day'),
(463, 'Microsoft InfoPath 2010 Creating InfoPath Forms', '295', '', 0, '1 Day'),
(464, 'Certified Information Security Manager (CISM)', '0', '', 0, '5 days'),
(465, 'M10554A: Developing Rich Internet Applications Using Microsoft Silverlight 4', '2095', '', 0, '5 Days'),
(466, 'M6433A: Planning and Implementing Windows Server 2008', '2095', '', 0, '5 Days'),
(467, 'HTML5 Training for Web Developers', '995', '', 0, '2 Days'),
(468, 'Microsoft SharePoint 2010 Content Administrator', '1255', '', 0, '3 days'),
(469, 'M50558A Microsoft Project Server 2010 Technical Boot Camp', '2095', '', 0, '5 days'),
(470, 'Crystal Reports 2011 Level 1', '485', '', 0, '2 days'),
(471, 'Microsoft Excel 2010 Powerpivot', '175', '', 0, '1 day'),
(472, 'CompTIA  Healthcare IT Technician', '1295', '', 0, '3 days'),
(473, 'M10747A  Administering System Center 2012 Configuration Manager', '2095', '', 0, '5 Days'),
(474, 'Crystal Reports 2011 Level 2', '485', '', 0, '2 Days'),
(475, 'Web Design with HTML5 and CSS3 Level 1', '495', '', 0, '1 Day'),
(476, 'CompTIA Advanced Security Practitioner (CASP)', '2095', '', 0, '5 Days'),
(477, 'Client Relationship Management', '395', '', 0, '1 day'),
(478, 'Giving and Receiving Performance Feedback', '195', '', 0, '4 hours'),
(479, 'Creating a Winning Management Style', '395', '', 0, '1 day'),
(480, 'Leading in Tough Times', '395', '', 0, '1 day'),
(481, 'Sales Negotiation', '195', '', 0, '4 hours'),
(482, 'Sales Territory Management', '195', '', 0, '4 hours'),
(483, 'CompTIA Linux+ Powered by LPI', '2295', '', 0, '5 days'),
(484, 'M50373A: Configuring and Managing Microsoft System Center Essentials 2010', '1255', '', 0, '3 days'),
(485, 'M10776A: Developing Microsoft SQL Server 2012 Databases', '2095', '', 0, '5 days'),
(486, 'Microsoft Excel 2010 VBA', '175', '', 0, '1 day'),
(487, 'Microsoft Project 2010: Web App', '175', '', 0, '1 day'),
(488, 'Adobe Fireworks CS5', '795', '', 0, '2 days'),
(489, 'ITIL V3 Evaluation, Analysis & Implementation', '495', '', 0, '1 day'),
(490, 'Implementing Cisco IP Routing (ROUTE)', '2895', '', 0, '5 days'),
(491, 'M10748A: Deploying System Center 2012 Configuration Manager', '1255', '', 0, '3 days'),
(492, 'Troubleshooting and Maintaining Cisco IP Networks (TSHOOT)', '2895', '', 0, '5 days'),
(493, 'HTML5: New Features', '995', '', 0, '2 days'),
(494, 'Web Design with HTML5 and CSS3: Level 2', '495', '', 0, '1 day'),
(495, 'Implementing Cisco Switched Networks (SWITCH)', '2895', '', 0, '5 days'),
(496, 'M50547A: Microsoft SharePoint 2010 Site Collection and Site Administration', '2095', '', 0, '5 days'),
(497, 'Microsoft OneNote 2010', '175', '', 0, '1 day'),
(498, 'CompTIA Cloud Essentials', '895', '', 0, '2 days'),
(499, 'CompTIA Storage+ Powered by SNIA', '2095', '', 0, '5 days'),
(500, 'Introduction to Supply Chain Management', '895', '', 0, '2 days'),
(501, 'M10775A: Administering Microsoft SQL Server 2012 Databases', '2095', '', 0, '5 days'),
(502, 'M10774A: Querying Microsoft SQL Server 2012', '2095', '', 0, '5 days'),
(503, 'M10778A: Implementing Data Models and Reports with Microsoft SQL Server 2012', '2095', '', 0, '5 days'),
(504, 'Adobe Contribute CS4', '495', '', 0, '1 day'),
(505, 'M10777A: Implementing a Data Warehouse with Microsoft SQL Server 2012', '2095', '', 0, '5 days'),
(506, 'Adobe Premiere Pro CS 5.5: Basic Video Editing', '495', '', 0, '1 day'),
(507, 'Basho Sales Training', '395', '', 0, '1  day'),
(508, 'M50430B: Administering Team Foundation Server 2010', '1255', '', 0, '3 days'),
(509, 'M6439A: Configuring and Troubleshooting Windows Server 2008 Application Infrastructure', '2095', '', 0, '5 days'),
(510, 'Microsoft Excel 2010 Level 1 On-Line', '175', '', 0, '6 hours'),
(511, 'Microsoft Excel 2010 Level 2 On-Line', '175', '', 0, '6 hours'),
(512, 'Microsoft Excel 2010 Level 3 On-Line', '175', '', 0, '6 hours'),
(513, 'Microsoft Excel 2010 Powerpivot On-Line', '115', '', 0, '4 hours'),
(514, 'Microsoft Excel 2010 Pivot Tables On-Line', '115', '', 0, '4 hours'),
(515, 'Microsoft Access 2010 Level 1 On-Line', '175', '', 0, '6 hours'),
(516, 'Microsoft Access 2010 Level 3 On-Line', '175', '', 0, '6 hours'),
(517, 'Microsoft Word 2010 Level 1 On-Line', '175', '', 0, '6 hours'),
(518, 'Microsoft Word 2010 Level 2 On-Line', '175', '', 0, '6 hours'),
(519, 'Microsoft Outlook 2010 Level 1  On-Line', '175', '', 0, '6 hours'),
(520, 'Microsoft Outlook 2010 Level 2 On-Line', '175', '', 0, '6 hours'),
(521, 'Microsoft Access 2010 Level 2 On-Line', '175', '', 0, '6 hours'),
(522, 'M40005A: First Look Clinic: Windows Server 2012', '95', '', 0, '3 hours'),
(523, 'M40006A: Hands On Lab: Windows Server 2012', '95', '', 0, '3 hours'),
(524, 'M20411A: Administering Windows Server 2012', '2095', '', 0, '5 days'),
(525, 'M20412A: Configuring Advanced Windows Server 2012 Services', '2095', '', 0, '5 days'),
(526, 'M20410A: Installing and Configuring Windows Server 2012', '2095', '', 0, '5 days'),
(527, 'M20417A: Upgrading Your Skills to MCSA Windows Server 2012', '2095', '', 0, '5 days'),
(528, 'M20687A: Configuring Windows 8', '2095', '', 0, '5 days'),
(529, 'Business Component Development with EJB Technology (Java EE 6)', '1595', '', 0, '3 days'),
(530, 'Web Component Development with Servlets & JSPs (Java EE 6)', '2125', '', 0, '4 days'),
(531, 'Introduction to Programming Using Java SE 7', '525', '', 0, '1 day'),
(532, 'M10751AB: Beta: Configuring and Deploying a Private Cloud with System Center 2012', '2095', '', 0, '5 days'),
(533, 'M10750A: Monitoring and Operating a Private Cloud with System Center 2012', '2095', '', 0, '5 days'),
(534, 'M40008A: Updating your Database Skills to Microsoft SQL Server 2012', '1255', '', 0, '3 days'),
(535, 'M40009A: Updating your Business Intelligence Skills to Microsoft SQL Server 2012', '1255', '', 0, '3 days'),
(536, 'Implementing Cisco IOS Network Security (IINS)', '2495', '', 0, '5 days'),
(537, 'Implementing Cisco IOS Network Security (IINS v2.0)', '2495', '', 0, ''),
(538, 'Securing Networks with Cisco Routers and Switches (SECURE v1.0)', '2495', '', 0, '5 days'),
(539, 'Deploying Cisco ASA Firewall Solutions (FIREWALL v2.0)', '2495', '', 0, '5 days'),
(540, 'Implementing Cisco Unified Wireless Networking Essentials (IUWNE)', '2495', '', 0, '5 days'),
(541, 'Deploying Cisco ASA VPN Solutions (VPN v2.0)', '2495', '', 0, '5 days'),
(542, 'Implementing Cisco Intrusion Prevention System (IPS v7.0)', '2495', '', 0, '5 days'),
(543, 'Implementing Cisco Voice Communications and QoS (CVOICE)', '2495', '', 0, '5 days'),
(544, 'Implementing Cisco Unified Communications Manager, Part 1 (CIPT1)', '2495', '', 0, '5 days'),
(545, 'Implementing Cisco Unified Communications Manager, Part 2 (CIPT2)', '2495', '', 0, '5 days'),
(546, 'Troubleshooting Cisco Unified Communications (TVOICE)', '2495', '', 0, '5 days'),
(547, 'Integrating Cisco Unified Communications Applications (CAPPS)', '2495', '', 0, '5 days'),
(548, 'Microsoft Office 2013 Transition from Microsoft 2007/2010', '175', '', 0, '1 Day'),
(549, 'iPad for Business Use', '195', '', 0, '1 Day'),
(550, 'Microsoft Office 365: Web Apps for End Users', '175', '', 0, '1 Day'),
(551, 'Microsoft Windows 8 Transition from Windows 7', '175', '', 0, '1 Day'),
(552, 'Using Windows 8', '0', '', 0, '1 Day'),
(553, 'Win8 Tablet Business Productivity', '175', '', 0, '1 Day'),
(558, 'My Class', '', '', 0, ''),
(560, 'Room Rental', '', '', 750, '3');

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE IF NOT EXISTS `company` (
  `companyname` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `salesrepid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=60 ;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`companyname`, `id`, `salesrepid`) VALUES
('Rich Products', 35, 26),
('New Era Cap', 36, 26),
('Zoodle', 37, 26),
('ABC Rental', 39, 26),
('Joes Chicken Coup', 40, 27),
('Verizon', 41, 26),
('Lawns Of Boulder', 42, 26),
('Buera Veritas ', 43, 38),
('MacDonalds', 44, 38),
('XYZ Printing ', 45, 27),
('A & M Realty', 46, 27),
('A Smith Comany, Inc', 47, 26),
('Steve & Steve Law Firm, LLC', 48, 39),
('Ben & Jerrys Printing Co.', 49, 27),
('Upstate Realty', 50, 27),
('Tapesmith Inc', 51, 27),
('Offide Dept.', 52, 39),
('Franklin, LLC', 53, 27),
('CNN.com', 54, 26),
('Lactalis', 55, 26),
('Dwyers Pub', 56, 38),
('cornwall hole', 57, 38),
('Balls Head Inc.', 58, 39),
('Guns n Roses', 59, 26);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE IF NOT EXISTS `enrollment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `billingid` int(11) NOT NULL,
  `classid` int(11) NOT NULL,
  `datesid` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `checkedIn` tinyint(1) NOT NULL DEFAULT '0',
  `userCancel` tinyint(1) NOT NULL DEFAULT '0',
  `noshow` tinyint(1) NOT NULL DEFAULT '0',
  `po` varchar(25) NOT NULL,
  `cancelNotes` varchar(1000) DEFAULT NULL,
  `invoiceStatus` enum('Uninvoiced','Payment Pending','Paid') NOT NULL DEFAULT 'Uninvoiced',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=48 ;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`id`, `companyid`, `studentid`, `billingid`, `classid`, `datesid`, `status`, `checkedIn`, `userCancel`, `noshow`, `po`, `cancelNotes`, `invoiceStatus`) VALUES
(1, 54, 19, 37, 331, 7, 1, 0, 0, 1, 'PO20315', NULL, 'Uninvoiced'),
(2, 36, 2, 16, 438, 12, 1, 0, 1, 0, 'PO1200453', NULL, 'Uninvoiced'),
(3, 36, 2, 16, 444, 18, 1, 1, 0, 0, '43635745794', NULL, 'Payment Pending'),
(16, 54, 19, 37, 181, 22, 1, 1, 0, 0, '', NULL, 'Payment Pending'),
(17, 46, 9, 24, 181, 22, 1, 1, 0, 0, '', NULL, 'Payment Pending'),
(7, 47, 12, 26, 400, 19, 1, 0, 1, 0, '', NULL, 'Uninvoiced'),
(9, 43, 13, 30, 400, 19, 1, 1, 0, 0, '', NULL, 'Payment Pending'),
(10, 36, 5, 1, 400, 19, 1, 1, 0, 0, '', NULL, 'Uninvoiced'),
(11, 51, 16, 34, 400, 19, 1, 0, 0, 1, '', NULL, 'Payment Pending'),
(12, 54, 19, 37, 400, 19, 1, 1, 0, 0, '', NULL, 'Payment Pending'),
(13, 36, 6, 16, 400, 19, 1, 1, 0, 0, '', NULL, 'Uninvoiced'),
(14, 35, 11, 2, 400, 19, 1, 1, 0, 0, '', NULL, 'Uninvoiced'),
(15, 43, 14, 30, 400, 19, 1, 0, 1, 0, '', NULL, 'Uninvoiced'),
(18, 44, 10, 25, 241, 21, 1, 1, 0, 0, '', NULL, 'Payment Pending'),
(19, 47, 12, 26, 241, 21, 1, 0, 0, 1, '', NULL, 'Payment Pending'),
(20, 43, 13, 30, 13, 17, 1, 1, 0, 0, '', NULL, 'Payment Pending'),
(21, 43, 14, 30, 13, 17, 1, 0, 0, 1, '', NULL, 'Payment Pending'),
(22, 54, 19, 37, 13, 17, 1, 1, 0, 0, '', NULL, 'Payment Pending'),
(25, 54, 19, 37, 444, 18, 1, 1, 0, 0, '', NULL, 'Payment Pending'),
(26, 35, 11, 2, 13, 17, 1, 0, 0, 1, '', NULL, 'Payment Pending'),
(28, 36, 2, 16, 13, 17, 1, 0, 0, 1, '', NULL, 'Payment Pending'),
(41, 36, 6, 16, 13, 17, 1, 0, 0, 1, '', NULL, 'Payment Pending'),
(46, 49, 21, 29, 13, 17, 1, 0, 0, 1, '', NULL, 'Uninvoiced'),
(47, 36, 22, 1, 560, 26, 1, 0, 0, 0, '', NULL, 'Uninvoiced');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL DEFAULT '',
  `description` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `instructors`
--

CREATE TABLE IF NOT EXISTS `instructors` (
  `instructor_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`instructor_name`),
  KEY `instructor_name` (`instructor_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `instructors`
--

INSERT INTO `instructors` (`instructor_name`, `status`) VALUES
('Linda Marotta-Moore', 1),
('Mark', 1),
('Mark Busch', 1);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE IF NOT EXISTS `invoices` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `enrollmentIDs` varchar(1000) NOT NULL,
  `billingID` int(10) NOT NULL,
  `status` enum('Unsent','Sent','Paid') NOT NULL DEFAULT 'Unsent',
  `createdAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `invoiceSentAt` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `enrollmentIDs`, `billingID`, `status`, `createdAt`, `invoiceSentAt`) VALUES
(2, '16,22,25', 37, 'Sent', '2012-12-18 02:17:14', '12-18-2012 15:55:28'),
(3, '3,28,41', 16, 'Sent', '2012-12-18 02:18:31', '12-18-2012 13:39:51'),
(4, '26', 2, 'Sent', '2012-12-18 02:19:39', '12-18-2012 02:30:15'),
(5, '19', 26, 'Sent', '2012-12-18 02:33:57', '12-18-2012 15:56:03'),
(6, '18', 25, 'Sent', '2012-12-18 02:42:31', '12-18-2012 13:10:13'),
(8, '11', 34, 'Sent', '2012-12-18 07:12:10', '12-18-2012 02:30:19'),
(9, '12', 37, 'Sent', '2012-12-18 07:16:46', '12-18-2012 02:29:58'),
(10, '17', 24, 'Sent', '2012-12-18 07:32:40', '12-18-2012 12:52:14'),
(12, '9,20,21', 30, 'Unsent', '2012-12-18 17:14:36', NULL),
(13, '', 37, 'Unsent', '2012-12-18 18:06:43', NULL),
(14, '', 30, 'Unsent', '2012-12-18 18:06:57', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `salesperson`
--

CREATE TABLE IF NOT EXISTS `salesperson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=42 ;

--
-- Dumping data for table `salesperson`
--

INSERT INTO `salesperson` (`id`, `name`) VALUES
(27, 'Jason Cornwall'),
(26, 'Dimas Duque'),
(40, ''),
(41, ''),
(39, 'Joe Smajdor'),
(38, 'John Doe');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `companyid` int(11) NOT NULL,
  `billingid` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `middleinitial` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `ccemail` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `companyid`, `billingid`, `firstname`, `lastname`, `middleinitial`, `email`, `ccemail`) VALUES
(1, 35, 2, 'Steve', 'Balmer', 'E', 'steve@neweracap.com', ''),
(2, 36, 16, 'Jack', 'Johnson', 'E', 'jj@jj.com', ''),
(3, 37, 1, 'Sue', 'Mullen', 'Z', 'zz@zz.com', ''),
(4, 37, 0, 'Mark', 'Marten', 'm', '', ''),
(5, 36, 1, 'Jim', 'Dog', 'S', 'SS@jj.com', ''),
(6, 36, 16, 'Lee', 'Salminen', 'D', 'lee@zoodlemarketing.com', ''),
(7, 40, 19, 'Chris', 'Falzone', '', 'chri@abc.com', ''),
(8, 41, 23, 'Chris', 'Hills', 'M', 'chris.hills030@gmail.com', 'me@leesalminen.com'),
(9, 46, 24, 'Adam ', 'Hout', 'T', 'adm@am.com', 'gg@aa.com'),
(10, 44, 25, 'Cabal', 'Richam', 'F', 'Cabal@abc.com', 'Labac@cba.com'),
(11, 35, 2, 'Danni', 'Finnlee', 'P', 'danni@gmail.com', ''),
(12, 47, 26, 'Zack ', 'Bass', 'G', 'Zack@ZZ.com', 'Bass@XZ.xom'),
(13, 43, 30, 'Jennie ', 'Dream', 'F', 'Jennie@BV.com', 'Dream@BV.com'),
(14, 43, 30, 'Troy', 'O''Higgins', 'B', 'Troy@zoodle.com', 'Lee@lee.com'),
(15, 53, 31, 'Randy  ', 'Thorn', 'D', 'randy@fr.com', 'thorn@fr.com'),
(16, 51, 34, 'Tina ', 'Root', 'J', 'tina@TM.com', 'root@tm.com'),
(17, 50, 35, 'Mark', 'Anthony', 'F', 'mark@lg.com', 'anthony@lg.com'),
(18, 45, 36, 'Greg', 'Thomson', 'F', 'greg@bb.com', 'thomas@bb.com'),
(19, 54, 37, 'Brian', 'Adams', '', 'badams@cnn.com', ''),
(20, 55, 38, 'Robert', 'Bennett', '', 'Robert.Bennett@lactalis.us', ''),
(21, 49, 29, 'Brett', 'Burnsworth', 'C', 'bburnsworth@zoodlemarketing.com', 'ralanyo@hotmail.com'),
(22, 36, 1, 'Service', 'Service', '', 'tt@tt.com', ''),
(23, 36, 1, 'shaune', 'dwyer', 'p', 'shaune@campuslinc.com', 'jason@cornwall.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group_id` int(11) NOT NULL DEFAULT '100',
  `token` varchar(255) NOT NULL,
  `identifier` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `group_id`, `token`, `identifier`) VALUES
(1, 'administrator', 'test@test.com', 'f8d8cb20571630d970cafc0bf5d8fb9e8a29c628658479b147cd0769b0a44e28', 1, '', '');
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
