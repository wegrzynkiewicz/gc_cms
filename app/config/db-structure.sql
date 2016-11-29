-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `gc_frames`;
CREATE TABLE `gc_frames` (
  `frame_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `lang` varchar(2) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `image` tinytext NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `settings` text NOT NULL,
  PRIMARY KEY (`frame_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_frame_modules`;
CREATE TABLE `gc_frame_modules` (
  `module_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `theme` varchar(32) NOT NULL,
  `content` longtext NOT NULL,
  `settings` mediumtext NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_frame_positions`;
CREATE TABLE `gc_frame_positions` (
  `frame_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `grid` tinytext NOT NULL,
  KEY `frame_id` (`frame_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `gc_frame_positions_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE,
  CONSTRAINT `gc_frame_positions_ibfk_2` FOREIGN KEY (`module_id`) REFERENCES `gc_frame_modules` (`module_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_galleries`;
CREATE TABLE `gc_galleries` (
  `gallery_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `lang` varchar(2) NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_gallery_images`;
CREATE TABLE `gc_gallery_images` (
  `image_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `file` tinytext NOT NULL,
  PRIMARY KEY (`image_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_gallery_positions`;
CREATE TABLE `gc_gallery_positions` (
  `gallery_id` int(10) unsigned NOT NULL,
  `image_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `image_id` (`image_id`),
  KEY `gallery_id` (`gallery_id`),
  CONSTRAINT `gc_gallery_positions_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `gc_gallery_images` (`image_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_gallery_positions_ibfk_4` FOREIGN KEY (`gallery_id`) REFERENCES `gc_galleries` (`gallery_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_navs`;
CREATE TABLE `gc_navs` (
  `nav_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workname` varchar(32) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_nav_menus`;
CREATE TABLE `gc_nav_menus` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `type` varchar(32) NOT NULL,
  `target` varchar(32) NOT NULL,
  `destination` tinytext NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_nav_positions`;
CREATE TABLE `gc_nav_positions` (
  `nav_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `navigation_id` (`nav_id`),
  KEY `node_id` (`menu_id`),
  KEY `parent_id` (`parent_id`),
  KEY `position` (`position`),
  CONSTRAINT `gc_nav_positions_ibfk_1` FOREIGN KEY (`nav_id`) REFERENCES `gc_navs` (`nav_id`),
  CONSTRAINT `gc_nav_positions_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `gc_nav_positions` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_nav_positions_ibfk_5` FOREIGN KEY (`menu_id`) REFERENCES `gc_nav_menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_pages`;
CREATE TABLE `gc_pages` (
  `page_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `frame_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`page_id`),
  KEY `frame_id` (`frame_id`),
  CONSTRAINT `gc_pages_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_staff`;
CREATE TABLE `gc_staff` (
  `staff_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `lang` varchar(2) NOT NULL,
  `root` tinyint(3) unsigned NOT NULL,
  `force_change_password` tinyint(3) unsigned NOT NULL,
  `avatar` tinytext NOT NULL,
  `settings` text NOT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_staff_groups`;
CREATE TABLE `gc_staff_groups` (
  `group_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_staff_membership`;
CREATE TABLE `gc_staff_membership` (
  `staff_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  KEY `staff_id` (`staff_id`),
  KEY `group_id` (`group_id`),
  CONSTRAINT `gc_staff_membership_ibfk_3` FOREIGN KEY (`staff_id`) REFERENCES `gc_staff` (`staff_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_staff_membership_ibfk_4` FOREIGN KEY (`group_id`) REFERENCES `gc_staff_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_staff_permissions`;
CREATE TABLE `gc_staff_permissions` (
  `group_id` int(10) unsigned NOT NULL,
  `name` tinytext NOT NULL,
  KEY `group_id` (`group_id`),
  CONSTRAINT `gc_staff_permissions_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `gc_staff_groups` (`group_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_widgets`;
CREATE TABLE `gc_widgets` (
  `workname` varchar(32) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `name` tinytext NOT NULL,
  `type` varchar(32) NOT NULL,
  `content` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2016-11-29 17:29:20
