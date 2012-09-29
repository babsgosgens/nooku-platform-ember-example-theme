# --------------------------------------------------------
# Diff Joomla 1.5 to alpha3

CREATE TABLE `#__versions_revisions` (
  `table` varchar(64) NOT NULL,
  `row` bigint(20) unsigned NOT NULL,
  `revision` bigint(20) unsigned NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `data` longtext NOT NULL COMMENT '@Filter("json")',
  `status` varchar(100) NOT NULL,
  PRIMARY KEY  (`table`,`row`,`revision`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# --------------------------------------------------------
# Diff alpha3 to alpha4

DROP TABLE IF EXISTS `#__files_paths`;

CREATE TABLE `#__files_containers` (
  `files_container_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `parameters` text NOT NULL,
  PRIMARY KEY (`files_container_id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `#__files_containers` (`files_container_id`, `slug`, `title`, `path`, `parameters`) VALUES
(NULL, 'files-files', 'Images', 'images', '{"thumbnails": true,"maximum_size":"10485760","allowed_extensions": ["bmp", "csv", "doc", "gif", "ico", "jpg", "jpeg", "odg", "odp", "ods", "odt", "pdf", "png", "ppt", "swf", "txt", "xcf", "xls"],"allowed_mimetypes": ["image/jpeg", "image/gif", "image/png", "image/bmp", "application/x-shockwave-flash", "application/msword", "application/excel", "application/pdf", "application/powerpoint", "text/plain", "application/x-zip"],"allowed_media_usergroup":3}');

CREATE TABLE IF NOT EXISTS `#__files_thumbnails` (
  `files_thumbnail_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `files_container_id` varchar(255) NOT NULL,
  `folder` varchar(255) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `thumbnail` text NOT NULL,
  PRIMARY KEY (`files_thumbnail_id`)
) DEFAULT CHARSET=utf8;


# --------------------------------------------------------
# com_activities schema changes

CREATE TABLE IF NOT EXISTS `#__activities_activities` (
	`activities_activity_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`application` VARCHAR(10) NOT NULL DEFAULT '',
	`type` VARCHAR(3) NOT NULL DEFAULT '',
	`package` VARCHAR(50) NOT NULL DEFAULT '',
	`name` VARCHAR(50) NOT NULL DEFAULT '',
	`action` VARCHAR(50) NOT NULL DEFAULT '',
	`row` BIGINT NOT NULL DEFAULT '0',
	`title` VARCHAR(255) NOT NULL DEFAULT '',
	`status` varchar(100) NOT NULL,
	`created_on` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
	`created_by` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY(`activities_activity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# --------------------------------------------------------

-- Remove tables
DROP TABLE `#__core_log_items`;
DROP TABLE `#__core_log_searches`;
DROP TABLE `#__messages`;
DROP TABLE `#__messages_cfg`;
DROP TABLE `#__stats_agents`;
DROP TABLE `#__migration_backlinks`;
DROP TABLE `#__templates_menu`;
DROP TABLE `#__content_rating`;
DROP TABLE `#__bannerclient`;
DROP TABLE `#__bannertrack`;

-- Remove com_poll
DELETE FROM `#__components` WHERE `option` = 'com_poll';
DROP TABLE  `#__polls`, `#__poll_data`, `#__poll_date`, `#__poll_menu`;
DELETE FROM `#__modules` WHERE `module` = 'mod_poll';

-- Make sure email and username are unique fields
ALTER TABLE  `#__users` DROP INDEX `email`, ADD UNIQUE `email` (`email`);
ALTER TABLE  `#__users` DROP INDEX `username`, ADD UNIQUE `username` (`username`);
