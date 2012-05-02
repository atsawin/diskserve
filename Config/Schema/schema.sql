

DROP TABLE IF EXISTS `diskless`.`alternatives`;
DROP TABLE IF EXISTS `diskless`.`clusters`;
DROP TABLE IF EXISTS `diskless`.`computers`;
DROP TABLE IF EXISTS `diskless`.`settings`;
DROP TABLE IF EXISTS `diskless`.`users`;


CREATE TABLE `diskless`.`alternatives` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`mode` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'C-Chain, S-SAN boot',
	`image` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`loop_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`cluster_id` int(10) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `cluster_id` (`cluster_id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `diskless`.`clusters` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`loop_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cow_size` int(11) NOT NULL,
	`extra_disk` int(11) NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `diskless`.`computers` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`ip_address` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`mac_address` varchar(17) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`loop_name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`cluster_id` int(10) NOT NULL,
	`mode` varchar(1) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT 'A-Alternate, P-Persistent, T-Transient',
	`alternative_id` int(10) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`),
	KEY `cluster_id` (`cluster_id`),
	KEY `alternative_id` (`alternative_id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `diskless`.`settings` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`value` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`description` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

CREATE TABLE `diskless`.`users` (
	`id` int(10) NOT NULL AUTO_INCREMENT,
	`username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`password` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
	`group_id` int(10) DEFAULT NULL,
	`created` datetime DEFAULT NULL,
	`modified` datetime DEFAULT NULL,	PRIMARY KEY  (`id`)) 	DEFAULT CHARSET=utf8,
	COLLATE=utf8_general_ci,
	ENGINE=InnoDB;

