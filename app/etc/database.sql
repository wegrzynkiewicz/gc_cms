-- Adminer 4.2.5 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `gc_checksums`;
CREATE TABLE `gc_checksums` (
  `file` tinytext NOT NULL,
  `hash` char(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_dumps`;
CREATE TABLE `gc_dumps` (
  `dump_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `creation_datetime` datetime NOT NULL,
  `size` int(11) unsigned NOT NULL,
  `path` tinytext NOT NULL,
  PRIMARY KEY (`dump_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_forms`;
CREATE TABLE `gc_forms` (
  `form_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_form_fields`;
CREATE TABLE `gc_form_fields` (
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `name` tinytext NOT NULL,
  `help` tinytext NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_form_field_meta`;
CREATE TABLE `gc_form_field_meta` (
  `field_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` mediumtext NOT NULL,
  UNIQUE KEY `field_id_name` (`field_id`,`name`),
  CONSTRAINT `gc_form_field_meta_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `gc_form_fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_form_pos`;
CREATE TABLE `gc_form_pos` (
  `form_id` int(10) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `form_id` (`form_id`),
  KEY `field_id` (`field_id`),
  CONSTRAINT `gc_form_pos_ibfk_4` FOREIGN KEY (`form_id`) REFERENCES `gc_forms` (`form_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_form_pos_ibfk_5` FOREIGN KEY (`field_id`) REFERENCES `gc_form_fields` (`field_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_form_sent`;
CREATE TABLE `gc_form_sent` (
  `sent_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `status` varchar(32) NOT NULL,
  `sent_datetime` datetime NOT NULL,
  `name` tinytext NOT NULL,
  `data` text NOT NULL,
  `localization` text NOT NULL,
  PRIMARY KEY (`sent_id`),
  KEY `name` (`name`(16)),
  KEY `sent_datetime` (`sent_datetime`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_frames`;
CREATE TABLE `gc_frames` (
  `frame_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` varchar(32) NOT NULL,
  `theme` varchar(32) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `slug` tinytext NOT NULL,
  `image` tinytext NOT NULL,
  `keywords` text NOT NULL,
  `description` text NOT NULL,
  `creation_datetime` datetime NOT NULL,
  `modify_datetime` datetime NOT NULL,
  PRIMARY KEY (`frame_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_frame_meta`;
CREATE TABLE `gc_frame_meta` (
  `frame_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` mediumtext NOT NULL,
  UNIQUE KEY `frame_id_name` (`frame_id`,`name`),
  CONSTRAINT `gc_frame_meta_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_mail_sent`;
CREATE TABLE `gc_mail_sent` (
  `mail_hash` char(40) NOT NULL,
  `receivers` text NOT NULL,
  `subject` tinytext NOT NULL,
  `sent_datetime` datetime NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`mail_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_mail_to_send`;
CREATE TABLE `gc_mail_to_send` (
  `mail_hash` char(40) NOT NULL,
  `receivers` text NOT NULL,
  `subject` tinytext NOT NULL,
  `push_datetime` datetime NOT NULL,
  `content` mediumtext NOT NULL,
  PRIMARY KEY (`mail_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_menus`;
CREATE TABLE `gc_menus` (
  `menu_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `type` varchar(32) NOT NULL,
  `target` varchar(32) NOT NULL,
  `destination` tinytext NOT NULL,
  `frame_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`menu_id`),
  KEY `frame_id` (`frame_id`),
  CONSTRAINT `gc_menus_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_menu_taxonomies`;
CREATE TABLE `gc_menu_taxonomies` (
  `nav_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workname` varchar(32) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `name` tinytext NOT NULL,
  `maxlevels` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`nav_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_menu_tree`;
CREATE TABLE `gc_menu_tree` (
  `nav_id` int(10) unsigned NOT NULL,
  `menu_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `navigation_id` (`nav_id`),
  KEY `node_id` (`menu_id`),
  KEY `parent_id` (`parent_id`),
  KEY `position` (`position`),
  CONSTRAINT `gc_menu_tree_ibfk_1` FOREIGN KEY (`nav_id`) REFERENCES `gc_menu_taxonomies` (`nav_id`),
  CONSTRAINT `gc_menu_tree_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `gc_menu_tree` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_menu_tree_ibfk_5` FOREIGN KEY (`menu_id`) REFERENCES `gc_menus` (`menu_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_modules`;
CREATE TABLE `gc_modules` (
  `module_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `theme` varchar(32) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_module_file_meta`;
CREATE TABLE `gc_module_file_meta` (
  `file_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` mediumtext NOT NULL,
  UNIQUE KEY `file_id_name` (`file_id`,`name`),
  CONSTRAINT `gc_module_file_meta_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `gc_module_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_module_file_pos`;
CREATE TABLE `gc_module_file_pos` (
  `module_id` int(10) unsigned NOT NULL,
  `file_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `module_id` (`module_id`),
  KEY `file_id` (`file_id`),
  CONSTRAINT `gc_module_file_pos_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `gc_modules` (`module_id`) ON DELETE CASCADE,
  CONSTRAINT `gc_module_file_pos_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `gc_module_files` (`file_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_module_grid`;
CREATE TABLE `gc_module_grid` (
  `frame_id` int(10) unsigned NOT NULL,
  `module_id` int(10) unsigned NOT NULL,
  `x` int(10) unsigned NOT NULL,
  `y` int(10) unsigned NOT NULL,
  `w` int(10) unsigned NOT NULL,
  `h` int(10) unsigned NOT NULL,
  KEY `frame_id` (`frame_id`),
  KEY `module_id` (`module_id`),
  CONSTRAINT `gc_module_grid_ibfk_3` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_module_grid_ibfk_4` FOREIGN KEY (`module_id`) REFERENCES `gc_modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_module_meta`;
CREATE TABLE `gc_module_meta` (
  `module_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` mediumtext NOT NULL,
  UNIQUE KEY `module_id_name` (`module_id`,`name`),
  CONSTRAINT `gc_module_meta_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `gc_modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_module_tabs`;
CREATE TABLE `gc_module_tabs` (
  `module_id` int(10) unsigned NOT NULL,
  `frame_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `module_id` (`module_id`),
  KEY `item_id` (`frame_id`),
  CONSTRAINT `gc_module_tabs_ibfk_4` FOREIGN KEY (`module_id`) REFERENCES `gc_modules` (`module_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_module_tabs_ibfk_6` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_popups`;
CREATE TABLE `gc_popups` (
  `popup_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) NOT NULL,
  `name` tinytext NOT NULL,
  `type` varchar(32) NOT NULL,
  `display` varchar(32) NOT NULL,
  `countdown` int(10) unsigned NOT NULL,
  `show_after_datetime` datetime NOT NULL,
  `hide_after_datetime` datetime NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`popup_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_popup_display`;
CREATE TABLE `gc_popup_display` (
  `popup_id` int(10) unsigned NOT NULL,
  `frame_id` int(10) unsigned NOT NULL,
  KEY `popup_id` (`popup_id`),
  KEY `frame_id` (`frame_id`),
  CONSTRAINT `gc_popup_display_ibfk_5` FOREIGN KEY (`popup_id`) REFERENCES `gc_popups` (`popup_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_popup_display_ibfk_6` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_post_membership`;
CREATE TABLE `gc_post_membership` (
  `post_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  KEY `post_id` (`post_id`),
  KEY `node_id` (`node_id`),
  CONSTRAINT `gc_post_membership_ibfk_5` FOREIGN KEY (`node_id`) REFERENCES `gc_post_nodes` (`node_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_post_nodes`;
CREATE TABLE `gc_post_nodes` (
  `node_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `frame_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`node_id`),
  KEY `frame_id` (`frame_id`),
  CONSTRAINT `gc_post_nodes_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_post_taxonomies`;
CREATE TABLE `gc_post_taxonomies` (
  `tax_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workname` varchar(32) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_post_tree`;
CREATE TABLE `gc_post_tree` (
  `tax_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `tax_id` (`tax_id`),
  KEY `parent_id` (`parent_id`),
  KEY `node_id` (`node_id`),
  CONSTRAINT `gc_post_tree_ibfk_1` FOREIGN KEY (`tax_id`) REFERENCES `gc_post_taxonomies` (`tax_id`),
  CONSTRAINT `gc_post_tree_ibfk_3` FOREIGN KEY (`parent_id`) REFERENCES `gc_post_tree` (`node_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_post_tree_ibfk_4` FOREIGN KEY (`node_id`) REFERENCES `gc_post_nodes` (`node_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_product_membership`;
CREATE TABLE `gc_product_membership` (
  `frame_id` int(10) unsigned NOT NULL,
  `node_id` int(10) unsigned NOT NULL,
  KEY `product_id` (`frame_id`),
  KEY `node_id` (`node_id`),
  CONSTRAINT `gc_product_membership_ibfk_2` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_product_membership_ibfk_3` FOREIGN KEY (`node_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_product_taxonomies`;
CREATE TABLE `gc_product_taxonomies` (
  `tax_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workname` varchar(32) NOT NULL,
  `lang` varchar(2) NOT NULL,
  `name` tinytext NOT NULL,
  `maxlevels` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_product_tree`;
CREATE TABLE `gc_product_tree` (
  `tax_id` int(10) unsigned NOT NULL,
  `frame_id` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `tax_id` (`tax_id`),
  KEY `parent_id` (`parent_id`),
  KEY `node_id` (`frame_id`),
  CONSTRAINT `gc_product_tree_ibfk_5` FOREIGN KEY (`tax_id`) REFERENCES `gc_product_taxonomies` (`tax_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_product_tree_ibfk_7` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_product_tree_ibfk_8` FOREIGN KEY (`parent_id`) REFERENCES `gc_product_tree` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
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


DROP TABLE IF EXISTS `gc_staff_meta`;
CREATE TABLE `gc_staff_meta` (
  `staff_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` mediumtext NOT NULL,
  UNIQUE KEY `staff_id_name` (`staff_id`,`name`),
  CONSTRAINT `gc_staff_meta_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `gc_staff` (`staff_id`) ON DELETE CASCADE
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
  `widget_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `workname` varchar(32) NOT NULL,
  `name` tinytext NOT NULL,
  `lang` varchar(2) NOT NULL,
  `type` varchar(32) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`widget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- 2017-02-23 02:07:20
