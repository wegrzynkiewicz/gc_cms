-- Adminer 4.3.0 MySQL dump

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


DROP TABLE IF EXISTS `gc_files`;
CREATE TABLE `gc_files` (
  `file_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `slug` tinytext NOT NULL,
  `width` smallint(6) unsigned NOT NULL,
  `height` smallint(6) unsigned NOT NULL,
  `size` int(10) unsigned NOT NULL,
  PRIMARY KEY (`file_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_file_meta`;
CREATE TABLE `gc_file_meta` (
  `file_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` mediumtext NOT NULL,
  UNIQUE KEY `file_id_name` (`file_id`,`name`),
  CONSTRAINT `gc_file_meta_ibfk_1` FOREIGN KEY (`file_id`) REFERENCES `gc_files` (`file_id`) ON DELETE CASCADE ON UPDATE CASCADE
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
  `frame_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Klucz główny rusztowania',
  `name` text NOT NULL COMMENT 'Nazwa rusztowania, może być pusta',
  `type` varchar(32) NOT NULL DEFAULT 'page' COMMENT 'Typ rusztowania, ilość typów jest zmienna',
  `theme` varchar(32) NOT NULL DEFAULT 'default' COMMENT 'Szablon rusztowania, w zależności od szablonu może załadować inny plik html wyglądu tego węzła',
  `lang` varchar(2) NOT NULL DEFAULT 'en' COMMENT 'Język rusztowania, zgodny z ISO 639-1',
  `visibility` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Flaga, która określa dla kogo jest widoczne to rusztowanie (0 - dla każdego, 1 - dla każdego pracownika, 2 - dla pracownika z odpowiednim uprawnieniem, 3 - dla nikogo)',
  `lock` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Flaga, która blokuje możliwość (0 - nic nie blokuje, 1 - usuwania, 2 - edycji, 3 -  wyświetlania pracownikowi)',
  `slug` tinytext NOT NULL COMMENT 'Adres relatywny do tego rusztowania, może być pusty',
  `image` tinytext NOT NULL COMMENT 'Adres relatywny do zdjęcia wyróżniającego',
  `title` tinytext NOT NULL COMMENT 'Tytuł, czyli treść znacznika "title", może być puste, wtedy tytuł jest pobierany z nazwy',
  `keywords` tinytext NOT NULL COMMENT 'Słowa kluczowe, czyli treść meta tagu "keywords"',
  `description` tinytext NOT NULL COMMENT 'Opis, czyli treść meta tagu "description"',
  `creation_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Data utworzenia rusztowania',
  `publication_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Data publikacji rusztowania, określa kiedy rusztowanie będzie widoczne',
  `modification_datetime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT 'Data ostatniej modyfikacji jakiejkolwiek treści rusztowania',
  PRIMARY KEY (`frame_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Przechowuje wszystkie rusztowania, czyli strony różnego typu do wyświetlenia';


DROP TABLE IF EXISTS `gc_frame_meta`;
CREATE TABLE `gc_frame_meta` (
  `frame_id` int(10) unsigned NOT NULL,
  `name` varchar(32) NOT NULL,
  `value` mediumtext NOT NULL,
  UNIQUE KEY `frame_id_name` (`frame_id`,`name`),
  CONSTRAINT `gc_frame_meta_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_frame_relations`;
CREATE TABLE `gc_frame_relations` (
  `frame_id` int(10) unsigned NOT NULL COMMENT 'Klucz obcy rusztowania, rusztowanie które posiada',
  `node_id` int(10) unsigned NOT NULL COMMENT 'Klucz obcy rusztowania, rusztowanie które jest posiadane',
  KEY `frame_id` (`frame_id`),
  KEY `node_id` (`node_id`),
  CONSTRAINT `gc_frame_relations_ibfk_4` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_frame_relations_ibfk_5` FOREIGN KEY (`node_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Przechowuje przynależność rusztowania do innego rusztowania';


DROP TABLE IF EXISTS `gc_frame_tree`;
CREATE TABLE `gc_frame_tree` (
  `taxonomy_id` int(10) unsigned NOT NULL COMMENT 'Klucz obcy rusztowania, taksonomia to podział rusztowań na jakieś konkretne grupy. Przykładem taksonomii może być "Kategoria produktu"',
  `frame_id` int(10) unsigned NOT NULL COMMENT 'Klucz obcy rusztowania, jest to rusztowanie, które przynależy do jakiejś taksonomii i tworzy grupę pewnych rusztowań. Przykładem może być "Komputery" jako "Kategoria produktu"',
  `parent_id` int(10) unsigned DEFAULT NULL COMMENT 'Klucz obcy rusztowania, określa węzeł nadrzędny w hierarchii drzewiastej. Na przykład "Procesory" należą do węzła "Komputery" w "Kategorii produktu"',
  `position` int(10) unsigned NOT NULL COMMENT 'Pozycja względem innych węzłów w tej samej taksonomii i w tym samym węźle nadrzędnym',
  UNIQUE KEY `taxonomy_id_frame_id_position` (`taxonomy_id`,`frame_id`,`position`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Przechowuje przynależność rusztowań do taksonomii oraz węzłów nadrzędnych';


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


DROP TABLE IF EXISTS `gc_modules`;
CREATE TABLE `gc_modules` (
  `module_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(32) NOT NULL,
  `theme` varchar(32) NOT NULL,
  `content` longtext NOT NULL,
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `gc_module_file_relations`;
CREATE TABLE `gc_module_file_relations` (
  `module_id` int(10) unsigned NOT NULL,
  `file_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  KEY `module_id` (`module_id`),
  KEY `file_id` (`file_id`),
  CONSTRAINT `gc_module_file_relations_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `gc_modules` (`module_id`) ON DELETE CASCADE,
  CONSTRAINT `gc_module_file_relations_ibfk_2` FOREIGN KEY (`file_id`) REFERENCES `gc_files` (`file_id`) ON DELETE CASCADE
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


DROP TABLE IF EXISTS `gc_module_rows`;
CREATE TABLE `gc_module_rows` (
  `frame_id` int(10) unsigned NOT NULL,
  `position` int(10) unsigned NOT NULL,
  `gutter` smallint(5) unsigned NOT NULL DEFAULT '30',
  `type` varchar(32) NOT NULL DEFAULT 'wrap',
  `bg_color` varchar(24) NOT NULL DEFAULT '',
  `bg_image` tinytext NOT NULL,
  PRIMARY KEY (`frame_id`,`position`),
  CONSTRAINT `gc_module_rows_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE
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


DROP TABLE IF EXISTS `gc_navigations`;
CREATE TABLE `gc_navigations` (
  `navigation_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Klucz główny',
  `workname` varchar(32) NOT NULL DEFAULT '' COMMENT 'Nazwa wykorzystywana przez szablon do pobrania tej nawigacji',
  `lang` varchar(2) NOT NULL DEFAULT 'en' COMMENT 'Język nawigacji, zgodny z ISO 639-1',
  `name` tinytext NOT NULL COMMENT 'Nazwa nawigacji',
  `maxlevels` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT 'Maksymalny poziom głębokości nawigacji',
  PRIMARY KEY (`navigation_id`),
  KEY `workname_lang` (`workname`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Przechowuje nawigacje';


DROP TABLE IF EXISTS `gc_navigation_nodes`;
CREATE TABLE `gc_navigation_nodes` (
  `node_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Klucz główny węzła',
  `name` tinytext NOT NULL COMMENT 'Wyświetlana nazwa węzła, może być pusta jeżeli jest ustawiony frame_id, wtedy nazwa jest pobierana z tabelki frames',
  `type` varchar(32) NOT NULL DEFAULT 'empty' COMMENT 'Typ węzła określa jego zachowanie (empty | homepage | external | frame)',
  `theme` varchar(32) NOT NULL DEFAULT 'default' COMMENT 'Wyróżnienie węzła (szablon), w zależności od szablonu może załadować inny plik html wyglądu tego węzła',
  `target` varchar(32) NOT NULL DEFAULT '_self' COMMENT 'Atrybut "target" znaczka "a"',
  `frame_id` int(10) unsigned DEFAULT NULL COMMENT 'Klucz obcy rusztowania, na które kieruje węzeł',
  `destination` tinytext NOT NULL COMMENT 'Adres na który kieruje węzeł, jeżeli jego typ to external',
  PRIMARY KEY (`node_id`),
  KEY `frame_id` (`frame_id`),
  CONSTRAINT `gc_navigation_nodes_ibfk_1` FOREIGN KEY (`frame_id`) REFERENCES `gc_frames` (`frame_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Przechowuje węzły nawigacji, czyli jej elementy menu';


DROP TABLE IF EXISTS `gc_navigation_tree`;
CREATE TABLE `gc_navigation_tree` (
  `navigation_id` int(10) unsigned NOT NULL COMMENT 'Klucz obcy nawigacji, określa do jakiej nawigacji przynależy węzeł',
  `node_id` int(10) unsigned NOT NULL COMMENT 'Klucz obcy węzła nawigacji',
  `parent_id` int(10) unsigned DEFAULT NULL COMMENT 'Klucz obcy węzła nawigacji, określa węzeł nadrzędny w hierarchii drzewiastej',
  `position` int(10) unsigned NOT NULL COMMENT 'Pozycja względem innych węzłów w tej samej nawigacji i w tym samym węźle nadrzędnym',
  KEY `navigation_id` (`navigation_id`),
  KEY `node_id` (`node_id`),
  KEY `parent_id` (`parent_id`),
  KEY `position` (`position`),
  CONSTRAINT `gc_navigation_tree_ibfk_4` FOREIGN KEY (`parent_id`) REFERENCES `gc_navigation_tree` (`node_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_navigation_tree_ibfk_5` FOREIGN KEY (`node_id`) REFERENCES `gc_navigation_nodes` (`node_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `gc_navigation_tree_ibfk_6` FOREIGN KEY (`navigation_id`) REFERENCES `gc_navigations` (`navigation_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Przechowuje przynależność węzłów do nawigacji oraz węzłów nadrzędnych';


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


-- 2017-03-23 21:02:14
