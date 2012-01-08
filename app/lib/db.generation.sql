-- phpMyAdmin SQL Dump
-- version 2.8.2.4
-- http://www.phpmyadmin.net
-- 
-- Host: localhost:3306
-- Generation Time: Jan 08, 2012 at 01:36 AM
-- Server version: 5.0.32
-- PHP Version: 5.2.6
-- 
-- Database: `footprint_live`
-- 
CREATE DATABASE `footprint_live` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `footprint_live`;

-- --------------------------------------------------------

-- 
-- Table structure for table `app_accounts`
-- 

CREATE TABLE `app_accounts` (
  `accID` int(10) unsigned NOT NULL auto_increment,
  `organisation` varchar(45) NOT NULL,
  `prefix` varchar(45) NOT NULL,
  `timezone` int(10) unsigned NOT NULL default '14',
  `logo` blob NOT NULL,
  `logoMIMEName` varchar(45) NOT NULL,
  `logoMIMEType` varchar(45) NOT NULL,
  `api` tinyint(3) unsigned NOT NULL,
  `accDiskSpace` float NOT NULL,
  `accStaff` int(10) unsigned NOT NULL,
  `accProjects` int(10) unsigned NOT NULL,
  `addCountry` varchar(45) NOT NULL,
  `addStreet` varchar(90) NOT NULL,
  `addCity` varchar(45) NOT NULL,
  `addState` varchar(45) NOT NULL,
  `addZipCode` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `ccType` varchar(12) NOT NULL,
  `ccName` varchar(45) NOT NULL,
  `ccExp` int(10) unsigned NOT NULL,
  `ccNumber` varchar(16) NOT NULL,
  `dateCreated` int(10) unsigned NOT NULL,
  `packageTitle` varchar(45) NOT NULL default 'Bronze',
  `cssZoneA` varchar(7) NOT NULL default '#003366',
  `cssZoneB` varchar(7) NOT NULL default '#4b75b3',
  `cssZoneC` varchar(7) NOT NULL default '#ecf5ff',
  `cssZoneD` varchar(7) NOT NULL default '#4b75b3',
  `cssScheme` int(10) unsigned NOT NULL default '1',
  `rssKey` varchar(45) NOT NULL,
  `ownerID` int(10) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`accID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1048 ;

-- 
-- Table structure for table `app_comments`
-- 

CREATE TABLE `app_comments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `parentID` int(10) unsigned NOT NULL,
  `parentType` varchar(45) NOT NULL,
  `comment` longtext NOT NULL,
  `dateCreated` int(10) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=306 ;

-- 
-- Table structure for table `app_documentVersions`
-- 

CREATE TABLE `app_documentVersions` (
  `versionID` int(10) unsigned NOT NULL auto_increment,
  `docID` int(10) unsigned NOT NULL,
  `revisionDate` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `size` float NOT NULL,
  `author` int(10) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`versionID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5152 ;

-- 
-- Table structure for table `app_documents`
-- 

CREATE TABLE `app_documents` (
  `docID` int(10) unsigned NOT NULL auto_increment,
  `taskID` int(10) unsigned NOT NULL,
  `title` varchar(90) NOT NULL,
  `docType` varchar(12) NOT NULL,
  `mime` varchar(45) NOT NULL,
  `lastAccessed` int(10) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `clientAccess` tinyint(3) unsigned NOT NULL default '0',
  PRIMARY KEY  USING BTREE (`docID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=114 ;

-- 
-- Table structure for table `app_emails`
-- 

CREATE TABLE `app_emails` (
  `emailID` int(10) unsigned NOT NULL auto_increment,
  `accID` int(10) unsigned NOT NULL,
  `content` longtext NOT NULL,
  `dateCreated` int(10) unsigned default NULL,
  `sendStatus` int(10) unsigned NOT NULL,
  `subject` text NOT NULL,
  `sentTo` text NOT NULL,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY  USING BTREE (`emailID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=267 ;

-- 
-- Table structure for table `app_feedback`
-- 

CREATE TABLE `app_feedback` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `userID` int(10) unsigned NOT NULL,
  `subject` varchar(90) NOT NULL,
  `comment` text NOT NULL,
  `referrer` varchar(254) NOT NULL,
  `createdOn` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 PACK_KEYS=1 AUTO_INCREMENT=2779 ;

-- 
-- Table structure for table `app_groupPerms`
-- 

CREATE TABLE `app_groupPerms` (
  `groupID` int(10) unsigned NOT NULL,
  `permID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`groupID`,`permID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Dumping data for table `app_groupPerms`
-- 

INSERT INTO `app_groupPerms` (`groupID`, `permID`) VALUES (1, 25),
(1, 28),
(1, 31),
(1, 33),
(1, 35),
(1, 36),
(1, 37),
(1, 39),
(1, 40),
(1, 41),
(1, 42),
(1, 43),
(1, 44),
(1, 45),
(1, 46),
(1, 47),
(1, 48),
(2, 35),
(2, 40),
(2, 41),
(2, 47),
(2, 48),
(3, 38);

-- --------------------------------------------------------

-- 
-- Table structure for table `app_groups`
-- 

CREATE TABLE `app_groups` (
  `groupID` int(10) unsigned NOT NULL auto_increment,
  `groupName` varchar(45) NOT NULL,
  `groupComment` text NOT NULL,
  PRIMARY KEY  USING BTREE (`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Dumping data for table `app_groups`
-- 

INSERT INTO `app_groups` (`groupID`, `groupName`, `groupComment`) VALUES (1, 'Designer', 'Main paying customers of Footprint.'),
(2, 'Staff', 'Staff or outsourced help that work for the designer.'),
(3, 'Client', 'These users are given accounts by the designer when their account is created.'),
(4, 'Admin', 'Used by system developers so they have access to the entire application.');

-- --------------------------------------------------------

-- 
-- Table structure for table `app_history`
-- 

CREATE TABLE `app_history` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `action` varchar(45) NOT NULL,
  `accID` varchar(45) NOT NULL,
  `clientID` int(10) unsigned NOT NULL default '0',
  `eventDate` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `adminOnly` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=2236 ;

-- 
-- Table structure for table `app_openIDs`
-- 

CREATE TABLE `app_openIDs` (
  `openid_url` varchar(255) NOT NULL,
  `accID` int(10) unsigned NOT NULL,
  `userID` int(11) NOT NULL,
  PRIMARY KEY  USING BTREE (`openid_url`,`accID`,`userID`),
  KEY `userID` (`userID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- 
-- Table structure for table `app_payments`
-- 

CREATE TABLE `app_payments` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `accID` int(10) unsigned NOT NULL,
  `amount` float NOT NULL,
  `dateReceived` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- 
-- Table structure for table `app_permissions`
-- 

CREATE TABLE `app_permissions` (
  `permID` int(10) unsigned NOT NULL auto_increment,
  `permission` varchar(45) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY  USING BTREE (`permID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

-- 
-- Dumping data for table `app_permissions`
-- 

INSERT INTO `app_permissions` (`permID`, `permission`, `description`) VALUES (25, 'staff', 'View and Manage the List of Staff Members'),
(28, 'all_objects', 'View All Clients/Projects/Tasks/Documents/Screenshots'),
(31, 'manage_clients', 'Create New Clients, Import Clients and Edit Existing Clients'),
(33, 'manage_account', 'Manage Account Information including Credit Card Info and Company Data'),
(35, 'assigned_objects', 'View Only Clients/Projects Assigned to User'),
(36, 'create_projects', 'Allow User to Create a New Project'),
(37, 'delete_projects', 'Allow User to Delete an Existing Project'),
(38, 'make_requests', 'Allow User to Make Task Requests'),
(39, 'manage_requests', 'Allow User to Accept or Delete a Request'),
(40, 'create_tasks', 'Allow User to Create a New Task'),
(41, 'manage_tasks', 'Allow User to Edit and Delete existing Tasks'),
(42, 'manage_colours_logos', 'Allow the User to Select Custom Colours and Logos for their FootPrint Account'),
(43, 'manage_import_export', 'Allow the User to Import and Export Data into their FootPrint Account'),
(44, 'manage_api', 'Allow the User to Enable or Disable their Account''s API Feature'),
(45, 'activity_feed', 'Allow user to view page containing the link to the full account activity RSS feed'),
(46, 'manage_projects', 'Allow User to Edit Existing Projects'),
(47, 'manage_doc_access', 'If enabled, the user can manage what type of access the client has to a document'),
(48, 'manage_img_access', 'If enabled, the user can manage what type of access the client has to a screenshot');

-- --------------------------------------------------------

-- 
-- Table structure for table `app_projects`
-- 

CREATE TABLE `app_projects` (
  `projID` int(10) unsigned NOT NULL auto_increment,
  `accID` int(10) unsigned NOT NULL,
  `clientID` int(10) unsigned NOT NULL,
  `assignedTo` int(10) unsigned NOT NULL,
  `dateCreated` int(10) unsigned NOT NULL,
  `name` varchar(45) character set latin1 collate latin1_bin NOT NULL default '',
  `description` text NOT NULL,
  `visibility` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`projID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=96 ;

-- 
-- Table structure for table `app_schemes`
-- 

CREATE TABLE `app_schemes` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(45) NOT NULL,
  `cssZoneA` varchar(7) NOT NULL,
  `cssZoneB` varchar(7) NOT NULL,
  `cssZoneC` varchar(7) NOT NULL,
  `cssZoneD` varchar(7) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

-- 
-- Dumping data for table `app_schemes`
-- 

INSERT INTO `app_schemes` (`id`, `name`, `cssZoneA`, `cssZoneB`, `cssZoneC`, `cssZoneD`) VALUES (1, 'Default', '#003366', '#4b75b3', '#ecf5ff', '#4b75b3'),
(2, 'Black and White', '#333333', '#797979', '#f5f5f5', '#a1a1a1'),
(3, 'Red', '#da0118', '#ff3b46', '#fff1ff', '#ff3b46'),
(4, 'Brown', '#663300', '#b3894b', '#fff6ec', '#b3894b'),
(5, 'Green', '#1e6600', '#60b34b', '#f1ffec', '#60b34b'),
(6, 'Purple', '#660062', '#b34ba5', '#ffecfe', '#b34ba5');

-- --------------------------------------------------------

-- 
-- Table structure for table `app_screenshotVersions`
-- 

CREATE TABLE `app_screenshotVersions` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `screenshotID` int(10) unsigned NOT NULL,
  `size` float NOT NULL,
  `dimensions` varchar(45) NOT NULL,
  `dateCreated` int(10) unsigned NOT NULL,
  `version` int(10) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=8092 ;

-- 
-- Table structure for table `app_screenshots`
-- 

CREATE TABLE `app_screenshots` (
  `screenshotID` int(10) unsigned NOT NULL auto_increment,
  `taskID` int(10) unsigned NOT NULL,
  `title` varchar(45) NOT NULL,
  `docType` varchar(45) NOT NULL,
  `mime` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `dateCreated` int(10) unsigned NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `clientAccess` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY  USING BTREE (`screenshotID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- 
-- Table structure for table `app_staffProjects`
-- 

CREATE TABLE `app_staffProjects` (
  `staffID` int(10) unsigned NOT NULL,
  `projectID` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`staffID`,`projectID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Table structure for table `app_tasks`
-- 

CREATE TABLE `app_tasks` (
  `taskID` int(10) unsigned NOT NULL auto_increment,
  `projID` int(10) unsigned NOT NULL,
  `title` varchar(90) NOT NULL,
  `description` text NOT NULL,
  `assignedTo` int(10) unsigned NOT NULL,
  `status` varchar(45) NOT NULL,
  `createdBy` int(10) unsigned NOT NULL,
  `type` varchar(12) NOT NULL,
  `createdOn` int(10) unsigned NOT NULL,
  `replyNote` text NOT NULL,
  PRIMARY KEY  USING BTREE (`taskID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=182 ;

-- 
-- Table structure for table `app_timezones`
-- 

CREATE TABLE `app_timezones` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `code` varchar(45) NOT NULL,
  `text` varchar(90) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=74 ;

-- 
-- Dumping data for table `app_timezones`
-- 

INSERT INTO `app_timezones` (`id`, `code`, `text`) VALUES (1, '', '(GMT-12:00) International Date Line West'),
(2, 'Pacific/Apia', '(GMT-11:00) Midway Island Samoa'),
(3, 'Pacific/Honolulu', '(GMT-10:00) Hawaii'),
(4, 'America/Anchorage', '(GMT-09:00) Alaska'),
(5, 'America/Los_Angeles', '(GMT-08:00) Pacific Time (US & Canada); Tijuana'),
(6, 'America/Denver', '(GMT-07:00) Arizona'),
(7, 'America/Denver', '(GMT-07:00) Chihuahua, La Paz, Mazatlan'),
(8, 'America/Denver', '(GMT-07:00) Mountain Time (US & Canada)'),
(9, 'America/Chicago', '(GMT-06:00) Central America'),
(10, 'America/Chicago', '(GMT-06:00) Central Time (US & Canada)'),
(11, 'America/Chicago', '(GMT-06:00) Guadalajara, Mexico City, Monterrey'),
(12, 'America/Chicago', '(GMT-06:00) Saskatchewan'),
(13, 'America/New_York', '(GMT-05:00) Bogota, Lime, Quito'),
(14, 'America/New_York', '(GMT-05:00) Eastern Time (US & Canada)'),
(15, 'America/Halifax', '(GMT-04:00) Atlantic Time (Canada)'),
(16, 'America/Halifax', '(GMT-04:00) Caracas, La Paz'),
(17, 'America/Halifax', '(GMT-04:00) Santiago'),
(18, '', '(GMT-03:30) Newfoundland'),
(19, 'America/Sao_Paulo', '(GMT-03:00) Brasilia'),
(20, 'America/Sao_Paulo', '(GMT-03:00) Buenos Aires, Georgetown'),
(21, 'America/Sao_Paulo', '(GMT-03:00) Greenland'),
(22, '', '(GMT-02:00) Mid-Atlantic'),
(23, 'Atlantic/Azores', '(GMT-01:00) Azores'),
(24, 'Atlantic/Azores', '(GMT-01:00) Cape Verde Is.'),
(25, 'Europe/London', '(GMT) Casablanca, Monrovia'),
(26, 'Europe/London', '(GMT) Greenwich Mean Time : Dublin, Edinburgh, Lisbon, London'),
(27, 'Europe/Paris', '(GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna'),
(28, 'Europe/Paris', '(GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague'),
(29, 'Europe/Paris', '(GMT+01:00) Brussels, Copenhagen, Madrid, Paris'),
(30, 'Europe/Paris', '(GMT+01:00) Sarajevo, Skopje, Warsaw, Zagreb'),
(31, 'Europe/Paris', '(GMT+01:00) West Central Africa'),
(32, 'Europe/Helsinki', '(GMT+02:00) Athens, Istanbul, Minsk'),
(33, 'Europe/Helsinki', '(GMT+02:00) Bucharest'),
(34, 'Europe/Helsinki', '(GMT+02:00) Cairo'),
(35, 'Europe/Helsinki', '(GMT+02:00) Harare, Pretoria'),
(36, 'Europe/Helsinki', '(GMT+02:00) Helsinki, Kyiv, Riga, Sofia, Tallinn, Vilnius'),
(37, 'Europe/Helsinki', '(GMT+02:00) Jerusalem'),
(38, 'Europe/Moscow', '(GMT+03:00) Baghdad'),
(39, 'Europe/Moscow', '(GMT+03:00) Kuwait, Riyadh'),
(40, 'Europe/Moscow', '(GMT+03:00) Moscow, St. Petersburg, Volgograd'),
(41, 'Europe/Moscow', '(GMT+03:00) Nairobi'),
(42, '', '(GMT+03:30) Tehran'),
(43, 'Asia/Dubai', '(GMT+04:00) Abu Dhabi, Muscat'),
(44, 'Asia/Dubai', '(GMT+04:00) Baku, Tbilisi, Yerevan'),
(45, '', '(GMT+04:30) Kabul'),
(46, 'Asia/Karachi', '(GMT+05:00) Ekaterinburg'),
(47, 'Asia/Karachi', '(GMT+05:00) Islamabad, Karachi, Tashkent'),
(48, '', '(GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi'),
(49, '', '(GMT+05:45) Kathmandu'),
(50, '', '(GMT+06:00) Almaty, Novosibirsk'),
(51, '', '(GMT+06:00) Sri Jayawardenepura'),
(52, '', '(GMT+06:30) Rangoon'),
(53, 'Asia/Krasnoyarsk', '(GMT+07:00) Bangkok, Hanoi, Jakarta'),
(54, 'Asia/Krasnoyarsk', '(GMT+07:00) Krasnoyarsk'),
(55, '', '(GMT+08:00) Beijing, Chongging, Hong Kong, Urumgi'),
(56, '', '(GMT+08:00) Irkutsk, Ulaan Bataar'),
(57, '', '(GMT+08:00) Kuala Lumpur, Singapore'),
(58, '', '(GMT+08:00) Perth'),
(59, '', '(GMT+08:00) Taipei'),
(60, 'Asia/Tokyo', '(GMT+09:00) Osaka, Sapporo, Tokyo'),
(61, 'Asia/Tokyo', '(GMT+09:00) Seoul'),
(62, 'Asia/Tokyo', '(GMT+09:00) Yakutsk'),
(63, '', '(GMT+09:30) Adelaide'),
(64, '', '(GMT+09:30) Darwin'),
(65, 'Australia/Melbourne', '(GMT+10:00) Brisbane'),
(66, 'Australia/Melbourne', '(GMT+10:00) Canberra, Melbourne, Sydney'),
(67, 'Australia/Melbourne', '(GMT+10:00) Guam, Port Moresby'),
(68, 'Australia/Melbourne', '(GMT+10:00) Hobart'),
(69, 'Australia/Melbourne', '(GMT+10:00) Vladivostok'),
(70, '', '(GMT+11:00) Magadan, Solomon Is., New Caledonia'),
(71, 'Pacific/Auckland', '(GMT+12:00) Auckland, Wellington'),
(72, 'Pacific/Auckland', '(GMT+12:00) Fiji, Kamchatka, Marshall Is.'),
(73, '', '(GMT+13:00) Nuku''alofa');

-- --------------------------------------------------------

-- 
-- Table structure for table `app_upgrades`
-- 

CREATE TABLE `app_upgrades` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `accID` int(10) unsigned NOT NULL,
  `dateUpgraded` int(10) unsigned NOT NULL,
  `newCharge` float NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Table structure for table `app_userGroups`
-- 

CREATE TABLE `app_userGroups` (
  `userID` int(10) unsigned NOT NULL default '0',
  `groupID` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  USING BTREE (`userID`,`groupID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- 
-- Table structure for table `app_users`
-- 

CREATE TABLE `app_users` (
  `userID` int(10) unsigned NOT NULL auto_increment,
  `accID` int(10) unsigned NOT NULL,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `createdOn` int(10) unsigned NOT NULL,
  `totLogins` int(10) unsigned NOT NULL default '0',
  `lastLogin` int(10) unsigned default NULL,
  `invited` tinyint(3) unsigned NOT NULL,
  `staffDefaultProjectAccess` tinyint(3) unsigned NOT NULL,
  `clientOrganisation` varchar(45) NOT NULL,
  PRIMARY KEY  USING BTREE (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1243 ;

